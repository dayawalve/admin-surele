<x-admin-layout>
    @section('content')
    <style>
        /* Glassmorphism Card */
.glass-card {
    background: rgba(255, 255, 255, 0.18);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.glass-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.25);
}

.glass-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    background: rgba(255, 255, 255, 0.25);
}

    </style>
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Students Payment List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Students Payment</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        {{-- <div class="m-0">
                            <!--begin::Menu toggle-->
                            <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>Filter</a>
                            <!--end::Menu toggle-->
                            <!--begin::Menu 1-->
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                                data-kt-menu="true"
                                id="kt_menu_student_filter">

                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Students</div>
                                </div>

                                <div class="separator border-gray-200"></div>

                                <form method="GET" action="{{ route('admin.students-payment.index') }}">
                                    <div class="px-7 py-5">

                                        <div class="mb-6">
                                            <label class="form-label fw-semibold">Status</label>
                                            <select name="is_active"
                                                    class="form-select form-select-solid"
                                                    data-placeholder="Select Status">
                                                <option value="">All</option>
                                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('admin.students-payment.index') }}"
                                            class="btn btn-sm btn-light btn-active-light-primary me-2">
                                                Reset
                                            </a>
                                            <button type="submit"
                                                    class="btn btn-sm btn-primary">
                                                Apply
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            <!--end::Menu 1-->
                        </div> --}}
                        {{-- <a href="{{ route('admin.students.create') }}" class="btn btn-sm fw-bold btn-primary">Create</a> --}}
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    <div class="row g-5 mb-7">
                        {{-- Total Collected --}}
                        <div class="col-md-4">
                            <div class="glass-card p-5 h-100">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="glass-icon text-success">
                                        <i class="bi bi-currency-rupee"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-2 text-success">
                                            ₹{{ number_format($data->sum('amount'), 2) }}
                                        </div>
                                        <div class="text-muted fw-semibold">
                                            Total Collected
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Total Transactions --}}
                        <div class="col-md-4">
                            <div class="glass-card p-5 h-100">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="glass-icon text-primary">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-2">
                                            {{ $data->count() }}
                                        </div>
                                        <div class="text-muted fw-semibold">
                                            Total Transactions
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Students Paid --}}
                        <div class="col-md-4">
                            <div class="glass-card p-5 h-100">
                                <div class="d-flex align-items-center gap-4">
                                    <div class="glass-icon text-warning">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold fs-2">
                                            {{ $data->unique('student_id')->count() }}
                                        </div>
                                        <div class="text-muted fw-semibold">
                                            Students Paid
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title fw-bold">
                                <i class="bi bi-credit-card me-2 text-primary"></i>
                                Student Payments
                            </h3>
                        </div>

                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table class="table table-row-dashed align-middle fs-6 gy-5">
                                    <thead>
                                        <tr class="text-muted fw-bold fs-7 text-uppercase">
                                            <th>#</th>
                                            <th>Student</th>
                                            <th>Program</th>
                                            <th>Amount</th>
                                            <th>Mode</th>
                                            <th>Date</th>
                                            <th>Receipt</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody class="fw-semibold text-gray-700">
                                        @foreach ($data as $key => $payment)
                                            <tr>
                                                <td>{{ $key + $i + 1 }}</td>

                                                <td>
                                                    <div class="fw-bold">
                                                        {{ $payment->student?->fname }}
                                                        {{ $payment->student?->lname }}
                                                    </div>
                                                    <div class="text-muted fs-7">
                                                        Refer ID: {{ $payment->student?->refer_id }}
                                                    </div>
                                                </td>

                                                <td>
                                                    {{ $payment->trainingProgram?->program_name ?? 'N/A' }}
                                                </td>

                                                <td class="fw-bold text-success">
                                                    ₹{{ number_format($payment->amount, 2) }}
                                                </td>

                                                <td>
                                                    <span class="badge badge-light-primary">
                                                        {{ $payment->payment_mode }}
                                                    </span>
                                                </td>

                                                <td>
                                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                                </td>

                                                <td>
                                                    @if($payment->payment_receipt)
                                                        <a href="{{ asset($payment->payment_receipt) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-light-primary">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-muted">—</span>
                                                    @endif
                                                </td>

                                                {{-- Dropdown Actions --}}
                                                <td class="text-end">
                                                    <div class="dropdown">
                                                        <button class="btn btn-sm btn-light btn-icon"
                                                                data-bs-toggle="dropdown">
                                                            <i class="bi bi-three-dots"></i>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end shadow">
                                                            <a href="{{ route('admin.students.show', $payment->student_id) }}"
                                                            class="dropdown-item">
                                                                <i class="bi bi-person me-2"></i>
                                                                View Student
                                                            </a>

                                                            <a href="{{ asset($payment->payment_receipt) }}"
                                                            target="_blank"
                                                            class="dropdown-item {{ !$payment->payment_receipt ? 'disabled' : '' }}">
                                                                <i class="bi bi-receipt me-2"></i>
                                                                View Receipt
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
