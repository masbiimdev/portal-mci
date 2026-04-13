@extends('layouts.home')

@section('title', 'Folder ' . $folder->folder_name . ' — Document Transmittal')

@push('css')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ========== BENTO CORE SYSTEM ========== */
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #2563eb;
            --accent-hover: #1d4ed8;
            --accent-soft: #eff6ff;
            --success: #16a34a;
            --warning: #ea580c;
            --danger: #dc2626;
            --bg: #f8fafc;
            --card: #ffffff;
            --muted: #64748b;
            --border: #e2e8f0;
            --radius-bento: 28px;
            --radius-md: 18px;
            --shadow-bento: 0 10px 15px -3px rgba(0, 0, 0, 0.04), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--primary);
            -webkit-font-smoothing: antialiased;
            background-image: radial-gradient(#e2e8f0 1.2px, transparent 1.2px);
            background-size: 30px 30px;
        }

        .container-main {
            max-width: 1440px;
            margin: 0 auto;
            padding: 2.5rem;
            min-height: 100vh;
        }

        /* ========== BENTO GRID LAYOUT ========== */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: auto auto;
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .bento-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-bento);
            padding: 2rem;
            box-shadow: var(--shadow-bento);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .bento-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 30px -10px rgba(0, 0, 0, 0.06);
            border-color: #cbd5e1;
        }

        /* Card: Info Utama (Lebar 2 Kolom) */
        .card-main-info {
            grid-column: span 2;
            grid-row: span 2;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white;
            border: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-main-info::after {
            content: '\eb31';
            font-family: 'boxicons';
            position: absolute;
            right: -30px;
            bottom: -40px;
            font-size: 16rem;
            color: rgba(255, 255, 255, 0.03);
            pointer-events: none;
        }

        .card-main-info h2 {
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .card-main-info p {
            font-size: 1.05rem;
            color: #94a3b8;
            line-height: 1.7;
            max-width: 90%;
            z-index: 2;
        }

        /* Card: Stats */
        .card-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .stat-label {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--muted);
            margin-bottom: 0.75rem;
        }

        .stat-value {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .stat-value.project-code {
            font-family: 'Monaco', 'Consolas', monospace;
            font-size: 1.6rem;
            color: var(--accent);
            background: var(--accent-soft);
            padding: 8px 16px;
            border-radius: 12px;
        }

        /* Card: Last Activity (Lebar 2 Kolom) */
        .card-activity {
            grid-column: span 2;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .activity-icon {
            width: 60px;
            height: 60px;
            background: var(--accent-soft);
            color: var(--accent);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        /* ========== TABLE SECTION (SEAMLESS) ========== */
        .bento-content-container {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-bento);
            box-shadow: var(--shadow-bento);
            overflow: hidden;
        }

        .table-toolbar {
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            border-bottom: 1px solid var(--border);
        }

        .search-container {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f1f5f9;
            padding: 0.8rem 1.5rem;
            border-radius: 16px;
            flex: 1;
            max-width: 500px;
            transition: var(--transition);
        }

        .search-container:focus-within {
            background: #fff;
            box-shadow: 0 0 0 3px var(--accent-soft);
            border: 1px solid var(--accent);
        }

        .search-container input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-weight: 600;
            font-size: 1rem;
            color: var(--primary);
        }

        /* Table Styling */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        th {
            background: #f8fafc;
            padding: 1.25rem 2rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 800;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            transition: var(--transition);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: var(--accent-soft);
        }

        /* File UI Components */
        .file-info-group {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .file-icon-box {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 0.8rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        /* Dynamic Colors for Ext */
        .bg-pdf {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        .bg-dwg {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        }

        .bg-excel {
            background: linear-gradient(135deg, #10b981, #047857);
        }

        .bg-word {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .bg-other {
            background: linear-gradient(135deg, #64748b, #334155);
        }

        .file-title {
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: block;
            margin-bottom: 4px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .file-title:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        /* Status & Badge */
        .badge-bento {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-bento.final {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .badge-bento.draft {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        /* Actions */
        .action-group {
            display: flex;
            gap: 8px;
            justify-content: flex-end;
        }

        .btn-circle {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border: 1px solid var(--border);
            color: var(--muted);
            transition: var(--transition);
            cursor: pointer;
            text-decoration: none;
        }

        .btn-circle:hover {
            background: var(--accent);
            color: white;
            transform: scale(1.1);
        }

        .btn-circle.btn-delete:hover {
            background: var(--danger);
        }

        /* ========== MODAL STYLE ========== */
        .modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 3000;
            padding: 1.5rem;
        }

        .modal[aria-hidden="false"] {
            display: flex;
        }

        .modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
        }

        .modal-container {
            position: relative;
            background: #fff;
            width: 100%;
            max-width: 600px;
            border-radius: var(--radius-bento);
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transform: scale(0.95);
            transition: var(--transition);
            opacity: 0;
        }

        .modal[aria-hidden="false"] .modal-container {
            transform: scale(1);
            opacity: 1;
        }

        .modal-header {
            padding: 2rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f8fafc;
        }

        .modal-body {
            padding: 2rem;
            max-height: 75vh;
            overflow-y: auto;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .input-bento {
            width: 100%;
            padding: 0.9rem 1.2rem;
            border-radius: 14px;
            border: 1.5px solid var(--border);
            background: #f8fafc;
            font-weight: 600;
            transition: var(--transition);
            font-family: inherit;
        }

        .input-bento:focus {
            border-color: var(--accent);
            background: #fff;
            box-shadow: 0 0 0 4px var(--accent-soft);
            outline: none;
        }

        /* Progress Bar for Downloads */
        #downloadProgressOverlay {
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .bento-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .bento-grid {
                grid-template-columns: 1fr;
            }

            .card-main-info,
            .card-activity {
                grid-column: span 1;
            }

            .table-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        <div
            style="margin-bottom: 2rem; display: flex; align-items: center; gap: 12px; font-weight: 700; font-size: 0.9rem;">
            <a href="{{ url('/portal/document') }}" style="color: var(--accent); text-decoration: none;">Projects</a>
            <i class="bx bx-chevron-right" style="color: var(--muted);"></i>
            <a href="{{ route('document.folder', $project->id) }}"
                style="color: var(--accent); text-decoration: none;">{{ $project->project_name }}</a>
            <i class="bx bx-chevron-right" style="color: var(--muted);"></i>
            <span style="color: var(--primary);">{{ $folder->folder_name }}</span>
        </div>

        <div class="bento-grid">
            <div class="bento-card card-main-info">
                <h2><i class="bx bx-folder-open"></i> {{ $folder->folder_name }}</h2>
                <p>{{ $folder->description ? $folder->description : 'Manajemen log transmittal, arsip teknis, dan kendali revisi dokumen untuk unit kerja ini.' }}
                </p>
            </div>

            <div class="bento-card card-stat">
                <span class="stat-label">Total Dokumen</span>
                <span class="stat-value">{{ $documents->count() }}</span>
            </div>

            <div class="bento-card card-stat">
                <span class="stat-label">Kode Project</span>
                <span
                    class="stat-value project-code">{{ $project->project_number ? $project->project_number : 'N/A' }}</span>
            </div>

            @php
                $last = $lastDocument ?? ($documents->count() ? $documents->sortByDesc('updated_at')->first() : null);
            @endphp
            <div class="bento-card card-activity">
                <div class="activity-icon">
                    <i class="bx bx-bolt-circle"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <span class="stat-label" style="margin:0">Terakhir Diperbarui</span>
                    @if ($last)
                        <a href="{{ route('document.show', $last->id) }}" class="file-title"
                            style="margin: 4px 0;">{{ $last->title }}</a>
                        <div style="font-size: 0.8rem; color: var(--muted);">
                            Oleh <b>{{ $last->user ? $last->user->name : 'System' }}</b> •
                            {{ $last->updated_at->format('d M Y, H:i') }} WIB
                        </div>
                    @else
                        <div style="color: var(--muted); font-size: 0.9rem; margin-top: 5px;">Belum ada riwayat dokumen.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="bento-content-container">
            <div class="table-toolbar">
                <div class="search-container">
                    <i class="bx bx-search" style="font-size: 1.3rem; color: var(--muted);"></i>
                    <input id="searchInput" type="text" placeholder="Cari nama atau nomor registrasi dokumen...">
                </div>

                <div style="display: flex; gap: 12px; align-items: center;">
                    <select id="statusFilter" class="input-bento" style="width: auto; padding-right: 2.5rem;">
                        <option value="">Semua Status</option>
                        <option value="FINAL">Final</option>
                        <option value="DRAFT">Draft</option>
                    </select>

                    @auth
                        <button onclick="openBentoModal('add')" class="btn-circle"
                            style="width: auto; padding: 0 1.5rem; background: var(--accent); color: white; border: none; font-weight: 800; gap: 8px;">
                            <i class="bx bx-plus"></i> Tambah Dokumen
                        </button>
                    @endauth
                </div>
            </div>

            <div class="table-responsive">
                <table id="documentTable">
                    <thead>
                        <tr>
                            <th width="45%">Nama Dokumen / Berkas</th>
                            <th width="15%">No. Registrasi</th>
                            <th width="10%">Revisi</th>
                            <th width="15%">Status</th>
                            <th width="15%" style="text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $doc)
                            @php
                                $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                                $isFinal = (bool) $doc->is_final;

                                // Map extension to color
                                $extColor = 'bg-other';
                                if ($ext == 'pdf') {
                                    $extColor = 'bg-pdf';
                                } elseif (in_array($ext, ['xls', 'xlsx'])) {
                                    $extColor = 'bg-excel';
                                } elseif (in_array($ext, ['doc', 'docx'])) {
                                    $extColor = 'bg-word';
                                } elseif ($ext == 'dwg') {
                                    $extColor = 'bg-dwg';
                                }
                            @endphp
                            <tr data-status="{{ $isFinal ? 'FINAL' : 'DRAFT' }}">
                                <td>
                                    <div class="file-info-group">
                                        <div class="file-icon-box {{ $extColor }}">{{ strtoupper($ext) ?: 'FILE' }}
                                        </div>
                                        <div style="min-width: 0;">
                                            <a href="{{ route('document.show', $doc->id) }}"
                                                class="file-title">{{ $doc->title }}</a>
                                            <div style="font-size: 0.75rem; color: var(--muted);">
                                                {{ $doc->updated_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-family: monospace; font-weight: 700; color: var(--primary-light);">
                                    {{ $doc->document_no ?: '—' }}</td>
                                <td><span
                                        style="background: #f1f5f9; padding: 4px 10px; border-radius: 8px; font-weight: 800; font-family: monospace;">v{{ $doc->revision }}</span>
                                </td>
                                <td><span
                                        class="badge-bento {{ $isFinal ? 'final' : 'draft' }}">{{ $isFinal ? 'FINAL' : 'DRAFT' }}</span>
                                </td>
                                <td>
                                    <div class="action-group">
                                        @if ($doc->file_path && file_exists(public_path($doc->file_path)))
                                            <a href="{{ route('document.show', $doc->id) }}" class="btn-circle"
                                                title="Lihat Detail / Preview">
                                                <i class="bx bx-show"></i>
                                            </a>

                                            <a href="{{ route('portal.document.download', $doc->id) }}"
                                                class="btn-circle btn-download-track" data-title="{{ $doc->title }}"
                                                title="Download File">
                                                <i class="bx bx-download"></i>
                                            </a>
                                        @else
                                            <div class="btn-circle" style="color: var(--danger); cursor: help;"
                                                title="File tidak ditemukan di server">
                                                <i class="bx bx-error-circle"></i>
                                            </div>
                                        @endif

                                        @auth
                                            <button
                                                onclick="openBentoModal('edit', {{ json_encode($doc) }}, '{{ route('document.update', $doc->id) }}')"
                                                class="btn-circle"
                                                {{ $isFinal ? 'disabled style=opacity:0.3;cursor:not-allowed' : '' }}
                                                title="Edit Data">
                                                <i class="bx bx-pencil"></i>
                                            </button>

                                            <form action="{{ route('documents.destroy', $doc->id) }}" method="POST"
                                                class="delete-form" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn-circle btn-delete" title="Hapus Permanen">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 6rem; text-align: center;">
                                    <div style="font-size: 4rem; color: #e2e8f0; margin-bottom: 1rem;"><i
                                            class="bx bx-folder-open"></i></div>
                                    <h3 style="font-weight: 800; color: var(--primary);">Folder Masih Kosong</h3>
                                    <p style="color: var(--muted); max-width: 400px; margin: 0 auto;">Belum ada berkas yang
                                        diunggah ke dalam direktori ini. Klik tombol Tambah Dokumen untuk memulai.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="bentoModal" class="modal" aria-hidden="true">
        <div class="modal-overlay" onclick="closeBentoModal()"></div>
        <div class="modal-container">
            <form id="bentoForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="bentoMethod" value="POST">
                <input type="hidden" name="document_project_id" value="{{ $project->id }}">
                <input type="hidden" name="document_folder_id" value="{{ $folder->id }}">

                <div class="modal-header">
                    <h3 id="bentoModalTitle"
                        style="margin:0; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                        <i class="bx bx-cloud-upload" style="color: var(--accent);"></i> <span>Upload Dokumen</span>
                    </h3>
                    <button type="button" onclick="closeBentoModal()"
                        style="background:none; border:none; font-size: 1.8rem; cursor:pointer; color:var(--muted);"><i
                            class="bx bx-x"></i></button>
                </div>

                <div class="modal-body">
                    <div style="margin-bottom: 1.5rem;">
                        <label
                            style="display:block; font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; margin-bottom: 8px;">Judul
                            Dokumen <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="title" id="f_title" class="input-bento"
                            placeholder="Contoh: Laporan Inspeksi Gate Valve" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
                        <div>
                            <label
                                style="display:block; font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; margin-bottom: 8px;">No.
                                Registrasi</label>
                            <input type="text" name="document_no" id="f_doc_no" class="input-bento"
                                placeholder="DOC-2026-001">
                        </div>
                        <div>
                            <label
                                style="display:block; font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; margin-bottom: 8px;">Revisi</label>
                            <input type="number" name="revision" id="f_rev" class="input-bento" value="0">
                        </div>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label
                            style="display:block; font-size: 0.75rem; font-weight: 800; color: var(--muted); text-transform: uppercase; margin-bottom: 8px;">Unggah
                            Berkas (PDF)</label>
                        <input type="file" name="file" id="f_file" class="input-bento" accept=".pdf"
                            style="padding: 0.6rem 1rem;">
                        <small id="fileHelpText"
                            style="display:block; margin-top: 6px; color: var(--muted); font-size: 0.75rem;"><i
                                class="bx bx-info-circle"></i> Ukuran maksimal 20MB. Hanya format PDF.</small>
                    </div>

                    <div
                        style="background: #f8fafc; padding: 1.25rem; border-radius: 18px; border: 1.5px solid var(--border); display: flex; align-items: center; justify-content: space-between;">
                        <div style="flex: 1;">
                            <div style="font-weight: 800; font-size: 0.95rem;">Kunci Dokumen (Final)</div>
                            <div style="font-size: 0.75rem; color: var(--muted);">Dokumen yang ditandai final tidak dapat
                                diubah kembali.</div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span id="finalLabel"
                                style="font-weight: 800; font-size: 0.8rem; color: var(--muted);">DRAFT</span>
                            <input type="checkbox" name="is_final" id="f_final" value="1"
                                style="width: 24px; height: 24px; cursor: pointer;">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" onclick="closeBentoModal()" class="btn-circle"
                        style="width:auto; padding: 0 1.5rem; background:#f1f5f9; color: var(--primary); border:none; font-weight: 700;">Batal</button>
                    <button type="submit" class="btn-circle"
                        style="width:auto; padding: 0 2rem; background:var(--accent); color:white; border:none; font-weight: 700;">
                        <i class="bx bx-save"></i> <span id="btnSubmitText">Simpan Dokumen</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ==========================================
        // 1. LOGIKA DOWNLOAD TRACKER (ADVANCED)
        // ==========================================
        (function() {
            const MIN_VISIBLE_MS = 2000;

            function createOverlay() {
                const div = document.createElement('div');
                div.id = 'downloadProgressOverlay';
                div.style.cssText =
                    'position:fixed; inset:0; z-index:99999; display:flex; align-items:center; justify-content:center; background:rgba(15,23,42,0.7); backdrop-filter:blur(5px);';
                div.innerHTML = `
                <div style="width:400px; background:#fff; border-radius:24px; padding:30px; box-shadow:0 25px 50px rgba(0,0,0,0.3); font-family:sans-serif;">
                    <div style="display:flex; align-items:center; gap:15px; margin-bottom:20px;">
                        <div style="width:50px; height:50px; border-radius:15px; background:linear-gradient(135deg,#2563eb,#1d4ed8); display:flex; align-items:center; justify-content:center; color:#fff; font-size:24px;"><i class="bx bx-cloud-download"></i></div>
                        <div style="flex:1; min-width:0;">
                            <div id="dlTitle" style="font-weight:800; font-size:16px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Mengunduh Dokumen</div>
                            <div id="dlSub" style="font-size:13px; color:#64748b; font-weight:600;">Menghubungkan ke server...</div>
                        </div>
                    </div>
                    <div style="height:10px; background:#f1f5f9; border-radius:10px; overflow:hidden; margin-bottom:15px;">
                        <div id="dlBar" style="width:0%; height:100%; background:linear-gradient(90deg,#2563eb,#38bdf8); transition:width 0.2s;"></div>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span id="dlPercent" style="font-weight:800; font-size:14px; color:#0f172a;">0%</span>
                        <button id="dlCancel" style="border:none; background:#fef2f2; color:#dc2626; padding:6px 12px; border-radius:8px; font-weight:700; font-size:12px; cursor:pointer;">Batalkan</button>
                    </div>
                </div>
            `;
                return div;
            }

            async function startDownload(url, title) {
                const overlay = createOverlay();
                document.body.appendChild(overlay);

                const bar = overlay.querySelector('#dlBar');
                const pctText = overlay.querySelector('#dlPercent');
                const subText = overlay.querySelector('#dlSub');
                const titleText = overlay.querySelector('#dlTitle');
                titleText.textContent = title;

                const controller = new AbortController();
                overlay.querySelector('#dlCancel').onclick = () => controller.abort();

                try {
                    const startedAt = Date.now();
                    const response = await fetch(url, {
                        signal: controller.signal
                    });
                    if (!response.ok) throw new Error("File tidak ditemukan");

                    const total = parseInt(response.headers.get('content-length'), 10);
                    const reader = response.body.getReader();
                    let loaded = 0;
                    let chunks = [];

                    while (true) {
                        const {
                            done,
                            value
                        } = await reader.read();
                        if (done) break;
                        chunks.push(value);
                        loaded += value.length;

                        if (total) {
                            const pct = Math.round((loaded / total) * 100);
                            bar.style.width = pct + '%';
                            pctText.textContent = pct + '%';
                            subText.textContent = (loaded / 1024 / 1024).toFixed(1) + ' MB / ' + (total / 1024 /
                                1024).toFixed(1) + ' MB';
                        }
                    }

                    const blob = new Blob(chunks);
                    const finalUrl = URL.createObjectURL(blob);

                    // Ensure UI is visible for a moment
                    const elapsed = Date.now() - startedAt;
                    if (elapsed < MIN_VISIBLE_MS) await new Promise(r => setTimeout(r, MIN_VISIBLE_MS - elapsed));

                    const a = document.createElement('a');
                    a.href = finalUrl;
                    a.download = title.split('/').pop() || 'download.pdf';
                    a.click();

                    document.body.removeChild(overlay);
                    Swal.fire({
                        icon: 'success',
                        title: 'Download Selesai',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000
                    });

                } catch (e) {
                    document.body.removeChild(overlay);
                    if (e.name !== 'AbortError') Swal.fire('Gagal', e.message, 'error');
                }
            }

            document.addEventListener('click', e => {
                const btn = e.target.closest('.btn-download-track');
                if (btn) {
                    e.preventDefault();
                    startDownload(btn.href, btn.dataset.title || 'Dokumen');
                }
            });
        })();

        // ==========================================
        // 2. LOGIKA MODAL & CRUD UI
        // ==========================================
        const modal = document.getElementById('bentoModal');
        const form = document.getElementById('bentoForm');

        function openBentoModal(mode, data = null, url = '') {
            form.reset();
            const titleEl = document.getElementById('bentoModalTitle').querySelector('span');
            const submitBtn = document.getElementById('btnSubmitText');
            const methodEl = document.getElementById('bentoMethod');
            const fileHelp = document.getElementById('fileHelpText');

            if (mode === 'add') {
                titleEl.textContent = 'Upload Dokumen Baru';
                submitBtn.textContent = 'Upload Sekarang';
                form.action = "{{ route('document.store', ['project' => $project->id, 'folder' => $folder->id]) }}";
                methodEl.value = 'POST';
                fileHelp.innerHTML = '<i class="bx bx-info-circle"></i> Berkas PDF wajib dilampirkan.';
            } else {
                titleEl.textContent = 'Edit Properti Dokumen';
                submitBtn.textContent = 'Simpan Perubahan';
                form.action = url;
                methodEl.value = 'PUT';

                document.getElementById('f_title').value = data.title;
                document.getElementById('f_doc_no').value = data.document_no || '';
                document.getElementById('f_rev').value = data.revision;
                document.getElementById('f_final').checked = data.is_final == 1;
                fileHelp.innerHTML = '<i class="bx bx-info-circle"></i> Biarkan kosong jika tidak ingin mengganti berkas.';
                updateFinalLabel();
            }

            modal.setAttribute('aria-hidden', 'false');
        }

        function closeBentoModal() {
            modal.setAttribute('aria-hidden', 'true');
        }

        // Toggle Label
        function updateFinalLabel() {
            const label = document.getElementById('finalLabel');
            const isChecked = document.getElementById('f_final').checked;
            label.textContent = isChecked ? 'FINAL' : 'DRAFT';
            label.style.color = isChecked ? 'var(--success)' : 'var(--muted)';
        }
        document.getElementById('f_final').addEventListener('change', updateFinalLabel);

        // Search & Filter
        document.getElementById('searchInput').addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#documentTable tbody tr').forEach(tr => {
                if (tr.innerText.toLowerCase().includes(q)) tr.style.display = '';
                else tr.style.display = 'none';
            });
        });

        document.getElementById('statusFilter').addEventListener('change', function() {
            const s = this.value;
            document.querySelectorAll('#documentTable tbody tr').forEach(tr => {
                if (s === '' || tr.dataset.status === s) tr.style.display = '';
                else tr.style.display = 'none';
            });
        });

        // Delete Confirmation
        document.querySelectorAll('.delete-form').forEach(f => {
            f.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Hapus Dokumen?',
                    text: "Data yang dihapus tidak dapat dipulihkan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((res) => {
                    if (res.isConfirmed) this.submit();
                });
            });
        });

        // Keydown Esc
        window.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeBentoModal();
        });
    </script>
@endpush
