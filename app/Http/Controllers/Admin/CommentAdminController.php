<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Notifications\NewAdminReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class CommentAdminController extends Controller
{
    public function store(Request $request, int $ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);

        $request->validate([
            'body'       => ['required', 'string'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,mp4,pdf', 'max:20480'],
        ]);

        $comment = $ticket->comments()->create([
            'author_type'  => 'admin',
            'author_name'  => Auth::user()->name,
            'author_email' => Auth::user()->email,
            'body'         => $request->body,
        ]);

        if ($request->hasFile('attachment')) {
            $file     = $request->file('attachment');
            $mimeType = $file->getMimeType();
            $fileType = match (true) {
                str_starts_with($mimeType, 'image/') => 'image',
                str_starts_with($mimeType, 'video/') => 'video',
                default                              => 'document',
            };

            $path    = $file->store("support-attachments/{$ticket->system_id}", 's3');
            $fileUrl = Storage::disk('s3')->url($path);

            TicketAttachment::create([
                'ticket_id'  => $ticket->id,
                'comment_id' => $comment->id,
                'file_url'   => $fileUrl,
                'file_name'  => $file->getClientOriginalName(),
                'file_type'  => $fileType,
                'file_size'  => $file->getSize(),
            ]);
        }

        Notification::route('mail', $ticket->client_email)
            ->notify(new NewAdminReplyNotification($ticket, $comment));

        return redirect()->back()->with('success', 'Reply sent successfully.');
    }
}
