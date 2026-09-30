<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add Business Developer</h1>
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
                                            <form class="form" action="{{ route('admin.business-developers.store') }}"
                                                method="POST" id="FormId">
                                                @csrf

                                                <div class="card-body border-top p-9">

                                                    {{-- Name --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Full Name
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="name"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter BD Name" data-bvalidator="required" />
                                                        </div>
                                                    </div>

                                                    {{-- Primary Email --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Primary Email
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="email" name="email"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter Primary Email"
                                                                data-bvalidator="required,email" />
                                                        </div>
                                                    </div>

                                                    {{-- Additional Emails --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Additional Emails <span class="fs-7 text-muted">(optional)</span>
                                                        </label>

                                                        <div class="col-lg-8">

                                                            <div id="extraEmailContainer">

                                                                <div class="d-flex gap-3 mb-2 extra-email-row">
                                                                    <input type="email" name="extra_emails[]"
                                                                        class="form-control form-control-lg form-control-solid"
                                                                        placeholder="Enter Additional Email">

                                                                    <button type="button"
                                                                        class="btn btn-light-danger btn-sm removeEmailBtn d-none">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>

                                                            </div>

                                                            <button type="button" class="btn btn-light-primary btn-sm mt-2"
                                                                id="addMoreEmailBtn">
                                                                <i class="bi bi-plus-circle me-1"></i> Add More Email
                                                            </button>

                                                        </div>
                                                    </div>


                                                    {{-- Phone --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Mobile Number
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="phone" maxlength="10"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter Mobile Number"
                                                                data-bvalidator="required,number" />
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Role</label>
                                                        <div class="col-lg-8">
                                                            <select
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                required name="role_id" data-bvalidator="required">
                                                                <option disabled selected>--Select Role--</option>
                                                                @foreach ($RoleList as $value)
                                                                    <option value="{{ $value->id }}">{{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- Footer --}}
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <a href="{{ route('admin.business-developers.index') }}"
                                                        class="btn btn-light btn-active-light-primary me-2">
                                                        Discard
                                                    </a>
                                                    <button type="submit" class="btn btn-primary">
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
        regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/); // number, a-z, A-Z, min 8 chars
        if (regex.test(password))
            return true;
        return false;
    }
</script>
<script>
document.getElementById('addMoreEmailBtn').addEventListener('click', function () {

    const container = document.getElementById('extraEmailContainer');

    const html = `
        <div class="d-flex gap-3 mb-2 extra-email-row">
            <input type="email"
                   name="extra_emails[]"
                   class="form-control form-control-lg form-control-solid"
                   placeholder="Enter Additional Email">

            <button type="button"
                    class="btn btn-light-danger btn-sm removeEmailBtn">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
});

// Remove button handler
document.addEventListener('click', function(e) {
    if (e.target.closest('.removeEmailBtn')) {
        e.target.closest('.extra-email-row').remove();
    }
});
</script>
