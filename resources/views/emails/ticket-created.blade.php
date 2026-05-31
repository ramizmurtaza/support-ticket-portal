@component('mail::message')
# Ticket Received

Hello{{ $ticket->client_name ? ', ' . $ticket->client_name : '' }},

Thank you for reaching out. We have received your support ticket and our team will review it shortly.

**Reference:** {{ $ticket->reference_no }}
**Title:** {{ $ticket->title }}
**Status:** {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}

@component('mail::button', ['url' => '#'])
View Ticket
@endcomponent

Please keep your reference number handy for follow-ups. We appreciate your patience.

Thanks,
{{ config('app.name') }}
@endcomponent
