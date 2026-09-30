<x-guest-layout>
    @section('content')
        <style>
            body {
                background-image: url('{{ asset('public/custom-img/bg4.jpg') }}');
            }

            [data-bs-theme="dark"] body {
                background-image: url('{{ asset('public/custom-img/bg4-dark.jpg') }}');
            }
        </style>
        <div class="d-flex flex-column flex-root">
            <div class="d-flex flex-column flex-column-fluid flex-lg-row">
                <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                    <div class="d-flex flex-center flex-lg-start flex-column">
                        <a href="#" class="mb-7">
                            <img alt="Logo" src="{{ url('/') }}/public/custom-img/light.svg" width="300px"
                                height="100px" />
                        </a>
                    </div>
                </div>
                <div
                    class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                    <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10">
                            <form class="form w-100" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="text-center mb-11">
                                    <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
                                </div>
                                <div class="row g-3 mb-9">
                                    <div class="col-md-6">
                                        <a href="{{ url('auth/google') }}"
                                            class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                            <img alt="Logo" src="{{ url('/') }}/public/custom-img/google-icon.svg"
                                                class="h-15px me-3" />Sign in with Google</a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ url('auth/github') }}"
                                            class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                            <img alt="Logo" src="{{ url('/') }}/public/custom-img/github-1.svg"
                                                class="theme-light-show h-15px me-3" />
                                            <img alt="Logo" src="{{ url('/') }}/public/custom-img/github.svg"
                                                class="theme-dark-show h-15px me-3" />Sign in with Github</a>
                                    </div>
                                </div>
                                <div class="separator separator-content my-14">
                                    <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
                                </div>
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="First Name" name="fname"
                                        class="form-control bg-transparent" required value="{{ old('fname') }}" />
                                </div>
                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Last Name" name="lname"
                                        class="form-control bg-transparent" required value="{{ old('lname') }}" />
                                </div>
                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Email" name="email"
                                        class="form-control bg-transparent" required value="{{ old('email') }}" />
                                </div>
                                <div class="fv-row mb-8" data-kt-password-meter="true">
                                    <div class="mb-1">
                                        <div class="position-relative mb-3">
                                            <input class="form-control bg-transparent" type="password"
                                                placeholder="Password" name="password" required />
                                            <span
                                                class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                                data-kt-password-meter-control="visibility">
                                                <i class="ki-duotone ki-eye-slash fs-2"></i>
                                                <i class="ki-duotone ki-eye fs-2 d-none"></i>
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center mb-3"
                                            data-kt-password-meter-control="highlight">
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                            </div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                            </div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2">
                                            </div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                        </div>
                                    </div>
                                    <div class="text-muted">Use 8 or more characters with a mix of letters, numbers &
                                        symbols.</div>
                                </div>
                                <div class="fv-row mb-8">
                                    <input placeholder="Repeat Password" name="password_confirmation" type="password"
                                        class="form-control bg-transparent" />
                                </div>
                                <div class="fv-row mb-8">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="toc" value="1"
                                            required />
                                        <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
                                            <a href="#" class="ms-1 link-primary">Terms & Conditions</a></span>
                                    </label>
                                </div>
                                <div class="d-grid mb-10">
                                    <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                                        <span class="indicator-label">Sign up</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
                                    <a href="{{ route('login') }}" class="link-primary fw-semibold">Sign in</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-guest-layout>
