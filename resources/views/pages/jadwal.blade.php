@extends('layouts.home')
@section('title', 'MCI | Ultra Premium Schedule Dashboard')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

    <style>
        /* ========== ULTRA PREMIUM BENTO SYSTEM 3.0 ========== */
        :root {
            --primary: #4F46E5;
            --primary-dark: #3730a3;
            --accent: #06b6d4;
            --bg-base: #F8FAFC;

            /* Glassmorphism Variables */
            --card-glass: rgba(255, 255, 255, 0.85);
            --card-glass-dark: rgba(15, 23, 42, 0.9);
            --card-border: rgba(255, 255, 255, 0.9);
            --card-border-dark: rgba(255, 255, 255, 0.1);

            --radius-bento: 2.25rem;
            --radius-md: 1.5rem;

            /* Premium Shadows & Glows */
            --inner-glow: inset 0 1px 1px 0 rgba(255, 255, 255, 1), inset 0 -1px 1px 0 rgba(0, 0, 0, 0.02);
            --shadow-bento: 0 20px 40px -15px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(0, 0, 0, 0.02);
            --shadow-hover: 0 30px 60px -20px rgba(79, 70, 229, 0.2), 0 0 0 1px rgba(79, 70, 229, 0.1);

            --transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-base);
            color: #0f172a;
            overflow-x: hidden;
            background-image: radial-gradient(rgba(203, 213, 225, 0.8) 1px, transparent 1px);
            background-size: 32px 32px;
            -webkit-font-smoothing: antialiased;
        }

        /* Ambient Animated Background (GPU Optimized) */
        .ambient-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }

        .ambient-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            will-change: transform;
            animation: breathe 10s infinite alternate ease-in-out;
        }

        .blob-1 {
            top: -10%;
            left: -5%;
            width: 45vw;
            height: 45vw;
            background: radial-gradient(circle, rgba(79, 70, 229, 0.25) 0%, transparent 70%);
        }

        .blob-2 {
            bottom: -10%;
            right: -5%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.2) 0%, transparent 70%);
            animation-delay: -5s;
        }

        @keyframes breathe {
            0% {
                transform: scale(1) translate(0, 0);
            }

            100% {
                transform: scale(1.1) translate(30px, -30px);
            }
        }

        /* Glassmorphism Bento Card (GPU Optimized) */
        .bento-card {
            background: var(--card-glass);
            backdrop-filter: blur(28px);
            -webkit-backdrop-filter: blur(28px);
            border-radius: var(--radius-bento);
            padding: 2rem;
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-bento), var(--inner-glow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            will-change: transform, box-shadow, border-color;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .bento-card:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: var(--shadow-hover), var(--inner-glow);
            border-color: rgba(255, 255, 255, 1);
            z-index: 10;
        }

        .bento-card.dark-card {
            background: var(--card-glass-dark);
            border-color: var(--card-border-dark);
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .bento-card.dark-card:hover {
            box-shadow: 0 30px 60px -20px rgba(15, 23, 42, 0.8), inset 0 1px 0 rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Staggered Animations */
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-1 {
            animation-delay: 0.05s;
        }

        .delay-2 {
            animation-delay: 0.15s;
        }

        .delay-3 {
            animation-delay: 0.25s;
        }

        .delay-4 {
            animation-delay: 0.35s;
        }

        /* FullCalendar Ultimate Polish */
        .fc {
            font-family: inherit;
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border: 1px solid rgba(226, 232, 240, 0.5) !important;
        }

        .fc .fc-toolbar {
            margin-bottom: 2.5rem !important;
        }

        .fc .fc-toolbar-title {
            font-weight: 900 !important;
            font-size: clamp(1.25rem, 2vw, 1.75rem) !important;
            letter-spacing: -0.03em;
            color: #0f172a;
        }

        .fc .fc-button-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark)) !important;
            border: none !important;
            border-radius: 12px !important;
            padding: 10px 20px !important;
            font-weight: 800 !important;
            font-size: 0.75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 6px 12px -2px rgba(79, 70, 229, 0.4) !important;
            transition: var(--transition);
        }

        .fc .fc-button-primary:hover {
            transform: translateY(-2px);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.3), 0 10px 20px -4px rgba(79, 70, 229, 0.6) !important;
        }

        .fc .fc-button-primary:not(:disabled):active,
        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: var(--primary-dark) !important;
            transform: translateY(0);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2) !important;
        }

        .fc .fc-col-header-cell {
            padding: 18px 0;
            background: transparent;
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 900;
            color: #94a3b8;
            letter-spacing: 1.5px;
            border-bottom: 2px solid rgba(226, 232, 240, 0.8) !important;
        }

        .fc-daygrid-day-frame {
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        .fc-daygrid-day-frame:hover {
            background: rgba(79, 70, 229, 0.02);
        }

        .fc-day-today .fc-daygrid-day-frame {
            background: rgba(56, 189, 248, 0.04);
            box-shadow: inset 0 0 0 1px rgba(56, 189, 248, 0.2);
        }

        /* Custom Scrollbar for sleekness */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: rgba(203, 213, 225, 0.8);
            border-radius: 20px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        .custom-scroll::-webkit-scrollbar-thumb:hover {
            background-color: #94a3b8;
        }
    </style>
@endpush

@section('content')
    {{-- Animated Ambient Background --}}
    <div class="ambient-bg">
        <div class="ambient-blob blob-1"></div>
        <div class="ambient-blob blob-2"></div>
    </div>

    <div class="min-h-screen pb-12 relative z-10">
        <div class="max-w-[1550px] mx-auto p-4 sm:p-8 mt-2">

            {{-- PREMIUM HEADER --}}
            <header class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-5 opacity-0"
                style="animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
                <div>
                    <div
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/80 backdrop-blur-md border border-white text-[10px] font-black text-indigo-600 uppercase tracking-widest shadow-sm mb-4">
                        <span class="relative flex h-2.5 w-2.5">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-indigo-500"></span>
                        </span>
                        MCI Dashboard
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tighter"
                        style="text-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                        Smart Schedule
                    </h1>
                </div>
                <div class="flex items-center">
                    <div
                        class="px-5 py-3 rounded-2xl bg-white/80 backdrop-blur-md border border-white text-[11px] font-extrabold text-slate-500 uppercase tracking-widest flex items-center gap-3 shadow-sm hover:shadow-md transition-shadow cursor-default">
                        <i class="bx bx-check-shield text-emerald-500 text-xl"></i> Real-time Sync Active
                    </div>
                </div>
            </header>

            {{-- ALERTS --}}
            @if ($errors->any())
                <div
                    class="mb-6 p-4 rounded-2xl bg-rose-50/90 backdrop-blur-md border border-rose-200 text-rose-600 font-bold text-sm flex items-center gap-3 shadow-sm">
                    <i class="bx bx-error-circle text-xl"></i> Peringatan: Terdapat kesalahan dalam pengisian formulir!
                </div>
            @endif
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-2xl bg-emerald-50/90 backdrop-blur-md border border-emerald-200 text-emerald-600 font-bold text-sm flex items-center gap-3 shadow-sm">
                    <i class="bx bx-check-circle text-xl"></i> {{ session('success') }}
                </div>
            @endif

            {{-- BENTO GRID CONTAINER --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 xl:gap-8">

                {{-- MAIN PANEL: CALENDAR (SPAN 9) --}}
                <div class="lg:col-span-9 bento-card delay-1 order-2 lg:order-1 p-5 sm:p-8 lg:p-10">
                    <div id="calendar" class="min-h-[600px] lg:min-h-[700px]"></div>
                </div>

                {{-- SIDE PANEL: STATS & AGENDA (SPAN 3) --}}
                <div class="lg:col-span-3 flex flex-col gap-6 xl:gap-8 order-1 lg:order-2">

                    {{-- TILE 1: TODAY (Dark Aesthetic) --}}
                    <div class="bento-card dark-card delay-2">
                        <div class="relative z-10 flex flex-col h-full justify-between">
                            <div class="flex justify-between items-start mb-6">
                                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-indigo-300">Today's Load
                                </p>
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-500/20 flex items-center justify-center backdrop-blur-sm border border-indigo-400/30">
                                    <i class="bx bx-calendar-star text-xl text-indigo-300"></i>
                                </div>
                            </div>
                            <div>
                                <h2 class="text-7xl font-black tracking-tighter text-white">{{ $todayCount ?? 0 }}</h2>
                                <p class="text-[11px] font-bold text-indigo-200/70 mt-2 uppercase tracking-widest">Tasks
                                    Scheduled</p>
                            </div>
                        </div>
                        <div
                            class="absolute -right-12 -top-12 w-48 h-48 border-[40px] border-white/5 rounded-full blur-[4px] pointer-events-none">
                        </div>
                    </div>

                    {{-- TILE 2: THIS WEEK --}}
                    <div class="bento-card delay-3 flex items-center justify-between !p-6">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1">Weekly Goal</p>
                            <h2 class="text-4xl font-black text-slate-800 tracking-tighter">{{ $weekCount ?? 0 }}</h2>
                        </div>
                        <div
                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-100 to-emerald-50 text-emerald-600 flex items-center justify-center text-2xl border border-white shadow-sm">
                            <i class="bx bx-trending-up"></i>
                        </div>
                    </div>

                    {{-- TILE 3: NEXT AGENDA LIST --}}
                    <div class="bento-card delay-4 flex-1 flex flex-col !p-0 overflow-hidden">
                        <div class="p-6 pb-4 border-b border-slate-100 bg-white/50 backdrop-blur-sm relative z-10">
                            <h3
                                class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em] flex items-center justify-between">
                                Up Next <div
                                    class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-indigo-100 hover:text-indigo-600 transition-colors cursor-pointer">
                                    <i class='bx bx-right-arrow-alt'></i></div>
                            </h3>
                        </div>
                        <div
                            class="p-5 space-y-4 flex-1 overflow-y-auto custom-scroll max-h-[350px] lg:max-h-full bg-slate-50/30">
                            @forelse ($weekActivities as $activity)
                                <div
                                    class="group cursor-pointer bg-white/90 backdrop-blur-md p-4 rounded-[1.25rem] border border-white shadow-[0_4px_10px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_10px_20px_-5px_rgba(79,70,229,0.15)] hover:border-indigo-100 transition-all duration-300">
                                    <div class="flex gap-4 items-center">
                                        <div
                                            class="flex-shrink-0 w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center group-hover:border-indigo-200 group-hover:bg-indigo-50 transition-all duration-300">
                                            <span
                                                class="text-[9px] font-black text-slate-400 group-hover:text-indigo-500 uppercase tracking-widest leading-none">{{ \Carbon\Carbon::parse($activity->start_date)->format('M') }}</span>
                                            <span
                                                class="text-xl font-black text-slate-700 group-hover:text-indigo-700 mt-0.5">{{ \Carbon\Carbon::parse($activity->start_date)->format('d') }}</span>
                                        </div>
                                        <div class="min-w-0">
                                            <h4
                                                class="text-xs font-black text-slate-800 truncate uppercase tracking-tight group-hover:text-indigo-600 transition-colors">
                                                {{ $activity->kegiatan }}
                                            </h4>
                                            <p
                                                class="text-[10px] text-slate-500 font-bold truncate mt-1.5 tracking-wide flex items-center gap-1.5">
                                                <i class="bx bx-buildings text-slate-400"></i>
                                                {{ $activity->customer ? $activity->customer : 'Internal Project' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12 flex flex-col items-center justify-center opacity-70">
                                    <div
                                        class="w-16 h-16 rounded-full bg-white shadow-sm border border-slate-100 flex items-center justify-center mb-4 text-slate-300 text-3xl">
                                        <i class="bx bx-coffee"></i></div>
                                    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">Clear
                                        Schedule</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL AKTIVITAS (VIEW) --}}
    <div id="modal"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-xl hidden items-center justify-center z-50 p-4 sm:p-6 transition-all duration-500">
        <div id="modalContent"
            class="bg-white/95 backdrop-blur-3xl rounded-[2.5rem] sm:rounded-[3rem] w-full max-w-3xl overflow-hidden shadow-[0_40px_100px_-20px_rgba(0,0,0,0.6)] border border-white transform scale-95 opacity-0 transition-all duration-500 flex flex-col max-h-[95vh]">

            <div
                class="p-6 sm:p-10 pb-6 flex justify-between items-start border-b border-slate-100 bg-gradient-to-b from-slate-50/80 to-white">
                <div class="max-w-[85%]">
                    <div id="mStatusBadge"
                        class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 border shadow-sm bg-white">
                        <span class="w-2 h-2 rounded-full bg-current animate-pulse"></span>
                        <span id="mStatus"></span>
                    </div>
                    <h2 id="mTitle"
                        class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight uppercase tracking-tighter">
                    </h2>
                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 mt-4">
                        <div class="flex items-center gap-2 text-[11px] text-slate-500 font-bold uppercase tracking-widest">
                            <div
                                class="w-8 h-8 rounded-full bg-white shadow-sm border border-slate-100 flex items-center justify-center">
                                <i class="bx bx-buildings text-lg"></i></div> <span id="mCustomer"
                                class="truncate max-w-[150px] sm:max-w-none"></span>
                        </div>
                        <div class="flex items-center gap-2 text-[11px] text-slate-500 font-bold uppercase tracking-widest">
                            <div
                                class="w-8 h-8 rounded-full bg-white shadow-sm border border-slate-100 flex items-center justify-center">
                                <i class="bx bx-calendar text-lg"></i></div> <span id="mTime"></span>
                        </div>
                    </div>
                </div>
                <button id="closeModal"
                    class="w-12 h-12 rounded-full bg-white border border-slate-200 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all duration-300 text-slate-400 shadow-sm flex items-center justify-center flex-shrink-0">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>

            <div class="p-6 sm:p-10 py-6 overflow-y-auto custom-scroll flex-grow bg-slate-50/30">
                <div
                    class="flex flex-col md:flex-row items-center justify-between mb-10 p-6 sm:p-8 bg-white border border-white shadow-[0_4px_20px_-5px_rgba(0,0,0,0.05)] rounded-[2.5rem]">
                    <div class="mb-5 md:mb-0 text-center md:text-left">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Completion Status
                        </p>
                        <div class="flex items-baseline justify-center md:justify-start gap-2">
                            <span id="mPercentText"
                                class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-br from-indigo-600 to-cyan-500 tracking-tighter">0%</span>
                            <span
                                class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Inspected</span>
                        </div>
                    </div>
                    <div
                        class="w-full md:w-64 h-3 sm:h-4 bg-slate-100 rounded-full overflow-hidden shadow-inner p-0.5 border border-slate-200/50">
                        <div id="mProgressBar"
                            class="h-full bg-gradient-to-r from-indigo-500 to-cyan-400 rounded-full transition-all duration-1000 ease-out relative overflow-hidden"
                            style="width: 0%">
                            <div class="absolute inset-0 bg-white/20"
                                style="background-image: linear-gradient(45deg, rgba(255,255,255,0.2) 25%, transparent 25%, transparent 50%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0.2) 75%, transparent 75%, transparent); background-size: 1rem 1rem;">
                            </div>
                        </div>
                    </div>
                </div>

                <h4 class="text-[11px] font-black text-slate-800 uppercase tracking-[0.2em] mb-5 flex items-center gap-2">
                    <i class="bx bx-layer text-xl text-indigo-500"></i> Component Details</h4>
                <div id="mItems" class="space-y-4 pb-4"></div>
            </div>
        </div>
    </div>

    {{-- MODAL UPDATE HASIL INSPEKSI (EDIT) --}}
    <div id="resultModal"
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-lg hidden items-center justify-center z-[60] p-4 sm:p-6 transition-all duration-500">
        <div
            class="bg-white/95 backdrop-blur-2xl rounded-[2.5rem] sm:rounded-[3rem] w-full max-w-md p-8 sm:p-10 shadow-[0_40px_100px_-20px_rgba(0,0,0,0.6)] border border-white relative transform scale-95 opacity-0 transition-all duration-500">

            <div
                class="absolute top-8 right-8 w-12 h-12 bg-indigo-50 border border-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl shadow-sm">
                <i class="bx bx-edit-alt"></i></div>

            <h3 class="text-3xl font-black text-slate-900 mb-1 tracking-tighter">Update Log</h3>
            <p id="display_part_name" class="text-xs font-black text-indigo-500 mb-8 uppercase tracking-[0.2em]"></p>

            <form id="resultForm" method="POST" action="{{ route('jadwal.store') }}" class="space-y-5">
                @csrf
                <input type="hidden" name="result_id" id="result_id">
                <input type="hidden" name="activity_id" id="activity_id">
                <input type="hidden" name="part_name" id="part_name">

                <div class="space-y-5">
                    <div class="grid grid-cols-2 gap-4 sm:gap-5">
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest block mb-2">Inspector</label>
                            <input type="text" name="inspector_name" id="inspector_name" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-inner">
                        </div>
                        <div>
                            <label
                                class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest block mb-2">PIC
                                Metinca</label>
                            <input type="text" name="pic" id="pic" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-inner">
                        </div>
                    </div>
                    <div>
                        <label
                            class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest block mb-2">Status</label>
                        <div class="relative">
                            <select name="result" id="result"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-bold text-slate-800 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none appearance-none cursor-pointer transition-all shadow-inner">
                                <option value="OK">🟢 ACCEPTED (OK)</option>
                                <option value="PA">🔵 PARTIAL (PA)</option>
                                <option value="OH">🟠 ON HOLD (OH)</option>
                                <option value="NG">🔴 REJECTED (NG)</option>
                            </select>
                            <i
                                class="bx bx-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-xl text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label
                            class="text-[10px] font-black text-slate-500 uppercase ml-2 tracking-widest block mb-2">Notes /
                            Remarks</label>
                        <textarea name="remarks" id="remarks" rows="3" placeholder="Add descriptive notes..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 text-sm font-medium text-slate-700 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none resize-none transition-all shadow-inner"></textarea>
                    </div>
                </div>

                <div class="pt-6 flex gap-3 sm:gap-4">
                    <button type="button" id="closeResultModal"
                        class="flex-1 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-500 bg-white hover:bg-slate-50 transition-all border border-slate-200 shadow-sm hover:shadow">Cancel</button>
                    <button type="submit"
                        class="flex-[2] py-4 bg-gradient-to-r from-indigo-600 to-indigo-500 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest shadow-[0_10px_20px_-5px_rgba(79,70,229,0.4)] hover:shadow-[0_15px_25px_-5px_rgba(79,70,229,0.5)] hover:-translate-y-0.5 transition-all">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data Parsing PHP 7.4
            const resultsData = @json($resultsData ?? []);
            const userIsLoggedIn = {!! Auth::check() ? 'true' : 'false' !!};

            function getLatestResult(actId, partName) {
                if (!Array.isArray(resultsData)) return null;
                const matches = resultsData.filter(r => String(r.activity_id) === String(actId) && String(r
                    .part_name).trim().toLowerCase() === String(partName).trim().toLowerCase());
                if (matches.length === 0) return null;
                matches.sort((a, b) => b.id - a.id);
                return matches[0];
            }

            function parseItems(rawItems) {
                let parsed = rawItems;
                try {
                    if (typeof parsed === 'string') parsed = JSON.parse(parsed);
                    if (typeof parsed === 'string') parsed = JSON.parse(parsed);
                } catch (e) {}
                return Array.isArray(parsed) ? parsed : [];
            }

            // High Performance Modal Toggle
            function toggleModal(modalId, contentSelector, show = true) {
                const m = document.getElementById(modalId);
                const c = document.querySelector(contentSelector);
                if (show) {
                    m.classList.remove('hidden');
                    m.classList.add('flex');
                    // Force reflow
                    void m.offsetWidth;
                    c.classList.remove('scale-95', 'opacity-0');
                    c.classList.add('scale-100', 'opacity-100');
                } else {
                    c.classList.remove('scale-100', 'opacity-100');
                    c.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        m.classList.add('hidden');
                        m.classList.remove('flex');
                    }, 400); // Wait for transition
                }
            }

            $('#closeModal').click(() => toggleModal('modal', '#modalContent', false));
            $('#closeResultModal').click(() => toggleModal('resultModal', '#resultModal > div', false));
            @if ($errors->any())
                toggleModal('resultModal', '#resultModal > div', true);
            @endif

            // CALENDAR INIT
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 768 ? '' : 'dayGridMonth,listWeek'
                },
                height: 'auto',
                windowResize: function(arg) {
                    if (window.innerWidth < 768) {
                        calendar.changeView('listWeek');
                        calendar.setOption('headerToolbar', {
                            left: 'prev,next',
                            center: 'title',
                            right: 'today'
                        });
                    } else {
                        calendar.changeView('dayGridMonth');
                        calendar.setOption('headerToolbar', {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,listWeek'
                        });
                    }
                },
                events: [
                    @foreach ($activities as $activity)
                        @php
                            $start = \Carbon\Carbon::parse($activity->start_date);
                            $end = \Carbon\Carbon::parse($activity->end_date);
                            $statusColor = ['Done' => '#10B981', 'On Going' => '#F59E0B', 'Reschedule' => '#F43F5E', 'Pending' => '#64748B'][$activity->status] ?? '#4F46E5';
                        @endphp
                        @for ($d = $start->copy(); $d->lte($end); $d->addDay())
                            @if (!$d->isWeekend())
                                {
                                    id: '{{ $activity->id }}',
                                    title: '{{ $activity->kegiatan }}',
                                    start: '{{ $d->toDateString() }}',
                                    backgroundColor: '{{ $statusColor }}',
                                    extendedProps: {
                                        customer: '{{ addslashes($activity->customer ? $activity->customer : '-') }}',
                                        po: '{{ addslashes($activity->po ? $activity->po : '-') }}',
                                        status: '{{ $activity->status }}',
                                        items: {!! $activity->items ? $activity->items : '[]' !!}
                                    }
                                },
                            @endif
                        @endfor
                    @endforeach
                ],
                eventContent: function(arg) {
                    const p = arg.event.extendedProps;
                    const itemsArray = parseItems(p.items);
                    let okCount = 0;
                    itemsArray.forEach(item => {
                        const found = getLatestResult(arg.event.id, item.part_name);
                        if (found && found.result === 'OK') okCount++;
                    });

                    const pct = itemsArray.length > 0 ? Math.round((okCount / itemsArray.length) *
                        100) : 0;
                    let html =
                        `<div class="p-1.5 text-white w-full overflow-hidden flex flex-col justify-center">
                                    <div class="font-bold truncate text-[10px] uppercase tracking-wide mb-1.5 leading-tight text-shadow-sm">${arg.event.title}</div>`;
                    if (itemsArray.length > 0) {
                        html += `<div class="h-1.5 w-full bg-black/20 rounded-full overflow-hidden shadow-inner">
                                    <div class="h-full bg-white shadow-[0_0_8px_rgba(255,255,255,0.9)] rounded-full transition-all duration-500" style="width: ${pct}%"></div>
                                 </div>`;
                    }
                    html += `</div>`;
                    return {
                        html: html
                    };
                },
                eventClick: function(info) {
                    const p = info.event.extendedProps;
                    $('#mTitle').text(info.event.title);
                    $('#mCustomer').text(p.customer);
                    $('#mTime').text(info.event.start.toLocaleDateString('id-ID', {
                        dateStyle: 'long'
                    }));
                    $('#mStatus').text(p.status);

                    const statusClass = {
                        'Done': 'bg-emerald-50 text-emerald-600 border-emerald-200',
                        'On Going': 'bg-amber-50 text-amber-600 border-amber-200',
                        'Reschedule': 'bg-rose-50 text-rose-600 border-rose-200'
                    } [p.status] || 'bg-slate-50 text-slate-600 border-slate-200';

                    $('#mStatusBadge').removeClass().addClass(
                        `inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 border shadow-sm bg-white ${statusClass}`
                        );

                    const itemsContainer = $('#mItems').empty();
                    const itemsArray = parseItems(p.items);
                    let okCount = 0;

                    if (itemsArray.length > 0) {
                        itemsArray.forEach(item => {
                            const found = getLatestResult(info.event.id, item.part_name);
                            if (found && found.result === 'OK') okCount++;

                            const resConfig = {
                                'OK': {
                                    color: 'text-emerald-600 bg-emerald-100 border-emerald-200',
                                    label: 'OK'
                                },
                                'PA': {
                                    color: 'text-blue-600 bg-blue-100 border-blue-200',
                                    label: 'PA'
                                },
                                'NG': {
                                    color: 'text-rose-600 bg-rose-100 border-rose-200',
                                    label: 'NG'
                                },
                                'OH': {
                                    color: 'text-amber-600 bg-amber-100 border-amber-200',
                                    label: 'OH'
                                }
                            } [found?.result] || {
                                color: 'text-slate-500 bg-slate-100 border-slate-200',
                                label: 'WAIT'
                            };

                            itemsContainer.append(`
                                <div class="bg-white border border-slate-100 p-5 rounded-[1.75rem] flex flex-col sm:flex-row justify-between items-center gap-4 hover:border-indigo-200 hover:shadow-[0_10px_20px_-10px_rgba(79,70,229,0.2)] transition-all duration-300 group">
                                    <div class="flex-1 w-full">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="px-3 py-1 rounded-[0.5rem] border text-[9px] font-black uppercase tracking-widest ${resConfig.color}">${resConfig.label}</span>
                                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest hidden sm:inline-block">Component</span>
                                        </div>
                                        <h5 class="text-sm font-black text-slate-800 uppercase tracking-tight group-hover:text-indigo-600 transition-colors">${item.part_name}</h5>
                                        <p class="text-[10px] font-extrabold text-slate-400 mt-1 uppercase tracking-widest">${item.material ? item.material : '-'} <span class="mx-1.5 text-slate-200">•</span> ${item.qty ? item.qty : 0} PCS</p>
                                    </div>
                                    <div class="flex items-center gap-2 w-full sm:w-auto mt-3 sm:mt-0">
                                        ${userIsLoggedIn ? `<button class="btn-update flex-1 sm:flex-none px-5 py-3 bg-indigo-50 text-indigo-600 border border-indigo-100 text-[10px] font-black rounded-[1rem] hover:bg-indigo-600 hover:text-white shadow-sm hover:shadow-md uppercase tracking-widest transition-all" data-id="${info.event.id}" data-part="${item.part_name}">Edit</button>` : ''}
                                        <button class="btn-detail flex-1 sm:flex-none px-5 py-3 bg-white text-slate-600 border border-slate-200 text-[10px] font-black rounded-[1rem] hover:bg-slate-900 hover:border-slate-900 hover:text-white shadow-sm hover:shadow-md uppercase tracking-widest transition-all" data-id="${info.event.id}" data-part="${item.part_name}">Log</button>
                                    </div>
                                </div>
                            `);
                        });

                        const percent = Math.round((okCount / itemsArray.length) * 100);
                        $('#mPercentText').text(percent + '%');
                        // Use timeout for smooth fill animation after modal opens
                        setTimeout(() => $('#mProgressBar').css('width', percent + '%'), 400);
                    } else {
                        itemsContainer.append(
                            '<div class="p-10 text-center flex flex-col items-center text-slate-400 bg-white rounded-[2rem] border border-slate-100 border-dashed"><i class="bx bx-box text-3xl mb-3 text-slate-200"></i><span class="text-[10px] font-black uppercase tracking-[0.2em]">Item Data Unavailable</span></div>'
                            );
                        $('#mPercentText').text('0%');
                        $('#mProgressBar').css('width', '0%');
                    }
                    toggleModal('modal', '#modalContent');
                }
            });
            calendar.render();

            // KLIK UPDATE 
            $(document).on('click', '.btn-update', function() {
                const actId = $(this).data('id');
                const part = $(this).data('part');
                $('#resultForm')[0].reset();
                $('#activity_id').val(actId);
                $('#part_name').val(part);
                $('#display_part_name').text(part);
                const found = getLatestResult(actId, part);
                if (found) {
                    $('#result_id').val(found.id);
                    $('#inspector_name').val(found.inspector_name);
                    $('#pic').val(found.pic);
                    $('#result').val(found.result);
                    $('#remarks').val(found.remarks || '');
                } else {
                    $('#result_id').val('');
                }
                toggleModal('resultModal', '#resultModal > div');
            });

            // KLIK LOG/HISTORY
            $(document).on('click', '.btn-detail', function() {
                const actId = $(this).data('id');
                const part = $(this).data('part');
                const matches = resultsData.filter(r => String(r.activity_id) === String(actId) && String(r
                    .part_name).trim().toLowerCase() === String(part).trim().toLowerCase());
                let htmlContent = '';

                if (matches.length === 0) {
                    htmlContent =
                        '<div class="p-12 text-center text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] border border-dashed border-slate-200 bg-white rounded-[2rem]">History Log Kosong</div>';
                } else {
                    matches.sort((a, b) => b.id - a.id).forEach(m => {
                        const bgBadge = m.result === 'OK' ? 'bg-emerald-500' : (m.result === 'NG' ?
                            'bg-rose-500' : 'bg-amber-500');
                        const dateText = m.inspection_time ? new Date(m.inspection_time)
                            .toLocaleString('id-ID', {
                                dateStyle: 'medium',
                                timeStyle: 'short'
                            }) : '-';
                        htmlContent += `
                        <div class="text-left bg-white p-6 rounded-[2rem] border border-slate-100 mb-4 shadow-sm hover:shadow-md hover:border-indigo-100 transition-all duration-300">
                            <div class="flex justify-between items-center mb-4 pb-4 border-b border-slate-100">
                                <span class="px-3 py-1 rounded-lg ${bgBadge} text-white text-[9px] font-black uppercase tracking-widest shadow-sm">${m.result}</span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">${dateText}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4 text-xs">
                                <div class="bg-slate-50 border border-slate-100 p-3.5 rounded-[1.25rem]"><p class="font-black text-slate-400 uppercase text-[8px] mb-1 tracking-widest">Inspector</p><p class="font-extrabold text-slate-800">${m.inspector_name}</p></div>
                                <div class="bg-slate-50 border border-slate-100 p-3.5 rounded-[1.25rem]"><p class="font-black text-slate-400 uppercase text-[8px] mb-1 tracking-widest">PIC Metinca</p><p class="font-extrabold text-slate-800">${m.pic}</p></div>
                            </div>
                            <div class="bg-slate-50/50 p-4 rounded-2xl border border-slate-100">
                                <p class="font-black text-slate-400 uppercase text-[8px] mb-2 tracking-widest flex items-center gap-1.5"><i class="bx bx-message-square-detail text-sm"></i> Remarks</p>
                                <p class="text-[11px] text-slate-600 font-bold leading-relaxed">${m.remarks || '<em class="text-slate-400 font-normal">Tidak ada catatan.</em>'}</p>
                            </div>
                        </div>`;
                    });
                }

                Swal.fire({
                    title: `<div class="text-2xl sm:text-3xl font-black text-slate-800 uppercase tracking-tighter mb-1">${part}</div><p class="text-[9px] text-indigo-500 uppercase tracking-[0.25em] font-black">History Log</p>`,
                    html: `<div class="max-h-[500px] overflow-y-auto mt-4 px-2 custom-scroll bg-slate-50/50 rounded-[2.5rem] p-3 border border-slate-100/50">${htmlContent}</div>`,
                    showConfirmButton: false,
                    showCloseButton: true,
                    customClass: {
                        popup: 'rounded-[3rem] p-6 sm:p-8 border border-white shadow-2xl bg-white/95 backdrop-blur-xl',
                        closeButton: 'focus:outline-none mt-5 mr-5 bg-white border border-slate-100 shadow-sm rounded-full w-10 h-10 flex items-center justify-center hover:bg-rose-50 hover:text-rose-500 transition-all text-slate-400'
                    }
                });
            });

            // Tutup Pop-Up Jika Klik Luar Panel
            $('#modal, #resultModal').on('mousedown', function(e) {
                if (e.target === this) {
                    if (this.id === 'modal') toggleModal('modal', '#modalContent', false);
                    if (this.id === 'resultModal') toggleModal('resultModal', '#resultModal > div', false);
                }
            });
        });
    </script>
@endpush
