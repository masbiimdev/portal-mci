@extends('layouts.home')
@section('title', 'MCI | Smart Schedule Dashboard')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary: #4F46E5;
            --secondary: #6366F1;
            --accent: #F43F5E;
            --glass: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F1F5F9;
            color: #1E293B;
            min-height: 100vh;
        }

        /* Dashboard Container Gradient */
        .dashboard-bg {
            background: radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(244, 63, 94, 0.05) 0%, transparent 50%);
        }

        /* Premium Card Glassmorphism */
        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
        }

        /* Calendar Stylings */
        .fc {
            --fc-button-bg-color: #4F46E5;
            --fc-button-border-color: #4F46E5;
            --fc-button-hover-bg-color: #4338CA;
        }

        .fc .fc-toolbar-title {
            font-weight: 800;
            letter-spacing: -0.025em;
            color: #0F172A;
            font-size: clamp(1.25rem, 2vw, 1.5rem);
        }

        .fc .fc-day-today {
            background: rgba(79, 70, 229, 0.03) !important;
        }

        .fc .fc-col-header-cell {
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748B;
            padding: 12px 0;
        }

        /* Event Custom Appearance */
        .fc-event {
            border: none !important;
            padding: 4px 6px !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .fc-event:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Progress Bar High-End */
        .progress-wrapper {
            height: 8px;
            background: #E2E8F0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4F46E5, #06B6D4);
            border-radius: 10px;
            transition: width 1.2s ease-out;
        }

        /* Scrollbar styling */
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-bg min-h-screen">
        <div class="max-w-[1500px] mx-auto p-4 sm:p-8">

            {{-- HEADER --}}
            <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Smart Schedule MCI</h1>
                    <p class="text-slate-500 font-medium">Monitoring real-time kegiatan & hasil inspeksi.</p>
                </div>
                <div class="flex items-center gap-3">
                    <span id="lastUpdate"
                        class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-[11px] font-bold text-slate-400 flex items-center gap-2 shadow-sm">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        SYNCING...
                    </span>
                </div>
            </header>

            {{-- NOTIFIKASI ERROR VALIDASI --}}
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-600 font-bold text-sm">
                    Gagal menyimpan data: Pastikan semua field wajib terisi dengan benar.
                </div>
            @endif
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-600 font-bold text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- MAIN GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- SIDEBAR --}}
                <aside class="lg:col-span-3 space-y-8 order-2 lg:order-1">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="glass-card p-6 rounded-[2rem] bg-indigo-600 text-white relative overflow-hidden">
                            <div class="relative z-10">
                                <p class="text-xs font-bold text-indigo-100 uppercase tracking-widest opacity-80">Today's
                                    Tasks</p>
                                <h2 class="text-5xl font-black mt-2 tracking-tighter">{{ $todayCount ?? 0 }}</h2>
                            </div>
                            <svg class="absolute -right-4 -bottom-4 w-32 h-32 opacity-10 text-white" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7v-5z" />
                            </svg>
                        </div>
                        <div class="glass-card p-6 rounded-[2rem] bg-white border-none">
                            <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Weekly Goal</p>
                            <div class="flex items-end justify-between mt-2">
                                <h2 class="text-3xl font-bold text-slate-800 tracking-tighter">{{ $weekCount ?? 0 }} <span
                                        class="text-sm font-medium text-slate-400">Events</span></h2>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-6 rounded-[2rem]">
                        <h3
                            class="text-sm font-extrabold text-slate-800 uppercase mb-6 tracking-wide flex items-center justify-between">
                            Next Agenda
                            <span class="text-[10px] bg-slate-100 px-2 py-1 rounded-lg text-slate-500">Auto-update</span>
                        </h3>
                        <div class="space-y-6 max-h-[400px] overflow-y-auto custom-scroll pr-3">
                            @forelse ($weekActivities as $activity)
                                <div class="group cursor-pointer">
                                    <div class="flex gap-4 items-start">
                                        <div
                                            class="flex-shrink-0 w-12 h-12 rounded-2xl bg-slate-100 flex flex-col items-center justify-center transition-colors group-hover:bg-indigo-50">
                                            <span
                                                class="text-[10px] font-extrabold text-slate-400 group-hover:text-indigo-600 uppercase">{{ \Carbon\Carbon::parse($activity->start_date)->format('M') }}</span>
                                            <span
                                                class="text-lg font-black text-slate-700 group-hover:text-indigo-700 leading-none">{{ \Carbon\Carbon::parse($activity->start_date)->format('d') }}</span>
                                        </div>
                                        <div class="min-w-0">
                                            <h4
                                                class="text-sm font-bold text-slate-800 group-hover:text-indigo-600 transition-colors truncate uppercase">
                                                {{ $activity->kegiatan }}</h4>
                                            <p class="text-[11px] text-slate-500 font-medium italic truncate">
                                                {{ $activity->customer ?? 'No Client' }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-400 text-xs italic text-center py-4">Kosong</p>
                            @endforelse
                        </div>
                    </div>
                </aside>

                {{-- CALENDAR --}}
                <main class="lg:col-span-9 order-1 lg:order-2">
                    <div class="glass-card p-6 sm:p-8 rounded-[2.5rem] bg-white">
                        <div id="calendar" class="min-h-[600px]"></div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    {{-- MODAL DETAIL AKTIVITAS --}}
    <div id="modal"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-xl hidden items-center justify-center z-50 p-4 transition-all">
        <div id="modalContent"
            class="bg-white rounded-[3rem] w-full max-w-2xl overflow-hidden shadow-[0_30px_60px_-15px_rgba(0,0,0,0.3)] transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
            <div class="p-10 pb-6 flex justify-between items-start">
                <div class="max-w-[80%]">
                    <div id="mStatusBadge"
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest mb-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                        <span id="mStatus"></span>
                    </div>
                    <h2 id="mTitle" class="text-3xl font-extrabold text-slate-900 leading-tight"></h2>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    stroke-width="2" />
                            </svg>
                            <span id="mCustomer"></span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                    stroke-width="2" />
                            </svg>
                            <span id="mTime"></span>
                        </div>
                    </div>
                </div>
                <button id="closeModal"
                    class="p-3 rounded-2xl bg-slate-50 hover:bg-rose-50 hover:text-rose-500 transition-all text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" />
                    </svg>
                </button>
            </div>

            <div class="px-10 py-4 overflow-y-auto custom-scroll flex-grow">
                <div class="flex items-center justify-between mb-8 p-6 bg-slate-50 rounded-[2rem]">
                    <div>
                        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Completion
                            Progress</p>
                        <div class="flex items-baseline gap-2">
                            <span id="mPercentText" class="text-3xl font-black text-indigo-600">0%</span>
                            <span class="text-xs font-bold text-slate-400 uppercase">Items Passed</span>
                        </div>
                    </div>
                    <div class="w-48">
                        <div class="progress-wrapper">
                            <div id="mProgressBar" class="progress-fill" style="width: 0%"></div>
                        </div>
                    </div>
                </div>

                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 ml-2">Item Inspection List</h4>
                <div id="mItems" class="space-y-4 pb-4"></div>
            </div>

            <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button id="closeModal2"
                    class="px-8 py-3 rounded-2xl bg-white border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-all">Close</button>
            </div>
        </div>
    </div>

    {{-- MODAL UPDATE HASIL --}}
    <div id="resultModal"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-md hidden items-center justify-center z-[60] p-4 transition-all">
        <div
            class="bg-white rounded-[2.5rem] w-full max-w-md p-10 shadow-2xl relative transform scale-95 opacity-0 transition-all duration-300">
            <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Update Inspection</h3>
            <p id="display_part_name" class="text-sm font-bold text-indigo-600 mb-8"></p>

            {{-- PENTING: Action form diset ke route hasil update --}}
            <form id="resultForm" method="POST" action="{{ route('jadwal.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="result_id" id="result_id">
                <input type="hidden" name="activity_id" id="activity_id">
                <input type="hidden" name="part_name" id="part_name">

                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase ml-1 tracking-widest">Client
                                Inspector</label>
                            <input type="text" name="inspector_name" id="inspector_name" required
                                class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>
                        <div class="space-y-1">
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase ml-1 tracking-widest">PIC
                                Metinca</label>
                            <input type="text" name="pic" id="pic" required
                                class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase ml-1 tracking-widest">Inspection
                            Result</label>
                        <select name="result" id="result"
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 appearance-none cursor-pointer">
                            <option value="OK">ALL ACCEPTED</option>
                            <option value="PA">PARTIAL ACCEPTED</option>
                            <option value="OH">ON HOLD</option>
                            <option value="NG">REJECTED</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-extrabold text-slate-400 uppercase ml-1 tracking-widest">Catatan /
                            Remarks</label>
                        <textarea name="remarks" id="remarks" rows="3" placeholder="Tambahkan catatan jika ada..."
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all outline-none resize-none"></textarea>
                    </div>
                </div>

                <div class="pt-6 flex gap-3">
                    <button type="button" id="closeResultModal"
                        class="flex-1 py-4 text-sm font-bold text-slate-400 hover:text-slate-600 transition-all">Cancel</button>
                    <button type="submit" id="submitResultBtn"
                        class="flex-[2] py-4 bg-indigo-600 text-white rounded-2xl text-sm font-bold shadow-xl shadow-indigo-200 hover:bg-indigo-700 transition-all">Save
                        Result</button>
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
            // 1. Ambil data dari Controller
            const resultsData = @json($resultsData ?? []);
            const userIsLoggedIn = {!! Auth::check() ? 'true' : 'false' !!};

            // FUNGSI KUNCI 1: Ambil data TERBARU berdasarkan ID terbesar
            // Mengatasi masalah jika ada riwayat ganda, JS akan selalu mengambil hasil yang paling update
            function getLatestResult(actId, partName) {
                if (!Array.isArray(resultsData)) return null;

                const matches = resultsData.filter(r =>
                    String(r.activity_id) === String(actId) &&
                    String(r.part_name).trim().toLowerCase() === String(partName).trim().toLowerCase()
                );

                if (matches.length === 0) return null;

                // Urutkan berdasarkan ID (terbesar/terbaru di index 0)
                matches.sort((a, b) => b.id - a.id);
                return matches[0];
            }

            // FUNGSI KUNCI 2: Memastikan JSON Items benar-benar jadi Array
            function parseItems(rawItems) {
                let parsed = rawItems;
                try {
                    if (typeof parsed === 'string') parsed = JSON.parse(parsed);
                    if (typeof parsed === 'string') parsed = JSON.parse(parsed); // Cegah double encode
                } catch (e) {}
                return Array.isArray(parsed) ? parsed : [];
            }

            // 2. Fungsi Animasi Modal
            function toggleModal(modalId, contentSelector, show = true) {
                const m = $(`#${modalId}`);
                const c = $(contentSelector);
                if (show) {
                    m.removeClass('hidden').addClass('flex');
                    setTimeout(() => c.removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100'), 10);
                } else {
                    c.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                    setTimeout(() => m.addClass('hidden').removeClass('flex'), 250);
                }
            }

            $('#closeModal, #closeModal2').click(() => toggleModal('modal', '#modalContent', false));
            $('#closeResultModal').click(() => toggleModal('resultModal', '#resultModal > div', false));

            @if ($errors->any())
                toggleModal('resultModal', '#resultModal > div', true);
            @endif

            // 3. Inisialisasi FullCalendar
            const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 768 ? '' : 'dayGridMonth,listWeek'
                },
                height: 'auto',
                events: [
                    @foreach ($activities as $activity)
                        @php
                            $start = \Carbon\Carbon::parse($activity->start_date);
                            $end = \Carbon\Carbon::parse($activity->end_date);
                            $statusColor =
                                [
                                    'Done' => '#10B981',
                                    'On Going' => '#F59E0B',
                                    'Reschedule' => '#F43F5E',
                                    'Pending' => '#64748B',
                                ][$activity->status] ?? '#4F46E5';
                        @endphp
                        @for ($d = $start->copy(); $d->lte($end); $d->addDay())
                            @if (!$d->isWeekend())
                                {
                                    id: '{{ $activity->id }}',
                                    title: '{{ $activity->kegiatan }}',
                                    start: '{{ $d->toDateString() }}',
                                    backgroundColor: '{{ $statusColor }}',
                                    extendedProps: {
                                        customer: '{{ addslashes($activity->customer ?? '-') }}',
                                        po: '{{ addslashes($activity->po ?? '-') }}',
                                        status: '{{ $activity->status }}',
                                        items: {!! $activity->items ? $activity->items : '[]' !!}
                                    }
                                },
                            @endif
                        @endfor
                    @endforeach
                ],

                // MENGHITUNG & MENGGAMBAR PROGRESS BAR DI KALENDER
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
                    `<div class="flex flex-col gap-1 w-full p-1 text-white overflow-hidden">
                                    <div class="font-bold truncate text-[11px] leading-tight">${arg.event.title}</div>`;

                    if (itemsArray.length > 0) {
                        html += `<div class="flex items-center gap-1.5 w-full mt-0.5">
                                    <div class="h-1.5 w-full bg-white/30 rounded-full overflow-hidden">
                                        <div class="h-full bg-white rounded-full" style="width: ${pct}%"></div>
                                    </div>
                                    <span class="text-[9px] font-black min-w-[20px] text-right">${pct}%</span>
                                </div>`;
                    }
                    html += `</div>`;
                    return {
                        html: html
                    };
                },

                // KLIK JADWAL -> MUNCUL POPUP DETAIL
                eventClick: function(info) {
                    const p = info.event.extendedProps;

                    $('#mTitle').text(info.event.title);
                    $('#mCustomer').text(p.customer);
                    $('#mTime').text(info.event.start.toLocaleDateString('id-ID', {
                        dateStyle: 'long'
                    }));
                    $('#mStatus').text(p.status);

                    const statusClass = {
                        'Done': 'bg-emerald-50 text-emerald-600',
                        'On Going': 'bg-amber-50 text-amber-600',
                        'Reschedule': 'bg-rose-50 text-rose-600'
                    } [p.status] || 'bg-slate-50 text-slate-600';

                    $('#mStatusBadge').removeClass().addClass(
                        `inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest mb-3 ${statusClass}`
                        );

                    const itemsContainer = $('#mItems').empty();
                    const itemsArray = parseItems(p.items);
                    let okCount = 0;

                    if (itemsArray.length > 0) {
                        itemsArray.forEach(item => {
                            // Cek data terbaru dari database
                            const found = getLatestResult(info.event.id, item.part_name);
                            if (found && found.result === 'OK') okCount++;

                            const resConfig = {
                                'OK': {
                                    color: 'text-emerald-500 bg-emerald-50',
                                    label: 'Accepted'
                                },
                                'PA': {
                                    color: 'text-blue-500 bg-blue-50',
                                    label: 'Partial'
                                },
                                'NG': {
                                    color: 'text-rose-500 bg-rose-50',
                                    label: 'Rejected'
                                },
                                'OH': {
                                    color: 'text-amber-500 bg-amber-50',
                                    label: 'On Hold'
                                }
                            } [found?.result] || {
                                color: 'text-slate-400 bg-slate-50',
                                label: 'Pending'
                            };

                            // Render baris list item
                            itemsContainer.append(`
                                <div class="bg-white border border-slate-100 p-6 rounded-[2rem] flex flex-col md:flex-row justify-between gap-6 transition-all hover:border-indigo-100">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Part Name</span>
                                            <span class="px-2 py-0.5 rounded-lg text-[9px] font-black uppercase ${resConfig.color}">${resConfig.label}</span>
                                        </div>
                                        <h5 class="text-lg font-extrabold text-slate-800 uppercase tracking-tight">${item.part_name}</h5>
                                        <p class="text-xs font-bold text-slate-400 mt-1">${item.material || '-'} • ${item.qty || 0} PCS</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        ${userIsLoggedIn ? `<button class="btn-update flex-1 md:flex-none px-6 py-3 bg-indigo-50 text-indigo-600 text-[11px] font-black rounded-2xl hover:bg-indigo-600 hover:text-white transition-all" data-id="${info.event.id}" data-part="${item.part_name}">UPDATE</button>` : ''}
                                        <button class="btn-detail flex-1 md:flex-none px-6 py-3 bg-slate-50 text-slate-500 text-[11px] font-black rounded-2xl hover:bg-slate-900 hover:text-white transition-all" data-id="${info.event.id}" data-part="${item.part_name}">DETAILS</button>
                                    </div>
                                </div>
                            `);
                        });

                        const percent = Math.round((okCount / itemsArray.length) * 100);
                        $('#mPercentText').text(percent + '%');
                        setTimeout(() => $('#mProgressBar').css('width', percent + '%'), 300);
                    } else {
                        itemsContainer.append(
                            '<div class="p-6 text-center text-sm font-medium text-slate-400 bg-slate-50 rounded-2xl">Tidak ada list part untuk inspeksi.</div>'
                            );
                        $('#mPercentText').text('0%');
                        $('#mProgressBar').css('width', '0%');
                    }

                    toggleModal('modal', '#modalContent');
                }
            });
            calendar.render();

            // 4. MUNCULKAN FORM UPDATE JIKA DIKLIK
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

            // 5. MUNCULKAN DETAIL (SWEETALERT) JIKA DIKLIK
            $(document).on('click', '.btn-detail', function() {
                const actId = $(this).data('id');
                const part = $(this).data('part');

                const matches = resultsData.filter(r =>
                    String(r.activity_id) === String(actId) &&
                    String(r.part_name).trim().toLowerCase() === String(part).trim().toLowerCase()
                );

                let htmlContent = '';
                if (matches.length === 0) {
                    htmlContent =
                        '<div class="p-8 text-center text-slate-400 font-bold">Belum ada riwayat inspeksi.</div>';
                } else {
                    // Tampilkan dari yang paling baru
                    matches.sort((a, b) => b.id - a.id).forEach(m => {
                        const bgBadge = m.result === 'OK' ? 'bg-emerald-500' : (m.result === 'NG' ?
                            'bg-rose-500' : 'bg-amber-500');
                        const dateText = m.inspection_time ? new Date(m.inspection_time)
                            .toLocaleString('id-ID') : '-';

                        htmlContent += `
                        <div class="text-left bg-slate-50 p-6 rounded-[2rem] border border-slate-100 mb-4 hover:border-indigo-200 transition-all">
                            <div class="flex justify-between items-center mb-4 border-b border-slate-200 pb-4">
                                <span class="px-3 py-1.5 rounded-lg ${bgBadge} text-white text-[10px] font-black uppercase tracking-widest">${m.result}</span>
                                <span class="text-[11px] font-bold text-slate-400">${dateText}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4 text-xs">
                                <div><p class="font-black text-slate-300 uppercase text-[9px] mb-1 tracking-widest">Inspector</p><p class="font-bold text-slate-700">${m.inspector_name}</p></div>
                                <div><p class="font-black text-slate-300 uppercase text-[9px] mb-1 tracking-widest">PIC Metinca</p><p class="font-bold text-slate-700">${m.pic}</p></div>
                            </div>
                            <div class="bg-white p-4 rounded-xl">
                                <p class="font-black text-slate-300 uppercase text-[9px] mb-1 tracking-widest">Catatan</p>
                                <p class="text-xs text-slate-600 font-medium">${m.remarks || '<em class="text-slate-400 font-normal">Tidak ada catatan.</em>'}</p>
                            </div>
                        </div>`;
                    });
                }

                Swal.fire({
                    title: `<div class="text-xl font-extrabold text-slate-800 uppercase tracking-tight">${part}</div>`,
                    html: `<div class="max-h-[400px] overflow-y-auto mt-4 px-2 custom-scroll">${htmlContent}</div>`,
                    showConfirmButton: false,
                    showCloseButton: true,
                    customClass: {
                        popup: 'rounded-[3rem] p-6',
                        closeButton: 'focus:outline-none mt-2 mr-2'
                    }
                });
            });

            // Tutup pop-up jika klik background blur
            $('#modal, #resultModal').on('click', function(e) {
                if (e.target === this) {
                    if (this.id === 'modal') toggleModal('modal', '#modalContent', false);
                    if (this.id === 'resultModal') toggleModal('resultModal', '#resultModal > div', false);
                }
            });
        });
    </script>
@endpush
