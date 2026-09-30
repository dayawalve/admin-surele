<x-admin-layout>
    @section('content')
        <style>
            /* Premium Core Design & Variables */
            .models-container {
                font-family: 'Inter', system-ui, -apple-system, sans-serif;
            }

            /* Card Styling */
            .custom-card {
                border-radius: 16px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
                border: none;
                background: #ffffff;
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
                padding: 14px 20px;
            }

            .table-premium tbody tr {
                background: #ffffff;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
                border-radius: 12px;
                transition: all 0.2s ease-in-out;
            }

            .table-premium tbody tr:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
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

            /* Avatar Circle */
            .avatar-circle-custom {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background-color: rgba(101, 14, 164, 0.08);
                color: #650ea4;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                font-size: 16px;
                margin-right: 12px;
            }

        /* Empty State */
        .empty-state {
            padding: 40px 0;
            text-align: center;
            color: #999;
            font-size: 14px;
        }

            /* Action Buttons */
            .action-btn-custom {
                border-radius: 8px;
                padding: 8px 12px;
                font-size: 14px;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border: none;
            }

            .action-btn-custom:hover {
                transform: translateY(-1px);
            }

            .btn-view-custom {
                background-color: rgba(101, 14, 164, 0.08);
                color: #650ea4;
            }

            .btn-view-custom:hover {
                background-color: #650ea4;
                color: #ffffff;
            }

            .btn-edit-custom {
                background-color: rgba(59, 130, 246, 0.08);
                color: #2563eb;
            }

            .btn-edit-custom:hover {
                background-color: #2563eb;
                color: #ffffff;
            }

            .btn-delete-custom {
                background-color: rgba(239, 68, 68, 0.08);
                color: #ef4444;
            }

            .btn-delete-custom:hover {
                background-color: #ef4444;
                color: #ffffff;
            }

            .btn-create-custom {
                background: linear-gradient(135deg, #650ea4 0%, #8b25da 100%);
                color: #ffffff !important;
                border-radius: 10px;
                padding: 8px 20px;
                font-weight: 600;
                border: none;
                transition: all 0.2s ease;
                box-shadow: 0 4px 12px rgba(101, 14, 164, 0.2);
            }

            .btn-create-custom:hover {
                transform: translateY(-1px);
                box-shadow: 0 6px 18px rgba(101, 14, 164, 0.3);
            }
        </style>

        <div class="d-flex flex-column flex-column-fluid models-container">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-xxl d-flex flex-stack">
                    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                            AI Models List
                        </h1>
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                            <li class="breadcrumb-item text-muted">
                                <a href="{{ route('admin.index') }}" class="text-muted text-hover-primary">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="bullet bg-gray-300 w-5px h-2px"></span>
                            </li>
                            <li class="breadcrumb-item text-dark">AI Models</li>
                        </ul>
                    </div>
                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                        <a href="{{ route('admin.ai-models.create') }}" class="btn btn-create-custom">
                            + Create Model
                        </a>
                    </div>
                </div>
            </div>

            <div id="kt_app_content" class="app-content flex-column-fluid">
                <div class="app-container container-xxl">
                    <div class="card custom-card bg-transparent">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="customerTable" class="table table-premium align-middle">
                                    <thead>
                                        <tr>
                                            <th class="ps-5" style="width: 80px;">Sr No.</th>
                                            <th>AI Model</th>
                                            <th>Max Tokens</th>
                                            <th>Input Price ($/M)</th>
                                            <th>Output Price ($/M)</th>
                                            <th class="text-end pe-5">Actions</th>
                                        </tr>
                                    </thead>
 
                                    <tbody>
                                        @if ($models->isEmpty())
                                            <tr>
                                                <td colspan="6">
                                                    <div class="empty-state bg-white rounded-4 shadow-sm py-8">
                                                        😕 No Models Found
                                                    </div>
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($models as $key => $value)
                                                <tr>
                                                    <td class="fw-bold text-muted ps-5" style="width: 80px;">
                                                        {{ sprintf('%02d', ++$i) }}
                                                    </td>
 
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-circle-custom">
                                                                {{ strtoupper(substr($value->name, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <div class="fw-bold text-dark fs-6">
                                                                    {{ $value->name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <span class="text-gray-800 fw-bold fs-6">
                                                            {{ number_format($value->max_tokens) }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <span class="text-gray-800 fw-bold fs-6">
                                                            ${{ number_format($value->input_price, 4) }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <span class="text-gray-800 fw-bold fs-6">
                                                            ${{ number_format($value->output_price ?? 0.00, 4) }}
                                                        </span>
                                                    </td>

                                                    <td class="text-end pe-5">
                                                        <div class="d-inline-flex gap-2">
                                                            <!-- View -->
                                                            <a href="{{ route('admin.ai-models.show', $value->id) }}"
                                                                class="action-btn-custom btn-view-custom"
                                                                title="View Details">
                                                                👁
                                                            </a>

                                                            <!-- Edit -->
                                                            <a href="{{ route('admin.ai-models.edit', $value->id) }}"
                                                                class="action-btn-custom btn-edit-custom"
                                                                title="Edit Model">
                                                                ✏️
                                                            </a>

                                                            <!-- Delete -->
                                                            <form action="{{ route('admin.ai-models.destroy', $value->id) }}"
                                                                method="POST" style="display:inline-block;"
                                                                onsubmit="return confirm('Are you sure you want to delete this model?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="action-btn-custom btn-delete-custom"
                                                                    title="Delete Model">
                                                                    🗑️
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <div class="mt-4">
                                    {{ $models->links() }}
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