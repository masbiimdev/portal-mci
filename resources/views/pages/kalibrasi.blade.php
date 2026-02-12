@extends('layouts.home')

@section('title', 'MCI | Portal Kalibrasi')

@push('css')
    <style>
        /* Card hover */
        .summary-card {
            transition: transform .12s ease, box-shadow .12s ease;
        }

        .summary-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(15, 23, 42, .08);
        }

        /* Status badges */
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

        /* Table visuals: sticky header, zebra rows, responsive */
        .table-wrapper {
            overflow: auto;
            border-radius: .5rem;
        }

        table.tools-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        table.tools-table thead th {
            position: sticky;
            top: 0;
            z-index: 10;
            background: linear-gradient(90deg, #0ea5e9, #0284c7);
            color: #fff;
            padding: .75rem 1rem;
            text-align: left;
        }

        table.tools-table th,
        table.tools-table td {
            padding: .75rem 1rem;
            border-bottom: 1px solid #eef2ff;
            text-align: left;
            vertical-align: top;
        }

        table.tools-table tbody tr:nth-child(odd) td {
            background: #fff;
        }

        table.tools-table tbody tr:hover td {
            background: rgba(59, 130, 246, .04);
        }

        /* Action button */
        .btn-detail {
            background: #0ea5e9;
            color: #fff;
            padding: .35rem .6rem;
            border-radius: .5rem;
            font-size: .85rem;
            border: none;
            cursor: pointer;
        }

        .btn-detail:hover {
            background: #0284c7;
        }

        /* Modal tweaks */
        .modal-backdrop {
            background: rgba(2, 6, 23, .6);
        }

        #detailModal .modal-card {
            max-height: 80vh;
            overflow: auto;
        }

        /* Pagination controls */
        .pagination {
            display: flex;
            gap: .5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .pagination button {
            padding: .4rem .6rem;
            border-radius: .4rem;
            border: 1px solid #e6edf4;
            background: #fff;
            cursor: pointer;
        }

        .pagination button.active {
            background: #0ea5e9;
            color: #fff;
            border-color: #0ea5e9;
        }

        .controls-row {
            display: flex;
            gap: .5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        @media (max-width: 640px) {
            .controls-row {
                flex-direction: column;
                align-items: stretch;
            }
        }

        /* Notice banner */
        .notice {
            background: linear-gradient(90deg, #fff7ed, #fff1f2);
            border-left: 4px solid #fb923c;
            padding: .75rem 1rem;
            border-radius: .5rem;
            color: #92400e;
            margin-bottom: 1rem;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
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

        <!-- Notice: effective date -->
        <div class="notice" role="status" aria-live="polite">
            <strong>Perhatian:</strong>
            Sistem ini mulai aktif pada Oktober 2025. Data kalibrasi sebelum periode tersebut mungkin tidak tersedia dalam
            aplikasi karena perbedaan metode pencatatan sebelumnya.”
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
                <p class="text-sm text-gray-500 mb-1">Penjadwalan &lt; 15 Hari</p>
                <h3 class="text-2xl font-bold text-red-600">{{ $dueSoon }}</h3>
                <p class="text-xs text-gray-400 mt-1">Perlu perhatian</p>
            </div>
        </div>

        <!-- Controls: search, filter, per-page, export, refresh -->
        <div class="controls-row mb-4 justify-between">
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <input id="searchInput" type="search" placeholder="Cari nama, merk, seri..."
                    class="w-full sm:w-72 px-3 py-2 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    aria-label="Cari alat" />
                <select id="statusFilter" class="px-3 py-2 rounded-lg border border-gray-200" aria-label="Filter status">
                    <option value="">Semua Status</option>
                    <option value="OK">OK</option>
                    <option value="PROSES">Proses</option>
                    <option value="DUE SOON">Penjadwalan</option>
                </select>
                <select id="perPage" class="px-3 py-2 rounded-lg border border-gray-200" title="Rows per page"
                    aria-label="Baris per halaman">
                    <option value="10">10 / halaman</option>
                    <option value="25">25 / halaman</option>
                    <option value="50">50 / halaman</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button id="refreshBtn"
                    class="inline-flex items-center gap-2 bg-white border border-gray-200 px-3 py-2 rounded-lg hover:bg-gray-50"
                    aria-label="Refresh halaman">↻ Refresh</button>
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
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-600"></span> Penjadwalan:
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
        <div class="bg-white border border-blue-100 shadow rounded-xl p-4 mt-6">
            <h2 class="text-lg font-semibold text-blue-700 mb-4">📋 Data Item</h2>

            <div class="table-wrapper" role="region" aria-labelledby="tableDescription">
                <table id="toolsTable" class="tools-table" aria-describedby="tableDescription" role="table">
                    <caption id="tableDescription" class="sr-only">Daftar alat dan status kalibrasi</caption>
                    <thead>
                        <tr role="row">
                            <th scope="col">No</th>
                            <th scope="col">Nama Item</th>
                            <th scope="col">No Seri</th>
                            <th scope="col">Merk</th>
                            <th scope="col">Status Kalibrasi</th>
                            <th scope="col">Tanggal Kalibrasi</th>
                            <th scope="col">Tanggal Kalibrasi Ulang</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="toolsTbody" class="bg-white">
                        @php
                            // prepare $toolsData for JS safely
                            $toolsData = $tools
                                ->map(function ($t, $i) {
                                    $history = optional($t->latestHistory);
                                    return [
                                        'id' => $t->id,
                                        'nama' => $t->nama_alat ?? '',
                                        'merek' => $t->merek ?? '',
                                        'no_seri' => $t->no_seri ?? '',
                                        'status' => $history->status_kalibrasi ?? '-',
                                        'tgl_kalibrasi' => $history->tgl_kalibrasi
                                            ? $history->tgl_kalibrasi->format('d/m/Y')
                                            : null,
                                        'tgl_kalibrasi_ulang' => $history->tgl_kalibrasi_ulang
                                            ? $history->tgl_kalibrasi_ulang->format('d/m/Y')
                                            : null,
                                        'keterangan' => $history->keterangan ?? '',
                                    ];
                                })
                                ->toArray();
                        @endphp

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

                            <tr data-tool='@json($toolJson)' role="row">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ e($tool->nama_alat) }}</td>
                                <td>{{ e($tool->no_seri) }}</td>
                                <td>{{ e($tool->merek ?? '-') }}</td>
                                <td><span class="{{ $statusClass }}"
                                        aria-label="Status {{ $status }}">{{ $status }}</span></td>
                                <td>{{ optional($history)->tgl_kalibrasi ? $history->tgl_kalibrasi->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ optional($history)->tgl_kalibrasi_ulang ? $history->tgl_kalibrasi_ulang->format('d/m/Y') : '-' }}
                                </td>
                                <td>{{ optional($history)->keterangan ?? '-' }}</td>
                                <td>
                                    <button type="button" class="btn-detail" data-action="detail"
                                        aria-label="Lihat detail item {{ $tool->nama_alat }}">Detail</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-6 text-center text-gray-400">Tidak ada data alat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination (client-side) -->
            <div class="mt-4 flex items-center justify-between">
                <div id="paginationInfo" class="text-sm text-gray-600"></div>
                <div id="paginationControls" class="pagination" aria-label="Kontrol halaman"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="detailModal" class="fixed inset-0 hidden items-center justify-center z-50" role="dialog" aria-modal="true"
        aria-labelledby="modalTitle">
        <div class="absolute inset-0 modal-backdrop" aria-hidden="true"></div>
        <div class="relative modal-card bg-white rounded-xl shadow-lg w-11/12 max-w-2xl p-6 z-10">
            <div class="flex justify-between items-start">
                <h3 id="modalTitle" class="text-lg font-semibold text-slate-700">Detail Item</h3>
                <button id="modalClose" class="text-gray-400 hover:text-gray-600" aria-label="Tutup">✕</button>
            </div>
            <div id="modalBody" class="mt-4 text-sm text-slate-700 space-y-2"></div>
            <div class="mt-4 text-right">
                <button id="modalClose2" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Tutup</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Expose server data
        window._portalTools = @json($toolsData ?? []);
        window._pieData = @json($pieData ?? ['ok' => 0, 'proses' => 0, 'due' => 0]);
        window.__BAR_LABELS__ = @json($barLabels ?? []);
        window.__BAR_VALUES__ = @json($barValues ?? []);

        (function() {
            const toolsTbody = document.getElementById('toolsTbody');
            const searchInput = document.getElementById('searchInput');
            const statusFilter = document.getElementById('statusFilter');
            const perPageSelect = document.getElementById('perPage');
            const exportCsvBtn = document.getElementById('exportCsvBtn');
            const refreshBtn = document.getElementById('refreshBtn');
            const detailModal = document.getElementById('detailModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalBody = document.getElementById('modalBody');
            const modalClose = document.getElementById('modalClose');
            const modalClose2 = document.getElementById('modalClose2');
            const statusPieEl = document.getElementById('statusPie');
            const trendLineEl = document.getElementById('trendLine');
            const paginationControls = document.getElementById('paginationControls');
            const paginationInfo = document.getElementById('paginationInfo');

            // read rows (exclude no-data)
            let allRows = Array.from(toolsTbody ? toolsTbody.querySelectorAll('tr') : []);
            allRows = allRows.filter(r => {
                const tds = r.querySelectorAll('td');
                return !(tds.length === 1 && tds[0].hasAttribute('colspan'));
            });

            function escapeHtml(s) {
                if (s === null || s === undefined) return '';
                return String(s).replace(/[&<>"'`]/g, m => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;',
                '`': '&#96;'
                } [m]));
            }

            // Filtering and pagination state
            let filteredRows = allRows.slice();
            let currentPage = 1;
            let perPage = parseInt(perPageSelect.value, 10) || 10;

            function applyFiltersAndPaginate() {
                const q = (searchInput && searchInput.value) ? searchInput.value.trim().toLowerCase() : '';
                const status = (statusFilter && statusFilter.value) ? statusFilter.value.trim().toLowerCase() : '';
                filteredRows = allRows.filter(r => {
                    const text = r.innerText.toLowerCase();
                    if (q && !text.includes(q)) return false;
                    if (status) {
                        const cell = r.querySelectorAll('td')[3];
                        if (!cell || !cell.innerText.toLowerCase().includes(status)) return false;
                    }
                    return true;
                });
                currentPage = 1;
                renderTablePage();
                renderPagination();
            }

            function renderTablePage() {
                // hide all rows
                allRows.forEach(r => r.style.display = 'none');
                const start = (currentPage - 1) * perPage;
                const pageRows = filteredRows.slice(start, start + perPage);
                pageRows.forEach(r => r.style.display = '');
                // no-data handling
                const noDataRow = toolsTbody.querySelector('tr td[colspan]') ? toolsTbody.querySelector(
                    'tr td[colspan]').parentElement : null;
                if (noDataRow) {
                    noDataRow.style.display = filteredRows.length === 0 ? '' : 'none';
                }
                paginationInfo.innerText = filteredRows.length === 0 ?
                    'Menampilkan 0 hasil' :
                    `Menampilkan ${start + 1} - ${Math.min(start + pageRows.length, filteredRows.length)} dari ${filteredRows.length} hasil`;
            }

            function renderPagination() {
                paginationControls.innerHTML = '';
                const total = Math.max(1, Math.ceil(filteredRows.length / perPage));
                // previous
                const prev = document.createElement('button');
                prev.innerText = '‹';
                prev.disabled = currentPage <= 1;
                prev.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderTablePage();
                        renderPagination();
                    }
                });
                paginationControls.appendChild(prev);
                // pages (compact if many)
                const maxButtons = 7;
                let start = Math.max(1, currentPage - Math.floor(maxButtons / 2));
                let end = Math.min(total, start + maxButtons - 1);
                if (end - start < maxButtons - 1) start = Math.max(1, end - maxButtons + 1);
                for (let i = start; i <= end; i++) {
                    const btn = document.createElement('button');
                    btn.innerText = i;
                    if (i === currentPage) btn.classList.add('active');
                    btn.addEventListener('click', () => {
                        currentPage = i;
                        renderTablePage();
                        renderPagination();
                    });
                    paginationControls.appendChild(btn);
                }
                // next
                const next = document.createElement('button');
                next.innerText = '›';
                next.disabled = currentPage >= total;
                next.addEventListener('click', () => {
                    if (currentPage < total) {
                        currentPage++;
                        renderTablePage();
                        renderPagination();
                    }
                });
                paginationControls.appendChild(next);
            }

            // initial
            applyFiltersAndPaginate();

            // listeners
            if (searchInput) searchInput.addEventListener('input', () => applyFiltersAndPaginate());
            if (statusFilter) statusFilter.addEventListener('change', () => applyFiltersAndPaginate());
            if (perPageSelect) perPageSelect.addEventListener('change', () => {
                perPage = parseInt(perPageSelect.value, 10) || 10;
                currentPage = 1;
                renderTablePage();
                renderPagination();
            });

            // export visible rows to CSV

            // refresh
            if (refreshBtn) refreshBtn.addEventListener('click', () => window.location.reload());

            // modal: delegated click on "Detail" button
            toolsTbody?.addEventListener('click', function(e) {
                const btn = e.target.closest('button[data-action="detail"]');
                if (!btn) return;
                const tr = btn.closest('tr[data-tool]');
                if (!tr) return;
                let data = null;
                try {
                    data = JSON.parse(tr.getAttribute('data-tool'));
                } catch (err) {
                    console.error('Invalid data-tool JSON', err);
                }
                if (!data) return;
                modalTitle.innerText = data.nama || 'Detail Item';
                modalBody.innerHTML = `
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div><strong>Nama:</strong><div class="text-sm mt-1">${escapeHtml(data.nama)}</div></div>
                        <div><strong>Merk:</strong><div class="text-sm mt-1">${escapeHtml(data.merek || '-')}</div></div>
                        <div><strong>No. Seri:</strong><div class="text-sm mt-1">${escapeHtml(data.no_seri || '-')}</div></div>
                        <div><strong>Status:</strong><div class="text-sm mt-1">${escapeHtml(data.history?.status || data.status || '-')}</div></div>
                        <div><strong>Tgl. Kalibrasi:</strong><div class="text-sm mt-1">${escapeHtml(data.history?.tgl_kalibrasi || data.tgl_kalibrasi || '-')}</div></div>
                        <div><strong>Tgl. Kalibrasi Ulang:</strong><div class="text-sm mt-1">${escapeHtml(data.history?.tgl_kalibrasi_ulang || data.tgl_kalibrasi_ulang || '-')}</div></div>
                        <div class="sm:col-span-2"><strong>Keterangan:</strong><div class="text-sm mt-1">${escapeHtml(data.history?.keterangan || data.keterangan || '-')}</div></div>
                    </div>
                `;
                detailModal.classList.remove('hidden');
                detailModal.classList.add('flex');
                modalClose?.focus();
            });

            function closeModal() {
                detailModal?.classList.add('hidden');
                detailModal?.classList.remove('flex');
            }
            modalClose?.addEventListener('click', closeModal);
            modalClose2?.addEventListener('click', closeModal);
            detailModal?.addEventListener('click', e => {
                if (e.target === detailModal) closeModal();
            });
            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeModal();
            });

            // charts
            (function initCharts() {
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
                                labels: ['OK', 'Proses', 'Penjadwalan'],
                                datasets: [{
                                    data: [pd.ok || 0, pd.proses || 0, pd.due || 0],
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
                                    label: 'Penjadwalan',
                                    data: values || [],
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
                } catch (err) {
                    console.error('Chart init error', err);
                }
            })();

            // expose for debugging
            window._portal = {
                applyFiltersAndPaginate,
                renderTablePage,
                renderPagination
            };
        })();
    </script>
@endpush
