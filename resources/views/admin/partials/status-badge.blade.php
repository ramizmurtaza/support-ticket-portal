@php
$classes = match($status) {
    'open'           => 'bg-yellow-100 text-yellow-800',
    'in_progress'    => 'bg-blue-100 text-blue-800',
    'waiting_client' => 'bg-gray-100 text-gray-700',
    'resolved'       => 'bg-green-100 text-green-800',
    'closed'         => 'bg-slate-100 text-slate-600',
    default          => 'bg-gray-100 text-gray-700',
};
@endphp
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
