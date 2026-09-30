<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit User</h1>
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
                                            <form action="{{ route('admin.colleges.update', $data->id) }}" autocomplete="off"
                                                method="POST" class="form" id="FormId" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="card-body border-top p-9">
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Full
                                                            Name</label>
                                                        <div class="col-lg-8">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <input type="text" data-bvalidator="required"
                                                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                        name="name" placeholder="Enter Full Name"
                                                                        value="{{ $data->name }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Code
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="code"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                placeholder="Enter code" value="{{ $data->code }}"
                                                                data-bvalidator="required" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Phone
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="phone"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                placeholder="Enter phone" value="{{ $data->phone }}"
                                                                data-bvalidator="required" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Email
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="email"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                placeholder="Enter email" value="{{ $data->email }}"
                                                                data-bvalidator="required,email" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Address
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="address"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                placeholder="Enter address" value="{{ $data->address }}"
                                                                data-bvalidator="required" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">City
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="city"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                placeholder="Enter city" value="{{ $data->city }}"
                                                                data-bvalidator="required" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">State
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="state"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                placeholder="Enter state" value="{{ $data->state }}"
                                                                data-bvalidator="required" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <a href="{{ route('admin.colleges.index') }}" class="btn btn-light btn-active-light-primary me-2">Discard</a>
                                                    <button type="submit" class="btn btn-primary"
                                                        id="kt_account_profile_details_submit">Save</button>
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
