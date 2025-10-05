@extends('layouts.scan')
@section('title', 'Scan Jobcard')

@section('content')
<div class="scan-card">
    <h5>📄 Informasi Jobcard</h5>
    <p><strong>Jobcard:</strong> {{ $jobcard->jobcard_no }}</p>
    <p><strong>Customer:</strong> {{ $jobcard->customer }}</p>
    <p><strong>WS No:</strong> {{ $jobcard->ws_no }}</p>

    <hr>

    <h5>👤 Operator</h5>
    <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
    <p><strong>Departemen:</strong> {{ auth()->user()->departemen ?? '-' }}</p>

    <hr>

    <form action="{{ route('jobcards.scan', $jobcard->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Proses</label>
            <input type="text" name="process_name" class="form-control form-control-lg" placeholder="Masukkan nama proses" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <input type="text" name="remarks" class="form-control form-control-lg" placeholder="Opsional">
        </div>

        <button type="submit" class="btn btn-scan">✅ Submit Scan</button>
    </form>
</div>
@endsection
