<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Training Program Details</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Training Program Details</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    {{-- Header --}}
                    <div class="d-flex flex-wrap flex-stack mb-6">
                        <h3 class="fw-bold m-0"> </h3>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.training-programs.edit', $data->id) }}"
                            class="btn btn-primary btn-sm">
                                <i class="bi bi-vector-pen me-1"></i> Edit
                            </a>

                            <a href="{{ route('admin.training-programs.index') }}"
                            class="btn btn-light btn-sm">
                                Back
                            </a>
                        </div>
                    </div>

                    {{-- Program Overview Card --}}
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-body pt-9 pb-0">

                            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">

                                {{-- Icon / Badge --}}
                                <div class="me-7 mb-4">
                                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed bg-light-primary d-flex align-items-center justify-content-center">
                                        <i class="bi bi-mortarboard fs-2x text-primary"></i>
                                    </div>
                                </div>

                                {{-- Program Info --}}
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="text-gray-900 fs-2 fw-bold me-2">
                                                    {{ $data->program_name }}
                                                </span>

                                                @if($data->is_deleted)
                                                    <span class="badge badge-light-danger">Deleted</span>
                                                @endif
                                            </div>

                                            <div class="d-flex flex-wrap fw-semibold fs-6 text-gray-500">
                                                <span class="me-4">
                                                    <strong>Code:</strong> TP-{{ $data->program_code }}
                                                </span>
                                                <span>
                                                    <strong>Mode:</strong> {{ $data->training_mode }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Badges --}}
                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        <span class="badge badge-light-info">
                                            Duration: {{ $data->duration_weeks }} Weeks
                                        </span>

                                        <span class="badge badge-light-success">
                                            Fees: ₹{{ number_format($data->fees, 2) }}
                                        </span>

                                        <span class="badge {{ $data->status === 'Active' ? 'badge-light-success' : 'badge-light-warning' }}">
                                            {{ $data->status }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card mt-5">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="symbol symbol-50px symbol-circle bg-light-primary me-4">
                                            <i class="bi bi-people fs-2 text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fs-4 fw-bold">{{ $data->students_count }}</div>
                                            <div class="text-gray-500">Total Students Enrolled</div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    {{-- Details Section --}}
                    <div class="row g-5 g-xl-10">
                        <div class="col-xl-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Program Information</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless fs-6">
                                        <tr>
                                            <th class="text-gray-600 w-200px">Program Code</th>
                                            <td class="fw-semibold">TP-{{ $data->program_code }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Training Mode</th>
                                            <td class="fw-semibold">{{ $data->training_mode }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Duration</th>
                                            <td class="fw-semibold">{{ $data->duration_weeks }} Weeks</td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Fees</th>
                                            <td class="fw-semibold">₹{{ number_format($data->fees, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">System Information</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless fs-6">
                                        <tr>
                                            <th class="text-gray-600 w-200px">Status</th>
                                            <td>
                                                <span class="badge {{ $data->status === 'Active' ? 'badge-light-success' : 'badge-light-warning' }}">
                                                    {{ $data->status }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Created At</th>
                                            <td class="fw-semibold">
                                                {{ $data->created_at->format('d M Y, h:i A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Last Updated</th>
                                            <td class="fw-semibold">
                                                {{ $data->updated_at->format('d M Y, h:i A') }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="card mt-5">
                        <div class="card-header">
                            <h3 class="card-title fw-bold">Program Description</h3>
                        </div>
                        <div class="card-body">
                            <p class="fs-6 text-gray-700">
                                {{ $data->description ?? 'No description provided.' }}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
