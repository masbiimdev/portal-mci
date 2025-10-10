@extends('layouts.admin')
@section('title', 'Akses Ditolak')

@section('content')
<div class="container py-5 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="text-center">
        <div class="mb-4">
            <h1 class="display-1 fw-bold text-danger animate__animated animate__fadeInDown">403</h1>
            <h4 class="fw-semibold text-dark mb-3 animate__animated animate__fadeInUp">
                Akses Ditolak
            </h4>
            <p class="text-muted mb-4 animate__animated animate__fadeInUp animate__delay-1s">
                Anda tidak memiliki hak akses untuk membuka halaman ini.<br>
                <span class="text-secondary">Silahkan hubungi <strong>administrator</strong> untuk mendapatkan izin akses.</span>
            </p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2 animate__animated animate__fadeInUp animate__delay-2s">
            <i class="bx bx-home"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush
@endsection
