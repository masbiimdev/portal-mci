<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300"
    role="navigation" aria-label="Primary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <div class="flex items-center flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-sky-400 shadow-md group-hover:shadow-lg transition-all duration-300 overflow-hidden">
                        <img src="{{ asset('images/metinca-logo.jpeg') }}" alt="Metinca Logo"
                            class="w-full h-full object-cover">
                    </span>
                    <span class="text-xl font-bold text-slate-800 tracking-tight">Metinca<span
                            class="text-sky-500 font-extrabold">.</span></span>
                </a>
            </div>

            <div class="hidden md:flex md:items-center md:space-x-2" id="primary-menu">
                <a href="{{ url('/') }}"
                    class="px-4 py-2 text-sm font-semibold rounded-full transition-all duration-200 {{ request()->is('/') ? 'text-sky-700 bg-sky-50' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50' }}"
                    aria-current="{{ request()->is('/') ? 'page' : '' }}">Home</a>

                @php
                    $isAktivitasActive =
                        request()->is('activities*') || request()->is('witness*') || request()->is('kalibrasi*');
                @endphp

                <div class="relative group" id="aktivitasWrapper">
                    <button
                        class="flex items-center gap-1 px-4 py-2 text-sm font-semibold rounded-full transition-all duration-200 {{ $isAktivitasActive ? 'text-sky-700 bg-sky-50' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50' }}"
                        aria-haspopup="true">
                        Aktivitas
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-sky-500 transition-transform duration-200"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div
                        class="absolute left-0 mt-2 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-2 group-hover:translate-y-0 transition-all duration-200 ease-out bg-white border border-gray-100 rounded-xl shadow-xl z-50 p-2">
                        <a href="{{ url('/schedule') }}"
                            class="block px-4 py-2.5 text-sm rounded-lg text-slate-700 hover:bg-sky-50 hover:text-sky-700 font-medium transition-colors">
                            Witness / Inspection
                        </a>
                        <a href="{{ url('/kalibrasi') }}"
                            class="block px-4 py-2.5 text-sm rounded-lg text-slate-700 hover:bg-sky-50 hover:text-sky-700 font-medium transition-colors">
                            Kalibrasi
                        </a>
                    </div>
                </div>

                <a href="{{ url('/portal/inventory') }}"
                    class="px-4 py-2 text-sm font-semibold rounded-full transition-all duration-200 {{ request()->is('portal/inventory*') ? 'text-sky-700 bg-sky-50' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50' }}">
                    Inventory
                </a>

                <a href="{{ url('/portal/document') }}"
                    class="px-4 py-2 text-sm font-semibold rounded-full transition-all duration-200 {{ request()->is('portal/document*') ? 'text-sky-700 bg-sky-50' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50' }}">
                    Document
                </a>
            </div>

            <div class="flex items-center gap-2 sm:gap-4">

                <div class="relative group">
                    <button
                        class="relative p-2 rounded-full text-slate-500 hover:text-sky-600 hover:bg-sky-50 focus:outline-none transition-colors"
                        aria-label="Notifications">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        @php $unread = session('unread_notifications', 5); @endphp
                        @if ($unread > 0)
                            <span
                                class="absolute top-1 right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 ring-2 ring-white text-[9px] font-bold text-white">
                                {{ $unread > 99 ? '99+' : $unread }}
                            </span>
                        @endif
                    </button>

                    <div
                        class="absolute right-0 mt-2 w-80 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-2 group-hover:translate-y-0 transition-all duration-200 ease-out bg-white border border-gray-100 rounded-2xl shadow-xl z-50 overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-50 flex justify-between items-center bg-slate-50/50">
                            <h4 class="text-sm font-bold text-slate-800">Notifikasi</h4>
                            <span class="text-xs font-semibold text-sky-600 cursor-pointer hover:underline">Tandai
                                dibaca</span>
                        </div>
                        <ul id="notifList" class="max-h-72 overflow-y-auto divide-y divide-gray-50">
                            <li class="px-5 py-8 text-sm text-slate-400 text-center flex flex-col items-center">
                                <svg class="w-8 h-8 mb-2 animate-spin text-sky-200" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Memuat...
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="relative group">
                    @auth
                        <button
                            class="flex items-center gap-2 p-1 pr-3 rounded-full border border-gray-100 hover:border-sky-200 hover:bg-sky-50 hover:shadow-sm transition-all focus:outline-none">
                            <span
                                class="h-8 w-8 rounded-full bg-gradient-to-tr from-sky-500 to-blue-600 flex items-center justify-center text-sm font-bold text-white shadow-inner">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span
                                class="hidden sm:block text-sm font-semibold text-slate-700">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4 text-slate-400 group-hover:text-sky-500" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div
                            class="absolute right-0 mt-2 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-2 group-hover:translate-y-0 transition-all duration-200 ease-out bg-white border border-gray-100 rounded-xl shadow-xl z-50 p-2">
                            <div class="px-4 py-3 border-b border-gray-50 mb-1">
                                <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Signed in as</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->email ?? 'Admin' }}
                                </p>
                            </div>
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-700 rounded-lg hover:bg-slate-50 hover:text-sky-600 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                Dashboard
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="m-0 mt-1">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-bold text-white bg-sky-600 hover:bg-sky-700 rounded-full shadow-md hover:shadow-lg transition-all">
                            Login
                        </a>
                    @endguest
                </div>

                <div class="md:hidden flex items-center">
                    <button id="hamburger"
                        class="p-2 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div id="mobileMenu"
        class="hidden md:hidden border-t border-gray-100 bg-white/95 backdrop-blur-md shadow-lg absolute w-full left-0 origin-top transform transition-all">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ url('/') }}"
                class="block px-4 py-3 rounded-xl font-semibold {{ request()->is('/') ? 'text-sky-700 bg-sky-50' : 'text-slate-600 hover:bg-slate-50' }}">Home</a>

            <div>
                <button id="mobileAktToggle"
                    class="w-full flex justify-between items-center px-4 py-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50">
                    Aktivitas
                    <svg id="mobileAktIcon" class="w-4 h-4 transition-transform duration-200" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="mobileAktList" class="hidden pl-6 pr-4 py-2 space-y-1 border-l-2 border-slate-100 ml-4">
                    <a href="{{ url('/activities/witness') }}"
                        class="block px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-sky-50 hover:text-sky-700">Witness
                        / Inspection</a>
                    <a href="{{ url('/activities/kalibrasi') }}"
                        class="block px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:bg-sky-50 hover:text-sky-700">Kalibrasi</a>
                </div>
            </div>

            <a href="{{ url('/portal/inventory') }}"
                class="block px-4 py-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50">Inventory</a>
            <a href="{{ url('/portal/document') }}"
                class="block px-4 py-3 rounded-xl font-semibold text-slate-600 hover:bg-slate-50">Document</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Toggle
            const hamburger = document.getElementById('hamburger');
            const mobileMenu = document.getElementById('mobileMenu');

            hamburger.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Mobile Submenu Toggle
            const mToggle = document.getElementById('mobileAktToggle');
            const mList = document.getElementById('mobileAktList');
            const mIcon = document.getElementById('mobileAktIcon');

            mToggle.addEventListener('click', () => {
                mList.classList.toggle('hidden');
                mIcon.classList.toggle('-rotate-180');
            });

            // Fetch Notifications Simulation
            const notifGroup = document.querySelector('.group[aria-label="Notifications"]');
            const notifList = document.getElementById('notifList');
            let isLoaded = false;

            notifGroup.addEventListener('mouseenter', async () => {
                if (isLoaded) return;
                try {
                    // Ganti dengan endpoint API real Anda
                    // const res = await fetch('/notifications');
                    // const data = await res.json();

                    // Simulasi delay fetch
                    setTimeout(() => {
                        const dummyData = [{
                                category: 'Sistem',
                                message: 'Kalibrasi alat Valve A berhasil',
                                time: '5 Menit lalu',
                                icon: '✅'
                            },
                            {
                                category: 'Peringatan',
                                message: 'Inventory Pipa C menipis',
                                time: '1 Jam lalu',
                                icon: '⚠️'
                            }
                        ];

                        notifList.innerHTML = dummyData.map(item => `
                            <li class="px-5 py-3 hover:bg-sky-50 cursor-pointer transition-colors group/item">
                                <div class="flex items-start gap-3">
                                    <div class="text-xl bg-white shadow-sm p-1.5 rounded-lg group-hover/item:scale-110 transition-transform">${item.icon}</div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-baseline mb-0.5">
                                            <span class="text-sm font-bold text-slate-800">${item.category}</span>
                                            <span class="text-[10px] font-semibold text-slate-400">${item.time}</span>
                                        </div>
                                        <p class="text-xs font-medium text-slate-600 leading-snug">${item.message}</p>
                                    </div>
                                </div>
                            </li>
                        `).join('');
                        isLoaded = true;
                    }, 800);
                } catch (e) {
                    notifList.innerHTML =
                        `<li class="px-5 py-4 text-sm text-red-500 font-medium text-center">Gagal memuat notifikasi</li>`;
                }
            });
        });
    </script>
</nav>
