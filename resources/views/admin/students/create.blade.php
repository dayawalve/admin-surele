<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Add Students</h1>
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
                                            <form class="form" action="{{ route('admin.students.store') }}" method="POST"
                                                enctype="multipart/form-data" id="FormId">
                                                @csrf
                                                <div class="card-body border-top p-9">
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label fw-semibold fs-6">Profile</label>
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
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Phone
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="phone"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                placeholder="Enter phone" data-bvalidator="required" />
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
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Business
                                                            Developer</label>
                                                        <div class="col-lg-8">
                                                            <select
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                required name="business_developer_id">
                                                                <option disabled selected>--Select Business Developer--
                                                                </option>
                                                                @foreach ($BusinessDeveloper as $value)
                                                                    <option value="{{ $value->id }}">{{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Refer
                                                            By</label>
                                                        <div class="col-lg-8">
                                                            {{-- <select
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                required name="refer_by">
                                                                <option disabled selected>--Select Refer By--</option>
                                                                @foreach ($Students as $value)
                                                                    <option value="{{ $value->id }}">{{ $value->fname }} {{ $value->lname }} : ({{ $value->refer_id }})
                                                                    </option>
                                                                @endforeach
                                                            </select> --}}
                                                            <select
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                required name="refer_by" id="refer_by">

                                                                <option disabled selected>--Select Refer By--</option>
                                                                <option value="0">Other</option>

                                                                @foreach ($Students as $value)
                                                                    <option value="{{ $value->id }}">
                                                                        {{ $value->fname }} {{ $value->lname }} :
                                                                        ({{ $value->refer_id }})
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6 d-none" id="otherReferBox">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">Other Refer Name
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="other_refer_name"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter Refer Name Manually">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label required fw-semibold fs-6">College</label>
                                                        <div class="col-lg-8">
                                                            <select
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                required name="college">
                                                                <option disabled selected>--Select College--</option>
                                                                @foreach ($data as $value)
                                                                    <option value="{{ $value->id }}">
                                                                        {{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Training Program
                                                        </label>

                                                        <div class="col-lg-8">
                                                            <select class="form-control form-control-lg form-control-solid"
                                                                required name="training_program_id"
                                                                id="training_program_id">
                                                                <option disabled selected>-- Select Training Program --
                                                                </option>
                                                                @foreach ($trainingPrograms as $value)
                                                                    <option value="{{ $value->id }}"
                                                                        data-fees="{{ $value->fees }}"
                                                                        data-name="{{ $value->program_name }}">
                                                                        {{ $value->program_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Enrollment Type
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <div class="d-flex gap-6">
                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="enrollment_type" value="trial" checked>
                                                                    <span class="form-check-label fw-semibold">
                                                                        Trial
                                                                    </span>
                                                                </label>

                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="enrollment_type" value="instant">
                                                                    <span class="form-check-label fw-semibold">
                                                                        Enroll
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6" id="trialBox">
                                                        <div class="col-lg-4"></div>
                                                        <div class="col-lg-8">
                                                            <div class="card border border-dashed border-warning">
                                                                <div class="card-body p-4">
                                                                    <span class="badge badge-light-warning mb-2">Trial
                                                                        Mode</span>
                                                                    <p class="mb-1 fw-semibold">
                                                                        Free Trial Activated
                                                                    </p>
                                                                    <small class="text-muted">
                                                                        Payment will be enabled only after trial
                                                                        confirmation.
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6 d-none" id="paymentBox">
                                                        <div class="col-lg-4"></div>
                                                        <div class="col-lg-8">
                                                            <div class="card border border-dashed border-success">
                                                                <div class="card-body p-4">

                                                                    <h5 class="mb-3">Payment Details</h5>

                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Total
                                                                            Fees</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-solid"
                                                                            id="totalFees" readonly>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">
                                                                            Paying Amount (Part / Full)
                                                                        </label>
                                                                        <input type="number" name="paid_amount"
                                                                            min="0"
                                                                            class="form-control form-control-solid"
                                                                            placeholder="Enter amount">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Payment
                                                                            Mode</label>
                                                                        <select name="payment_mode"
                                                                            class="form-select form-select-solid">
                                                                            <option value="">Select Mode</option>
                                                                            <option>Cash</option>
                                                                            <option>UPI</option>
                                                                            <option>Bank Transfer</option>
                                                                            <option>Card</option>
                                                                        </select>
                                                                    </div>

                                                                    {{-- Receipt Upload --}}
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">
                                                                            Payment Receipt
                                                                            <span class="text-muted fs-7">(Optional)</span>
                                                                        </label>

                                                                        <input type="file" name="payment_receipt"
                                                                            class="form-control form-control-solid"
                                                                            accept=".jpg,.jpeg,.png,.pdf">

                                                                        <div class="form-text">
                                                                            Allowed formats: JPG, PNG, PDF (Max 2MB)
                                                                        </div>
                                                                    </div>

                                                                    {{-- <span class="badge badge-light-success">
                                                                        Part Payment Allowed
                                                                    </span> --}}

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <a href="{{ route('admin.students.index') }}"
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
    document.getElementById('refer_by').addEventListener('change', function() {
        const otherBox = document.getElementById('otherReferBox');

        if (this.value === '0') {
            otherBox.classList.remove('d-none');
        } else {
            otherBox.classList.add('d-none');
        }
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
<script>
    const trialBox = document.getElementById('trialBox');
    const paymentBox = document.getElementById('paymentBox');

    document.querySelectorAll('input[name="enrollment_type"]').forEach(radio => {
        radio.addEventListener('change', function() {

            if (this.value === 'instant') {
                trialBox.classList.add('d-none');
                paymentBox.classList.remove('d-none');
            } else {
                paymentBox.classList.add('d-none');
                trialBox.classList.remove('d-none');
            }
        });
    });
</script>

<script>
    const programSelect = document.getElementById('training_program_id');
    const totalFeesInput = document.getElementById('totalFees');

    const enrollmentRadios = document.querySelectorAll('input[name="enrollment_type"]');

    function updateFees() {
        const selectedOption = programSelect.options[programSelect.selectedIndex];
        const fees = selectedOption?.dataset?.fees || '';

        // Check enrollment type
        const enrollmentType = document.querySelector('input[name="enrollment_type"]:checked')?.value;

        if (enrollmentType === 'instant' && fees) {
            totalFeesInput.value = fees;
        } else {
            totalFeesInput.value = '';
        }
    }

    // On program change
    programSelect.addEventListener('change', updateFees);

    // On enrollment type change
    enrollmentRadios.forEach(radio => {
        radio.addEventListener('change', updateFees);
    });
</script>
