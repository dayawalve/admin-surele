<x-admin-layout>
    @section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div class="app-toolbar py-3 py-lg-6">
            <div class="app-container container-fluid d-flex flex-stack">
                <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Ai Model</h1>
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
                                        <form class="form" action="{{ route('admin.ai-models.update', $model->id) }}"
                                            method="POST" enctype="multipart/form-data" id="FormId">
                                            @csrf
                                            @method('PUT')
                                            <div class="card-body border-top p-9">
                                                <div class="row mb-6">
                                                    <label class="col-lg-2 col-form-label required fw-semibold fs-6">Ai Model</label>
                                                    <div class="col-lg-8">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="text" data-bvalidator="required" value="{{ $model->name }}"
                                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                    name="name" placeholder="Enter ai model" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-6">
                                                    <label class="col-lg-2 col-form-label fw-semibold fs-6">Max Tokens</label>
                                                    <div class="col-lg-8">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="number" min="0" step="1"
                                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                    name="max_tokens" placeholder="Enter max tokens" value="{{ $model->max_tokens ?? 0 }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-6">
                                                    <label class="col-lg-2 col-form-label fw-semibold fs-6">Input Price ($/M)</label>
                                                    <div class="col-lg-8">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="number" min="0" step="0.0001"
                                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                    name="input_price" placeholder="Enter input price per million tokens" value="{{ $model->input_price ?? 0.00 }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-6">
                                                    <label class="col-lg-2 col-form-label fw-semibold fs-6">Output Price ($/M)</label>
                                                    <div class="col-lg-8">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <input type="number" min="0" step="0.0001"
                                                                    class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                                    name="output_price" placeholder="Enter output price per million tokens" value="{{ $model->output_price ?? 0.00 }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                <a href="{{ route('admin.ai-models.index') }}"
                                                    class="btn btn-light btn-active-light-primary me-2">Discard</a>
                                                <button type="submit" class="btn btn-primary"
                                                    id="kt_account_profile_details_submit">Update</button>
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