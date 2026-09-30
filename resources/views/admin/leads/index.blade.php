<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <!-- Toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Leads Management
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Leads</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">

                    <!-- Metric Cards -->
                    <div class="row g-5 g-xl-8 mb-6">
                        <div class="col-md-4">
                            <div class="card card-bordered shadow-sm bg-light-primary">
                                <div class="card-body p-6 d-flex align-items-center">
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label bg-primary text-white">
                                            <i class="bi bi-funnel-fill fs-2 text-white"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fs-4 fw-bolder text-dark">{{ $totalLeads ?? 0 }}</div>
                                        <div class="fs-7 text-muted fw-semibold">Total Leads</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Leads Card -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <h3 class="fw-bold m-0 text-gray-800">
                                    <i class="bi bi-person-lines-fill text-primary me-2"></i> All Leads
                                </h3>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            @if(isset($leads) && count($leads) > 0)
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                                        <thead>
                                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-600">
                                            @foreach($leads as $key => $lead)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="text-dark fw-bold">{{ $lead->name ?? '-' }}</td>
                                                    <td>{{ $lead->email ?? '-' }}</td>
                                                    <td>{{ $lead->phone ?? '-' }}</td>
                                                    <td>
                                                        <span class="badge badge-light-primary">{{ $lead->status ?? 'New' }}</span>
                                                    </td>
                                                    <td>{{ isset($lead->created_at) ? \Carbon\Carbon::parse($lead->created_at)->format('M d, Y') : '-' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <!-- Clean Empty / Placeholder State -->
                                <div class="text-center py-15">
                                    <div class="symbol symbol-100px mb-5">
                                        <span class="symbol-label bg-light-primary">
                                            <i class="bi bi-funnel text-primary fs-3x"></i>
                                        </span>
                                    </div>
                                    <h3 class="fs-2 fw-bold text-gray-800 mb-2">Leads Module Configured</h3>
                                    <p class="text-muted fs-6 mb-6 mw-500px mx-auto">
                                        The Leads module has been set up successfully. When new leads are generated or imported, they will be listed and tracked here.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
