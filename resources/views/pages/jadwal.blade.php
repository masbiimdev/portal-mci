@extends('layouts.home')
@section('title', 'MCI | Jadwal Kegiatan')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <style>
        .fc .fc-daygrid-day-top {
            padding: .5rem .6rem;
        }

        .event-badge {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: .5rem;
        }

        .modal-transition {
            transition: all 0.3s ease-in-out;
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto p-4 sm:p-6 grid grid-cols-1 lg:grid-cols-4 gap-6 mt-6">

        <!-- Sidebar -->
        <aside class="col-span-1 space-y-4 order-2 lg:order-1">
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <h2 class="font-medium">Ringkasan Jadwal</h2>
                <div class="mt-3 grid grid-cols-2 gap-3">
                    <div class="p-3 bg-sky-50 rounded">
                        <div class="text-sm text-slate-500">Event Hari Ini</div>
                        <div id="todayCount" class="text-xl font-semibold">{{ $todayCount ?? 0 }}</div>
                    </div>
                    <div class="p-3 bg-amber-50 rounded">
                        <div class="text-sm text-slate-500">Minggu Ini</div>
                        <div id="weekCount" class="text-xl font-semibold">{{ $weekCount ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm">
                <h2 class="font-medium mb-3">Jadwal Minggu Ini</h2>
                <ul id="weekEvents" class="space-y-3 text-sm">
                    @foreach ($weekActivities as $activity)
                        <li class="flex items-start gap-2 border-b pb-2">
                            <span
                                class="text-sky-600 font-medium w-16">{{ \Carbon\Carbon::parse($activity->start_date)->format('d M') }}
                                - {{ \Carbon\Carbon::parse($activity->end_date)->format('d M') }}</span>
                            <div>
                                <div class="font-medium">{{ $activity->kegiatan }}</div>
                                <div class="text-slate-500 text-xs">{{ $activity->customer ?? '-' }}</div>
                                <div class="text-slate-500 text-xs">{{ $activity->po ?? '-' }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        <!-- Kalender -->
        <section class="col-span-3 order-1 lg:order-2 bg-white p-4 rounded-lg shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                <h2 class="font-medium text-lg">Kalender Jadwal</h2>
            </div>
            <div id="calendar"></div>
        </section>
    </div>

    <!-- Modal -->
    <div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div id="modalContent"
            class="bg-white rounded-2xl w-full max-w-md max-h-[85vh] p-6 transform scale-90 opacity-0 transition-all duration-300 ease-out overflow-y-auto shadow-2xl">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 id="mTitle" class="font-semibold text-lg text-slate-800">Event Title</h3>
                <button id="closeModal"
                    class="text-slate-400 hover:text-red-500 transition-colors text-xl font-bold">✕</button>
            </div>

            <!-- Body -->
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <div class="text-slate-500">Tipe</div>
                    <div id="mType" class="font-medium text-slate-800"></div>
                </div>
                <div>
                    <div class="text-slate-500">Waktu</div>
                    <div id="mTime" class="font-medium text-slate-800"></div>
                </div>
                <div>
                    <div class="text-slate-500">Customer</div>
                    <div id="mCustomer" class="font-medium text-slate-800"></div>
                </div>
                <div>
                    <div class="text-slate-500">PO</div>
                    <div id="mPO" class="font-medium text-slate-800"></div>
                </div>
                <div class="col-span-2">
                    <div class="text-slate-500">Status</div>
                    <div id="mStatus"
                        class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                        <!-- isi status -->
                    </div>
                </div>
                <div class="col-span-2">
                    <div class="text-slate-500">Detail Items</div>
                    <div id="mItems" class="mt-1 space-y-1 text-slate-700 text-sm leading-relaxed">
                        <!-- Items dari JS -->
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 flex justify-end">
                <button id="closeModal2"
                    class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');

            // Helper untuk expand range
            function expandRange(activity) {
                let events = [];
                let start = new Date(activity.start_date);
                let end = new Date(activity.end_date);

                // FullCalendar "end" itu exclusive → tambahin 1 hari
                end.setDate(end.getDate() + 1);

                for (let d = new Date(start); d < end; d.setDate(d.getDate() + 1)) {
                    events.push({
                        id: activity.id + '-' + d.toISOString().split('T')[0],
                        title: activity.kegiatan,
                        start: new Date(d), // tiap hari masuk sebagai start baru
                        end: new Date(d), // end sama dengan start biar 1 hari
                        extendedProps: {
                            customer: activity.customer || '-',
                            type: activity.type,
                            po: activity.po || '',
                            status: activity.status,
                            items: activity.items || null
                        }
                    });
                }
                return events;
            }

            let initialEvents = [];
            @foreach ($activities as $activity)
                initialEvents = initialEvents.concat(expandRange({
                    id: '{{ $activity->id }}',
                    kegiatan: '{{ addslashes($activity->kegiatan) }}',
                    customer: '{{ $activity->customer ?? '' }}',
                    start_date: '{{ $activity->start_date }}',
                    end_date: '{{ $activity->end_date }}',
                    type: '{{ ucfirst($activity->type) }}',
                    po: '{{ $activity->po ?? '' }}',
                    status: '{{ $activity->status }}',
                    items: {!! $activity->items ?? 'null' !!}
                }));
            @endforeach

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: "dayGridMonth,dayGridWeek,dayGridDay"
                },
                events: initialEvents,
                eventDidMount: function(info) {
                    const type = info.event.extendedProps.status;
                    let color = '#2563EB';
                    if (type === 'Pending') color = '#059669';
                    if (type === 'On Going') color = '#F59E0B';
                    if (type === 'Reschedule') color = '#2563EB';
                    if (type === 'Done') color = '#EF4444';
                    info.el.style.backgroundColor = color;
                    info.el.style.borderColor = color;
                },
                eventClick: function(info) {
                    const ev = info.event;
                    document.getElementById('mTitle').innerText = ev.title;
                    document.getElementById('mCustomer').innerText = ev.extendedProps.customer || '-';
                    document.getElementById('mType').innerText = ev.extendedProps.type || '-';
                    const opts = {
                        day: 'numeric',
                        month: 'short',
                        year: 'numeric'
                    };
                    document.getElementById('mTime').innerText = ev.start ? ev.start.toLocaleDateString(
                        'id-ID', opts) : '-';
                    document.getElementById('mPO').innerText = ev.extendedProps.po || '-';
                    document.getElementById('mStatus').innerText = ev.extendedProps.status || '-';

                    // Items
                    const itemsDiv = document.getElementById('mItems');
                    itemsDiv.innerHTML = '';
                    const scrollDiv = document.createElement('div');
                    scrollDiv.style.maxHeight = '300px';
                    scrollDiv.style.overflowY = 'auto';

                    if (ev.extendedProps.items && ev.extendedProps.items.length > 0) {
                        ev.extendedProps.items.forEach(item => {
                            const itemHTML = `
                            <div class="border p-2 mb-2 rounded">
                                <div><strong>Part:</strong> ${item.part_name || '-'}</div>
                                <div><strong>Material:</strong> ${item.material || '-'}</div>
                                <div><strong>Qty:</strong> ${item.qty || '-'}</div>
                                <div><strong>Heat No:</strong> ${item.heat_no || '-'}</div>
                                <div><strong>Remarks:</strong> ${item.remarks || '-'}</div>
                            </div>`;
                            scrollDiv.innerHTML += itemHTML;
                        });
                    } else {
                        scrollDiv.innerHTML = '<p class="text-muted mb-0">Tidak ada items</p>';
                    }

                    itemsDiv.appendChild(scrollDiv);
                    showModal();
                }
            });

            calendar.render();

            function showModal() {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.add('flex');
                    modalContent.classList.remove('opacity-0', 'scale-95');
                    modalContent.classList.add('opacity-100', 'scale-100');
                }, 10);
            }

            function hideModal() {
                modalContent.classList.remove('opacity-100', 'scale-100');
                modalContent.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 300);
            }

            document.getElementById('closeModal').addEventListener('click', hideModal);
            document.getElementById('closeModal2').addEventListener('click', hideModal);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) hideModal();
            });
        });
    </script>
@endpush
