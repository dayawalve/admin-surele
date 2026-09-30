<x-guest-layout>
    @section('content')
        <div class="d-flex flex-column flex-root" >
            <style>
                body {
                    background-image: url('{{ asset('public/custom-img/bg4.jpg') }}');
                }

                [data-bs-theme="dark"] body {
                    background-image: url('{{ asset('public/custom-img/bg4-dark.jpg') }}');
                }
            </style>
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
                        <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                            <form class="form w-100" method="POST" action="{{ route('admin.password.update') }}">
                                @csrf
                                <div class="text-center mb-10">
                                    <h1 class="text-dark fw-bolder mb-3">Setup New Password</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
                                        <a href="{{ route('admin.login') }}" class="link-primary fw-bold">Sign in</a>
                                    </div>
                                </div>
                                <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                                <div class="fv-row mb-8">
                                    <input type="email" placeholder="Email" name="email" required
                                        class="form-control bg-transparent" />
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
                                    <input type="password" placeholder="Repeat Password" name="password_confirmation"
                                        class="form-control bg-transparent" />
                                </div>
                                {{-- <div class="fv-row mb-8">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="toc" value="1" />
                                        <span class="form-check-label fw-semibold text-gray-700 fs-6 ms-1">I Agree &
                                            <a href="#" class="ms-1 link-primary">Terms and conditions</a>.</span>
                                    </label>
                                </div> --}}
                                <div class="d-grid mb-10">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex flex-stack px-lg-10">
                            <div class="me-0">
                            </div>
                            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                <a href="#">Terms</a>
                                <a href="#">Plans</a>
                                <a href="#">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-guest-layout>
