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
        animation: spin-very-slow 60s linear infinite;
    }

    /* Pattern Blueprint Tipis */
    .bg-blueprint {
        background-image: linear-gradient(rgba(71, 85, 105, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(71, 85, 105, 0.04) 1px, transparent 1px);
        background-size: 24px 24px;
    }
</style>
<footer
    class="bg-gradient-to-b from-white to-slate-50 border-t border-slate-200 mt-auto shadow-[0_-4px_10px_-1px_rgba(0,0,0,0.03)] relative overflow-hidden bg-blueprint">

    <div class="absolute top-0 left-0 w-full h-1.5 bg-slate-200 overflow-hidden z-20">
        <div
            class="h-full w-48 bg-gradient-to-r from-transparent via-blue-500 to-transparent animate-pipe-flow shadow-[0_0_8px_#3b82f6]">
        </div>
    </div>

    <div
        class="absolute -bottom-48 -right-24 w-[35rem] h-[35rem] text-slate-300 opacity-30 pointer-events-none z-0 animate-spin-valve">
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor">
            <circle cx="100" cy="100" r="85" stroke-width="12" />
            <circle cx="100" cy="100" r="96" stroke-width="2" stroke-dasharray="6 6" />
            <circle cx="100" cy="100" r="22" stroke-width="8" />
            <circle cx="100" cy="100" r="6" fill="currentColor" />
            <path
                d="M100 22 V78 M100 122 V178 M22 100 H78 M122 100 H178 M45 45 L80 80 M155 155 L120 120 M45 155 L80 120 M155 45 L120 80"
                stroke-width="10" stroke-linecap="round" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-8">

            <div class="md:col-span-5 lg:col-span-4">
                <div class="flex items-center gap-3 mb-5">
                    <div
                        class="w-12 h-12 bg-white rounded-xl shadow-md border border-slate-100 flex items-center justify-center overflow-hidden flex-shrink-0 relative">
                        <span
                            class="absolute top-1 right-1 w-2 h-2 rounded-full bg-green-500 animate-pulse border border-white"></span>
                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}"
                            alt="Logo PT Metinca" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <span class="block text-md font-extrabold text-slate-800 tracking-tight leading-none">PT
                            Metinca Prima Industrial Works</span>
                        <span class="block text-sm font-bold text-blue-600 mt-1 tracking-widest uppercase">Metinca Portal</span>
                    </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed mb-6 pe-4 font-medium">
                    Sistem manajemen kalibrasi dan inventaris terpadu. Memastikan setiap instrumen dan <span
                        class="font-bold text-slate-700">industrial valve</span> operasional Anda selalu berada dalam
                    presisi tingkat tinggi.
                </p>
            </div>

            <div class="md:col-span-3 lg:col-span-3">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest mb-5 flex items-center gap-2">
                    <i data-feather="target" class="w-3.5 h-3.5 text-blue-600"></i> Navigasi
                </h3>
                <ul class="space-y-3.5">
                    <li>
                        <a href="/schedule"
                            class="group flex items-center gap-3 text-slate-500 hover:text-blue-700 text-sm font-semibold transition-all">
                            <span
                                class="bg-white border border-slate-200 group-hover:border-blue-300 group-hover:bg-blue-50 p-1.5 rounded-lg transition-colors shadow-sm">
                                <i data-feather="calendar"
                                    class="w-3.5 h-3.5 text-slate-500 group-hover:text-blue-600"></i>
                            </span>
                            Jadwal Kalibrasi
                        </a>
                    </li>
                    <li>
                        <a href="/portal/inventory"
                            class="group flex items-center gap-3 text-slate-500 hover:text-blue-700 text-sm font-semibold transition-all">
                            <span
                                class="bg-white border border-slate-200 group-hover:border-blue-300 group-hover:bg-blue-50 p-1.5 rounded-lg transition-colors shadow-sm">
                                <i data-feather="tool" class="w-3.5 h-3.5 text-slate-500 group-hover:text-blue-600"></i>
                            </span>
                            Inventory Control
                        </a>
                    </li>
                    <li>
                        <a href="/portal/document"
                            class="group flex items-center gap-3 text-slate-500 hover:text-blue-700 text-sm font-semibold transition-all">
                            <span
                                class="bg-white border border-slate-200 group-hover:border-blue-300 group-hover:bg-blue-50 p-1.5 rounded-lg transition-colors shadow-sm">
                                <i data-feather="file-text"
                                    class="w-3.5 h-3.5 text-slate-500 group-hover:text-blue-600"></i>
                            </span>
                            Pusat Dokumen
                        </a>
                    </li>
                </ul>
            </div>

            <div class="md:col-span-4 lg:col-span-5">
                <h3 class="text-xs font-bold text-slate-800 uppercase tracking-widest mb-5 flex items-center gap-2">
                    <i data-feather="radio" class="w-3.5 h-3.5 text-blue-600"></i> Office Information
                </h3>
                <ul class="space-y-4">
                    <li
                        class="flex items-start gap-3 bg-white p-3 rounded-xl border border-slate-200 shadow-sm hover:border-blue-300 transition-colors">
                        <div class="mt-0.5 bg-blue-50 p-1.5 rounded-md flex-shrink-0">
                            <i data-feather="map-pin" class="w-4 h-4 text-blue-600"></i>
                        </div>
                        <div class="text-sm text-slate-600 leading-relaxed font-medium">
                            <span class="font-bold text-slate-800 block mb-0.5">Office - Bekasi</span>
                            Jl. Setia Darma No.35, Setiadarma,<br>
                            South Tambun, Bekasi,<br>
                            West Java 17510
                        </div>
                    </li>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                        <div class="space-y-3">
                            <li class="flex items-center gap-3">
                                <div class="bg-white border border-slate-200 p-1.5 rounded-lg flex-shrink-0 shadow-sm">
                                    <i data-feather="phone" class="w-3.5 h-3.5 text-blue-600"></i>
                                </div>
                                <span class="text-sm text-slate-600 font-bold">+62 21 88368880</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="bg-white border border-slate-200 p-1.5 rounded-lg flex-shrink-0 shadow-sm">
                                    <i data-feather="printer" class="w-3.5 h-3.5 text-blue-600"></i>
                                </div>
                                <span class="text-sm text-slate-600 font-bold">+62 21 88368881</span>
                            </li>
                        </div>

                        <div class="space-y-3">
                            <li class="flex items-center gap-3">
                                <div class="bg-white border border-slate-200 p-1.5 rounded-lg flex-shrink-0 shadow-sm">
                                    <i data-feather="mail" class="w-3.5 h-3.5 text-blue-600"></i>
                                </div>
                                <a href="mailto:info@metinca-prima.co.id"
                                    class="text-sm text-slate-600 font-bold hover:text-blue-700 transition-colors truncate">info@metinca-prima.co.id</a>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="bg-white border border-slate-200 p-1.5 rounded-lg flex-shrink-0 shadow-sm">
                                    <i data-feather="message-circle" class="w-3.5 h-3.5 text-blue-600"></i>
                                </div>
                                <a href="mailto:syaugy.awad@metica-prima.co.id"
                                    class="text-sm text-slate-600 font-bold hover:text-blue-700 transition-colors truncate"
                                    title="syaugy.awad@metica-prima.co.id">syaugy.awad@metica...</a>
                            </li>
                        </div>
                    </div>
                </ul>
            </div>
        </div>

        <div
            class="border-t border-slate-200/80 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center gap-4 relative z-10">
            <p class="text-xs text-slate-500 font-bold">
                &copy; {{ date('Y') }} PT Metinca Prima. All rights reserved.
            </p>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-3 py-1 bg-white border border-slate-200 rounded-full shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    <span class="text-[10px] font-extrabold text-slate-600 tracking-wider uppercase">System Active
                        v2.0.1</span>
                </div>
            </div>
        </div>
    </div>
</footer>
