<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add Role</h1>
                </div>
            </div>
            <div class="app-content flex-column-fluid">
                <div class="app-container container-fluid">
                    <div class="d-flex flex-column-fluid">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom example example-compact">
                                        <form action="{{ route('admin.role-permission.store') }}" autocomplete="off" method="POST"
                                            class="form" id="FormId" enctype="multipart/form-data">
                                            @csrf
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <div class="mb-4">
                                                        <div class="form-group row">
                                                            <label class="col-2 col-form-label">Role Name *</label>
                                                            <div class="col-10">
                                                                <input type="text" data-bvalidator="maxlen[70],required" class="form-control" name="role" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
            
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-2"></div><div class="col-10">
                                                        <button type="submit" class="btn btn-success mr-2" name="submitButton">Submit</button>
                                                        <a href="{{ route('admin.role-permission.index') }}" class="btn btn-light-danger">Cancel</a>
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
