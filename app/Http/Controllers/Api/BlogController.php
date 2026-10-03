<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Get published blogs with optional filtering.
     */
    public function index(Request $request)
    {
        $query = Blog::query()->published();

        // Filter by category slug
        if ($category = $request->input('category')) {
            if ($category !== 'all') {
                $query->where(function ($q) use ($category) {
                    $q->where('category_slug', $category)
                      ->orWhere('category', $category);
                });
            }
        }

        // Filter by featured
        if ($request->has('featured')) {
            $isFeatured = filter_var($request->input('featured'), FILTER_VALIDATE_BOOLEAN);
            if ($isFeatured) {
                $query->where('featured', true);
            }
        }

        // Search query
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%");
            });
        }

        // Order
        $query->orderBy('order', 'asc')->orderByDesc('id');

        // Limit or pagination
        if ($limit = $request->input('limit')) {
            $blogs = $query->limit((int) $limit)->get();
        } else {
            $blogs = $query->get();
        }

        $formatted = $blogs->map(function ($blog) {
            return $blog->toFrontendFormat();
        });

        return response()->json([
            'status'  => true,
            'success' => true,
            'data'    => $formatted,
            'total'   => $blogs->count(),
        ]);
    }

    /**
     * Get single blog post by slug.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        if (!$blog && is_numeric($slug)) {
            $blog = Blog::find($slug);
        }

        if (!$blog) {
            return response()->json([
                'status'  => false,
                'success' => false,
                'message' => 'Blog article not found',
            ], 404);
        }

        // Fetch related blogs (up to 3)
        $related = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('category_slug', $blog->category_slug)
            ->limit(3)
            ->get();

        if ($related->count() < 3) {
            $more = Blog::published()
                ->where('id', '!=', $blog->id)
                ->whereNotIn('id', $related->pluck('id'))
                ->limit(3 - $related->count())
                ->get();
            $related = $related->merge($more);
        }

        $formattedRelated = $related->map(fn($b) => $b->toFrontendFormat());

        return response()->json([
            'status'   => true,
            'success'  => true,
            'data'     => $blog->toFrontendFormat(),
            'related'  => $formattedRelated,
        ]);
    }

    /**
     * Get list of categories and counts.
     */
    public function categories()
    {
        $baseCategories = [
            ['name' => 'All Articles', 'slug' => 'all'],
            ['name' => 'Cosmetics & Skincare', 'slug' => 'cosmetic'],
            ['name' => 'Ayurvedic Wellness', 'slug' => 'ayurvedic'],
            ['name' => 'Private Label & OEM', 'slug' => 'private-label'],
            ['name' => 'Natural Care', 'slug' => 'natural-care'],
            ['name' => 'Global Export', 'slug' => 'export'],
            ['name' => 'Home Hygiene', 'slug' => 'home-care'],
        ];

        $counts = Blog::published()
            ->selectRaw('category_slug, count(*) as total')
            ->groupBy('category_slug')
            ->pluck('total', 'category_slug');

        $result = array_map(function ($cat) use ($counts) {
            $slug = $cat['slug'];
            $cat['count'] = $slug === 'all' 
                ? Blog::published()->count() 
                : ($counts[$slug] ?? 0);
            return $cat;
        }, $baseCategories);

        return response()->json([
            'status'  => true,
            'success' => true,
            'data'    => $result,
        ]);
    }
}
