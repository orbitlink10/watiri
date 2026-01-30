<?php

namespace App\Http\Controllers;

use App\Models\HomeContent;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class HeroImageController extends Controller
{
    public function __invoke(): BinaryFileResponse
    {
        $defaultPath = public_path('images/hero-bridal.svg');

        $homeContent = HomeContent::query()->first();
        $path = $defaultPath;

        if ($homeContent && $homeContent->hero_image_path && Storage::disk('public')->exists($homeContent->hero_image_path)) {
            $path = Storage::disk('public')->path($homeContent->hero_image_path);
        }

        $mime = mime_content_type($path) ?: 'image/svg+xml';
        $lastModified = filemtime($path) ?: now()->timestamp;

        return response()->file($path, [
            'Cache-Control' => 'public, max-age=604800, s-maxage=604800',
            'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified) . ' GMT',
            'Content-Type' => $mime,
        ]);
    }
}
