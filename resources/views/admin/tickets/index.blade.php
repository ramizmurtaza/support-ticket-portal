@extends('admin.layouts.admin')

@section('title', 'All Tickets')
@section('page-title', 'All Tickets')

@section('content')

{{-- Filter Bar --}}
<form method="GET" action="{{ route('admin.tickets.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
        <select name="system_id" class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Systems</option>
            @foreach($systems as $system)
                <option value="{{ $system->system_id }}" {{ request('system_id') === $system->system_id ? 'selected' : '' }}>
                    {{ $system->name }}
                </option>
            @endforeach
        </select>

        <select name="status" class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Statuses</option>
            @foreach(['open', 'in_progress', 'waiting_client', 'resolved', 'closed'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>
                    {{ ucfirst(str_replace('_', ' ', $s)) }}
                </option>
            @endforeach
        </select>

        <select name="priority" class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Priorities</option>
            @foreach(['low', 'medium', 'high', 'critical'] as $p)
                <option value="{{ $p }}" {{ request('priority') === $p ? 'selected' : '' }}>
                    {{ ucfirst($p) }}
                </option>
            @endforeach
        </select>

        <select name="type" class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">All Types</option>
            @foreach(['bug', 'support', 'feature'] as $t)
                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>
                    {{ ucfirst($t) }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Search title, ref, email..."
               class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 sm:col-span-2 lg:col-span-1">

        <input type="date" name="date_from" value="{{ request('date_from') }}"
               class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <input type="date" name="date_to" value="{{ request('date_to') }}"
               class="rounded-lg border border-gray-300 text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Apply
            </button>
            <a href="{{ route('admin.tickets.index') }}" class="flex-1 text-center bg-gray-100 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                Reset
            </a>
        </div>
    </div>
</form>

{{-- Tickets Table --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ref</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                <th class="hidden md:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">System</th>
                <th class="hidden lg:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="hidden lg:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Priority</th>
                <th class="hidden xl:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Client</th>
                <th class="hidden xl:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Created</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($tickets as $ticket)
                <tr class="hover:bg-gray-50 transition-colors cursor-pointer"
                    onclick="window.location='{{ route('admin.tickets.show', $ticket->id) }}'">
                    <td class="px-4 py-3">
                        <span class="font-mono text-xs text-gray-500">{{ $ticket->reference_no }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-sm font-medium text-gray-900">{{ Str::limit($ticket->title, 50) }}</span>
                    </td>
                    <td class="hidden md:table-cell px-4 py-3">
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded">
                            {{ $ticket->system?->name ?? $ticket->system_id }}
                        </span>
                    </td>
                    <td class="hidden lg:table-cell px-4 py-3">
                        <span class="text-xs text-gray-600">{{ ucfirst($ticket->type) }}</span>
                    </td>
                    <td class="px-4 py-3">
                        @include('admin.partials.status-badge', ['status' => $ticket->status])
                    </td>
                    <td class="hidden lg:table-cell px-4 py-3">
                        @include('admin.partials.priority-badge', ['priority' => $ticket->priority])
                    </td>
                    <td class="hidden xl:table-cell px-4 py-3">
                        <span class="text-xs text-gray-500">{{ $ticket->client_email }}</span>
                    </td>
                    <td class="hidden xl:table-cell px-4 py-3">
                        <span class="text-xs text-gray-400">{{ $ticket->created_at->format('M d, Y') }}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                           onclick="event.stopPropagation()"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">View</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center text-sm text-gray-400">No tickets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($tickets->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $tickets->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
