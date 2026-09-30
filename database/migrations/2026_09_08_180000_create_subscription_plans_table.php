<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    protected $connection = 'pgsql_second';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $connections = ['pgsql_second'];

        foreach ($connections as $conn) {
            if (!Schema::connection($conn)->hasTable('subscription_plans')) {
                Schema::connection($conn)->create('subscription_plans', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('slug')->unique();
                    $table->string('tagline')->nullable();
                    $table->decimal('price', 10, 2)->default(0.00);
                    $table->string('currency', 10)->default('$');
                    $table->string('billing_period', 50)->default('mo');
                    $table->string('badge', 100)->nullable();
                    $table->string('button_text', 100)->default('Start Now');
                    $table->string('button_link', 500)->nullable();
                    $table->text('features')->nullable();
                    $table->integer('llm_prompts')->nullable();
                    $table->string('keyword_ranking', 100)->nullable();
                    $table->string('blog_posts', 100)->nullable();
                    $table->string('backlink_checks', 100)->nullable();
                    $table->string('new_pages', 100)->nullable();
                    $table->integer('ai_engines_count')->default(6);
                    $table->string('stripe_plan_id', 255)->nullable();
                    $table->boolean('is_popular')->default(false);
                    $table->boolean('is_active')->default(true);
                    $table->integer('sort_order')->default(0);
                    $table->timestamps();
                });

                // Seed initial 3 plans matching user reference cards
                $plans = [
                    [
                        'name' => 'Core Rank',
                        'slug' => 'core-rank',
                        'tagline' => 'For Business just getting started',
                        'price' => 299.00,
                        'currency' => '$',
                        'billing_period' => 'mo',
                        'badge' => null,
                        'button_text' => 'Start with Starter',
                        'button_link' => '#',
                        'features' => json_encode([
                            '40 LLM Prompts',
                            'Monthly Keyword Ranking',
                            '1–3 Blog Posts (Suggested Content)',
                            '1× Backlink Check',
                            '3 New Pages (Suggested)',
                            'AI visibility across 6 engines'
                        ]),
                        'llm_prompts' => 40,
                        'keyword_ranking' => 'Monthly',
                        'blog_posts' => '1–3',
                        'backlink_checks' => '1×',
                        'new_pages' => '3',
                        'ai_engines_count' => 6,
                        'is_popular' => false,
                        'is_active' => true,
                        'sort_order' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Growth Surge',
                        'slug' => 'growth-surge',
                        'tagline' => 'For growth brands scaling content',
                        'price' => 449.00,
                        'currency' => '$',
                        'billing_period' => 'mo',
                        'badge' => 'Most popular',
                        'button_text' => 'Start with Growth',
                        'button_link' => '#',
                        'features' => json_encode([
                            '100 LLM Prompts',
                            'Weekly Keyword Ranking',
                            '5 Blog Posts (Suggested Content)',
                            '2× Backlink Check',
                            '5 New Pages (Suggested)',
                            'AI visibility across 6 engines'
                        ]),
                        'llm_prompts' => 100,
                        'keyword_ranking' => 'Weekly',
                        'blog_posts' => '5',
                        'backlink_checks' => '2×',
                        'new_pages' => '5',
                        'ai_engines_count' => 6,
                        'is_popular' => true,
                        'is_active' => true,
                        'sort_order' => 2,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Authority Pro',
                        'slug' => 'authority-pro',
                        'tagline' => 'Full power for authority level SEO',
                        'price' => 549.00,
                        'currency' => '$',
                        'billing_period' => 'mo',
                        'badge' => null,
                        'button_text' => 'Start with Scale',
                        'button_link' => '#',
                        'features' => json_encode([
                            '150 LLM Prompts',
                            'Weekly Keyword Ranking',
                            '10 Blog Posts (Suggested Content)',
                            '2× Backlink Check',
                            '7 New Pages (Suggested)',
                            'AI visibility across 6 engines'
                        ]),
                        'llm_prompts' => 150,
                        'keyword_ranking' => 'Weekly',
                        'blog_posts' => '10',
                        'backlink_checks' => '2×',
                        'new_pages' => '7',
                        'ai_engines_count' => 6,
                        'is_popular' => false,
                        'is_active' => true,
                        'sort_order' => 3,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                ];

                DB::connection($conn)->table('subscription_plans')->insert($plans);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('pgsql_second')->dropIfExists('subscription_plans');
    }
};
