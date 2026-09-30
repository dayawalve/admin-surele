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
                            Employees List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Employees</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">

                        <a href="{{ route('admin.employees.create') }}" class="btn btn-sm fw-bold btn-primary">Create</a>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    <div class="card shadow-sm border-0">

                        <!-- CARD HEADER -->
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">

                            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                                <h3 class="card-title mb-0 fw-bold">
                                    <i class="bi bi-mortarboard-fill text-primary me-2"></i>
                                    Employees List
                                </h3>
                            </div>

                            <div class="card-toolbar">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    <input type="text" id="collegeSearch"
                                        class="form-control form-control-solid w-250px ps-13"
                                        placeholder="Search employee" />
                                </div>
                            </div>

                            {{-- <div class="d-flex gap-2">
                                <div class="m-0">
                                    <!--begin::Menu toggle-->
                                    <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>Filter</a>
                                    <!--end::Menu toggle-->
                                    <!--begin::Menu 1-->
                                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                        id="kt_menu_student_filter">

                                        <div class="px-7 py-5">
                                            <div class="fs-5 text-dark fw-bold">Filter employees</div>
                                        </div>

                                        <div class="separator border-gray-200"></div>

                                        <form method="GET" action="{{ route('admin.employees.index') }}">
                                            <div class="px-7 py-5">
                                              
                                                <div class="mb-6">
                                                    <label class="form-label fw-semibold">Status</label>
                                                    <select name="is_active" class="form-select form-select-solid"
                                                        data-placeholder="Select Status">
                                                        <option value="">All</option>
                                                        <option value="1"
                                                            {{ request('is_active') === '1' ? 'selected' : '' }}>Active
                                                        </option>
                                                        <option value="0"
                                                            {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="d-flex justify-content-end">
                                                    <a href="{{ route('admin.employees.index') }}"
                                                        class="btn btn-sm btn-light btn-active-light-primary me-2">
                                                        Reset
                                                    </a>
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        Apply
                                                    </button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                    <!--end::Menu 1-->
                                </div>
                            </div> --}}
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body py-4">
                            <div class="table-responsive">

                                <table id="collegeTable" class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead class="bg-light">
                                        <tr class="text-muted fw-semibold fs-7 text-uppercase">
                                            <th>#</th>
                                            <th>Employee</th>
                                            <th>Phone</th>
                                            <th>Designation</th>
                                            <th>Login Status</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody class="fw-semibold text-gray-600">
                                        @if(isset($data) && $data->isEmpty())
                                            <tr>
                                                <td colspan="8" class="text-center">No records found.</td>
                                            </tr>
                                        @endif
                                        @foreach ($data as $key => $value)
                                            <tr id="student_{{ $value->id }}"
                                                class="{{ $value->is_deleted ? 'text-danger' : '' }}">

                                                <td>#{{ ++$i }}</td>

                                                <!-- STUDENT -->
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">

                                                        <div>
                                                            <div class="fw-bold">
                                                                {{ $value->name }}
                                                                @if ($value->is_deleted)
                                                                    <span
                                                                        class="badge badge-light-danger ms-1">Deleted</span>
                                                                @endif
                                                            </div>
                                                            <small class="text-muted">{{ $value->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- PHONE -->
                                                <td>{{ $value->phone ?? 'N/A' }}</td>

                                                <!-- DESIGNATION -->
                                                <td>{{ $value->designation ?? 'N/A' }}</td>
                                                <!-- LOGIN STATUS -->
                                                <td>
                                                    @if ($value->is_logged_in == 1)
                                                        <span class="badge badge-light-success">
                                                            <i class="bi bi-check-circle me-1"></i> Logged In
                                                        </span>
                                                    @else
                                                        <span class="badge badge-light-danger">
                                                            <i class="bi bi-pause-circle me-1"></i> Logout
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- STATUS -->
                                                <td>
                                                    @if ($value->status == 'active')
                                                        <span class="badge badge-light-success">
                                                            <i class="bi bi-check-circle me-1"></i> Active
                                                        </span>
                                                    @else
                                                        <span class="badge badge-light-warning">
                                                            <i class="bi bi-pause-circle me-1"></i> Inactive
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- ACTIONS -->
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-1">

                                                        <a href="{{ route('admin.employees.show', $value->id) }}"
                                                            class="btn btn-sm btn-icon btn-light-primary"
                                                            data-bs-toggle="tooltip" title="View">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        
                                                        <a href="{{ route('admin.employees.edit', $value->id) }}"
                                                            class="btn btn-sm btn-icon btn-light-warning"
                                                            data-bs-toggle="tooltip" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>

                                                        <a href="{{ route('admin.employees.status', $value->id) }}"
                                                            class="btn btn-sm btn-icon btn-light-info"
                                                            data-bs-toggle="tooltip"
                                                            title="{{ $value->is_active ? 'Deactivate' : 'Activate' }}">
                                                            <i
                                                                class="bi {{ $value->is_active ? 'bi-pause' : 'bi-play' }}"></i>
                                                        </a>

                                                        <form action="{{ route('admin.employees.destroy', $value->id) }}"
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
