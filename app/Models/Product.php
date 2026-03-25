<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'image_url',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getImageSrcAttribute(): ?string
    {
        $image = $this->getRawOriginal('image_url');

        if (! $image) {
            return null;
        }

        if (Str::startsWith($image, ['http://', 'https://', '//', 'data:'])) {
            return $image;
        }

        $path = $this->stored_image_path;

        if (! $path) {
            return null;
        }

        if (! Storage::disk('public')->exists($path)) {
            return null;
        }

        $version = Storage::disk('public')->lastModified($path) ?: null;

        return route('products.image', [
            'product' => $this,
            'v' => $version,
        ], false);
    }

    public function getStoredImagePathAttribute(): ?string
    {
        $image = $this->getRawOriginal('image_url');

        if (! $image || Str::startsWith($image, ['http://', 'https://', '//', 'data:'])) {
            return null;
        }

        $path = Str::of($image)
            ->ltrim('/')
            ->replaceStart('storage/', '')
            ->toString();

        return $path !== '' ? $path : null;
    }
}
