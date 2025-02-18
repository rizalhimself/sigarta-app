<header class="antialiased z-50">
    <nav class="shadow-lg bg-gray-50 border-gray-200 px-4 lg:px-5 py-2.5 dark:bg-gray-800 fixed top-0 left-0 right-0 z-50"
        data-navbar-sticky="top">
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex justify-start items-center">

                {{-- Hamburger Menu --}}
                <div class="grid grid-cols-2 items-center">
                    <button id="sidebar-toggle" class=" text-gray-700 dark:text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                {{-- Logo and Title on Left Hidden on Tablet --}}
                <div class="grid items-center">
                    <div class="sm:hidden lg:block">
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-center">
                            <img src="https://flowbite.s3.amazonaws.com/logo.svg" class="mr-3 h-8" alt="Logo">
                            <span
                                class="text-2xl font-semibold whitespace-nowrap text-gray-800 dark:text-white ">SIGARTA</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Logo and Title on Center Show on Tablet --}}
            <div class="hidden sm:block lg:hidden">
                <div class="flex justify-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="https://flowbite.s3.amazonaws.com/logo.svg" class="mr-3 h-8" alt="Logo">
                        <span
                            class="text-2xl font-semibold whitespace-nowrap text-gray-800 dark:text-white ">SIGARTA</span>
                    </a>
                </div>
            </div>

            <div class="flex items-center lg:order-2">
                <!-- Dark Mode Toggle -->
                <button id="theme-toggle" type="button"
                    class="p-2 text-gray-500 dark:text-gray-400 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg id="theme-toggle-dark-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a7 7 0 1 1 0 14 7 7 0 0 1 0-14Z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 5a1 1 0 0 1 1 1v8a1 1 0 1 1-2 0V6a1 1 0 0 1 1-1Z"></path>
                    </svg>
                </button>

                <!-- User Menu -->
                <div class="relative ml-4">
                    <button type="button"
                        class="flex items-center text-sm  rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        id="user-menu-button" aria-expanded="false">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full"
                            src="{{ auth()->user()->warga->link_foto ? asset('storage/' . auth()->user()->warga->link_foto) : asset('storage/default-avatar.png') }}"
                            alt="user photo">
                        <div class="hidden md:hidden lg:block px-2.5 text-sm text-gray-800 dark:text-white">
                            <span class="font-bold">{{ auth()->user()->warga->nama_lengkap ?? 'Guest' }}</span>
                        </div>
                    </button>
                    <!-- Dropdown menu -->
                    <div class="fixed right-2 w-48 top-16 bg-gray-50 rounded-lg shadow-lg dark:bg-gray-800 transform transition-transform duration-300 ease-in-out -translate-y-full hidden"
                        id="user-dropdown">
                        <div class="py-3 px-4 text-sm text-gray-900 dark:text-white">
                            <span
                                class="block lg:hidden font-bold">{{ auth()->user()->warga->nama_lengkap ?? 'Guest' }}</span>
                            <span class="hidden sm:block lg:block font-medium">{{ auth()->user()->username }}</span>
                            <span
                                class="block lg:hidden text-gray-500 dark:text-gray-400">{{ auth()->user()->username }}</span>
                            <span
                                class="hidden sm:block lg:block text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</span>
                        </div>
                        <ul class="py-1 px-1">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm rounded-[10px] text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600">Profile</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button
                                        class="block w-full text-left px-4 py-2 text-sm rounded-[10px] text-gray-700 hover:bg-red-400 dark:text-gray-200 dark:hover:bg-red-600">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
