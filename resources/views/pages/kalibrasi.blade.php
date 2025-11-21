@extends('layouts.home')

@section('title', 'MCI | Portal Kalibrasi')

@push('css')
    <style>
        /* Small visual polish for table and controls */
        .summary-card {
            transition: transform .12s ease, box-shadow .12s ease;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .25rem .5rem;
            border-radius: .5rem;
            font-weight: 600;
            font-size: .85rem;
        }

        .badge-ok {
            background: #ecfdf5;
            color: #166534;
        }

        .badge-proses {
            background: #fffbeb;
            color: #92400e;
        }

        .badge-due {
            background: #fff1f2;
            color: #991b1b;
        }

        .badge-unknown {
            background: #f8fafc;
            color: #475569;
        }

        table tr.cursor-pointer {
            cursor: pointer;
        }

        table tr:hover td {
            background: rgba(59, 130, 246, .04);
        }

        .modal-backdrop {
            background: rgba(2, 6, 23, .6);
        }
    </style>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto py-10 px-4">
        <!-- Header -->
        <div class="text-center mb-6">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-blue-700 tracking-tight mb-2">🛠️ Portal Kalibrasi</h1>
            <p class="text-gray-500 text-sm sm:text-base">Pantau status kalibrasi alat, jadwal ulang, dan ringkasan status
                alat secara real-time.</p>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @php
                $statusOk = $statusOk ?? 0;
                $statusProses = $statusProses ?? 0;
                $dueSoon = $dueSoon ?? 0;
                $totalTools = $totalTools ?? 0;
            @endphp

            <div class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
                <p class="text-sm text-gray-500 mb-1">Total Item</p>
                <h3 class="text-2xl font-bold text-blue-700">{{ $totalTools }}</h3>
                <p class="text-xs text-gray-400 mt-1">Terdaftar</p>
            </div>
            <div class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
                <p class="text-sm text-gray-500 mb-1">Status OK</p>
                <h3 class="text-2xl font-bold text-green-700">{{ $statusOk }}</h3>
                <p class="text-xs text-gray-400 mt-1">Siap pakai</p>
            </div>
            <div class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
                <p class="text-sm text-gray-500 mb-1">Proses Kalibrasi</p>
                <h3 class="text-2xl font-bold text-amber-600">{{ $statusProses }}</h3>
                <p class="text-xs text-gray-400 mt-1">Sedang dikerjakan</p>
            </div>
            <div class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
                <p class="text-sm text-gray-500 mb-1">Akan Jatuh Tempo &lt; 30 Hari</p>
                <h3 class="text-2xl font-bold text-red-600">{{ $dueSoon }}</h3>
                <p class="text-xs text-gray-400 mt-1">Perlu perhatian</p>
            </div>
        </div>

        <!-- Controls -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 mb-4">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <input id="searchInput" type="search" placeholder="Cari nama, merk, seri..."
                    class="w-full sm:w-72 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-200" />
                <select id="statusFilter" class="px-3 py-2 rounded-lg border border-gray-200">
                    <option value="">Semua Status</option>
                    <option value="OK">OK</option>
                    <option value="Proses">Proses</option>
                    <option value="Jatuh Tempo">Jatuh Tempo</option>
                </select>
            </div>
            <div class="flex items-center gap-2">
                {{-- <button id="exportCsvBtn"
                    class="inline-flex items-center gap-2 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700">↓
                    Export CSV</button> --}}
                <button id="refreshBtn"
                    class="inline-flex items-center gap-2 bg-white border border-gray-200 px-3 py-2 rounded-lg hover:bg-gray-50">↻
                    Refresh</button>
                {{-- <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                    <input id="autoRefresh" type="checkbox" class="rounded" />
                    Auto-refresh (30s)
                </label> --}}
            </div>
        </div>
        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
            <div class="bg-white border border-blue-100 shadow rounded-xl p-6">
                <h2 class="text-lg font-semibold text-blue-700 mb-4">📈 Ringkasan Status</h2>
                <div class="h-56 flex items-center justify-center">
                    <canvas id="statusPie" style="max-width:320px; width:100%; height:220px;"></canvas>
                </div>
                <div class="mt-3 flex items-center justify-center gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-green-600"></span> OK:
                        {{ $pieData['ok'] ?? 0 }}</div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-amber-500"></span> Proses:
                        {{ $pieData['proses'] ?? 0 }}</div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-600"></span> Jatuh Tempo:
                        {{ $pieData['due'] ?? 0 }}</div>
                </div>
            </div>

            <div class="bg-white border border-blue-100 shadow rounded-xl p-6">
                <h2 class="text-lg font-semibold text-blue-700 mb-4">🕒 Tren Jadwal</h2>
                <div class="h-56">
                    <canvas id="trendLine" style="width:100%; height:220px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white border border-blue-100 shadow rounded-xl p-4">
            <h2 class="text-lg font-semibold text-blue-700 mb-4">📋 Data Item</h2>
            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table id="toolsTable" class="min-w-full text-sm text-gray-700 border-collapse">
                    <thead class="bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-3 text-left w-12">No</th>
                            <th class="px-4 py-3 text-left">Nama Item</th>
                            <th class="px-4 py-3 text-left">Merk</th>
                            <th class="px-4 py-3 text-left">Status Kalibrasi</th>
                            <th class="px-4 py-3 text-left">Tanggal Kalibrasi</th>
                            <th class="px-4 py-3 text-left">Tanggal Kalibrasi Ulang</th>
                            <th class="px-4 py-3 text-left">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="toolsTbody" class="divide-y divide-gray-100 bg-white">
                        @forelse($tools as $index => $tool)
                            @php
                                $history = $tool->latestHistory;
                                $status = optional($history)->status_kalibrasi ?? '-';
                                if ($status === 'OK') {
                                    $statusClass = 'badge-status badge-ok';
                                } elseif ($status === 'Proses') {
                                    $statusClass = 'badge-status badge-proses';
                                } elseif ($status === 'Jatuh Tempo' || $status === 'Akan Jatuh Tempo') {
                                    $statusClass = 'badge-status badge-due';
                                } else {
                                    $statusClass = 'badge-status badge-unknown';
                                }

                                // Buat array untuk @json
                                $toolJson = [
                                    'id' => $tool->id,
                                    'nama' => $tool->nama_alat,
                                    'merek' => $tool->merek,
                                    'no_seri' => $tool->no_seri,
                                    'history' => $history
                                        ? [
                                            'status' => $history->status_kalibrasi,
                                            'tgl_kalibrasi' => $history->tgl_kalibrasi
                                                ? $history->tgl_kalibrasi->format('d/m/Y')
                                                : null,
                                            'tgl_kalibrasi_ulang' => $history->tgl_kalibrasi_ulang
                                                ? $history->tgl_kalibrasi_ulang->format('d/m/Y')
                                                : null,
                                            'keterangan' => $history->keterangan,
                                        ]
                                        : null,
                                ];
                            @endphp

                            <tr class="cursor-pointer" data-tool='@json($toolJson)'>
                                <td class="px-4 py-3 border align-top">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 border align-top">{{ $tool->nama_alat }}</td>
                                <td class="px-4 py-3 border align-top">{{ $tool->merek ?? '-' }}</td>
                                <td class="px-4 py-3 border align-top"><span
                                        class="{{ $statusClass }}">{{ $status }}</span></td>
                                <td class="px-4 py-3 border align-top">
                                    {{ optional($history)->tgl_kalibrasi ? $history->tgl_kalibrasi->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 border align-top">
                                    {{ optional($history)->tgl_kalibrasi_ulang ? $history->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 border align-top">{{ optional($history)->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-6 text-center text-gray-400">Tidak ada data alat.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div id="detailModal" class="fixed inset-0 hidden items-center justify-center z-50">
        <div class="absolute inset-0 modal-backdrop"></div>
        <div class="relative bg-white rounded-xl shadow-lg w-11/12 max-w-2xl p-6 z-10">
            <div class="flex justify-between items-start">
                <h3 id="modalTitle" class="text-lg font-semibold text-slate-700">Detail Alat</h3>
                <button id="modalClose" class="text-gray-400 hover:text-gray-600">✕</button>
            </div>
            <div id="modalBody" class="mt-4 text-sm text-slate-700 space-y-2"></div>
            <div class="mt-4 text-right">
                <button id="modalClose2" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Tutup</button>
            </div>
        </div>
    </div>

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            window._portalTools = @json($toolsData ?? []);
            window._pieData = @json($pieData ?? ['ok' => 0, 'proses' => 0, 'due' => 0]);
            window.__BAR_LABELS__ = @json($barLabels ?? []);
            window.__BAR_VALUES__ = @json($barValues ?? []);

            (function() {
                const toolsTbody = document.getElementById('toolsTbody');
                const searchInput = document.getElementById('searchInput');
                const statusFilter = document.getElementById('statusFilter');
                const exportCsvBtn = document.getElementById('exportCsvBtn');
                const refreshBtn = document.getElementById('refreshBtn');
                const autoRefreshCheckbox = document.getElementById('autoRefresh');
                const detailModal = document.getElementById('detailModal');
                const modalTitle = document.getElementById('modalTitle');
                const modalBody = document.getElementById('modalBody');
                const modalClose = document.getElementById('modalClose');
                const modalClose2 = document.getElementById('modalClose2');
                const statusPieEl = document.getElementById('statusPie');
                const trendLineEl = document.getElementById('trendLine');

                let toolsData = window._portalTools || [];

                function escapeHtml(s) {
                    return s ? String(s).replace(/[&<>"'`]/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;',
                '`': '&#96;'
                    } [m])) : '';
                }

                function rowMatchesFilter(rowEl, q, status) {
                    if (q && !rowEl.innerText.toLowerCase().includes(q.toLowerCase())) return false;
                    if (status) {
                        const cell = rowEl.querySelectorAll('td')[3];
                        if (!cell || !cell.innerText.toLowerCase().includes(status.toLowerCase())) return false;
                    }
                    return true;
                }

                function applyFilters() {
                    if (!toolsTbody) return;
                    const q = searchInput ? searchInput.value.trim() : '';
                    const status = statusFilter ? statusFilter.value : '';
                    const rows = Array.from(toolsTbody.querySelectorAll('tr'));
                    let visibleCount = 0;
                    rows.forEach(r => {
                        const tds = r.querySelectorAll('td');
                        if (tds.length === 1 && tds[0].hasAttribute('colspan')) return;
                        const ok = rowMatchesFilter(r, q, status);
                        r.style.display = ok ? '' : 'none';
                        if (ok) visibleCount++;
                    });
                    const noDataTd = toolsTbody.querySelector('tr td[colspan="7"]');
                    if (noDataTd) noDataTd.parentElement.style.display = visibleCount === 0 ? '' : 'none';
                }

                searchInput?.addEventListener('input', applyFilters);
                statusFilter?.addEventListener('change', applyFilters);

                exportCsvBtn?.addEventListener('click', () => {
                    try {
                        const headers = Array.from(document.querySelectorAll('#toolsTable thead th')).map(th => th
                            .innerText.trim());
                        const rows = [headers];
                        Array.from(toolsTbody.querySelectorAll('tr')).forEach(tr => {
                            if (tr.style.display === 'none') return;
                            const tds = Array.from(tr.querySelectorAll('td'));
                            if (tds.length === 1 && tds[0].hasAttribute('colspan')) return;
                            rows.push(tds.map(td => td.innerText.trim()));
                        });
                        const csv = rows.map(r => r.map(c => `"${c.replace(/"/g,'""')}"`).join(',')).join('\n');
                        const blob = new Blob([csv], {
                            type: 'text/csv;charset=utf-8;'
                        });
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.setAttribute('download', 'data-alat.csv');
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                    } catch (e) {
                        console.error(e);
                        alert('Gagal mengekspor CSV.');
                    }
                });

                refreshBtn?.addEventListener('click', () => window.location.reload());
                autoRefreshCheckbox?.addEventListener('change', function() {
                    if (this.checked) {
                        this.timer = setInterval(() => window.location.reload(), 30000);
                    } else {
                        clearInterval(this.timer);
                    }
                });

                function openModalWithTool(tool) {
                    if (!detailModal) return;
                    modalTitle.innerText = tool?.nama || 'Detail Alat';
                    modalBody.innerHTML = `
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div><strong>Nama:</strong><div class="text-sm mt-1">${escapeHtml(tool?.nama??'-')}</div></div>
            <div><strong>Merk:</strong><div class="text-sm mt-1">${escapeHtml(tool?.merek??'-')}</div></div>
            <div><strong>No. Seri:</strong><div class="text-sm mt-1">${escapeHtml(tool?.no_seri??'-')}</div></div>
            <div><strong>Status:</strong><div class="text-sm mt-1">${escapeHtml(tool?.history?.status??'-')}</div></div>
            <div><strong>Tgl. Kalibrasi:</strong><div class="text-sm mt-1">${escapeHtml(tool?.history?.tgl_kalibrasi??'-')}</div></div>
            <div><strong>Tgl. Kalibrasi Ulang:</strong><div class="text-sm mt-1">${escapeHtml(tool?.history?.tgl_kalibrasi_ulang??'-')}</div></div>
            <div class="sm:col-span-2"><strong>Keterangan:</strong><div class="text-sm mt-1">${escapeHtml(tool?.history?.keterangan??'-')}</div></div>
        </div>`;
                    detailModal.classList.remove('hidden');
                    detailModal.classList.add('flex');
                }

                function closeModal() {
                    detailModal.classList.add('hidden');
                    detailModal.classList.remove('flex');
                }
                toolsTbody?.parentElement?.addEventListener('click', e => {
                    const tr = e.target.closest('tr[data-tool]');
                    if (!tr) return;
                    const interactive = e.target.closest('button,a,input,select,textarea');
                    if (interactive) return;
                    const tool = JSON.parse(tr.getAttribute('data-tool'));
                    openModalWithTool(tool);
                });
                modalClose?.addEventListener('click', closeModal);
                modalClose2?.addEventListener('click', closeModal);
                detailModal?.addEventListener('click', e => {
                    if (e.target === detailModal) closeModal();
                });
                document.addEventListener('keydown', e => {
                    if (e.key === 'Escape') closeModal();
                });

                function initCharts() {
                    try {
                        const pd = window._pieData || {
                            ok: 0,
                            proses: 0,
                            due: 0
                        };
                        if (statusPieEl && window.Chart) {
                            const ctx = statusPieEl.getContext('2d');
                            if (statusPieEl.__chart) statusPieEl.__chart.destroy();
                            statusPieEl.__chart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['OK', 'Proses', 'Jatuh Tempo'],
                                    datasets: [{
                                        data: [pd.ok, pd.proses, pd.due],
                                        backgroundColor: ['#16a34a', '#f59e0b', '#dc2626']
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '55%'
                                }
                            });
                        }
                        const labels = window.__BAR_LABELS__ || [];
                        const values = window.__BAR_VALUES__ || [];
                        if (trendLineEl && window.Chart) {
                            const ctx2 = trendLineEl.getContext('2d');
                            if (trendLineEl.__chart) trendLineEl.__chart.destroy();
                            const grad = ctx2.createLinearGradient(0, 0, 0, 250);
                            grad.addColorStop(0, 'rgba(13,110,253,0.18)');
                            grad.addColorStop(1, 'rgba(13,110,253,0.02)');
                            trendLineEl.__chart = new Chart(ctx2, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: 'Alat Akan Jatuh Tempo',
                                        data: values,
                                        fill: true,
                                        backgroundColor: grad,
                                        borderColor: '#0d6efd'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false
                                }
                            });
                        }
                    } catch (e) {
                        console.error('Chart init error', e);
                    }
                }
                initCharts();

            })();
        </script>
    @endpush
@endsection
