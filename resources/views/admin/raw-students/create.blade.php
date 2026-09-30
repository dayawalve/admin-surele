<x-admin-layout>
    @section('content')
        {{-- <div class="card">
            <div class="card-header">
                <h3>Import Raw Students</h3>
            </div>

            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.raw.students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="file" name="file" required class="form-control mb-3">

                    <button type="submit" class="btn btn-primary">
                        Upload Excel
                    </button>
                </form>
            </div>
        </div> --}}

               <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add Raw Students</h1>
                </div>
            </div>
            <div class="app-content flex-column-fluid">
                <div class="app-container container-fluid">
                    <div class="d-flex flex-column-fluid">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card mb-5 mb-xl-10">
                                        <div id="kt_account_settings_profile_details" class="collapse show">
                                            <form class="form" action="{{ route('admin.raw-students.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="card-body border-top p-9">
                                                    
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-3 col-form-label required fw-semibold fs-6">Import
                                                            Students
                                                        </label>
                                                        <div class="col-lg-9">
                                                            <input type="file" name="file"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                data-bvalidator="required" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <a href="{{ route('admin.raw-students.index') }}"
                                                        class="btn btn-light btn-active-light-primary me-2">Discard</a>
                                                    <button type="submit" class="btn btn-success"
                                                        id="kt_account_profile_details_submit">Upload Excel</button>
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
        </div>
    @endsection
</x-admin-layout>
