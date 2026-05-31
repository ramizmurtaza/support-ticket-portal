<?php

use App\Http\Controllers\Admin\CommentAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SystemAdminController;
use App\Http\Controllers\Admin\TicketAdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/tickets', [TicketAdminController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/{id}', [TicketAdminController::class, 'show'])->name('tickets.show');
    Route::patch('/tickets/{id}', [TicketAdminController::class, 'update'])->name('tickets.update');
    Route::post('/tickets/{id}/comments', [CommentAdminController::class, 'store'])->name('tickets.comments.store');

    Route::get('/systems', [SystemAdminController::class, 'index'])->name('systems.index');
    Route::get('/systems/create', [SystemAdminController::class, 'create'])->name('systems.create');
    Route::post('/systems', [SystemAdminController::class, 'store'])->name('systems.store');
    Route::get('/systems/{id}/edit', [SystemAdminController::class, 'edit'])->name('systems.edit');
    Route::patch('/systems/{id}', [SystemAdminController::class, 'update'])->name('systems.update');
    Route::post('/systems/{id}/regenerate-key', [SystemAdminController::class, 'regenerateKey'])->name('systems.regenerate');
});

require __DIR__ . '/auth.php';
