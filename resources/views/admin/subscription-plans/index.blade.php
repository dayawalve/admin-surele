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

            .popular-pill {
                background-color: #f7edff;
                color: #650ea4;
                font-size: 12px;
                font-weight: 600;
                padding: 4px 12px;
                border-radius: 20px;
                display: inline-block;
            }

            /* Management Table Styles */
            .table-premium {
                width: 100% !important;
            }

            .table-premium tbody tr {
                transition: all 0.2s ease-in-out;
            }

            .table-premium tbody tr:hover {
                background-color: #f8fafc;
            }

            .btn-create-custom {
                background: linear-gradient(135deg, #650ea4 0%, #8b25da 100%);
                color: #ffffff !important;
                border-radius: 10px;
                padding: 10px 22px;
                font-weight: 600;
                border: none;
                transition: all 0.2s ease;
                box-shadow: 0 4px 12px rgba(101, 14, 164, 0.2);
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .btn-create-custom:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 18px rgba(101, 14, 164, 0.3);
            }

            .action-btn-custom {
                border-radius: 8px;
                padding: 7px 11px;
                font-size: 13px;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: none;
                margin: 0 2px;
            }

            .btn-edit-custom {
                background-color: rgba(59, 130, 246, 0.08);
                color: #2563eb;
            }

            .btn-edit-custom:hover {
                background-color: #2563eb;
                color: #ffffff;
            }

            .btn-delete-custom {
                background-color: rgba(239, 68, 68, 0.08);
                color: #ef4444;
            }

            .btn-delete-custom:hover {
                background-color: #ef4444;
                color: #ffffff;
            }

            .badge-active {
                background-color: #ecfdf5;
                color: #10b981;
                font-weight: 600;
                padding: 4px 10px;
                border-radius: 6px;
                font-size: 12px;
            }

            .badge-inactive {
                background-color: #fef2f2;
                color: #ef4444;
                font-weight: 600;
                padding: 4px 10px;
                border-radius: 6px;
                font-size: 12px;
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid plans-container">
            <!-- Toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Subscription Plans Master
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Subscription Plans</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('admin.subscription-plans.create') }}" class="btn-create-custom">
                            <i class="bi bi-plus-lg fs-5 text-white"></i> Add New Plan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Content Area -->
            <div class="app-content flex-column-fluid">
                <div class="app-container container-xxl">

                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center p-4 mb-5" role="alert">
                            <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                            <div class="d-flex flex-column">
                                <h5 class="mb-1 text-dark">Success</h5>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center p-4 mb-5" role="alert">
                            <i class="bi bi-x-circle-fill fs-3 text-danger me-3"></i>
                            <div class="d-flex flex-column">
                                <h5 class="mb-1 text-dark">Error</h5>
                                <span>{{ session('error') }}</span>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Section: Management Table -->
                    <div class="card custom-card">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <h4 class="fw-bold text-dark m-0">All Subscription Plans (Management)</h4>
                            </div>
                            <div class="card-toolbar">
                                <span class="badge bg-light-primary text-primary fs-7 fw-bold px-3 py-2">
                                    Total Plans: {{ count($plans) }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div class="table-responsive">
                                <table class="table table-premium align-middle gy-4 gs-4">
                                    <thead>
                                        <tr class="fw-bold text-muted bg-light">
                                            <th class="ps-4 rounded-start" style="width: 60px;">Sr. No.</th>
                                            <th>Plan Details</th>
                                            <th>Price & Billing</th>
                                            <th>Badge</th>
                                            <th>Features</th>
                                            <th>Status</th>
                                            <th>Order</th>
                                            <th class="pe-4 text-end rounded-end" style="width: 120px;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($plans as $index => $plan)
                                            <tr>
                                                <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="text-dark fw-bold fs-6">{{ $plan->name }}</span>
                                                        <span class="text-muted fs-7">{{ $plan->tagline ?? '-' }}</span>
                                                        <span class="text-muted fs-8">slug: <code>{{ $plan->slug }}</code></span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="fw-bold text-dark fs-6">{{ $plan->currency ?? '$' }}{{ number_format($plan->price, 2) }}</span>
                                                    <span class="text-muted fs-7">/ {{ $plan->billing_period }}</span>
                                                </td>
                                                <td>
                                                    @if($plan->badge)
                                                        <span class="popular-pill">{{ $plan->badge }}</span>
                                                    @elseif($plan->is_popular)
                                                        <span class="popular-pill">Most popular</span>
                                                    @else
                                                        <span class="text-muted fs-7">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-light-info text-info fw-semibold">
                                                        {{ count($plan->features_array) }} Features
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($plan->is_active)
                                                        <span class="badge-active">Active</span>
                                                    @else
                                                        <span class="badge-inactive">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-dark">{{ $plan->sort_order }}</span>
                                                </td>
                                                <td class="pe-4 text-end">
                                                    <a href="{{ route('admin.subscription-plans.edit', $plan->id) }}"
                                                       class="action-btn-custom btn-edit-custom"
                                                       title="Edit Plan">
                                                        <i class="bi bi-pencil-square fs-6"></i>
                                                    </a>
                                                    <form action="{{ route('admin.subscription-plans.destroy', $plan->id) }}"
                                                          method="POST"
                                                          class="d-inline-block delete-plan-form"
                                                          onsubmit="return confirmDelete(event, this, '{{ addslashes($plan->name) }}');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-btn-custom btn-delete-custom" title="Delete Plan">
                                                            <i class="bi bi-trash fs-6"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-6 text-muted">
                                                    No plans available.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- SweetAlert Delete Confirmation -->
        <script>
            function confirmDelete(e, form, planName) {
                e.preventDefault();
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `Do you really want to delete the plan "${planName}"?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                } else {
                    if (confirm(`Do you really want to delete the plan "${planName}"?`)) {
                        form.submit();
                    }
                }
                return false;
            }
        </script>
    @endsection
</x-admin-layout>
