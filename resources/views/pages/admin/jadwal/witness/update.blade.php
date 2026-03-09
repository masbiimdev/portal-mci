@extends('layouts.admin')
@section('title', 'Jadwal Witness | ' . (isset($activity) ? 'Edit' : 'Tambah') . ' Data')

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

        #dynamicTable thead th {
            background-color: #f8f9fa;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
        }

        .card {
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }

        .production-only {
            display: none;
            /* Akan dikontrol via JS */
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
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
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

                            {{-- Section 1: Informasi Dasar --}}
                            <div class="form-section-title">
                                <i class="bx bx-info-circle text-primary"></i> Informasi Dasar
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Tipe Kegiatan</label>
                                    <select name="type" id="type"
                                        class="form-select @if (isset($activity)) bg-light @endif" required
                                        @if (isset($activity)) disabled @endif>
                                        @foreach (['meeting', 'production', 'other'] as $type)
                                            <option value="{{ $type }}"
                                                {{ old('type', $activity->type ?? '') == $type ? 'selected' : '' }}>
                                                {{ ucfirst($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if (isset($activity))
                                        <input type="hidden" name="type" value="{{ $activity->type }}">
                                    @endif
                                </div>
                                <div class="col-md-6">
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

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Rentang Tanggal</label>
                                    <div class="input-group">
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                            value="{{ old('start_date', $activity->start_date ?? '') }}" required>
                                        <span class="input-group-text">s/d</span>
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                            value="{{ old('end_date', $activity->end_date ?? '') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Customer</label>
                                    <input type="text" name="customer" class="form-control"
                                        placeholder="Nama Perusahaan / Klien"
                                        value="{{ old('customer', $activity->customer ?? '') }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Nama Kegiatan</label>
                                <input type="text" name="kegiatan" class="form-control"
                                    placeholder="Contoh: Witness Testing Gate Valve"
                                    value="{{ old('kegiatan', $activity->kegiatan ?? '') }}" required>
                            </div>

                            {{-- Section 2: Detail Produksi --}}
                            <div class="production-only">
                                <div class="form-section-title">
                                    <i class="bx bx-package text-warning"></i> Detail Produksi & Parts
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Nomor PO (Purchase Order)</label>
                                        <input type="text" name="po" class="form-control"
                                            placeholder="Masukkan No. PO" value="{{ old('po', $activity->po ?? '') }}">
                                    </div>
                                </div>

                                <div class="table-responsive border rounded p-2 mb-4 bg-light">
                                    <table class="table table-sm table-hover align-middle mb-0" id="dynamicTable">
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
                                                            <button type="button"
                                                                class="btn btn-sm btn-icon btn-primary shadow-sm"
                                                                id="addRow"><i class="bx bx-plus"></i></button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-sm btn-icon btn-danger removeRow shadow-sm"><i
                                                                    class="bx bx-trash"></i></button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- Section 3: Catatan --}}
                            <div class="mb-4">
                                <label class="form-label">Keterangan / Remarks</label>
                                <textarea name="remarks" class="form-control" rows="3" placeholder="Tambahkan catatan khusus jika ada...">{{ old('remarks', $activity->remarks ?? '') }}</textarea>
                            </div>

                            <div class="d-flex justify-content-end gap-3 mt-4 border-top pt-4">
                                <button type="reset" class="btn btn-label-secondary">Reset</button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bx bx-save me-1"></i> Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const typeSelect = document.getElementById("type");
            const productionFields = document.querySelectorAll(".production-only");

            function toggleFields() {
                if (typeSelect.value === "production") {
                    productionFields.forEach(el => el.style.display = "block");
                } else {
                    productionFields.forEach(el => el.style.display = "none");
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
                    <td><button type="button" class="btn btn-sm btn-icon btn-danger removeRow shadow-sm"><i class="bx bx-trash"></i></button></td>
                `;
                    tableBody.appendChild(newRow);
                });
            }

            tableBody.addEventListener("click", function(e) {
                const deleteBtn = e.target.closest(".removeRow");
                if (deleteBtn) {
                    deleteBtn.closest("tr").remove();
                }
            });

            // Date Logic
            const startInput = document.getElementById('start_date');
            const endInput = document.getElementById('end_date');

            startInput.addEventListener('change', function() {
                endInput.min = this.value;
                if (endInput.value && endInput.value < this.value) {
                    endInput.value = this.value;
                }
            });
        });
    </script>
@endpush
