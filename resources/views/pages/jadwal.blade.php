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
            --glass: rgba(255, 255, 255, 0.85);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #F8FAFC;
            color: #1E293B;
        }

        /* Premium Glassmorphism */
        .glass-card {
            background: var(--glass);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 1);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.08);
        }

        /* Calendar Stylings */
        .fc {
            --fc-button-bg-color: #4F46E5;
            --fc-button-border-color: #4F46E5;
        }

        .fc .fc-toolbar-title {
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #0F172A;
        }

        .fc .fc-col-header-cell {
            text-transform: uppercase;
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748B;
            padding: 12px 0;
        }

        .fc-event {
            border: none !important;
            padding: 4px 8px !important;
            font-weight: 600 !important;
            border-radius: 8px !important;
        }

        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #CBD5E1;
            border-radius: 10px;
        }

        /* Progress Bar */
        .progress-wrapper {
            height: 8px;
            background: #E2E8F0;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4F46E5, #06B6D4);
            border-radius: 10px;
            transition: width 1s ease;
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-[#F8FAFC]">
        <div class="max-w-[1500px] mx-auto p-4 sm:p-8">

            <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-[800] text-slate-900 tracking-tight">MCI Smart Dashboard</h1>
                    <p class="text-slate-500 font-medium">Monitoring Real-time Jadwal & Inspeksi</p>
                </div>
                <div id="lastUpdate"
                    class="px-5 py-2.5 rounded-2xl bg-white border border-slate-200 text-[11px] font-bold text-slate-400 flex items-center gap-2 shadow-sm uppercase tracking-widest">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    System Synced
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <aside class="lg:col-span-3 space-y-6 order-2 lg:order-1">
                    <div class="glass-card p-6 rounded-[2.5rem] bg-indigo-600 text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <p class="text-[10px] font-bold text-indigo-100 uppercase tracking-widest opacity-80">Today's
                                Activity</p>
                            <h2 class="text-5xl font-black mt-1 tracking-tighter">{{ $todayCount ?? 0 }}</h2>
                        </div>
                    </div>

                    <div class="glass-card p-8 rounded-[2.5rem]">
                        <h3 class="text-xs font-black text-slate-800 uppercase mb-6 tracking-widest">Upcoming Agenda</h3>
                        <div class="space-y-6 max-h-[450px] overflow-y-auto custom-scroll pr-3">
                            @forelse ($weekActivities as $activity)
                                <div class="group flex gap-4 items-center">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 rounded-2xl bg-slate-50 flex flex-col items-center justify-center transition-colors group-hover:bg-indigo-50">
                                        <span
                                            class="text-[10px] font-black text-slate-400 group-hover:text-indigo-600 uppercase">{{ \Carbon\Carbon::parse($activity->start_date)->format('M') }}</span>
                                        <span
                                            class="text-lg font-black text-slate-700 group-hover:text-indigo-700 leading-none">{{ \Carbon\Carbon::parse($activity->start_date)->format('d') }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <h4
                                            class="text-sm font-bold text-slate-800 truncate uppercase tracking-tight group-hover:text-indigo-600 transition-colors">
                                            {{ $activity->kegiatan }}</h4>
                                        <p class="text-[11px] text-slate-400 font-medium italic truncate">
                                            {{ $activity->customer ?? 'No Client' }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-400 text-xs italic text-center">Tidak ada jadwal terdekat</p>
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

    <div id="modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-md hidden items-center justify-center z-50 p-4">
        <div id="modalContent"
            class="bg-white rounded-[3rem] w-full max-w-3xl overflow-hidden shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
            <div class="p-10 pb-4 flex justify-between items-start">
                <div class="max-w-[80%]">
                    <div id="mStatusBadge"
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-3">
                        <span id="mStatus"></span>
                    </div>
                    <h2 id="mTitle" class="text-3xl font-extrabold text-slate-900 leading-tight tracking-tighter"></h2>
                </div>
                <button id="closeModal"
                    class="p-3 rounded-2xl bg-slate-50 hover:bg-rose-50 hover:text-rose-500 transition-all text-slate-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M6 18L18 6M6 6l12 12" stroke-width="2.5" />
                    </svg>
                </button>
            </div>

            <div class="px-10 py-6 max-h-[65vh] overflow-y-auto custom-scroll">
                <div
                    class="flex flex-col md:flex-row items-center justify-between mb-8 p-8 bg-slate-50 rounded-[2.5rem] gap-6">
                    <div>
                        <p
                            class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 text-center md:text-left">
                            Inspection Progress</p>
                        <div class="flex items-center gap-3 justify-center md:justify-start">
                            <span id="mPercentText" class="text-4xl font-black text-indigo-600">0%</span>
                            <div class="w-32 md:w-48 progress-wrapper">
                                <div id="mProgressBar" class="progress-fill" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-xs font-bold text-slate-500 uppercase tracking-tight">
                        <div class="bg-white px-4 py-2 rounded-xl">PO: <span id="mPO" class="text-slate-800"></span>
                        </div>
                        <div class="bg-white px-4 py-2 rounded-xl">Date: <span id="mTime" class="text-slate-800"></span>
                        </div>
                    </div>
                </div>

                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-4">Inspection Items</h4>
                <div id="mItems" class="space-y-4"></div>
            </div>

            <div class="p-8 bg-white flex justify-end">
                <button id="closeModal2"
                    class="px-8 py-3 rounded-2xl bg-slate-100 text-sm font-black text-slate-500 hover:bg-slate-200 transition-all">CLOSE</button>
            </div>
        </div>
    </div>

    <div id="resultModal"
        class="fixed inset-0 bg-slate-900/80 backdrop-blur-md hidden items-center justify-center z-[70] p-4">
        <div
            class="bg-white rounded-[2.5rem] w-full max-w-md p-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300">
            <h3 class="text-2xl font-[900] text-slate-900 mb-2">Update Hasil</h3>
            <p id="display_part_name" class="text-sm font-bold text-indigo-600 mb-8 tracking-tight"></p>

            <form id="resultForm" method="POST" action="{{ route('jadwal.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="result_id" id="result_id">
                <input type="hidden" name="activity_id" id="activity_id">
                <input type="hidden" name="part_name" id="part_name">

                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Inspector
                            Client</label>
                        <input type="text" name="inspector_name" id="inspector_name" required
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">PIC
                            Metinca</label>
                        <input type="text" name="pic" id="pic" required
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status
                            Hasil</label>
                        <select name="result" id="result"
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                            <option value="OK">ALL ACCEPTED</option>
                            <option value="PA">PARTIAL ACCEPTED</option>
                            <option value="OH">ON HOLD</option>
                            <option value="NG">REJECTED</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Catatan /
                            Remarks</label>
                        <textarea name="remarks" id="remarks" rows="2"
                            class="w-full bg-slate-50 border-none rounded-2xl p-4 text-sm font-bold focus:ring-2 focus:ring-indigo-500 transition-all"></textarea>
                    </div>
                </div>

                <div class="pt-4 flex gap-3">
                    <button type="button" id="closeResultModal"
                        class="flex-1 py-4 text-sm font-black text-slate-400 hover:text-slate-600 transition-all uppercase">Batal</button>
                    <button type="submit" id="submitResultBtn"
                        class="flex-[2] py-4 bg-indigo-600 text-white rounded-2xl text-sm font-black shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition-all uppercase tracking-widest">Simpan
                        Data</button>
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
        $(document).ready(function() {
            // 1. Simpan data global
            const resultsData = @json($resultsData);
            const userIsLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

            // 2. Inisialisasi Kalender
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: window.innerWidth < 768 ? 'listWeek' : 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                },
                events: [
                    @foreach ($activities as $activity)
                        @php
                            $start = \Carbon\Carbon::parse($activity->start_date);
                            $end = \Carbon\Carbon::parse($activity->end_date);
                            $color = ['Done' => '#10B981', 'On Going' => '#F59E0B', 'Reschedule' => '#F43F5E'][$activity->status] ?? '#4F46E5';
                        @endphp
                        @for ($d = $start->copy(); $d->lte($end); $d->addDay())
                            @if (!$d->isWeekend())
                                {
                                    id: '{{ $activity->id }}',
                                    title: '{{ $activity->kegiatan }}',
                                    start: '{{ $d->toDateString() }}',
                                    backgroundColor: '{{ $color }}',
                                    extendedProps: {
                                        db_id: '{{ $activity->id }}',
                                        customer: '{{ $activity->customer ?? '-' }}',
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

                    // Isi Data Modal
                    $('#mTitle').text(info.event.title);
                    $('#mPO').text(p.po);
                    $('#mCustomer').text(p.customer);
                    $('#mTime').text(info.event.start.toLocaleDateString('id-ID', {
                        dateStyle: 'long'
                    }));
                    $('#mStatus').text(p.status);

                    const itemsContainer = $('#mItems').empty();
                    let okCount = 0;

                    if (p.items && p.items.length > 0) {
                        p.items.forEach(item => {
                            const found = resultsData.find(r => r.activity_id == p.db_id && r
                                .part_name == item.part_name);
                            if (found?.result === 'OK') okCount++;

                            const resMap = {
                                'OK': {
                                    c: 'text-emerald-500 bg-emerald-50',
                                    l: 'Accepted'
                                },
                                'PA': {
                                    c: 'text-blue-500 bg-blue-50',
                                    l: 'Partial'
                                },
                                'NG': {
                                    c: 'text-rose-500 bg-rose-50',
                                    l: 'Rejected'
                                }
                            } [found?.result] || {
                                c: 'text-slate-400 bg-slate-50',
                                l: 'Pending'
                            };

                            // PERHATIKAN: Kita gunakan class 'btn-update' dan 'btn-detail' (Bukan onclick)
                            itemsContainer.append(`
                        <div class="bg-white border border-slate-100 p-6 rounded-[2rem] flex flex-col md:flex-row justify-between items-center gap-6 group hover:border-indigo-100 transition-all">
                            <div class="text-center md:text-left">
                                <div class="flex items-center gap-2 mb-2 justify-center md:justify-start">
                                    <span class="px-2 py-0.5 rounded-lg text-[9px] font-black uppercase ${resMap.c}">${resMap.l}</span>
                                </div>
                                <h5 class="text-lg font-black text-slate-800 uppercase tracking-tight">${item.part_name}</h5>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">${item.material || '-'} • ${item.qty || 0} PCS</p>
                            </div>
                            <div class="flex gap-2 w-full md:w-auto">
                                ${userIsLoggedIn ? `<button class="btn-update flex-1 md:flex-none px-6 py-3 bg-indigo-50 text-indigo-600 text-[10px] font-black rounded-2xl hover:bg-indigo-600 hover:text-white transition-all" 
                                        data-id="${p.db_id}" data-part="${item.part_name}">UPDATE</button>` : ''}
                                <button class="btn-detail flex-1 md:flex-none px-6 py-3 bg-slate-50 text-slate-500 text-[10px] font-black rounded-2xl hover:bg-slate-900 hover:text-white transition-all"
                                    data-id="${p.db_id}" data-part="${item.part_name}">DETAIL</button>
                            </div>
                        </div>
                    `);
                        });

                        const pct = Math.round((okCount / p.items.length) * 100);
                        $('#mPercentText').text(pct + '%');
                        setTimeout(() => $('#mProgressBar').css('width', pct + '%'), 200);
                    }

                    // Tampilkan Modal Utama
                    $('#modal').removeClass('hidden').addClass('flex');
                    setTimeout(() => $('#modalContent').removeClass('scale-95 opacity-0').addClass(
                        'scale-100 opacity-100'), 10);
                }
            });
            calendar.render();

            // 3. EVENT DELEGATION (PENTING!)
            // Mendengarkan klik pada tombol Update
            $(document).on('click', '.btn-update', function() {
                const actId = $(this).data('id');
                const part = $(this).data('part');

                $('#resultForm')[0].reset();
                $('#activity_id').val(actId);
                $('#part_name').val(part);
                $('#display_part_name').text(part);

                const found = resultsData.find(r => r.activity_id == actId && r.part_name == part);
                if (found) {
                    $('#result_id').val(found.id);
                    $('#inspector_name').val(found.inspector_name);
                    $('#pic').val(found.pic);
                    $('#result').val(found.result);
                    $('#remarks').val(found.remarks || '');
                }

                $('#resultModal').removeClass('hidden').addClass('flex');
                setTimeout(() => $('#resultModal > div').removeClass('scale-95 opacity-0').addClass(
                    'scale-100 opacity-100'), 10);
            });

            // Mendengarkan klik pada tombol Detail
            $(document).on('click', '.btn-detail', function() {
                const actId = $(this).data('id');
                const part = $(this).data('part');
                const matches = resultsData.filter(r => r.activity_id == actId && r.part_name == part);

                let htmlContent = '';
                if (matches.length === 0) {
                    htmlContent =
                        '<div class="p-6 text-center text-slate-400 italic">Belum ada riwayat inspeksi.</div>';
                } else {
                    matches.forEach(m => {
                        htmlContent += `
                <div class="text-left bg-slate-50 p-6 rounded-[2rem] border border-slate-100 mb-4 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <span class="px-3 py-1 rounded-full bg-indigo-600 text-white text-[9px] font-black uppercase tracking-widest">${m.result}</span>
                        <span class="text-[10px] font-bold text-slate-400">${m.inspection_time || '-'}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4 text-xs">
                        <div><p class="font-black text-slate-300 uppercase text-[9px]">Inspector</p><p class="font-bold text-slate-700">${m.inspector_name}</p></div>
                        <div><p class="font-black text-slate-300 uppercase text-[9px]">PIC</p><p class="font-bold text-slate-700">${m.pic}</p></div>
                    </div>
                    <div><p class="font-black text-slate-300 uppercase text-[9px]">Catatan</p><p class="italic text-slate-600">${m.remarks || '-'}</p></div>
                </div>`;
                    });
                }

                Swal.fire({
                    title: `<div class="text-xl font-black uppercase tracking-tighter">${part}</div>`,
                    html: `<div class="max-h-[400px] overflow-y-auto mt-4 px-2 custom-scroll">${htmlContent}</div>`,
                    showConfirmButton: false,
                    showCloseButton: true,
                    customClass: {
                        popup: 'rounded-[3rem] p-8'
                    }
                });
            });

            // 4. Close Modal Handlers
            $('#closeModal, #closeModal2').click(function() {
                $('#modalContent').addClass('scale-95 opacity-0').removeClass('scale-100 opacity-100');
                setTimeout(() => $('#modal').addClass('hidden').removeClass('flex'), 250);
            });

            $('#closeResultModal').click(function() {
                $('#resultModal > div').addClass('scale-95 opacity-0').removeClass('scale-100 opacity-100');
                setTimeout(() => $('#resultModal').addClass('hidden').removeClass('flex'), 250);
            });
        });
    </script>
@endpush
