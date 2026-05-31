<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StatusChangedNotification extends Notification
{
    public function __construct(
        public Ticket $ticket,
        public string $oldStatus
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Your ticket {$this->ticket->reference_no} has been updated")
            ->markdown('emails.status-changed', [
                'ticket'    => $this->ticket,
                'oldStatus' => $this->oldStatus,
            ]);
    }
}
