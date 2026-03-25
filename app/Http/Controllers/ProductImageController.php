<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductImageController extends Controller
{
    public function __invoke(Product $product): BinaryFileResponse
    {
        $path = $product->stored_image_path;

        abort_unless($path && Storage::disk('public')->exists($path), 404);

        $absolutePath = Storage::disk('public')->path($path);
        $mime = mime_content_type($absolutePath) ?: 'application/octet-stream';
        $lastModified = Storage::disk('public')->lastModified($path) ?: now()->timestamp;

        return response()->file($absolutePath, [
            'Cache-Control' => 'public, max-age=604800, s-maxage=604800',
            'Last-Modified' => gmdate('D, d M Y H:i:s', $lastModified) . ' GMT',
            'Content-Type' => $mime,
        ]);
    }
}
