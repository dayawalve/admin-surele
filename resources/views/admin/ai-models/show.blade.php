<x-admin-layout>
    @section('content')
        <style>
            .border-hover-primary:hover {
                border: 1px solid #0d6efd;
                transform: scale(1.02);
                transition: all 0.2s ease;
            }

            .recharge-btn {
                border-radius: 8px;
                padding: 8px 16px;
                font-weight: 500;
                background: linear-gradient(135deg, #4e73df, #224abe);
                border: none;
                transition: all 0.2s ease;
            }

            .recharge-btn .icon {
                background: rgba(255, 255, 255, 0.2);
                width: 20px;
                height: 20px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .recharge-btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 15px rgba(78, 115, 223, 0.3);
            }

            .modal-content {
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }

            .modal-header {
                border-bottom: 1px solid #eee;
            }

            .modal-footer {
                border-top: 1px solid #eee;
            }

            .form-control-solid {
                border-radius: 8px;
                padding: 10px 12px;
            }
        </style>
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            AI Model Details</h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-400 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-muted"> Details</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">

                    {{-- 🔷 HEADER --}}
                    <div class="d-flex flex-wrap flex-stack mb-6">
                        <h3 class="fw-bold m-0"></h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.ai-models.index') }}" class="btn btn-light btn-sm">
                                ← Back
                            </a>
                        </div>
                    </div>


                    {{-- SUMMARY CARDS --}}
                    <div class="row g-5 mb-6">
 
                        {{-- Model Name --}}
                        <div class="col-md-3">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Model Name</h6>
                                    <h2 class="fw-bold text-primary">
                                        {{ $model->name }}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        {{-- Max Tokens --}}
                        <div class="col-md-3">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Max Tokens</h6>
                                    <h2 class="fw-bold text-success">
                                        {{ number_format($model->max_tokens ?? 0) }}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        {{-- Input Price --}}
                        <div class="col-md-3">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Input Price ($/M)</h6>
                                    <h2 class="fw-bold text-warning">
                                        ${{ number_format($model->input_price ?? 0.00, 4) }}
                                    </h2>
                                </div>
                            </div>
                        </div>

                        {{-- Output Price --}}
                        <div class="col-md-3">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Output Price ($/M)</h6>
                                    <h2 class="fw-bold text-danger">
                                        ${{ number_format($model->output_price ?? 0.00, 4) }}
                                    </h2>
                                </div>
                            </div>
                        </div>
 
                    </div>

                </div>
            </div>
        </div>
    @endsection
</x-admin-layout>
