@extends('layouts.admin')
@section('title', 'Input Material Harian')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

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

        <div class="table-responsive shadow-sm rounded-3">
            <table class="table table-bordered align-middle text-center mb-0">
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
                                class="{{ $day == now()->day && $month == now()->format('m') && $year == now()->year ? 'bg-info text-white' : '' }}">
                                {{ $day }}
                            </th>
                        @endfor

                        <th>Jumlah</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($materials as $index => $m)
                        @php
                            $totalQty = 0;
                        @endphp
                        <tr>
                            <td class="hide-col">{{ $index + 1 }}</td>
                            <td class="hide-col">{{ $m->heat_lot_no ?? '-' }}</td>
                            <td class="hide-col">{{ $m->no_drawing ?? '-' }}</td>

                            <td class="sticky-left sticky-valve">
                                {{ $m->valves->pluck('valve_name')->implode(', ') ?: '-' }}</td>
                            <td class="sticky-left sticky-spare">{{ $m->sparePart->spare_part_name ?? '-' }}</td>
                            <td class="sticky-left sticky-dimensi">{{ $m->dimensi ?? '-' }}</td>

                            <td class="hide-col"><strong>{{ $m->current_stock ?? 0 }}</strong></td>

                            @for ($day = 1; $day <= $days; $day++)
                                @php
                                    $date = $year . '-' . $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                    $existingQty = '';

                                    if (isset($dailyOutputs[$m->id])) {
                                        $row = $dailyOutputs[$m->id]->firstWhere('date_out', $date);
                                        $existingQty = $row->qty_out ?? '';
                                        $totalQty += (int) $existingQty;
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

                            <td class="fw-bold text-danger">{{ $totalQty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@push('css')
    <style>
        .table th,
        .table td {
            font-size: 13px;
            padding: 4px;
            white-space: nowrap;
        }

        .day-input {
            width: 55px;
            font-size: 13px;
            text-align: center;
        }

        .day-input.filled {
            background: #edd4d4;
            border-color: #a72828;
        }

        .day-cell {
            position: relative;
        }

        /* Sticky columns (Valve, Spare Part, Dimensi) */
        .table thead th.sticky-left,
        .table tbody td.sticky-left {
            position: sticky;
            background: #fff;
            z-index: 3;
            box-shadow: 2px 0 3px rgba(0, 0, 0, 0.1);
        }

        /* Posisi bertahap (menyesuaikan urutan kolom) */
        th.sticky-valve,
        td.sticky-valve {
            left: 0;
            min-width: 120px;
            z-index: 4;
        }

        th.sticky-spare,
        td.sticky-spare {
            left: calc(500px);
            min-width: 160px;
            z-index: 4;
        }

        th.sticky-dimensi,
        td.sticky-dimensi {
            left: calc(500px + 150px);
            min-width: 130px;
            z-index: 4;
        }

        /* Hidden columns when minimized */
        .minimized th.hide-col,
        .minimized td.hide-col {
            display: none;
        }

        /* Smooth transition */
        .table th,
        .table td {
            transition: all 0.3s ease;
        }
    </style>
@endpush

@push('js')
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

            document.querySelectorAll('.day-input').forEach(input => {
                input.addEventListener('keydown', e => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        save(input);
                    }
                });
            });

            async function save(input) {
                const qty = input.value;
                if (!qty || qty <= 0) return;

                const day = input.dataset.day;
                const material = input.dataset.material;
                const month = document.getElementById("monthSelect").value;
                const year = document.getElementById("yearSelect").value;
                const date = `${year}-${month}-${String(day).padStart(2, '0')}`;
                const spinner = input.closest("td").querySelector(".spinner-border");

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

                    input.classList.add("filled");
                } catch (e) {
                    alert("Gagal menyimpan");
                }

                spinner.classList.add('d-none');
                input.disabled = false;
            }
            // === Toggle minimize ===
            const toggleBtn = document.getElementById('toggleColumns');
            const tableContainer = document.querySelector('.table-responsive');

            toggleBtn.addEventListener('click', () => {
                tableContainer.classList.toggle('minimized');
                toggleBtn.textContent = tableContainer.classList.contains('minimized') ?
                    '🔼 Expand' :
                    '🔽 Minimize';
            });
        });
    </script>
@endpush
