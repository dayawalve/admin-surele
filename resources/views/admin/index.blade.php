<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Dashboard
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Dashboard</li>
                        </ul>
                    </div>
                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container container-fluid">
                    
                    <div class="row mt-5 g-5 g-xl-8">
                        <div class="col-xl-6 col-md-6">
                            <a href="{{ route('admin.leads.index') }}" class="card bg-primary hoverable card-xl-stretch mb-xl-8 shadow-sm">
                                <div class="card-body">
                                    <i class="bi bi-funnel-fill text-white fs-2x ms-n1 d-block mb-3"></i> 
                                    <div class="text-white fw-bold fs-2 mb-2 mt-5"> {{ $totalLeads }} </div>
                                    <div class="fw-semibold text-white"> Total Leads </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <a href="{{ route('admin.users.index') }}" class="card bg-info hoverable card-xl-stretch mb-xl-8 shadow-sm">
                                <div class="card-body">
                                    <i class="bi bi-person-badge-fill text-white fs-2x ms-n1 d-block mb-3"></i> 
                                    <div class="text-white fw-bold fs-2 mb-2 mt-5"> {{ $totalAdmins }} </div>
                                    <div class="fw-semibold text-white"> Registered Admins </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
