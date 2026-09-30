<x-admin-layout>
    @section('content')
        <style>
            .table tbody tr:hover {
                background-color: #f9fafb;
                transition: 0.2s ease-in-out;
            }
        </style>
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Ideal Time Reasons List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Ideal Time Reasons</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    <div class="card shadow-sm border-0">

                        {{-- <form method="GET" action="{{ route('admin.ideal-time-reason.index') }}">
                            <div class="card-header d-flex justify-content-between align-items-center bg-light">

                                <h3 class="card-title mb-0 fw-bold">
                                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                                    Employees List
                                </h3>

                                <div class="d-flex align-items-center gap-2">

                                    <!-- Search -->
                                    <div class="position-relative">
                                        <input type="text" name="employee_name" value="{{ request('employee_name') }}"
                                            class="form-control form-control-solid w-250px" placeholder="Search employee"
                                            style="border: 1px solid #d1d5db; border-radius: 6px;" />
                                    </div>

                                    <!-- Status Filter -->
                                    <select name="status" class="form-select form-select-solid w-150px"
                                        style="border: 1px solid #d1d5db; border-radius: 6px;">
                                        <option value="">All</option>
                                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                                            Approved
                                        </option>
                                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>
                                            Rejected
                                        </option>
                                    </select>

                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Apply
                                    </button>

                                    <a href="{{ route('admin.ideal-time-reason.index') }}" class="btn btn-sm btn-light">
                                        Reset
                                    </a>

                                </div>
                            </div>
                        </form> --}}

                        <form method="GET" action="{{ route('admin.ideal-time-reason.index') }}">
                            <div class="card-header d-flex justify-content-between align-items-center bg-light">

                                <h3 class="card-title mb-0 fw-bold">
                                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                                    Employees List
                                </h3>

                                <div class="d-flex align-items-center gap-2">

                                    <!-- Search -->
                                    <input type="text" name="employee_name" value="{{ request('employee_name') }}"
                                        class="form-control form-control-solid w-200px" placeholder="Search employee"
                                        style="border:1px solid #d1d5db;border-radius:6px;" />

                                    <!-- Single Date -->
                                    <input type="date" name="filter_date" value="{{ request('filter_date') }}"
                                        class="form-control form-control-solid w-170px"
                                        style="border:1px solid #d1d5db;border-radius:6px;" />

                                    <!-- Status -->
                                    <select name="status" class="form-select form-select-solid w-150px"
                                        style="border:1px solid #d1d5db;border-radius:6px;">
                                        <option value="">All</option>
                                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>
                                            Rejected</option>
                                    </select>

                                    <!-- Buttons -->
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Apply
                                    </button>

                                    <a href="{{ route('admin.ideal-time-reason.index') }}" class="btn btn-sm btn-light">
                                        Reset
                                    </a>

                                </div>
                            </div>
                        </form>

                        <!-- CARD BODY -->
                        <div class="card-body py-4">
                            <div class="table-responsive">

                                <table id="dd" class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead class="bg-light">
                                        <tr class="text-muted fw-semibold fs-7 text-uppercase">
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Ideal Time</th>
                                            <th>Reason</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody class="fw-semibold text-gray-600">

                                        @if ($data->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center">No records found.</td>
                                            </tr>
                                        @endif

                                        @foreach ($data as $key => $value)
                                            <tr>

                                                <!-- INDEX -->
                                                <td>#{{ ++$i }}</td>

                                                <!-- EMPLOYEE -->
                                                <td>
                                                    <div class="fw-bold">
                                                        {{ $value->employee->name ?? 'N/A' }}
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $value->employee->designation ?? 'N/A' }}
                                                    </small>
                                                </td>

                                                <!-- IDEAL TIME -->
                                                <td>
                                                    {{-- <div>
                                                        <strong>Total:</strong>
                                                        {{ gmdate('H:i:s', $value->total_seconds) }} (
                                                        {{ $value->total_seconds }} seconds )
                                                    </div> --}}
                                                    @php
                                                        $seconds = $value->total_seconds;

                                                        $hours = floor($seconds / 3600);
                                                        $minutes = floor(($seconds % 3600) / 60);
                                                        $remainingSeconds = $seconds % 60;
                                                    @endphp

                                                    <div>
                                                        <strong>Total:</strong>

                                                        @if ($hours > 0)
                                                            {{ $hours }} Hr
                                                        @endif

                                                        @if ($minutes > 0)
                                                            {{ $minutes }} Min
                                                        @endif

                                                        @if ($remainingSeconds > 0 && $hours == 0)
                                                            {{ $remainingSeconds }} Sec
                                                        @endif

                                                        {{-- ({{ $seconds }} seconds) --}}
                                                    </div>
                                                    <div>
                                                        <strong>From:</strong>
                                                        {{ $value->ideal_start_time }}
                                                    </div>

                                                    @if ($value->ideal_end_time)
                                                        <div>
                                                            <strong>To:</strong>
                                                            {{ $value->ideal_end_time }}
                                                        </div>
                                                    @else
                                                        <span class="badge badge-light-warning">Running</span>
                                                    @endif
                                                </td>

                                                <!-- REASON -->
                                                <td>{{ $value->reason ?? '—' }}</td>

                                                <!-- STATUS -->
                                                <td>
                                                    @if ($value->status === 'approved')
                                                        <span class="badge badge-light-success">Approved</span>
                                                    @elseif ($value->status === 'rejected')
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    @else
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    @endif
                                                </td>

                                                <!-- ACTIONS -->
                                                <td class="text-end">

                                                    @if ($value->status === 'pending')
                                                        <form
                                                            action="{{ route('admin.ideal-time-reason.approve', $value->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')

                                                            <button type="submit"
                                                                class="btn btn-sm btn-icon btn-light-success"
                                                                data-bs-toggle="tooltip" title="Approve">
                                                                <i class="bi bi-check-circle"></i>
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('admin.ideal-time-reason.reject', $value->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')

                                                            <button type="submit"
                                                                class="btn btn-sm btn-icon btn-light-danger"
                                                                data-bs-toggle="tooltip" title="Reject"
                                                                onclick="return confirm('Reject this ideal time request?')">
                                                                <i class="bi bi-x-circle"></i>
                                                            </button>
                                                        </form>
                                                    @elseif($value->status === 'approved')
                                                        -
                                                        {{-- <span class="badge badge-light-success ms-2">
                                                            <i class="bi bi-check-circle me-1"></i> Approved
                                                        </span> --}}
                                                    @elseif($value->status === 'rejected')
                                                        -
                                                        {{-- <span class="badge badge-light-danger ms-2">
                                                            <i class="bi bi-x-circle me-1"></i> Rejected
                                                        </span> --}}
                                                    @endif

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
