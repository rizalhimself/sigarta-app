<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIGARTA') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script type="module" src="{{ asset('js/modal.js') }}"></script>

    @yield('scripts');
</head>

<body class="bg-gray-100">
    <div class="flex mx-auto max-h-full">

        <!--NavBar-->
        @include('components.navbar')
        {{-- End NavBar --}}

        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        <main id="mainContent" class="flex mt-10 mx-auto w-full lg:ml-80 lg:w-auto flex-grow max-w-5xl sm:px-10 md:px-16 lg:px-16 transition-all duration-300">
            @yield('content')
        </main>

    </div>
    <!-- Import Modal Global -->
    @include('components.modal')
</body>

</html>
