<!-- Navbar -->
<nav class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left: Logo -->
            <div class="flex items-center">
                <a href="/" class="text-xl font-bold text-blue-600">Metinca Portal .</a>
            </div>
            <!-- Center: Menu -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="/"
                    class="block text-gray-700 hover:text-blue-600 {{ request()->is('/') ? 'active-page' : '' }}">Home</a>
                <a href="/schedule"
                    class="block text-gray-700 hover:text-blue-600 {{ request()->is('schedule') ? 'active-page' : '' }}">Jadwal</a>
                <a href="/tracking"
                    class="block text-gray-700 hover:text-blue-600 {{ request()->is('tracking') ? 'active-page' : '' }}">Tracking</a>
            </div>
            <!-- Right: Notif + User -->
            <div class="flex items-center space-x-4">
                <!-- Notifikasi -->
                <div class="relative">
                    <button id="notifBtn" class="p-2 text-gray-500 hover:text-blue-600">
                        <i data-feather="bell"></i>
                    </button>
                    <div id="notifMenu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg p-4">
                        <ul class="mt-2 text-sm text-gray-600 space-y-2">
                            <li><a href="#" class="hover:text-blue-600">📢 Maintenance server jam 22:00</a></li>
                            <li><a href="#" class="hover:text-blue-600">⚠️ Deadline tender minggu ini</a></li>
                        </ul>
                    </div>
                </div>
                <!-- User Menu -->
                <div class="relative">
                    @auth
                        <!-- Jika user sudah login -->
                        <button id="userBtn" class="flex items-center space-x-2 p-2 text-gray-500 hover:text-blue-600">
                            <i data-feather="user"></i>
                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                        </button>
                    @endauth

                    @guest
                        <!-- Jika user belum login -->
                        <a href="{{ route('login') }}"
                            class="flex items-center space-x-2 p-2 text-gray-500 hover:text-blue-600">
                            <i data-feather="log-in"></i>
                            <span class="hidden sm:inline">Login</span>
                        </a>
                    @endguest

                    <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg p-2">
                        <a href="{{ route('dashboard') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
                <!-- Hamburger -->
                <button id="hamburger" class="md:hidden p-2 text-gray-600 hover:text-blue-600 focus:outline-none">
                    <i data-feather="menu"></i>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2 bg-white shadow">
        <a href="/"
            class="block text-gray-700 hover:text-blue-600 {{ request()->is('/') ? 'active-page' : '' }}">Home</a>
        <a href="/schedule"
            class="block text-gray-700 hover:text-blue-600 {{ request()->is('schedule') ? 'active-page' : '' }}">Jadwal</a>
        <a href="/tracking"
            class="block text-gray-700 hover:text-blue-600 {{ request()->is('tracking') ? 'active-page' : '' }}">Tracking</a>
    </div>
</nav>
