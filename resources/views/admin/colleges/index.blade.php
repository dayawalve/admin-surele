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
                            Colleges List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Colleges</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <div class="m-0">
                            <!--begin::Menu toggle-->
                            {{-- <a href="#" class="btn btn-sm btn-flex btn-secondary fw-bold" data-kt-menu-trigger="click"
                                data-kt-menu-placement="bottom-end">
                                <i class="ki-duotone ki-filter fs-6 text-muted me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>Filter</a> --}}
                            <!--end::Menu toggle-->
                            <!--begin::Menu 1-->
                            {{-- <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                                id="kt_menu_64b77617dd0a2">
                                <!--begin::Header-->
                                <div class="px-7 py-5">
                                    <div class="fs-5 text-dark fw-bold">Filter Options</div>
                                </div>
                                <!--end::Header-->
                                <!--begin::Menu separator-->
                                <div class="separator border-gray-200"></div>
                                <!--end::Menu separator-->
                                <!--begin::Form-->
                                <div class="px-7 py-5">
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Status:</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <div>
                                            <select class="form-select form-select-solid" multiple="multiple"
                                                data-kt-select2="true" data-close-on-select="false"
                                                data-placeholder="Select option"
                                                data-dropdown-parent="#kt_menu_64b77617dd0a2" data-allow-clear="true">
                                                <option></option>
                                                <option value="1">Approved</option>
                                                <option value="2">Pending</option>
                                                <option value="2">In Process</option>
                                                <option value="2">Rejected</option>
                                            </select>
                                        </div>
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Member Type:</label>
                                        <!--end::Label-->
                                        <!--begin::Options-->
                                        <div class="d-flex">
                                            <!--begin::Options-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                <input class="form-check-input" type="checkbox" value="1" />
                                                <span class="form-check-label">Author</span>
                                            </label>
                                            <!--end::Options-->
                                            <!--begin::Options-->
                                            <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="2"
                                                    checked="checked" />
                                                <span class="form-check-label">Customer</span>
                                            </label>
                                            <!--end::Options-->
                                        </div>
                                        <!--end::Options-->
                                    </div>
                                    <!--end::Input group-->
                                    <!--begin::Actions-->
                                    <div class="d-flex justify-content-end">
                                        <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                            data-kt-menu-dismiss="true">Reset</button>
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            data-kt-menu-dismiss="true">Apply</button>
                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Form-->
                            </div> --}}
                            <!--end::Menu 1-->
                        </div>
                        <a href="{{ route('admin.colleges.create') }}" class="btn btn-sm fw-bold btn-primary">Create</a>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    <div class="card shadow-sm border-0">

                        <!-- CARD HEADER -->
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <h3 class="card-title mb-0 fw-bold">
                                <i class="bi bi-bank text-primary me-2"></i>
                                College List
                            </h3>
                        </div>

                        <div class="card-toolbar">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span><span class="path2"></span>
                                </i>
                                <input type="text" id="collegeSearch"
                                    class="form-control form-control-solid w-250px ps-13" placeholder="Search College" />
                            </div>
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body py-4">
                            <div class="table-responsive">

                                <table id="collegeTable" class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead class="bg-light">
                                        <tr class="text-muted fw-semibold fs-7 text-uppercase">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($data as $key => $value)
                                            <tr id="college_{{ $value->id }}"
                                                class="{{ $value->is_deleted ? 'text-danger' : '' }}">

                                                <!-- SR NO -->
                                                <td>#{{ ++$i }}</td>

                                                <!-- NAME WITH AVATAR -->
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="symbol symbol-35px symbol-circle bg-light-primary">
                                                            <span class="text-primary fw-bold">
                                                                {{ strtoupper(substr($value->name, 0, 1)) }}
                                                            </span>
                                                        </div>

                                                        <div>
                                                            <div class="fw-bold">
                                                                {{ $value->name }}
                                                                @if ($value->is_deleted)
                                                                    <span
                                                                        class="badge badge-light-danger ms-1">Deleted</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- EMAIL -->
                                                <td>{{ $value->email }}</td>

                                                <!-- PHONE -->
                                                <td>{{ $value->phone }}</td>

                                                <!-- STATUS -->
                                                <td>
                                                    @if ($value->is_active)
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

                                                        <a href="{{ route('admin.colleges.status', $value->id) }}"
                                                            class="btn btn-sm btn-icon btn-light-info"
                                                            data-bs-toggle="tooltip"
                                                            title="{{ $value->is_active ? 'Deactivate' : 'Activate' }}">
                                                            <i
                                                                class="bi {{ $value->is_active ? 'bi-pause' : 'bi-play' }}"></i>
                                                        </a>

                                                        <a href="{{ route('admin.colleges.edit', $value->id) }}"
                                                            class="btn btn-sm btn-icon btn-light-warning"
                                                            data-bs-toggle="tooltip" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>

                                                        <form action="{{ route('admin.colleges.destroy', $value->id) }}"
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
