@extends('layouts.admin')
@section('title', 'Input Material Harian (Barang Keluar)')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">📦 Input Material Harian (Barang Keluar)</h4>

            <div class="d-flex gap-2 align-items-center">
                <button id="toggleColumns" class="btn btn-outline-secondary btn-sm">
                    🔽 Minimize
                </button>

                <select id="monthSelect" class="form-select form-select-sm" style="width:auto;">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                        </option>
                    @endforeach
                </select>

                <select id="yearSelect" class="form-select form-select-sm" style="width:auto;">
                    @foreach (range(now()->year - 2, now()->year + 2) as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive shadow-sm rounded-3">
            <table id="materialOutTable" class="table table-striped table-bordered align-middle">
                <thead class="table-primary sticky-top">
                    <tr>
                        <th class="hide-col">No</th>
                        <th class="hide-col">Heat/Lot/Batch No</th>
                        <th class="hide-col">No Drawing</th>

                        <th class="sticky-left sticky-valve">Valve</th>
                        <th class="sticky-left sticky-spare">Spare Part</th>
                        <th class="sticky-left sticky-dimensi">Dimensi</th>

                        <th class="hide-col">Stok Awal</th>

                        @for ($day = 1; $day <= $days; $day++)
                            <th
                                class="
                            {{ $day == now()->day && $month == now()->format('m') && $year == now()->year ? 'bg-info text-white' : '' }}
                        ">
                                {{ $day }}
                            </th>
                        @endfor

                        <th>Total Keluar</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        function formatValvesGrouped($valves)
                        {
                            if (empty($valves)) {
                                return '<em>-</em>';
                            }

                            $groups = [];

                            foreach ($valves as $v) {
                                if (preg_match('/^([A-Z]+)\.(\d+)\.(\d+)$/', $v, $m)) {
                                    $prefix = $m[1] . '.' . $m[2];
                                    $groups[$prefix][] = $m[3];
                                } else {
                                    $groups[$v][] = null;
                                }
                            }

                            $formatted = [];

                            foreach ($groups as $base => $nums) {
                                $nums = array_filter($nums);
                                $text = $nums ? $base . '.' . implode(',', $nums) : $base;

                                $prefix = explode('.', $base)[0];

                                // PERBAIKAN: pakai IF ELSE (Blade aman)
                                if ($prefix === 'GT') {
                                    $color = '#dbeafe';
                                } elseif ($prefix === 'GL') {
                                    $color = '#dcfce7';
                                } elseif ($prefix === 'GF') {
                                    $color = '#fef3c7';
                                } elseif ($prefix === 'GC') {
                                    $color = '#fde68a';
                                } else {
                                    $color = '#f3f4f6';
                                }

                                $formatted[] = "<span class='valve-badge' style='background:$color'>$text</span>";
                            }

                            return implode('<br>', $formatted);
                        }
                    @endphp


                    @foreach ($materials as $index => $m)
                        @php
                            $stokAwal = $m->stock_awal ?? 0; // ✅ pakai stock_awal asli
                            $totalQty = 0;
                        @endphp

                        <tr>
                            <td class="hide-col">{{ $index + 1 }}</td>
                            <td class="hide-col">{{ $m->heat_lot_no ?? '-' }}</td>
                            <td class="hide-col">{{ $m->no_drawing ?? '-' }}</td>

                            <td class="sticky-left sticky-valve">
                                <div class="valve-list">
                                    {!! formatValvesGrouped($m->valves->pluck('valve_name')->toArray()) !!}
                                </div>
                            </td>
                            <td class="sticky-left sticky-spare">{{ $m->sparePart->spare_part_name ?? '-' }}</td>
                            <td class="sticky-left sticky-dimensi">{{ $m->dimensi ?? '-' }}</td>

                            <td class="hide-col"><strong>{{ $stokAwalPerMaterial[$m->id] ?? 0 }}</strong></td>

                            @php
                                $runningStock = $stokAwalPerMaterial[$m->id] ?? 0;
                            @endphp

                            @for ($day = 1; $day <= $days; $day++)
                                @php
                                    $date = $year . '-' . $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                    $existingQty = '';
                                    if (isset($dailyInputs[$m->id])) {
                                        $row = $dailyInputs[$m->id]->firstWhere('date_out', $date);
                                        $existingQty = $row->qty_out ?? '';
                                        $runningStock += (int) $existingQty;
                                    }
                                @endphp
                                <td class="position-relative day-cell">
                                    <input type="number"
                                        class="form-control form-control-sm text-center day-input {{ $existingQty ? 'filled' : '' }}"
                                        min="0" placeholder="0" data-day="{{ $day }}"
                                        data-material="{{ $m->id }}" value="{{ $existingQty }}">
                                    <div class="spinner-border spinner-border-sm text-primary d-none position-absolute top-50 start-50 translate-middle"
                                        style="width:1rem;height:1rem;"></div>
                                </td>
                            @endfor

                            <td><strong>{{ $runningStock }}</strong></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        .table th,
        .table td {
            font-size: 13px;
            padding: 5px;
            vertical-align: middle;
            transition: all .25s ease;
        }

        .day-input {
            width: 55px;
            font-size: 13px;
            text-align: center;
        }

        .day-input.filled {
            background: #ffe2e2;
            border-color: #e02424;
        }

        .day-cell {
            position: relative;
        }

        /* Sticky columns */
        th.sticky-left,
        td.sticky-left {
            position: sticky;
            background: #fff;
            z-index: 3;
            box-shadow: 2px 0 3px rgba(0, 0, 0, 0.05);
        }

        th.sticky-valve,
        td.sticky-valve {
            left: 0;
            width: 130px;
            max-width: 130px;
        }

        th.sticky-spare,
        td.sticky-spare {
            left: 130px;
            min-width: 160px;
        }

        th.sticky-dimensi,
        td.sticky-dimensi {
            left: 290px;
            min-width: 130px;
        }

        .valve-list {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .valve-badge {
            color: #1e3a8a;
            padding: 3px 7px;
            border-radius: 6px;
            font-size: 12.5px;
            font-weight: 500;
        }

        /* Minimize */
        .minimized th.hide-col,
        .minimized td.hide-col {
            display: none;
        }
    </style>
@endpush

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const url = "{{ route('material_out.store') }}";
            const csrf = document.querySelector('meta[name="csrf-token"]').content;

            document.getElementById("monthSelect").addEventListener('change', reloadPage);
            document.getElementById("yearSelect").addEventListener('change', reloadPage);

            function reloadPage() {
                const m = document.getElementById("monthSelect").value;
                const y = document.getElementById("yearSelect").value;
                window.location = `?month=${m}&year=${y}`;
            }

            const table = $('#materialOutTable').DataTable({
                pageLength: 15,
                order: [],
                scrollX: true,
                columnDefs: [{
                    orderable: false,
                    targets: '_all'
                }]
            });

            function bindInputs() {
                document.querySelectorAll('.day-input').forEach(input => {
                    input.addEventListener('keydown', e => {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            save(input);
                        }
                    });
                });
            }

            table.on('draw', bindInputs);
            bindInputs();

            async function save(input) {
                const qty = input.value;
                if (!qty || qty <= 0) return;

                const day = input.dataset.day;
                const material = input.dataset.material;
                const month = document.getElementById("monthSelect").value;
                const year = document.getElementById("yearSelect").value;

                const date = `${year}-${month}-${String(day).padStart(2,'0')}`;
                const spinner = input.closest("td").querySelector('.spinner-border');

                input.disabled = true;
                spinner.classList.remove('d-none');

                try {
                    await fetch(url, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrf,
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            material_id: material,
                            qty_out: qty,
                            date_out: date
                        })
                    });

                    input.classList.add('filled');

                } catch {
                    alert("Gagal menyimpan data");
                }

                spinner.classList.add('d-none');
                input.disabled = false;
            }

            const toggleBtn = document.getElementById("toggleColumns");
            const tableContainer = document.querySelector(".table-responsive");

            toggleBtn.addEventListener('click', () => {
                tableContainer.classList.toggle('minimized');
                toggleBtn.textContent = tableContainer.classList.contains('minimized') ?
                    '🔼 Expand' :
                    '🔽 Minimize';
            });
        });
    </script>
@endpush
