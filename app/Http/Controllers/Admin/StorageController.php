<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageController extends Controller
{
    /**
     * Serve payment proof files without relying on public/storage symlink.
     *
     * Route: /storage/payments/{path}
     */
    public function paymentProof(string $path): StreamedResponse
    {
        $path = ltrim($path, '/');
        $fullPath = 'payments/' . $path;

        $disk = Storage::disk('public');

        if (!$disk->exists($fullPath)) {
            abort(404);
        }

        $mimeType = $disk->mimeType($fullPath) ?: 'application/octet-stream';
        $filename = basename($fullPath);

        return response()->streamDownload(
            function () use ($disk, $fullPath): void {
                echo $disk->get($fullPath);
            },
            $filename,
            [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]
        );
    }
}
