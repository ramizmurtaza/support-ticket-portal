<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewClientCommentNotification extends Notification
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
            ->subject("Client replied on {$this->ticket->reference_no}")
            ->markdown('emails.client-comment', [
                'ticket'  => $this->ticket,
                'comment' => $this->comment,
            ]);
    }
}
