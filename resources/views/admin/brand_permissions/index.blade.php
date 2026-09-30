<x-admin-layout>
    @section('content')
        <style>
            .permissions-container {
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
            }

            .custom-card {
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
                border: none;
                background: #ffffff;
            }

            .table-premium {
                border-collapse: separate;
                border-spacing: 0 8px;
                width: 100%;
            }

            .table-premium thead tr th {
                background: #f3f4f5ff;
                border: none;
                color: #475569;
                font-weight: 600;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 14px 20px;
            }

            .table-premium thead tr th:first-child {
                border-top-left-radius: 10px;
                border-bottom-left-radius: 10px;
            }

            .table-premium thead tr th:last-child {
                border-top-right-radius: 10px;
                border-bottom-right-radius: 10px;
            }

            .table-premium tbody tr {
                background: #ffffff;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
                border-radius: 12px;
                transition: all 0.2s ease-in-out;
            }

            .table-premium tbody tr:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
                background-color: #fafafa;
            }

            .table-premium tbody td {
                border: none;
                padding: 16px 20px;
            }

            .table-premium tbody td:first-child {
                border-top-left-radius: 12px;
                border-bottom-left-radius: 12px;
            }

            .table-premium tbody td:last-child {
                border-top-right-radius: 12px;
                border-bottom-right-radius: 12px;
            }

            .badge-permission {
                font-size: 11px;
                padding: 4px 8px;
                border-radius: 6px;
                font-weight: 600;
                margin-right: 4px;
                margin-bottom: 4px;
                display: inline-block;
            }

            .badge-enabled {
                background-color: rgba(16, 185, 129, 0.1);
                color: #10b981;
            }

            .badge-disabled {
                background-color: rgba(239, 68, 68, 0.1);
                color: #ef4444;
            }

            .action-btn-custom {
                border-radius: 8px;
                padding: 8px 12px;
                font-size: 14px;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: none;
            }

            .btn-edit-custom {
                background-color: rgba(59, 130, 246, 0.08);
                color: #2563eb;
            }

            .btn-edit-custom:hover {
                background-color: #2563eb;
                color: #ffffff;
                transform: translateY(-1px);
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid permissions-container">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Brand Permissions Control
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Brand Permissions</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span><span class="path2"></span>
                            </i>
                            <input type="text" id="brandPermissionsSearch" class="form-control form-control-solid w-300px ps-13" style="border-radius: 10px; background-color: #ffffff; border: 1px solid #e4e6ef;" placeholder="Search Users, Brands, or Emails..." />
                        </div>
                    </div>

                    <div class="card custom-card bg-transparent">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="brandPermissionsTable" class="table table-premium align-middle">
                                    <thead>
                                        <tr>
                                            <th class="ps-5" style="width: 80px;">Sr No.</th>
                                            <th>User / Brand</th>
                                            <th>Email</th>
                                            <th>Feature Permissions</th>
                                            <th class="text-end pe-5">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if ($users->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center py-8">
                                                    😕 No Brands/Users Found
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($users as $key => $value)
                                                <tr>
                                                    <td class="ps-5 text-muted">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="fw-bold text-gray-800 fs-6">
                                                            {{ $value->brand_name ?? 'N/A' }}
                                                        </div>
                                                        <div class="text-muted fs-7">
                                                            User ID: {{ $value->id }} ({{ $value->username }})
                                                        </div>
                                                    </td>
                                                    <td class="text-gray-600">{{ $value->email }}</td>
                                                    <td>
                                                        @php
                                                            $features = [
                                                                'SEO' => $value->has_seo,
                                                                'AEO' => $value->has_aeo,
                                                                'GBP' => $value->has_gbp,
                                                                'Content' => $value->has_content_engines,
                                                                'Insights' => $value->has_insights,
                                                                'Analytics' => $value->has_analytics_suite,
                                                                'Heatmap' => $value->has_heatmap,
                                                                'Monitoring' => $value->has_monitoring,
                                                                'Comp Intel' => $value->has_competitive_intel,
                                                            ];
                                                        @endphp
                                                        @foreach ($features as $name => $enabled)
                                                            <span class="badge-permission {{ $enabled ? 'badge-enabled' : 'badge-disabled' }}">
                                                                {{ $name }}: {{ $enabled ? 'ON' : 'OFF' }}
                                                            </span>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-end pe-5">
                                                        <a href="{{ route('admin.brand_permissions.edit', $value->id) }}"
                                                           class="action-btn-custom btn-edit-custom">
                                                            <i class="bi bi-pencil-fill me-1"></i> Edit
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Wait for layout scripts (jQuery, DataTables) to fully load
            window.addEventListener('load', function() {
                if (typeof $ !== 'undefined' && $.fn.DataTable) {
                    initializeDataTable();
                } else {
                    var interval = setInterval(function() {
                        if (typeof $ !== 'undefined' && $.fn.DataTable) {
                            clearInterval(interval);
                            initializeDataTable();
                        }
                    }, 50);
                }

                function initializeDataTable() {
                    var table = $('#brandPermissionsTable').DataTable({
                        pageLength: 10,
                        responsive: true,
                        dom: 'rtip', // hide default search bar
                        columnDefs: [{
                            orderable: false,
                            targets: 4
                        }]
                    });

                    $('#brandPermissionsSearch').on('keyup', function() {
                        table.search(this.value).draw();
                    });
                }
            });
        </script>
    @endsection
</x-admin-layout>
