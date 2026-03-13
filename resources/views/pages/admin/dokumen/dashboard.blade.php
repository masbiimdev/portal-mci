@extends('layouts.admin')
@section('title', 'Document Dashboard | Metinca')

@push('css')
    <style>
        /* ================= KARTU RINGKASAN PREMIUM ================= */
        .stat-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            position: relative;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .stat-card.card-project::before {
            background-color: #3b82f6;
        }

        /* Blue */
        .stat-card.card-folder::before {
            background-color: #f59e0b;
        }

        /* Amber */
        .stat-card.card-document::before {
            background-color: #0ea5e9;
        }

        /* Light Blue */
        .stat-card.card-storage::before {
            background-color: #10b981;
        }

        /* Emerald */

        .stat-card .card-body {
            padding: 1.5rem;
            position: relative;
            z-index: 2;
        }

        /* Watermark Ikon di Latar Belakang Kartu */
        .stat-card .icon-watermark {
            position: absolute;
            right: -10px;
            bottom: -15px;
            font-size: 6rem;
            opacity: 0.04;
            transform: rotate(-15deg);
            transition: all 0.3s ease;
            z-index: 1;
        }

        .stat-card:hover .icon-watermark {
            transform: rotate(0deg) scale(1.1);
            opacity: 0.08;
        }

        .stat-value {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.2;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .stat-title {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Ikon Kecil di Judul */
        .title-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 8px;
            font-size: 1.1rem;
        }

        /* ================= KARTU AKSES CEPAT ================= */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
            border-radius: 16px;
        }

        .quick-action-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            backdrop-filter: blur(4px);
            transition: all 0.2s ease;
        }

        .quick-action-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            transform: translateY(-2px);
        }

        /* ================= ANIMASI ================= */
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        .delay-3 {
            animation-delay: 0.3s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Desain Tabel Custom */
        .table-custom-header th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(59, 130, 246, 0.03);
        }

        /* Label/Badge Folder & Project */
        .badge-project {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            font-weight: 600;
        }

        .badge-folder {
            background-color: #fffbeb;
            color: #d97706;
            border: 1px solid #fde68a;
            font-weight: 600;
        }

        /* PDF Viewer Modal CSS */
        .modal-xl-custom {
            max-width: 90%;
        }

        #pdfViewerEmbed {
            width: 100%;
            height: 75vh;
            border: none;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')

    {{-- Inisialisasi Perhitungan Data --}}
    @php
        $now = \Carbon\Carbon::now();

        $totalProjects = $projects->count();
        $newProjectsThisMonth = $projects->where('created_at', '>=', $now->startOfMonth())->count();

        $totalFolders = $folders->count();

        $totalDocuments = $documents->count();
        $newDocumentsThisWeek = $documents->where('created_at', '>=', $now->startOfWeek())->count();

        // Mengambil 6 dokumen terbaru agar tabel lebih terisi
        $recentDocuments = $documents->take(6);
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4 fade-in-up">
            <span class="text-muted fw-light">Document /</span> Dashboard
        </h4>

        {{-- 1. KARTU STATISTIK (SUMMARY CARDS) --}}
        <div class="row mb-4">

            {{-- Kartu Total Project --}}
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4 fade-in-up">
                <div class="stat-card card-project">
                    <div class="card-body">
                        <i class='bx bx-briefcase icon-watermark text-primary'></i>
                        <div class="stat-title mb-2">
                            <span class="title-icon bg-primary bg-opacity-10 text-primary"><i
                                    class='bx bx-briefcase'></i></span>
                            Total Project
                        </div>
                        <div class="stat-value">{{ $totalProjects }}</div>
                        <div class="mt-2 pt-2 border-top border-light">
                            @if ($newProjectsThisMonth > 0)
                                <span class="badge bg-label-success fw-semibold rounded-pill me-1 px-2 py-1">
                                    <i class='bx bx-up-arrow-alt'></i> {{ $newProjectsThisMonth }}
                                </span>
                                <span class="text-muted" style="font-size: 0.75rem;">baru bulan ini</span>
                            @else
                                <span class="text-muted" style="font-size: 0.75rem;"><i class='bx bx-minus'></i> Tidak ada
                                    penambahan</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Total Folder --}}
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4 fade-in-up delay-1">
                <div class="stat-card card-folder">
                    <div class="card-body">
                        <i class='bx bx-folder-open icon-watermark text-warning'></i>
                        <div class="stat-title mb-2">
                            <span class="title-icon bg-warning bg-opacity-10 text-warning"><i
                                    class='bx bx-folder-open'></i></span>
                            Total Folder
                        </div>
                        <div class="stat-value">{{ $totalFolders }}</div>
                        <div class="mt-2 pt-2 border-top border-light">
                            <span class="text-muted" style="font-size: 0.75rem;">
                                <i class='bx bx-sitemap me-1'></i> Tersebar di semua project
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Total Dokumen --}}
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4 fade-in-up delay-2">
                <div class="stat-card card-document">
                    <div class="card-body">
                        <i class='bx bx-file icon-watermark text-info'></i>
                        <div class="stat-title mb-2">
                            <span class="title-icon bg-info bg-opacity-10 text-info"><i class='bx bx-file'></i></span>
                            Total Dokumen
                        </div>
                        <div class="stat-value">{{ $totalDocuments }}</div>
                        <div class="mt-2 pt-2 border-top border-light">
                            @if ($newDocumentsThisWeek > 0)
                                <span class="badge bg-label-info fw-semibold rounded-pill me-1 px-2 py-1">
                                    <i class='bx bx-up-arrow-alt'></i> {{ $newDocumentsThisWeek }}
                                </span>
                                <span class="text-muted" style="font-size: 0.75rem;">baru minggu ini</span>
                            @else
                                <span class="text-muted" style="font-size: 0.75rem;"><i class='bx bx-minus'></i> Belum ada
                                    minggu ini</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kartu Kapasitas Disk --}}
            <div class="col-lg-3 col-md-6 col-sm-6 mb-4 fade-in-up delay-3">
                <div class="stat-card card-storage">
                    <div class="card-body">
                        <i class='bx bx-hdd icon-watermark text-success'></i>
                        <div class="stat-title mb-2">
                            <span class="title-icon bg-success bg-opacity-10 text-success"><i
                                    class='bx bx-server'></i></span>
                            Status Server
                        </div>
                        <div class="stat-value" style="font-size: 1.8rem; padding-top: 0.2rem;">Optimal</div>
                        <div class="mt-2 pt-2 border-top border-light">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="text-muted" style="font-size: 0.75rem;">Kapasitas Aktif</span>
                                <span class="text-success fw-bold" style="font-size: 0.75rem;">Online</span>
                            </div>
                            <div class="progress" style="height: 4px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 100%"
                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- 2. KONTEN UTAMA (TABEL & QUICK ACTION) --}}
        <div class="row">

            <div class="col-xl-8 col-lg-7 mb-4 fade-in-up delay-1">
                <div class="card stat-card h-100">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                            <span class="title-icon bg-primary bg-opacity-10 text-primary me-2"><i
                                    class="bx bx-time-five"></i></span>
                            Dokumen Terbaru
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light table-custom-header">
                                    <tr>
                                        <th class="ps-4">Nama Dokumen</th>
                                        <th>Project</th>
                                        <th>Folder</th>
                                        <th>Tanggal</th>
                                        <th class="text-center pe-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentDocuments as $doc)
                                        @php
                                            // LOGIKA NAMA FILE
                                            $rawPath = $doc->file_path ?? '';
                                            $fileNameFromPath = basename($rawPath);
                                            $docName =
                                                $doc->title ?? ($doc->document_name ?? ($doc->file_name ?? $doc->name));

                                            if (empty($docName)) {
                                                $docName = $fileNameFromPath ?: 'Untitled Document';
                                            }

                                            // PEMISAHAN LOGIKA PROJECT & FOLDER
                                            $projectName = $doc->project->project_name ?? '-';
                                            $folderName = $doc->folder->folder_name ?? '-';

                                            // Deteksi Ekstensi File
                                            $ext = pathinfo($rawPath, PATHINFO_EXTENSION);
                                            if (empty($ext) && isset($doc->file_type)) {
                                                $ext = strtolower($doc->file_type);
                                            }

                                            $iconClass = 'bx-file text-secondary';
                                            if (in_array($ext, ['pdf'])) {
                                                $iconClass = 'bxs-file-pdf text-danger';
                                            } elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) {
                                                $iconClass = 'bxs-file-blank text-success';
                                            } elseif (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                                                $iconClass = 'bxs-image text-info';
                                            } elseif (in_array($ext, ['doc', 'docx'])) {
                                                $iconClass = 'bxs-file-doc text-primary';
                                            }

                                            // URL File
                                            $fileUrl = $rawPath ? asset('storage/' . $rawPath) : '#';
                                        @endphp
                                        <tr>
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="title-icon bg-light me-3 shadow-sm border text-center"
                                                        style="width: 40px; height: 40px; font-size: 1.5rem;">
                                                        <i class='bx {{ $iconClass }}'></i>
                                                    </div>
                                                    <div>
                                                        <span class="fw-semibold text-dark d-block text-truncate"
                                                            style="max-width: 180px;" title="{{ $docName }}">
                                                            {{ $docName }}
                                                        </span>
                                                        <small class="text-muted">
                                                            @if ($doc->user)
                                                                Oleh: <span class="fw-medium">{{ $doc->user->name }}</span>
                                                            @else
                                                                Ext: <span
                                                                    class="text-uppercase fw-medium">{{ $ext ?: 'Unknown' }}</span>
                                                            @endif
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                @if ($projectName !== '-')
                                                    <span class="badge badge-project rounded-pill px-3 py-2 text-truncate"
                                                        style="max-width: 130px;" title="{{ $projectName }}">
                                                        <i class='bx bx-briefcase me-1'></i> {{ $projectName }}
                                                    </span>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($folderName !== '-')
                                                    <span class="badge badge-folder rounded-pill px-3 py-2 text-truncate"
                                                        style="max-width: 130px;" title="{{ $folderName }}">
                                                        <i class='bx bx-folder me-1'></i> {{ $folderName }}
                                                    </span>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>

                                            <td class="text-muted small">
                                                <div class="d-flex align-items-center">
                                                    <i class='bx bx-calendar-alt me-2 text-secondary fs-6'></i>
                                                    {{ $doc->created_at->format('d M Y') }}
                                                </div>
                                            </td>

                                            <td class="text-center pe-4">
                                                <button type="button"
                                                    class="btn btn-sm btn-info shadow-sm btn-view-pdf rounded-pill px-3"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Pratinjau Dokumen" data-fileurl="{{ $fileUrl }}"
                                                    data-filename="{{ $docName }}"
                                                    data-fileext="{{ $ext }}">
                                                    <i class="bx bx-show me-1"></i> View
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <div class="d-flex flex-column align-items-center">
                                                    <div class="bg-light rounded-circle p-4 mb-3">
                                                        <i class='bx bx-folder-open text-muted'
                                                            style="font-size: 3.5rem;"></i>
                                                    </div>
                                                    <span class="fw-bold text-dark fs-5">Belum ada dokumen</span>
                                                    <p class="text-muted mt-1">Dokumen yang baru diunggah akan otomatis
                                                        muncul di sini.</p>
                                                    <button class="btn btn-primary mt-2 shadow-sm rounded-pill px-4"><i
                                                            class='bx bx-upload me-2'></i> Unggah Sekarang</button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5 mb-4 fade-in-up delay-2">

                <div class="card stat-card mb-4 bg-gradient-primary text-white overflow-hidden p-1">
                    <div class="card-body position-relative zindex-1 p-4">
                        <h5 class="card-title text-white mb-2 fw-bold d-flex align-items-center"
                            style="font-size: 1.25rem;">
                            <i class='bx bx-rocket me-2 fs-3 text-warning'></i> Akses Cepat
                        </h5>
                        <p class="mb-4 text-white-50" style="font-size: 0.9rem; line-height: 1.5;">
                            Jalan pintas untuk mengelola operasional dokumen Anda hari ini.
                        </p>
                        <div class="d-grid gap-3">
                            <a href="#"
                                class="btn btn-light text-primary fw-bold shadow-lg rounded-pill py-2 d-flex justify-content-center align-items-center">
                                <i class="bx bx-upload fs-5 me-2"></i> Unggah Dokumen
                            </a>
                            <a href="{{ route('document.project.create') }}"
                                class="btn quick-action-btn rounded-pill py-2 d-flex justify-content-center align-items-center">
                                <i class="bx bx-plus-circle fs-5 me-2"></i> Buat Project Baru
                            </a>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0 p-3 opacity-25"
                        style="pointer-events: none; transform: translate(15%, 25%);">
                        <i class="bx bx-folder-plus" style="font-size: 10rem;"></i>
                    </div>
                </div>

                <div class="card stat-card">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-4 d-flex align-items-center text-uppercase"
                            style="letter-spacing: 0.5px; font-size: 0.85rem;">
                            <span class="title-icon bg-success bg-opacity-10 text-success me-2"><i
                                    class='bx bx-shield-quarter'></i></span>
                            Status Sistem
                        </h6>
                        <ul class="list-unstyled mb-0 mt-2">
                            <li class="d-flex mb-4 align-items-center p-3 rounded-3"
                                style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                                <div
                                    class="bg-white p-2 rounded-circle me-3 shadow-sm text-success border border-success border-opacity-25">
                                    <i class='bx bx-check fs-4 d-block'></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark fs-6">Penyimpanan Terhubung</h6>
                                    <small class="text-muted">Server berjalan normal</small>
                                </div>
                            </li>
                            <li class="d-flex align-items-center p-3 rounded-3"
                                style="background-color: #f8fafc; border: 1px solid #f1f5f9;">
                                <div
                                    class="bg-white p-2 rounded-circle me-3 shadow-sm text-primary border border-primary border-opacity-25">
                                    <i class='bx bx-sync fs-4 d-block'></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold text-dark fs-6">Sinkronisasi Aktif</h6>
                                    <small class="text-muted">Diperbarui {{ $now->format('H:i') }} WIB</small>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- 3. MODAL PDF VIEWER (TETAP SAMA) --}}
    <div class="modal fade" id="documentViewerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-xl-custom">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-white border-bottom py-3">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center" id="viewerModalTitle">
                        <i class="bx bxs-file text-primary me-2 fs-4" id="viewerIconTitle"></i>
                        <span id="viewerFileName" class="text-truncate" style="max-width: 600px;">Loading...</span>
                    </h5>
                    <div class="d-flex align-items-center">
                        <a href="#" id="viewerDownloadBtn"
                            class="btn btn-sm btn-primary rounded-pill px-3 me-3 shadow-sm" download>
                            <i class="bx bx-download me-1"></i> Unduh
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body p-0 bg-dark position-relative">
                    <div id="viewerUnsupportedMessage"
                        class="d-none text-center py-5 text-white w-100 position-absolute top-50 start-50 translate-middle">
                        <i class="bx bx-error-circle text-warning mb-3" style="font-size: 5rem;"></i>
                        <h4 class="fw-bold">Format tidak didukung</h4>
                        <p class="text-white-50 mb-4">Browser tidak dapat mempratinjau file dengan ekstensi ini.<br>Silakan
                            unduh file untuk melihat isinya.</p>
                    </div>
                    <embed id="pdfViewerEmbed" src="" type="application/pdf" class="d-none">
                    <div id="imageViewerContainer" class="d-none text-center p-4">
                        <img id="imageViewerImg" src="" alt="Preview" class="rounded shadow"
                            style="max-width: 100%; max-height: 70vh; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
