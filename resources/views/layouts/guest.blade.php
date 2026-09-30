<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Aquil-CRM') }}</title>
    <link rel="shortcut icon" href="{{ url('/') }}/public/custom-img/28x28.png" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link rel="stylesheet" href="{{ url('/') }}/public/css/admin/app.css">
    <link rel="stylesheet" href="{{ url('/') }}/public/css/admin/plugins.bundle.css">
    <link rel="stylesheet" href="{{ url('/') }}/public/css/admin/style.bundle.css">
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <div class="font-sans text-gray-900 antialiased">
        @yield('content')
    </div>
</body>
<script src="{{ url('/') }}/public/js/admin/plugins.bundle.js"></script>
<script src="{{ url('/') }}/public/js/admin/scripts.bundle.js"></script>
<script src="{{ url('/') }}/public/js/admin/widgets.bundle.js"></script>
<script src="{{ url('/') }}/public/js/custom.js"></script>

</html>
