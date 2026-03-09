@extends('layouts.admin')
@section('title', 'Jadwal Witness | MCI | ' . (isset($activity) ? 'Edit' : 'Tambah') . ' Data')

@push('css')
    <style>
        .form-section-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #566a7f;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #f0f2f4;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-label {
            font-weight: 600;
            color: #566a7f;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            background-color: #f8f9fa;
        }

        #dynamicTable thead th {
            background-color: #f1f5f9;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">
                <span class="text-muted fw-light">Activities /</span> {{ isset($activity) ? 'Edit' : 'Tambah' }} Data
            </h4>
            <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bx bx-arrow-back me-1"></i> Kembali ke Daftar
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-xl-10 col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body p-4">
                        <form
                            action="{{ isset($activity) ? route('activities.update', $activity->id) : route('activities.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($activity))
                                @method('PUT')
                            @endif

                            <input type="hidden" name="redirect_to" value="{{ request('from') ?? 'show' }}">

                            <div class="form-section-title">
                                <i class="bx bx-info-circle text-primary"></i> Informasi Dasar
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tipe Kegiatan</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-category"></i></span>
                                        <select name="type" id="type" class="form-select" required>
                                            @foreach (['meeting', 'production', 'other'] as $type)
                                                <option value="{{ $type }}"
                                                    {{ old('type', $activity->type ?? '') == $type ? 'selected' : '' }}>
                                                    {{ ucfirst($type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select fw-bold text-primary" required>
                                        @foreach (['Pending', 'On Going', 'Reschedule', 'Done'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('status', $activity->status ?? '') == $status ? 'selected' : '' }}>
                                                ● {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Rentang Tanggal (Mulai - Selesai)</label>
                                    <div class="input-group">
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                            value="{{ old('start_date', $activity->start_date ?? '') }}" required>
                                        <span class="input-group-text">s/d</span>
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                            value="{{ old('end_date', $activity->end_date ?? '') }}" required>
                                    </div>
                                    <small class="text-muted mt-1 d-block"><i class="bx bx-help-circle"></i> Jika hanya 1
                                        hari, isi kedua tanggal dengan nilai yang sama.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Customer / Klien</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" name="customer" class="form-control"
                                            placeholder="Contoh: PT. PLN Persero"
                                            value="{{ old('customer', $activity->customer ?? '') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Nama Kegiatan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-task"></i></span>
                                    <input type="text" name="kegiatan" class="form-control"
                                        placeholder="Contoh: Witness Testing Gate Valve 10 Inch"
                                        value="{{ old('kegiatan', $activity->kegiatan ?? '') }}" required>
                                </div>
                            </div>

                            <div class="production-only">
                                <div class="form-section-title">
                                    <i class="bx bx-box text-warning"></i> Detail Produksi & Parts
                                </div>

                                <div class="mb-4 row">
                                    <div class="col-md-6">
                                        <label class="form-label">Nomor PO (Purchase Order)</label>
                                        <input type="text" name="po" class="form-control"
                                            placeholder="Contoh: PO-2023-XXXX"
                                            value="{{ old('po', $activity->po ?? '') }}">
                                    </div>
                                </div>

                                <div class="table-responsive border rounded mb-4">
                                    <table class="table table-hover mb-0" id="dynamicTable">
                                        <thead>
                                            <tr>
                                                <th>Part Name</th>
                                                <th>Material</th>
                                                <th width="100">Qty</th>
                                                <th>Heat No</th>
                                                <th>Remarks</th>
                                                <th width="50">#</th>
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
                                                    <td><input type="text" name="part_name[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item['part_name'] ?? '' }}"></td>
                                                    <td><input type="text" name="material[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item['material'] ?? '' }}"></td>
                                                    <td><input type="number" name="qty[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item['qty'] ?? '' }}"></td>
                                                    <td><input type="text" name="heat_no[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item['heat_no'] ?? '' }}"></td>
                                                    <td><input type="text" name="remarks[]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item['remarks'] ?? '' }}"></td>
                                                    <td>
                                                        @if ($i === 0)
                                                            <button type="button" class="btn btn-sm btn-icon btn-primary"
                                                                id="addRow"><i class="bx bx-plus"></i></button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-sm btn-icon btn-danger removeRow"><i
                                                                    class="bx bx-trash"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-3">
                                <button type="reset" class="btn btn-label-secondary">Reset Form</button>
                                <button type="submit" class="btn btn-success px-5">
                                    <i class="bx bx-save me-1"></i> Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const typeSelect = document.getElementById("type");
            const productionFields = document.querySelectorAll(".production-only");

            function toggleFields() {
                if (typeSelect.value === "production") {
                    productionFields.forEach(el => el.classList.remove('d-none'));
                } else {
                    productionFields.forEach(el => el.classList.add('d-none'));
                }
            }

            toggleFields();
            typeSelect.addEventListener("change", toggleFields);

            // Dynamic Table Logic
            const tableBody = document.querySelector("#dynamicTable tbody");
            const addBtn = document.getElementById("addRow");

            if (addBtn) {
                addBtn.addEventListener("click", function() {
                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
                        <td><input type="text" name="part_name[]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="material[]" class="form-control form-control-sm"></td>
                        <td><input type="number" name="qty[]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="heat_no[]" class="form-control form-control-sm"></td>
                        <td><input type="text" name="remarks[]" class="form-control form-control-sm"></td>
                        <td><button type="button" class="btn btn-sm btn-icon btn-danger removeRow"><i class="bx bx-trash"></i></button></td>
                    `;
                    tableBody.appendChild(newRow);
                });
            }

            tableBody.addEventListener("click", function(e) {
                const target = e.target.closest(".removeRow");
                if (target) {
                    target.closest("tr").remove();
                }
            });

            // Date Constraint Logic
            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');

            if (startInput.value) endInput.min = startInput.value;

            startInput.addEventListener('change', function() {
                endInput.min = this.value;
                if (endInput.value && endInput.value < this.value) {
                    endInput.value = this.value;
                }
            });
        });
    </script>
@endsection
