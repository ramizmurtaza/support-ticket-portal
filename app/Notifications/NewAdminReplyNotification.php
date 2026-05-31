<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAdminReplyNotification extends Notification
{
    public function __construct(
        public Ticket $ticket,
        public TicketComment $comment
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New reply on ticket {$this->ticket->reference_no}")
            ->markdown('emails.admin-reply', [
                'ticket'  => $this->ticket,
                'comment' => $this->comment,
            ]);
    }
}
