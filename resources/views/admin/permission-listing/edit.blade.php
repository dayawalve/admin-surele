<x-admin-layout>
    @section('content')
        <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
            <div class="toolbar" id="kt_toolbar">
                <!--begin::Container-->
                <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                    <!--begin::Page title-->
                    <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                        data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                        class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                        <!--begin::Title-->
                        <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Permission</h1>
                        <!--end::Title-->
                        <!--begin::Separator-->
                        <span class="h-20px border-gray-200 border-start mx-4"></span>
                        <!--end::Separator-->
                    </div>
                    <!--end::Page title-->
                </div>
                <!--end::Container-->
            </div>
            <div class="d-flex flex-column-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card card-custom example example-compact">

                                <form action="{{ route('admin.permission-listing.update', $data->id) }}" autocomplete="off"
                                    method="POST" class="form" id="FormId" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="mb-5">
                                            <div class="form-group row">
                                                <label class="col-2 col-form-label">Permission Name*</label>
                                                <div class="col-10">
                                                    <input type="text" data-bvalidator="required" class="form-control"
                                                        value="{{ $data->name }}" name="name"
                                                        placeholder="Enter Permission Name" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-5">
                                            <div class="form-group row">
                                                <label class="col-2 col-form-label">Controller Name*</label>
                                                <div class="col-10">
                                                    <input type="text" data-bvalidator="required" class="form-control"
                                                        value="{{ $data->controller }}" name="controller"
                                                        placeholder="Enter Controller Name" />
                                                </div>
                                            </div>
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
    @endsection
</x-admin-layout>
