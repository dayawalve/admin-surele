<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add Company </h1>
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
                                        
                                               <form class="form" action="{{ route('admin.company-settings.store') }}" method="POST" enctype="multipart/form-data" id="FormId">
                                                @csrf
                                                <div class="card-body border-top p-9">

                                                    {{-- Company Logo --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Logo</label>
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
                                                                    <input type="file" name="logo" class="imgVal"
                                                                        accept=".png,.jpg,.jpeg" />
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
                                                            <div class="form-text">Allowed: png, jpg, jpeg</div>
                                                        </div>
                                                    </div>

                                                    {{-- Company Name --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Company Name</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="company_name"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter Company Name" required>
                                                        </div>
                                                    </div>

                                                    {{-- Company Email --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Email</label>
                                                        <div class="col-lg-8">
                                                            <input type="email" name="company_email"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter Company Email">
                                                        </div>
                                                    </div>

                                                    {{-- Company Phone --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Phone</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="company_phone"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter Company Phone">
                                                        </div>
                                                    </div>

                                                    {{-- Website --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Website</label>
                                                        <div class="col-lg-8">
                                                            <input type="url" name="company_website"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="https://example.com">
                                                        </div>
                                                    </div>

                                                    {{-- Address --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Address</label>
                                                        <div class="col-lg-8">
                                                            <textarea name="address"
                                                                    class="form-control form-control-lg form-control-solid"
                                                                    rows="3"
                                                                    placeholder="Enter Company Address"></textarea>
                                                        </div>
                                                    </div>

                                                    {{-- City / State --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">City / State</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="city"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="City">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="state"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="State">
                                                        </div>
                                                    </div>

                                                    {{-- Country / Pincode --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Country / Pincode</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="country"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Country">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="pincode"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Pincode">
                                                        </div>
                                                    </div>

                                                    {{-- GST / PAN --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">GST / PAN</label>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="gst_number"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="GST Number">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text" name="pan_number"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="PAN Number">
                                                        </div>
                                                    </div>

                                                    {{-- Social Links --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Social Links</label>
                                                        <div class="col-lg-8">
                                                            <input type="url" name="facebook_url"
                                                                class="form-control form-control-lg form-control-solid mb-3"
                                                                placeholder="Facebook URL">
                                                            <input type="url" name="instagram_url"
                                                                class="form-control form-control-lg form-control-solid mb-3"
                                                                placeholder="Instagram URL">
                                                            <input type="url" name="linkedin_url"
                                                                class="form-control form-control-lg form-control-solid mb-3"
                                                                placeholder="LinkedIn URL">
                                                            <input type="url" name="twitter_url"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Twitter URL">
                                                        </div>
                                                    </div>

                                                    {{-- Digital Signature --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Digital Signature</label>
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
                                                                    <input type="file" name="digital_signature" class="imgVal"
                                                                        accept=".png,.jpg,.jpeg" />
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
                                                            <div class="form-text">Allowed: png, jpg, jpeg</div>
                                                        </div>
                                                    </div>


                                                    {{-- Status --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Status</label>
                                                        <div class="col-lg-8">
                                                            <label class="form-check form-switch form-check-custom">
                                                                <input class="form-check-input" type="checkbox" name="is_active" checked>
                                                                <span class="form-check-label fw-semibold">Active</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <a href="{{ route('admin.company-settings.index') }}"
                                                        class="btn btn-light btn-active-light-primary me-2">Discard</a>
                                                    <button type="submit" class="btn btn-success">
                                                        Save
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
        regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/); 
        if (regex.test(password))
            return true;
        return false;
    }
</script>
