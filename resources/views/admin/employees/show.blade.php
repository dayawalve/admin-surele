<x-admin-layout>
    @section('content')
        <style>
            .border-hover-primary:hover {
                border: 1px solid #0d6efd;
                transform: scale(1.02);
                transition: all 0.2s ease;
            }
        </style>
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Employee Details</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted"> Details</li>
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
                            <a href="{{ route('admin.employees.edit', $data->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-vector-pen me-1"></i> Edit
                            </a>

                            <a href="{{ route('admin.employees.index') }}" class="btn btn-light btn-sm">
                                Back
                            </a>
                        </div>
                    </div>


                    {{-- Profile Card --}}
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-body pt-9 pb-0">

                            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">

                                {{-- Profile Image --}}
                                <div class="me-7 mb-4">
                                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                        <img src="{{ asset($data->image ?? 'public/custom-img/blank.png') }}"
                                            alt="Student Image" />
                                        @if ($data->is_active)
                                            <div
                                                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle h-20px w-20px border border-4 border-body">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Student Info --}}
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">

                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                                    {{ $data->fname }} {{ $data->lname }}
                                                </span>

                                                @if ($data->is_deleted)
                                                    <span class="badge badge-light-danger ms-2">Deleted</span>
                                                @endif
                                            </div>

                                            <div class="d-flex flex-wrap fw-semibold fs-6 text-gray-500">
                                                <span class="me-4">
                                                    <i class="bi bi-envelope me-1"></i> {{ $data->email }}
                                                </span>
                                                <span>
                                                    <i class="bi bi-telephone me-1"></i> {{ $data->phone }}
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- Badges --}}
                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        <span class="badge badge-light-primary">
                                            {{ $data->designation ?? 'No Designation Assigned' }}
                                        </span>

                                        <span class="badge badge-light-info">
                                            {{ $data->department ?? 'Department N/A' }}
                                        </span>

                                        <span
                                            class="badge {{ $data->status === 'active' ? 'badge-light-success' : 'badge-light-warning' }}">
                                            {{ $data->status === 'active' ? 'active' : 'inactive' }}
                                        </span>
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
                                    <h3 class="card-title fw-bold">Personal Information</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless fs-6">
                                        <tr>
                                            <th class="text-gray-600 w-200px">Name</th>
                                            <td class="fw-semibold">
                                                {{ $data->name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Employee Code</th>
                                            <td class="fw-semibold">
                                                {{ $data->employee_code ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Salary</th>
                                            <td class="fw-semibold">
                                                {{ $data->salary ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Date of Birth</th>
                                            <td class="fw-semibold">
                                                {{ $data->date_of_birth }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Date of Joining</th>
                                            <td class="fw-semibold">
                                                {{ $data->date_of_joining }}
                                            </td>
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
                                            <th class="text-gray-600 w-200px">Created At</th>
                                            <td class="fw-semibold">
                                                {{ $data->created_at->format('d M Y, h:i A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Status</th>
                                            <td>
                                                {{-- @dd($data) --}}
                                                <span
                                                    class="badge {{ $data->status === 'active' ? 'badge-light-success' : 'badge-light-warning' }}">
                                                    {{ $data->status === 'active' ? 'active' : 'inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-8">
                        <div class="card-header">
                            <h3 class="card-title fw-bold">Today's Activity Log</h3>
                        </div>
                        <div class="row g-4 mb-6 mt-5">
                            <div class="col-md-3">
                                <div class="card bg-light-primary">
                                    <div class="card-body">
                                        <div class="fw-bold text-primary">Total Time</div>
                                        <div class="fs-2 fw-bolder">{{ $totalTime }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card bg-light-success">
                                    <div class="card-body">
                                        <div class="fw-bold text-success">Active Time</div>
                                        <div class="fs-2 fw-bolder">{{ $activeTime }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card bg-light-warning">
                                    <div class="card-body">
                                        <div class="fw-bold text-warning">Idle Time</div>
                                        <div class="fs-2 fw-bolder">{{ $idleTime }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card bg-light-info">
                                    <div class="card-body">
                                        <div class="fw-bold text-info">Top App</div>
                                        <div class="fs-6 fw-semibold">{{ $topApp ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Domains Section --}}
                    <div class="card mb-5">
                        <div class="card-header py-4">
                            <h3 class="card-title fw-bold mb-0">
                                <i class="bi bi-globe me-2"></i> Assigned Domains
                            </h3>
                        </div>

                        <div class="card-body p-0">
                            @if ($domains->count())
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="padding-left:14px;">Domain</th>
                                            <th class="text-center" style="width:120px;">Status</th>
                                            <th class="text-center" style="width:100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($domains as $domain)
                                            <tr>
                                                {{-- Domain (ONLY LEFT PADDING ADDED) --}}
                                                <td style="padding-left:14px;" class="fw-semibold">
                                                    {{ $domain->name }}
                                                </td>

                                                {{-- Status --}}
                                                <td class="text-center">
                                                    <span
                                                        class="badge {{ ($domain->is_enabled ?? 0) == 1 ? 'badge-light-success' : 'badge-light-danger' }}">
                                                        {{ ($domain->is_enabled ?? 0) == 1 ? 'Enable' : 'Disabled' }}
                                                    </span>
                                                </td>

                                                {{-- Action --}}
                                                <td class="text-center">
                                                    <a href="{{ route('admin.employees.toggle', $domain->id) }}?employee_id={{ $data->id }}"
                                                        class="btn btn-icon btn-sm
                                                        {{ ($domain->is_enabled ?? 0) == 1 ? 'btn-light-success' : 'btn-light-danger' }}"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ ($domain->is_enabled ?? 0) == 1 ? 'Disable' : 'Enable' }}">

                                                        <i
                                                            class="bi {{ ($domain->is_enabled ?? 0) == 1 ? 'bi-toggle-on' : 'bi-toggle-off' }}"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center text-muted py-6">
                                    No domains assigned
                                </div>
                            @endif
                        </div>

                    </div>


                    {{-- Screenshots Section --}}
                    <div class="card mt-8">

                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <h3 class="card-title fw-bold mb-2 mb-md-0">
                                Screenshots Activity
                            </h3>

                            <form method="GET" action="{{ route('admin.employees.show', ['employee' => $data->id]) }}"
                                class="d-flex align-items-center gap-2">

                                <input type="date" name="date" class="form-control form-control-sm"
                                    style="max-width: 180px;" value="{{ request('date', now()->toDateString()) }}"
                                    max="{{ now()->toDateString() }}">

                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-funnel-fill me-1"></i> Filter
                                </button>

                                <a href="{{ route('admin.employees.show', ['employee' => $data->id]) }}"
                                    class="btn btn-sm btn-light-secondary text-dark">
                                    Reset
                                </a>

                                <!-- Export Button -->
                                <a href="{{ route('admin.employees.export', ['employee' => $data->id, 'date' => request('date', now()->toDateString())]) }}"
                                    class="btn btn-sm btn-success">
                                    <i class="bi bi-download me-1"></i> Export
                                </a>

                            </form>
                        </div>

                        <div class="card-body">
                            @if ($screenshots->count())
                                {{-- Screenshot Grid --}}
                                <div class="row g-4">
                                    @foreach ($screenshots as $index => $shot)
                                        @php
                                            $screenshotUrl = $shot->screenshot_path;
                                        @endphp

                                        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                                            <div class="card shadow-sm border-hover-primary h-100">

                                                <div class="card-body p-2">
                                                    {{-- <a href="{{ asset($shot->screenshot_path) }}" data-bs-toggle="modal"
                                                        data-bs-target="#screenshotModal"
                                                        data-image="{{ asset($shot->screenshot_path) }}"
                                                        data-time="{{ $shot->date_time }}"> --}}

                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                        data-bs-target="#screenshotModal"
                                                        data-index="{{ $index }}">


                                                        <img src="{{ asset($shot->screenshot_path) }}"
                                                            class="img-fluid rounded" loading="lazy" alt="Screenshot">
                                                    </a>
                                                </div>

                                                <div class="card-footer py-2 text-center">
                                                    <span class="fs-8 text-gray-600">
                                                        {{ \Carbon\Carbon::parse($shot->date_time)->format('d M, h:i A') }}
                                                    </span>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Pagination (NOW IT WORKS ✅) --}}
                                <div class="d-flex justify-content-end mt-5">
                                    {!! $screenshots->appends(Request::all())->links() !!}
                                </div>
                            @else
                                <div class="text-center text-muted py-10">
                                    <i class="bi bi-image fs-2x mb-3"></i>
                                    <div>No screenshots found</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card mt-8 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title fw-bold mb-0">
                                Application Usage Summary
                            </h3>

                            <span class="badge badge-light-primary">
                                Top Apps by Usage
                            </span>
                        </div>

                        <div class="card-body">

                            @if (empty($appUsage) || $appUsage->count() === 0)
                                <div class="text-center text-muted py-5">
                                    <i class="bi bi-bar-chart fs-2 mb-2"></i>
                                    <div>No application usage data available.</div>
                                </div>
                            @else
                                @php
                                    $maxSeconds = $appUsage->max();
                                @endphp

                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead class="text-muted text-uppercase fs-7">
                                            <tr>
                                                <th>Application</th>
                                                <th>Usage</th>
                                                <th class="text-end">Time</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if (isset($appUsage) && $appUsage->count() > 0)
                                                @foreach ($appUsage as $app => $seconds)
                                                    @php
                                                        $percentage =
                                                            $maxSeconds > 0 ? round(($seconds / $maxSeconds) * 100) : 0;

                                                        $hours = floor($seconds / 3600);
                                                        $minutes = floor(($seconds % 3600) / 60);
                                                    @endphp

                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div
                                                                    class="symbol symbol-40px bg-light-primary text-primary fw-bold">
                                                                    {{ strtoupper(substr($app, 0, 1)) }}
                                                                </div>
                                                                <div class="fw-semibold">
                                                                    {{ $app }}
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div class="progress h-6px bg-light">
                                                                <div class="progress-bar bg-primary" role="progressbar"
                                                                    style="width: {{ $percentage }}%">
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="text-end fw-bold">
                                                            {{ $hours }}h {{ $minutes }}m
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted py-4">
                                                        No application usage data available.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <h3 class="card-title fw-bold mb-2 mb-md-0">
                                Activity Log
                            </h3>
                            <form method="GET" action="{{ route('admin.employees.show', ['employee' => $data->id]) }}"
                                class="d-flex align-items-center gap-2">

                                <input type="date" name="date" class="form-control form-control-sm"
                                    style="max-width: 180px;" value="{{ request('date', now()->toDateString()) }}"
                                    max="{{ now()->toDateString() }}">

                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="bi bi-funnel-fill me-1"></i> Filter
                                </button>

                                <a href="{{ route('admin.employees.show', ['employee' => $data->id]) }}"
                                    class="btn btn-sm btn-light-secondary">
                                    Reset
                                </a>

                            </form>
                        </div>

                        <div class="card-body">

                            <div class="mb-3">
                                <small class="text-muted">
                                    Showing activity for
                                    <strong>
                                        {{ \Carbon\Carbon::parse(request('date', now()))->format('d M Y') }}
                                    </strong>
                                </small>
                            </div>

                            <table class="table table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Active Tab</th>
                                        <th>Duration</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($TrackingData as $track)
                                        <tr>
                                            <td>
                                                {{ \Carbon\Carbon::parse($track->date_time)->format('d M, h:i A') }}
                                            </td>

                                            <td>
                                                <span class="badge badge-light-info">
                                                    {{ $track->active_tabs }}
                                                </span>
                                            </td>

                                            <td>
                                                {{ gmdate('i:s', $track->active_tabs_time) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">
                                                No activity data for selected date.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>

                            {{-- PAGINATION --}}
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="text-muted fs-7">
                                    Showing {{ $TrackingData->firstItem() }}
                                    – {{ $TrackingData->lastItem() }}
                                    of {{ $TrackingData->total() }} entries
                                </div>

                                {!! $TrackingData->appends(Request::all())->links() !!}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        @php
            $screenshotsData = [];
            foreach ($screenshots as $shot) {
                $screenshotsData[] = [
                    'image' => asset($shot->screenshot_path),
                    'time' => \Carbon\Carbon::parse($shot->date_time)->format('d M, h:i A'),
                ];
            }
        @endphp

        <div class="modal fade" id="screenshotModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header py-3">
                        <h5 class="modal-title">Screenshot Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center position-relative">

                        {{-- PREV --}}
                        <button type="button"
                            class="btn btn-icon btn-light position-absolute top-50 start-0 translate-middle-y ms-3"
                            id="prevShot">
                            <i class="bi bi-chevron-left fs-2"></i>
                        </button>

                        {{-- IMAGE --}}
                        <img id="modalScreenshot" class="img-fluid rounded shadow" style="max-height: 70vh;"
                            alt="Screenshot">

                        {{-- NEXT --}}
                        <button type="button"
                            class="btn btn-icon btn-light position-absolute top-50 end-0 translate-middle-y me-3"
                            id="nextShot">
                            <i class="bi bi-chevron-right fs-2"></i>
                        </button>

                        {{-- TIME --}}
                        <div class="text-muted mt-2 fs-7" id="modalTime"></div>

                    </div>

                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const screenshots = @json($screenshotsData);
                let currentIndex = 0;

                const modalImage = document.getElementById('modalScreenshot');
                const modalTime = document.getElementById('modalTime');

                function renderSlide(index) {
                    if (!screenshots.length) return;
                    modalImage.src = screenshots[index].image;
                    modalTime.innerText = screenshots[index].time;
                }

                const modal = document.getElementById('screenshotModal');

                modal.addEventListener('show.bs.modal', function(event) {
                    currentIndex = parseInt(event.relatedTarget.dataset.index);
                    renderSlide(currentIndex);
                });

                document.getElementById('nextShot').addEventListener('click', function() {
                    currentIndex = (currentIndex + 1) % screenshots.length;
                    renderSlide(currentIndex);
                });

                document.getElementById('prevShot').addEventListener('click', function() {
                    currentIndex = (currentIndex - 1 + screenshots.length) % screenshots.length;
                    renderSlide(currentIndex);
                });

            });
        </script>

        {{-- <div class="modal fade" id="screenshotModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header py-3">
                        <h5 class="modal-title">Screenshot Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body text-center p-3">
                        <img id="modalScreenshot" src="" class="img-fluid rounded shadow"
                            style="max-height: 65vh; width: auto;" alt="Screenshot">

                        <div class="text-muted mt-2 fs-7" id="modalTime"></div>
                    </div>

                </div>
            </div>
        </div>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = document.getElementById('screenshotModal');

                modal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const image = button.getAttribute('data-image');
                    const time = button.getAttribute('data-time');

                    document.getElementById('modalScreenshot').src = image;
                    document.getElementById('modalTime').innerText = time;
                });
            });
        </script> --}}
    @endsection
</x-admin-layout>
