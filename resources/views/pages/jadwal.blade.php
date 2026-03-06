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
            --glass: rgba(255, 255, 255, 0.7);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F1F5F9;
            color: #1E293B;
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
            padding: 5px 8px !important;
            font-size: 0.75rem !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
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

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-bg min-h-screen">
        <div class="max-w-[1500px] mx-auto p-4 sm:p-8">

            <header class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Smart Schedule MCI</h1>
                    <p class="text-slate-500 font-medium">Monitoring real-time kegiatan & hasil inspeksi.</p>
                </div>
                <div class="flex items-center gap-3">
                    <span id="lastUpdate"
                        class="px-4 py-2 rounded-2xl bg-white border border-slate-200 text-[11px] font-bold text-slate-400 flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></span>
                        SYNCING...
                    </span>
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

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

                <main class="lg:col-span-9 order-1 lg:order-2">
                    <div class="glass-card p-6 sm:p-8 rounded-[2.5rem] bg-white">
                        <div id="calendar"></div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <div id="modal"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-xl hidden items-center justify-center z-50 p-4 transition-all">
        <div id="modalContent"
            class="bg-white rounded-[3rem] w-full max-w-2xl overflow-hidden shadow-[0_30px_60px_-15px_rgba(0,0,0,0.3)] transform scale-95 opacity-0 transition-all duration-300">
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

            <div class="px-10 py-4 max-h-[60vh] overflow-y-auto custom-scroll">
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
                <div id="mItems" class="space-y-4 pb-10"></div>
            </div>

            <div class="p-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button id="closeModal2"
                    class="px-8 py-3 rounded-2xl bg-white border border-slate-200 text-sm font-bold text-slate-600 hover:bg-slate-100 transition-all">Close</button>
            </div>
        </div>
    </div>

    <div id="resultModal"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-md hidden items-center justify-center z-[60] p-4">
        <div class="bg-white rounded-[2.5rem] w-full max-w-md p-10 shadow-2xl relative">
            <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Update Inspection</h3>
            <p id="display_part_name" class="text-sm font-bold text-indigo-600 mb-8"></p>

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
            const resultsData = @json($resultsData);
            const userIsLoggedIn = {!! Auth::check() ? 'true' : 'false' !!};

            // --- Modal Animations ---
            function toggleModal(modalId, contentId, show = true) {
                const m = $(`#${modalId}`);
                const c = $(`#${contentId}`);
                if (show) {
                    m.removeClass('hidden').addClass('flex');
                    setTimeout(() => c.removeClass('scale-95 opacity-0').addClass('scale-100 opacity-100'), 10);
                } else {
                    c.removeClass('scale-100 opacity-100').addClass('scale-95 opacity-0');
                    setTimeout(() => m.addClass('hidden').removeClass('flex'), 250);
                }
            }

            $('#closeModal, #closeModal2').click(() => toggleModal('modal', 'modalContent', false));
            $('#closeResultModal').click(() => toggleModal('resultModal', 'resultModal > div', false));

            // --- Calendar Implementation ---
            const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: window.innerWidth < 768 ? '' : 'dayGridMonth,dayGridWeek,listWeek'
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
                                        customer: '{{ $activity->customer ?? '-' }}',
                                        type: '{{ ucfirst($activity->type) }}',
                                        po: '{{ $activity->po ?? '-' }}',
                                        status: '{{ $activity->status }}',
                                        items: {!! $activity->items ?? '[]' !!}
                                    }
                                },
                            @endif
                        @endfor
                    @endforeach
                ],
                eventClick: function(info) {
                    const p = info.event.extendedProps;

                    // Header Info
                    $('#mTitle').text(info.event.title);
                    $('#mCustomer').text(p.customer);
                    $('#mTime').text(info.event.start.toLocaleDateString('id-ID', {
                        dateStyle: 'long'
                    }));
                    $('#mStatus').text(p.status);

                    // Dynamic Status Badge
                    const statusClass = {
                        'Done': 'bg-emerald-50 text-emerald-600',
                        'On Going': 'bg-amber-50 text-amber-600',
                        'Reschedule': 'bg-rose-50 text-rose-600'
                    } [p.status] || 'bg-slate-50 text-slate-600';
                    $('#mStatusBadge').removeClass().addClass(
                        `inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest mb-3 ${statusClass}`
                        );

                    // Items Rendering
                    const itemsContainer = $('#mItems').empty();
                    let ok = 0;

                    if (p.items.length > 0) {
                        p.items.forEach(item => {
                            const found = resultsData.find(r => r.activity_id == info.event
                                .id && r.part_name == item.part_name);
                            if (found?.result === 'OK') ok++;

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

                            itemsContainer.append(`
                        <div class="bg-white border border-slate-100 p-6 rounded-[2rem] flex flex-col md:flex-row justify-between gap-6 transition-all hover:border-indigo-100">
                            <div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Part Name</span>
                                    <span class="px-2 py-0.5 rounded-lg text-[9px] font-black uppercase ${resConfig.color}">${resConfig.label}</span>
                                </div>
                                <h5 class="text-lg font-extrabold text-slate-800 uppercase tracking-tight">${item.part_name}</h5>
                                <p class="text-xs font-bold text-slate-400 mt-1">${item.material || '-'} • ${item.qty || 0} PCS</p>
                            </div>
                            <div class="flex items-center gap-2">
                                ${userIsLoggedIn ? `<button onclick="openForm('${info.event.id}', '${item.part_name}')" class="flex-1 md:flex-none px-6 py-3 bg-indigo-50 text-indigo-600 text-[11px] font-black rounded-2xl hover:bg-indigo-600 hover:text-white transition-all">UPDATE</button>` : ''}
                                <button onclick="viewDetail('${info.event.id}', '${item.part_name}')" class="flex-1 md:flex-none px-6 py-3 bg-slate-50 text-slate-500 text-[11px] font-black rounded-2xl hover:bg-slate-900 hover:text-white transition-all">DETAILS</button>
                            </div>
                        </div>
                    `);
                        });

                        const percent = Math.round((ok / p.items.length) * 100);
                        $('#mPercentText').text(percent + '%');
                        setTimeout(() => $('#mProgressBar').css('width', percent + '%'), 200);
                    }

                    toggleModal('modal', 'modalContent');
                }
            });
            calendar.render();

            // --- Functions ---
            window.openForm = function(actId, part) {
                $('#activity_id').val(actId);
                $('#part_name').val(part);
                $('#display_part_name').text(part);

                const found = resultsData.find(r => r.activity_id == actId && r.part_name == part);
                if (found) {
                    $('#result_id').val(found.id);
                    $('#inspector_name').val(found.inspector_name);
                    $('#pic').val(found.pic);
                    $('#result').val(found.result);
                }
                toggleModal('resultModal', 'resultModal > div');
            };

            function updateSync() {
                const time = new Date().toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                $('#lastUpdate').html(
                    `<span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> SYNCED ${time}`);
            }
            updateSync();
            setInterval(updateSync, 60000);
        });
    </script>
@endpush
