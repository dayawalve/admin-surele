<x-admin-layout>
    @section('content')
        <style>
            /* Premium Core Design & Variables */
            .details-container {
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
            }

            /* Profile Banner Card */
            .profile-banner {
                background: linear-gradient(135deg, #650ea4 0%, #8b25da 100%);
                border-radius: 16px;
                border: none;
                overflow: hidden;
                position: relative;
                color: #fff;
                box-shadow: 0 10px 25px -5px rgba(101, 14, 164, 0.2);
            }

            .profile-banner::before {
                content: "";
                position: absolute;
                top: -50px;
                right: -50px;
                width: 180px;
                height: 180px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.08);
                pointer-events: none;
            }

            .profile-avatar-large {
                width: 70px;
                height: 70px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.2);
                color: #ffffff;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 28px;
                border: 3px solid rgba(255, 255, 255, 0.4);
                backdrop-filter: blur(10px);
            }

            /* Stats Cards */
            .stat-card {
                border: none;
                border-radius: 16px;
                background: #ffffff;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08);
            }

            .stat-icon-wrapper {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
            }

            .bg-light-primary-custom {
                background-color: rgba(101, 14, 164, 0.08);
                color: #650ea4;
            }

            .bg-light-success-custom {
                background-color: rgba(16, 185, 129, 0.08);
                color: #10b981;
            }

            .bg-light-danger-custom {
                background-color: rgba(239, 68, 68, 0.08);
                color: #ef4444;
            }

            /* Table Customization */
            .table-premium {
                border-collapse: separate;
                border-spacing: 0 8px;
                width: 100%;
            }

            .table-premium thead tr th {
                background: transparent;
                border: none;
                color: #6b7280;
                font-weight: 600;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                padding: 12px 20px;
            }

            .table-premium tbody tr {
                background: #ffffff;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
                border-radius: 12px;
                transition: all 0.2s ease;
            }

            .table-premium tbody tr:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
                background-color: #fafafa;
            }

            .table-premium tbody td {
                border: none;
                padding: 16px 20px;
            }

            .table-premium tbody td:first-child {
                border-top-left-radius: 12px;
                border-bottom-left-radius: 12px;
            }

            .table-premium tbody td:last-child {
                border-top-right-radius: 12px;
                border-bottom-right-radius: 12px;
            }

            .competitor-badge {
                padding: 6px 12px;
                border-radius: 8px;
                background-color: rgba(101, 14, 164, 0.08);
                color: #650ea4;
                font-weight: 600;
                font-size: 13px;
                display: inline-block;
            }

            .btn-back-custom {
                border-radius: 10px;
                padding: 8px 18px;
                font-weight: 500;
                background-color: #f3f4f6;
                color: #4b5563;
                border: none;
                transition: all 0.2s ease;
            }

            .btn-back-custom:hover {
                background-color: #e5e7eb;
                color: #1f2937;
            }

            .badge-brand-custom {
                background-color: #650ea4;
                color: #ffffff;
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid details-container">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            Brand Analytics Hub
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.brands.index') }}" class="text-muted text-hover-primary">Brands</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">Details</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">

                    {{-- 🔷 PROFILE HERO BANNER --}}
                    <div class="card profile-banner mb-8">
                        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between p-8 gap-4">
                            <div class="d-flex align-items-center gap-4">
                                <div class="profile-avatar-large">
                                    {{ strtoupper(substr($user->username, 0, 1)) }}
                                </div>
                                <div>
                                    <h1 class="fw-bold text-white mb-1 fs-2">
                                        {{ $user->username }}
                                    </h1>
                                    <div class="d-flex flex-wrap align-items-center gap-3 fs-7 opacity-75">
                                        <span class="d-flex align-items-center gap-1">
                                            ✉️ {{ $user->email }}
                                        </span>
                                        <span class="bullet bg-white opacity-50 w-4px h-4px"></span>
                                        <span>
                                            📅 Registered: {{ \Carbon\Carbon::parse($user->createdAt)->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('admin.brands.index') }}" class="btn btn-back-custom shadow-sm">
                                    ← Back to List
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- 🔷 STATS ROW --}}
                    <div class="row g-5 mb-8">
                        
                        <div class="col-md-4">
                            <div class="card stat-card h-100">
                                <div class="card-body d-flex align-items-center gap-4 p-6">
                                    <div class="stat-icon-wrapper bg-light-primary-custom">
                                        👤
                                    </div>
                                    <div>
                                        <h6 class="text-muted fw-semibold mb-1 fs-7">Brand Identity</h6>
                                        <h3 class="fw-bold text-dark m-0 fs-4">
                                            {{ $user->username }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card stat-card h-100">
                                <div class="card-body d-flex align-items-center gap-4 p-6">
                                    <div class="stat-icon-wrapper bg-light-success-custom">
                                        ⚔️
                                    </div>
                                    <div>
                                        <h6 class="text-muted fw-semibold mb-1 fs-7">Total Competitors</h6>
                                        <h3 class="fw-bold text-success m-0 fs-3">
                                            {{ $competitors->count() }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card stat-card h-100">
                                <div class="card-body d-flex align-items-center gap-4 p-6">
                                    <div class="stat-icon-wrapper bg-light-danger-custom">
                                        💡
                                    </div>
                                    <div>
                                        <h6 class="text-muted fw-semibold mb-1 fs-7">Total Prompts</h6>
                                        <h3 class="fw-bold text-danger m-0 fs-3">
                                            {{ $totalprompts }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- 🔷 AEO CRON SETTING CARD --}}
                    <div class="card shadow-sm border-0 mb-8" style="border-radius: 16px; background-color: #ffffff;">
                        <div class="card-body d-flex align-items-center justify-content-between p-6">
                            <div class="d-flex align-items-center gap-4">
                                <div class="stat-icon-wrapper {{ $user->is_aeo_enabled ? 'bg-light-success-custom' : 'bg-light-danger-custom' }}" style="font-size: 24px;">
                                    🤖
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Answer Engine Optimization (AEO) Cron</h5>
                                    <p class="text-muted m-0 fs-7">
                                        Toggle AEO tracking and cron processes for this user account.
                                    </p>
                                </div>
                            </div>
                            <div>
                                <form action="{{ route('admin.brands.toggle-aeo', $user->id) }}"
                                    method="POST" style="display:inline-block;"
                                    onsubmit="return confirmAeoToggle(event, {{ $user->is_aeo_enabled ? 'true' : 'false' }});">
                                    @csrf
                                    <button type="submit"
                                        class="btn {{ $user->is_aeo_enabled ? 'btn-success' : 'btn-danger' }} d-flex align-items-center gap-2 fw-semibold px-5"
                                        style="border-radius: 12px; padding: 10px 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                                        <span>{{ $user->is_aeo_enabled ? 'Enabled ✅' : 'Disabled ❌' }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- 🔷 COMPETITORS LISTING --}}
                    <div class="card shadow-sm border-0 bg-transparent">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h4 class="fw-bold text-dark m-0">Tracked Competitors</h4>
                            <span class="badge badge-brand-custom px-3 py-2 rounded-pill fs-8">
                                {{ $competitors->count() }} Competitors
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-premium align-middle">
                                <thead>
                                    <tr>
                                        <th class="ps-5" style="width: 80px;">#</th>
                                        <th>Competitor Brand</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($competitors->isEmpty())
                                        <tr>
                                            <td colspan="3">
                                                <div class="text-center text-muted py-8 bg-white rounded-4 shadow-sm">
                                                    <span class="fs-1 d-block mb-2">🔍</span>
                                                    <span class="fw-semibold">No competitors are currently registered under this brand.</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($competitors as $key => $competitor)
                                            <tr>
                                                <td class="ps-5 fw-bold text-muted" style="width: 80px;">
                                                    {{ sprintf('%02d', $key + 1) }}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <!-- <div class="avatar-circle" style="width: 32px; height: 32px; font-size: 12px; margin-right: 0; background-color: #ece8e8ff;">
                                                            {{ strtoupper(substr($competitor->brand_name, 0, 1)) }}
                                                        </div> -->
                                                        <span class="text-dark fw-bold">
                                                            {{ $competitor->brand_name }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="competitor-badge">
                                                        Active Competitor
                                                    </span>
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
        <script>
            function confirmAeoToggle(e, isEnabled) {
                e.preventDefault(); 
                const actionText = isEnabled ? 'disable' : 'enable';
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${actionText} the AEO option for this user?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, proceed',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#650ea4',
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