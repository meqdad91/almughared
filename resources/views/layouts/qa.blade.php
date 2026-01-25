<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.2.0/ckeditor5.css">

    @yield('head')
</head>

<body>
    <header class="w-full bg-white shadow p-4 flex justify-between items-center">
        <div class="text-xl font-bold">
            <span style="font-size: 20px;color: #2b1a40;font-weight: bold;">
                Almughared
            </span>
        </div>
        <div class="flex items-center space-x-4">
            <button class="relative">
                <i class="fas fa-bell"></i>
                <span class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full"></span>
            </button>
            @include('layouts.partials.header-user-dropdown')
        </div>
    </header>
    <div class="container-fluid">
        <div class="row">
            @include('qa.partials.sidebar')
            @yield('content')
        </div>
    </div>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-..."
        crossorigin="anonymous"></script>
    @yield('scripts')
</body>

</html>