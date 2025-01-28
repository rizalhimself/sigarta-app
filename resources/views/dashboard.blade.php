<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white">
        <h2 class="p-4 text-2xl font-bold">SIGARTA</h2>
        <nav>
            <ul>
                <li><a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-700">Dashboard</a></li>
                <li><a href="/manage-users" class="block px-4 py-2 hover:bg-gray-700">Pengguna</a></li>
                <li><a href="/manage-tagihan" class="block px-4 py-2 hover:bg-gray-700">Tagihan</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="block w-full px-4 py-2 text-left hover:bg-red-700">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <p>Welcome back, {{ auth()->user()->username }}!</p>
    </main>
</div>
</body>
</html>
