@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm text-gray-500 font-medium">Open Tickets</p>
        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $open }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm text-gray-500 font-medium">In Progress</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $inProgress }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm text-gray-500 font-medium">Resolved Today</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $resolvedToday }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <p class="text-sm text-gray-500 font-medium">Waiting Client</p>
        <p class="text-3xl font-bold text-gray-600 mt-1">{{ $waiting }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Tickets by Product --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-base font-semibold text-gray-800 mb-4">Tickets by System</h3>
        @forelse($bySsystem as $system)
            @php $pct = $system->tickets_count > 0 ? min(100, $system->tickets_count) : 0; @endphp
            <div class="mb-4">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-medium text-gray-700">{{ $system->name }}</span>
                    <span class="text-sm text-gray-500">{{ $system->tickets_count }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $pct }}%"></div>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-400">No systems yet.</p>
        @endforelse
    </div>

    {{-- Recent Tickets --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-800">Recent Tickets</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recent as $ticket)
                <a href="{{ route('admin.tickets.show', $ticket->id) }}"
                   class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="font-mono text-xs text-gray-400 flex-shrink-0">{{ $ticket->reference_no }}</span>
                        <span class="text-sm font-medium text-gray-800 truncate">{{ $ticket->title }}</span>
                        @if($ticket->system)
                            <span class="hidden sm:inline text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded flex-shrink-0">{{ $ticket->system->name }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0 ml-4">
                        @include('admin.partials.status-badge', ['status' => $ticket->status])
                        <span class="hidden sm:inline text-xs text-gray-400">{{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                </a>
            @empty
                <div class="px-6 py-8 text-center text-sm text-gray-400">No tickets yet.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection
