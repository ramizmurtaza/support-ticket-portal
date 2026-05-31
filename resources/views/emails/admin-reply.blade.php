@component('mail::message')
# New Reply on Your Ticket

Hello{{ $ticket->client_name ? ', ' . $ticket->client_name : '' }},

Our support team has replied to your ticket **{{ $ticket->reference_no }}**.

---

**{{ $comment->author_name ?? 'Support Team' }}** wrote:

{{ $comment->body }}

---

Please log in to view the full conversation and reply if needed.

Thanks,
{{ config('app.name') }}
@endcomponent
