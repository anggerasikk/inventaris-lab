<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Admin')</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    <style>
        /* Gaya dasar gradien, akan dipindahkan ke app.css jika menggunakan aset */
        .hero-bg {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            min-height: 100vh;
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="hero-bg">
        @yield('content')
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>