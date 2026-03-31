<nav class="sticky top-0 z-50 bg-white/70 backdrop-blur-xl border-b border-slate-200/60 shadow-[0_4px_30px_rgba(0,0,0,0.03)] transition-all duration-300"
    role="navigation" aria-label="Primary">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">

            <div class="flex items-center flex-shrink-0">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <span
                        class="relative inline-flex items-center justify-center w-11 h-11 rounded-xl bg-gradient-to-br from-blue-600 to-sky-400 shadow-lg shadow-sky-500/30 group-hover:shadow-sky-500/50 group-hover:-translate-y-0.5 transition-all duration-300 overflow-hidden">
                        <img src="{{ asset('images/metinca-logo.jpeg') }}" alt="Metinca Logo"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </span>
                    <span
                        class="text-2xl font-bold text-slate-800 tracking-tight group-hover:text-sky-600 transition-colors duration-300">
                        Metinca<span class="text-sky-500 font-extrabold text-3xl leading-none">.</span>
                    </span>
                </a>
            </div>

            <div class="hidden lg:flex lg:items-center lg:space-x-1" id="primary-menu">

                <a href="{{ url('/') }}"
                    class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-full transition-all duration-300 {{ request()->is('/') ? 'text-sky-700 bg-sky-50 shadow-sm ring-1 ring-sky-100' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50' }}"
                    aria-current="{{ request()->is('/') ? 'page' : '' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Home
                </a>

                @php
                    // Tambahkan pengecekan route ncr agar tab aktivitas menyala saat berada di NCR Log
                    $isAktivitasActive =
                        request()->is('activities*') ||
                        request()->is('witness*') ||
                        request()->is('kalibrasi*') ||
                        request()->is('portal/ncr*');
                @endphp

                <div class="relative group" id="aktivitasWrapper">
                    <button
                        class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-full transition-all duration-300 {{ $isAktivitasActive ? 'text-sky-700 bg-sky-50 shadow-sm ring-1 ring-sky-100' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50' }}"
                        aria-haspopup="true">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Aktivitas
                        <svg class="w-4 h-4 text-slate-400 group-hover:text-sky-500 group-hover:rotate-180 transition-transform duration-300"
                            viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div
                        class="absolute left-0 mt-4 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-4 group-hover:translate-y-0 transition-all duration-300 ease-out z-50 pt-2">
                        <div
                            class="bg-white/95 backdrop-blur-xl border border-slate-100 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] overflow-hidden p-2 relative">
                            <div
                                class="absolute -top-10 -right-10 w-20 h-20 bg-sky-100 rounded-full blur-2xl opacity-50 pointer-events-none">
                            </div>

                            <a href="{{ url('/schedule') }}"
                                class="group/item flex items-center gap-3 px-4 py-3 text-sm rounded-xl text-slate-700 hover:bg-sky-50 hover:text-sky-700 font-medium transition-all">
                                <span
                                    class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-500 group-hover/item:bg-white group-hover/item:text-sky-600 group-hover/item:shadow-sm transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                                Witness / Inspection
                            </a>
                            <a href="{{ url('/kalibrasi') }}"
                                class="group/item flex items-center gap-3 px-4 py-3 text-sm rounded-xl text-slate-700 hover:bg-sky-50 hover:text-sky-700 font-medium transition-all">
                                <span
                                    class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-500 group-hover/item:bg-white group-hover/item:text-sky-600 group-hover/item:shadow-sm transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </span>
                                Kalibrasi
                            </a>
                            {{-- MENU NCR LOG DIPINDAHKAN KE SINI --}}
                            <a href="{{ url('/portal/ncr') }}"
                                class="group/item flex items-center gap-3 px-4 py-3 text-sm rounded-xl text-slate-700 hover:bg-sky-50 hover:text-sky-700 font-medium transition-all">
                                <span
                                    class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-lg bg-slate-50 text-slate-500 group-hover/item:bg-white group-hover/item:text-sky-600 group-hover/item:shadow-sm transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </span>
                                NCR Log
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/portal/inventory') }}"
                    class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-full transition-all duration-300 {{ request()->is('portal/inventory*') ? 'text-sky-700 bg-sky-50 shadow-sm ring-1 ring-sky-100' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Inventory
                </a>

                <a href="{{ url('/portal/document') }}"
                    class="flex items-center gap-2 px-4 py-2.5 text-sm font-semibold rounded-full transition-all duration-300 {{ request()->is('portal/document*') ? 'text-sky-700 bg-sky-50 shadow-sm ring-1 ring-sky-100' : 'text-slate-600 hover:text-sky-600 hover:bg-slate-50' }}">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Document
                </a>
            </div>

            <div class="flex items-center gap-3 sm:gap-4 relative z-10">

                <div
                    class="hidden sm:flex items-center gap-2.5 px-3.5 py-1.5 rounded-full bg-slate-50/50 border border-slate-200/50 shadow-sm mr-1">
                    <div
                        class="flex items-center justify-center w-6 h-6 rounded-full bg-white shadow-sm border border-slate-100">
                        <svg class="w-3.5 h-3.5 text-sky-500 animate-[spin_60s_linear_infinite]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span id="navTime"
                            class="text-sm font-bold text-slate-700 leading-none font-mono tracking-tight">--:--:--</span>
                        <span id="navDate"
                            class="text-[9px] font-bold text-slate-400 uppercase tracking-widest leading-none mt-0.5">Memuat...</span>
                    </div>
                </div>

                <div class="relative group">
                    @auth
                        <button
                            class="flex items-center gap-2.5 p-1.5 pr-4 rounded-full border border-slate-200 bg-white hover:border-sky-300 hover:bg-sky-50 hover:shadow-md transition-all duration-300 focus:outline-none group/btn">
                            <span
                                class="h-9 w-9 rounded-full bg-gradient-to-tr from-sky-500 to-blue-600 flex items-center justify-center text-sm font-bold text-white shadow-inner group-hover/btn:scale-105 transition-transform">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="hidden md:block text-sm font-bold text-slate-700">{{ Auth::user()->name }}</span>
                            <svg class="hidden md:block h-4 w-4 text-slate-400 group-hover/btn:text-sky-500 transition-colors"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div
                            class="absolute right-0 mt-4 w-60 opacity-0 invisible group-hover:opacity-100 group-hover:visible translate-y-4 group-hover:translate-y-0 transition-all duration-300 ease-out z-50 pt-2">
                            <div
                                class="bg-white/95 backdrop-blur-xl border border-slate-100 rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] overflow-hidden p-2">
                                <div class="px-4 py-3 border-b border-gray-50 mb-2 bg-slate-50/50 rounded-xl">
                                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Signed
                                        in as</p>
                                    <p class="text-sm font-bold text-slate-800 truncate">
                                        {{ Auth::user()->email ?? 'Admin' }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}"
                                    class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-slate-700 rounded-xl hover:bg-sky-50 hover:text-sky-600 transition-all">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    Dashboard
                                </a>
                                <form action="{{ route('logout') }}" method="POST"
                                    class="m-0 mt-1 border-t border-slate-50 pt-1">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-red-600 rounded-xl hover:bg-red-50 transition-all">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}"
                            class="flex items-center gap-2 px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-500 hover:to-blue-500 rounded-full shadow-lg shadow-sky-500/30 hover:shadow-sky-500/50 hover:-translate-y-0.5 transition-all duration-300">
                            Login
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    @endguest
                </div>

                <div class="lg:hidden flex items-center ml-1">
                    <button id="hamburger"
                        class="p-2.5 text-slate-500 hover:text-sky-600 hover:bg-sky-50 rounded-xl transition-all focus:outline-none focus:ring-2 focus:ring-sky-500/50">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div id="mobileMenu"
        class="lg:hidden overflow-hidden transition-all duration-300 ease-in-out max-h-0 bg-white border-t border-slate-100 shadow-xl absolute w-full left-0 origin-top z-40">

        <div class="sm:hidden px-6 py-3 bg-slate-50/50 border-b border-slate-100 flex items-center gap-3">
            <svg class="w-5 h-5 text-sky-500 animate-[spin_60s_linear_infinite]" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="flex flex-col">
                <span id="navTimeMobile" class="text-sm font-bold text-slate-700 font-mono">--:--:--</span>
                <span id="navDateMobile"
                    class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Memuat...</span>
            </div>
        </div>

        <div class="px-4 py-5 space-y-2 bg-slate-50/30">
            <a href="{{ url('/') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold text-base transition-all {{ request()->is('/') ? 'text-sky-700 bg-white shadow-sm ring-1 ring-slate-200/50' : 'text-slate-600 hover:bg-white hover:text-sky-600' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Home
            </a>

            <div class="bg-white rounded-xl shadow-sm ring-1 ring-slate-200/50 overflow-hidden">
                <button id="mobileAktToggle"
                    class="w-full flex justify-between items-center px-4 py-3.5 font-bold text-base text-slate-600 hover:bg-sky-50 hover:text-sky-700 transition-colors">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Aktivitas
                    </div>
                    <svg id="mobileAktIcon" class="w-5 h-5 text-slate-400 transition-transform duration-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div id="mobileAktList"
                    class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-slate-50/50">
                    <div class="p-3 space-y-1">
                        <a href="{{ url('/activities/witness') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-sky-100 hover:text-sky-700 transition-colors">
                            <span class="w-2 h-2 rounded-full bg-sky-400"></span> Witness / Inspection
                        </a>
                        <a href="{{ url('/activities/kalibrasi') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-sky-100 hover:text-sky-700 transition-colors">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span> Kalibrasi
                        </a>
                        {{-- MENU NCR LOG DIPINDAHKAN KE SINI UNTUK MOBILE --}}
                        <a href="{{ url('/portal/ncr') }}"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-semibold text-slate-600 hover:bg-sky-100 hover:text-sky-700 transition-colors">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span> NCR Log
                        </a>
                    </div>
                </div>
            </div>

            <a href="{{ url('/portal/inventory') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold text-base transition-all {{ request()->is('portal/inventory*') ? 'text-sky-700 bg-white shadow-sm ring-1 ring-slate-200/50' : 'text-slate-600 hover:bg-white hover:text-sky-600' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Inventory
            </a>

            <a href="{{ url('/portal/document') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-xl font-bold text-base transition-all {{ request()->is('portal/document*') ? 'text-sky-700 bg-white shadow-sm ring-1 ring-slate-200/50' : 'text-slate-600 hover:bg-white hover:text-sky-600' }}">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Document
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === 1. REAL-TIME CLOCK LOGIC ===
            const navTime = document.getElementById('navTime');
            const navDate = document.getElementById('navDate');
            const navTimeMobile = document.getElementById('navTimeMobile');
            const navDateMobile = document.getElementById('navDateMobile');

            function updateClock() {
                const now = new Date();

                const timeString = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                });

                const dateString = now.toLocaleDateString('id-ID', {
                    day: '2-digit',
                    month: 'short',
                    year: 'numeric'
                }).replace('.', '');

                if (navTime) navTime.textContent = timeString;
                if (navDate) navDate.textContent = dateString;
                if (navTimeMobile) navTimeMobile.textContent = timeString;
                if (navDateMobile) navDateMobile.textContent = dateString;
            }

            setInterval(updateClock, 1000);
            updateClock();

            // === 2. MOBILE MENU & ACCORDION LOGIC ===
            const hamburger = document.getElementById('hamburger');
            const mobileMenu = document.getElementById('mobileMenu');
            let isMenuOpen = false;

            hamburger.addEventListener('click', () => {
                isMenuOpen = !isMenuOpen;
                if (isMenuOpen) {
                    mobileMenu.style.maxHeight = mobileMenu.scrollHeight + "px";
                } else {
                    mobileMenu.style.maxHeight = "0px";
                    if (isSubOpen) mToggle.click();
                }
            });

            const mToggle = document.getElementById('mobileAktToggle');
            const mList = document.getElementById('mobileAktList');
            const mIcon = document.getElementById('mobileAktIcon');
            let isSubOpen = false;

            mToggle.addEventListener('click', () => {
                isSubOpen = !isSubOpen;
                mIcon.classList.toggle('-rotate-180');
                if (isSubOpen) {
                    mList.style.maxHeight = mList.scrollHeight + "px";
                    if (isMenuOpen) {
                        mobileMenu.style.maxHeight = (mobileMenu.scrollHeight + mList.scrollHeight) + "px";
                    }
                } else {
                    mList.style.maxHeight = "0px";
                    if (isMenuOpen) {
                        mobileMenu.style.maxHeight = (mobileMenu.scrollHeight - mList.scrollHeight) + "px";
                    }
                }
            });
        });
    </script>
</nav>
