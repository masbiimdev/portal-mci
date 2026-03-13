@extends('layouts.admin')
@section('title', 'Edit Modul | MCI')

@push('css')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --surface: #ffffff;
            --bg-body: #f8fafc;
            --border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --radius-md: 12px;
            --radius-lg: 20px;
            --shadow-sm: 0 2px 4px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
        }

        /* ================= HEADER ================= */
        .page-header {
            margin-bottom: 2rem;
        }

        .breadcrumb-custom {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 0.75rem;
        }

        .breadcrumb-custom a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.2s;
        }

        .breadcrumb-custom a:hover {
            color: var(--primary-hover);
        }

        .header-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ================= CARD & FORM ================= */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            padding: 2.5rem;
            max-width: 800px;
            /* Membatasi lebar agar form tidak terlalu melar di layar besar */
            transition: all 0.3s ease;
        }

        .form-card:hover {
            box-shadow: var(--shadow-md);
        }

        .form-label-custom {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            margin-bottom: 8px;
            display: block;
        }

        .form-control-custom {
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            padding: 0.8rem 1.2rem;
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-main);
            background-color: var(--bg-body);
            transition: all 0.25s ease;
            width: 100%;
        }

        .form-control-custom:focus {
            background-color: var(--surface);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            outline: none;
        }

        .form-control-custom::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .help-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ================= BUTTONS ================= */
        .action-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 2.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
        }

        .btn-custom {
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
            color: white;
        }

        .btn-back {
            background: var(--surface);
            color: var(--text-700);
            border: 1.5px solid var(--border);
        }

        .btn-back:hover {
            background: var(--bg-body);
            color: var(--text-900);
            border-color: #cbd5e1;
        }

        /* Input Group Icon */
        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.2rem;
        }

        .input-group-custom .form-control-custom {
            padding-left: 3rem;
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- HEADER --}}
        <div class="page-header">
            <div class="breadcrumb-custom">
                <i class="bx bx-home-alt"></i>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <i class="bx bx-chevron-right"></i>
                <a href="{{ route('modules.index') }}">Manajemen Modul</a>
                <i class="bx bx-chevron-right"></i>
                <span style="color: var(--text-main);">Edit Modul</span>
            </div>
            <h2 class="header-title">
                <i class="bx bx-edit text-primary"></i> Edit Data Modul
            </h2>
        </div>

        {{-- FORM CARD --}}
        <div class="form-card">

            {{-- Notifikasi Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center mb-4 border-0"
                    style="background-color: #fef2f2; color: #dc2626; border-radius: 12px; padding: 1rem;">
                    <i class='bx bx-error-circle fs-4 me-3'></i>
                    <div>
                        <div class="fw-bold mb-1">Gagal menyimpan data!</div>
                        <ul class="mb-0 ps-3" style="font-size: 0.85rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('modules.update', $module->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    {{-- Nama Modul --}}
                    <div class="col-12">
                        <label for="name" class="form-label-custom">Nama Modul <span
                                class="text-danger">*</span></label>
                        <div class="input-group-custom">
                            <i class='bx bx-cube-alt'></i>
                            <input type="text" id="name" name="name" class="form-control-custom"
                                value="{{ old('name', $module->name) }}" placeholder="Contoh: Document Control" required
                                autofocus>
                        </div>
                        <div class="help-text"><i class='bx bx-info-circle'></i> Nama yang akan ditampilkan di aplikasi.
                        </div>
                    </div>

                    {{-- Slug --}}
                    <div class="col-md-6">
                        <label for="slug" class="form-label-custom">Slug (URL) <span
                                class="text-danger">*</span></label>
                        <div class="input-group-custom">
                            <i class='bx bx-link'></i>
                            <input type="text" id="slug" name="slug" class="form-control-custom"
                                value="{{ old('slug', $module->slug) }}" placeholder="contoh: document-control" required>
                        </div>
                        <div class="help-text"><i class='bx bx-info-circle'></i> Digunakan untuk identifier URL (huruf
                            kecil, tanpa spasi).</div>
                    </div>

                    {{-- Route Name (BUG DIPERBAIKI DI SINI: name="route_name") --}}
                    <div class="col-md-6">
                        <label for="route_name" class="form-label-custom">Route Name <span
                                class="text-danger">*</span></label>
                        <div class="input-group-custom">
                            <i class='bx bx-sitemap'></i>
                            <input type="text" id="route_name" name="route_name" class="form-control-custom"
                                value="{{ old('route_name', $module->route_name) }}" placeholder="contoh: documents.index"
                                required>
                        </div>
                        <div class="help-text"><i class='bx bx-info-circle'></i> Nama route utama di Laravel (web.php).
                        </div>
                    </div>
                </div>

                {{-- Aksi --}}
                <div class="action-area">
                    <button type="submit" class="btn-custom btn-save">
                        <i class="bx bx-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('modules.index') }}" class="btn-custom btn-back">
                        <i class="bx bx-left-arrow-alt"></i> Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('js')
    <script>
        // Opsional: Membuat Auto-Slug sederhana jika nama modul diketik
        // (Bisa dihapus jika kamu lebih suka mengisi slug secara manual)
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            // Hanya auto-fill slug jika user mengedit text nama
            nameInput.addEventListener('input', function() {
                // Ubah text menjadi slug format (lowercase, ganti spasi dengan strip)
                let slugValue = this.value.toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '') // Hapus karakter non-alphanumeric
                    .replace(/\s+/g, '-') // Ganti spasi dengan strip
                    .replace(/-+/g, '-'); // Hapus strip berlebih

                // Un-comment kode di bawah ini jika ingin slug OTOMATIS berubah saat nama diedit.
                // slugInput.value = slugValue; 
            });
        });
    </script>
@endpush
