@component('mail::message')
# Client Replied on Ticket {{ $ticket->reference_no }}

A client has replied to ticket **{{ $ticket->reference_no }}**.

**Client:** {{ $ticket->client_name ?? $ticket->client_email }}
**Title:** {{ $ticket->title }}
**System:** {{ $ticket->system_id }}

---

**Reply:**

{{ $comment->body }}

---

@component('mail::button', ['url' => url('/admin/tickets/' . $ticket->id)])
View Ticket in Admin Panel
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent
