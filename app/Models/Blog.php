<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'excerpt',
        'category',
        'category_slug',
        'author_name',
        'author_role',
        'author_avatar_text',
        'author_experience',
        'published_at',
        'read_time',
        'cover_image',
        'tags',
        'featured',
        'status',
        'table_of_contents',
        'sections',
        'related_products',
        'faq',
        'meta_title',
        'meta_description',
        'order',
    ];

    protected $casts = [
        'tags' => 'array',
        'table_of_contents' => 'array',
        'sections' => 'array',
        'related_products' => 'array',
        'faq' => 'array',
        'featured' => 'boolean',
    ];

    protected $appends = [
        'cover_image_url',
    ];

    /**
     * Get computed full URL for cover image.
     */
    public function getCoverImageUrlAttribute(): string
    {
        if (empty($this->cover_image)) {
            return '';
        }

        // If already an absolute URL (http:// or https://)
        if (Str::startsWith($this->cover_image, ['http://', 'https://'])) {
            return $this->cover_image;
        }

        // If stored as public/storage/ or storage/
        if (Str::startsWith($this->cover_image, 'public/')) {
            return url($this->cover_image);
        }

        if (Str::startsWith($this->cover_image, 'storage/')) {
            return url('public/' . $this->cover_image);
        }

        // If it starts with / (e.g. /products/...)
        if (Str::startsWith($this->cover_image, '/')) {
            return url('public' . $this->cover_image);
        }

        return url('public/' . $this->cover_image);
    }

    /**
     * Format model as TypeScript BlogPost compatible array.
     */
    public function toFrontendFormat(): array
    {
        return [
            'id' => (string) $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'subtitle' => $this->subtitle ?? '',
            'excerpt' => $this->excerpt ?? '',
            'category' => $this->category,
            'categorySlug' => $this->category_slug,
            'author' => [
                'name' => $this->author_name ?: 'Surele Formulation Team',
                'role' => $this->author_role ?: 'Dermo-Cosmetics Specialist',
                'avatarText' => $this->author_avatar_text ?: 'ST',
                'experience' => $this->author_experience ?: '',
            ],
            'publishedAt' => $this->published_at ?: ($this->created_at ? $this->created_at->format('F d, Y') : date('F d, Y')),
            'readTime' => $this->read_time ?: '5 min read',
            'coverImage' => $this->cover_image_url,
            'tags' => is_array($this->tags) ? $this->tags : [],
            'featured' => (bool) $this->featured,
            'tableOfContents' => is_array($this->table_of_contents) ? $this->table_of_contents : [],
            'sections' => is_array($this->sections) ? $this->sections : [],
            'relatedProducts' => is_array($this->related_products) ? $this->related_products : [],
            'faq' => is_array($this->faq) ? $this->faq : [],
        ];
    }

    /**
     * Scope for published blogs.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for featured blogs.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}
