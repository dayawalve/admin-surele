<x-guest-layout>
    @section('content')
        <style>
            body {
                background-image: url('{{ asset("public/custom-img/bg4.jpg") }}');
            }

            [data-bs-theme="dark"] body {
                background-image: url('{{ asset("public/custom-img/bg4-dark.jpg") }}');
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
                            <div class="mb-4 text-sm text-gray-600">
                                This is a secure area of the admin. Please confirm your password before continuing.
                            </div>
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />
                            <form class="form w-100" method="POST" action="{{ route('admin.password.confirm') }}">
                                @csrf
                                <div class="fv-row mb-3">
                                    <input type="password" placeholder="Password" name="password"
                                        class="form-control bg-transparent" required autocomplete="current-password" />
                                </div>
                                <div class="d-grid mb-10">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="indicator-label">Confirm</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-guest-layout>
