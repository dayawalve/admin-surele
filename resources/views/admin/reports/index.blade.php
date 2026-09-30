<x-admin-layout>
    @section('content')
        <style>
            .glass-card {
                background: rgba(255, 255, 255, 0.22);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.3);
                border-radius: 12px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            }

            .glass-icon {
                width: 42px;
                height: 42px;
                border-radius: 10px;
                margin: 0 auto 8px;
                background: rgba(255, 255, 255, 0.35);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Reports</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Reports</li>
                        </ul>
                    </div>
                    {{-- <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ route('admin.company-settings.create') }}"
                            class="btn btn-sm fw-bold btn-primary">Create</a>
                    </div> --}}
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    {{-- MAIN REPORT CARD --}}
                    <div class="card card-flush">
                        <div class="card-body px-8 py-6">

                            {{-- ================= KPI SUMMARY ================= --}}
                            <div class="row g-6 mb-10">

                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-light-primary h-100">
                                        <div class="card-body text-center py-6">
                                            <div class="fs-2 fw-bold text-primary">
                                                ₹{{ number_format($totalRevenue) }}
                                            </div>
                                            <div class="text-muted fw-semibold">Total Revenue</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-light-success h-100">
                                        <div class="card-body text-center py-6">
                                            <div class="fs-2 fw-bold text-success">
                                                ₹{{ number_format($paidAmount) }}
                                            </div>
                                            <div class="text-muted fw-semibold">Collected Amount</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-light-danger h-100">
                                        <div class="card-body text-center py-6">
                                            <div class="fs-2 fw-bold text-danger">
                                                ₹{{ number_format($pendingAmount) }}
                                            </div>
                                            <div class="text-muted fw-semibold">Pending Amount</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-light h-100">
                                        <div class="card-body text-center py-6">
                                            <div class="fs-2 fw-bold">{{ $totalStudents }}</div>
                                            <div class="text-muted fw-semibold">Total Students</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= FILTER SECTION ================= --}}
                            <div class="card mb-10">
                                <div class="card-body py-6 px-6">
                                    <form method="GET" class="row g-5 align-items-end">

                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">From Date</label>
                                            <input type="date" name="from_date" value="{{ request('from_date') }}"
                                                class="form-control form-control-solid">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label fw-semibold">To Date</label>
                                            <input type="date" name="to_date" value="{{ request('to_date') }}"
                                                class="form-control form-control-solid">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label fw-semibold">Training Program</label>
                                            <select name="program_id" class="form-select form-select-solid">
                                                <option value="">All Programs</option>
                                                @foreach ($trainingPrograms as $program)
                                                    <option value="{{ $program->id }}"
                                                        {{ request('program_id') == $program->id ? 'selected' : '' }}>
                                                        {{ $program->program_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-2 d-flex gap-1">
                                            <a href="{{ route('admin.reports.index') }}"
                                                class="btn btn-outline-secondary flex-fill">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                            </a>

                                            <button type="submit" class="btn btn-primary flex-fill">
                                                <i class="bi bi-funnel me-1"></i> Filter
                                            </button>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            {{-- ================= PAYMENT REPORT ================= --}}
                            <div class="card mb-10">
                                <div class="card-header py-5">
                                    <h3 class="card-title fw-bold">Payment Report</h3>
                                </div>

                                <div class="card-body py-6">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed align-middle">
                                            <thead class="text-muted fw-bold fs-7">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student</th>
                                                    <th>Program</th>
                                                    <th>Amount</th>
                                                    <th>Mode</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($payments as $key => $payment)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>

                                                        <td>
                                                            {{ $payment->student->fname ?? '-' }}
                                                            {{ $payment->student->lname ?? '' }}
                                                        </td>

                                                        <td>{{ $payment->trainingProgram->program_name ?? 'N/A' }}</td>

                                                        <td class="fw-bold text-success">
                                                            ₹{{ number_format($payment->amount) }}
                                                        </td>

                                                        <td>
                                                            <span class="badge badge-light-primary">
                                                                {{ $payment->payment_mode }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center text-muted py-6">
                                                            No payment records found
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- ================= PROGRAM PERFORMANCE ================= --}}
                            {{-- <div class="card">
                                <div class="card-header py-5">
                                    <h3 class="card-title fw-bold">Program Performance</h3>
                                </div>

                                <div class="card-body py-6">
                                    <div class="table-responsive">
                                        <table class="table table-row-dashed align-middle">
                                            <thead class="text-muted fw-bold fs-7">
                                                <tr>
                                                    <th>Program</th>
                                                    <th>Students</th>
                                                    <th>Revenue</th>
                                                    <th>Pending</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($programReport as $row)
                                                    <tr>
                                                        <td>{{ $row->program_name }}</td>
                                                        <td>{{ $row->students_count }}</td>
                                                        <td class="fw-bold text-success">
                                                            ₹{{ number_format($row->revenue) }}
                                                        </td>
                                                        <td class="fw-bold text-danger">
                                                            ₹{{ number_format($row->pending) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card">
                                <div class="card-header py-5">
                                    <h3 class="card-title fw-bold">Program Performance</h3>
                                </div>

                                <div class="card-body py-6">
                                    <div class="row g-5">
                                        @foreach ($programReport as $row)
                                            @php
                                                $total = $row->revenue + $row->pending;
                                                $percentage = $total > 0 ? ($row->revenue / $total) * 100 : 0;
                                            @endphp

                                            <div class="col-xl-4 col-md-6">
                                                <div class="card card-flush h-100 shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="fw-bold mb-3">{{ $row->program_name }}</h5>

                                                        <div class="d-flex justify-content-between mb-2">
                                                            <span class="text-muted">Students</span>
                                                            <span class="fw-bold">{{ $row->students_count }}</span>
                                                        </div>

                                                        <div class="d-flex justify-content-between mb-2">
                                                            <span class="text-muted">Revenue</span>
                                                            <span class="fw-bold text-success">
                                                                ₹{{ number_format($row->revenue) }}
                                                            </span>
                                                        </div>

                                                        <div class="d-flex justify-content-between mb-4">
                                                            <span class="text-muted">Pending</span>
                                                            <span class="fw-bold text-danger">
                                                                ₹{{ number_format($row->pending) }}
                                                            </span>
                                                        </div>

                                                        <div class="progress h-8px">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: {{ $percentage }}%">
                                                            </div>
                                                        </div>
                                                        <small class="text-muted">
                                                            {{ round($percentage) }}% Collected
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div> {{-- card-body --}}
                    </div> {{-- main card --}}
                </div>
            </div>

        </div>
    @endsection
</x-admin-layout>
