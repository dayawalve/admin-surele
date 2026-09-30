<x-admin-layout>
    @section('content')
        <div class="d-flex flex-column flex-column-fluid">
            <div class="app-toolbar py-3 py-lg-6">
                <div class="app-container container-fluid d-flex flex-stack">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Edit Basic Settings</h1>
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
                                            <form action="{{ route('admin.basic-settings.update', $setting->id) }}" method="POST"
                                                class="form" id="BasicSettingForm" autocomplete="off">
                                                @csrf
                                                @method('PUT')
                                                <div class="card-body border-top p-9">
                                                    {{-- Inactivity Threshold --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Inactivity Threshold (seconds)
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="number" name="inactivity_threshold"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ $setting->inactivity_threshold ?? 300 }}"
                                                                data-bvalidator="required,number,min[1]">
                                                        </div>
                                                    </div>

                                                    {{-- Popup Timeout --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Popup Timeout (seconds)
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="number" name="popup_timeout"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ $setting->popup_timeout ?? 3600 }}"
                                                                data-bvalidator="required,number,min[1]">
                                                        </div>
                                                    </div>

                                                    {{-- Check Interval --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Check Interval (seconds)
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="number" name="check_interval"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ $setting->check_interval ?? 5 }}"
                                                                data-bvalidator="required,number,min[1]">
                                                        </div>
                                                    </div>

                                                    {{-- Idle Threshold --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Idle Threshold (seconds)
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="number" name="idle_threshold"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ $setting->idle_threshold ?? 240 }}"
                                                                data-bvalidator="required,number,min[1]">
                                                        </div>
                                                    </div>

                                                    {{-- Send Interval --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">
                                                            Send Interval (seconds)
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="number" name="send_interval"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ $setting->send_interval ?? 60 }}"
                                                                data-bvalidator="required,number,min[1]">
                                                        </div>
                                                    </div>

                                                    {{-- Screenshot Settings --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Screenshot Enabled
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <select name="screenshot_enabled"
                                                                class="form-control form-control-lg form-control-solid">
                                                                <option value="1"
                                                                    {{ ($setting->screenshot_enabled ?? 0) == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="0"
                                                                    {{ ($setting->screenshot_enabled ?? 0) == 0 ? 'selected' : '' }}>
                                                                    No</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Screenshot Count
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="number" name="screenshot_count"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ $setting->screenshot_count ?? 3 }}"
                                                                data-bvalidator="number,min[0]">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Screenshot Time Period (seconds)
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="number" name="screenshot_time_period"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ $setting->screenshot_time_period ?? 300 }}"
                                                                data-bvalidator="number,min[1]">
                                                        </div>
                                                    </div>

                                                    {{-- Activity Tracker --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Activity Tracker Enabled
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <select name="activity_tracker_enabled"
                                                                class="form-control form-control-lg form-control-solid">
                                                                <option value="1"
                                                                    {{ ($setting->activity_tracker_enabled ?? 1) == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="0"
                                                                    {{ ($setting->activity_tracker_enabled ?? 1) == 0 ? 'selected' : '' }}>
                                                                    No</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Activity Check Interval (seconds)
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="number" name="activity_check_interval"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ $setting->activity_check_interval ?? 10 }}"
                                                                data-bvalidator="number,min[1]">
                                                        </div>
                                                    </div>

                                                    {{-- Blocker --}}
                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Blocker Enabled
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <select name="blocker_enabled"
                                                                class="form-control form-control-lg form-control-solid">
                                                                <option value="1"
                                                                    {{ ($setting->blocker_enabled ?? 0) == 1 ? 'selected' : '' }}>
                                                                    Yes</option>
                                                                <option value="0"
                                                                    {{ ($setting->blocker_enabled ?? 0) == 0 ? 'selected' : '' }}>
                                                                    No</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-6">
                                                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                            Blocker Check Interval (seconds)
                                                        </label>
                                                        <div class="col-lg-8">
                                                            <input type="number" name="blocker_check_interval"
                                                                class="form-control form-control-lg form-control-solid"
                                                                value="{{ $setting->blocker_check_interval ?? 60 }}"
                                                                data-bvalidator="number,min[1]">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                    <button type="submit" class="btn btn-primary">
                                                        Save Settings
                                                    </button>
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
<script type="text/javascript">
    function passwordFormat(password) {
        regex = new RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/); // number, a-z, A-Z, min 8 chars
        if (regex.test(password))
            return true;
        return false;
    }
</script>
