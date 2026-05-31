<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Notifications\TicketCreatedNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TicketApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'          => ['required', 'string', 'max:255'],
            'description'    => ['required', 'string'],
            'type'           => ['required', 'in:bug,support,feature'],
            'client_name'    => ['nullable', 'string', 'max:100'],
            'client_email'   => ['required', 'email'],
            'attachment_url' => ['nullable', 'url'],
        ]);

        $ticket = Ticket::create(array_merge($validated, [
            'system_id'    => $request->system->system_id,
            'reference_no' => 'TKT-TEMP',
        ]));

        Notification::route('mail', $ticket->client_email)
            ->notify(new TicketCreatedNotification($ticket));

        return response()->json([
            'id'           => $ticket->id,
            'reference_no' => $ticket->reference_no,
        ], 201);
    }

    public function index(Request $request): JsonResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $tickets = Ticket::where('client_email', $request->query('email'))
            ->where('system_id', $request->system->system_id)
            ->latest()
            ->paginate(15);

        return response()->json([
            'data'         => $tickets->map(fn ($t) => [
                'id'           => $t->id,
                'reference_no' => $t->reference_no,
                'title'        => $t->title,
                'type'         => $t->type,
                'status'       => $t->status,
                'priority'     => $t->priority,
                'created_at'   => $t->created_at,
            ]),
            'current_page' => $tickets->currentPage(),
            'last_page'    => $tickets->lastPage(),
            'total'        => $tickets->total(),
        ]);
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $ticket = Ticket::with(['comments.attachments', 'attachments'])
            ->where('id', $id)
            ->where('system_id', $request->system->system_id)
            ->first();

        if (! $ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        return response()->json([
            'id'           => $ticket->id,
            'reference_no' => $ticket->reference_no,
            'system_id'    => $ticket->system_id,
            'client_name'  => $ticket->client_name,
            'client_email' => $ticket->client_email,
            'type'         => $ticket->type,
            'title'        => $ticket->title,
            'description'  => $ticket->description,
            'status'       => $ticket->status,
            'priority'     => $ticket->priority,
            'jira_task_id' => $ticket->jira_task_id,
            'assigned_to'  => $ticket->assigned_to,
            'resolved_at'  => $ticket->resolved_at,
            'created_at'   => $ticket->created_at,
            'updated_at'   => $ticket->updated_at,
            'attachments'  => $ticket->attachments->map(fn ($a) => [
                'id'        => $a->id,
                'file_url'  => $a->file_url,
                'file_name' => $a->file_name,
                'file_type' => $a->file_type,
                'file_size' => $a->file_size,
            ]),
            'comments' => $ticket->comments->map(fn ($c) => [
                'id'          => $c->id,
                'author_type' => $c->author_type,
                'author_name' => $c->author_name,
                'author_email'=> $c->author_email,
                'body'        => $c->body,
                'created_at'  => $c->created_at,
                'attachments' => $c->attachments->map(fn ($a) => [
                    'id'        => $a->id,
                    'file_url'  => $a->file_url,
                    'file_name' => $a->file_name,
                    'file_type' => $a->file_type,
                    'file_size' => $a->file_size,
                ]),
            ]),
        ]);
    }
}
