@extends('layouts.home')

@section('title', 'Folder — Transmittal Portal')

@push('css')
    <style>
        /* ========== CSS VARIABLES ========== */
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #2563eb;
            --accent-soft: #dbeafe;
            --success: #16a34a;
            --warning: #ea580c;
            --danger: #dc2626;
            --bg: #f8fafc;
            --card: #ffffff;
            --muted: #64748b;
            --muted-light: #94a3b8;
            --border: #e2e8f0;
            --radius: 14px;
            --shadow-sm: 0 2px 8px rgba(15, 23, 42, 0.04);
            --shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            --shadow-lg: 0 16px 40px rgba(15, 23, 42, 0.12);
        }

        /* ========== BASE STYLES ========== */
        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, var(--bg) 0%, #f0f4f8 100%);
            color: var(--primary);
            line-height: 1.6;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ========== CONTAINER ========== */
        .container-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 24px;
        }

        /* ========== BREADCRUMB ========== */
        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            font-size: 13px;
            color: var(--muted);
        }

        .breadcrumb-nav a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s ease;
        }

        .breadcrumb-nav a:hover {
            opacity: 0.7;
        }

        .breadcrumb-nav i {
            font-size: 12px;
        }

        /* ========== HEADER ========== */
        /* ========== PAGE HEADER ========== */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: #fff;
            padding: 32px;
            border-radius: var(--radius);
            margin-bottom: 32px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            flex-wrap: wrap;
        }

        .header-main h2 {
            font-size: 28px;
            font-weight: 800;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
        }

        .header-main small {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            line-height: 1.6;
            display: block;
        }

        .header-main small strong {
            color: #fff;
            font-weight: 600;
        }

        .header-meta {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 16px 20px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }

        .header-meta-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .header-meta-value {
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            margin-top: 4px;
        }

        /* ========== PAGE ACTIONS / BUTTON ========== */
        .page-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn-add {
            background: linear-gradient(90deg, var(--accent), #7c3aed);
            color: #fff;
            padding: 10px 14px;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.12);
            transition: transform 0.15s ease, box-shadow 0.15s ease, opacity 0.15s ease;
            border: 0;
            cursor: pointer;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            opacity: 0.98;
        }

        .btn-add:active {
            transform: translateY(0);
        }

        .btn-add i {
            margin-left: 0;
            font-size: 14px;
        }

        /* ========== MODAL STYLES ========== */
        .modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1100;
        }

        .modal[aria-hidden="false"] {
            display: flex;
        }

        .modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(2, 6, 23, 0.55);
            backdrop-filter: blur(3px);
            transition: opacity 0.18s ease;
        }

        .modal-content {
            position: relative;
            background: var(--card);
            width: 100%;
            max-width: 520px;
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--shadow-lg);
            z-index: 2;
            transform: translateY(8px);
            transition: transform 0.18s ease, opacity 0.18s ease;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
        }

        .modal-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
        }

        .modal-close {
            background: transparent;
            border: 0;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            color: var(--muted);
            padding: 6px;
            border-radius: 6px;
        }

        .modal-close:hover {
            background: rgba(15, 23, 42, 0.03);
            color: var(--primary);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 12px;
        }

        label {
            font-size: 13px;
            font-weight: 700;
            color: var(--muted);
        }

        .form-control {
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            outline: none;
            font-size: 14px;
            background: #fff;
            color: var(--primary);
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 6px 18px rgba(37, 99, 235, 0.06);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 8px;
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--primary);
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(90deg, var(--accent), #7c3aed);
            color: #fff;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 700;
            border: 0;
            cursor: pointer;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 16px;
                padding: 24px;
            }

            .header-main h2 {
                font-size: 24px;
            }

            .header-meta {
                width: 100%;
            }

            .page-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        @media (max-width: 480px) {
            .page-header {
                padding: 16px;
            }

            .header-main h2 {
                font-size: 20px;
            }

            .header-main small {
                font-size: 13px;
            }

            .header-meta {
                width: 100%;
            }

            .page-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* ========== SEARCH ========== */
        .search-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--card);
            border: 1.5px solid var(--border);
            padding: 10px 16px;
            border-radius: 999px;
            transition: all 0.2s ease;
            min-width: 280px;
            box-shadow: var(--shadow-sm);
        }

        .search-wrapper:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-wrapper i {
            color: var(--muted);
            font-size: 16px;
        }

        .search-wrapper input {
            border: 0;
            outline: none;
            width: 100%;
            font-size: 14px;
            background: transparent;
            color: var(--primary);
        }

        .search-wrapper input::placeholder {
            color: var(--muted-light);
        }

        /* ========== STATS ========== */
        .folder-stats-header {
            display: flex;
            gap: 16px;
            align-items: center;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 20px;
        }

        .stat-item {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .stat-badge {
            background: var(--accent-soft);
            color: var(--accent);
            padding: 2px 8px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 12px;
        }

        /* ========== GRID ========== */
        .folder-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========== FOLDER CARD ========== */
        .folder-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, var(--card) 100%);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 280px;
            text-decoration: none;
            color: inherit;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .folder-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), #7c3aed);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .folder-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .folder-card:hover::before {
            transform: scaleX(1);
        }

        /* ========== CARD HEADER ========== */
        .folder-header {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .folder-icon {
            width: 52px;
            height: 52px;
            min-width: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--accent-soft), #e0e7ff);
            border-radius: 12px;
            font-size: 24px;
            color: var(--accent);
        }

        .folder-info {
            flex: 1;
            min-width: 0;
        }

        .folder-title {
            font-weight: 700;
            font-size: 16px;
            color: var(--primary);
            margin: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .folder-code {
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ========== CARD STATS ========== */
        .folder-meta {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }

        .meta-box {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.04), rgba(124, 58, 237, 0.04));
            border: 1px solid rgba(37, 99, 235, 0.08);
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .folder-card:hover .meta-box {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.08), rgba(124, 58, 237, 0.08));
            border-color: rgba(37, 99, 235, 0.15);
        }

        .meta-box strong {
            font-size: 20px;
            font-weight: 800;
            display: block;
            color: var(--accent);
        }

        .meta-box span {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.3px;
            font-weight: 600;
            margin-top: 4px;
            display: block;
        }

        /* ========== CARD FOOTER ========== */
        .folder-footer {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-date {
            font-size: 12px;
            color: var(--muted);
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .footer-date i {
            font-size: 12px;
        }

        .view-link {
            color: var(--accent);
            font-weight: 700;
            display: flex;
            gap: 4px;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .folder-card:hover .view-link {
            background: var(--accent-soft);
            transform: translateX(4px);
        }

        .view-link i {
            font-size: 14px;
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            grid-column: 1 / -1;
            min-height: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 16px;
            border: 2px dashed var(--border);
            border-radius: var(--radius);
            background: linear-gradient(135deg, rgba(248, 250, 252, 0.5), rgba(240, 244, 248, 0.5));
            color: var(--muted);
        }

        .empty-state-icon {
            font-size: 48px;
            color: var(--muted-light);
        }

        .empty-state h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: var(--primary);
        }

        .empty-state p {
            margin: 0;
            font-size: 14px;
            max-width: 380px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* ========== NO RESULTS ========== */
        .no-results {
            grid-column: 1 / -1;
            min-height: 280px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            color: var(--muted);
        }

        .no-results-icon {
            font-size: 40px;
            opacity: 0.5;
        }

        .no-results h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
        }

        .no-results p {
            margin: 0;
            font-size: 13px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1024px) {
            .folder-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .container-main {
                padding: 24px 16px;
            }

            .page-header {
                flex-direction: column;
                gap: 16px;
            }

            .page-header-left h2 {
                font-size: 24px;
            }

            .search-wrapper {
                width: 100%;
                min-width: auto;
            }

            .folder-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 16px;
            }

            .folder-stats-header {
                flex-wrap: wrap;
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .container-main {
                padding: 16px 12px;
            }

            .page-header-left h2 {
                font-size: 20px;
            }

            .page-header-left small {
                font-size: 13px;
            }

            .folder-grid {
                grid-template-columns: 1fr;
            }

            .page-actions {
                width: 100%;
            }

            .search-wrapper {
                width: 100%;
            }

            .breadcrumb-nav {
                font-size: 12px;
            }
        }

        /* ========== ACCESSIBILITY ========== */
        .folder-card:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* ========== ANIMATIONS ========== */
        @media (prefers-reduced-motion: reduce) {

            .folder-card,
            .search-wrapper {
                transition: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        {{-- <!-- BREADCRUMB -->
        <div class="breadcrumb-nav">
            <a href="#">
                <i class="bi bi-house-fill"></i> Projects
            </a>
            <i class="bi bi-chevron-right"></i>
            <span>{{ $project->project_name ?? 'Project' }}</span>
        </div> --}}

        <!-- HEADER -->
        <div class="page-header">
            <div class="header-main">
                <h2>📂 {{ $project->project_name ?? 'Unnamed Project' }}</h2>
                <small>Kelola folder dan dokumen transmittal dengan mudah</small>
            </div>

            <div class="page-actions">
                {{-- Tombol buka modal --}}
                <button id="open-add-folder" class="btn-add" type="button" aria-haspopup="dialog"
                    aria-controls="add-folder-modal">
                    + Tambah Folder <i class="bi bi-plus-lg" aria-hidden="true"></i>
                </button>

                {{-- Jika ingin mengaktifkan pencarian, uncomment bagian ini --}}
                {{-- <div class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input id="folder-search" type="search" placeholder="Cari folder atau kode..." aria-label="Cari folder" />
                </div> --}}
            </div>
        </div>

        <!-- STATS -->
        @if ($folders->count() > 0)
            <div class="folder-stats-header">
                <span class="stat-item">
                    📁 Total Folder:
                    <span class="stat-badge" id="total-folders">{{ $folders->count() }}</span>
                </span>
                <span class="stat-item">
                    📄 Total Dokumen:
                    <span class="stat-badge" id="total-documents">{{ $folders->sum('documents_count') }}</span>
                </span>
            </div>
        @endif

        <!-- FOLDER GRID -->
        <div id="folder-grid" class="folder-grid">

            @forelse($folders as $folder)
                <a href="{{ route('document.list', ['project' => $project->id, 'folder' => $folder->id]) }}"
                    class="folder-card" data-title="{{ strtolower($folder->folder_name) }}"
                    data-code="{{ strtolower($folder->folder_code) }}" role="link" tabindex="0">

                    <div class="folder-header">
                        <div class="folder-icon">📁</div>
                        <div class="folder-info">
                            <h4 class="folder-title">{{ $folder->folder_name }}</h4>
                            <div class="folder-code">{{ $folder->folder_code }}</div>
                        </div>
                    </div>

                    <div class="folder-meta">
                        <div class="meta-box">
                            <strong>{{ $folder->documents_count ?? 0 }}</strong>
                            <span>Documents</span>
                        </div>
                    </div>

                    <div class="folder-footer">
                        <span class="footer-date">
                            <i class="bi bi-calendar3"></i>
                            {{ optional($folder->updated_at)->format('d M Y') ?? '—' }}
                        </span>
                        <span class="view-link">
                            Open <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>

                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">📂</div>
                    <h3>Belum ada folder</h3>
                    <p>
                        Folder belum dibuat. Silakan buat folder terlebih dahulu untuk mengelola dokumen transmittal.
                    </p>
                </div>
            @endforelse

            <!-- NO RESULTS MESSAGE (Hidden by default) -->
            <div id="no-results" class="no-results" style="display: none;">
                <div class="no-results-icon">🔍</div>
                <h3>Hasil tidak ditemukan</h3>
                <p>Coba sesuaikan pencarian Anda</p>
            </div>

        </div>

    </div>

    {{-- MODAL: Tambah Folder --}}
    <div id="add-folder-modal" class="modal" role="dialog" aria-hidden="true" aria-labelledby="add-folder-title"
        aria-modal="true">
        <div class="modal-overlay" data-close-modal></div>

        <div class="modal-content" role="document">
            <div class="modal-header">
                <h3 id="add-folder-title" class="modal-title">Tambah Folder</h3>
                <button class="modal-close" type="button" aria-label="Tutup modal" data-close-modal>×</button>
            </div>

            {{-- Ganti route('folder.store', ...) jika nama route di aplikasi berbeda --}}
            <form id="add-folder-form" method="POST"
                action="{{ route('document.folders.store', ['project' => $project->id]) }}">
                @csrf

                <div class="form-group">
                    <label for="folder_name">Nama Folder</label>
                    <input id="folder_name" name="folder_name" type="text" class="form-control" required maxlength="120"
                        placeholder="Masukkan nama folder" />
                </div>

                <div class="form-group">
                    <label for="folder_code">Kode Folder (opsional)</label>
                    <input id="folder_code" name="folder_code" type="text" class="form-control" maxlength="40"
                        placeholder="Contoh: F-001" />
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" data-close-modal>Batal</button>
                    <button type="submit" class="btn-primary">Buat Folder</button>
                </div>
            </form>
        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    (function() {
        'use strict';

        // Coba pasang handler saat DOM siap (fallback bila push/stack tidak dipanggil)
        function initAddFolderModal() {
            var openBtn = document.getElementById('open-add-folder');
            var modal = document.getElementById('add-folder-modal');

            console.log('[modal-debug] initAddFolderModal running', {
                openBtn: !!openBtn,
                modal: !!modal
            });

            if (!openBtn || !modal) {
                console.error('[modal-debug] open button or modal element not found');
                return;
            }

            var overlay = modal.querySelector('.modal-overlay');
            var closeTriggers = modal.querySelectorAll('[data-close-modal]');
            var firstInput = modal.querySelector('input[name="folder_name"]');
            var lastActive = null;

            function showModal() {
                lastActive = document.activeElement;
                modal.style.display = 'flex'; // fallback inline
                modal.setAttribute('aria-hidden', 'false');
                document.documentElement.style.overflow = 'hidden';
                if (firstInput) firstInput.focus();
                console.log('[modal-debug] modal opened');
            }

            function hideModal() {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
                document.documentElement.style.overflow = '';
                if (lastActive && typeof lastActive.focus === 'function') lastActive.focus();
                console.log('[modal-debug] modal closed');
            }

            openBtn.addEventListener('click', function(e) {
                e.preventDefault();
                showModal();
            }, false);

            // Close triggers (buttons)
            closeTriggers.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    hideModal();
                }, false);
            });

            // Click overlay
            if (overlay) {
                overlay.addEventListener('click', function() {
                    hideModal();
                }, false);
            }

            // ESC closes modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
                    hideModal();
                }
            }, false);
        }

        // If document already loaded, init immediately; otherwise wait for DOMContentLoaded
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initAddFolderModal);
        } else {
            initAddFolderModal();
        }
    })();
    // Notifikasi sukses

    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>
