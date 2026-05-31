@extends('admin.layouts.admin')

@section('title', $ticket->reference_no)
@section('page-title', $ticket->reference_no . ' — ' . Str::limit($ticket->title, 40))

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.tickets.index') }}" class="text-sm text-blue-600 hover:text-blue-800">&larr; Back to Tickets</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT COLUMN --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Ticket Header --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="font-mono text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded">{{ $ticket->reference_no }}</span>
                @include('admin.partials.status-badge', ['status' => $ticket->status])
                @include('admin.partials.priority-badge', ['priority' => $ticket->priority])
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">{{ ucfirst($ticket->type) }}</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $ticket->title }}</h1>
            <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-500">
                <span>System: <strong class="text-gray-700">{{ $ticket->system?->name ?? $ticket->system_id }}</strong></span>
                <span>Client: <strong class="text-gray-700">{{ $ticket->client_email }}</strong></span>
                <span>Submitted: <strong class="text-gray-700">{{ $ticket->created_at->format('M d, Y H:i') }}</strong></span>
            </div>
        </div>

        {{-- Description --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Description</h3>
            <p class="text-gray-800 whitespace-pre-wrap text-sm leading-relaxed">{{ $ticket->description }}</p>
        </div>

        {{-- Ticket Attachments --}}
        @if($ticket->attachments->where('comment_id', null)->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Attachments</h3>
                <div class="flex flex-wrap gap-4">
                    @foreach($ticket->attachments->where('comment_id', null) as $att)
                        @if($att->file_type === 'image')
                            <img src="{{ $att->file_url }}" alt="{{ $att->file_name }}"
                                 class="max-w-xs max-h-48 rounded-lg border border-gray-200 object-cover">
                        @elseif($att->file_type === 'video')
                            <video controls class="max-w-sm rounded-lg">
                                <source src="{{ $att->file_url }}">
                            </video>
                        @else
                            <a href="{{ $att->file_url }}" target="_blank"
                               class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-blue-600 hover:bg-gray-100">
                                📄 {{ $att->file_name ?? 'Download' }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Comment Thread --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">Conversation</h3>

            <div class="space-y-4 mb-6">
                @forelse($ticket->comments as $comment)
                    <div class="rounded-lg p-4 {{ $comment->author_type === 'admin' ? 'bg-blue-50 border border-blue-100 ml-6' : 'bg-gray-50 border border-gray-200 mr-6' }}">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-semibold {{ $comment->author_type === 'admin' ? 'text-blue-700' : 'text-gray-600' }} uppercase tracking-wider">
                                {{ $comment->author_type === 'admin' ? ($comment->author_name ?? 'Support Team') : ($comment->author_name ?? 'Client') }}
                            </span>
                            <span class="text-xs text-gray-400">{{ $comment->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-800 whitespace-pre-wrap">{{ $comment->body }}</p>

                        @if($comment->attachments->count() > 0)
                            <div class="flex flex-wrap gap-3 mt-3">
                                @foreach($comment->attachments as $att)
                                    @if($att->file_type === 'image')
                                        <img src="{{ $att->file_url }}" alt="{{ $att->file_name }}"
                                             class="max-w-xs max-h-40 rounded border border-gray-200 object-cover">
                                    @elseif($att->file_type === 'video')
                                        <video controls class="max-w-xs rounded">
                                            <source src="{{ $att->file_url }}">
                                        </video>
                                    @else
                                        <a href="{{ $att->file_url }}" target="_blank"
                                           class="text-sm text-blue-600 hover:underline">
                                            📄 {{ $att->file_name ?? 'Download' }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-4">No comments yet.</p>
                @endforelse
            </div>

            {{-- Admin Reply Form --}}
            <div class="border-t border-gray-200 pt-4">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Send Reply</h4>
                <form method="POST"
                      action="{{ route('admin.tickets.comments.store', $ticket->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <textarea name="body" rows="4" required
                                  class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y"
                                  placeholder="Write your reply..."></textarea>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <input type="file" name="attachment" accept="image/*,video/*,.pdf"
                               class="text-sm text-gray-500">
                        <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Send Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- RIGHT COLUMN --}}
    <div class="space-y-4">

        {{-- Status --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Status</h3>
            <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                <input type="hidden" name="jira_task_id" value="{{ $ticket->jira_task_id }}">
                <input type="hidden" name="assigned_to" value="{{ $ticket->assigned_to }}">
                <select name="status" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                    @foreach(['open', 'in_progress', 'waiting_client', 'resolved', 'closed'] as $s)
                        <option value="{{ $s }}" {{ $ticket->status === $s ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $s)) }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Update Status
                </button>
            </form>
        </div>

        {{-- Priority --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Priority</h3>
            <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $ticket->status }}">
                <input type="hidden" name="jira_task_id" value="{{ $ticket->jira_task_id }}">
                <input type="hidden" name="assigned_to" value="{{ $ticket->assigned_to }}">
                <select name="priority" class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                    @foreach(['low', 'medium', 'high', 'critical'] as $p)
                        <option value="{{ $p }}" {{ $ticket->priority === $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Update Priority
                </button>
            </form>
        </div>

        {{-- Jira Task ID --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Jira Task ID</h3>
            <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $ticket->status }}">
                <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                <input type="hidden" name="assigned_to" value="{{ $ticket->assigned_to }}">
                <div class="flex gap-2 mb-3">
                    <input type="text" name="jira_task_id" value="{{ $ticket->jira_task_id }}"
                           placeholder="e.g. PROJ-123"
                           class="flex-1 rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @if($ticket->jira_task_id)
                        <a href="#" target="_blank" title="Open in Jira"
                           class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-lg text-sm hover:bg-gray-200 transition-colors">🔗</a>
                    @endif
                </div>
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Save
                </button>
            </form>
        </div>

        {{-- Assigned To --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Assigned To</h3>
            <form method="POST" action="{{ route('admin.tickets.update', $ticket->id) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $ticket->status }}">
                <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                <input type="hidden" name="jira_task_id" value="{{ $ticket->jira_task_id }}">
                <input type="text" name="assigned_to" value="{{ $ticket->assigned_to }}"
                       placeholder="Assignee name or email"
                       class="w-full rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3">
                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Save
                </button>
            </form>
        </div>

        {{-- Ticket Meta --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Details</h3>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">System</dt>
                    <dd class="text-gray-800 font-medium">{{ $ticket->system?->name ?? $ticket->system_id }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Type</dt>
                    <dd class="text-gray-800">{{ ucfirst($ticket->type) }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Created</dt>
                    <dd class="text-gray-800">{{ $ticket->created_at->format('M d, Y') }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Updated</dt>
                    <dd class="text-gray-800">{{ $ticket->updated_at->format('M d, Y') }}</dd>
                </div>
                @if($ticket->resolved_at)
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Resolved</dt>
                        <dd class="text-gray-800">{{ $ticket->resolved_at->format('M d, Y') }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>

</div>
@endsection
