<x-admin-layout>
    @section('content')
        <style>
            .plans-container {
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
            }

            .custom-card {
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
                border: none;
                background: #ffffff;
            }

            .form-label {
                font-weight: 600;
                color: #334155;
                font-size: 13px;
                margin-bottom: 6px;
            }

            .form-control, .form-select {
                border-radius: 10px;
                border: 1px solid #e2e8f0;
                padding: 10px 14px;
                font-size: 14px;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            .form-control:focus, .form-select:focus {
                border-color: #650ea4;
                box-shadow: 0 0 0 3px rgba(101, 14, 164, 0.1);
            }

            .btn-save-custom {
                background: linear-gradient(135deg, #650ea4 0%, #8b25da 100%);
                color: #ffffff !important;
                border-radius: 10px;
                padding: 10px 24px;
                font-weight: 600;
                border: none;
                transition: all 0.2s ease;
                box-shadow: 0 4px 12px rgba(101, 14, 164, 0.2);
            }

            .btn-save-custom:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 18px rgba(101, 14, 164, 0.3);
            }

            .section-header {
                font-size: 15px;
                font-weight: 700;
                color: #1e293b;
                border-bottom: 1px solid #f1f5f9;
                padding-bottom: 8px;
                margin-bottom: 16px;
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid plans-container">
            <!-- Toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Edit Subscription Plan: {{ $plan->name }}
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.subscription-plans.index') }}" class="text-muted text-hover-primary">Subscription Plans</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Edit</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-sm btn-light">
                            <i class="bi bi-arrow-left me-1"></i> Back to Plans
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="app-content flex-column-fluid">
                <div class="app-container container-xxl">

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show p-4 mb-5" role="alert">
                            <h5 class="mb-2">Please fix the following errors:</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.subscription-plans.update', $plan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-6">
                            <!-- Left Column: Main Plan Details -->
                            <div class="col-lg-8">
                                <div class="card custom-card p-6 mb-6">
                                    <div class="section-header">Basic Information</div>

                                    <div class="row g-4 mb-4">
                                        <div class="col-md-7">
                                            <label class="form-label required">Plan Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $plan->name) }}" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Badge / Pill (optional)</label>
                                            <input type="text" name="badge" class="form-control" value="{{ old('badge', $plan->badge) }}">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Tagline / Subtitle</label>
                                            <input type="text" name="tagline" class="form-control" value="{{ old('tagline', $plan->tagline) }}">
                                        </div>
                                    </div>

                                    <div class="section-header mt-6">Pricing & Billing</div>
                                    <div class="row g-4 mb-4">
                                        <div class="col-md-4">
                                            <label class="form-label required">Price ($)</label>
                                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $plan->price) }}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Currency Symbol</label>
                                            <input type="text" name="currency" class="form-control" value="{{ old('currency', $plan->currency ?? '$') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label required">Billing Period</label>
                                            <select name="billing_period" class="form-select">
                                                <option value="mo" {{ old('billing_period', $plan->billing_period) == 'mo' ? 'selected' : '' }}>Monthly (/mo)</option>
                                                <option value="yr" {{ old('billing_period', $plan->billing_period) == 'yr' ? 'selected' : '' }}>Yearly (/yr)</option>
                                                <option value="quarter" {{ old('billing_period', $plan->billing_period) == 'quarter' ? 'selected' : '' }}>Quarterly (/quarter)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="section-header mt-6">Call to Action (Button)</div>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label">Button Text</label>
                                            <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $plan->button_text) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Button URL / Link</label>
                                            <input type="text" name="button_link" class="form-control" value="{{ old('button_link', $plan->button_link) }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Features List Card -->
                                <div class="card custom-card p-6">
                                    <div class="section-header d-flex justify-content-between align-items-center">
                                        <span>Display Features (Bullet Points)</span>
                                        <span class="text-muted fs-8 fw-normal">One feature per line</span>
                                    </div>

                                    <div class="mb-3">
                                        <textarea name="features" rows="7" class="form-control">{{ old('features', $plan->features_text) }}</textarea>
                                        <div class="form-text text-muted fs-8 mt-2">
                                            <i class="bi bi-info-circle me-1"></i> Each new line will be displayed with a green checkmark on the pricing card preview.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Settings & Limits -->
                            <div class="col-lg-4">
                                <div class="card custom-card p-6 mb-6">
                                    <div class="section-header">Plan Status & Highlight</div>

                                    <div class="form-check form-switch mb-4">
                                        <input class="form-check-input" type="checkbox" name="is_popular" id="is_popular" value="1" {{ old('is_popular', $plan->is_popular) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-dark" for="is_popular">
                                            Featured / Most Popular
                                        </label>
                                        <div class="form-text fs-8 text-muted">Highlights card with purple border & solid button.</div>
                                    </div>

                                    <div class="form-check form-switch mb-4">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold text-dark" for="is_active">
                                            Active (Visible on Frontend)
                                        </label>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Sort Order</label>
                                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $plan->sort_order) }}">
                                        <div class="form-text fs-8 text-muted">Lower numbers appear first (e.g. 1, 2, 3).</div>
                                    </div>
                                </div>

                                <div class="card custom-card p-6 mb-6">
                                    <div class="section-header">Structured Limits</div>

                                    <div class="mb-3">
                                        <label class="form-label required">LLM Prompts Limit</label>
                                        <input type="number" name="llm_prompts" class="form-control" value="{{ old('llm_prompts', $plan->llm_prompts) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Keyword Ranking Frequency</label>
                                        <input type="text" name="keyword_ranking" class="form-control" placeholder="e.g. Monthly, Weekly" value="{{ old('keyword_ranking', $plan->keyword_ranking) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Blog Posts Count</label>
                                        <input type="text" name="blog_posts" class="form-control" placeholder="e.g. 1–3, 5, 10" value="{{ old('blog_posts', $plan->blog_posts) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">Backlink Checks</label>
                                        <input type="text" name="backlink_checks" class="form-control" placeholder="e.g. 1×, 2×" value="{{ old('backlink_checks', $plan->backlink_checks) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">New Pages Suggested</label>
                                        <input type="text" name="new_pages" class="form-control" placeholder="e.g. 3, 5, 7" value="{{ old('new_pages', $plan->new_pages) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label required">AI Engines Count</label>
                                        <input type="number" name="ai_engines_count" class="form-control" value="{{ old('ai_engines_count', $plan->ai_engines_count ?? 6) }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-column gap-2">
                                    <button type="submit" class="btn-save-custom w-100">
                                        <i class="bi bi-check-lg me-1"></i> Update Subscription Plan
                                    </button>
                                    <a href="{{ route('admin.subscription-plans.index') }}" class="btn btn-light w-100">
                                        Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
