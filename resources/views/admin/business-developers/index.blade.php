<x-admin-layout>
    @section('content')

    <style>
        /* Row hover effect */
        .bd-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .bd-table tbody tr:hover {
            background-color: #f9fafb;
        }

        /* Action buttons polish */
        .bd-actions .btn {
            transition: all 0.15s ease-in-out;
        }

        .bd-actions .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        }

        /* Avatar polish */
        .bd-avatar {
            font-size: 14px;
        }

        .table tbody tr:hover {
            background-color: #f9fafb;
            transition: 0.2s ease-in-out;
        }
                
    </style>

        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Business Developer List</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">Business Developers</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        
                        <a href="{{ route('admin.business-developers.create') }}" class="btn btn-sm fw-bold btn-primary">Create</a>
                    </div>
                </div>
            </div>
            
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-xxl">

                    <div class="card shadow-sm border-0">

                        {{-- HEADER --}}
                        <div class="card-header d-flex justify-content-between align-items-center bg-light">
                            <h3 class="card-title mb-0 fw-bold">
                                <i class="bi bi-briefcase-fill text-primary me-2"></i>
                                Business Developer List
                            </h3>
                        </div>

                        {{-- BODY --}}
                        <div class="card-body py-4">
                            <div class="table-responsive">

                                <table class="table align-middle table-row-dashed fs-6 gy-5 bd-table">
                                    <thead class="bg-light">
                                        <tr class="text-muted fw-semibold fs-7 text-uppercase">
                                            <th>#</th>
                                            <th>BD Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Students Enrolled</th>
                                            <th class="text-end pe-8">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody class="fw-semibold text-gray-600">
                                        @foreach ($data as $value)
                                            <tr id="bd_{{ $value->id }}"
                                                class="{{ $value->id === $topBdId ? 'bg-light-success' : '' }}">

                                                {{-- SR --}}
                                                <td>#{{ ++$i }}</td>

                                                {{-- NAME --}}
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="symbol symbol-35px symbol-circle bg-light-primary">
                                                            <span class="text-primary fw-bold">
                                                                {{ strtoupper(substr($value->name, 0, 1)) }}
                                                            </span>
                                                        </div>

                                                        <div>
                                                            <div class="fw-bold d-flex align-items-center gap-2">
                                                                {{ $value->name }}

                                                                @if($value->id === $topBdId)
                                                                    <i class="bi bi-award-fill text-warning"
                                                                    data-bs-toggle="tooltip"
                                                                    title="Top Performer"></i>
                                                                @endif
                                                            </div>
                                                            <small class="text-muted">{{ $value->role_name }}</small>
                                                        </div>
                                                    </div>
                                                </td>

                                                {{-- EMAIL --}}
                                                <td>
                                                    <i class="bi bi-envelope me-1"></i>{{ $value->email }}
                                                </td>

                                                {{-- PHONE --}}
                                                <td>
                                                    <i class="bi bi-telephone me-1"></i>{{ $value->phone }}
                                                </td>

                                                {{-- STUDENTS --}}
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">

                                                        <span class="badge badge-light-info fw-bold">
                                                            <i class="bi bi-people me-1"></i>
                                                            {{ $value->students_count ?? 0 }}
                                                        </span>

                                                        @if($value->id === $topBdId)
                                                            <span class="badge badge-light-success fw-bold">
                                                                <i class="bi bi-arrow-up-circle me-1"></i>
                                                                Top Performer
                                                            </span>
                                                        @endif

                                                    </div>
                                                </td>

                                                {{-- ACTIONS --}}
                                                <td class="text-end pe-8">
                                                    <div class="d-flex justify-content-end gap-1">

                                                        <a href="{{ route('admin.business-developers.edit', $value->id) }}"
                                                        class="btn btn-sm btn-icon btn-light-warning"
                                                        data-bs-toggle="tooltip" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>

                                                        <a href="{{ route('admin.business-developers.status', $value->id) }}"
                                                        class="btn btn-sm btn-icon btn-light-info"
                                                        data-bs-toggle="tooltip"
                                                        title="{{ $value->is_active ? 'Deactivate' : 'Activate' }}">
                                                            <i class="bi {{ $value->is_active ? 'bi-pause' : 'bi-play' }}"></i>
                                                        </a>

                                                        <form action="{{ route('admin.business-developers.destroy', $value->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                    class="btn btn-sm btn-icon btn-light-danger ConfirmDelete"
                                                                    data-bs-toggle="tooltip" title="Delete">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach
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
