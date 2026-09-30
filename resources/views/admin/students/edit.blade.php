<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit User</h1>
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
                                            <form action="{{ route('admin.students.update', $data->id) }}"
                                                autocomplete="off" method="POST" class="form" id="FormId"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="card-body border-top p-9">
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label fw-semibold fs-6">Avatar</label>
                                                        <div class="col-lg-8">
                                                            <div class="image-input image-input-outline"
                                                                data-kt-image-input="true"
                                                                style="background-image: url('{{ asset('public/custom-img/blank.png') }}')">
                                                                <div class="image-input-wrapper w-125px h-125px"
                                                                    style="background-image: url('{{ url('/') }}/{{ $data->image }}')">
                                                                </div>
                                                                <label
                                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                                    data-kt-image-input-action="change"
                                                                    data-bs-toggle="tooltip" title="Change avatar">
                                                                    <i class="ki-duotone ki-pencil fs-7">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    <input type="file" name="image"
                                                                        accept=".png, .jpg, .jpeg" />
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
                                                                        name="fname" placeholder="Enter First Name"
                                                                        value="{{ $data->fname }}" />
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <input type="text" data-bvalidator="required"
                                                                        class="form-control form-control-lg form-control-solid"
                                                                        name="lname" placeholder="Enter Last Name"
                                                                        value="{{ $data->lname }}" />
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
                                                                placeholder="Enter email" data-bvalidator="required,email"
                                                                value="{{ $data->email }}" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label
                                                            class="col-lg-4 col-form-label fw-semibold fs-6">Phone</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="phone"
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                placeholder="Enter phone" value="{{ $data->phone }}"
                                                                data-bvalidator="required" />
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Business Developer
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <select
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                required name="business_developer_id">

                                                                <option disabled>--Select Business Developer--</option>

                                                                @foreach ($BusinessDeveloper as $value)
                                                                    <option value="{{ $value->id }}"
                                                                        {{ isset($data) && $data->bd_id == $value->id ? 'selected' : '' }}>
                                                                        {{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Refer By
                                                        </label>
                                                        <div class="col-lg-8">
                                                            {{-- <select
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                required
                                                                name="refer_by">
                                                                
                                                                <option disabled>--Select Refer By--</option>

                                                                @foreach ($Students as $value)
                                                                    <option value="{{ $value->id }}"
                                                                        {{ isset($data) && $data->refer_by_id == $value->id ? 'selected' : '' }}>
                                                                        {{ $value->fname }} {{ $value->lname }} ({{ $value->refer_id }})
                                                                    </option>
                                                                @endforeach
                                                            </select> --}}

                                                            <select
                                                                class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                required name="refer_by" id="refer_by">

                                                                <option disabled>--Select Refer By--</option>

                                                                <option value="0"
                                                                    {{ $data->otherRefer ? 'selected' : '' }}>
                                                                    Other
                                                                </option>

                                                                @foreach ($Students as $value)
                                                                    <option value="{{ $value->id }}"
                                                                        {{ $data->refer_by_id == $value->id ? 'selected' : '' }}>
                                                                        {{ $value->fname }} {{ $value->lname }}
                                                                        ({{ $value->refer_id }})
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="row mb-6 {{ $data->otherRefer ? '' : 'd-none' }}"
                                                        id="otherReferBox">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Other Refer Name
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="other_refer_name"
                                                                class="form-control form-control-lg form-control-solid"
                                                                placeholder="Enter Refer Name"
                                                                value="{{ optional($data->otherRefer)->name }}">
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
                                                                @foreach ($college as $value)
                                                                    <option value="{{ $value->id }}"
                                                                        @if ($data->college_id == $value->id) selected @endif>
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
                                                                <option disabled>--Select Training Program--</option>
                                                                @foreach ($trainingPrograms as $program)
                                                                    <option value="{{ $program->id }}"
                                                                        data-fees="{{ $program->fees }}"
                                                                        {{ $data->training_program_id == $program->id ? 'selected' : '' }}>
                                                                        {{ $program->program_name }}
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
                                                                        name="enrollment_type" value="trial"
                                                                        {{ $data->enrollment_type === 'trial' ? 'checked' : '' }}>
                                                                    <span class="form-check-label fw-semibold">Trial</span>
                                                                </label>

                                                                <label
                                                                    class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="enrollment_type" value="instant"
                                                                        {{ $data->enrollment_type === 'instant' ? 'checked' : '' }}>
                                                                    <span
                                                                        class="form-check-label fw-semibold">Enroll</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6 {{ $data->enrollment_type === 'instant' ? 'd-none' : '' }}"
                                                        id="trialBox">
                                                        <div class="col-lg-4"></div>
                                                        <div class="col-lg-8">
                                                            <div class="card border border-dashed border-warning">
                                                                <div class="card-body p-4">
                                                                    <span class="badge badge-light-warning mb-2">Trial
                                                                        Mode</span>
                                                                    <p class="mb-1 fw-semibold">Free Trial Activated</p>
                                                                    <small class="text-muted">
                                                                        Payment will be enabled only after trial
                                                                        confirmation.
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6 {{ $data->enrollment_type === 'instant' ? '' : 'd-none' }}"
                                                        id="paymentBox">
                                                        <div class="col-lg-4"></div>
                                                        <div class="col-lg-8">
                                                            <div class="card border border-dashed border-success">
                                                                <div class="card-body p-4">

                                                                    <h5 class="mb-3">Payment Details</h5>

                                                                    {{-- Total Fees --}}
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Total
                                                                            Fees</label>
                                                                        <input type="text"
                                                                            class="form-control form-control-solid"
                                                                            id="totalFees" readonly>
                                                                    </div>

                                                                    {{-- Paid Amount --}}
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">
                                                                            Paying Amount (Part / Full)
                                                                        </label>
                                                                        <input type="number" name="paid_amount"
                                                                            min="0"
                                                                            class="form-control form-control-solid"
                                                                            placeholder="Enter amount"
                                                                            value="{{ $lastPayment?->amount ?? '' }}">
                                                                    </div>

                                                                    {{-- Payment Mode --}}
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-semibold">Payment
                                                                            Mode</label>
                                                                        <select name="payment_mode"
                                                                            class="form-select form-select-solid">
                                                                            <option value="">Select Mode</option>
                                                                            <option value="Cash"
                                                                                {{ $lastPayment?->payment_mode === 'Cash' ? 'selected' : '' }}>
                                                                                Cash</option>
                                                                            <option value="UPI"
                                                                                {{ $lastPayment?->payment_mode === 'UPI' ? 'selected' : '' }}>
                                                                                UPI</option>
                                                                            <option value="Bank Transfer"
                                                                                {{ $lastPayment?->payment_mode === 'Bank Transfer' ? 'selected' : '' }}>
                                                                                Bank Transfer
                                                                            </option>
                                                                            <option value="Card"
                                                                                {{ $lastPayment?->payment_mode === 'Card' ? 'selected' : '' }}>
                                                                                Card</option>
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
                                                                    </div>

                                                                    {{-- Existing Receipt Preview --}}
                                                                    @if ($lastPayment && $lastPayment->payment_receipt)
                                                                        <div class="mt-4">
                                                                            <label class="form-label fw-semibold">Uploaded
                                                                                Receipt</label>
                                                                            <div class="d-flex align-items-center gap-4">

                                                                                {{-- Image Preview --}}
                                                                                @if (in_array(pathinfo($lastPayment->payment_receipt, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                                                                    <div
                                                                                        class="symbol symbol-100px symbol-2by3">
                                                                                        <img src="{{ asset($lastPayment->payment_receipt) }}"
                                                                                            alt="Receipt"
                                                                                            class="rounded border">
                                                                                    </div>
                                                                                @else
                                                                                    {{-- PDF Preview --}}
                                                                                    <div
                                                                                        class="symbol symbol-80px symbol-circle bg-light-primary">
                                                                                        <i
                                                                                            class="bi bi-file-earmark-pdf fs-2x text-primary"></i>
                                                                                    </div>
                                                                                @endif

                                                                                <div>
                                                                                    <a href="{{ asset($lastPayment->payment_receipt) }}"
                                                                                        target="_blank"
                                                                                        class="btn btn-sm btn-light-primary mb-1">
                                                                                        <i class="bi bi-eye me-1"></i> View
                                                                                        Receipt
                                                                                    </a>

                                                                                    <div class="text-muted fs-7">
                                                                                        Uploaded on
                                                                                        {{ \Carbon\Carbon::parse($lastPayment->created_at)->format('d M Y') }}
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    @endif

                                                                    {{-- <span class="badge badge-light-success mt-4">
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
document.getElementById('refer_by').addEventListener('change', function () {
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
        regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/);
        if (regex.test(password))
            return true;
        return false;
    }
</script>
<script>
    const programSelect = document.getElementById('training_program_id');
    const totalFeesInput = document.getElementById('totalFees');
    const trialBox = document.getElementById('trialBox');
    const paymentBox = document.getElementById('paymentBox');

    function updateUI() {
        const enrollmentType =
            document.querySelector('input[name="enrollment_type"]:checked')?.value;

        const selectedOption =
            programSelect.options[programSelect.selectedIndex];

        const fees = selectedOption?.dataset?.fees || '';

        if (enrollmentType === 'instant') {
            trialBox.classList.add('d-none');
            paymentBox.classList.remove('d-none');
            totalFeesInput.value = fees;
        } else {
            paymentBox.classList.add('d-none');
            trialBox.classList.remove('d-none');
            totalFeesInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', updateUI);

    document.querySelectorAll('input[name="enrollment_type"]').forEach(radio => {
        radio.addEventListener('change', updateUI);
    });

    programSelect.addEventListener('change', updateUI);
</script>
