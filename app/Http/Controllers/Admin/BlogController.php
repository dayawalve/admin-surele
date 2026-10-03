<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    /**
     * Standard categories available for blogs.
     */
    protected function getCategories(): array
    {
        return [
            ['name' => 'Cosmetics & Skincare', 'slug' => 'cosmetic'],
            ['name' => 'Ayurvedic Wellness', 'slug' => 'ayurvedic'],
            ['name' => 'Private Label & OEM', 'slug' => 'private-label'],
            ['name' => 'Natural Care', 'slug' => 'natural-care'],
            ['name' => 'Global Export', 'slug' => 'export'],
            ['name' => 'Home Hygiene', 'slug' => 'home-care'],
        ];
    }

    /**
     * Display a listing of blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::query();

        // Search query
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%")
                  ->orWhere('author_name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($cat = $request->input('category')) {
            $query->where('category_slug', $cat);
        }

        // Status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Featured filter
        if ($request->has('featured') && $request->input('featured') !== '') {
            $query->where('featured', (bool) $request->input('featured'));
        }

        $totalBlogs    = Blog::count();
        $publishedCount = Blog::where('status', 'published')->count();
        $draftCount     = Blog::where('status', 'draft')->count();
        $featuredCount  = Blog::where('featured', true)->count();

        $blogs = $query->orderBy('order', 'asc')->orderByDesc('id')->paginate(15)->withQueryString();
        $categories = $this->getCategories();

        return view('admin.blogs.index', compact(
            'blogs',
            'totalBlogs',
            'publishedCount',
            'draftCount',
            'featuredCount',
            'categories'
        ));
    }

    /**
     * Show form for creating a new blog.
     */
    public function create()
    {
        $categories = $this->getCategories();
        return view('admin.blogs.create', compact('categories'));
    }

    /**
     * Store a newly created blog in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:500',
            'slug'              => 'nullable|string|max:255|unique:blogs,slug',
            'category_slug'     => 'required|string|max:100',
            'cover_image_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:8192',
            'cover_image_url'   => 'nullable|string|max:500',
        ]);

        // Generate unique slug
        $baseSlug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        $slug = $baseSlug;
        $counter = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        // Resolve Category Name
        $categories = $this->getCategories();
        $categoryName = 'Cosmetics & Skincare';
        foreach ($categories as $cat) {
            if ($cat['slug'] === $request->category_slug) {
                $categoryName = $cat['name'];
                break;
            }
        }
        if (!empty($request->custom_category)) {
            $categoryName = $request->custom_category;
        }

        // Handle Image
        $coverImage = $this->handleCoverImage($request);

        // Parse Tags
        $tags = $this->parseTags($request->tags);

        // Parse Structured Sections & TOC
        list($sections, $toc) = $this->processSections($request);

        // Parse FAQs
        $faq = $this->processFaqs($request);

        // Parse Related Products
        $relatedProducts = $this->processRelatedProducts($request);

        // Avatar text calculation
        $avatarText = $request->author_avatar_text;
        if (empty($avatarText) && !empty($request->author_name)) {
            $words = explode(' ', trim($request->author_name));
            $initials = '';
            foreach ($words as $w) {
                $initials .= strtoupper(substr($w, 0, 1));
            }
            $avatarText = substr($initials, 0, 3);
        }

        // Read Time calculation
        $readTime = $request->read_time;
        if (empty($readTime)) {
            $wordCount = str_word_count($request->title . ' ' . $request->subtitle . ' ' . $request->excerpt . ' ' . json_encode($sections));
            $minutes = max(1, ceil($wordCount / 200));
            $readTime = "{$minutes} min read";
        }

        // Publication Date
        $publishedAt = $request->published_at ?: date('F d, Y');

        $blog = Blog::create([
            'slug'                => $slug,
            'title'               => $request->title,
            'subtitle'            => $request->subtitle,
            'excerpt'             => $request->excerpt,
            'category'            => $categoryName,
            'category_slug'       => $request->category_slug,
            'author_name'         => $request->author_name ?: 'Surele Team',
            'author_role'         => $request->author_role ?: 'Formulation Chemist',
            'author_avatar_text'  => $avatarText ?: 'ST',
            'author_experience'   => $request->author_experience,
            'published_at'        => $publishedAt,
            'read_time'           => $readTime,
            'cover_image'         => $coverImage,
            'tags'                => $tags,
            'featured'            => $request->has('featured'),
            'status'              => $request->status ?: 'published',
            'table_of_contents'   => $toc,
            'sections'            => $sections,
            'related_products'    => $relatedProducts,
            'faq'                 => $faq,
            'meta_title'          => $request->meta_title ?: $request->title,
            'meta_description'    => $request->meta_description ?: $request->excerpt,
            'order'               => $request->order ?: 0,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog article created successfully!');
    }

    /**
     * Show form for editing a blog.
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $categories = $this->getCategories();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    /**
     * Update an existing blog in database.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title'             => 'required|string|max:500',
            'slug'              => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'category_slug'     => 'required|string|max:100',
            'cover_image_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp,svg,gif|max:8192',
            'cover_image_url'   => 'nullable|string|max:500',
        ]);

        // Slug handling
        $slug = !empty($request->slug) ? Str::slug($request->slug) : Str::slug($request->title);
        if ($slug !== $blog->slug) {
            $baseSlug = $slug;
            $counter = 1;
            while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
        }

        // Resolve Category Name
        $categories = $this->getCategories();
        $categoryName = $blog->category;
        foreach ($categories as $cat) {
            if ($cat['slug'] === $request->category_slug) {
                $categoryName = $cat['name'];
                break;
            }
        }
        if (!empty($request->custom_category)) {
            $categoryName = $request->custom_category;
        }

        // Image Handling
        $coverImage = $blog->cover_image;
        if ($request->hasFile('cover_image_file')) {
            $coverImage = $this->handleCoverImage($request, $blog->cover_image);
        } elseif (!empty($request->cover_image_url)) {
            $coverImage = $request->cover_image_url;
        }

        // Parse Tags
        $tags = $this->parseTags($request->tags);

        // Parse Structured Sections & TOC
        list($sections, $toc) = $this->processSections($request);

        // Parse FAQs
        $faq = $this->processFaqs($request);

        // Parse Related Products
        $relatedProducts = $this->processRelatedProducts($request);

        // Avatar text
        $avatarText = $request->author_avatar_text;
        if (empty($avatarText) && !empty($request->author_name)) {
            $words = explode(' ', trim($request->author_name));
            $initials = '';
            foreach ($words as $w) {
                $initials .= strtoupper(substr($w, 0, 1));
            }
            $avatarText = substr($initials, 0, 3);
        }

        // Read Time
        $readTime = $request->read_time ?: $blog->read_time;
        if (empty($readTime)) {
            $wordCount = str_word_count($request->title . ' ' . $request->subtitle . ' ' . json_encode($sections));
            $minutes = max(1, ceil($wordCount / 200));
            $readTime = "{$minutes} min read";
        }

        $blog->update([
            'slug'                => $slug,
            'title'               => $request->title,
            'subtitle'            => $request->subtitle,
            'excerpt'             => $request->excerpt,
            'category'            => $categoryName,
            'category_slug'       => $request->category_slug,
            'author_name'         => $request->author_name,
            'author_role'         => $request->author_role,
            'author_avatar_text'  => $avatarText ?: 'ST',
            'author_experience'   => $request->author_experience,
            'published_at'        => $request->published_at ?: $blog->published_at,
            'read_time'           => $readTime,
            'cover_image'         => $coverImage,
            'tags'                => $tags,
            'featured'            => $request->has('featured'),
            'status'              => $request->status ?: 'published',
            'table_of_contents'   => $toc,
            'sections'            => $sections,
            'related_products'    => $relatedProducts,
            'faq'                 => $faq,
            'meta_title'          => $request->meta_title ?: $request->title,
            'meta_description'    => $request->meta_description ?: $request->excerpt,
            'order'               => $request->order ?: 0,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog article updated successfully!');
    }

    /**
     * Remove blog from database.
     */
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        // Delete uploaded image file if locally stored in storage/blogs
        if (!empty($blog->cover_image) && Str::startsWith($blog->cover_image, 'public/storage/blogs/')) {
            $filePath = public_path(str_replace('public/', '', $blog->cover_image));
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('success', 'Blog article deleted successfully!');
    }

    /**
     * Toggle featured status via AJAX or link.
     */
    public function toggleFeatured($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->featured = !$blog->featured;
        $blog->save();

        if (request()->wantsJson()) {
            return response()->json(['status' => true, 'featured' => $blog->featured]);
        }

        return back()->with('success', 'Featured status updated.');
    }

    /**
     * Toggle published status via AJAX or link.
     */
    public function toggleStatus($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->status = $blog->status === 'published' ? 'draft' : 'published';
        $blog->save();

        if (request()->wantsJson()) {
            return response()->json(['status' => true, 'blog_status' => $blog->status]);
        }

        return back()->with('success', 'Status updated.');
    }

    // --- Helper Methods ---

    protected function handleCoverImage(Request $request, $existingImage = null): string
    {
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $folder = public_path('storage/blogs');
            if (!File::exists($folder)) {
                File::makeDirectory($folder, 0755, true);
            }

            // Remove old uploaded file if replacing
            if ($existingImage && Str::startsWith($existingImage, 'public/storage/blogs/')) {
                $oldPath = public_path(str_replace('public/', '', $existingImage));
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($folder, $fileName);
            return 'public/storage/blogs/' . $fileName;
        }

        if (!empty($request->cover_image_url)) {
            return $request->cover_image_url;
        }

        return $existingImage ?: '/products/surele-petroleum-jelly-hero.png';
    }

    protected function parseTags($tagsInput): array
    {
        if (is_array($tagsInput)) {
            return array_values(array_filter(array_map('trim', $tagsInput)));
        }

        if (is_string($tagsInput) && !empty(trim($tagsInput))) {
            return array_values(array_filter(array_map('trim', explode(',', $tagsInput))));
        }

        return [];
    }

    protected function processSections(Request $request): array
    {
        // Check if raw JSON mode was provided
        if (!empty($request->sections_json)) {
            $decoded = json_decode($request->sections_json, true);
            if (is_array($decoded)) {
                $toc = [];
                foreach ($decoded as $sec) {
                    if (!empty($sec['id']) && !empty($sec['heading'])) {
                        $toc[] = [
                            'id' => $sec['id'],
                            'title' => preg_replace('/^\d+\.\s*/', '', $sec['heading']),
                        ];
                    }
                }
                return [$decoded, $toc];
            }
        }

        $sections = [];
        $toc = [];

        if ($request->has('sections') && is_array($request->sections)) {
            foreach ($request->sections as $s) {
                $heading = trim($s['heading'] ?? '');
                if (empty($heading)) {
                    continue;
                }

                $secId = !empty($s['id']) ? Str::slug($s['id']) : Str::slug($heading);

                // Content lines/paragraphs
                $content = [];
                if (!empty($s['content'])) {
                    if (is_array($s['content'])) {
                        $content = array_values(array_filter($s['content']));
                    } else {
                        $content = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $s['content'])))));
                    }
                }

                $sectionObj = [
                    'id'         => $secId,
                    'heading'    => $heading,
                    'subheading' => !empty($s['subheading']) ? trim($s['subheading']) : null,
                    'content'    => $content,
                ];

                // Callout
                if (!empty($s['callout_text'])) {
                    $sectionObj['callout'] = [
                        'type'  => $s['callout_type'] ?? 'highlight',
                        'title' => !empty($s['callout_title']) ? trim($s['callout_title']) : null,
                        'text'  => trim($s['callout_text']),
                    ];
                }

                // Bullets
                if (!empty($s['bullet_points'])) {
                    if (is_array($s['bullet_points'])) {
                        $sectionObj['bulletPoints'] = array_values(array_filter($s['bullet_points']));
                    } else {
                        $sectionObj['bulletPoints'] = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $s['bullet_points'])))));
                    }
                }

                // Technical data / specs table
                if (!empty($s['data_labels']) && is_array($s['data_labels'])) {
                    $items = [];
                    foreach ($s['data_labels'] as $k => $label) {
                        if (!empty(trim($label))) {
                            $items[] = [
                                'label' => trim($label),
                                'value' => trim($s['data_values'][$k] ?? ''),
                            ];
                        }
                    }
                    if (!empty($items)) {
                        $sectionObj['codeOrData'] = [
                            'title' => !empty($s['data_title']) ? trim($s['data_title']) : 'Technical Specifications',
                            'items' => $items,
                        ];
                    }
                }

                $sections[] = $sectionObj;
                $toc[] = [
                    'id'    => $secId,
                    'title' => preg_replace('/^\d+\.\s*/', '', $heading),
                ];
            }
        }

        return [$sections, $toc];
    }

    protected function processFaqs(Request $request): array
    {
        if (!empty($request->faq_json)) {
            $decoded = json_decode($request->faq_json, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        $faqs = [];
        if ($request->has('faqs') && is_array($request->faqs)) {
            foreach ($request->faqs as $f) {
                if (!empty(trim($f['question'] ?? '')) && !empty(trim($f['answer'] ?? ''))) {
                    $faqs[] = [
                        'question' => trim($f['question']),
                        'answer'   => trim($f['answer']),
                    ];
                }
            }
        }

        return $faqs;
    }

    protected function processRelatedProducts(Request $request): array
    {
        if (!empty($request->related_products_json)) {
            $decoded = json_decode($request->related_products_json, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        $products = [];
        if ($request->has('related_products') && is_array($request->related_products)) {
            foreach ($request->related_products as $p) {
                if (!empty(trim($p['name'] ?? ''))) {
                    $products[] = [
                        'name'     => trim($p['name']),
                        'slug'     => !empty($p['slug']) ? Str::slug($p['slug']) : Str::slug($p['name']),
                        'category' => $p['category'] ?? 'Cosmetics',
                        'image'    => $p['image'] ?? '/products/surele-petroleum-jelly-hero.png',
                        'tagline'  => $p['tagline'] ?? '',
                    ];
                }
            }
        }

        return $products;
    }
}
