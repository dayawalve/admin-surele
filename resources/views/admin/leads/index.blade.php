<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <!-- Toolbar -->
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Leads & Enquiries
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Leads</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">

                    @if(session('success'))
                        <div class="alert alert-success d-flex align-items-center p-5 mb-6">
                            <i class="bi bi-check-circle-fill fs-2hx text-success me-4"></i>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Metric Cards -->
                    <div class="row g-5 g-xl-8 mb-6">
                        <div class="col-md-4">
                            <div class="card card-bordered shadow-sm bg-light-primary">
                                <div class="card-body p-6 d-flex align-items-center">
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label bg-primary text-white">
                                            <i class="bi bi-funnel-fill fs-2 text-white"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fs-3 fw-bolder text-dark">{{ $totalLeads ?? 0 }}</div>
                                        <div class="fs-7 text-muted fw-semibold">Total Leads / Enquiries</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-bordered shadow-sm bg-light-success">
                                <div class="card-body p-6 d-flex align-items-center">
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label bg-success text-white">
                                            <i class="bi bi-bell-fill fs-2 text-white"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fs-3 fw-bolder text-dark">{{ $newLeads ?? 0 }}</div>
                                        <div class="fs-7 text-muted fw-semibold">New Enquiries</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-bordered shadow-sm bg-light-info">
                                <div class="card-body p-6 d-flex align-items-center">
                                    <div class="symbol symbol-50px me-4">
                                        <span class="symbol-label bg-info text-white">
                                            <i class="bi bi-calendar-event-fill fs-2 text-white"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <div class="fs-3 fw-bolder text-dark">{{ $todayLeads ?? 0 }}</div>
                                        <div class="fs-7 text-muted fw-semibold">Today's Enquiries</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Leads Card -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header border-0 pt-6">
                            <div class="card-title">
                                <h3 class="fw-bold m-0 text-gray-800">
                                    <i class="bi bi-person-lines-fill text-primary me-2"></i> All Enquiries
                                </h3>
                            </div>
                            <div class="card-toolbar d-flex align-items-center gap-3">
                                <form method="GET" action="{{ route('admin.leads.index') }}" class="d-flex align-items-center gap-2">
                                    <div class="position-relative">
                                        <i class="bi bi-search position-absolute top-50 translate-middle-y ms-3 text-gray-500"></i>
                                        <input type="text" name="search" value="{{ request('search') }}" 
                                            class="form-control form-control-solid ps-10 h-40px" 
                                            placeholder="Search name, phone, product..." />
                                    </div>
                                    @if(request('search') || request('status'))
                                        <a href="{{ route('admin.leads.index') }}" class="btn btn-sm btn-light">Reset</a>
                                    @endif
                                </form>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            @if(isset($leads) && count($leads) > 0)
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-4">
                                        <thead>
                                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0 border-bottom border-gray-200">
                                                <th>#</th>
                                                <th>Customer</th>
                                                <th>Contact</th>
                                                <th>Product</th>
                                                <th>Size / Qty</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="fw-semibold text-gray-700">
                                            @foreach($leads as $key => $lead)
                                                <tr>
                                                    <td>{{ $leads->firstItem() ? $leads->firstItem() + $key : $key + 1 }}</td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            <span class="text-dark fw-bold fs-6">{{ $lead->name ?? '-' }}</span>
                                                            @if(!empty($lead->company))
                                                                <span class="text-muted fs-7"><i class="bi bi-building me-1"></i>{{ $lead->company }}</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            @if(!empty($lead->phone))
                                                                <a href="tel:{{ $lead->phone }}" class="text-dark text-hover-primary fs-7">
                                                                    <i class="bi bi-telephone-fill text-success me-1"></i>{{ $lead->phone }}
                                                                </a>
                                                            @endif
                                                            @if(!empty($lead->email))
                                                                <a href="mailto:{{ $lead->email }}" class="text-muted text-hover-primary fs-8">
                                                                    <i class="bi bi-envelope-fill me-1"></i>{{ $lead->email }}
                                                                </a>
                                                            @endif
                                                            @if(empty($lead->phone) && empty($lead->email))
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if(!empty($lead->product))
                                                            <span class="badge badge-light-primary fw-bold">{{ $lead->product }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($lead->size_qty))
                                                            <span class="badge badge-light-info">{{ $lead->size_qty }}</span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="text-truncate" style="max-width: 180px;" title="{{ $lead->message ?? '' }}">
                                                            {{ $lead->message ?? '-' }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $status = $lead->status ?? 'New';
                                                            $badgeClass = match($status) {
                                                                'New' => 'badge-light-success',
                                                                'Contacted' => 'badge-light-primary',
                                                                'In Progress' => 'badge-light-warning',
                                                                'Converted' => 'badge-light-success',
                                                                'Closed' => 'badge-light-danger',
                                                                default => 'badge-light-info',
                                                            };
                                                        @endphp
                                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="fs-7 text-muted">
                                                            {{ isset($lead->created_at) ? \Carbon\Carbon::parse($lead->created_at)->format('M d, Y h:i A') : '-' }}
                                                        </span>
                                                    </td>
                                                    <td class="text-end">
                                                        <button type="button" class="btn btn-sm btn-icon btn-light-primary me-2" 
                                                            onclick="viewLeadDetails({{ json_encode($lead) }})" 
                                                            title="View Details">
                                                            <i class="bi bi-eye-fill fs-5"></i>
                                                        </button>

                                                        <form method="POST" action="{{ route('admin.leads.destroy', $lead->id) }}" 
                                                            class="d-inline" 
                                                            onsubmit="return confirm('Are you sure you want to delete this enquiry?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-icon btn-light-danger" title="Delete">
                                                                <i class="bi bi-trash-fill fs-5"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-5">
                                    <div class="text-muted fs-7">
                                        Showing {{ $leads->firstItem() ?? 0 }} to {{ $leads->lastItem() ?? 0 }} of {{ $leads->total() ?? 0 }} entries
                                    </div>
                                    <div>
                                        {{ $leads->links() }}
                                    </div>
                                </div>
                            @else
                                <!-- Clean Empty / Placeholder State -->
                                <div class="text-center py-15">
                                    <div class="symbol symbol-100px mb-5">
                                        <span class="symbol-label bg-light-primary">
                                            <i class="bi bi-funnel text-primary fs-3x"></i>
                                        </span>
                                    </div>
                                    <h3 class="fs-2 fw-bold text-gray-800 mb-2">No Enquiries Received Yet</h3>
                                    <p class="text-muted fs-6 mb-6 mw-500px mx-auto">
                                        Your frontend enquiry form is connected to the API endpoint:
                                        <code class="d-block mt-2 p-2 bg-light rounded text-dark fs-7">POST {{ url('/api/enquiry') }}</code>
                                        When visitors submit the form, their enquiries will instantly appear here.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- View Details Modal -->
        <div class="modal fade" id="leadDetailModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold" id="modalTitle">Enquiry Details</h2>
                        <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg fs-3"></i>
                        </button>
                    </div>
                    <div class="modal-body py-6 px-lg-10">
                        <div class="row mb-5">
                            <div class="col-sm-6 mb-3">
                                <label class="fw-semibold text-muted fs-7">Full Name</label>
                                <div class="fw-bold fs-6 text-gray-800" id="m_name">-</div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="fw-semibold text-muted fs-7">Company</label>
                                <div class="fw-bold fs-6 text-gray-800" id="m_company">-</div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-sm-6 mb-3">
                                <label class="fw-semibold text-muted fs-7">Email</label>
                                <div><a href="#" id="m_email" class="fw-bold fs-6 text-primary">-</a></div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="fw-semibold text-muted fs-7">Phone / WhatsApp</label>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="#" id="m_phone" class="fw-bold fs-6 text-gray-800">-</a>
                                    <a href="#" id="m_wa_link" target="_blank" class="btn btn-xs btn-light-success py-1 px-2 d-none">
                                        <i class="bi bi-whatsapp"></i> Chat
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-sm-6 mb-3">
                                <label class="fw-semibold text-muted fs-7">Product</label>
                                <div class="fw-bold fs-6 text-gray-800" id="m_product">-</div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="fw-semibold text-muted fs-7">Size / Qty</label>
                                <div class="fw-bold fs-6 text-gray-800" id="m_size_qty">-</div>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="fw-semibold text-muted fs-7">Message</label>
                            <div class="p-4 bg-light rounded text-gray-800 fs-6" id="m_message" style="white-space: pre-wrap;">-</div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-sm-6 mb-3">
                                <label class="fw-semibold text-muted fs-7">Submitted At</label>
                                <div class="fs-7 text-gray-700" id="m_date">-</div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="fw-semibold text-muted fs-7">Status</label>
                                <div>
                                    <form id="m_status_form" method="POST" action="">
                                        @csrf
                                        @method('PUT')
                                        <div class="d-flex gap-2">
                                            <select name="status" id="m_status_select" class="form-select form-select-sm form-select-solid">
                                                <option value="New">New</option>
                                                <option value="Contacted">Contacted</option>
                                                <option value="In Progress">In Progress</option>
                                                <option value="Converted">Converted</option>
                                                <option value="Closed">Closed</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function viewLeadDetails(lead) {
                document.getElementById('m_name').innerText = lead.name || '-';
                document.getElementById('m_company').innerText = lead.company || 'Not specified';
                
                const emailEl = document.getElementById('m_email');
                if (lead.email) {
                    emailEl.innerText = lead.email;
                    emailEl.href = 'mailto:' + lead.email;
                } else {
                    emailEl.innerText = '-';
                    emailEl.removeAttribute('href');
                }

                const phoneEl = document.getElementById('m_phone');
                const waLink = document.getElementById('m_wa_link');
                if (lead.phone) {
                    phoneEl.innerText = lead.phone;
                    phoneEl.href = 'tel:' + lead.phone;
                    
                    const cleanPhone = lead.phone.replace(/[^0-9]/g, '');
                    if (cleanPhone) {
                        waLink.href = 'https://wa.me/' + cleanPhone;
                        waLink.classList.remove('d-none');
                    } else {
                        waLink.classList.add('d-none');
                    }
                } else {
                    phoneEl.innerText = '-';
                    phoneEl.removeAttribute('href');
                    waLink.classList.add('d-none');
                }

                document.getElementById('m_product').innerText = lead.product || '-';
                document.getElementById('m_size_qty').innerText = lead.size_qty || '-';
                document.getElementById('m_message').innerText = lead.message || 'No message provided.';
                document.getElementById('m_date').innerText = lead.created_at ? new Date(lead.created_at).toLocaleString() : '-';

                // Status form update URL
                const form = document.getElementById('m_status_form');
                form.action = '{{ url("admin/leads") }}/' + lead.id;
                document.getElementById('m_status_select').value = lead.status || 'New';

                const modal = new bootstrap.Modal(document.getElementById('leadDetailModal'));
                modal.show();
            }
        </script>
    @endsection
</x-admin-layout>
