@extends('layouts.admin')
@section('title')
    Jadwal Witness | MCI | Update Data
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Activities /</span>
            {{ isset($activity) ? 'Edit' : 'Tambah' }}
        </h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ isset($activity) ? 'Edit' : 'Tambah' }} Activity</h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($activity) ? route('activities.update', $activity->id) : route('activities.store') }}"
                    method="POST">
                    @csrf
                    @if (isset($activity))
                        @method('PUT')
                    @endif

                    {{-- Type --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Tipe Kegiatan</label>
                        <div class="col-sm-10">
                            <select name="type" id="type" class="form-select" required disabled>
                                @foreach (['meeting', 'production', 'other'] as $type)
                                    <option value="{{ $type }}"
                                        {{ old('type', $activity->type ?? '') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-5">
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ old('start_date', $activity->start_date ?? '') }}" required>
                        </div>
                        <div class="col-sm-5">
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ old('end_date', $activity->end_date ?? old('start_date', $activity->start_date ?? '')) }}"
                                required>
                        </div>
                        <small class="text-muted ms-2">Jika hanya 1 hari, isi sama dengan tanggal mulai</small>
                    </div>

                    {{-- Kegiatan --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Kegiatan</label>
                        <div class="col-sm-10">
                            <input type="text" name="kegiatan" class="form-control"
                                value="{{ old('kegiatan', $activity->kegiatan ?? '') }}" required>
                        </div>
                    </div>
                    {{-- Customer --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Customer</label>
                        <div class="col-sm-10">
                            <input type="text" name="customer" class="form-control"
                                value="{{ old('customer', $activity->customer ?? '') }}" required>
                        </div>
                    </div>

                    {{-- PO --}}
                    <div class="mb-3 row production-only">
                        <label class="col-sm-2 col-form-label">PO</label>
                        <div class="col-sm-10">
                            <input type="text" name="po" class="form-control"
                                value="{{ old('po', $activity->po ?? '') }}">
                        </div>
                    </div>

                    {{-- Dynamic Items --}}
                    <div class="mb-3 row production-only">
                        <label class="col-sm-2 col-form-label">Detail Parts</label>
                        <div class="col-sm-10">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dynamicTable">
                                    <thead>
                                        <tr>
                                            <th>Part Name</th>
                                            <th>Material</th>
                                            <th>Qty</th>
                                            <th>Heat No</th>
                                            <th>Remarks</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $items =
                                                isset($activity) && $activity->items
                                                    ? json_decode($activity->items, true)
                                                    : [[]];
                                        @endphp
                                        @foreach ($items as $i => $item)
                                            <tr>
                                                <td><input type="text" name="part_name[]" class="form-control"
                                                        value="{{ $item['part_name'] ?? '' }}"></td>
                                                <td><input type="text" name="material[]" class="form-control"
                                                        value="{{ $item['material'] ?? '' }}"></td>
                                                <td><input type="number" name="qty[]" class="form-control"
                                                        value="{{ $item['qty'] ?? '' }}"></td>
                                                <td><input type="text" name="heat_no[]" class="form-control"
                                                        value="{{ $item['heat_no'] ?? '' }}"></td>
                                                <td><input type="text" name="remarks[]" class="form-control"
                                                        value="{{ $item['remarks'] ?? '' }}"></td>
                                                <td>
                                                    @if ($i === 0)
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                            id="addRow">+</button>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger removeRow">x</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select name="status" class="form-select" required>
                                @foreach (['Pending', 'On Going', 'Reschedule', 'Done'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $activity->status ?? '') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Submit --}}
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Script Dynamic Form & Toggle --}}
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    let typeSelect = document.getElementById("type");
                    let productionFields = document.querySelectorAll(".production-only");

                    function toggleFields() {
                        if (typeSelect.value === "production") {
                            productionFields.forEach(el => el.style.display = "flex");
                        } else {
                            productionFields.forEach(el => el.style.display = "none");
                        }
                    }

                    // Jalankan saat load awal
                    toggleFields();

                    // Jalankan saat type berubah
                    typeSelect.addEventListener("change", toggleFields);

                    // Dynamic Table Add/Remove Row
                    let table = document.getElementById("dynamicTable").getElementsByTagName('tbody')[0];
                    let addBtn = document.getElementById("addRow");

                    if (addBtn) {
                        addBtn.addEventListener("click", function() {
                            let newRow = table.insertRow();
                            newRow.innerHTML = `
                            <td><input type="text" name="part_name[]" class="form-control"></td>
                            <td><input type="text" name="material[]" class="form-control"></td>
                            <td><input type="number" name="qty[]" class="form-control"></td>
                            <td><input type="text" name="heat_no[]" class="form-control"></td>
                            <td><input type="text" name="remarks[]" class="form-control"></td>
                            <td><button type="button" class="btn btn-sm btn-danger removeRow">x</button></td>
                        `;
                        });
                    }

                    table.addEventListener("click", function(e) {
                        if (e.target && e.target.classList.contains("removeRow")) {
                            let row = e.target.closest("tr");
                            row.remove();
                        }
                    });
                });
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const startInput = document.getElementById('start_date');
                    const endInput = document.getElementById('end_date');

                    // Set default min untuk end_date saat load awal
                    if (startInput.value) {
                        endInput.min = startInput.value;
                    }

                    // Update min end_date saat start_date berubah
                    startInput.addEventListener('change', function() {
                        endInput.min = this.value;

                        // Jika end_date sebelumnya lebih kecil dari start_date, set sama dengan start_date
                        if (endInput.value && endInput.value < this.value) {
                            endInput.value = this.value;
                        }
                    });
                });
            </script>

        </div>
    </div>
@endsection
