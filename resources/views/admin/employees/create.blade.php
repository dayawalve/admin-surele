<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add Employee</h1>
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
                                                action="{{ route('admin.employees.store') }}"
                                                method="POST"
                                                enctype="multipart/form-data"
                                                id="FormId">
                                                @csrf

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
                                                                    <input type="file" name="image" class="imgVal"
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
                                                                <div class="text-muted fs-7 mt-2">
                                                                    JPG, PNG allowed
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-9">
                                                                <div class="row g-5">
                                                                    <div class="col-lg-6">
                                                                        <label class="required fw-semibold">Employee Code</label>
                                                                        <input type="text" name="employee_code"
                                                                            class="form-control form-control-solid"
                                                                            placeholder="EMP-001">
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <label class="required fw-semibold">Full Name</label>
                                                                        <input type="text" name="name"
                                                                            class="form-control form-control-solid"
                                                                            placeholder="Enter full name">
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
                                                                <input type="text" name="phone" pattern="[0-9]{10}"
                                                                    class="form-control form-control-solid"
                                                                    placeholder="98765 43210">
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <label class="required fw-semibold">Email</label>
                                                                <input type="email" name="email"
                                                                    class="form-control form-control-solid"
                                                                    placeholder="email@example.com">
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
                                                                    placeholder="IT / HR / Accounts">
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <label class="required fw-semibold">Designation</label>
                                                                <input type="text" name="designation"
                                                                    class="form-control form-control-solid"
                                                                    placeholder="Software Engineer">
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label class="required fw-semibold">Salary</label>
                                                                <input type="number" name="salary"
                                                                    class="form-control form-control-solid"
                                                                    placeholder="₹ 50,000">
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label class="required fw-semibold">Date of Birth</label>
                                                                <input type="date" name="date_of_birth"
                                                                    class="form-control form-control-solid">
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label class="required fw-semibold">Date of Joining</label>
                                                                <input type="date" name="date_of_joining"
                                                                    class="form-control form-control-solid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card mb-8 shadow-sm d-none" id="paymentBox">
                                                    <div class="card-header bg-light-success">
                                                        <h3 class="card-title fw-bold text-success">
                                                            <i class="ki-duotone ki-wallet fs-2 me-2"></i>
                                                            Payment Details
                                                        </h3>
                                                    </div>

                                                    <div class="card-body p-7">
                                                        <div class="row g-5">
                                                            <div class="col-lg-4">
                                                                <label class="fw-semibold">Total Fees</label>
                                                                <input type="text" id="totalFees"
                                                                    class="form-control form-control-solid" readonly>
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label class="fw-semibold">Paid Amount</label>
                                                                <input type="number" name="paid_amount"
                                                                    class="form-control form-control-solid"
                                                                    placeholder="Enter amount">
                                                            </div>

                                                            <div class="col-lg-4">
                                                                <label class="fw-semibold">Payment Mode</label>
                                                                <select name="payment_mode"
                                                                        class="form-select form-select-solid">
                                                                    <option value="">Select Mode</option>
                                                                    <option>Cash</option>
                                                                    <option>UPI</option>
                                                                    <option>Bank Transfer</option>
                                                                    <option>Card</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <label class="fw-semibold">
                                                                    Payment Receipt (Optional)
                                                                </label>
                                                                <input type="file" name="payment_receipt"
                                                                    class="form-control form-control-solid"
                                                                    accept=".jpg,.jpeg,.png,.pdf">
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
                                                        Save Employee
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

