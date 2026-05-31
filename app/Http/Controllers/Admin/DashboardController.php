<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $open          = Ticket::open()->count();
        $inProgress    = Ticket::byStatus('in_progress')->count();
        $resolvedToday = Ticket::where('status', 'resolved')
            ->whereDate('resolved_at', today())
            ->count();
        $waiting       = Ticket::byStatus('waiting_client')->count();
        $bySsystem     = System::withCount('tickets')->get();
        $recent        = Ticket::with('system')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'open', 'inProgress', 'resolvedToday', 'waiting', 'bySsystem', 'recent'
        ));
    }
}
