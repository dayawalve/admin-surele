<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Company List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Company</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ route('admin.company-settings.create') }}" class="btn btn-sm fw-bold btn-primary">Create</a>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">
                    <div class="card">
                        <div class="card-body py-4">
                            <div class="table-responsive">
                                <table id="companyTable" class="table align-middle table-row-dashed fs-6 gy-5">
                                    <thead>
                                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                            <th>Sr No.</th>
                                            <th>Company</th>
                                            <th>Contact</th>
                                            <th>Website</th>
                                            <th>Status</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-gray-600 fw-semibold">
                                        @php $i = 0; @endphp

                                        @if($data->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">
                                                    No Company Settings Found
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($data as $value)
                                                <tr id="company_{{ $value->id }}">
                                                    <td>{{ ++$i }}</td>

                                                    {{-- Company Info --}}
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="symbol symbol-45px me-3">
                                                                <img src="{{ $value->logo ? asset($value->logo) : asset('public/custom-img/blank.png') }}"
                                                                    alt="Logo">
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold">{{ $value->company_name }}</div>
                                                                <div class="text-muted fs-7">
                                                                    GST: {{ $value->gst_number ?? 'N/A' }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    {{-- Contact --}}
                                                    <td>
                                                        <div>{{ $value->company_email ?? '—' }}</div>
                                                        <div class="text-muted fs-7">{{ $value->company_phone ?? '—' }}</div>
                                                    </td>

                                                    {{-- Website --}}
                                                    <td>
                                                        @if($value->company_website)
                                                            <a href="{{ $value->company_website }}" target="_blank"
                                                            class="text-primary">
                                                                {{ $value->company_website }}
                                                            </a>
                                                        @else
                                                            —
                                                        @endif
                                                    </td>

                                                    {{-- Status --}}
                                                    <td>
                                                        <span class="badge {{ $value->is_active ? 'badge-light-success' : 'badge-light-danger' }}">
                                                            {{ $value->is_active ? 'Active' : 'Inactive' }}
                                                        </span>
                                                    </td>

                                                    {{-- Actions --}}
                                                    <td class="text-end">
                                                        <a href="{{ route('admin.company-settings.edit', $value->id) }}"
                                                        class="btn btn-sm btn-light-primary"
                                                        data-bs-toggle="tooltip"
                                                        title="Edit Company Settings">
                                                            <i class="bi bi-vector-pen"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
