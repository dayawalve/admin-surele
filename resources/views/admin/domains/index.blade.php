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
                            Domains List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Domains</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">

                        <a href="{{ route('admin.domains.create') }}" class="btn btn-sm fw-bold btn-primary">Create</a>
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
                                    Domains List
                                </h3>
                            </div>

                            <div class="card-toolbar">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span><span class="path2"></span>
                                    </i>
                                    <input type="text" id="collegeSearch"
                                        class="form-control form-control-solid w-250px ps-13" placeholder="Search domain" />
                                </div>
                            </div>
                        </div>

                        <!-- CARD BODY -->
                        <div class="card-body py-4">
                            <div class="table-responsive">

                                <table id="DomainsTable" class="table align-middle table-row-dashed fs-6 gy-5">

                                    <!-- TABLE HEADER -->
                                    <thead class="bg-light">
                                        <tr class="text-muted fw-semibold fs-7 text-uppercase">
                                            <th style="width:80px;">#</th>
                                            <th>Employee</th>
                                            <th class="text-end" style="width:150px;">Actions</th>
                                        </tr>
                                    </thead>

                                    <!-- TABLE BODY -->
                                    <tbody class="fw-semibold text-gray-600">

                                        @if ($data->isEmpty())
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">
                                                    No records found.
                                                </td>
                                            </tr>
                                        @endif

                                        @foreach ($data as $key => $value)
                                            <tr id="employee_{{ $value->id }}"
                                                class="{{ $value->is_deleted ? 'text-danger' : '' }}">

                                                <!-- ID -->
                                                <td>#{{ ++$i }}</td>

                                                <!-- NAME + EMAIL -->
                                                <td>
                                                    <div class="fw-bold">
                                                        {{ $value->name }}

                                                        @if ($value->is_deleted)
                                                            <span class="badge badge-light-danger ms-1">
                                                                Deleted
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <small class="text-muted">
                                                        {{ $value->email }}
                                                    </small>
                                                </td>

                                                <!-- ACTIONS -->
                                                <td class="text-end">
                                                    <div class="d-flex justify-content-end gap-1">

                                                        <!-- Edit -->
                                                        <a href="{{ route('admin.domains.edit', $value->id) }}"
                                                            class="btn btn-sm btn-icon btn-light-warning"
                                                            data-bs-toggle="tooltip" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>

                                                        <!-- Delete / Restore -->
                                                        <form action="{{ route('admin.domains.destroy', $value->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            @if ($value->is_deleted == 0)
                                                                <button type="button"
                                                                    class="btn btn-sm btn-icon btn-light-danger ConfirmDelete"
                                                                    title="Delete">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            @else
                                                                <button type="button"
                                                                    class="btn btn-sm btn-icon btn-light-success RestoreDelete"
                                                                    title="Restore">
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
