<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <main  class="d-flex justify-content-center">
            <div style="max-width: 500px;" class="col">
                <nav style="z-index: 100" class="d-flex justify-content-around p-1 fs-4 bg-info position-sticky top-0 mb-2">
                    <a class=" nav-link" href="#"><i class="fa-solid fa-house"></i></a>
                    <a class="nav-link" href="#"><i class="fa-solid fa-magnifying-glass"></i></a>
                    <a class="nav-link" href="#"><i class="fa-regular fa-pen-to-square"></i></a>
                    <a class="nav-link" href="#"><i class="fa-regular fa-heart"></i></a>
                    <a class="nav-link" href="#"><i class="fa-regular fa-user"></i></a>
                </nav>
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Jquery CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @yield('socialJs')
</body>
</html>
