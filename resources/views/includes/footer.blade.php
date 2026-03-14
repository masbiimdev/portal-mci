<style>
    /* Animasi Fluida Pipa */
    @keyframes pipe-flow {
        0% {
            transform: translateX(-100%);
        }

        100% {
            transform: translateX(100vw);
        }
    }

    .animate-pipe-flow {
        animation: pipe-flow 4s ease-in-out infinite;
    }

    /* Animasi Putaran Valve lambat */
    @keyframes spin-very-slow {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .animate-spin-valve {
        animation: spin-very-slow 90s linear infinite;
        /* Diperlambat agar tidak mendistraksi */
    }

    /* Pattern Blueprint Tipis */
    .bg-blueprint {
        background-color: #ffffff;
        background-image:
            linear-gradient(rgba(71, 85, 105, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(71, 85, 105, 0.03) 1px, transparent 1px);
        background-size: 24px 24px;
    }
</style>

<footer
    class="border-t border-slate-200 mt-auto shadow-[0_-4px_15px_-3px_rgba(0,0,0,0.02)] relative overflow-hidden bg-blueprint">

    <div class="absolute top-0 left-0 w-full h-1 bg-slate-100 overflow-hidden z-20">
        <div
            class="h-full w-64 bg-gradient-to-r from-transparent via-blue-500 to-transparent animate-pipe-flow shadow-[0_0_10px_#3b82f6]">
        </div>
    </div>

    <div
        class="absolute -bottom-48 -right-24 w-[40rem] h-[40rem] text-slate-300 opacity-20 pointer-events-none z-0 animate-spin-valve">
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor">
            <circle cx="100" cy="100" r="85" stroke-width="8" />
            <circle cx="100" cy="100" r="96" stroke-width="1.5" stroke-dasharray="6 6" />
            <circle cx="100" cy="100" r="22" stroke-width="6" />
            <circle cx="100" cy="100" r="6" fill="currentColor" />
            <path
                d="M100 22 V78 M100 122 V178 M22 100 H78 M122 100 H178 M45 45 L80 80 M155 155 L120 120 M45 155 L80 120 M155 45 L120 80"
                stroke-width="8" stroke-linecap="round" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 lg:gap-12">

            <div class="md:col-span-5 lg:col-span-4 flex flex-col">
                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-14 h-14 bg-white rounded-2xl shadow-sm border border-slate-200 flex items-center justify-center overflow-hidden flex-shrink-0 relative group">
                        <span
                            class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse border-2 border-white z-10"></span>
                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}"
                            alt="Logo PT Metinca"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-900 tracking-tight leading-tight">PT Metinca
                            Prima <br>Industrial Works</h2>
                        <span
                            class="inline-block mt-1 text-xs font-bold text-blue-600 tracking-widest uppercase bg-blue-50 px-2 py-0.5 rounded-md border border-blue-100">Metinca
                            Portal</span>
                    </div>
                </div>
                <p class="text-slate-600 text-sm leading-relaxed mb-6 font-medium pe-4">
                    Sistem manajemen kalibrasi dan inventaris terpadu. Memastikan setiap instrumen dan <span
                        class="font-bold text-slate-800">industrial valve</span> operasional Anda selalu berada dalam
                    presisi tingkat tinggi.
                </p>
            </div>

            <div class="md:col-span-3 lg:col-span-3">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i data-feather="target" class="w-4 h-4 text-blue-500"></i> Navigasi Sistem
                </h3>
                <ul class="space-y-4">
                    <li>
                        <a href="/schedule"
                            class="group flex items-center gap-3 text-slate-600 hover:text-blue-700 text-sm font-semibold transition-all hover:-translate-y-0.5">
                            <span
                                class="bg-white border border-slate-200 group-hover:border-blue-400 group-hover:bg-blue-50 p-2 rounded-lg transition-colors shadow-sm">
                                <i data-feather="calendar"
                                    class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors"></i>
                            </span>
                            Jadwal Kalibrasi
                        </a>
                    </li>
                    <li>
                        <a href="/portal/inventory"
                            class="group flex items-center gap-3 text-slate-600 hover:text-blue-700 text-sm font-semibold transition-all hover:-translate-y-0.5">
                            <span
                                class="bg-white border border-slate-200 group-hover:border-blue-400 group-hover:bg-blue-50 p-2 rounded-lg transition-colors shadow-sm">
                                <i data-feather="tool"
                                    class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors"></i>
                            </span>
                            Inventory Control
                        </a>
                    </li>
                    <li>
                        <a href="/portal/document"
                            class="group flex items-center gap-3 text-slate-600 hover:text-blue-700 text-sm font-semibold transition-all hover:-translate-y-0.5">
                            <span
                                class="bg-white border border-slate-200 group-hover:border-blue-400 group-hover:bg-blue-50 p-2 rounded-lg transition-colors shadow-sm">
                                <i data-feather="file-text"
                                    class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors"></i>
                            </span>
                            Pusat Dokumen
                        </a>
                    </li>
                </ul>
            </div>

            <div class="md:col-span-4 lg:col-span-5">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i data-feather="radio" class="w-4 h-4 text-blue-500"></i> Office Information
                </h3>

                <div class="space-y-4">
                    <div
                        class="flex items-start gap-3 bg-white/80 backdrop-blur-sm p-4 rounded-xl border border-slate-200 shadow-sm hover:border-blue-300 hover:shadow-md transition-all group">
                        <div
                            class="mt-0.5 bg-blue-50 p-2 rounded-lg flex-shrink-0 group-hover:bg-blue-100 transition-colors">
                            <i data-feather="map-pin" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        <div class="text-sm text-slate-600 leading-relaxed font-medium">
                            <span class="font-bold text-slate-900 block mb-1">Office - Bekasi</span>
                            Jl. Setia Darma No.35, Setiadarma,<br>
                            South Tambun, Bekasi,<br>
                            West Java 17510
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2">
                        <div class="flex items-center gap-3 group">
                            <div
                                class="bg-white border border-slate-200 p-2 rounded-lg flex-shrink-0 shadow-sm group-hover:border-blue-300 transition-colors">
                                <i data-feather="phone" class="w-4 h-4 text-slate-500 group-hover:text-blue-600"></i>
                            </div>
                            <span class="text-sm text-slate-700 font-bold">+62 21 88368880</span>
                        </div>

                        <div class="flex items-center gap-3 group">
                            <div
                                class="bg-white border border-slate-200 p-2 rounded-lg flex-shrink-0 shadow-sm group-hover:border-blue-300 transition-colors">
                                <i data-feather="printer" class="w-4 h-4 text-slate-500 group-hover:text-blue-600"></i>
                            </div>
                            <span class="text-sm text-slate-700 font-bold">+62 21 88368881</span>
                        </div>

                        <div class="flex items-center gap-3 group">
                            <div
                                class="bg-white border border-slate-200 p-2 rounded-lg flex-shrink-0 shadow-sm group-hover:border-blue-300 transition-colors">
                                <i data-feather="mail" class="w-4 h-4 text-slate-500 group-hover:text-blue-600"></i>
                            </div>
                            <a href="mailto:info@metinca-prima.co.id"
                                class="text-sm text-slate-700 font-bold hover:text-blue-700 transition-colors truncate">info@metinca-prima.co.id</a>
                        </div>

                        <div class="flex items-center gap-3 group">
                            <div
                                class="bg-white border border-slate-200 p-2 rounded-lg flex-shrink-0 shadow-sm group-hover:border-blue-300 transition-colors">
                                <i data-feather="message-circle"
                                    class="w-4 h-4 text-slate-500 group-hover:text-blue-600"></i>
                            </div>
                            <a href="mailto:syaugy.awad@metica-prima.co.id"
                                class="text-sm text-slate-700 font-bold hover:text-blue-700 transition-colors truncate"
                                title="syaugy.awad@metinca-prima.co.id">syaugy.awad@...</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="border-t border-slate-200/80 mt-12 pt-6 flex flex-col md:flex-row justify-between items-center gap-4 relative z-10">
            <p class="text-xs text-slate-500 font-semibold">
                &copy; {{ date('Y') }} <span class="font-bold text-slate-700">PT Metinca Prima Industrial Works</span>. All rights
                reserved.
            </p>
            <div class="flex items-center gap-3">
                <div
                    class="flex items-center gap-2 px-4 py-1.5 bg-white border border-slate-200 rounded-full shadow-sm hover:shadow transition-shadow cursor-default">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <span class="text-[10px] font-extrabold text-slate-700 tracking-wider uppercase">System Active
                        &bull; v2.0.1</span>
                </div>
            </div>
        </div>
    </div>
</footer>
