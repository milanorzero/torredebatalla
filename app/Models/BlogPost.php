<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $appends = [
        'cover_image_url',
        'is_published',
    ];

    public function getCoverImageUrlAttribute(): ?string
    {
        if (!$this->cover_image) {
            return null;
        }

        return asset('blog/' . $this->cover_image);
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->published_at !== null && $this->published_at->lte(now());
    }

    protected static function booted(): void
    {
        static::saving(function (BlogPost $post) {
            $slug = trim((string) $post->slug);
            if ($slug === '') {
                $slug = Str::slug((string) $post->title);
            } else {
                $slug = Str::slug($slug);
            }

            if ($slug === '') {
                $slug = 'post';
            }

            $post->slug = static::generateUniqueSlug($slug, $post->id);
        });
    }

    public static function generateUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $counter = 2;

        while (static::query()
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
