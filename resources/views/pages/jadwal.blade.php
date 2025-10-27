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
                            <span class="text-sky-600 font-medium w-16">
                                {{ \Carbon\Carbon::parse($activity->start_date)->format('d M') }} -
                                {{ \Carbon\Carbon::parse($activity->end_date)->format('d M') }}
                            </span>
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

    <!-- Modal Utama (lihat event & items) -->
    <div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div id="modalContent"
            class="bg-white rounded-2xl w-full max-w-md max-h-[85vh] p-6 transform scale-90 opacity-0 transition-all duration-300 ease-out overflow-y-auto shadow-2xl">
            <div class="flex justify-between items-center border-b pb-3 mb-4">
                <h3 id="mTitle" class="font-semibold text-lg text-slate-800">Event Title</h3>
                <button id="closeModal" class="text-slate-400 hover:text-red-500 text-xl font-bold">✕</button>
            </div>

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
                    </div>
                </div>

                <div class="col-span-2">
                    <div class="text-slate-500">Detail Items</div>
                    <div id="mItems" class="mt-1 space-y-1 text-slate-700 text-sm leading-relaxed"></div>
                </div>
            </div>
            <!-- Progress Container -->
            <div id="mProgressContainer" class="mt-4 hidden">
                <label class="text-sm text-slate-600 mb-1 block">Progress</label>
                <div class="w-full bg-gray-200 rounded-full h-5 overflow-hidden relative">
                    <div id="mProgressBar"
                        class="h-full w-0 flex items-center justify-end pr-2 text-white font-semibold text-xs rounded-full"
                        style="background: linear-gradient(90deg, #10B981, #3B82F6); transition: width 1s ease-in-out;">
                        0%
                    </div>
                </div>
            </div>


            <div class="mt-6 flex justify-end">
                <button id="closeModal2"
                    class="px-4 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal Input / Edit Hasil Pemeriksaan -->
    <div id="resultModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div
            class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl transform scale-90 opacity-0 transition-all duration-300 ease-out overflow-y-auto">
            <h3 class="font-semibold text-lg mb-4 text-slate-800">Input Hasil Pemeriksaan</h3>

            <form id="resultForm" method="POST" action="{{ route('jadwal.store') }}">
                @csrf
                <input type="hidden" name="result_id" id="result_id">
                <input type="hidden" name="activity_id" id="activity_id">

                <div class="mb-3">
                    <label class="text-sm text-slate-600">Nama Inspektur</label>
                    <input type="text" name="inspector_name" id="inspector_name"
                        class="form-control w-full border rounded-lg p-2" required>
                </div>
                <div class="mb-3">
                    <label class="text-sm text-slate-600">Nama PIC</label>
                    <input type="text" name="pic" id="pic" class="form-control w-full border rounded-lg p-2"
                        required>
                </div>

                <div class="mb-3">
                    <label class="text-sm text-slate-600">Nama Part</label>
                    <input type="text" readonly name="part_name" id="part_name"
                        class="form-control w-full border rounded-lg p-2">
                </div>

                <div class="mb-3">
                    <label class="text-sm text-slate-600">Material</label>
                    <input type="text" readonly name="material" id="material"
                        class="form-control w-full border rounded-lg p-2">
                </div>

                <div class="mb-3">
                    <label class="text-sm text-slate-600">Qty</label>
                    <input type="number" readonly name="qty" id="qty"
                        class="form-control w-full border rounded-lg p-2">
                </div>

                <div class="mb-3">
                    <label class="text-sm text-slate-600">Hasil</label>
                    <select name="result" id="result" class="form-control w-full border rounded-lg p-2" required>
                        <option value="OK">OK</option>
                        <option value="NG">NG</option>
                        <option value="Rework">Rework</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="text-sm text-slate-600">Catatan</label>
                    <textarea name="remarks" id="remarks" class="form-control w-full border rounded-lg p-2"></textarea>
                </div>

                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" id="closeResultModal"
                        class="px-4 py-2 bg-slate-100 rounded-lg hover:bg-slate-200 text-slate-700">Batal</button>
                    <button type="submit" id="submitResultBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal View Hasil Pemeriksaan (rendered server-side) -->
    <div id="viewResultModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div
            class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl transform scale-90 opacity-0 transition-all duration-300 ease-out overflow-y-auto">
            <h3 class="font-semibold text-lg mb-4 text-slate-800">Hasil Pemeriksaan</h3>

            <div id="viewResultBody" class="space-y-3">
                {{-- server-side rendered list (all results) --}}
                @forelse($activityResults as $result)
                    <div class="result-row " data-activity-id="{{ $result->activity_id }}"
                        data-part-name="{{ $result->part_name }}">
                        <div class="border p-3 rounded-lg">
                            <div><strong>Inspektur:</strong> {{ $result->inspector_name }}</div>
                            <div><strong>PIC:</strong> {{ $result->pic }}</div>
                            <div><strong>Waktu:</strong> {{ $result->inspection_time }}</div>
                            <div><strong>Hasil:</strong> {{ $result->result }}</div>
                            <div><strong>Status:</strong> {{ $result->status }}</div>
                            <div><strong>Catatan:</strong> {{ $result->remarks ?? '-' }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-slate-500 italic">Belum ada hasil pemeriksaan.</p>
                @endforelse
            </div>

            <div class="mt-4 flex justify-end">
                <button id="closeViewResultModal"
                    class="px-4 py-2 bg-slate-100 rounded-lg hover:bg-slate-200 text-slate-700">Tutup</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- Data dari server ---
            const resultsData = @json($resultsData);

            // --- Elemen DOM ---
            const calendarEl = document.getElementById('calendar');
            const modal = document.getElementById('modal');
            const modalContent = document.getElementById('modalContent');
            const resultModal = document.getElementById('resultModal');
            const viewResultModal = document.getElementById('viewResultModal');

            // --- Helper Modal ---
            function showModal(el, contentEl) {
                el.classList.remove('hidden');
                setTimeout(() => {
                    el.classList.add('flex');
                    if (contentEl) {
                        contentEl.classList.remove('opacity-0', 'scale-90');
                        contentEl.classList.add('opacity-100', 'scale-100');
                    }
                }, 10);
            }

            function hideModal(el, contentEl) {
                if (contentEl) {
                    contentEl.classList.remove('opacity-100', 'scale-100');
                    contentEl.classList.add('opacity-0', 'scale-90');
                }
                setTimeout(() => {
                    el.classList.add('hidden');
                    el.classList.remove('flex');
                }, 200);
            }

            // --- Close buttons ---
            document.getElementById('closeModal')?.addEventListener('click', () => hideModal(modal, modalContent));
            document.getElementById('closeModal2')?.addEventListener('click', () => hideModal(modal, modalContent));
            modal.addEventListener('click', e => {
                if (e.target === modal) hideModal(modal, modalContent);
            });

            document.getElementById('closeResultModal')?.addEventListener('click', () => hideModal(resultModal,
                resultModal.querySelector('.bg-white')));
            resultModal.addEventListener('click', e => {
                if (e.target === resultModal) hideModal(resultModal, resultModal.querySelector(
                    '.bg-white'));
            });

            document.getElementById('closeViewResultModal')?.addEventListener('click', () => hideModal(
                viewResultModal, viewResultModal.querySelector('.bg-white')));
            viewResultModal.addEventListener('click', e => {
                if (e.target === viewResultModal) hideModal(viewResultModal, viewResultModal.querySelector(
                    '.bg-white'));
            });

            // --- Modal Input/Edit Hasil ---
            function openResultModal(activity, item) {
                const activityId = activity.id;
                const partName = item.part_name || '';

                // Reset form
                const form = document.getElementById('resultForm');
                form.reset();
                document.getElementById('result_id').value = '';
                document.getElementById('activity_id').value = activityId;
                document.getElementById('part_name').value = partName;
                document.getElementById('material').value = item.material || '';
                document.getElementById('qty').value = item.qty || '';

                const submitBtn = document.getElementById('submitResultBtn');

                // Cek apakah sudah ada hasil
                const found = resultsData.find(r => r.activity_id == activityId && r.part_name == partName);
                if (found) {
                    document.getElementById('result_id').value = found.id;
                    document.getElementById('inspector_name').value = found.inspector_name || '';
                    document.getElementById('pic').value = found.pic || '';
                    document.getElementById('material').value = found.material || '';
                    document.getElementById('qty').value = found.qty || '';
                    document.getElementById('result').value = found.result || 'OK';
                    document.getElementById('remarks').value = found.remarks || '';
                    submitBtn.innerText = 'Perbarui';
                } else {
                    submitBtn.innerText = 'Simpan';
                }

                showModal(resultModal, resultModal.querySelector('.bg-white'));
            }

            // --- Modal Lihat Hasil ---
            function openViewResultModal(activityId, partName) {
                const body = document.getElementById('viewResultBody');
                body.innerHTML = '';

                const matches = resultsData.filter(r => r.activity_id == activityId && r.part_name == partName);

                if (matches.length === 0) {
                    body.innerHTML =
                        '<p class="text-center text-slate-500 italic">Belum ada hasil pemeriksaan.</p>';
                } else {
                    matches.forEach(m => {
                        const div = document.createElement('div');
                        div.classList.add('border', 'p-3', 'rounded-lg');
                        div.innerHTML = `
                    <div><strong>Part Name:</strong> ${m.part_name}</div>
                    <div><strong>Material:</strong> ${m.material}</div>
                    <div><strong>Qty:</strong> ${m.qty}</div>
                    <div><strong>Inspektor:</strong> ${m.inspector_name}</div>
                    <div><strong>PIC:</strong> ${m.pic}</div>
                    <div><strong>Hasil:</strong> ${m.result}</div>
                    <div><strong>Status:</strong> ${m.status}</div>
                    <div><strong>Catatan:</strong> ${m.remarks || '-'}</div>
                `;
                        body.appendChild(div);
                    });
                }

                showModal(viewResultModal, viewResultModal.querySelector('.bg-white'));
            }

            function expandRange(activity) {
                const events = [];
                let start = new Date(activity.start_date);
                let end = new Date(activity.end_date);
                end.setDate(end.getDate() + 1); // include end date

                for (let d = new Date(start); d < end; d.setDate(d.getDate() + 1)) {
                    const dateStr = d.toISOString().split('T')[0]; // hanya YYYY-MM-DD
                    events.push({
                        id: activity.id + '-' + dateStr,
                        title: activity.kegiatan,
                        start: dateStr, // HANYA tanggal
                        end: dateStr, // HANYA tanggal
                        allDay: true, // pastikan full day event
                        extendedProps: {
                            id: activity.id,
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
                    kegiatan: '{!! addslashes($activity->kegiatan) !!}',
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
                    let color = '#6B7280'; // Default Pending (Gray)

                    if (type === 'Pending') color = '#6B7280'; // Gray
                    if (type === 'On Going') color = '#F59E0B'; // Orange
                    if (type === 'Reschedule') color = '#EF4444'; // Red
                    if (type === 'Done') color = '#10B981'; // Green

                    info.el.style.backgroundColor = color;
                    info.el.style.borderColor = color;
                },
                eventClick: function(info) {
                    const ev = info.event;

                    // --- Isi data modal utama ---
                    document.getElementById('mTitle').innerText = ev.title;
                    document.getElementById('mCustomer').innerText = ev.extendedProps.customer || '-';
                    document.getElementById('mType').innerText = ev.extendedProps.type || '-';
                    document.getElementById('mTime').innerText = ev.start ? ev.start.toLocaleDateString(
                        'id-ID') : '-';
                    document.getElementById('mPO').innerText = ev.extendedProps.po || '-';
                    document.getElementById('mStatus').innerText = ev.extendedProps.status || '-';

                    // --- Items ---
                    const itemsDiv = document.getElementById('mItems');
                    itemsDiv.innerHTML = '';

                    if (ev.extendedProps.items && ev.extendedProps.items.length > 0) {
                        const scrollDiv = document.createElement('div');
                        scrollDiv.style.maxHeight = '300px';
                        scrollDiv.style.overflowY = 'auto';

                        ev.extendedProps.items.forEach(item => {
                            const itemContainer = document.createElement('div');
                            itemContainer.classList.add('border', 'p-2', 'mb-2', 'rounded',
                                'flex', 'justify-between', 'items-start', 'gap-2');

                            // --- LEFT: Info item + badge status ---
                            const left = document.createElement('div');

                            // Ambil status item dari resultsData
                            const foundResult = resultsData.find(r => r.activity_id == ev
                                .extendedProps.id && r.part_name == item.part_name);
                            const status = foundResult ? foundResult.result : '-';

                            // Tentukan warna badge
                            let badgeText = status;
                            let badgeColor = 'gray';

                            if (status === 'OK') {
                                badgeColor = 'green';
                            } else if (status === 'NG') {
                                badgeColor = 'orange';
                            } else if (status === 'Rework') {
                                badgeColor = 'red';
                            } else {
                                badgeText = 'Belum Diperiksa'; // teks default
                                badgeColor = 'gray';
                            }

                            const statusBadge =
                                `<span class="px-2 py-1 rounded text-white text-xs" style="background-color:${badgeColor}">${badgeText}</span>`;

                            left.innerHTML = `
                <div><strong>Part:</strong> ${item.part_name || '-'}</div>
                <div><strong>Material:</strong> ${item.material || '-'}</div>
                <div><strong>Qty:</strong> ${item.qty || '-'}</div>
                <div><strong>Remarks:</strong> ${item.remarks || '-'}</div>
                <div><strong>Status:</strong> ${statusBadge}</div>
            `;

                            // --- RIGHT: Button ---
                            const right = document.createElement('div');
                            right.classList.add('flex', 'flex-col', 'gap-1');

                            const userIsLoggedIn = {!! Auth::check() ? 'true' : 'false' !!};

                            if (userIsLoggedIn) {
                                const inputBtn = document.createElement('button');
                                inputBtn.innerText = 'Input / Edit Hasil';
                                inputBtn.classList.add('bg-blue-600', 'text-white', 'text-xs',
                                    'px-2', 'py-1', 'rounded', 'hover:bg-blue-700');
                                inputBtn.addEventListener('click', () => openResultModal(ev
                                    .extendedProps, item));
                                right.appendChild(inputBtn);
                            }

                            const viewBtn = document.createElement('button');
                            viewBtn.innerText = 'Lihat Hasil';
                            viewBtn.classList.add('bg-gray-100', 'text-gray-700', 'text-xs',
                                'px-2', 'py-1', 'rounded', 'hover:bg-gray-200');
                            viewBtn.addEventListener('click', () => openViewResultModal(ev
                                .extendedProps.id, item.part_name));
                            right.appendChild(viewBtn);

                            itemContainer.appendChild(left);
                            itemContainer.appendChild(right);
                            scrollDiv.appendChild(itemContainer);
                        });

                        itemsDiv.appendChild(scrollDiv);

                        // --- Progress Bar ---
                        const progressContainer = document.getElementById('mProgressContainer');
                        const progressBar = document.getElementById('mProgressBar');

                        // Reset default
                        progressContainer.classList.add('hidden');
                        progressBar.style.width = '0%';
                        progressBar.innerText = '0%';

                        const items = ev.extendedProps.items;
                        const okCount = items.filter(item => {
                            const found = resultsData.find(r => r.activity_id == ev
                                .extendedProps.id && r.part_name == item.part_name);
                            return found && found.result === 'OK';
                        }).length;

                        const percent = Math.round((okCount / items.length) * 100);

                        if (percent > 0) {
                            progressContainer.classList.remove('hidden');

                            // Animasi progress
                            setTimeout(() => {
                                progressBar.style.width = percent + '%';
                                progressBar.innerText = percent + '%';
                            }, 50);
                        }

                    } else {
                        itemsDiv.innerHTML = '<p class="text-muted mb-0">Tidak ada items</p>';
                    }

                    showModal(modal, modalContent);
                }
            });

            calendar.render();

        });

        // Notifikasi sukses
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        @endif
    </script>
@endpush
