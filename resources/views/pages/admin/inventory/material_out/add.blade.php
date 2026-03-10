@extends('layouts.admin')
@section('title', 'Input Material Harian (Keluar)')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            var(--brand): #2563eb;
            --brand-soft: #eff6ff;
            --surface: #ffffff;
            --bg-body: #f4f7fb;
            --text-main: #0f172a;
            --text-muted: #475569;
            --border-light: #cbd5e1;
            --border-dark: #94a3b8;

            --th-bg: #1e293b;
            --th-text: #ffffff;

            /* Warna Barang Keluar = MERAH */
            --out-bg: #fee2e2;
            --out-text: #dc2626;

            --shadow-sticky: 3px 0 8px rgba(0, 0, 0, 0.08);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
        }

        .container-p-y {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        /* ============== HEADER CONTROLS ============== */
        .page-header-card {
            background: var(--surface);
            padding: 1rem 1.25rem;
            border-radius: 12px;
            border: 1px solid var(--border-light);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.15rem;
            font-weight: 800;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .control-group {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .custom-select-sm {
            border: 1px solid var(--border-dark);
            border-radius: 6px;
            padding: 0.3rem 2rem 0.3rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-main);
            background-color: var(--surface);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.5rem center;
            background-size: 12px 12px;
            appearance: none;
            cursor: pointer;
        }

        .custom-select-sm:focus {
            border-color: #dc2626;
            outline: none;
            box-shadow: 0 0 0 2px #fee2e2;
        }

        .btn-action-sm {
            background: white;
            border: 1px solid var(--border-dark);
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.8rem;
            padding: 0.3rem 0.75rem;
            border-radius: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: 0.2s;
        }

        .btn-action-sm:hover {
            background: #f8fafc;
        }

        /* ============== COMPACT SPREADSHEET TABLE ============== */
        .table-scroll-wrapper {
            width: 100%;
            max-height: 75vh;
            overflow-x: auto;
            overflow-y: auto;
            background: var(--surface);
            border-radius: 8px;
            border: 1px solid var(--border-dark);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.03);
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: max-content !important;
            min-width: 100%;
            margin: 0 !important;
            border-collapse: separate;
            border-spacing: 0;
        }

        /* THEAD Sticky */
        .table thead th {
            position: sticky;
            top: 0;
            z-index: 20;
            background-color: var(--th-bg) !important;
            color: var(--th-text) !important;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 0.5rem 0.25rem;
            border-bottom: 2px solid #dc2626;
            /* Aksen merah untuk Out */
            border-right: 1px solid rgba(255, 255, 255, 0.15);
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 0;
            border-bottom: 1px solid var(--border-light);
            border-right: 1px solid var(--border-light);
            background: var(--surface);
            vertical-align: middle;
        }

        .table tbody tr:hover td {
            background-color: #f1f5f9;
        }

        /* ============== MATEMATIKA KOLOM STICKY (SAMA PERSIS DENGAN 'IN') ============== */
        .col-no {
            width: 35px;
            min-width: 35px;
            max-width: 35px;
            text-align: center;
        }

        .col-batch {
            width: 90px;
            min-width: 90px;
            max-width: 90px;
        }

        .col-drawing {
            width: 90px;
            min-width: 90px;
            max-width: 90px;
        }

        .col-valve {
            width: 130px;
            min-width: 130px;
            max-width: 130px;
        }

        .col-spare {
            width: 150px;
            min-width: 150px;
            max-width: 150px;
        }

        .col-dimensi {
            width: 110px;
            min-width: 110px;
            max-width: 110px;
        }

        .col-stok {
            width: 50px;
            min-width: 50px;
            max-width: 50px;
            text-align: center;
        }

        .info-cell {
            padding: 0.4rem 0.5rem !important;
            font-size: 0.75rem;
            white-space: normal;
            line-height: 1.3;
        }

        .info-batch {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        /* STATE 1: EXPAND */
        body:not(.is-minimized) .col-sticky {
            position: sticky;
            z-index: 10;
            background: #f8fafc;
        }

        body:not(.is-minimized) thead th.col-sticky {
            z-index: 30;
            background: var(--th-bg) !important;
        }

        body:not(.is-minimized) .col-no {
            left: 0;
        }

        body:not(.is-minimized) .col-batch {
            left: 35px;
        }

        body:not(.is-minimized) .col-drawing {
            left: 125px;
        }

        /* 35 + 90 */
        body:not(.is-minimized) .col-valve {
            left: 215px;
        }

        /* 125 + 90 */
        body:not(.is-minimized) .col-spare {
            left: 345px;
        }

        /* 215 + 130 */
        body:not(.is-minimized) .col-dimensi {
            left: 495px;
        }

        /* 345 + 150 */
        body:not(.is-minimized) .col-stok {
            left: 605px;
            /* 495 + 110 */
            border-right: 2px solid var(--border-dark) !important;
            box-shadow: var(--shadow-sticky);
        }

        /* STATE 2: MINIMIZE */
        body.is-minimized .col-hide {
            display: none !important;
        }

        body.is-minimized .col-sticky-min {
            position: sticky;
            z-index: 10;
            background: #f8fafc;
        }

        body.is-minimized thead th.col-sticky-min {
            z-index: 30;
            background: var(--th-bg) !important;
        }

        body.is-minimized .col-valve {
            left: 0;
        }

        body.is-minimized .col-spare {
            left: 130px;
        }

        body.is-minimized .col-dimensi {
            left: 280px;
            /* 130 + 150 */
            border-right: 2px solid var(--border-dark) !important;
            box-shadow: var(--shadow-sticky);
        }

        /* ============== SPREADSHEET INPUT BOXES ============== */
        .col-date {
            width: 38px;
            /* UKURAN KECIL */
            min-width: 38px;
            max-width: 38px;
        }

        .day-cell {
            position: relative;
            padding: 0 !important;
        }

        .day-input {
            width: 100%;
            height: 34px;
            /* TINGGI PENDEK */
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
            background: transparent;
            color: var(--text-main);
            border: none;
            padding: 0;
            margin: 0;
            cursor: cell;
        }

        .day-input:hover:not(:focus) {
            background-color: rgba(220, 38, 38, 0.05);
        }

        .day-input:focus {
            background-color: #ffffff;
            box-shadow: inset 0 0 0 2px #dc2626;
            /* Fokus warna merah */
            outline: none;
            z-index: 5;
            position: relative;
        }

        /* State Saat Input Berisi Angka (MERAH) */
        .day-input.filled {
            background-color: var(--out-bg);
            color: var(--out-text);
            font-weight: 700;
        }

        .day-input.filled:focus {
            box-shadow: inset 0 0 0 2px #b91c1c;
        }

        /* Highlight Hari Ini */
        .col-today {
            background-color: #fef2f2 !important;
        }

        th.col-today {
            color: #f87171 !important;
            border-bottom-color: #ef4444 !important;
        }

        .spinner-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 6;
            pointer-events: none;
        }

        /* ============== BADGE VALVE ============== */
        .valve-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .valve-badge {
            padding: 2px 4px;
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 600;
            font-family: 'JetBrains Mono', monospace;
            display: inline-block;
            width: fit-content;
        }

        /* Kolom Total Paling Kanan */
        .col-total {
            min-width: 50px;
            text-align: center;
            font-weight: 800;
            color: #dc2626;
            font-size: 0.85rem;
            background: #fef2f2 !important;
            border-left: 2px solid #fca5a5 !important;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            appearance: none;
            margin: 0;
        }

        input[type=number] {
            appearance: textfield;
        }

        div.dataTables_wrapper {
            padding: 0.5rem 0 0 0;
        }

        div.dataTables_filter input {
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
        }

        div.dataTables_length,
        div.dataTables_info,
        div.dataTables_paginate {
            padding: 0 1rem;
            margin-bottom: 0.5rem;
            font-size: 0.8rem;
        }
    </style>
    <style>
        /* Styling khusus untuk Balon Tooltip Error */
        .error-tooltip .tooltip-inner {
            background-color: #ff3e1d !important;
            /* Merah khas error */
            color: #ffffff;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgba(255, 62, 29, 0.3);
            font-size: 0.85rem;
        }

        /* Mengubah warna panah balon menjadi merah agar senada */
        .error-tooltip.bs-tooltip-top .tooltip-arrow::before {
            border-top-color: #ff3e1d !important;
        }

        .error-tooltip.bs-tooltip-bottom .tooltip-arrow::before {
            border-bottom-color: #ff3e1d !important;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Top Premium Header Card --}}
        <div class="page-header-card">
            <h4 class="page-title">
                <span style="font-size: 1.25rem;">📤</span> Input Harian Spreadsheet (OUT)
            </h4>

            <div class="control-group">
                <button id="toggleColumns" class="btn-action-sm">
                    <i class="bi bi-arrows-collapse"></i> <span id="toggleText">Minimize</span>
                </button>

                <select id="monthSelect" class="custom-select-sm">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                <select id="yearSelect" class="custom-select-sm">
                    @foreach (range(now()->year - 2, now()->year + 2) as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- WADAH NATIVE CSS SCROLL --}}
        <div class="table-scroll-wrapper">
            <table id="materialOutTable" class="table">
                <thead>
                    <tr>
                        <th class="col-hide col-sticky col-no">No</th>
                        <th class="col-hide col-sticky col-batch">Heat/Batch</th>
                        <th class="col-hide col-sticky col-drawing">Drawing</th>

                        <th class="col-sticky col-sticky-min col-valve">Valve Ref.</th>
                        <th class="col-sticky col-sticky-min col-spare">Spare Part</th>
                        <th class="col-sticky col-sticky-min col-dimensi">Dimensi</th>

                        <th class="col-hide col-sticky col-stok text-center">Awal</th>

                        @for ($day = 1; $day <= $days; $day++)
                            @php $isToday = ($day == now()->day && $month == now()->format('m') && $year == now()->year); @endphp
                            <th class="col-date {{ $isToday ? 'col-today' : '' }}">
                                {{ str_pad($day, 2, '0', STR_PAD_LEFT) }}
                            </th>
                        @endfor

                        <th class="col-total text-center">TOT</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        function formatValvesGrouped($valves)
                        {
                            if (empty($valves)) {
                                return '<em class="text-muted">-</em>';
                            }
                            $groups = [];
                            foreach ($valves as $v) {
                                if (preg_match('/^([A-Z]+)\.(\d+)\.(\d+)$/', $v, $m)) {
                                    $groups[$m[1] . '.' . $m[2]][] = $m[3];
                                } else {
                                    $groups[$v][] = null;
                                }
                            }
                            uksort($groups, function ($a, $b) {
                                $order = ['GT', 'GL', 'GF', 'GC', 'GX'];
                                $getPrefixA = explode('.', $a)[0];
                                $getPrefixB = explode('.', $b)[0];
                                $ai = array_search($getPrefixA, $order);
                                $bi = array_search($getPrefixB, $order);
                                $ai = $ai === false ? 999 : $ai;
                                $bi = $bi === false ? 999 : $bi;
                                if ($ai === $bi) {
                                    return strcmp($a, $b);
                                }
                                return $ai < $bi ? -1 : 1;
                            });

                            $formatted = [];
                            foreach ($groups as $base => $nums) {
                                $nums = array_filter($nums);
                                $text = $nums ? $base . '.' . implode(',', $nums) : $base;
                                $prefix = explode('.', $base)[0];
                                $bgColors = [
                                    'GT' => '#dbeafe',
                                    'GL' => '#dcfce7',
                                    'GF' => '#fef3c7',
                                    'GC' => '#fde68a',
                                ];
                                $textColors = [
                                    'GT' => '#1e40af',
                                    'GL' => '#166534',
                                    'GF' => '#92400e',
                                    'GC' => '#92400e',
                                ];
                                $bg = isset($bgColors[$prefix]) ? $bgColors[$prefix] : '#f1f5f9';
                                $col = isset($textColors[$prefix]) ? $textColors[$prefix] : '#475569';
                                $formatted[] =
                                    "<span class='valve-badge' style='background:{$bg}; color:{$col}'>" .
                                    e($text) .
                                    '</span>';
                            }
                            return implode('', $formatted);
                        }
                    @endphp

                    @foreach ($materials as $index => $m)
                        @php
                            $stokAwal = $m->stock_awal ?? 0;
                            $runningStock = 0; // OUT = akumulasi dari 0
                        @endphp

                        <tr>
                            <td class="col-hide col-sticky col-no info-cell text-center text-muted">{{ $index + 1 }}</td>
                            <td class="col-hide col-sticky col-batch info-cell info-batch">{{ $m->heat_lot_no ?? '-' }}</td>
                            <td class="col-hide col-sticky col-drawing info-cell info-batch">{{ $m->no_drawing ?? '-' }}
                            </td>

                            <td class="col-sticky col-sticky-min col-valve info-cell">
                                <div class="valve-list">{!! formatValvesGrouped($m->valves->pluck('valve_name')->toArray()) !!}</div>
                            </td>
                            <td class="col-sticky col-sticky-min col-spare info-cell fw-semibold text-dark">
                                {{ $m->sparePart->spare_part_name ?? '-' }}</td>
                            <td class="col-sticky col-sticky-min col-dimensi info-cell text-muted">{{ $m->dimensi ?? '-' }}
                            </td>

                            <td class="col-hide col-sticky col-stok info-cell text-center fw-bold">
                                {{ number_format($stokAwalPerMaterial[$m->id] ?? 0) }}</td>

                            @for ($day = 1; $day <= $days; $day++)
                                @php
                                    $date = $year . '-' . $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                    $existingQty = '';
                                    if (isset($dailyInputs[$m->id])) {
                                        $row = $dailyInputs[$m->id]->firstWhere('date_out', $date);
                                        $existingQty = $row->qty_out ?? '';
                                        $runningStock += (int) $existingQty;
                                    }
                                    $isToday =
                                        $day == now()->day && $month == now()->format('m') && $year == now()->year;
                                @endphp
                                <td class="day-cell col-date {{ $isToday ? 'col-today' : '' }}">
                                    <div style="position: relative; width: 100%; height: 100%;">
                                        <input type="number" class="day-input {{ $existingQty ? 'filled' : '' }}"
                                            placeholder="" data-day="{{ $day }}"
                                            data-material="{{ $m->id }}" value="{{ $existingQty }}">

                                        <div class="spinner-overlay d-none">
                                            <div class="spinner-border spinner-border-sm text-danger"
                                                style="width:0.8rem; height:0.8rem;" role="status"></div>
                                        </div>
                                    </div>
                                </td>
                            @endfor

                            <td class="col-total info-cell">{{ number_format($runningStock) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const url = "{{ route('material_out.store') }}";
            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            const reloadPage = () => {
                const m = document.getElementById("monthSelect").value;
                const y = document.getElementById("yearSelect").value;
                window.location = `?month=${m}&year=${y}`;
            };
            document.getElementById("monthSelect").addEventListener('change', reloadPage);
            document.getElementById("yearSelect").addEventListener('change', reloadPage);

            // Inisialisasi DataTable TANPA scrollX
            const table = $('#materialOutTable').DataTable({
                pageLength: 50,
                lengthMenu: [25, 50, 100, 200],
                ordering: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari data...",
                    lengthMenu: "Tampil _MENU_",
                },
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row pt-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            });

            // Logic Keyboard Navigasi Excel
            function attachInputEvents() {
                document.querySelectorAll('.day-input').forEach(input => {
                    if (!input.dataset.eventAttached) {
                        input.dataset.eventAttached = 'true';
                        input.addEventListener('keydown', e => {
                            if (e.key === 'Enter' || e.key === 'ArrowDown') {
                                e.preventDefault();
                                if (e.key === 'Enter') save(input);

                                const td = input.closest('td');
                                const tr = td.closest('tr');
                                const cellIndex = Array.from(tr.children).indexOf(td);
                                const nextRow = tr.nextElementSibling;
                                if (nextRow) {
                                    const nextInput = nextRow.children[cellIndex].querySelector(
                                        '.day-input');
                                    if (nextInput) {
                                        nextInput.focus();
                                        nextInput.select();
                                    }
                                }
                            } else if (e.key === 'ArrowUp') {
                                e.preventDefault();
                                const td = input.closest('td');
                                const tr = td.closest('tr');
                                const cellIndex = Array.from(tr.children).indexOf(td);
                                const prevRow = tr.previousElementSibling;
                                if (prevRow) {
                                    const prevInput = prevRow.children[cellIndex].querySelector(
                                        '.day-input');
                                    if (prevInput) {
                                        prevInput.focus();
                                        prevInput.select();
                                    }
                                }
                            }
                        });

                        input.addEventListener('focus', function() {
                            this.select();
                        });
                    }
                });
            }

            table.on('draw', attachInputEvents);
            attachInputEvents();

            // =========================================================================
            // 1. KONFIGURASI TOAST SWEETALERT (Diturunkan sedikit)
            // =========================================================================
            async function save(input) {
                // 1. Pastikan input tidak error (mencegah null)
                const qty = (input.value || "").toString().trim();
                const wrapper = input.closest(".day-cell");
                const spinner = wrapper ? wrapper.querySelector(".spinner-overlay") : null;

                // 2. Ambil nilai lama. Jika di HTML belum ada data-prev-value, 
                // gunakan defaultValue (angka bawaan saat halaman pertama dimuat)
                const prevValue = input.getAttribute('data-prev-value') !== null ?
                    input.getAttribute('data-prev-value') :
                    input.defaultValue;

                // Jika user mengetik angka yang sama, batalkan (hemat database)
                if (qty === prevValue) return;

                // 3. Setup Konfigurasi Toast di dalam fungsi agar aman dari error "Swal is not defined"
                const showToast = (icon, title, text) => {
                    if (typeof Swal !== 'undefined') {
                        Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3500,
                            customClass: {
                                popup: 'rounded-3 shadow-sm mt-5'
                            }
                        }).fire({
                            icon,
                            title,
                            text
                        });
                    } else {
                        alert(title + ": " + text); // Fallback jika SweetAlert gagal dimuat
                    }
                };

                // Validasi angka minus
                if (qty !== "" && parseFloat(qty) < 0) {
                    input.value = prevValue;
                    showToast('warning', 'Ditolak', 'Angka tidak boleh minus!');
                    return;
                }

                const day = input.dataset.day;
                const material = input.dataset.material;
                const month = document.getElementById("monthSelect").value;
                const year = document.getElementById("yearSelect").value;
                const date = `${year}-${month}-${String(day).padStart(2, '0')}`;

                // UI: Efek Loading
                input.disabled = true;
                input.style.opacity = "0.6";
                input.style.transition = "all 0.3s ease";
                if (spinner) spinner.classList.remove('d-none');

                try {
                    const response = await fetch(url, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrf,
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            material_id: material,
                            qty_out: qty, // Pastikan ini sama dengan yang ditangkap di $request->qty_out di Controller
                            date_out: date
                        })
                    });

                    // ==========================================
                    // JIKA SERVER MENOLAK (HTTP 4xx / 5xx)
                    // ==========================================
                    if (!response.ok) {
                        let errorMessage = 'Gagal menyimpan data ke server.';
                        try {
                            // Hanya coba parsing JSON jika responsnya gagal
                            const errorData = await response.json();
                            errorMessage = errorData.message || errorMessage;
                        } catch (e) {}

                        throw new Error(errorMessage);
                    }

                    // ==========================================
                    // JIKA BERHASIL DISIMPAN (HTTP 200 OK)
                    // ==========================================
                    input.setAttribute('data-prev-value', qty);

                    if (qty === '' || parseFloat(qty) === 0) {
                        input.classList.remove("filled");
                    } else {
                        input.classList.add("filled");
                    }

                    // Efek kedip Hijau
                    input.style.backgroundColor = "#e8fadf";
                    input.style.color = "#28a745";
                    setTimeout(() => {
                        input.style.backgroundColor = "";
                        input.style.color = "";
                    }, 1000);

                } catch (error) {
                    // Tampilkan Error
                    showToast('error', 'Gagal Disimpan', error.message);

                    // Kembalikan kotak ke angka sebelumnya yang benar
                    input.value = prevValue;
                    if (prevValue === '' || parseFloat(prevValue) === 0) {
                        input.classList.remove("filled");
                    } else {
                        input.classList.add("filled");
                    }

                    // Efek kedip Merah
                    input.style.backgroundColor = "#fbeaea";
                    input.style.color = "#dc3545";
                    setTimeout(() => {
                        input.style.backgroundColor = "";
                        input.style.color = "";
                    }, 1000);

                } finally {
                    // Kembalikan kotak input agar bisa diketik lagi
                    input.disabled = false;
                    input.style.opacity = "1";
                    if (spinner) spinner.classList.add('d-none');
                }
            }

            // Logic Minimize 
            const toggleBtn = document.getElementById('toggleColumns');
            const toggleText = document.getElementById('toggleText');

            toggleBtn.addEventListener('click', () => {
                const isMin = document.body.classList.toggle('is-minimized');
                toggleBtn.innerHTML = isMin ?
                    '<i class="bi bi-arrows-expand"></i> <span id="toggleText">Expand Info</span>' :
                    '<i class="bi bi-arrows-collapse"></i> <span id="toggleText">Minimize</span>';
            });
        });
    </script>
@endpush
