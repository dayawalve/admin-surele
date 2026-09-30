<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Users List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Users</li>
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
                            <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
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
                                    <!--begin::Input group-->
                                    <div class="mb-10">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Notifications:</label>
                                        <!--end::Label-->
                                        <!--begin::Switch-->
                                        <div
                                            class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="notifications" checked="checked" />
                                            <label class="form-check-label">Enabled</label>
                                        </div>
                                        <!--end::Switch-->
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
                            </div>
                            <!--end::Menu 1-->
                        </div> --}}
                        <a href="{{ route('admin.users.create') }}" class="btn btn-sm fw-bold btn-primary">Create</a>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card">
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th class="">Sr No.</th>
                                            <th class="min-w-125px">User</th>
                                            <th class="min-w-125px">User Role</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @foreach ($data as $key => $value)
                                            <tr class="fs-6 fw-normal @if ($value->is_deleted == 1) text-danger @endif"
                                                id="{{ $value->id }}">
                                                <td>{{ ++$i }}</td>
                                                <td class="d-flex align-items-center">
                                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                        <a>
                                                            <div class="symbol-label">
                                                                <img src="{{ url('/') }}/{{ $value->photo }}"
                                                                    alt="Emma Smith" class="w-100" />
                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div class="d-flex align-items-center">
                                                            <span class="mb-1 me-3">{{ $value->fname }}
                                                                {{ $value->lname }}</span>
                                                            @if (isset($value->email_verified_at))
                                                                <span class="text-info fs-8" data-bs-trigger="hover"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    title="@ {{ Helper::datetimeFormat($value->email_verified_at) }}"><i
                                                                        class="bi bi-patch-check-fill fs-5"></i></span>
                                                            @else
                                                                <span class="text-danger fs-8 VerifyUser" role="button"
                                                                    data-bs-trigger="hover" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" title="Click to Verify"></i><i
                                                                        class="bi bi-patch-check"></i>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <span>{{ $value->email }}</span>
                                                    </div>
                                                    @if ($value->is_deleted == 1)
                                                        <span class="fs-8 ms-3 badge badge-light-info d-block">User
                                                            Deleted</span>
                                                    @endif
                                                </td>
                                                @if ($value->roles->first())
                                                    <td>{{ $value->roles->first()->name }}</td>
                                                @else
                                                    <td>NA</td>
                                                @endif
                                                <td>
                                                    <div class="d-flex justify-content-end">
                                                        @if (isset($value->status) && $value->status == 1)
                                                            <a href="{{ route('admin.ChangeStatus', $value->id) }}"
                                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 "
                                                                data-bs-trigger="hover" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Click To Block">
                                                                <i class="bi bi-check2 fs-3"></i>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('admin.ChangeStatus', $value->id) }}"
                                                                class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                                data-bs-trigger="hover" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" title="Click To Unblock">
                                                                <i class="bi bi-x fs-3 text-danger"></i>
                                                            </a>
                                                        @endif
                                                        <a href="{{ route('admin.users.edit', $value->id) }}"
                                                            class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 "
                                                            data-bs-trigger="hover" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Click To Edit">
                                                            <i class="bi bi-vector-pen fs-3"></i>
                                                        </a>
                                                        @if ($value->is_deleted == 0)
                                                            <form action="{{ route('admin.users.destroy', $value->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm ConfirmDelete "
                                                                    data-bs-trigger="hover" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" title="Click To Delete">
                                                                    <i class="bi bi-trash fs-3"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form action="{{ route('admin.users.destroy', $value->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button"
                                                                    class="btn btn-icon btn-bg-light btn-active-color-info btn-sm RestoreDelete "
                                                                    data-bs-trigger="hover" data-bs-toggle="tooltip"
                                                                    data-bs-placement="top" title="Click To Restore">
                                                                    <i class="bi bi-recycle fs-3"></i>
                                                                </button>
                                                            </form>
                                                        @endif
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
