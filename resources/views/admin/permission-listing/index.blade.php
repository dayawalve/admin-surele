<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Permissions List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Permissions</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ route('admin.permission-listing.create') }}"
                            class="btn btn-sm fw-bold btn-primary">Create</a>
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
                                            <th class="min-w-125px">Sr.No</th>
                                            <th class="min-w-125px">Controller Name</th>
                                            <th class="min-w-125px">Permission Name</th>
                                            <th class="text-end min-w-100px">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600 fw-semibold">
                                        @foreach ($data as $key => $value)
                                            <tr class="fs-6 fw-normal">
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $value->controller }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td style="display:flex;">
                                                    <a href="{{ route('admin.permission-listing.edit', $value->id) }}"
                                                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                                        data-bs-trigger="hover" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Click To Edit">
                                                        <i class="bi bi-vector-pen fs-3"></i>
                                                    </a>
                                                    <form
                                                        action="{{ route('admin.permission-listing.destroy', $value->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm ConfirmDelete"
                                                            data-bs-trigger="hover" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" title="Click To Delete">
                                                            <i class="bi bi-trash fs-3"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {!! $data->appends(Request::all())->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
