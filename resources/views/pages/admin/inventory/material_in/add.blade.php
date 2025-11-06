@extends('layouts.admin')
@section('title', 'Input Material Harian')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">📦 Input Material Harian (Barang Masuk)</h4>

        <div class="d-flex gap-2 align-items-center">
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
                    <th>No</th>
                    <th>Heat/Lot/Batch No</th>
                    <th>No Drawing</th>
                    <th>Valve</th>
                    <th>Spare Part</th>
                    <th>Dimensi</th>
                    <th>Stok Awal</th>

                    @for ($day = 1; $day <= $days; $day++)
                        <th class="{{ $day == now()->day && $month == now()->format('m') && $year == now()->year ? 'bg-info text-white' : '' }}">
                            {{ $day }}
                        </th>
                    @endfor

                    <th>Jumlah</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($materials as $index => $m)
                    @php
                        $stokAwal = $m->current_stock ?? 0;
                        $totalQty = 0;
                    @endphp

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $m->heat_lot_no ?? '-' }}</td>
                        <td>{{ $m->no_drawing ?? '-' }}</td>
                        <td>{{ $m->valves->pluck('valve_name')->implode(', ') ?: '-' }}</td>
                        <td>{{ $m->sparePart->spare_part_name ?? '-' }}</td>
                        <td>{{ $m->dimensi ?? '-' }}</td>
                        <td><strong>{{ $stokAwal }}</strong></td>

                        @for ($day = 1; $day <= $days; $day++)
                            @php
                                $date = $year . '-' . $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                $existingQty = '';

                                if (isset($dailyInputs[$m->id])) {
                                    $row = $dailyInputs[$m->id]->firstWhere('date_in', $date);
                                    $existingQty = $row->qty_in ?? '';
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

                        <td><strong>{{ $totalQty }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection

@push('css')
<style>
.table th, .table td { font-size: 13px; padding: 4px; white-space: nowrap; }
.day-input { width: 55px; font-size: 13px; text-align: center; }
.day-input.filled { background: #d4edda; border-color: #28a745; }
.day-cell { position: relative; }
</style>
@endpush

@push('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const url = "{{ route('material_in.store') }}";
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    // Reload based on month/year change
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
        const date = `${year}-${month}-${String(day).padStart(2,'0')}`;
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
                    qty_in: qty,
                    date_in: date
                })
            });

            input.classList.add("filled");

        } catch (e) {
            alert("Gagal menyimpan");
        }

        spinner.classList.add('d-none');
        input.disabled = false;
    }
});
</script>
@endpush
