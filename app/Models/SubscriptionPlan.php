<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $connection = 'pgsql_second';
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'price',
        'currency',
        'billing_period',
        'badge',
        'button_text',
        'button_link',
        'features',
        'llm_prompts',
        'keyword_ranking',
        'blog_posts',
        'backlink_checks',
        'new_pages',
        'ai_engines_count',
        'stripe_plan_id',
        'is_popular',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
        'llm_prompts' => 'integer',
        'ai_engines_count' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Get features as an array.
     */
    public function getFeaturesArrayAttribute(): array
    {
        if (empty($this->features)) {
            return [];
        }

        if (is_array($this->features)) {
            return $this->features;
        }

        $decoded = json_decode($this->features, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Fallback to line breaks
        return array_filter(array_map('trim', explode("\n", $this->features)));
    }
}
