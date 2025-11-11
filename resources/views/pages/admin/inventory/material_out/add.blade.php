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
        <table id="materialOutTable" class="table table-striped table-bordered align-middle text-center mb-0">
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
                        <th class="{{ $day == now()->day && $month == now()->format('m') && $year == now()->year ? 'bg-info text-white' : '' }}">
                            {{ $day }}
                        </th>
                    @endfor

                    <th>Total Keluar</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($materials as $index => $m)
                    @php $totalQty = 0; @endphp
                    <tr>
                        <td class="hide-col">{{ $index + 1 }}</td>
                        <td class="hide-col">{{ $m->heat_lot_no ?? '-' }}</td>
                        <td class="hide-col">{{ $m->no_drawing ?? '-' }}</td>

                        {{-- Valve --}}
                        <td class="sticky-left sticky-valve">
                            <div class="valve-list">
                                @php
                                    $valves = $m->valves->pluck('valve_name')->toArray();
                                    $groups = [];
                                    foreach ($valves as $v) {
                                        if (preg_match('/^([A-Z]+)\.(\d+)\.(\d+)$/', $v, $m2)) {
                                            $prefix = $m2[1] . '.' . $m2[2];
                                            $groups[$prefix][] = $m2[3];
                                        } else {
                                            $groups[$v][] = null;
                                        }
                                    }
                                @endphp
                                @foreach ($groups as $base => $nums)
                                    @php
                                        $nums = array_filter($nums);
                                        $text = $nums ? $base . '.' . implode(',', $nums) : $base;
                                    @endphp
                                    <span class="valve-badge">{{ $text }}</span>
                                @endforeach
                                @if (empty($valves))
                                    <em>-</em>
                                @endif
                            </div>
                        </td>

                        {{-- Spare Part & Dimensi --}}
                        <td class="sticky-left sticky-spare">{{ $m->sparePart->spare_part_name ?? '-' }}</td>
                        <td class="sticky-left sticky-dimensi">{{ $m->dimensi ?? '-' }}</td>

                        <td class="hide-col"><strong>{{ $m->current_stock ?? 0 }}</strong></td>

                        {{-- Input per hari --}}
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
                                    min="0" placeholder="0"
                                    data-day="{{ $day }}" data-material="{{ $m->id }}"
                                    value="{{ $existingQty }}">
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
.table th, .table td {
    font-size: 13px;
    padding: 6px 8px;
    vertical-align: middle;
    white-space: nowrap;
    transition: all 0.25s ease;
}
.table tbody tr:hover { background-color: #f8f9fa; }

.day-input {
    width: 55px;
    font-size: 13px;
    text-align: center;
    border: 1px solid #ddd;
}
.day-input.filled {
    background: #ffecec;
    border-color: #a72828;
}
.day-cell { position: relative; }

/* Sticky columns */
.table thead th.sticky-left, .table tbody td.sticky-left {
    position: sticky;
    background: #fff;
    z-index: 5;
    box-shadow: 2px 0 3px rgba(0, 0, 0, 0.05);
}
th.sticky-valve, td.sticky-valve { left: 0; min-width: 140px; }
th.sticky-spare, td.sticky-spare { left: 140px; min-width: 160px; }
th.sticky-dimensi, td.sticky-dimensi { left: 300px; min-width: 130px; }

/* Valve badges */
.valve-list { display: flex; flex-direction: column; gap: 3px; }
.valve-badge {
    background: #eef4ff;
    color: #1a4fb7;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 500;
    display: inline-block;
    width: fit-content;
}

/* Minimize mode */
.minimized th.hide-col, .minimized td.hide-col { display: none; }
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const url = "{{ route('material_out.store') }}";
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // Reload page on month/year change
    document.getElementById("monthSelect").addEventListener('change', reloadPage);
    document.getElementById("yearSelect").addEventListener('change', reloadPage);
    function reloadPage() {
        const m = document.getElementById("monthSelect").value;
        const y = document.getElementById("yearSelect").value;
        window.location = `?month=${m}&year=${y}`;
    }

    // Init DataTables
    const table = $('#materialOutTable').DataTable({
        pageLength: 15,
        order: [],
        scrollX: true,
        columnDefs: [{ orderable: false, targets: '_all' }]
    });

    function attachInputEvents() {
        document.querySelectorAll('.day-input').forEach(input => {
            input.addEventListener('keydown', e => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    save(input);
                }
            });
        });
    }

    table.on('draw', attachInputEvents);
    attachInputEvents();

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
        } catch {
            alert("Gagal menyimpan data");
        }

        spinner.classList.add('d-none');
        input.disabled = false;
    }

    // Toggle minimize
    const toggleBtn = document.getElementById('toggleColumns');
    const tableContainer = document.querySelector('.table-responsive');
    toggleBtn.addEventListener('click', () => {
        tableContainer.classList.toggle('minimized');
        toggleBtn.textContent = tableContainer.classList.contains('minimized')
            ? '🔼 Expand' : '🔽 Minimize';
    });
});
</script>
@endpush
