<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title', 500);
            $table->text('subtitle')->nullable();
            $table->text('excerpt')->nullable();
            $table->string('category')->default('Cosmetics & Skincare');
            $table->string('category_slug', 100)->default('cosmetic');

            // Author details
            $table->string('author_name')->nullable();
            $table->string('author_role')->nullable();
            $table->string('author_avatar_text', 50)->nullable();
            $table->string('author_experience')->nullable();

            // Publication & Metadata
            $table->string('published_at')->nullable();
            $table->string('read_time')->nullable();
            $table->string('cover_image', 500)->nullable();
            $table->json('tags')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('status', 50)->default('published'); // published, draft

            // Structured Content
            $table->json('table_of_contents')->nullable();
            $table->longText('sections')->nullable(); // JSON array of BlogSection
            $table->json('related_products')->nullable();
            $table->json('faq')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('order')->default(0);

            $table->timestamps();

            $table->index(['category_slug', 'status']);
            $table->index(['featured', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
