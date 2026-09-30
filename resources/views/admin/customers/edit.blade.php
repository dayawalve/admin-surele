<x-admin-layout>
    @section('content')
    <style>
        .form-card {
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            border: none;
        }

        .form-title {
            font-size: 18px;
            font-weight: 600;
            color: #4e73df;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        .form-control-solid {
            border-radius: 8px !important;
            padding: 12px 14px;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .form-control-solid:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
            background: #fff;
        }

        .input-group-text {
            background: #f1f5ff;
            border: 1px solid #e5e7eb;
            border-right: none;
            border-radius: 8px 0 0 8px;
        }

        .input-group .form-control {
            border-left: none;
        }

        .form-section {
            border-bottom: 1px dashed #e5e7eb;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }

        .btn-primary {
            border-radius: 8px;
            padding: 8px 20px;
        }

        .btn-light {
            border-radius: 8px;
        }
    </style>
    <div class="d-flex flex-column flex-column-fluid">
        <div class="app-toolbar py-3 py-lg-6 card-header">
            <div class="app-container container-fluid d-flex flex-stack">
                <h3 class="form-title">👤 Edit Brand User</h3>
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
                                        <div class="card form-card">
                                            <form class="form" action="{{ route('admin.brands.update', $user->id) }}"
                                                method="POST" enctype="multipart/form-data" id="FormId">
                                                @csrf
                                                @method('PUT')

                                                <div class="card-body p-9">

                                                    <!-- Username -->
                                                    <div class="row mb-6 form-section">
                                                        <label
                                                            class="col-lg-2 col-form-label required form-label">Username</label>
                                                        <div class="col-lg-8">
                                                            <div class="input-group">
                                                                <span class="input-group-text">👤</span>
                                                                <input type="text" name="username"
                                                                    class="form-control form-control-solid"
                                                                    placeholder="Enter username"
                                                                    value="{{ $user->username }}"
                                                                    data-bvalidator="required" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Email -->
                                                    <div class="row mb-6 form-section">
                                                        <label
                                                            class="col-lg-2 col-form-label required form-label">Email</label>
                                                        <div class="col-lg-8">
                                                            <div class="input-group">
                                                                <span class="input-group-text">📧</span>
                                                                <input type="email" name="email"
                                                                    class="form-control form-control-solid"
                                                                    placeholder="Enter email"
                                                                    value="{{ $user->email }}"
                                                                    data-bvalidator="required" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Password -->
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-2 col-form-label form-label">Password</label>
                                                        <div class="col-lg-8">
                                                            <div class="input-group">
                                                                <span class="input-group-text">🔒</span>
                                                                <input type="password" name="password"
                                                                    class="form-control form-control-solid"
                                                                    placeholder="Enter new password (optional)" />
                                                            </div>
                                                            <small class="text-muted">Leave blank if you don't want to
                                                                change password</small>
                                                        </div>
                                                    </div>


                                                </div>

                                        </div>

                                        <!-- Footer -->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <a href="{{ route('admin.brands.index') }}"
                                                class="btn btn-light me-2">
                                                Cancel
                                            </a>

                                            <button type="submit" class="btn btn-primary">
                                                💾 Save Changes
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