<?php

use App\Http\Controllers\Api\AttachmentApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\TicketApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('system.auth')->group(function () {
    Route::post('/tickets',                 [TicketApiController::class, 'store']);
    Route::get('/tickets',                  [TicketApiController::class, 'index']);
    Route::get('/tickets/{id}',             [TicketApiController::class, 'show']);
    Route::post('/tickets/{id}/comments',   [CommentApiController::class, 'store']);
    Route::post('/upload',                  [AttachmentApiController::class, 'store']);
});
