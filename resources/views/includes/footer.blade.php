<style>
    /* ============== ANIMASI INDUSTRIAL ============== */
    @keyframes pipe-flow {
        0% { transform: translateX(-100%); opacity: 0; }
        10% { opacity: 1; }
        90% { opacity: 1; }
        100% { transform: translateX(100vw); opacity: 0; }
    }

    .animate-pipe-flow {
        animation: pipe-flow 5s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    }

    /* Putaran Valve (Lebih Halus) */
    @keyframes spin-very-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .animate-spin-valve {
        animation: spin-very-slow 120s linear infinite;
        transform-origin: center;
    }

    /* ============== PREMIUM BLUEPRINT ============== */
    .bg-blueprint {
        background-color: #f8fafc; /* Lebih soft dari putih murni */
        background-image:
            linear-gradient(rgba(100, 116, 139, 0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(100, 116, 139, 0.04) 1px, transparent 1px);
        background-size: 32px 32px; /* Diperbesar sedikit agar tidak terlalu padat */
        position: relative;
    }

    /* Efek Vignette/Shadow di atas blueprint */
    .bg-blueprint::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at center, transparent 0%, rgba(248, 250, 252, 0.8) 100%);
        pointer-events: none;
        z-index: 0;
    }
</style>

<footer class="border-t border-slate-200 mt-auto shadow-[0_-10px_30px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden bg-blueprint">

    <div class="absolute top-0 left-0 w-full h-[3px] bg-slate-200 overflow-hidden z-20">
        <div class="h-full w-48 bg-gradient-to-r from-transparent via-blue-500 to-transparent animate-pipe-flow" 
             style="box-shadow: 0 0 12px 2px rgba(59, 130, 246, 0.6);">
        </div>
    </div>

    <div class="absolute -bottom-64 -right-32 w-[45rem] h-[45rem] text-slate-300 opacity-[0.07] pointer-events-none z-0 animate-spin-valve">
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor">
            <circle cx="100" cy="100" r="85" stroke-width="6" />
            <circle cx="100" cy="100" r="96" stroke-width="1.5" stroke-dasharray="4 6" />
            <circle cx="100" cy="100" r="22" stroke-width="4" />
            <circle cx="100" cy="100" r="8" fill="currentColor" />
            <path d="M100 22 V78 M100 122 V178 M22 100 H78 M122 100 H178 M45 45 L80 80 M155 155 L120 120 M45 155 L80 120 M155 45 L120 80" stroke-width="6" stroke-linecap="round" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 lg:py-16 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16">

            <div class="md:col-span-5 lg:col-span-4 flex flex-col">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 bg-white/80 backdrop-blur-md rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-center overflow-hidden flex-shrink-0 relative group cursor-pointer">
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse border-2 border-white z-10"></span>
                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('images/metinca-logo.jpeg'))) }}"
                            alt="Logo PT Metinca"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div>
                        <h2 class="text-lg font-extrabold text-slate-900 tracking-tight leading-tight">PT Metinca Prima <br><span class="text-slate-600 font-bold text-sm">Industrial Works</span></h2>
                        <span class="inline-block mt-1.5 text-[10px] font-extrabold text-blue-700 tracking-widest uppercase bg-blue-50/80 backdrop-blur-sm px-2.5 py-1 rounded-md border border-blue-200/50 shadow-sm">
                            Metinca Portal
                        </span>
                    </div>
                </div>
                <p class="text-slate-500 text-sm leading-relaxed mb-6 font-medium pe-4">
                    Sistem manajemen kalibrasi dan inventaris terpadu. Memastikan setiap instrumen dan <strong class="text-slate-800 font-bold">industrial valve</strong> operasional Anda selalu berada dalam presisi tingkat tinggi.
                </p>
            </div>

            <div class="md:col-span-3 lg:col-span-3">
                <h3 class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i data-feather="target" class="w-3.5 h-3.5 text-blue-500"></i> Navigasi Sistem
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="/schedule" class="group flex items-center gap-3 text-slate-600 hover:text-blue-600 text-sm font-semibold transition-all hover:translate-x-1">
                            <span class="bg-white/60 backdrop-blur-sm border border-slate-200 group-hover:border-blue-300 group-hover:bg-blue-50 w-8 h-8 flex items-center justify-center rounded-lg transition-all shadow-sm">
                                <i data-feather="calendar" class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors"></i>
                            </span>
                            Jadwal Kalibrasi
                        </a>
                    </li>
                    <li>
                        <a href="/portal/inventory" class="group flex items-center gap-3 text-slate-600 hover:text-blue-600 text-sm font-semibold transition-all hover:translate-x-1">
                            <span class="bg-white/60 backdrop-blur-sm border border-slate-200 group-hover:border-blue-300 group-hover:bg-blue-50 w-8 h-8 flex items-center justify-center rounded-lg transition-all shadow-sm">
                                <i data-feather="tool" class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors"></i>
                            </span>
                            Inventory Control
                        </a>
                    </li>
                    <li>
                        <a href="/portal/document" class="group flex items-center gap-3 text-slate-600 hover:text-blue-600 text-sm font-semibold transition-all hover:translate-x-1">
                            <span class="bg-white/60 backdrop-blur-sm border border-slate-200 group-hover:border-blue-300 group-hover:bg-blue-50 w-8 h-8 flex items-center justify-center rounded-lg transition-all shadow-sm">
                                <i data-feather="file-text" class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition-colors"></i>
                            </span>
                            Pusat Dokumen
                        </a>
                    </li>
                </ul>
            </div>

            <div class="md:col-span-4 lg:col-span-5">
                <h3 class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i data-feather="radio" class="w-3.5 h-3.5 text-blue-500"></i> Office Information
                </h3>

                <div class="space-y-3">
                    <div class="flex items-start gap-4 bg-white/50 backdrop-blur-md p-4 rounded-xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
                        <div class="mt-0.5 bg-white border border-slate-100 shadow-sm p-2 rounded-lg flex-shrink-0 group-hover:bg-blue-50 transition-colors">
                            <i data-feather="map-pin" class="w-4 h-4 text-blue-500"></i>
                        </div>
                        <div class="text-[13px] text-slate-500 leading-relaxed font-medium">
                            <span class="font-bold text-slate-800 block mb-1 text-sm tracking-tight">Office - Bekasi</span>
                            Jl. Setia Darma No.35, Setiadarma,<br>
                            South Tambun, Bekasi,<br>
                            West Java 17510
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                        <div class="flex items-center gap-3 bg-white/40 backdrop-blur-sm border border-slate-200/60 p-2.5 rounded-xl hover:bg-white transition-colors group cursor-pointer">
                            <div class="bg-white border border-slate-100 p-2 rounded-lg flex-shrink-0 shadow-sm group-hover:border-blue-200 transition-colors">
                                <i data-feather="phone" class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600"></i>
                            </div>
                            <span class="text-[13px] text-slate-700 font-bold tracking-tight">+62 21 88368880</span>
                        </div>

                        <div class="flex items-center gap-3 bg-white/40 backdrop-blur-sm border border-slate-200/60 p-2.5 rounded-xl hover:bg-white transition-colors group cursor-pointer">
                            <div class="bg-white border border-slate-100 p-2 rounded-lg flex-shrink-0 shadow-sm group-hover:border-blue-200 transition-colors">
                                <i data-feather="printer" class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600"></i>
                            </div>
                            <span class="text-[13px] text-slate-700 font-bold tracking-tight">+62 21 88368881</span>
                        </div>

                        <div class="flex items-center gap-3 bg-white/40 backdrop-blur-sm border border-slate-200/60 p-2.5 rounded-xl hover:bg-white transition-colors group cursor-pointer sm:col-span-2">
                            <div class="bg-white border border-slate-100 p-2 rounded-lg flex-shrink-0 shadow-sm group-hover:border-blue-200 transition-colors">
                                <i data-feather="mail" class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-600"></i>
                            </div>
                            <div class="flex flex-col">
                                <a href="mailto:info@metinca-prima.co.id" class="text-[13px] text-slate-700 font-bold hover:text-blue-600 transition-colors truncate">info@metinca-prima.co.id</a>
                                <a href="mailto:syaugy.awad@metinca-prima.co.id" class="text-[12px] text-slate-400 font-medium hover:text-slate-600 transition-colors truncate">syaugy.awad@metinca-prima.co.id</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200/60 mt-14 pt-6 flex flex-col md:flex-row justify-between items-center gap-4 relative z-10">
            <p class="text-[13px] text-slate-500 font-medium">
                &copy; {{ date('Y') }} <span class="font-bold text-slate-700">PT Metinca Prima Industrial Works</span>. All rights reserved.
            </p>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 px-3 py-1.5 bg-white/80 backdrop-blur-sm border border-slate-200 rounded-full shadow-sm cursor-default">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-extrabold text-slate-600 tracking-widest uppercase">System Active &bull; v2.0.1</span>
                </div>
            </div>
        </div>
    </div>
</footer>