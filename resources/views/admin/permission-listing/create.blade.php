<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add Permission</h1>
                </div>
            </div>
            <div class="app-content flex-column-fluid">
                <div class="app-container container-fluid">
                    <div class="d-flex flex-column-fluid">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom example example-compact">
                                        <form action="{{ route('admin.permission-listing.store') }}" autocomplete="off"
                                            method="POST" class="form" id="FormId" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body border-top p-9">
                                                <div class="row mb-6">
                                                    <label
                                                        class="col-lg-2 col-form-label required fw-semibold fs-6">Permisson
                                                        Name
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <input type="text" name="permission_name"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            data-bvalidator="required" />
                                                    </div>
                                                </div>
                                                <div class="row mb-6">
                                                    <label
                                                        class="col-lg-2 col-form-label required fw-semibold fs-6">Controller
                                                        Name
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <input type="text" name="controller_name"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            data-bvalidator="required" />
                                                    </div>
                                                </div>
                                                <div class="row mb-6">
                                                    <label class="col-lg-2 col-form-label fw-semibold fs-6"><span
                                                            class="text-danger">Note</span>: Check if route is
                                                        resource</label>
                                                    <div class="col-lg-10 d-flex align-items-center">
                                                        <input class="form-check-input" name="resource"
                                                            type="checkbox">
                                                    </div>
                                                </div>
                                                <div class="row mb-6">
                                                    <label
                                                        class="col-lg-2 col-form-label required fw-semibold fs-6">Role Name
                                                    </label>
                                                    @foreach ($RoleList as $key => $item)
                                                        <div class="col-lg-1">
                                                            <div class="d-flex align-items-center mt-3">
                                                                <label class="form-check form-check-inline ">
                                                                    <input class="form-check-input" name="roles[]"
                                                                        @if ($key == $RoleList->count() - 1) data-bvalidator="min[1],required" @endif
                                                                        type="checkbox" value="{{ $item->id }}" />
                                                                    <span class="fw-bold ps-2 fs-5 ">{{ $item->name }}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-2"></div>
                                                    <div class="col-10">
                                                        <button type="submit" class="btn btn-success mr-2"
                                                            name="submitButton">Submit</button>
                                                        <a href="{{ route('admin.permission-listing.index') }}"
                                                            class="btn btn-light-danger">Cancel</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
