<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Notifications\NewClientCommentNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class CommentApiController extends Controller
{
    public function store(Request $request, int $ticketId): JsonResponse
    {
        $ticket = Ticket::where('id', $ticketId)
            ->where('system_id', $request->system->system_id)
            ->first();

        if (! $ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        $validated = $request->validate([
            'body'         => ['required', 'string'],
            'author_name'  => ['nullable', 'string', 'max:100'],
            'author_email' => ['nullable', 'email'],
        ]);

        $comment = $ticket->comments()->create([
            'author_type'  => 'client',
            'body'         => $validated['body'],
            'author_name'  => $validated['author_name'] ?? null,
            'author_email' => $validated['author_email'] ?? null,
        ]);

        $adminEmail = config('app.admin_email', env('ADMIN_EMAIL', 'admin@example.com'));

        Notification::route('mail', $adminEmail)
            ->notify(new NewClientCommentNotification($ticket, $comment));

        return response()->json([
            'id'          => $comment->id,
            'author_type' => $comment->author_type,
            'author_name' => $comment->author_name,
            'body'        => $comment->body,
            'created_at'  => $comment->created_at,
        ], 201);
    }
}
