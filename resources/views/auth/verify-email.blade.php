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
                            @if (session('status') == 'verification-link-sent')
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    A new verification link has been sent to the email address you provided during
                                    registration.
                                </div>
                            @endif
                            <div class="mb-4 text-gray-600">
                                Thanks for signing up! Before getting started, could you verify your email address by
                                clicking on the link we just emailed to you? If you didn't receive the email, we will
                                gladly send you another.
                            </div>
                            <form method="POST" action="{{ route('verification.send') }}" class="mt-5">
                                @csrf
                                <div>
                                    <button type="submit" class="btn btn-primary me-4">
                                        <span class="indicator-label">Resend Verification Email</span>
                                    </button>
                                </div>
                            </form>
                            <form method="POST" action="{{ route('logout') }}" class="mt-5">
                                @csrf
                                <button type="submit" class="btn btn-primary me-4">
                                    <span class="indicator-label">Logout</span>
                                </button>
                            </form>
                        </div>
                        <div class="d-flex justify-center px-lg-10">
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
