<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add Training Program</h1>
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
                                            <form class="form" action="{{ route('admin.training-programs.store') }}" method="POST" enctype="multipart/form-data" id="trainingProgramForm">
                                                @csrf
                                                <div class="card-body border-top p-9">
                                                    {{-- Program Code --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 required col-form-label fw-semibold fs-6">
                                                            Program Code
                                                        </label>
                                                        <div class="col-lg-6">
                                                            <div class="input-group input-group-lg input-group-solid">
                                                                <span class="input-group-text">TP-</span>
                                                                <input type="text"
                                                                    name="program_code"
                                                                    id="program_code"
                                                                    class="form-control"
                                                                    placeholder="Auto or manual code"
                                                                    maxlength="50">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2 d-flex align-items-center">
                                                            <button type="button"
                                                                    class="btn btn-light-primary btn-sm"
                                                                    onclick="generateProgramCode()">
                                                                Auto Generate
                                                            </button>
                                                        </div>
                                                    </div>

                                                    {{-- Program Name --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Program Name
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text"
                                                                name="program_name" required
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter Training Program Name"
                                                                data-bvalidator="required">
                                                        </div>
                                                    </div>

                                                    {{-- Duration & Mode --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Duration & Mode
                                                        </label>
                                                        <div class="col-lg-4">
                                                            <input type="number"
                                                                name="duration_weeks" required min="0"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Duration (Weeks)"
                                                                data-bvalidator="required,number,min[1]">
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <select name="training_mode" required
                                                                    class="form-select form-select-lg form-select-solid"
                                                                    data-bvalidator="required">
                                                                <option value="">Select Mode</option>
                                                                <option value="Online">Online</option>
                                                                <option value="Offline" selected>Offline</option>
                                                                <option value="Hybrid">Hybrid</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- Fees --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Fees</label>
                                                        <div class="col-lg-8">
                                                            <input type="number"
                                                                name="fees" required min="0"
                                                                step="0.01" data-bvalidator="required"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter Fees (₹)">
                                                        </div>
                                                    </div>

                                                    {{-- Status --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Status
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <select name="status" required
                                                                    class="form-select form-select-lg form-select-solid"
                                                                    data-bvalidator="required">
                                                                <option value="Active" selected>Active</option>
                                                                <option value="Inactive">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- Description --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Description
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <textarea name="description"
                                                                    class="form-control form-control-lg form-control-solid"
                                                                    rows="4"
                                                                    placeholder="Brief description of the training program"></textarea>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- Footer --}}
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <a href="{{ route('admin.training-programs.index') }}"
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
        regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/); 
        if (regex.test(password))
            return true;
        return false;
    }
</script>
<script>
function generateProgramCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let randomPart = '';

    for (let i = 0; i < 6; i++) {
        randomPart += chars.charAt(Math.floor(Math.random() * chars.length));
    }

    document.getElementById('program_code').value = randomPart;
}
</script>


