<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Students Details</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Students Details</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    {{-- Header --}}
                    <div class="d-flex flex-wrap flex-stack mb-6">
                        <h3 class="fw-bold m-0"> </h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.students.edit', $data->id) }}"
                            class="btn btn-primary btn-sm">
                                <i class="bi bi-vector-pen me-1"></i> Edit
                            </a>

                            <a href="{{ route('admin.students.index') }}"
                            class="btn btn-light btn-sm">
                                Back
                            </a>
                        </div>
                    </div>

                    {{-- Profile Card --}}
                    <div class="card mb-5 mb-xl-10">
                        <div class="card-body pt-9 pb-0">

                            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">

                                {{-- Profile Image --}}
                                <div class="me-7 mb-4">
                                    <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                        <img src="{{ asset($data->image ?? 'public/custom-img/blank.png') }}"
                                            alt="Student Image" />
                                        @if($data->is_active)
                                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle h-20px w-20px border border-4 border-body"></div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Student Info --}}
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">

                                        <div class="d-flex flex-column">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">
                                                    {{ $data->fname }} {{ $data->lname }}
                                                </span>

                                                @if($data->is_deleted)
                                                    <span class="badge badge-light-danger ms-2">Deleted</span>
                                                @endif
                                            </div>

                                            <div class="d-flex flex-wrap fw-semibold fs-6 text-gray-500">
                                                <span class="me-4">
                                                    <i class="bi bi-envelope me-1"></i> {{ $data->email }}
                                                </span>
                                                <span>
                                                    <i class="bi bi-telephone me-1"></i> {{ $data->phone }}
                                                </span>
                                            </div>
                                        </div>

                                        <form method="POST"
                                            action="{{ route('admin.students.send-offer-letter', $data->id) }}"
                                            onsubmit="return confirmSendOffer(event);">
                                            @csrf

                                            <button type="submit"
                                                class="btn btn-light-success fw-semibold px-4 py-3 shadow-sm">
                                                <i class="bi bi-send me-2"></i>
                                                Send Offer Letter
                                            </button>
                                        </form>


                                        {{-- Referral Count Box --}}
                                        <div class="d-flex align-items-center">
                                            <div class="card bg-light-primary border-0 shadow-sm px-4 py-3 text-center">
                                                <div class="fw-bold fs-3 text-primary">
                                                    {{ $data->referrals->count() }}
                                                </div>
                                                <div class="text-muted fs-7 fw-semibold">
                                                    Referrals
                                                </div>
                                            </div>
                                        </div>
                                    
                                    </div>

                                    {{-- Badges --}}
                                    <div class="d-flex flex-wrap gap-2 mt-3">
                                        <span class="badge badge-light-primary">
                                            {{ $data->trainingProgram?->program_name ?? 'No Training Assigned' }}
                                        </span>

                                        <span class="badge badge-light-info">
                                            {{ $data->college?->name ?? 'College N/A' }}
                                        </span>

                                        <span class="badge {{ $data->is_active ? 'badge-light-success' : 'badge-light-warning' }}">
                                            {{ $data->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Details Section --}}
                    <div class="row g-5 g-xl-10">
                        <div class="col-xl-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">Academic Information</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless fs-6">
                                        <tr>
                                            <th class="text-gray-600 w-200px">Training Program</th>
                                            <td class="fw-semibold">
                                                {{ $data->trainingProgram?->program_name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">College</th>
                                            <td class="fw-semibold">
                                                {{ $data->college?->name ?? 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Enrollment Type</th>
                                            <td class="fw-semibold">
                                               @if($data->enrollment_type === 'trial')
                                                    <span class="badge badge-light-warning">Trial</span>
                                                @elseif($data->enrollment_type === 'after_trial')
                                                    <span class="badge badge-light-info">After Trial</span>
                                                @else
                                                    <span class="badge badge-light-success">Instant</span>
                                                @endif

                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <th class="text-gray-600">Referred By</th>
                                            <td class="fw-semibold">
                                                @if($data->referredBy)
                                                    <a href="{{ route('admin.students.show', $data->referredBy->id) }}"
                                                    class="text-primary text-hover-underline">
                                                        {{ $data->referredBy->fname }} {{ $data->referredBy->lname }}
                                                        ({{ $data->referredBy->refer_id }})
                                                    </a>
                                                @elseif($data->otherRefer)
                                                    {{ optional($data->otherRefer)->name ?? '-' }}<br>
                                                    <span class="text-muted text-sm">Other Refer</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h3 class="card-title fw-bold">System Information</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless fs-6">
                                        <tr>
                                            <th class="text-gray-600 w-200px">Created At</th>
                                            <td class="fw-semibold">
                                                {{ $data->created_at->format('d M Y, h:i A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-gray-600">Status</th>
                                            <td>
                                                <span class="badge {{ $data->is_active ? 'badge-light-success' : 'badge-light-warning' }}">
                                                    {{ $data->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Transaction History --}}
                    <div class="card mt-5">
                        <div class="card-header align-items-center d-flex flex-wrap gap-3">
                            <h3 class="card-title fw-bold mb-0">Transaction History</h3>

                            {{-- Payment Summary --}}
                            @php
                                $totalPaid = $data->payments->sum('amount');
                                $programFees = $data->trainingProgram?->fees ?? 0;
                                $pending = max($programFees - $totalPaid, 0);
                            @endphp

                            {{-- Add Payment Button --}}
                            @if($pending > 0 && $data->enrollment_type != 'trial')
                                <button class="btn btn-sm btn-primary ms-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#addPaymentModal">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Add Payment
                                </button>
                            @endif
                            
                            @if($pending > 0 && $data->enrollment_type != 'trial')
                                <form action="{{ route('admin.students.send-payment-reminder', $data->id) }}"
                                    method="POST"
                                    class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-warning ms-3">
                                        <i class="bi bi-send me-1"></i>
                                        Send Reminder
                                    </button>
                                </form>
                            @endif



                            {{-- Badges --}}
                            <div class="ms-auto d-flex gap-3">
                                <span class="badge badge-light-success fs-7">
                                    Paid: ₹{{ number_format($totalPaid, 2) }}
                                </span>
                                <span class="badge badge-light-danger fs-7">
                                    Pending: ₹{{ number_format($pending, 2) }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-6">
                            @if($data->payments->count())
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 align-middle mb-0">
                                        <thead>
                                            <tr class="fw-bold text-muted">
                                                <th>#</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <th>Mode</th>
                                                <th>Receipt</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data->payments as $key => $payment)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>

                                                    <td>
                                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                                    </td>

                                                    <td class="fw-bold text-success">
                                                        ₹{{ number_format($payment->amount, 2) }}
                                                    </td>

                                                    <td>
                                                        <span class="badge badge-light-primary">
                                                            {{ $payment->payment_mode }}
                                                        </span>
                                                    </td>

                                                    {{-- Receipt Column --}}
                                                    <td>
                                                        @if($payment->payment_receipt)
                                                            <a href="{{ asset($payment->payment_receipt) }}"
                                                            target="_blank"
                                                            class="btn btn-sm btn-light-primary"
                                                            data-bs-toggle="tooltip"
                                                            title="View Receipt">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>

                                                    <td class="text-muted">
                                                        {{ $payment->remarks ?? '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-10 text-muted">
                                    <i class="bi bi-receipt fs-2x mb-3"></i>
                                    <div>No transactions found</div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Referred Students --}}
                    <div class="card mt-5">
                        <div class="card-header d-flex align-items-center">
                            <h3 class="card-title fw-bold mb-0">
                                <i class="bi bi-people me-2 text-primary"></i>
                                Referred Students
                            </h3>

                            <span class="badge badge-light-primary ms-3">
                                {{ $data->referrals->count() }} Total
                            </span>
                        </div>

                        <div class="card-body p-6">
                            @if($data->referrals->count())
                                <div class="table-responsive">
                                    <table class="table table-row-dashed table-row-gray-300 align-middle">
                                        <thead>
                                            <tr class="fw-bold text-muted">
                                                <th>#</th>
                                                <th>Student</th>
                                                <th>Reference ID</th>
                                                <th>Program</th>
                                                <th>Status</th>
                                                <th>Joined On</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data->referrals as $index => $ref)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>

                                                    <td class="fw-semibold">
                                                        {{ $ref->fname }} {{ $ref->lname }}
                                                    </td>

                                                    <td>
                                                        <span class="badge badge-light-info fw-bold">
                                                            {{ $ref->refer_id }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        {{ $ref->trainingProgram?->program_name ?? 'N/A' }}
                                                    </td>

                                                    <td>
                                                        <span class="badge {{ $ref->is_active ? 'badge-light-success' : 'badge-light-warning' }}">
                                                            {{ $ref->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        {{ $ref->created_at->format('d M Y') }}
                                                    </td>

                                                    <td class="text-end">
                                                        <a href="{{ route('admin.students.show', $ref->id) }}"
                                                        class="btn btn-sm btn-light-primary"
                                                        data-bs-toggle="tooltip"
                                                        title="View Student">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                {{-- Empty State --}}
                                <div class="text-center py-10 text-muted">
                                    <i class="bi bi-person-x fs-2x mb-3"></i>
                                    <div>No referred students found</div>
                                </div>
                            @endif
                        </div>
                    </div>


                </div>
            </div>
        </div>

        {{-- Add Payment Modal --}}
        <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <form method="POST"
                    action="{{ route('admin.students.add-payment', $data->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-content">

                        {{-- Header --}}
                        <div class="modal-header bg-light-primary">
                            <h5 class="modal-title fw-bold">
                                <i class="bi bi-credit-card me-2"></i>
                                Add Payment
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        {{-- Body --}}
                        <div class="modal-body p-6">

                            {{-- Payment Summary --}}
                            <div class="card border border-dashed border-primary mb-5">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-muted fs-7">Training Program</div>
                                        <div class="fw-bold">
                                            {{ $data->trainingProgram?->program_name }}
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <div class="badge badge-light-success fs-6 mb-1">
                                            Paid: ₹{{ number_format($totalPaid, 2) }}
                                        </div>
                                        <div class="badge badge-light-danger fs-6">
                                            Pending: ₹{{ number_format($pending, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Form Fields --}}
                            <div class="row g-4">

                                {{-- Pending Amount --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Pending Amount</label>
                                    <input type="text"
                                        class="form-control form-control-solid"
                                        value="₹{{ number_format($pending, 2) }}"
                                        readonly>
                                </div>

                                {{-- Paying Amount --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Paying Amount
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number"
                                        name="amount"
                                        max="{{ $pending }}"
                                        value="{{ $pending }}"
                                        required
                                        class="form-control form-control-solid"
                                        placeholder="Enter amount">
                                </div>

                                {{-- Payment Mode --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Payment Mode
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="payment_mode"
                                            class="form-select form-select-solid"
                                            required>
                                        <option value="">Select Mode</option>
                                        <option>Cash</option>
                                        <option>UPI</option>
                                        <option>Bank Transfer</option>
                                        <option>Card</option>
                                    </select>
                                </div>

                                {{-- Remarks --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Remarks <span class="text-muted fs-7">(Optional)</span></label>
                                    <input type="text"
                                        name="remarks"
                                        class="form-control form-control-solid"
                                        placeholder="Optional note">
                                </div>

                                {{-- Payment Receipt --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">
                                        Payment Receipt
                                        <span class="text-muted fs-7">(Optional)</span>
                                    </label>

                                    <input type="file"
                                        name="payment_receipt"
                                        class="form-control form-control-solid"
                                        accept=".jpg,.jpeg,.png,.pdf">

                                    <div class="form-text">
                                        Allowed formats: JPG, PNG, PDF (Max 2MB)
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="modal-footer">
                            <button type="button"
                                    class="btn btn-light"
                                    data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>
                                Save Payment
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
.

    <script>
        function confirmSendOffer(e) {
            e.preventDefault(); 

            Swal.fire({
                title: 'Send Offer Letter?',
                text: 'Are you sure you want to send the offer letter to this student?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Send',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d'
            }).then((result) => {
                if (result.isConfirmed) {
                    e.target.submit(); 
                }
            });

            return false;
        }
    </script>

@endsection
</x-admin-layout>
