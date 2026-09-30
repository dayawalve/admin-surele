<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                </div>
            </div>
            <div class="app-content flex-column-fluid">
                <div class="app-container container-fluid">

                    <div class="card mb-5 mb-xl-10">
                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                            data-bs-target="#kt_account_profile_details" aria-expanded="true"
                            aria-controls="kt_account_profile_details">
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Profile Details</h3>
                            </div>
                        </div>
                        <div id="kt_account_settings_profile_details" class="collapse show">
                            <form class="form" action="{{ route('admin.profile.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <div class="card-body border-top p-9">
                                    <div class="row mb-6">
                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                                        <div class="col-lg-8">
                                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                                style="background-image: url('{{ asset('public/custom-img/blank.png') }}')">
                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: url('{{ url('/') }}/{{ Auth::guard('admin')->user()->photo }}')">
                                                </div>
                                                <label
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    title="Change avatar">
                                                    <i class="ki-duotone ki-pencil fs-7">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                                </label>
                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    title="Cancel avatar">
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
                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full
                                            Name</label>
                                        <div class="col-lg-8">
                                            <div class="row">
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="fname"
                                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                        placeholder="First name" value="{{ Auth::guard('admin')->user()->fname }}" />
                                                </div>
                                                <div class="col-lg-6 fv-row">
                                                    <input type="text" name="lname"
                                                        class="form-control form-control-lg form-control-solid"
                                                        placeholder="Last name" value="{{ Auth::guard('admin')->user()->lname }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button type="reset"
                                        class="btn btn-light btn-active-light-primary me-2">Discard</button>
                                    <button type="submit" class="btn btn-primary"
                                        id="kt_account_profile_details_submit">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--begin::Sign-in Method-->
                    <div class="card mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                            data-bs-target="#kt_account_signin_method">
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Sign-in Method</h3>
                            </div>
                        </div>
                        <!--end::Card header-->
                        <!--begin::Content-->
                        <div id="kt_account_settings_signin_method" class="collapse show">
                            <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Email Address-->
                                <div class="d-flex flex-wrap align-items-center">
                                    <!--begin::Label-->
                                    <div id="kt_signin_email">
                                        <div class="fs-6 fw-bold mb-1">Email Address</div>
                                        <div class="fw-semibold text-gray-600">{{ Auth::guard('admin')->user()->email }}</div>
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Edit-->
                                    <div id="kt_signin_email_edit" class="flex-row-fluid d-none">
                                        <!--begin::Form-->
                                        <form class="form" method="POST" action="{{ route('admin.profile.update-email') }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="row mb-6">
                                                <div class="col-lg-6 mb-4 mb-lg-0">
                                                    <div class="fv-row mb-0">
                                                        <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Enter
                                                            New
                                                            Email Address</label>
                                                        <input type="email"
                                                            class="form-control form-control-lg form-control-solid"
                                                            placeholder="Email Address" name="email"
                                                            value="{{ Auth::guard('admin')->user()->email }}" />
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="fv-row mb-0">
                                                        <label for="confirmemailpassword"
                                                            class="form-label fs-6 fw-bold mb-3">Confirm
                                                            Password</label>
                                                        <input type="password"
                                                            class="form-control form-control-lg form-control-solid"
                                                            name="confirmemailpassword" id="confirmemailpassword" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <button id="kt_signin_submit" type="submit"
                                                    class="btn btn-primary me-2 px-6">Update Email</button>
                                                <button id="kt_signin_cancel" type="button"
                                                    class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                                            </div>
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Edit-->
                                    <!--begin::Action-->
                                    <div id="kt_signin_email_button" class="ms-auto">
                                        <button class="btn btn-light btn-active-light-primary">Change
                                            Email</button>
                                    </div>
                                    <!--end::Action-->
                                </div>
                                <!--end::Email Address-->
                                <!--begin::Separator-->
                                <div class="separator separator-dashed my-6"></div>
                                <!--end::Separator-->
                                <!--begin::Password-->
                                <div class="d-flex flex-wrap align-items-center mb-10">
                                    <!--begin::Label-->
                                    <div id="kt_signin_password">
                                        <div class="fs-6 fw-bold mb-1">Password</div>
                                        <div class="fw-semibold text-gray-600">************</div>
                                    </div>
                                    <!--end::Label-->
                                    <!--begin::Edit-->
                                    <div id="kt_signin_password_edit" class="flex-row-fluid d-none">
                                        <!--begin::Form-->
                                        <form class="form" method="POST"
                                            action="{{ route('admin.profile.update-password') }}">
                                            @csrf
                                            @method('PATCH')
                                            <div class="row mb-1">
                                                <div class="col-lg-4">
                                                    <div class="fv-row mb-0">
                                                        <label for="currentpassword"
                                                            class="form-label fs-6 fw-bold mb-3">Current
                                                            Password</label>
                                                        <input type="password"
                                                            class="form-control form-control-lg form-control-solid"
                                                            name="currentpassword" required />
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="fv-row mb-0">
                                                        <label for="newpassword" class="form-label fs-6 fw-bold mb-3">New
                                                            Password</label>
                                                        <input type="password"
                                                            class="form-control form-control-lg form-control-solid"
                                                            name="newpassword" required />
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="fv-row mb-0">
                                                        <label for="confirmpassword"
                                                            class="form-label fs-6 fw-bold mb-3">Confirm New
                                                            Password</label>
                                                        <input type="password"
                                                            class="form-control form-control-lg form-control-solid"
                                                            name="newpassword_confirmation" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-text mb-5">Password must be at least 8
                                                character</div>
                                            <div class="d-flex">
                                                <button id="kt_password_submit" type="submit"
                                                    class="btn btn-primary me-2 px-6">Update
                                                    Password</button>
                                                <button id="kt_password_cancel" type="button"
                                                    class="btn btn-color-gray-400 btn-active-light-primary px-6">Cancel</button>
                                            </div>
                                        </form>
                                        <!--end::Form-->
                                    </div>
                                    <!--end::Edit-->
                                    <!--begin::Action-->
                                    <div id="kt_signin_password_button" class="ms-auto">
                                        <button class="btn btn-light btn-active-light-primary">Reset
                                            Password</button>
                                    </div>
                                    <!--end::Action-->
                                </div>
                                <!--end::Password-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Sign-in Method-->

                    <!--begin::Delete Account-->
                    <div class="card">
                        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                            data-bs-target="#kt_account_deactivate" aria-expanded="true"
                            aria-controls="kt_account_deactivate">
                            <div class="card-title m-0">
                                <h3 class="fw-bold m-0">Delete Account</h3>
                            </div>
                        </div>
                        <div id="kt_account_settings_deactivate" class="collapse show">
                            <form class="form" action="{{ route('admin.deleteAccount') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card-body border-top p-9">
                                    <div class="form-check form-check-solid fv-row">
                                        <label class="form-check-label fw-semibold ps-2 fs-6" for="deactivate">Once your account is deleted, all of its resources and data will be permanently deleted.</label>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                    <button id="kt_account_deactivate_account_submit" type="button"
                                        class="btn btn-danger fw-semibold ConfirmDelete">Delete Account</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--end::Delete Account-->
                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
