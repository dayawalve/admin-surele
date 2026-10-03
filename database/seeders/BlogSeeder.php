<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Facades\File;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('seeders/blogs_data.json');
        if (!File::exists($jsonPath)) {
            $this->command->error("blogs_data.json not found!");
            return;
        }

        $blogs = json_decode(File::get($jsonPath), true);
        if (!is_array($blogs)) {
            $this->command->error("Invalid JSON in blogs_data.json");
            return;
        }

        foreach ($blogs as $index => $item) {
            Blog::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title'               => $item['title'] ?? '',
                    'subtitle'            => $item['subtitle'] ?? '',
                    'excerpt'             => $item['excerpt'] ?? '',
                    'category'            => $item['category'] ?? 'Cosmetics & Skincare',
                    'category_slug'       => $item['categorySlug'] ?? 'cosmetic',
                    'author_name'         => $item['author']['name'] ?? 'Surele Team',
                    'author_role'         => $item['author']['role'] ?? 'Formulation Expert',
                    'author_avatar_text'  => $item['author']['avatarText'] ?? 'ST',
                    'author_experience'   => $item['author']['experience'] ?? '',
                    'published_at'        => $item['publishedAt'] ?? 'September 24, 2026',
                    'read_time'           => $item['readTime'] ?? '6 min read',
                    'cover_image'         => $item['coverImage'] ?? '',
                    'tags'                => $item['tags'] ?? [],
                    'featured'            => (bool) ($item['featured'] ?? false),
                    'status'              => 'published',
                    'table_of_contents'   => $item['tableOfContents'] ?? [],
                    'sections'            => $item['sections'] ?? [],
                    'related_products'    => $item['relatedProducts'] ?? [],
                    'faq'                 => $item['faq'] ?? [],
                    'meta_title'          => $item['title'] ?? '',
                    'meta_description'    => $item['excerpt'] ?? '',
                    'order'               => $index + 1,
                ]
            );
        }

        $this->command->info("Seeded " . count($blogs) . " blogs successfully!");
    }
}
