<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
                <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            DataForSEO Costing
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted">DataForSEO Costing</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--end::Toolbar-->

            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div id="kt_app_content_container" class="app-container container-fluid">

                    @if ($error)
                        <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                            <i class="bi bi-shield-slash fs-2hx text-danger me-4"></i>
                            <div class="d-flex flex-column">
                                <h4 class="mb-1 text-danger fw-bold">API Connection Error</h4>
                                <span>{{ $error }}</span>
                            </div>
                        </div>
                    @endif

                    @if ($result)
                        <!--begin::Stats row-->
                        <div class="row g-5 g-xl-8 mb-8">
                            <!--begin::Balance Card-->
                            <div class="col-xl-4">
                                <div class="card bg-success hoverable h-100 min-h-150px">
                                    <div class="card-body p-6 d-flex flex-column justify-content-center">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="text-white opacity-75 fw-semibold fs-6">Account Balance</div>
                                                <div class="text-white fw-bold fs-1 mt-2">
                                                    ${{ number_format($result['money']['balance'] ?? 0, 4) }}
                                                </div>
                                            </div>
                                            <span class="symbol symbol-50px bg-white bg-opacity-20 p-2 rounded">
                                                <i class="bi bi-wallet2 text-white fs-2x"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Balance Card-->

                            <!--begin::Spent Card-->
                            <div class="col-xl-4">
                                <div class="card bg-primary hoverable h-100 min-h-150px">
                                    <div class="card-body p-6 d-flex flex-column justify-content-center">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <div class="text-white opacity-75 fw-semibold fs-6">Total Spent</div>
                                                <div class="text-white fw-bold fs-1 mt-2">
                                                    ${{ number_format($result['money']['total'] ?? 0, 2) }}
                                                </div>
                                            </div>
                                            <span class="symbol symbol-50px bg-white bg-opacity-20 p-2 rounded">
                                                <i class="bi bi-credit-card text-white fs-2x"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Spent Card-->

                            <!--begin::Metadata Card-->
                            <div class="col-xl-4">
                                <div class="card bg-info hoverable h-100 min-h-150px">
                                    <div class="card-body p-6 d-flex flex-column justify-content-center">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div style="max-width: 75%;">
                                                <div class="text-white opacity-75 fw-semibold fs-6">Active Account</div>
                                                <div class="text-white fw-bold fs-5 mt-2 text-truncate" title="{{ $result['login'] }}">
                                                    {{ $result['login'] }}
                                                </div>
                                                <div class="text-white opacity-75 fs-7 mt-1 text-truncate">
                                                    Timezone: {{ $result['timezone'] }}
                                                </div>
                                            </div>
                                            <span class="symbol symbol-50px bg-white bg-opacity-20 p-2 rounded">
                                                <i class="bi bi-person-check text-white fs-2x"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Metadata Card-->
                        </div>
                        <!--end::Stats row-->

                        <!--begin::Tab Control-->
                        <div class="card card-custom card-stretch gutter-b shadow-sm mb-10">
                            <div class="card-header card-header-stretch border-bottom border-gray-200">
                                <div class="card-title">
                                    <h3 class="card-label fw-bold text-gray-800">Account Health & Usage Breakdown</h3>
                                </div>
                                <div class="card-toolbar">
                                    <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active text-active-primary fw-bold px-5" data-bs-toggle="tab" href="#tab_overview" role="tab" aria-selected="true">
                                                <i class="bi bi-grid-fill me-2 fs-5"></i>Overview
                                            </a>
                                        </li>
                                        <!-- <li class="nav-item" role="presentation">
                                            <a class="nav-link text-active-primary fw-bold px-5" data-bs-toggle="tab" href="#tab_usage" role="tab" aria-selected="false">
                                                <i class="bi bi-bar-chart-fill me-2 fs-5"></i>Periodic Spending
                                            </a>
                                        </li> -->
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link text-active-primary fw-bold px-5" data-bs-toggle="tab" href="#tab_subscriptions" role="tab" aria-selected="false">
                                                <i class="bi bi-clock-history me-2 fs-5"></i>Subscriptions Expiry
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <!--begin::Tab Overview-->
                                    <div class="tab-pane fade show active" id="tab_overview" role="tabpanel">
                                        <div class="row g-5">
                                            <div class="col-md-4">
                                                <h4 class="fw-bold text-gray-800 mb-5">Account Credentials</h4>
                                                <table class="table table-row-dashed table-row-gray-300 align-middle">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-muted fw-semibold py-4">API Username / Login</td>
                                                            <td class="text-gray-800 fw-bold py-4 text-end">{{ $result['login'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-semibold py-4">Account Timezone</td>
                                                            <td class="text-gray-800 fw-bold py-4 text-end">{{ $result['timezone'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-semibold py-4">Total Recharge Volume</td>
                                                            <td class="text-gray-800 fw-bold py-4 text-end">${{ number_format($result['money']['total'] ?? 0, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-muted fw-semibold py-4">Available Credits</td>
                                                            <td class="text-success fw-bolder py-4 text-end">${{ number_format($result['money']['balance'] ?? 0, 4) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-4">
                                                <h4 class="fw-bold text-gray-800 mb-5">API Limits Threshold</h4>
                                                <div class="p-5 bg-light rounded d-flex flex-column gap-3">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-muted fw-semibold">Global Day Limit</span>
                                                        <span class="badge badge-light-primary fw-bold fs-7">
                                                            {{ isset($result['money']['limits']['day']['total']) ? '$' . number_format($result['money']['limits']['day']['total'], 2) : 'No Limit' }}
                                                        </span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-muted fw-semibold">Global Minute Limit</span>
                                                        <span class="badge badge-light-primary fw-bold fs-7">
                                                            {{ isset($result['money']['limits']['minute']['total']) ? '$' . number_format($result['money']['limits']['minute']['total'], 2) : 'No Limit' }}
                                                        </span>
                                                    </div>
                                                    <div class="separator border-gray-300 my-1"></div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-muted fw-semibold">Current Account Status</span>
                                                        <span class="badge badge-light-success fw-bold fs-7">Active</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h4 class="fw-bold text-gray-800 mb-5">Today's Cost Breakdown</h4>
                                                <div class="p-5 bg-light rounded d-flex flex-column gap-3">
                                                    @php
                                                        $dayStats = $result['money']['statistics']['day'] ?? [];
                                                        $dayTotal = $dayStats['total'] ?? 0;
                                                        $activeCategories = [];
                                                        foreach ($dayStats as $key => $cost) {
                                                            if ($key !== 'total' && strpos($key, 'total_') === 0 && $cost > 0) {
                                                                $cleanName = ucwords(str_replace('_', ' ', str_replace('total_', '', $key)));
                                                                $pct = $dayTotal > 0 ? ($cost / $dayTotal) * 100 : 0;
                                                                $activeCategories[] = [
                                                                    'name' => $cleanName,
                                                                    'cost' => $cost,
                                                                    'pct' => $pct
                                                                ];
                                                            }
                                                        }
                                                    @endphp

                                                    @forelse ($activeCategories as $cat)
                                                        <div class="d-flex flex-column mb-2">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="text-gray-800 fw-bold fs-7">{{ $cat['name'] }}</span>
                                                                <span class="text-danger fw-bold fs-7">${{ number_format($cat['cost'], 4) }}</span>
                                                            </div>
                                                            <div class="progress h-6px bg-light-danger">
                                                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $cat['pct'] }}%;" aria-valuenow="{{ $cat['pct'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        @if ($dayTotal > 0)
                                                            <div class="d-flex flex-column mb-2">
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <span class="text-gray-800 fw-bold fs-7">Cost</span>
                                                                    <span class="text-danger fw-bold fs-7">${{ number_format($dayTotal, 4) }}</span>
                                                                </div>
                                                                <div class="progress h-6px bg-light-danger">
                                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="text-center text-muted py-6">
                                                                <i class="bi bi-info-circle fs-2 text-muted mb-2 d-block"></i>
                                                                No service usage costs incurred today.
                                                            </div>
                                                        @endif
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Tab Overview-->

                                    <!--begin::Tab Usage-->
                                    <div class="tab-pane fade" id="tab_usage" role="tabpanel">
                                        <div class="row g-5">
                                            @foreach (['day' => 'Daily Spent Breakdown', 'minute' => 'Minute Spent Breakdown'] as $period => $title)
                                                @php
                                                    $periodStats = $result['money']['statistics'][$period] ?? [];
                                                    $periodTotal = $periodStats['total'] ?? 0;
                                                @endphp
                                                <div class="col-md-6">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <h4 class="fw-bold text-gray-800 mb-0">{{ $title }}</h4>
                                                        <span class="badge badge-light-danger fw-bolder fs-7">Total: ${{ number_format($periodTotal, 6) }}</span>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-3">
                                                            <thead>
                                                                <tr class="fw-bold text-muted fs-7 text-uppercase">
                                                                    <th class="min-w-150px">Service / API Category</th>
                                                                    <th class="min-w-100px text-end">Spent Cost</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($periodStats as $key => $cost)
                                                                    @if ($key !== 'total' && strpos($key, 'total_') === 0 && $cost > 0)
                                                                        @php
                                                                            $cleanKey = ucwords(str_replace('_', ' ', str_replace('total_', '', $key)));
                                                                        @endphp
                                                                        <tr>
                                                                            <td class="text-gray-800 fw-bold">{{ $cleanKey }}</td>
                                                                            <td class="text-danger fw-bold text-end">${{ number_format($cost, 6) }}</td>
                                                                        </tr>
                                                                    @endif
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="2" class="text-muted text-center py-4">No spending records in this period</td>
                                                                    </tr>
                                                                @endforelse

                                                                @php
                                                                    $activeItems = array_filter($periodStats, function($cost, $key) {
                                                                        return $key !== 'total' && strpos($key, 'total_') === 0 && $cost > 0;
                                                                    }, ARRAY_FILTER_USE_BOTH);
                                                                @endphp
                                                                @if (empty($activeItems))
                                                                    <tr>
                                                                        <td colspan="2" class="text-muted text-center py-4">No active category spending</td>
                                                                    </tr>
                                                                @endif
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!--end::Tab Usage-->

                                    <!--begin::Tab Subscriptions-->
                                    <div class="tab-pane fade" id="tab_subscriptions" role="tabpanel">
                                        <div class="row g-5">
                                            <div class="col-md-6">
                                                <div class="card card-bordered shadow-none h-100">
                                                    <div class="card-body p-6 d-flex align-items-center">
                                                        <div class="symbol symbol-50px me-5">
                                                            <span class="symbol-label bg-light-info">
                                                                <i class="bi bi-link-45deg text-info fs-1"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <h5 class="fw-bold text-gray-800">Backlinks API Subscription</h5>
                                                            @if (isset($result['backlinks_subscription_expiry_date']))
                                                                @php
                                                                    $backlinkExpiry = \Carbon\Carbon::parse($result['backlinks_subscription_expiry_date']);
                                                                    $isBacklinkExpired = $backlinkExpiry->isPast();
                                                                @endphp
                                                                <div class="d-flex align-items-center mt-1">
                                                                    <span class="text-muted fs-7 me-3">Expires: {{ $backlinkExpiry->format('d M Y, H:i') }}</span>
                                                                    <span class="badge badge-light-{{ $isBacklinkExpired ? 'danger' : 'success' }} fw-bold fs-9">
                                                                        {{ $isBacklinkExpired ? 'Expired' : 'Active' }}
                                                                    </span>
                                                                </div>
                                                            @else
                                                                <span class="text-muted fs-7">No active subscription</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card card-bordered shadow-none h-100">
                                                    <div class="card-body p-6 d-flex align-items-center">
                                                        <div class="symbol symbol-50px me-5">
                                                            <span class="symbol-label bg-light-primary">
                                                                <i class="bi bi-chat-left-dots text-primary fs-2"></i>
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <h5 class="fw-bold text-gray-800">LLM Mentions API Subscription</h5>
                                                            @if (isset($result['llm_mentions_subscription_expiry_date']))
                                                                @php
                                                                    $llmExpiry = \Carbon\Carbon::parse($result['llm_mentions_subscription_expiry_date']);
                                                                    $isLlmExpired = $llmExpiry->isPast();
                                                                @endphp
                                                                <div class="d-flex align-items-center mt-1">
                                                                    <span class="text-muted fs-7 me-3">Expires: {{ $llmExpiry->format('d M Y, H:i') }}</span>
                                                                    <span class="badge badge-light-{{ $isLlmExpired ? 'danger' : 'success' }} fw-bold fs-9">
                                                                        {{ $isLlmExpired ? 'Expired' : 'Active' }}
                                                                    </span>
                                                                </div>
                                                            @else
                                                                <span class="text-muted fs-7">No active subscription</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Tab Subscriptions-->
                                </div>
                            </div>
                        </div>
                        <!--end::Tab Control-->
                    @endif

                </div>
            </div>
            <!--end::Content-->
        </div>
    @endsection
</x-admin-layout>
