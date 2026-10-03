<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    @php
    $route = request()->segments();
    $route = array_filter($route, function ($value) {
        return !is_numeric($value);
    });
    @endphp
    <div class="app-sidebar-logo px-4 d-flex align-items-center justify-content-center position-relative">
        <a href="{{ route('admin.index') }}" class="d-flex align-items-center justify-content-center w-100">
            <img alt="Surele Logo" src="{{ url('/') }}/public/custom-img/surele_logo.svg?v=5"
                class="app-sidebar-logo-default" style="height: 58px; max-width: 175px; width: auto; object-fit: contain;" />
            <img alt="Surele Logo" src="{{ url('/') }}/public/custom-img/surele_icon.png?v=5"
                class="h-35px app-sidebar-logo-minimize" />
        </a>        
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <i class="ki-duotone ki-black-left-line fs-3 rotate-180">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </div>
    </div>
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
            <div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    <div class="menu-item">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Admin</span>
                        </div>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('admin.index') }}">
                            <span class="menu-icon">
                                <i class="ki-duotone ki-element-11 fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('admin.users.index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-person-fill fs-2"></i>
                            </span>
                            <span class="menu-title">Users</span>
                        </a>
                    </div>
                    <!-- <div class="menu-item">
                        <a class="menu-link" href="{{ route('admin.role-permission.index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-person-lines-fill fs-2"></i>
                            </span>
                            <span class="menu-title">Roles</span>
                        </a>
                    </div>
                    <div class="menu-item">
                        <a class="menu-link" href="{{ route('admin.permission-listing.index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-link fs-2"></i>
                            </span>
                            <span class="menu-title">Permissions</span>
                        </a>
                    </div> -->
                    <div class="menu-item pt-2">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Label</span>
                        </div>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ isset($route[1]) && $route[1] == 'leads' ? 'active' : '' }}" href="{{ route('admin.leads.index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-funnel-fill fs-2"></i>
                            </span>
                            <span class="menu-title">Leads</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ isset($route[1]) && $route[1] == 'blogs' ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-journal-richtext fs-2"></i>
                            </span>
                            <span class="menu-title">Blogs</span>
                        </a>
                    </div>

                    {{-- <div class="menu-item">
                        <a class="menu-link {{ isset($route[1]) && $route[1] == 'employees' ? 'active' : '' }}" href="{{ route('admin.employees.index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-link fs-2"></i>
                            </span>
                            <span class="menu-title">Employees</span>
                        </a>
                    </div>

                    <div class="menu-item">
                        <a class="menu-link {{ isset($route[1]) && $route[1] == 'ideal-time-reason' ? 'active' : '' }}" href="{{ route('admin.ideal-time-reason.index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-link fs-2"></i>
                            </span>
                            <span class="menu-title">Ideal Time Reason</span>
                        </a>
                    </div> --}}

                    {{-- <div class="menu-item">
                        <a class="menu-link {{ isset($route[1]) && $route[1] == 'company-settings' ? 'active' : '' }}" href="{{ route('admin.company-settings.index') }}">
                            <span class="menu-icon">
                                <i class="bi bi-link fs-2"></i>
                            </span>
                            <span class="menu-title">Company Settings</span>
                        </a>
                    </div> --}}
                    
                </div>
            </div>
        </div>
    </div>
    <div class="app-sidebar-footer flex-column-auto pt-2 pb-6 px-6" id="kt_app_sidebar_footer">
    </div>
</div>
