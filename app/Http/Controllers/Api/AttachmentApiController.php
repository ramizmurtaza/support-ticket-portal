<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TicketAttachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentApiController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png,mp4,pdf', 'max:20480'],
        ]);

        $file     = $request->file('file');
        $mimeType = $file->getMimeType();
        $systemId = $request->system->system_id;

        $fileType = match (true) {
            str_starts_with($mimeType, 'image/') => 'image',
            str_starts_with($mimeType, 'video/') => 'video',
            default                              => 'document',
        };

        $path    = $file->store("support-attachments/{$systemId}", 's3');
        $fileUrl = Storage::disk('s3')->url($path);

        $attachment = null;
        if ($request->filled('ticket_id')) {
            $attachment = TicketAttachment::create([
                'ticket_id' => $request->ticket_id,
                'file_url'  => $fileUrl,
                'file_name' => $file->getClientOriginalName(),
                'file_type' => $fileType,
                'file_size' => $file->getSize(),
            ]);
        }

        return response()->json([
            'file_url'  => $fileUrl,
            'file_name' => $file->getClientOriginalName(),
            'file_type' => $fileType,
            'file_size' => $file->getSize(),
            'id'        => $attachment?->id,
        ], 201);
    }
}
