<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Employee</h1>
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
                                            <form class="form" action="{{ route('admin.employees.update', $data->id) }}"
                                                method="POST" enctype="multipart/form-data" id="FormId">
                                                @csrf
                                                @method('PUT')

                                                <div class="card mb-8 shadow-sm">
                                                    <div class="card-header bg-light">
                                                        <h3 class="card-title fw-bold">
                                                            <i class="ki-duotone ki-user fs-2 me-2"></i>
                                                            Employee Profile
                                                        </h3>
                                                    </div>

                                                    <div class="card-body p-7">
                                                        <div class="row align-items-center">
                                                            <div class="col-lg-3 text-center">
                                                                <div class="image-input image-input-outline"
                                                                    data-kt-image-input="true"
                                                                    style="background-image: url('{{ asset($data->image ?? 'public/custom-img/blank.png') }}')">
                                                                    <div class="image-input-wrapper w-150px h-150px"
                                                                        style="background-image: url('{{ asset($data->image ?? 'public/custom-img/blank.png') }}')">
                                                                    </div>

                                                                    <label
                                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                        data-kt-image-input-action="change"
                                                                        data-bs-toggle="tooltip" title="Change avatar">
                                                                        <i class="ki-duotone ki-pencil fs-7">
                                                                            <span class="path1"></span>
                                                                            <span class="path2"></span>
                                                                        </i>
                                                                        <input type="file" name="image" class="imgVal"
                                                                            accept=".png,.jpg,.jpeg" />
                                                                    </label>
                                                                </div>
                                                                <div class="text-muted fs-7 mt-2">
                                                                    JPG, PNG allowed
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-9">
                                                                <div class="row g-5">
                                                                    <div class="col-lg-6">
                                                                        <label class="required fw-semibold">Employee
                                                                            Code</label>
                                                                        <input type="text" name="employee_code"
                                                                            class="form-control form-control-solid"
                                                                            value="{{ $data->employee_code }}">
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label class="required fw-semibold">Full
                                                                            Name</label>
                                                                        <input type="text" name="name"
                                                                            class="form-control form-control-solid"
                                                                            value="{{ $data->name }}">
                                                                    </div>

                                                                    <div class="col-lg-12">
                                                                        <label class="required fw-semibold">Password</label>
                                                                        <input type="text" name="password"
                                                                            class="form-control form-control-solid"
                                                                            placeholder="Enter password">
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card mb-8 shadow-sm">
                                                    <div class="card-header">
                                                        <h3 class="card-title fw-bold">
                                                            <i class="ki-duotone ki-phone fs-2 me-2"></i>
                                                            Contact Information
                                                        </h3>
                                                    </div>

                                                    <div class="card-body p-7">
                                                        <div class="row g-5">
                                                            <div class="col-lg-6">
                                                                <label class="required fw-semibold">Phone</label>
                                                                <input type="text" name="phone"
                                                                    class="form-control form-control-solid"
                                                                    value="{{ $data->phone }}">
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <label class="required fw-semibold">Email</label>
                                                                <input type="email" name="email"
                                                                    class="form-control form-control-solid"
                                                                    value="{{ $data->email }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card mb-8 shadow-sm">
                                                    <div class="card-header">
                                                        <h3 class="card-title fw-bold">
                                                            <i class="ki-duotone ki-briefcase fs-2 me-2"></i>
                                                            Job & Salary Details
                                                        </h3>
                                                    </div>

                                                    <div class="card-body p-7">
                                                        <div class="row g-5">
                                                            <div class="col-lg-6">
                                                                <label class="required fw-semibold">Department</label>
                                                                <input type="text" name="department"
                                                                    class="form-control form-control-solid"
                                                                    value="{{ $data->department }}">
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <label class="required fw-semibold">Designation</label>
                                                                <input type="text" name="designation"
                                                                    class="form-control form-control-solid"
                                                                    value="{{ $data->designation }}">
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label class="required fw-semibold">Salary</label>
                                                                <input type="number" name="salary"
                                                                    class="form-control form-control-solid"
                                                                    value="{{ $data->salary }}">
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label class="required fw-semibold">Date of Birth</label>
                                                                <input type="date" name="date_of_birth"
                                                                    class="form-control form-control-solid"
                                                                    value="{{ $data->date_of_birth }}">
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label class="required fw-semibold">Date of Joining</label>
                                                                <input type="date" name="date_of_joining"
                                                                    class="form-control form-control-solid"
                                                                    value="{{ $data->date_of_joining }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-footer d-flex justify-content-end gap-3 py-6">
                                                    <a href="{{ route('admin.employees.index') }}"
                                                        class="btn btn-light px-6">
                                                        Cancel
                                                    </a>

                                                    <button type="submit" class="btn btn-primary px-8">
                                                        <i class="ki-duotone ki-check fs-4 me-2"></i>
                                                        Update Employee
                                                    </button>
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

<script type="text/javascript">
    function passwordFormat(password) {
        regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/); // number, a-z, A-Z, min 8 chars
        if (regex.test(password))
            return true;
        return false;
    }
</script>
