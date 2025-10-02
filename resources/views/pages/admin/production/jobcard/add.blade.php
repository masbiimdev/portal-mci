@extends('layouts.admin')
@section('title')
    Jobcard | MCI | {{ isset($jobcard) ? 'Edit Data' : 'Tambah Data' }}
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Jobcard /</span>
        {{ isset($jobcard) ? 'Edit' : 'Tambah' }}
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
            <h5 class="mb-0">{{ isset($jobcard) ? 'Edit' : 'Tambah' }} Jobcard</h5>
        </div>
        <div class="card-body">
            <form action="{{ isset($jobcard) ? route('jobcards.update', $jobcard->id) : route('jobcards.store') }}" method="POST">
                @csrf
                @if (isset($jobcard))
                    @method('PUT')
                @endif


                {{-- WS No --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">WS No</label>
                    <div class="col-sm-10">
                        <input type="text" name="ws_no" class="form-control"
                               value="{{ old('ws_no', $jobcard->ws_no ?? '') }}" required>
                    </div>
                </div>

                {{-- Customer --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Customer</label>
                    <div class="col-sm-10">
                        <input type="text" name="customer" class="form-control"
                               value="{{ old('customer', $jobcard->customer ?? '') }}" required>
                    </div>
                </div>

                {{-- Serial No --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Serial No</label>
                    <div class="col-sm-10">
                        <input type="text" name="serial_no" class="form-control"
                               value="{{ old('serial_no', $jobcard->serial_no ?? '') }}" required>
                    </div>
                </div>

                {{-- Drawing No --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Drawing No</label>
                    <div class="col-sm-10">
                        <input type="text" name="drawing_no" class="form-control"
                               value="{{ old('drawing_no', $jobcard->drawing_no ?? '') }}">
                    </div>
                </div>

                {{-- Disc, Body, Bonnet --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Disc</label>
                    <div class="col-sm-10">
                        <input type="text" name="disc" class="form-control"
                               value="{{ old('disc', $jobcard->disc ?? '') }}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Body</label>
                    <div class="col-sm-10">
                        <input type="text" name="body" class="form-control"
                               value="{{ old('body', $jobcard->body ?? '') }}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Bonnet</label>
                    <div class="col-sm-10">
                        <input type="text" name="bonnet" class="form-control"
                               value="{{ old('bonnet', $jobcard->bonnet ?? '') }}">
                    </div>
                </div>

                {{-- Size/Class --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Size / Class</label>
                    <div class="col-sm-10">
                        <input type="text" name="size_class" class="form-control"
                               value="{{ old('size_class', $jobcard->size_class ?? '') }}">
                    </div>
                </div>

                {{-- Type --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Type</label>
                    <div class="col-sm-10">
                        <input type="text" name="type" class="form-control"
                               value="{{ old('type', $jobcard->type ?? '') }}">
                    </div>
                </div>

                {{-- Qty acc PO --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Qty acc PO</label>
                    <div class="col-sm-10">
                        <input type="number" name="qty_acc_po" class="form-control"
                               value="{{ old('qty_acc_po', $jobcard->qty_acc_po ?? 0) }}">
                    </div>
                </div>

                {{-- Date Line --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Date Line</label>
                    <div class="col-sm-10">
                        <input type="date" name="date_line" class="form-control"
                               value="{{ old('date_line', isset($jobcard->date_line) ? $jobcard->date_line->format('Y-m-d') : '') }}">
                    </div>
                </div>

                {{-- Category --}}
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">Category</label>
                    <div class="col-sm-10">
                        <select name="category" class="form-select" required>
                            @foreach(['Reused','Repair','New Manufacture','Supplied'] as $cat)
                                <option value="{{ $cat }}"
                                    {{ old('category', $jobcard->category ?? '') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Created By --}}
                <input type="hidden" name="created_by" value="{{ auth()->id() }}">

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
    </div>
</div>
@endsection
