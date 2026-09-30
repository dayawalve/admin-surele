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
                            <form class="form w-100" method="POST" action="{{ route('admin.login') }}">
                                @csrf
                                <div class="text-center mb-11">
                                    <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                                </div>
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Email" name="identity"
                                        class="form-control bg-transparent" value="{{ old('email') }}" required
                                        autofocus />
                                </div>
                                <div class="fv-row mb-3">
                                    <input type="password" placeholder="Password" name="password"
                                        class="form-control bg-transparent" required autocomplete="current-password" />
                                </div>
                                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                    <div></div>
                                    <a href="{{ route('admin.password.request') }}" class="link-primary">Forgot Password
                                        ?</a>
                                </div>
                                <div class="d-grid mb-10">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Sign In</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="d-flex flex-stack px-lg-10">
                            <div class="me-0">
                            </div>
                            <div class="d-flex fw-semibold text-primary fs-base gap-5">
                                <a href="#">Terms</a>
                                <a href="#">Conditions</a>
                                <a href="#">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-guest-layout>
