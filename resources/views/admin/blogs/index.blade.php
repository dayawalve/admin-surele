<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <!-- Toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Blog Articles & Insights
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Blogs</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-sm fw-bold btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Add New Blog
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">

                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center p-5 mb-6">
                            <i class="bi bi-check-circle-fill fs-2hx text-success me-4"></i>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center p-5 mb-6">
                            <i class="bi bi-exclamation-triangle-fill fs-2hx text-danger me-4"></i>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Metric Cards -->
                    <div class="row g-5 g-xl-8 mb-6">
                        <div class="col-sm-6 col-xl-3">
                            <div class="card card-bordered shadow-sm bg-light-primary">
                                <div class="card-body p-6 d-flex align-items-center">
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label bg-primary text-white">
                                            <i class="bi bi-journal-richtext fs-2 text-white"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fs-3 fw-bolder text-dark">{{ $totalBlogs ?? 0 }}</div>
                                        <div class="fs-7 text-muted fw-semibold">Total Articles</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card card-bordered shadow-sm bg-light-success">
                                <div class="card-body p-6 d-flex align-items-center">
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label bg-success text-white">
                                            <i class="bi bi-check2-circle fs-2 text-white"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fs-3 fw-bolder text-dark">{{ $publishedCount ?? 0 }}</div>
                                        <div class="fs-7 text-muted fw-semibold">Published Live</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card card-bordered shadow-sm bg-light-warning">
                                <div class="card-body p-6 d-flex align-items-center">
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label bg-warning text-white">
                                            <i class="bi bi-star-fill fs-2 text-white"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fs-3 fw-bolder text-dark">{{ $featuredCount ?? 0 }}</div>
                                        <div class="fs-7 text-muted fw-semibold">Featured on Home</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xl-3">
                            <div class="card card-bordered shadow-sm bg-light-info">
                                <div class="card-body p-6 d-flex align-items-center">
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label bg-info text-white">
                                            <i class="bi bi-file-earmark-text fs-2 text-white"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fs-3 fw-bolder text-dark">{{ $draftCount ?? 0 }}</div>
                                        <div class="fs-7 text-muted fw-semibold">Drafts</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Table Card -->
                    <div class="card shadow-sm border border-gray-200">
                        <!-- Card Header & Filter Bar -->
                        <div class="card-header border-0 pt-6">
                            <form action="{{ route('admin.blogs.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-3 w-100 justify-content-between">
                                <div class="d-flex align-items-center position-relative my-1 flex-grow-1" style="max-width: 380px;">
                                    <i class="bi bi-search position-absolute ms-4 text-gray-500 fs-4"></i>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control form-control-solid ps-12"
                                        placeholder="Search title, category, author..." />
                                </div>

                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    <!-- Category Filter -->
                                    <select name="category" class="form-select form-select-solid w-auto" onchange="this.form.submit()">
                                        <option value="">All Categories</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat['slug'] }}" {{ request('category') == $cat['slug'] ? 'selected' : '' }}>
                                                {{ $cat['name'] }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <!-- Status Filter -->
                                    <select name="status" class="form-select form-select-solid w-auto" onchange="this.form.submit()">
                                        <option value="">All Status</option>
                                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>

                                    <!-- Featured Filter -->
                                    <select name="featured" class="form-select form-select-solid w-auto" onchange="this.form.submit()">
                                        <option value="">Featured: Any</option>
                                        <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Featured Only</option>
                                        <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Non-Featured</option>
                                    </select>

                                    <button type="submit" class="btn btn-light-primary">Filter</button>

                                    @if(request()->anyFilled(['search', 'category', 'status', 'featured']))
                                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-light-danger" title="Clear filters">
                                            <i class="bi bi-x-circle me-1"></i> Reset
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Card Body: Table -->
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-4 mb-0" id="kt_blogs_table">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0 border-bottom border-gray-200">
                                            <th style="width: 45px;" class="ps-2">#</th>
                                            <th style="min-width: 300px; max-width: 420px;">Article & Details</th>
                                            <th style="width: 140px;">Category</th>
                                            <th style="width: 170px;">Author</th>
                                            <th style="width: 130px;">Published</th>
                                            <th style="width: 80px;" class="text-center">Featured</th>
                                            <th style="width: 95px;" class="text-center">Status</th>
                                            <th style="width: 100px;" class="text-end pe-2">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-700 fw-semibold">
                                        @forelse($blogs as $blog)
                                            <tr>
                                                <td class="ps-2 text-muted fs-7">
                                                    {{ $loop->iteration + ($blogs->currentPage() - 1) * $blogs->perPage() }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="max-width: 420px;">
                                                        <!-- Fixed 54px thumbnail box with strict boundaries -->
                                                        <div class="me-3 position-relative" style="width: 54px; height: 54px; min-width: 54px; max-width: 54px; border-radius: 8px; overflow: hidden; background: #f8fafc; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                            @if($blog->cover_image)
                                                                <img src="{{ $blog->cover_image_url }}" alt="{{ $blog->title }}"
                                                                    style="width: 54px; height: 54px; max-width: 54px; max-height: 54px; object-fit: contain; display: block;"
                                                                    onerror="this.onerror=null; this.src='{{ url('/public/custom-img/surele_icon.png') }}'; this.style.padding='4px';" />
                                                            @else
                                                                <i class="bi bi-journal-text text-primary fs-3"></i>
                                                            @endif
                                                        </div>

                                                        <!-- Text content with ellipsis preventing wrap explosion -->
                                                        <div class="d-flex flex-column overflow-hidden" style="min-width: 0;">
                                                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-gray-900 text-hover-primary fw-bold fs-7 mb-1 text-truncate d-block" title="{{ $blog->title }}" style="line-height: 1.35;">
                                                                {{ $blog->title }}
                                                            </a>
                                                            <div class="d-flex align-items-center gap-1">
                                                                <span class="badge badge-light text-muted fw-semibold text-truncate" style="font-size: 11px; max-width: 250px;">
                                                                    /blog/{{ $blog->slug }}
                                                                </span>
                                                            </div>
                                                            @if(!empty($blog->subtitle))
                                                                <span class="text-muted text-truncate mt-1" style="max-width: 320px; font-size: 11px;">
                                                                    {{ $blog->subtitle }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @php
                                                        $badgeColor = match($blog->category_slug) {
                                                            'cosmetic' => 'badge-light-primary text-primary',
                                                            'ayurvedic' => 'badge-light-success text-success',
                                                            'private-label' => 'badge-light-warning text-warning',
                                                            'natural-care' => 'badge-light-info text-info',
                                                            'export' => 'badge-light-dark text-dark',
                                                            'home-care' => 'badge-light-secondary text-gray-700',
                                                            default => 'badge-light-primary text-primary'
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $badgeColor }} fs-8 fw-bold px-2.5 py-1.5" style="white-space: nowrap;">
                                                        {{ $blog->category }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center" style="min-width: 140px;">
                                                        <div class="symbol symbol-30px symbol-circle bg-light-primary text-primary fw-bold me-2 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px; min-width: 32px;">
                                                            <span style="font-size: 11px;">{{ $blog->author_avatar_text ?: 'ST' }}</span>
                                                        </div>
                                                        <div class="d-flex flex-column text-truncate" style="min-width: 0;">
                                                            <span class="text-gray-900 fw-bold fs-7 text-truncate">{{ $blog->author_name ?: 'Surele Team' }}</span>
                                                            <span class="text-muted text-truncate" style="font-size: 11px;">{{ Str::limit($blog->author_role, 22) }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column" style="white-space: nowrap;">
                                                        <span class="text-gray-900 fs-7 fw-semibold">{{ $blog->published_at ?: $blog->created_at->format('M d, Y') }}</span>
                                                        <span class="text-muted" style="font-size: 11px;">
                                                            <i class="bi bi-clock me-1 text-primary"></i>{{ $blog->read_time ?: '5 min' }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('admin.blogs.toggle-featured', $blog->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-icon {{ $blog->featured ? 'btn-light-warning' : 'btn-light-secondary' }}" style="width: 32px; height: 32px;" title="{{ $blog->featured ? 'Featured on Home (Click to remove)' : 'Not featured (Click to feature)' }}">
                                                            <i class="bi {{ $blog->featured ? 'bi-star-fill text-warning' : 'bi-star text-muted' }} fs-6"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="text-center">
                                                    <form action="{{ route('admin.blogs.toggle-status', $blog->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="badge {{ $blog->status === 'published' ? 'badge-light-success text-success' : 'badge-light-secondary text-gray-700' }} border-0 cursor-pointer px-2.5 py-1.5" style="font-size: 11px;" title="Click to toggle status">
                                                            <span class="bullet bullet-dot {{ $blog->status === 'published' ? 'bg-success' : 'bg-secondary' }} me-1"></span>
                                                            {{ ucfirst($blog->status) }}
                                                        </button>
                                                    </form>
                                                </td>
                                                <td class="text-end pe-2">
                                                    <div class="d-flex justify-content-end gap-1">
                                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-icon btn-light-primary btn-sm" style="width: 32px; height: 32px;" title="Edit Article">
                                                            <i class="bi bi-pencil-square fs-6"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-icon btn-light-danger btn-sm" style="width: 32px; height: 32px;" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $blog->id }}" title="Delete">
                                                            <i class="bi bi-trash fs-6"></i>
                                                        </button>
                                                    </div>

                                                    <!-- Delete Confirmation Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $blog->id }}" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content text-start">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title fw-bold">Delete Blog Article</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body py-4">
                                                                    <p class="text-gray-700 fs-6 mb-2">Are you sure you want to delete this blog post?</p>
                                                                    <p class="fw-bold text-dark fs-6">{{ $blog->title }}</p>
                                                                    <div class="alert alert-warning d-flex align-items-center p-3 mb-0">
                                                                        <i class="bi bi-exclamation-triangle-fill fs-3 text-warning me-2"></i>
                                                                        <span class="fs-7">This action cannot be undone and will remove the article from the website.</span>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-10">
                                                    <div class="d-flex flex-column align-items-center">
                                                        <i class="bi bi-journal-x fs-3x text-muted mb-3"></i>
                                                        <div class="fs-5 fw-bold text-gray-700">No blog articles found</div>
                                                        <div class="fs-7 text-muted mb-4">Get started by creating your first dynamic blog article!</div>
                                                        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm">
                                                            <i class="bi bi-plus-circle me-1"></i> Create Blog
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-between align-items-center flex-wrap pt-4">
                                <div class="fs-7 text-muted">
                                    Showing {{ $blogs->firstItem() ?? 0 }} to {{ $blogs->lastItem() ?? 0 }} of {{ $blogs->total() }} articles
                                </div>
                                <div>
                                    {{ $blogs->links() }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
