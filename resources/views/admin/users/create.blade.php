<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add User</h1>
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
                                            <form class="form" action="{{ route('admin.users.store') }}" method="POST"
                                                enctype="multipart/form-data" id="FormId">
                                                @csrf
                                                <div class="card-body border-top p-9">
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Avatar</label>
                                                        <div class="col-lg-8">
                                                            <div class="image-input image-input-outline"
                                                                data-kt-image-input="true"
                                                                style="background-image: url('{{ asset('public/custom-img/blank.png') }}')">
                                                                <div class="image-input-wrapper w-125px h-125px"
                                                                    style="background-image: url('{{ asset('public/custom-img/blank.png') }}')">
                                                                </div>
                                                                <label
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="change"
                                                                    data-bs-toggle="tooltip" title="Change avatar">
                                                                    <i class="ki-duotone ki-pencil fs-7">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    <input type="file" name="profile_image"
                                                                        class="imgVal" accept=".png,.jpg,.jpeg" required />
                                                                </label>
                                                                <span
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="cancel"
                                                                    data-bs-toggle="tooltip" title="Cancel avatar">
                                                                    <i class="ki-duotone ki-cross fs-2">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                </span>
                                                            </div>
                                                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Full
                                                            Name</label>
                                                        <div class="col-lg-8">
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" data-bvalidator="required"
                                                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                        name="fname" placeholder="Enter First Name" />
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <input type="text" data-bvalidator="required"
                                                                        class="form-control form-control-lg form-control-solid"
                                                                        name="lname" placeholder="Enter Last Name" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Email
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="email"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                placeholder="Enter email"
                                                                data-bvalidator="required,email" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            New Password
                                                        </label>
                                                        <div class="col-lg-8 position-relative">
                                                            <input id="new_pass1" type="password"
                                                                data-bvalidator="passwordFormat,required"
                                                                data-bvalidator-msg="Min 8 characters including a number, letters a-z, A-Z"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 pe-10"
                                                                name="password" placeholder="Enter New Password" />

                                                            <i class="bi bi-eye-slash toggle-password" toggle="#new_pass1"
                                                                style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Confirm Password
                                                        </label>
                                                        <div class="col-lg-8 position-relative">
                                                            <input id="confirm_pass" type="password"
                                                                data-bvalidator="equal[new_pass1],required"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0 pe-10"
                                                                name="confirm_password"
                                                                data-bvalidator-msg-equal="Please enter the same password again"
                                                                placeholder="Enter Confirm Password" />

                                                            <i class="bi bi-eye-slash toggle-password"
                                                                toggle="#confirm_pass"
                                                                style="position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;"></i>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">New
                                                            Password</label>
                                                        <div class="col-lg-8">
                                                            <input id="new_pass1" type="password"
                                                                data-bvalidator="passwordFormat,required"
                                                                data-bvalidator-msg="Min 8 characters including a number, letters a-z, A-Z"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                name="password" placeholder="Enter New Password" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Confirm
                                                            Password</label>
                                                        <div class="col-lg-8">
                                                            <input type="password"
                                                                data-bvalidator="equal[new_pass1],required"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                name="password"
                                                                data-bvalidator-msg-equal="Please enter the same password again"
                                                                placeholder="Enter Confirm Password" />
                                                        </div>
                                                    </div> --}}
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Role</label>
                                                        <div class="col-lg-8">
                                                            <select
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                required name="role">
                                                                <option disabled selected>--Select Role--</option>
                                                                @foreach ($RoleList as $value)
                                                                    <option value="{{ $value->id }}">{{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <a href="{{ route('admin.users.index') }}"
                                                        class="btn btn-light btn-active-light-primary me-2">Discard</a>
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
<script>
    document.querySelectorAll(".toggle-password").forEach(function(icon) {
        icon.addEventListener("click", function() {
            const input = document.querySelector(this.getAttribute("toggle"));

            if (input.type === "password") {
                input.type = "text";
                this.classList.remove("bi-eye-slash");
                this.classList.add("bi-eye");
            } else {
                input.type = "password";
                this.classList.remove("bi-eye");
                this.classList.add("bi-eye-slash");
            }
        });
    });
</script>
<script type="text/javascript">
    function passwordFormat(password) {
        regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/); // number, a-z, A-Z, min 8 chars
        if (regex.test(password))
            return true;
        return false;
    }
</script>
