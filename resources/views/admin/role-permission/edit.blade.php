<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Permission</h1>
                </div>
            </div>
            <div class="app-content flex-column-fluid">
                <div class="app-container container-fluid">
                    <div class="d-flex flex-column-fluid">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card card-custom example example-compact">
                                        <form action="{{ route('admin.role-permission.update', $Roles->id) }}"
                                            autocomplete="off" method="POST" class="form" id="FormId"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="card-body border-top p-9">
                                                <div class="row mb-6">
                                                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">Role
                                                        Name
                                                    </label>
                                                    <div class="col-lg-10">
                                                        <input type="text" data-bvalidator="maxlen[20],required"
                                                            class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                            name="RoleName" value="{{ $Roles->name }}" />
                                                    </div>
                                                </div>
                                                <div class="row mb-6">
                                                    <div class="table-responsive">
                                                        <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                            <tbody class="text-gray-600 fw-bold">
                                                                <tr>
                                                                    <td class="text-gray-800">Administrator Access
                                                                        <i class="fas fa-exclamation-circle ms-1 fs-7"
                                                                            data-bs-toggle="tooltip"
                                                                            title="Allows a full access to the system"></i>
                                                                    </td>
                                                                    <td>
                                                                        <label
                                                                            class="form-check form-check-sm form-check-custom form-check-solid me-9">
                                                                            <input class="form-check-input" type="checkbox"
                                                                                value="" id="RoleSelectAll" />
                                                                            <span class="form-check-label"
                                                                                for="RoleSelectAll">Select
                                                                                all</span>
                                                                        </label>
                                                                    </td>
                                                                </tr>
                                                                @foreach ($AllPermission as $value)
                                                                    <tr>
                                                                        <td class="text-gray-800">
                                                                            <label
                                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                                <span
                                                                                    class="form-check-label me-2 col-10">{{ $value->controller }}</span>
                                                                                <input
                                                                                    class="form-check-input SelectRoleRow {{ $value->controller }}"
                                                                                    type="checkbox" />
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <div class="d-flex">
                                                                                @foreach (json_decode($value->permission) as $item)
                                                                                    @if (strpos($item->name, '.') !== false)
                                                                                        @php
                                                                                            $Split = explode(
                                                                                                '.',
                                                                                                $item->name,
                                                                                            );
                                                                                        @endphp
                                                                                    @endif
                                                                                    <label
                                                                                        class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                                        <input
                                                                                            class="form-check-input CheckAll {{ $value->controller }}"
                                                                                            type="checkbox"
                                                                                            @if (in_array($item->id, $PermissionArray)) checked @endif
                                                                                            value="{{ $item->id }}"
                                                                                            name="permission[]" />
                                                                                        {{-- <span class="form-check-label">
                                                                                            @if (strpos($item->name, '.') !== false)
                                                                                                {{ ucfirst($Split[1]) }} {{ ucfirst($Split[2]) }}
                                                                                            @else
                                                                                                {{ ucfirst($item->name) }}
                                                                                            @endif
                                                                                        </span> --}}
                                                                                        <span class="form-check-label">
                                                                                            @if (count($Split) >= 3)
                                                                                                {{ ucfirst($Split[1]) }}
                                                                                                {{ ucfirst($Split[2]) }}
                                                                                            @elseif (count($Split) == 2)
                                                                                                {{ ucfirst($Split[1]) }}
                                                                                            @else
                                                                                                {{ ucfirst($item->name) }}
                                                                                            @endif
                                                                                        </span>
                                                                                    </label>
                                                                                @endforeach
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-2"></div>
                                                    <div class="col-10">
                                                        <button type="submit" class="btn btn-success mr-2"
                                                            name="submitButton">Submit</button>
                                                        <a href="{{ route('admin.role-permission.index') }}"
                                                            class="btn btn-light-danger">Cancel</a>
                                                    </div>
                                                </div>
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
    @endsection
</x-admin-layout>
