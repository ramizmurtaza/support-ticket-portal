<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Models\Ticket;
use App\Notifications\StatusChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TicketAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with('system');

        if ($request->filled('system_id')) {
            $query->where('system_id', $request->system_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                  ->orWhere('reference_no', 'like', $search)
                  ->orWhere('client_email', 'like', $search);
            });
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $tickets = $query->latest()->paginate(20)->appends($request->query());
        $systems = System::all();

        return view('admin.tickets.index', compact('tickets', 'systems'));
    }

    public function show(int $id)
    {
        $ticket  = Ticket::with(['system', 'comments.attachments', 'attachments'])->findOrFail($id);
        $systems = System::all();

        return view('admin.tickets.show', compact('ticket', 'systems'));
    }

    public function update(Request $request, int $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'status'       => ['required', 'in:open,in_progress,waiting_client,resolved,closed'],
            'priority'     => ['required', 'in:low,medium,high,critical'],
            'jira_task_id' => ['nullable', 'string', 'max:50'],
            'assigned_to'  => ['nullable', 'string', 'max:100'],
        ]);

        $oldStatus = $ticket->status;

        if ($validated['status'] === 'resolved' && $ticket->status !== 'resolved') {
            $validated['resolved_at'] = now();
        }

        $ticket->update($validated);

        if ($oldStatus !== $validated['status']) {
            Notification::route('mail', $ticket->client_email)
                ->notify(new StatusChangedNotification($ticket, $oldStatus));
        }

        return redirect()->back()->with('success', 'Ticket updated successfully.');
    }
}
