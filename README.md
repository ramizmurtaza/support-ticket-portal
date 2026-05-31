# support-ticket-portal

Central admin portal and REST API for the support ticket system. All client apps send tickets here via API. Admins manage tickets, reply, and track status through the web UI.

---

## Requirements

- PHP 8.2+
- Composer
- MySQL
- Node.js + npm
- S3-compatible bucket (AWS S3, MinIO, etc.)

---

## Setup

### 1. Scaffold Laravel

The repo contains only the app-specific files. You need to pull in the Laravel framework first.

```bash
cd /Users/ramizmurtaza/development/support

composer create-project laravel/laravel _temp-portal

rsync -av --ignore-existing _temp-portal/ support-ticket-portal/

rm -rf _temp-portal
```

> `rsync --ignore-existing` copies all Laravel scaffold files but skips anything already in the folder (our controllers, models, views, routes, etc.).

### 2. Install dependencies

```bash
cd support-ticket-portal

composer install
```

### 3. Install Breeze (auth)

```bash
composer require laravel/breeze --dev

php artisan breeze:install blade
```

Choose defaults when prompted.

### 4. Install API support

```bash
php artisan install:api
```

> If it asks to overwrite `routes/api.php`, choose **No** — ours already has all routes.

### 5. Configure environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`:

```env
APP_NAME="Support Portal"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=support_portal
DB_USERNAME=root
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_FROM_ADDRESS="support@yourapp.com"
MAIL_FROM_NAME="Support Portal"

AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=your_bucket

ADMIN_EMAIL=admin@yourdomain.com
ADMIN_PASSWORD=changeme123
```

### 6. Create the database

```bash
mysql -u root -p -e "CREATE DATABASE support_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 7. Run migrations and seed

```bash
php artisan migrate --seed
```

Seeds:
- Admin user using `ADMIN_EMAIL` / `ADMIN_PASSWORD` from `.env`
- **Evexia HIS** system (`system_id: evexia`)
- **Jenan Portal** system (`system_id: jenan`)

### 8. Build frontend assets

```bash
npm install && npm run build
```

### 9. Create storage symlink

```bash
php artisan storage:link
```

### 10. Start the server

```bash
php artisan serve
```

Portal: **http://localhost:8000**
Login: **http://localhost:8000/login**

---

## Getting API keys

After logging in:

1. Go to **Systems** in the sidebar
2. Click **Regen Key** next to a system
3. Copy the key immediately — it is shown only once

These keys go into your client apps' `.env` as `SUPPORT_API_KEY`.

---

## Admin Panel Routes

| URL | Page |
|---|---|
| `/admin` | Dashboard |
| `/admin/tickets` | All tickets with filters |
| `/admin/tickets/{id}` | Ticket detail, reply, update status |
| `/admin/systems` | System management |
| `/admin/systems/create` | Register a new system |

---

## API Routes

All API routes require these headers:

```
X-Api-Key: <system api key>
X-System-Id: <system_id>
Accept: application/json
```

| Method | URL | Description |
|---|---|---|
| `POST` | `/api/tickets` | Create a ticket |
| `GET` | `/api/tickets?email=` | List tickets for an email |
| `GET` | `/api/tickets/{id}` | Get full ticket with comments |
| `POST` | `/api/tickets/{id}/comments` | Add a comment |
| `POST` | `/api/upload` | Upload a file to S3 |

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # DashboardController, TicketAdminController,
│   │   │                   # CommentAdminController, SystemAdminController
│   │   └── Api/            # TicketApiController, CommentApiController,
│   │                       # AttachmentApiController
│   └── Middleware/
│       └── ValidateSystemApiKey.php
├── Models/
│   ├── System.php
│   ├── Ticket.php          # auto-generates reference_no on created event
│   ├── TicketComment.php
│   └── TicketAttachment.php
└── Notifications/          # 4 mail notifications (synchronous, no queue)
    ├── TicketCreatedNotification.php
    ├── StatusChangedNotification.php
    ├── NewAdminReplyNotification.php
    └── NewClientCommentNotification.php

database/
├── migrations/             # systems, tickets, ticket_comments, ticket_attachments
└── seeders/
    └── DatabaseSeeder.php

resources/views/
├── admin/
│   ├── layouts/admin.blade.php   # Tailwind sidebar layout
│   ├── dashboard.blade.php
│   ├── tickets/
│   │   ├── index.blade.php       # filterable table
│   │   └── show.blade.php        # 2-column detail + reply form
│   └── systems/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
└── emails/                       # markdown mail templates
```

---

## Troubleshooting

**401 on API calls**
Check that `X-Api-Key` and `X-System-Id` headers match a record in the `systems` table where `is_active = 1`.

**Emails not sending**
Install [Mailpit](https://mailpit.axllent.org/) locally and set `MAIL_HOST=127.0.0.1 MAIL_PORT=1025`. Visit `http://localhost:8025` to see caught emails.

**File uploads failing**
Verify S3 credentials and that the bucket has the correct permissions. The bucket must allow `PutObject` and `GetObject`.

**`reference_no` stuck as TKT-TEMP**
The `Ticket` model sets `reference_no` in the `created` boot event (after insert, when `id` is available). If it stays as TKT-TEMP, check for exceptions in `storage/logs/laravel.log`.
