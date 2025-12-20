<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadAdminController extends Controller
{
    public function download(Request $request, string $token): StreamedResponse
    {
        $data = json_decode(base64_decode($token), true) ?: [];
        abort_if(($data['uid'] ?? null) !== $request->user()->id && !$request->user()->hasRole('Admin'), 403);

        $path = $data['path'] ?? null;
        abort_unless($path, 404);

        $disk = Storage::disk('private');
        abort_unless($disk->exists($path), 404);

        return $disk->download($path);
    }
}
