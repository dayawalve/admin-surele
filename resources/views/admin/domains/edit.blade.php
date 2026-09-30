<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Domain</h1>
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
                                            <form class="form"
                                                action="{{ route('admin.domains.update', $domain->id) }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                                id="FormId">
                                                @csrf
                                                @method('PUT')
                                                <div class="card mb-8 shadow-sm">
                                                    <div class="card-header bg-light">
                                                        <h3 class="card-title fw-bold">
                                                            <i class="ki-duotone ki-user fs-2 me-2"></i>
                                                            
                                                        </h3>
                                                    </div>

                                                    <div class="card-body p-7">
                                                        <div class="row align-items-center">

                                                            <div class="col-lg-12">
                                                                <div class="row g-5">
                                                                    <div class="col-lg-8">
                                                                        <label class="required fw-semibold">Domain</label>
                                                                        <input type="text" name="domain"
                                                                            class="form-control form-control-solid"
                                                                            placeholder="Enter domain name" value="{{ $domain->name }}" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-footer d-flex justify-content-end gap-3 py-6">
                                                    <a href="{{ route('admin.domains.index') }}"
                                                    class="btn btn-light px-6">
                                                        Cancel
                                                    </a>

                                                    <button type="submit" class="btn btn-primary px-8">
                                                        <i class="ki-duotone ki-check fs-4 me-2"></i>
                                                        Save Domain
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

