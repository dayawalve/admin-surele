<x-admin-layout>
    @section('content')
        <style>
            .form-card {
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
                border: 1px solid #f1f5f9;
                background: #ffffff;
            }

            .form-title {
                font-size: 20px;
                font-weight: 700;
                color: #0f172a;
                letter-spacing: -0.02em;
            }

            .form-label {
                font-weight: 600;
                font-size: 13px;
                color: #475569;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }

            .form-control-solid {
                border-radius: 10px !important;
                padding: 12px 16px;
                border: 1px solid #e2e8f0;
                background-color: #f8fafc !important;
                font-weight: 500;
                color: #1e293b;
                transition: all 0.2s ease;
            }

            .permission-switch-card {
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 16px 18px;
                background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
                display: flex;
                align-items: center;
                justify-content: space-between;
                transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            }

            .permission-switch-card:hover {
                border-color: #3b82f6;
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(59, 130, 246, 0.08);
                background: #ffffff;
            }

            /* Accordion Tree Styling */
            .perm-section-card {
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                background-color: #ffffff;
                margin-bottom: 20px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(15, 23, 42, 0.03);
                transition: all 0.2s ease;
            }

            .perm-section-card:hover {
                box-shadow: 0 6px 20px rgba(15, 23, 42, 0.06);
            }

            .perm-section-header {
                background: linear-gradient(90deg, #f8fafc 0%, #f1f5f9 100%);
                border-bottom: 1px solid #e2e8f0;
                padding: 16px 22px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .perm-section-title {
                font-size: 16px;
                font-weight: 700;
                color: #0f172a;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .perm-group-box {
                background-color: #ffffff;
                border-bottom: 1px solid #f1f5f9;
                padding: 16px 22px;
            }

            .perm-group-box:last-child {
                border-bottom: none;
            }

            .perm-group-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 12px;
                padding-bottom: 8px;
                border-bottom: 1px dashed #e2e8f0;
            }

            .perm-group-title {
                font-size: 13px;
                font-weight: 700;
                color: #475569;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .route-tile {
                display: flex;
                align-items: center;
                padding: 10px 14px;
                border-radius: 10px;
                border: 1px solid #f1f5f9;
                background-color: #fafafa;
                transition: all 0.2s ease;
                height: 100%;
            }

            .route-tile:hover {
                background-color: #f0fdf4;
                border-color: #bbf7d0;
            }

            .route-tile.has-active {
                background-color: #ffffff;
                border-color: #cbd5e1;
            }

            .badge-route {
                background-color: #f1f5f9;
                color: #64748b;
                font-family: monospace;
                font-size: 11px;
                padding: 2px 6px;
                border-radius: 4px;
                margin-top: 2px;
            }

            .toggle-pill {
                user-select: none;
            }

            .form-check-input {
                cursor: pointer;
            }

            .form-check-input:checked {
                background-color: #10b981 !important;
                border-color: #10b981 !important;
            }

            .cursor-pointer {
                cursor: pointer;
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Edit Brand Permissions
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.brand_permissions.index') }}" class="text-muted text-hover-primary">Brand Permissions</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Edit</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">
                    <div class="card form-card">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <span class="form-title">
                                    Permissions for {{ $brand->brand_name ?? 'N/A' }} ({{ $user->username }})
                                </span>
                            </div>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('admin.brand_permissions.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- User Info Read-Only -->
                                <div class="row mb-6">
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label mb-1">Client Name</label>
                                        <input type="text" class="form-control form-control-solid bg-light" value="{{ $user->username }}" readonly />
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label mb-1">Email Address</label>
                                        <input type="text" class="form-control form-control-solid bg-light" value="{{ $user->email }}" readonly />
                                    </div>
                                </div>

                                <div class="separator separator-dashed my-6"></div>

                                <!-- Permission Toggles Grid -->
                                <div class="d-flex justify-content-between align-items-center mb-6">
                                    <h3 class="fs-5 fw-bold text-gray-800 m-0">Enable / Disable Features</h3>
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input h-20px w-20px" type="checkbox" id="selectAllPermissions" />
                                        <label class="form-check-label fw-bold text-gray-700 ms-2 cursor-pointer" for="selectAllPermissions">Select All</label>
                                    </div>
                                </div>
                                
                                <div class="row g-4 mb-8">
                                    @php
                                        $switches = [
                                            ['label' => 'SEO Audit Module', 'key' => 'has_seo', 'desc' => 'Enables Technical and On-Page SEO checklists.'],
                                            ['label' => 'AEO / AI Search', 'key' => 'has_aeo', 'desc' => 'Enables AI Insights, LLM Prompts and Citation overview.'],
                                            ['label' => 'Google Business Profile', 'key' => 'has_gbp', 'desc' => 'Enables Google Maps and Reviews integration.'],
                                            ['label' => 'Content Engines', 'key' => 'has_content_engines', 'desc' => 'Enables suggestions, outlines, and blog generators.'],
                                            ['label' => 'Insight Hub', 'key' => 'has_insights', 'desc' => 'Enables scorecard downloads and report generation.'],
                                            ['label' => 'Analytics Suite', 'key' => 'has_analytics_suite', 'desc' => 'Enables Google Analytics and search console dashboard.'],
                                            ['label' => 'Heatmap Website', 'key' => 'has_heatmap', 'desc' => 'Enables user click heatmaps.'],
                                            ['label' => 'Uptime Monitoring', 'key' => 'has_monitoring', 'desc' => 'Enables server ping/SSL expiry checks.'],
                                            ['label' => 'Competitive Intelligence', 'key' => 'has_competitive_intel', 'desc' => 'Enables competitor content/link tracking.'],
                                        ];
                                    @endphp

                                    @foreach ($switches as $sw)
                                        @php
                                            $checked = $permissions ? $permissions->{$sw['key']} : false;
                                        @endphp
                                        <div class="col-md-6 col-lg-4">
                                            <div class="permission-switch-card">
                                                <div class="me-3">
                                                    <span class="fs-6 fw-bold text-gray-800 d-block">{{ $sw['label'] }}</span>
                                                    <span class="fs-7 text-muted">{{ $sw['desc'] }}</span>
                                                </div>
                                                <div class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input h-20px w-35px permission-checkbox" type="checkbox" 
                                                           name="{{ $sw['key'] }}" id="{{ $sw['key'] }}"
                                                           value="1" {{ $checked ? 'checked' : '' }} />
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="separator separator-dashed my-8"></div>

                                <!-- 🔷 NESTED CHECKBOX TREE FOR INDIVIDUAL TABS 🔷 -->
                                @php
                                    $menuTree = [
                                        'Deck Creation' => [
                                            'Deck Creation' => [
                                                '/dashboard/deck-report-gamma' => 'Deck Creation',
                                            ],
                                        ],
                                        'SEO Module' => [
                                            'SEO Overview' => [
                                                '/dashboard/seo-overview' => 'Dashboard',
                                                '/dashboard/seo-scores' => 'SEO Scores',
                                            ],
                                            'Technical SEO' => [
                                                '/dashboard/crawl-data' => 'Crawl Data',
                                                '/dashboard/seo-errors' => 'Broken Links',
                                                '/dashboard/canonical' => 'Canonical',
                                                '/dashboard/site-analysis' => 'Site Analysis',
                                                '/dashboard/technical-issues' => 'Technical Issue',
                                                '/dashboard/schema-analysis' => 'Schema Markup',
                                                '/dashboard/depth-analysis' => 'Depth Analysis',
                                            ],
                                            'On-Page SEO' => [
                                                '/dashboard/meta-tags' => 'Meta Tags',
                                                '/dashboard/headings' => 'Headings',
                                                '/dashboard/content-analysis' => 'Content',
                                                '/dashboard/image-alt' => 'Image ALT Tags',
                                                '/dashboard/page-analysis' => 'All Pages',
                                            ],
                                            'Performance' => [
                                                '/dashboard/performance' => 'Mobile / Desktop / CWV',
                                            ],
                                            'Keywords' => [
                                                '/dashboard/keyword-ranking' => 'Keyword Ranking',
                                            ],
                                            'SEO Backlink Tracker' => [
                                                '/dashboard/seo-backlink-tracker' => 'SEO Backlink Tracker',
                                            ],
                                            'Failures' => [
                                                '/dashboard/seo-failures' => 'All Issues',
                                            ],
                                            'Implementation Status' => [
                                                '/dashboard/fix-status' => 'Fix Status',
                                            ],
                                        ],
                                        'AEO Module' => [
                                            'AI Insights' => [
                                                '/dashboard/seo-recommendations' => 'Recommendations',
                                                '/dashboard/seo-faqs' => 'FAQs',
                                            ],
                                            'LLM Prompts' => [
                                                '/dashboard/llm-prompts' => 'AI Engine Prompts',
                                            ],
                                            'AEO Visibility' => [
                                                '/dashboard/ai-visibility' => 'Overview',
                                                '/dashboard/ai-citation' => 'Citations',
                                                '/dashboard/competitors' => 'Competitors',
                                                '/dashboard/aeo-sentiment' => 'Sentiment',
                                                '/dashboard/aeo-scores' => 'AEO Scores',
                                                '/dashboard/aeo-trend-analysis' => 'Trends',
                                                '/dashboard/aeo-internal-links' => 'Internal Links',
                                                '/dashboard/share-of-voice' => 'Share of Voice',
                                            ],
                                        ],
                                        'Google Business Profile' => [
                                            'GBP Overview' => [
                                                '/dashboard/googlebusinessprofile' => 'Dashboard',
                                                '/dashboard/gbp-profile-audit' => 'Profile Audit',
                                                '/dashboard/gbp-analytics' => 'GBP Analytics',
                                                '/dashboard/gbp-reviews' => 'Reviews',
                                            ],
                                            'AI Suggestions' => [
                                                '/dashboard/gbp-ai-insights' => 'AI Insights',
                                                '/dashboard/gbp-pages' => 'Pages',
                                                '/dashboard/gbp-post-planner' => 'Post Planner',
                                                '/dashboard/gbp-ai-replies' => 'AI Reply',
                                                '/dashboard/gbp-action' => 'Action',
                                            ],
                                            'Summary' => [
                                                '/dashboard/gbp-rankings' => 'Ranking',
                                                '/dashboard/gbp-competitors' => 'Competitors',
                                                '/dashboard/gbp-entity' => 'Entity',
                                                '/dashboard/gbp-report' => 'Report',
                                            ],
                                            'GBP Checks' => [
                                                '/dashboard/gbp-spam-check' => 'Spam Check',
                                                '/dashboard/gbp-geo-grid' => 'Geo Grid',
                                            ],
                                        ],
                                        'Content Engines' => [
                                            'Content' => [
                                                '/dashboard/content-suggestions' => 'Content Suggestions',
                                                '/dashboard/brand-intelligence' => 'Brand Intelligence',
                                                '/dashboard/blog-ideas' => 'Blog Ideas',
                                            ],
                                            'Strategy' => [
                                                '/dashboard/six-month-plan' => '6-Month Plan',
                                                '/dashboard/backlinks' => 'Backlinks',
                                                '/dashboard/internal-linking' => 'Internal Linking',
                                                '/dashboard/new-page-suggestions' => 'New Page',
                                            ],
                                        ],
                                        'Insight Hub' => [
                                            'Reports' => [
                                                '/dashboard/scorecard' => 'SEO Scorecard',
                                                '/dashboard/generated-files' => 'Generated Files',
                                                '/dashboard/Monthlyreportpage' => 'Monthly Report',
                                                '/dashboard/audit-excel' => 'Audit Excel',
                                            ],
                                            'Analytics' => [
                                                '/dashboard/analytics-dashboard' => 'Dashboard',
                                                '/dashboard/audit-summary' => 'Audit Summary',
                                            ],
                                            'Keyword Planner' => [
                                                '/dashboard/keyword-planner' => 'Keyword Planner',
                                                '/dashboard/keywords' => 'AI Keywords',
                                                '/dashboard/keyword-mapping' => 'URL Mapping',
                                            ],
                                        ],
                                        'Analytics Suite' => [
                                            'Analytics' => [
                                                '/dashboard/googleanalytics' => 'Google Analytics',
                                                '/dashboard/chatbot' => 'Chat Bot (Buddy AI)',
                                                '/dashboard/googlesearchconsole' => 'Google Search Console',
                                                '/dashboard/indexing' => 'Indexing',
                                            ],
                                        ],
                                        'Other Tools' => [
                                            'Tools' => [
                                                '/dashboard/heatmap' => 'Heatmap Website',
                                                '/dashboard/uptimemonitoring' => 'Uptime Monitoring',
                                            ],
                                            'AI Competitive' => [
                                                '/dashboard/ai-competitive-intelligence' => 'AI Competitive & Page Intelligence',
                                                '/dashboard/ai-competitive-intelligence/dashboard' => 'Intelligence Dashboard',
                                            ]
                                        ]
                                    ];
                                @endphp

                                <div class="d-flex align-items-center justify-content-between mb-6">
                                    <div>
                                        <h3 class="fs-4 fw-bold text-gray-900 m-0">Manage Individual Tab Visibility</h3>
                                        <p class="text-muted fs-7 m-0">Enable or disable specific sidebar routes for this client</p>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($menuTree as $sectionName => $groups)
                                        <div class="col-12">
                                            <div class="perm-section-card tree-card">
                                                <!-- Section Header -->
                                                <div class="perm-section-header">
                                                    <div class="perm-section-title">
                                                        <i class="bi bi-grid-fill text-primary fs-5"></i>
                                                        <span>{{ $sectionName }}</span>
                                                    </div>
                                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input h-20px w-35px section-checkbox" type="checkbox" data-section="{{ Str::slug($sectionName) }}" checked />
                                                        <label class="form-check-label fw-bold fs-7 text-gray-700 ms-2 cursor-pointer">Select All Section</label>
                                                    </div>
                                                </div>

                                                <!-- Section Groups -->
                                                <div class="perm-section-body" id="section-{{ Str::slug($sectionName) }}">
                                                    @foreach ($groups as $groupName => $items)
                                                        @php
                                                            $isSingleSelfGroup = (count($groups) === 1 && $groupName === $sectionName);
                                                        @endphp
                                                        <div class="perm-group-box group-container">
                                                            <!-- Group Header (Hidden if Section has only 1 group with the same name) -->
                                                            @if (!$isSingleSelfGroup)
                                                                <div class="perm-group-header">
                                                                    <span class="perm-group-title">{{ $groupName }}</span>
                                                                    <div class="form-check form-check-custom form-check-solid">
                                                                        <input class="form-check-input h-16px w-16px group-checkbox" type="checkbox" checked />
                                                                        <label class="form-check-label fw-semibold fs-8 text-muted ms-2 cursor-pointer">Toggle Group</label>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            <!-- Group Items -->
                                                            <div class="perm-group-body">
                                                                <div class="row g-3">
                                                                    @foreach ($items as $route => $label)
                                                                        @php
                                                                            $isEnabled = !($permissions && isset($permissions->disabled_routes) && is_array($permissions->disabled_routes) && in_array($route, $permissions->disabled_routes));
                                                                        @endphp
                                                                        <div class="col-md-6 col-lg-4">
                                                                            <div class="route-tile">
                                                                                <div class="form-check form-check-custom form-check-solid w-100 align-items-center">
                                                                                    <input class="form-check-input h-18px w-18px route-checkbox me-3" type="checkbox" 
                                                                                           name="enabled_routes[]" value="{{ $route }}" 
                                                                                           {{ $isEnabled ? 'checked' : '' }} />
                                                                                    <div class="flex-grow-1">
                                                                                        <span class="fw-bold fs-7 text-gray-800 d-block">{{ $label }}</span>
                                                                                        <span class="badge-route d-inline-block">{{ $route }}</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="separator separator-dashed my-8"></div>

                                <!-- Form Actions -->
                                <div class="d-flex justify-content-end gap-3">
                                    <a href="{{ route('admin.brand_permissions.index') }}" class="btn btn-light">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary bg-primary">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // ── 1. Select All (Feature Switches) ──
                const selectAllCheckbox = document.getElementById('selectAllPermissions');
                const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');

                function updateSelectAllState() {
                    const allChecked = Array.from(permissionCheckboxes).every(cb => cb.checked);
                    selectAllCheckbox.checked = allChecked;
                }

                selectAllCheckbox.addEventListener('change', function() {
                    permissionCheckboxes.forEach(cb => {
                        cb.checked = selectAllCheckbox.checked;
                    });
                });

                permissionCheckboxes.forEach(cb => {
                    cb.addEventListener('change', updateSelectAllState);
                });

                updateSelectAllState();

                // ── 2. Tree Collapsible / Parent-Child Checkbox State Propagation ──
                // Group Toggle Checkboxes
                document.querySelectorAll('.group-checkbox').forEach(parentCb => {
                    parentCb.addEventListener('change', function() {
                        const isChecked = this.checked;
                        const groupContainer = this.closest('.group-container');
                        groupContainer.querySelectorAll('.route-checkbox').forEach(childCb => {
                            childCb.checked = isChecked;
                        });
                        updateParentStates();
                    });
                });

                // Section Toggle Checkboxes
                document.querySelectorAll('.section-checkbox').forEach(sectionCb => {
                    sectionCb.addEventListener('change', function() {
                        const isChecked = this.checked;
                        const sectionSlug = this.getAttribute('data-section');
                        const sectionBody = document.getElementById('section-' + sectionSlug);
                        sectionBody.querySelectorAll('.group-checkbox, .route-checkbox').forEach(cb => {
                            cb.checked = isChecked;
                        });
                        updateParentStates();
                    });
                });

                // Helper to update Group and Section checkbox states based on children
                function updateParentStates() {
                    document.querySelectorAll('.group-container').forEach(group => {
                        const childCbs = group.querySelectorAll('.route-checkbox');
                        const groupCb = group.querySelector('.group-checkbox');
                        if (childCbs.length > 0 && groupCb) {
                            const allChecked = Array.from(childCbs).every(cb => cb.checked);
                            groupCb.checked = allChecked;
                        }
                    });

                    document.querySelectorAll('.tree-card').forEach(card => {
                        const routeCbs = card.querySelectorAll('.route-checkbox');
                        const sectionCb = card.querySelector('.section-checkbox');
                        if (routeCbs.length > 0 && sectionCb) {
                            const allChecked = Array.from(routeCbs).every(cb => cb.checked);
                            sectionCb.checked = allChecked;
                        }
                    });
                }

                // Listen to children to update parent checkboxes
                document.querySelectorAll('.route-checkbox').forEach(cb => {
                    cb.addEventListener('change', updateParentStates);
                });

                // Run once on load to establish correct parent checkbox states
                updateParentStates();
            });
        </script>
    @endsection
</x-admin-layout>
