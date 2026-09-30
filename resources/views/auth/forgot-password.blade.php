<x-guest-layout>
    @section('content')
        <div class="d-flex flex-column flex-root">
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
                            <form class="form w-100" method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="text-center mb-10">
                                    <h1 class="text-dark fw-bolder mb-3">Forgot Password ?</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.
                                    </div>
                                </div>
                                <x-auth-session-status class="mb-4" :status="session('status')" />
                                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Email" name="email"
                                        class="form-control bg-transparent" value="{{ old('email') }}" />
                                </div>
                                <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                    <button type="submit" class="btn btn-primary me-4">
                                        <span class="indicator-label">Submit</span>
                                    </button>
                                    <a href="{{ route('login') }}" class="btn btn-light">Cancel</a>
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
