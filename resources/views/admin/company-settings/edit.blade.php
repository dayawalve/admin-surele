<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Company </h1>
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

                                            <form class="form" action="{{ route('admin.company-settings.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <div class="card-body border-top p-9">

                                                    {{-- Company Logo --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Company Logo</label>
                                                        <div class="col-lg-8">
                                                            <div class="image-input image-input-outline"
                                                                data-kt-image-input="true"
                                                                style="background-image: url('{{ asset('public/custom-img/blank.png') }}')">
                                                                <div class="image-input-wrapper w-125px h-125px"
                                                                    style="background-image: url('{{ $data->logo ? asset($data->logo) : asset('public/custom-img/blank.png') }}')">
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
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Company Name
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text"
                                                                name="company_name"
                                                                value="{{ old('company_name', $data->company_name) }}"
                                                                class="form-control form-control-lg form-control-solid"
                                                                required>
                                                        </div>
                                                    </div>

                                                    {{-- Email --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Email
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="email"
                                                                name="company_email"
                                                                value="{{ old('company_email', $data->company_email) }}"
                                                                class="form-control form-control-lg form-control-solid">
                                                        </div>
                                                    </div>

                                                    {{-- Phone --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Phone
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text"
                                                                name="company_phone"
                                                                value="{{ old('company_phone', $data->company_phone) }}"
                                                                class="form-control form-control-lg form-control-solid">
                                                        </div>
                                                    </div>

                                                    {{-- Website --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Website
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="url"
                                                                name="company_website"
                                                                value="{{ old('company_website', $data->company_website) }}"
                                                                class="form-control form-control-lg form-control-solid">
                                                        </div>
                                                    </div>

                                                    {{-- Address --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Address
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <textarea name="address"
                                                                    rows="3"
                                                                    class="form-control form-control-lg form-control-solid">{{ old('address', $data->address) }}</textarea>
                                                        </div>
                                                    </div>

                                                    {{-- City / State --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            City / State
                                                        </label>
                                                        <div class="col-lg-4">
                                                            <input type="text"
                                                                name="city"
                                                                value="{{ old('city', $data->city) }}"
                                                                class="form-control form-control-lg form-control-solid">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text"
                                                                name="state"
                                                                value="{{ old('state', $data->state) }}"
                                                                class="form-control form-control-lg form-control-solid">
                                                        </div>
                                                    </div>

                                                    {{-- Country / Pincode --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Country / Pincode
                                                        </label>
                                                        <div class="col-lg-4">
                                                            <input type="text"
                                                                name="country"
                                                                value="{{ old('country', $data->country) }}"
                                                                class="form-control form-control-lg form-control-solid">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text"
                                                                name="pincode"
                                                                value="{{ old('pincode', $data->pincode) }}"
                                                                class="form-control form-control-lg form-control-solid">
                                                        </div>
                                                    </div>

                                                    {{-- GST / PAN --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            GST / PAN
                                                        </label>
                                                        <div class="col-lg-4">
                                                            <input type="text"
                                                                name="gst_number"
                                                                value="{{ old('gst_number', $data->gst_number) }}"
                                                                class="form-control form-control-lg form-control-solid">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <input type="text"
                                                                name="pan_number"
                                                                value="{{ old('pan_number', $data->pan_number) }}"
                                                                class="form-control form-control-lg form-control-solid">
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
                                                                    style="background-image: url('{{ $data->digital_signature ? asset($data->digital_signature) : asset('public/custom-img/blank.png') }}')">
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
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Status
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <label class="form-check form-switch form-check-custom">
                                                                <input class="form-check-input"
                                                                    type="checkbox"
                                                                    name="is_active"
                                                                    value="1"
                                                                    {{ $data->is_active ? 'checked' : '' }}>
                                                                <span class="form-check-label fw-semibold">Active</span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- Footer --}}
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <a href="{{ route('admin.company-settings.index') }}"
                                                    class="btn btn-light btn-active-light-primary me-2">
                                                        Cancel
                                                    </a>
                                                    <button type="submit" class="btn btn-success">
                                                        Update
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
