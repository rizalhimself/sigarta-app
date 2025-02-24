<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIGARTA') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script type="module" src="{{ asset('js/modal.js') }}"></script>
    <script type="module" src="{{ asset('js/table-utils.js') }}"></script>

    @yield('scripts');
</head>

<body class="bg-gray-100">
    <div class="flex mx-auto max-h-full">

        <!--NavBar-->
        @include('components.navbar')
        {{-- End NavBar --}}

        <div class="container flex items-stretch mx-auto max-h-full">

            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Main Content -->
            <main id="mainContent" class="flex p-6 transition-all duration-300 lg:pl-64">
                @yield('content')
            </main>

        </div>

    </div>
    <!-- Import Modal Global -->
    @include('components.modal')
</body>

</html>
