<x-admin-layout>
    @section('content')
        <style>
            .table tbody tr:hover {
                background-color: #f9fafb;
                transition: 0.2s ease-in-out;
            }

            .symbol {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        </style>
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Training Programs List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Training Programs</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <div class="m-0">
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
                                id="kt_menu_training_filter">

                                {{-- Header --}}
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Training Programs</div>
                                </div>

                                <div class="separator border-gray-200"></div>

                                {{-- FORM --}}
                                <form method="GET" action="{{ route('admin.training-programs.index') }}">
                                    <div class="px-7 py-5">

                                        {{-- Training Mode --}}
                                        <div class="mb-6">
                                            <label class="form-label fw-semibold">Training Mode</label>
                                            <select name="training_mode"
                                                    class="form-select form-select-solid"
                                                    data-kt-select2="true"
                                                    data-placeholder="Select Mode"
                                                    data-dropdown-parent="#kt_menu_training_filter"
                                                    data-allow-clear="true">
                                                <option value=""></option>
                                                <option value="Online"  {{ request('training_mode') == 'Online' ? 'selected' : '' }}>Online</option>
                                                <option value="Offline" {{ request('training_mode') == 'Offline' ? 'selected' : '' }}>Offline</option>
                                                <option value="Hybrid"  {{ request('training_mode') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                            </select>
                                        </div>

                                        {{-- Training Status --}}
                                        <div class="mb-6">
                                            <label class="form-label fw-semibold">Status</label>
                                            <select name="status"
                                                    class="form-select form-select-solid"
                                                    data-placeholder="Select Status">
                                                <option value="">All</option>
                                                <option value="Active"   {{ request('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="d-flex justify-content-end">
                                            <a href="{{ route('admin.training-programs.index') }}"
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
                        </div>
                        <a href="{{ route('admin.training-programs.create') }}" class="btn btn-sm fw-bold btn-primary">Create</a>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    <div class="card shadow-sm border-0">

                        <!-- CARD HEADER -->
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <h3 class="card-title mb-0 fw-bold">
                                <i class="bi bi-journal-code text-primary me-2"></i>
                                Training Programs
                            </h3>
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body py-4">
                            <div class="table-responsive">

                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead class="bg-light">
                                        <tr class="text-muted fw-semibold fs-7 text-uppercase">
                                            <th>#</th>
                                            <th>Program Code</th>
                                            <th>Program Name</th>
                                            <th>Duration</th>
                                            <th>Mode</th>
                                            <th>Fees</th>
                                            <th>Status</th>
                                            <th class="text-end min-w-120px">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($data as $key => $value)
                                            <tr id="program_{{ $value->id }}"
                                                class="{{ $value->is_deleted ? 'text-danger' : '' }}">

                                                <!-- SR NO -->
                                                <td>#{{ ++$i }}</td>

                                                <!-- PROGRAM CODE -->
                                                <td>
                                                    <span class="badge badge-light-info fw-bold">
                                                        TP-{{ $value->program_code }}
                                                    </span>
                                                </td>

                                                <!-- PROGRAM NAME -->
                                                <td class="fw-bold">{{ $value->program_name }}</td>

                                                <!-- DURATION -->
                                                <td>
                                                    <span class="badge badge-light-info fw-bold">
                                                        {{ $value->duration_weeks }} Weeks
                                                    </span>
                                                </td>

                                                <!-- MODE -->
                                                <td>
                                                    @if ($value->training_mode === 'Online')
                                                        <span class="badge badge-light-primary">
                                                            <i class="bi bi-laptop me-1"></i> Online
                                                        </span>
                                                    @elseif ($value->training_mode === 'Offline')
                                                        <span class="badge badge-light-success">
                                                            <i class="bi bi-building me-1"></i> Offline
                                                        </span>
                                                    @elseif ($value->training_mode === 'Hybrid')
                                                        <span class="badge badge-light-warning">
                                                            <i class="bi bi-shuffle me-1"></i> Hybrid
                                                        </span>
                                                    @else
                                                        <span class="badge badge-light-dark">
                                                            <i class="bi bi-question-circle me-1"></i> Other
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- FEES -->
                                                <td class="fw-bold text-success">
                                                    ₹{{ number_format($value->fees) }}
                                                </td>

                                                <!-- STATUS -->
                                                <td>
                                                    @if ($value->status === 'Active')
                                                        <span class="badge badge-light-success">
                                                            <i class="bi bi-check-circle me-1"></i> Active
                                                        </span>
                                                    @else
                                                        <span class="badge badge-light-danger">
                                                            <i class="bi bi-x-circle me-1"></i> Inactive
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- ACTIONS -->
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-1">

                                                        <a href="{{ route('admin.training-programs.status', $value->id) }}"
                                                        class="btn btn-sm btn-icon btn-light-info"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $value->status === 'Active' ? 'Deactivate' : 'Activate' }}">
                                                            <i class="bi {{ $value->status === 'Active' ? 'bi-pause' : 'bi-play' }}"></i>
                                                        </a>

                                                        <a href="{{ route('admin.training-programs.show', $value->id) }}"
                                                        class="btn btn-sm btn-icon btn-light-primary"
                                                        data-bs-toggle="tooltip" title="View">
                                                            <i class="bi bi-eye"></i>
                                                        </a>

                                                        <a href="{{ route('admin.training-programs.edit', $value->id) }}"
                                                        class="btn btn-sm btn-icon btn-light-warning"
                                                        data-bs-toggle="tooltip" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>

                                                        <form action="{{ route('admin.training-programs.destroy', $value->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            @if ($value->is_deleted == 0)
                                                                <button type="button"
                                                                    class="btn btn-sm btn-icon btn-light-danger ConfirmDelete"
                                                                    data-bs-toggle="tooltip" title="Delete">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-sm btn-icon btn-light-success RestoreDelete"
                                                                    data-bs-toggle="tooltip" title="Restore">
                                                                    <i class="bi bi-arrow-repeat"></i>
                                                                </button>
                                                            @endif
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
    @endsection
</x-admin-layout>
