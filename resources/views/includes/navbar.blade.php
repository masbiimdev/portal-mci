<nav class="bg-white shadow-sm sticky top-0 z-50" role="navigation" aria-label="Primary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left: Logo -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center gap-3">
                    <span
                        class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-gradient-to-br from-blue-600 to-blue-400 shadow-sm">
                        <img src="{{ asset('images/metinca-logo.jpeg') }}" alt="">
                    </span>
                    <span class="text-lg font-semibold text-sky-600 tracking-tight">Metinca Portal<span
                            class="text-sky-400">.</span></span>
                </a>
            </div>

            <!-- Center: Desktop Menu -->
            <div class="hidden md:flex md:items-center md:space-x-6" id="primary-menu">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-md transition-colors {{ request()->is('/') ? 'text-sky-600 bg-sky-50' : 'text-gray-700 hover:text-sky-600 hover:bg-sky-50' }}"
                    aria-current="{{ request()->is('/') ? 'page' : '' }}">Home</a>

                <a href="{{ url('/schedule') }}"
                    class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-md transition-colors {{ request()->is('schedule') ? 'text-sky-600 bg-sky-50' : 'text-gray-700 hover:text-sky-600 hover:bg-sky-50' }}">Jadwal</a>

                @php $isSUP = auth()->check() && auth()->user()->role === 'SUP'; @endphp

                <a href="{{ $isSUP ? url('/tracking') : url('/under-construction') }}"
                    class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-md transition-colors {{ request()->is('tracking') ? 'text-sky-600 bg-sky-50' : 'text-gray-700 hover:text-sky-600 hover:bg-sky-50' }}">Tracking</a>

                <a href="{{ $isSUP ? url('/portal/inventory') : url('/under-construction') }}"
                    class="inline-flex items-center px-2 py-1 text-sm font-medium rounded-md transition-colors {{ request()->is('inventory') ? 'text-sky-600 bg-sky-50' : 'text-gray-700 hover:text-sky-600 hover:bg-sky-50' }}">Inventory</a>
            </div>

            <!-- Right: Notif + User + Mobile -->
            <div class="flex items-center space-x-3">
                <!-- Notifications using <details> -->
                <details id="notifDetails" class="relative" role="group" aria-label="Notifications">
                    <summary
                        class="relative p-2 rounded-md text-gray-600 hover:text-sky-600 hover:bg-sky-50 focus:outline-none focus:ring-2 focus:ring-sky-200 cursor-pointer list-none"
                        aria-haspopup="true">
                        <svg class="h-5 w-5 inline-block" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0h6z" />
                        </svg>
                        @php $unread = session('unread_notifications', 2); @endphp
                        @if ($unread > 0)
                            <span
                                class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-semibold leading-none text-white bg-rose-500 rounded-full">{{ $unread > 99 ? '99+' : $unread }}</span>
                        @endif
                    </summary>

                    <div
                        class="absolute right-0 mt-2 w-72 bg-white border border-gray-100 rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 p-2">
                        <div class="py-2 px-3 text-sm text-gray-600 font-medium">Notifikasi</div>
                        <ul class="divide-y divide-gray-100 max-h-60 overflow-auto">
                            <li class="px-3 py-2">
                                <a href="#"
                                    class="flex items-start gap-3 text-sm text-gray-700 hover:bg-sky-50 rounded-md p-2">
                                    <span class="text-xl">📢</span>
                                    <div>
                                        <div class="font-medium text-gray-900">Maintenance server</div>
                                        <div class="text-xs text-gray-500">Hari ini, 22:00</div>
                                    </div>
                                </a>
                            </li>
                            <li class="px-3 py-2">
                                <a href="#"
                                    class="flex items-start gap-3 text-sm text-gray-700 hover:bg-sky-50 rounded-md p-2">
                                    <span class="text-xl">⚠️</span>
                                    <div>
                                        <div class="font-medium text-gray-900">Deadline tender</div>
                                        <div class="text-xs text-gray-500">Minggu ini</div>
                                    </div>
                                </a>
                            </li>
                            <li class="px-3 py-2">
                                <a href="{{ url('/notifications') }}"
                                    class="block text-center text-sm text-sky-600 hover:underline">Lihat semua</a>
                            </li>
                        </ul>
                    </div>
                </details>

                <!-- User Menu using <details> -->
                <details id="userDetails" class="relative" role="group" aria-label="User menu">
                    @auth
                        <summary
                            class="flex items-center gap-2 px-2 py-1 rounded-md text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-200 cursor-pointer list-none">
                            <span
                                class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-sm font-medium text-gray-700">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                <path d="M6 8l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </summary>

                        <div
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50 p-1">
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50">Logout</button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <summary
                            class="inline-flex items-center gap-2 px-2 py-1 rounded-md text-sm text-gray-700 hover:bg-sky-50 hover:text-sky-600 focus:outline-none focus:ring-2 focus:ring-sky-200 cursor-pointer list-none">
                            <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path
                                    d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4s-3 1.567-3 3.5S10.343 11 12 11zM4 20a8 8 0 0116 0"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <a href="{{ route('login') }}"
                                class="block px-2 py-2 rounded-md text-sm text-gray-700 hover:bg-sky-50">Login</a>
                        </summary>
                    @endguest
                </details>

                <!-- Mobile Hamburger -->
                <div class="md:hidden">
                    <button id="hamburger" type="button" aria-controls="mobileMenu" aria-expanded="false"
                        class="p-2 rounded-md text-gray-600 hover:text-sky-600 hover:bg-sky-50 focus:outline-none focus:ring-2 focus:ring-sky-200">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="1.6"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (collapsible) -->
    <div id="mobileMenu" class="hidden md:hidden px-4 pb-4 space-y-2 border-t border-gray-100 bg-white z-40"
        role="menu" aria-label="Mobile primary">
        <a href="{{ url('/') }}"
            class="block px-2 py-2 rounded-md text-sm font-medium {{ request()->is('/') ? 'text-sky-600 bg-sky-50' : 'text-gray-700 hover:text-sky-600 hover:bg-sky-50' }}">Home</a>
        <a href="{{ url('/schedule') }}"
            class="block px-2 py-2 rounded-md text-sm font-medium {{ request()->is('schedule') ? 'text-sky-600 bg-sky-50' : 'text-gray-700 hover:text-sky-600 hover:bg-sky-50' }}">Jadwal</a>
        <a href="{{ $isSUP ? url('/tracking') : url('/under-construction') }}"
            class="block px-2 py-2 rounded-md text-sm font-medium {{ request()->is('tracking') ? 'text-sky-600 bg-sky-50' : 'text-gray-700 hover:text-sky-600 hover:bg-sky-50' }}">Tracking</a>
        <a href="{{ $isSUP ? url('/portal/inventory') : url('/under-construction') }}"
            class="block px-2 py-2 rounded-md text-sm font-medium {{ request()->is('inventory') ? 'text-sky-600 bg-sky-50' : 'text-gray-700 hover:text-sky-600 hover:bg-sky-50' }}">Inventory</a>

        <div class="pt-2 border-t border-gray-100">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="block px-2 py-2 rounded-md text-sm text-gray-700 hover:bg-sky-50">Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" class="mt-1">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-2 py-2 rounded-md text-sm text-rose-600 hover:bg-rose-50">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="block px-2 py-2 rounded-md text-sm text-gray-700 hover:bg-sky-50">Login</a>
            @endauth
        </div>
    </div>

    <!-- Small inline script to support mobile toggle and outside click close for <details> -->
    <script>
        (function() {
            // Mobile hamburger toggle (kept simple)
            const hamburger = document.getElementById('hamburger');
            const mobileMenu = document.getElementById('mobileMenu');
            if (hamburger && mobileMenu) {
                hamburger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const hidden = mobileMenu.classList.contains('hidden');
                    if (hidden) {
                        mobileMenu.classList.remove('hidden');
                        hamburger.setAttribute('aria-expanded', 'true');
                        // focus first link
                        const f = mobileMenu.querySelector('a, button');
                        f && f.focus();
                    } else {
                        mobileMenu.classList.add('hidden');
                        hamburger.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            // Close open <details> when clicking outside
            document.addEventListener('click', function(e) {
                // close any open details except if click inside them
                document.querySelectorAll('details[open]').forEach(function(d) {
                    if (!d.contains(e.target)) d.removeAttribute('open');
                });
            });

            // keyboard: close details on Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('details[open]').forEach(function(d) {
                        d.removeAttribute('open');
                        // try focus summary
                        const s = d.querySelector('summary');
                        s && s.focus();
                    });
                    if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        hamburger && hamburger.setAttribute('aria-expanded', 'false');
                        hamburger && hamburger.focus();
                    }
                }
            });
        })();
    </script>
</nav>
