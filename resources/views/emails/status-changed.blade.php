@component('mail::message')
# Ticket Status Updated

Hello{{ $ticket->client_name ? ', ' . $ticket->client_name : '' }},

Your support ticket has been updated.

**Reference:** {{ $ticket->reference_no }}
**Title:** {{ $ticket->title }}
**Previous Status:** {{ ucfirst(str_replace('_', ' ', $oldStatus)) }}
**New Status:** {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}

@if($ticket->status === 'resolved')
Your issue has been marked as resolved. If you have further questions, please open a new ticket.
@elseif($ticket->status === 'waiting_client')
Our team has responded and is waiting for your input. Please review and reply at your earliest convenience.
@else
Our team is actively working on your ticket.
@endif

Thanks,
{{ config('app.name') }}
@endcomponent
