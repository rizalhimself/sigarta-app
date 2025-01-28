<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIGARTA') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
<div class="flex">
    <!-- Sidebar -->
    @include('components.sidebar')

    <!--NavBar-->
    @include('components.navbar')
    {{--End NavBar--}}

    <!-- Main Content -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>
</body>
</html>
