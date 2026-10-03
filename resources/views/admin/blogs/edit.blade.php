<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <!-- Toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Edit Blog Article
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.blogs.index') }}" class="text-muted text-hover-primary">Blogs</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Edit #{{ $blog->id }}</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm fw-bold btn-light-primary">
                            <i class="bi bi-arrow-left me-1"></i> Back to All Blogs
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">

                    @if ($errors->any())
                        <div class="alert alert-danger d-flex align-items-center p-5 mb-6">
                            <i class="bi bi-exclamation-triangle-fill fs-2hx text-danger me-4"></i>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-danger">Please fix the following errors:</h4>
                                <ul class="mb-0 ps-4">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form id="blog_form" action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-7">
                            <!-- Left Column: Main Content & Sections (8 cols) -->
                            <div class="col-lg-8">
                                <!-- Article Overview Card -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Article Overview</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <!-- Title -->
                                        <div class="mb-5">
                                            <label class="required form-label fw-bold">Article Title</label>
                                            <input type="text" name="title" id="blog_title" class="form-control form-control-solid"
                                                placeholder="Article title..."
                                                value="{{ old('title', $blog->title) }}" required />
                                        </div>

                                        <!-- Slug -->
                                        <div class="mb-5">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <label class="form-label fw-bold mb-0">URL Slug</label>
                                                <button type="button" class="btn btn-link btn-sm p-0 text-primary" id="btn_generate_slug">
                                                    <i class="bi bi-magic me-1"></i> Regenerate Slug
                                                </button>
                                            </div>
                                            <div class="input-group input-group-solid">
                                                <span class="input-group-text text-muted">/blog/</span>
                                                <input type="text" name="slug" id="blog_slug" class="form-control form-control-solid"
                                                    value="{{ old('slug', $blog->slug) }}" />
                                            </div>
                                        </div>

                                        <!-- Subtitle -->
                                        <div class="mb-5">
                                            <label class="form-label fw-bold">Subtitle</label>
                                            <textarea name="subtitle" rows="2" class="form-control form-control-solid">{{ old('subtitle', $blog->subtitle) }}</textarea>
                                        </div>

                                        <!-- Excerpt -->
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Excerpt / Summary</label>
                                            <textarea name="excerpt" rows="3" class="form-control form-control-solid">{{ old('excerpt', $blog->excerpt) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dynamic Blog Sections Builder -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-layers-fill text-primary fs-3"></i>
                                                <h2 class="mb-0">Article Content Sections</h2>
                                            </div>
                                        </div>
                                        <div class="card-toolbar gap-2">
                                            <button type="button" class="btn btn-sm btn-light-info" id="btn_toggle_json_mode">
                                                <i class="bi bi-code-square me-1"></i> Raw JSON Mode
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" id="btn_add_section">
                                                <i class="bi bi-plus-lg me-1"></i> Add Section
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="alert alert-light-primary d-flex align-items-center p-4 mb-5">
                                            <i class="bi bi-info-circle-fill fs-3 text-primary me-3"></i>
                                            <span class="fs-7">
                                                Sections generate your <strong>Table of Contents</strong> and structured body content.
                                            </span>
                                        </div>

                                        <!-- Raw JSON editor container -->
                                        <div id="json_mode_container" class="d-none mb-5">
                                            <label class="form-label fw-bold">Sections JSON (Advanced)</label>
                                            <textarea name="sections_json" id="sections_json" rows="12" class="form-control font-monospace fs-7 bg-light-dark text-dark">{{ json_encode($blog->sections, JSON_PRETTY_PRINT) }}</textarea>
                                            <div class="form-text">If filled, this JSON array overrides visual builder inputs.</div>
                                        </div>

                                        <!-- Visual Sections Container -->
                                        <div id="sections_container" class="d-flex flex-column gap-5">
                                            <!-- Injected via JavaScript from existing sections -->
                                        </div>

                                        <div class="text-center mt-5">
                                            <button type="button" class="btn btn-light-primary w-100 py-3" id="btn_add_section_bottom">
                                                <i class="bi bi-plus-circle me-2"></i> Add Another Content Section
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- FAQs Builder Card -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-question-circle-fill text-primary fs-3"></i>
                                                <h2 class="mb-0">Frequently Asked Questions (FAQ)</h2>
                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-light-primary" id="btn_add_faq">
                                                <i class="bi bi-plus-lg me-1"></i> Add FAQ
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div id="faq_container" class="d-flex flex-column gap-3">
                                            <!-- FAQ rows -->
                                        </div>
                                    </div>
                                </div>

                                <!-- Related Products Card -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="bi bi-bag-check-fill text-primary fs-3"></i>
                                                <h2 class="mb-0">Related Products Showcase</h2>
                                            </div>
                                        </div>
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-light-primary" id="btn_add_product">
                                                <i class="bi bi-plus-lg me-1"></i> Add Product
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div id="products_container" class="d-flex flex-column gap-3">
                                            <!-- Product rows -->
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Metadata Card -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>SEO & Meta Details</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Meta Title</label>
                                            <input type="text" name="meta_title" class="form-control form-control-solid"
                                                value="{{ old('meta_title', $blog->meta_title) }}" />
                                        </div>
                                        <div>
                                            <label class="form-label fw-bold">Meta Description</label>
                                            <textarea name="meta_description" rows="2" class="form-control form-control-solid">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Publishing Controls, Image & Metadata (4 cols) -->
                            <div class="col-lg-4">
                                <!-- Publish Settings Card -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Publish Settings</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <!-- Status -->
                                        <div class="mb-4">
                                            <label class="required form-label fw-bold">Article Status</label>
                                            <select name="status" class="form-select form-select-solid">
                                                <option value="published" {{ old('status', $blog->status) === 'published' ? 'selected' : '' }}>
                                                    Published (Live on Website)
                                                </option>
                                                <option value="draft" {{ old('status', $blog->status) === 'draft' ? 'selected' : '' }}>
                                                    Draft (Hidden)
                                                </option>
                                            </select>
                                        </div>

                                        <!-- Featured Switch -->
                                        <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-light mb-4">
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold text-dark fs-7">Featured Article</span>
                                                <span class="text-muted fs-8">Display in Home Page journal section</span>
                                            </div>
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured_toggle" {{ old('featured', $blog->featured) ? 'checked' : '' }} />
                                            </div>
                                        </div>

                                        <!-- Published Date -->
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Published Date</label>
                                            <input type="text" name="published_at" class="form-control form-control-solid"
                                                value="{{ old('published_at', $blog->published_at) }}" />
                                        </div>

                                        <!-- Read Time -->
                                        <div class="mb-4">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <label class="form-label fw-bold mb-0">Read Time</label>
                                                <button type="button" class="btn btn-link btn-sm p-0 text-primary" id="btn_calc_read_time">
                                                    <i class="bi bi-stopwatch me-1"></i> Auto Calculate
                                                </button>
                                            </div>
                                            <input type="text" name="read_time" id="blog_read_time" class="form-control form-control-solid"
                                                value="{{ old('read_time', $blog->read_time) }}" />
                                        </div>

                                        <!-- Sort Order -->
                                        <div class="mb-5">
                                            <label class="form-label fw-bold">Display Order</label>
                                            <input type="number" name="order" class="form-control form-control-solid"
                                                value="{{ old('order', $blog->order) }}" />
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-primary w-100 py-3 fw-bold fs-6">
                                            <i class="bi bi-check2-circle me-2"></i> Update Article
                                        </button>
                                    </div>
                                </div>

                                <!-- Cover Image Card -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Cover Image</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0 text-center">
                                        <!-- Preview Box -->
                                        <div class="image-input image-input-outline mb-4 w-100" style="min-height: 180px; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                                            <img id="cover_image_preview" src="{{ $blog->cover_image_url ?: '/products/surele-petroleum-jelly-hero.png' }}" alt="Preview"
                                                style="max-width: 100%; max-height: 190px; object-fit: contain; {{ $blog->cover_image ? 'display: block;' : 'display: none;' }}" />
                                            <div id="cover_image_placeholder" class="text-muted p-4" style="{{ $blog->cover_image ? 'display: none;' : 'display: block;' }}">
                                                <i class="bi bi-image fs-3x text-muted mb-2 d-block"></i>
                                                <span class="fs-7 fw-semibold">Upload cover image or provide path below</span>
                                            </div>
                                        </div>

                                        <!-- Upload Input -->
                                        <div class="mb-3 text-start">
                                            <label class="form-label fw-bold">Replace Image File</label>
                                            <input type="file" name="cover_image_file" id="cover_image_file" class="form-control form-control-solid" accept="image/*" />
                                            <div class="form-text">Choose a new file to replace current image.</div>
                                        </div>

                                        <!-- Or Image URL / Path -->
                                        <div class="text-start">
                                            <label class="form-label fw-bold">Or Image Path / External URL</label>
                                            <input type="text" name="cover_image_url" id="cover_image_url" class="form-control form-control-solid"
                                                value="{{ old('cover_image_url', $blog->cover_image) }}" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Category Selection Card -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Category</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="mb-3">
                                            <label class="required form-label fw-bold">Select Category</label>
                                            <select name="category_slug" id="category_slug" class="form-select form-select-solid" required>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat['slug'] }}" {{ old('category_slug', $blog->category_slug) == $cat['slug'] ? 'selected' : '' }}>
                                                        {{ $cat['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Author Profile Card -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Author Profile</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Author Name</label>
                                            <input type="text" name="author_name" id="author_name" class="form-control form-control-solid"
                                                value="{{ old('author_name', $blog->author_name) }}" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Author Role / Title</label>
                                            <input type="text" name="author_role" class="form-control form-control-solid"
                                                value="{{ old('author_role', $blog->author_role) }}" />
                                        </div>
                                        <div class="row g-2 mb-3">
                                            <div class="col-4">
                                                <label class="form-label fw-bold">Initials</label>
                                                <input type="text" name="author_avatar_text" id="author_avatar_text" class="form-control form-control-solid"
                                                    maxlength="4" value="{{ old('author_avatar_text', $blog->author_avatar_text) }}" />
                                            </div>
                                            <div class="col-8">
                                                <label class="form-label fw-bold">Experience</label>
                                                <input type="text" name="author_experience" class="form-control form-control-solid"
                                                    value="{{ old('author_experience', $blog->author_experience) }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tags Card -->
                                <div class="card card-flush shadow-sm mb-6">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h2>Tags</h2>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        @php
                                            $tagStr = is_array($blog->tags) ? implode(', ', $blog->tags) : ($blog->tags ?? '');
                                        @endphp
                                        <label class="form-label fw-bold">Tags (Comma-separated)</label>
                                        <input type="text" name="tags" class="form-control form-control-solid"
                                            value="{{ old('tags', $tagStr) }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Section Template (Hidden) -->
        <template id="section_template">
            <div class="section-item card border border-gray-300 shadow-none p-5 rounded-3 mb-4" data-index="__INDEX__">
                <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge badge-primary fs-7 fw-bold section-badge">Section #__NUM__</span>
                        <h4 class="mb-0 fs-6 fw-bold section-title-preview text-gray-800">New Content Section</h4>
                    </div>
                    <button type="button" class="btn btn-icon btn-light-danger btn-sm btn-remove-section" title="Delete section">
                        <i class="bi bi-trash fs-5"></i>
                    </button>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <label class="required form-label fw-bold">Section Heading</label>
                        <input type="text" name="sections[__INDEX__][heading]" class="form-control form-control-solid section-heading-input"
                            placeholder="Heading..." required />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Anchor ID (TOC ID)</label>
                        <input type="text" name="sections[__INDEX__][id]" class="form-control form-control-solid section-id-input"
                            placeholder="anchor-id" />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Subheading (Optional)</label>
                    <input type="text" name="sections[__INDEX__][subheading]" class="form-control form-control-solid section-subheading-input"
                        placeholder="Subheading..." />
                </div>

                <div class="mb-4">
                    <label class="required form-label fw-bold">Paragraphs Content</label>
                    <textarea name="sections[__INDEX__][content]" rows="4" class="form-control form-control-solid section-content-input"
                        placeholder="Paragraphs separated by blank line..." required></textarea>
                </div>

                <!-- Collapsible Extras: Callout, Bullets, Data -->
                <div class="accordion accordion-icon-toggle" id="section_extras___INDEX__">
                    <!-- Callout Accordion -->
                    <div class="mb-3 border rounded">
                        <div class="accordion-header py-3 px-4 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#callout_col___INDEX__">
                            <span class="fs-7 fw-bold text-gray-700">
                                <i class="bi bi-chat-square-quote me-2 text-primary"></i> Optional Highlight / Callout Box
                            </span>
                        </div>
                        <div id="callout_col___INDEX__" class="collapse px-4 pb-4">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fs-7 fw-bold">Callout Type</label>
                                    <select name="sections[__INDEX__][callout_type]" class="form-select form-select-sm form-select-solid section-callout-type">
                                        <option value="highlight">Highlight (Blue)</option>
                                        <option value="tip">Tip (Green)</option>
                                        <option value="quote">Quote (Purple)</option>
                                        <option value="info">Info</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label fs-7 fw-bold">Callout Title</label>
                                    <input type="text" name="sections[__INDEX__][callout_title]" class="form-control form-control-sm form-control-solid section-callout-title" placeholder="Clinical Fact" />
                                </div>
                                <div class="col-12">
                                    <label class="form-label fs-7 fw-bold">Callout Text</label>
                                    <textarea name="sections[__INDEX__][callout_text]" rows="2" class="form-control form-control-sm form-control-solid section-callout-text" placeholder="Quote or highlighted clinical finding..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bullet Points Accordion -->
                    <div class="mb-3 border rounded">
                        <div class="accordion-header py-3 px-4 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#bullets_col___INDEX__">
                            <span class="fs-7 fw-bold text-gray-700">
                                <i class="bi bi-list-check me-2 text-success"></i> Optional Bullet Points
                            </span>
                        </div>
                        <div id="bullets_col___INDEX__" class="collapse px-4 pb-4">
                            <label class="form-label fs-7 fw-bold">Bullet Points (One per line)</label>
                            <textarea name="sections[__INDEX__][bullet_points]" rows="3" class="form-control form-control-sm form-control-solid section-bullets-input" placeholder="Enter bullet points, one per line"></textarea>
                        </div>
                    </div>

                    <!-- Technical Specifications Table Accordion -->
                    <div class="border rounded">
                        <div class="accordion-header py-3 px-4 cursor-pointer" data-bs-toggle="collapse" data-bs-target="#data_col___INDEX__">
                            <span class="fs-7 fw-bold text-gray-700">
                                <i class="bi bi-table me-2 text-info"></i> Optional Specifications / Data Table
                            </span>
                        </div>
                        <div id="data_col___INDEX__" class="collapse px-4 pb-4">
                            <div class="mb-3">
                                <label class="form-label fs-7 fw-bold">Table Title</label>
                                <input type="text" name="sections[__INDEX__][data_title]" class="form-control form-control-sm form-control-solid section-data-title" placeholder="Technical Specifications" />
                            </div>
                            <div class="spec-rows-container d-flex flex-column gap-2 mb-2">
                                <!-- spec rows injected dynamically -->
                            </div>
                            <button type="button" class="btn btn-sm btn-light-primary btn-add-spec-row">
                                <i class="bi bi-plus me-1"></i> Add Spec Row
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Initial Existing Data JSON for JS injection -->
        <script>
            const existingSections = @json($blog->sections ?? []);
            const existingFaqs = @json($blog->faq ?? []);
            const existingProducts = @json($blog->related_products ?? []);
        </script>

        <!-- Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let sectionCount = 0;
                const sectionsContainer = document.getElementById('sections_container');
                const sectionTemplate = document.getElementById('section_template').innerHTML;

                function slugify(text) {
                    return text.toString().toLowerCase()
                        .replace(/\s+/g, '-')
                        .replace(/[^\w\-]+/g, '')
                        .replace(/\-\-+/g, '-')
                        .replace(/^-+/, '')
                        .replace(/-+$/, '');
                }

                function addSection(data = null) {
                    const index = sectionCount++;
                    let html = sectionTemplate
                        .replace(/__INDEX__/g, index)
                        .replace(/__NUM__/g, sectionsContainer.children.length + 1);

                    const div = document.createElement('div');
                    div.innerHTML = html;
                    const sectionEl = div.firstElementChild;

                    if (data) {
                        sectionEl.querySelector('.section-heading-input').value = data.heading || '';
                        sectionEl.querySelector('.section-title-preview').innerText = data.heading || 'New Content Section';
                        sectionEl.querySelector('.section-id-input').value = data.id || '';
                        sectionEl.querySelector('.section-subheading-input').value = data.subheading || '';

                        // Content (can be array of strings or string)
                        if (Array.isArray(data.content)) {
                            sectionEl.querySelector('.section-content-input').value = data.content.join("\n\n");
                        } else if (data.content) {
                            sectionEl.querySelector('.section-content-input').value = data.content;
                        }

                        // Callout
                        if (data.callout) {
                            sectionEl.querySelector('.section-callout-type').value = data.callout.type || 'highlight';
                            sectionEl.querySelector('.section-callout-title').value = data.callout.title || '';
                            sectionEl.querySelector('.section-callout-text').value = data.callout.text || '';
                            sectionEl.querySelector('#callout_col_' + index).classList.add('show');
                        }

                        // Bullets
                        if (data.bulletPoints && data.bulletPoints.length) {
                            sectionEl.querySelector('.section-bullets-input').value = data.bulletPoints.join("\n");
                            sectionEl.querySelector('#bullets_col_' + index).classList.add('show');
                        }

                        // Specs/Data table
                        if (data.codeOrData) {
                            sectionEl.querySelector('.section-data-title').value = data.codeOrData.title || '';
                            const specContainer = sectionEl.querySelector('.spec-rows-container');
                            if (Array.isArray(data.codeOrData.items)) {
                                data.codeOrData.items.forEach(item => {
                                    const row = document.createElement('div');
                                    row.className = 'row g-2 align-items-center';
                                    row.innerHTML = `
                                        <div class="col-5">
                                            <input type="text" name="sections[${index}][data_labels][]" class="form-control form-control-sm form-control-solid" value="${escapeHtml(item.label || '')}" placeholder="Label" />
                                        </div>
                                        <div class="col-6">
                                            <input type="text" name="sections[${index}][data_values][]" class="form-control form-control-sm form-control-solid" value="${escapeHtml(item.value || '')}" placeholder="Value" />
                                        </div>
                                        <div class="col-1 text-end">
                                            <button type="button" class="btn btn-sm btn-icon btn-light-danger btn-remove-spec-row"><i class="bi bi-x"></i></button>
                                        </div>
                                    `;
                                    specContainer.appendChild(row);
                                });
                            }
                            sectionEl.querySelector('#data_col_' + index).classList.add('show');
                        }
                    }

                    sectionsContainer.appendChild(sectionEl);
                    updateSectionNumbers();
                }

                function escapeHtml(text) {
                    return text.replace(/"/g, '&quot;');
                }

                function updateSectionNumbers() {
                    Array.from(sectionsContainer.children).forEach((el, idx) => {
                        const badge = el.querySelector('.section-badge');
                        if (badge) badge.innerText = `Section #${idx + 1}`;
                    });
                }

                // Add button clicks
                document.getElementById('btn_add_section').addEventListener('click', () => addSection());
                document.getElementById('btn_add_section_bottom').addEventListener('click', () => addSection());

                // Remove section & spec row delegation
                sectionsContainer.addEventListener('click', function (e) {
                    if (e.target.closest('.btn-remove-section')) {
                        const section = e.target.closest('.section-item');
                        if (sectionsContainer.children.length > 1) {
                            section.remove();
                            updateSectionNumbers();
                        } else {
                            alert('A blog must have at least one section.');
                        }
                    }

                    if (e.target.closest('.btn-add-spec-row')) {
                        const specContainer = e.target.closest('.collapse').querySelector('.spec-rows-container');
                        const index = e.target.closest('.section-item').dataset.index;
                        const row = document.createElement('div');
                        row.className = 'row g-2 align-items-center';
                        row.innerHTML = `
                            <div class="col-5">
                                <input type="text" name="sections[${index}][data_labels][]" class="form-control form-control-sm form-control-solid" placeholder="Label" />
                            </div>
                            <div class="col-6">
                                <input type="text" name="sections[${index}][data_values][]" class="form-control form-control-sm form-control-solid" placeholder="Value" />
                            </div>
                            <div class="col-1 text-end">
                                <button type="button" class="btn btn-sm btn-icon btn-light-danger btn-remove-spec-row"><i class="bi bi-x"></i></button>
                            </div>
                        `;
                        specContainer.appendChild(row);
                    }

                    if (e.target.closest('.btn-remove-spec-row')) {
                        const row = e.target.closest('.row');
                        row.remove();
                    }
                });

                // Auto slugify on title change or button click
                const titleInput = document.getElementById('blog_title');
                const slugInput = document.getElementById('blog_slug');

                document.getElementById('btn_generate_slug').addEventListener('click', function () {
                    if (titleInput.value) {
                        slugInput.value = slugify(titleInput.value);
                    }
                });

                // Auto anchor ID for section heading
                sectionsContainer.addEventListener('input', function (e) {
                    if (e.target.classList.contains('section-heading-input')) {
                        const item = e.target.closest('.section-item');
                        const preview = item.querySelector('.section-title-preview');
                        const idInput = item.querySelector('.section-id-input');
                        preview.innerText = e.target.value || 'New Content Section';
                        if (!idInput.value) {
                            idInput.value = slugify(e.target.value.replace(/^\d+\.\s*/, ''));
                        }
                    }
                });

                // Image preview
                const imageFileInput = document.getElementById('cover_image_file');
                const imageUrlInput = document.getElementById('cover_image_url');
                const previewImg = document.getElementById('cover_image_preview');
                const placeholder = document.getElementById('cover_image_placeholder');

                imageFileInput.addEventListener('change', function (e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewImg.src = e.target.result;
                            previewImg.style.display = 'block';
                            placeholder.style.display = 'none';
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });

                imageUrlInput.addEventListener('input', function () {
                    if (this.value) {
                        previewImg.src = this.value;
                        previewImg.style.display = 'block';
                        placeholder.style.display = 'none';
                    }
                });

                // Auto calculate read time
                document.getElementById('btn_calc_read_time').addEventListener('click', function () {
                    let totalText = titleInput.value;
                    document.querySelectorAll('textarea').forEach(t => totalText += ' ' + t.value);
                    const words = totalText.trim().split(/\s+/).length;
                    const mins = Math.max(1, Math.ceil(words / 200));
                    document.getElementById('blog_read_time').value = `${mins} min read`;
                });

                // Raw JSON mode toggle
                const jsonContainer = document.getElementById('json_mode_container');
                const toggleJsonBtn = document.getElementById('btn_toggle_json_mode');
                toggleJsonBtn.addEventListener('click', function () {
                    if (jsonContainer.classList.contains('d-none')) {
                        jsonContainer.classList.remove('d-none');
                        toggleJsonBtn.classList.remove('btn-light-info');
                        toggleJsonBtn.classList.add('btn-info');
                    } else {
                        jsonContainer.classList.add('d-none');
                        toggleJsonBtn.classList.remove('btn-info');
                        toggleJsonBtn.classList.add('btn-light-info');
                    }
                });

                // FAQ Dynamic Rows
                const faqContainer = document.getElementById('faq_container');
                let faqIndex = 0;
                function addFaqRow(q = '', a = '') {
                    const idx = faqIndex++;
                    const card = document.createElement('div');
                    card.className = 'border rounded p-3 bg-light';
                    card.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold fs-7 text-dark">FAQ #${idx + 1}</span>
                            <button type="button" class="btn btn-icon btn-sm btn-light-danger" onclick="this.closest('.border').remove()"><i class="bi bi-x"></i></button>
                        </div>
                        <input type="text" name="faqs[${idx}][question]" class="form-control form-control-sm form-control-solid mb-2" value="${escapeHtml(q)}" placeholder="Question" />
                        <textarea name="faqs[${idx}][answer]" rows="2" class="form-control form-control-sm form-control-solid" placeholder="Answer">${q ? escapeHtml(a) : ''}</textarea>
                    `;
                    faqContainer.appendChild(card);
                }
                document.getElementById('btn_add_faq').addEventListener('click', () => addFaqRow());

                // Related Products Dynamic Rows
                const productsContainer = document.getElementById('products_container');
                let productIndex = 0;
                function addProductRow(p = null) {
                    const idx = productIndex++;
                    const card = document.createElement('div');
                    card.className = 'border rounded p-3 bg-light';
                    card.innerHTML = `
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold fs-7 text-dark">Product #${idx + 1}</span>
                            <button type="button" class="btn btn-icon btn-sm btn-light-danger" onclick="this.closest('.border').remove()"><i class="bi bi-x"></i></button>
                        </div>
                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <input type="text" name="related_products[${idx}][name]" class="form-control form-control-sm form-control-solid" value="${p ? escapeHtml(p.name || '') : ''}" placeholder="Product Name" />
                            </div>
                            <div class="col-6">
                                <input type="text" name="related_products[${idx}][slug]" class="form-control form-control-sm form-control-solid" value="${p ? escapeHtml(p.slug || '') : ''}" placeholder="Slug" />
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="text" name="related_products[${idx}][category]" class="form-control form-control-sm form-control-solid" value="${p ? escapeHtml(p.category || 'Cosmetics') : 'Cosmetics'}" placeholder="Category" />
                            </div>
                            <div class="col-6">
                                <input type="text" name="related_products[${idx}][image]" class="form-control form-control-sm form-control-solid" value="${p ? escapeHtml(p.image || '') : ''}" placeholder="Image path (/products/...)" />
                            </div>
                        </div>
                    `;
                    productsContainer.appendChild(card);
                }
                document.getElementById('btn_add_product').addEventListener('click', () => addProductRow());

                // Populate Existing Data
                if (existingSections && existingSections.length) {
                    existingSections.forEach(s => addSection(s));
                } else {
                    addSection();
                }

                if (existingFaqs && existingFaqs.length) {
                    existingFaqs.forEach(f => addFaqRow(f.question, f.answer));
                }

                if (existingProducts && existingProducts.length) {
                    existingProducts.forEach(p => addProductRow(p));
                }
            });
        </script>
    @endsection
</x-admin-layout>
