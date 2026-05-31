<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'reference_no', 'system_id', 'client_name', 'client_email',
        'type', 'title', 'description', 'status', 'priority',
        'jira_task_id', 'assigned_to', 'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::created(function (Ticket $ticket) {
            $ticket->reference_no = 'TKT-' . now()->year . '-' . str_pad($ticket->id, 5, '0', STR_PAD_LEFT);
            $ticket->saveQuietly();
        });
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class, 'system_id', 'system_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TicketAttachment::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    public function scopeBySystem($query, string $systemId)
    {
        return $query->where('system_id', $systemId);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
