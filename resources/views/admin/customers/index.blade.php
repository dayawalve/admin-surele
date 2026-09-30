<x-admin-layout>
    @section('content')
        <style>
            .brands-container {
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
            }

            .custom-card {
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
                border: none;
                background: #ffffff;
            }

            .table-premium {
                width: 100% !important;
            }

            .table-premium tbody tr {
                transition: all 0.2s ease-in-out;
            }

            .table-premium tbody tr:hover {
                background-color: #f8fafc;
            }

            .avatar-circle-custom {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                background-color: rgba(101, 14, 164, 0.08);
                color: #650ea4;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 15px;
                margin-right: 12px;
            }

            .action-btn-custom {
                border-radius: 8px;
                padding: 6px 10px;
                font-size: 13px;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: none;
            }

            .btn-view-custom {
                background-color: rgba(101, 14, 164, 0.08);
                color: #650ea4;
            }

            .btn-view-custom:hover {
                background-color: #650ea4;
                color: #ffffff;
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

            .btn-create-custom {
                background: linear-gradient(135deg, #650ea4 0%, #8b25da 100%);
                color: #ffffff !important;
                border-radius: 10px;
                padding: 8px 20px;
                font-weight: 600;
                border: none;
                transition: all 0.2s ease;
                box-shadow: 0 4px 12px rgba(101, 14, 164, 0.2);
            }

            .btn-create-custom:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 18px rgba(101, 14, 164, 0.3);
            }
            .btn-aeo-enabled {
                background-color: rgba(16, 185, 129, 0.08);
                color: #10b981;
            }

            .btn-aeo-enabled:hover {
                background-color: #10b981;
                color: #ffffff;
            }

            .btn-aeo-disabled {
                background-color: rgba(239, 68, 68, 0.08);
                color: #ef4444;
            }

            .btn-aeo-disabled:hover {
                background-color: #ef4444;
                color: #ffffff;
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid brands-container">
            <!-- Toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Brands Hub
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Brands</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <form method="GET" action="{{ route('admin.brands.index') }}" class="d-flex gap-2">
                            <select name="month" class="form-select form-select-solid form-select-sm" style="min-width: 180px;">
                                <option value="">Current Month ({{ $daysInMonth }} days)</option>
                                @php
                                    for($m = 0; $m < 12; $m++) {
                                        $targetMonth = now()->copy()->subMonths($m);
                                        $monthValue = $targetMonth->format('Y-m');
                                        $monthLabel = $targetMonth->format('M Y');
                                        $days = $targetMonth->daysInMonth;
                                        $selected = request('month') == $monthValue ? 'selected' : '';
                                        echo "<option value='$monthValue' $selected>$monthLabel ($days days)</option>";
                                    }
                                @endphp
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm px-4">Filter</button>
                            @if(request('month'))
                                <a href="{{ route('admin.brands.index') }}" class="btn btn-light btn-sm px-4">Reset</a>
                            @endif
                        </form>
                        <a href="{{ route('admin.brands.create') }}" class="btn btn-create-custom">
                            + Create Brand
                        </a>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">

                    <!-- Summary Stats Row -->
                    <div class="row g-6 mb-8">
                        <div class="col-md-6 col-xl-4">
                            <div class="card card-bordered shadow-sm bg-light-primary h-100">
                                <div class="card-body p-5 d-flex align-items-center">
                                    <div class="symbol symbol-45px me-3">
                                        <span class="symbol-label bg-primary">
                                            <i class="bi bi-briefcase text-white fs-4"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 fs-7 fw-bold">Total Brands</div>
                                        <div class="text-dark fw-bolder fs-3">{{ $totalBrands ?? 0 }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card card-bordered shadow-sm bg-light-success h-100">
                                <div class="card-body p-5 d-flex align-items-center">
                                    <div class="symbol symbol-45px me-3">
                                        <span class="symbol-label bg-success">
                                            <i class="bi bi-cpu text-white fs-4"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 fs-7 fw-bold">Total Prompts</div>
                                        <div class="text-dark fw-bolder fs-3">{{ number_format($totalPromptsOverall ?? 0) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-4">
                            <div class="card card-bordered shadow-sm bg-light-danger h-100">
                                <div class="card-body p-5 d-flex align-items-center">
                                    <div class="symbol symbol-45px me-3">
                                        <span class="symbol-label bg-danger">
                                            <i class="bi bi-currency-dollar text-white fs-4"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="text-gray-500 fs-7 fw-bold">
                                            {{ request('month') ? 'Monthly Spending' : 'Total Spending' }}
                                        </div>
                                        <div class="text-dark fw-bolder fs-3">${{ number_format($totalSpendingOverall ?? 0, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top Engines Overall Row -->
                    <div class="card card-bordered shadow-sm mb-8">
                        <div class="card-body p-5">
                            <div class="fw-bold fs-6 mb-4 text-gray-800">Overall Cost breakdown by Engine ({{ $selectedMonth ?? 'Current Month' }})</div>
                            <div class="d-flex flex-wrap gap-3">
                                @forelse($overallMonthlySpendingByEngine ?? [] as $engine => $cost)
                                    <div class="px-4 py-3 bg-light rounded d-flex align-items-center">
                                        <div class="me-2">
                                            <span class="fw-bold text-gray-800 d-block">{{ $engine }}</span>
                                            <span class="fs-8 text-muted">Estimated Cost</span>
                                        </div>
                                        <span class="fw-bolder text-primary fs-5 ms-3">
                                            ${{ number_format($cost, 2) }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="text-muted">No engine data available</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="position-relative">
                            <input type="text" id="brandsSearch" class="form-control form-control-solid w-300px ps-12" style="border-radius: 10px; background-color: #ffffff; border: 1px solid #e4e6ef;" placeholder="🔍 Search Brands, Emails, or Spends..." />
                        </div>
                        <div>
                            <a href="{{ route('admin.brands.export-excel') }}" class="btn btn-success fw-bold d-flex align-items-center gap-2" style="border-radius: 10px;">
                                <i class="bi bi-file-earmark-excel"></i> Export Brands
                            </a>
                        </div>
                    </div>

                    <!-- Brands Table Card -->
                    <div class="card custom-card">
                        <div class="card-body p-6">
                            <div class="table-responsive">
                                <table id="brandsTable" class="table table-premium table-row-bordered table-row-gray-300 align-middle fs-6 gy-5">
                                    <thead>
                                        <tr class="fw-bold text-uppercase text-muted fs-7">
                                            <th class="ps-4">Sr No.</th>
                                            <th>Brand Name</th>
                                            <th>Email</th>
                                            <th>Prompts</th>
                                            <th>Daily Spend</th>
                                            <th>Monthly Spend</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($users as $key => $value)
                                            <tr>
                                                <td class="fw-bold text-muted ps-4">
                                                    {{ sprintf('%02d', $key + 1) }}
                                                </td>

                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-circle-custom">
                                                            {{ strtoupper(substr($value->brand_name ?: $value->username, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div class="fw-bold text-dark fs-6">
                                                                {{ $value->brand_name ?: $value->username }}
                                                            </div>
                                                            <small class="text-muted">
                                                                Reg: {{ \Carbon\Carbon::parse($value->createdAt)->format('d M Y') }}
                                                            </small>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <span class="text-gray-800 fw-semibold">
                                                        {{ $value->email }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="badge badge-light-success fs-7 fw-bold px-3 py-1">
                                                        {{ number_format($value->totalprompts ?? 0) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="text-gray-800 fw-bolder">
                                                        ${{ number_format($value->totalspends ?? 0, 2) }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <span class="text-primary fw-bolder fs-6">
                                                        ${{ number_format($value->monthlySpending ?? 0, 2) }}
                                                    </span>
                                                </td>

                                                <td class="text-end pe-4">
                                                    <div class="d-inline-flex gap-2">
                                                        <!-- View -->
                                                        <a href="{{ route('admin.brands.show', $value->id) }}"
                                                            class="action-btn-custom btn-view-custom"
                                                            title="View Details">
                                                            👁
                                                        </a>

                                                        <!-- Edit -->
                                                        <a href="{{ route('admin.brands.edit', $value->id) }}"
                                                            class="action-btn-custom btn-edit-custom"
                                                            title="Edit Brand">
                                                            ✏️
                                                        </a>

                                                        <!-- AEO Optin Toggle -->
                                                        <!-- <form action="{{ route('admin.brands.toggle-aeo', $value->id) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirmAeoToggle(event, {{ $value->is_aeo_enabled ? 'true' : 'false' }});">
                                                            @csrf
                                                            <button type="submit"
                                                                class="action-btn-custom {{ $value->is_aeo_enabled ? 'btn-aeo-enabled' : 'btn-aeo-disabled' }}"
                                                                title="{{ $value->is_aeo_enabled ? 'Disable AEO Option' : 'Enable AEO Option' }}">
                                                                {{ $value->is_aeo_enabled ? '✅' : '❌' }}
                                                            </button>
                                                        </form> -->

                                                        <!-- Delete -->
                                                        <form action="{{ route('admin.brands.destroy', $value->id) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirm('Are you sure you want to delete this brand?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="action-btn-custom btn-delete-custom"
                                                                title="Delete Brand">
                                                                🗑️
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Initialize DataTable -->
        <script>
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
                    var table = $('#brandsTable').DataTable({
                        pageLength: 10,
                        responsive: true,
                        dom: 'rtip', // Hide default search box
                        columnDefs: [{
                            orderable: false,
                            targets: 6
                        }]
                    });

                    $('#brandsSearch').on('keyup', function() {
                        table.search(this.value).draw();
                    });
                }
            });

            function confirmAeoToggle(e, isEnabled) {
                e.preventDefault(); 
                const actionText = isEnabled ? 'disable' : 'enable';
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${actionText} the AEO option for this user?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#650ea4',
                    cancelButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit(); 
                    }
                });

                return false;
            }
        </script>
    @endsection
</x-admin-layout>