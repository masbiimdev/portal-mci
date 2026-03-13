@extends('layouts.home')

@section('title', 'Folder — Transmittal Portal')

@push('css')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        /* ========== CSS VARIABLES ========== */
        :root {
            --primary: #1e293b;
            --primary-light: #334155;
            --accent: #2563eb;
            --accent-hover: #1d4ed8;
            --accent-soft: #eff6ff;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --bg: #f8fafc;
            --card: #ffffff;
            --muted: #64748b;
            --muted-light: #94a3b8;
            --border: #e2e8f0;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(15, 23, 42, 0.05);
            --shadow-lg: 0 15px 35px -5px rgba(37, 99, 235, 0.08);
            --transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--primary);
            -webkit-font-smoothing: antialiased;
        }

        .container-main {
            max-width: 1440px;
            margin: 0 auto;
            padding: 2.5rem 1.5rem;
        }

        /* ========== BREADCRUMB ========== */
        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
            color: var(--muted);
            font-weight: 500;
        }

        .breadcrumb-nav a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .breadcrumb-nav a:hover {
            color: var(--accent-hover);
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            border-radius: var(--radius-xl);
            padding: 2.5rem 3rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow-md);
            margin-bottom: 2.5rem;
            position: relative;
            overflow: hidden;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.3) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .header-content {
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .header-content h2 {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            letter-spacing: -0.02em;
        }

        .header-content p {
            color: #cbd5e1;
            font-size: 1.05rem;
            margin: 0;
            max-width: 500px;
            line-height: 1.5;
        }

        .header-actions {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-add {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            transition: var(--transition);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
        }

        /* ========== STATS BAR ========== */
        .filter-stats {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .stat-badge {
            background: var(--card);
            border: 1px solid var(--border);
            padding: 0.5rem 1.25rem;
            border-radius: 999px;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--primary);
            box-shadow: var(--shadow-sm);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stat-badge span {
            background: var(--accent-soft);
            color: var(--accent);
            padding: 0.1rem 0.6rem;
            border-radius: 999px;
            font-weight: 800;
        }

        /* ========== FOLDER GRID & CARD ========== */
        .folder-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .folder-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: inherit;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            position: relative;
        }

        .folder-card::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            height: 4px;
            background: linear-gradient(90deg, #38bdf8, var(--accent));
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            opacity: 0;
            transition: var(--transition);
        }

        .folder-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: #bfdbfe;
        }

        .folder-card:hover::before {
            opacity: 1;
        }

        /* Card Header */
        .folder-header {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            position: relative;
        }

        .folder-avatar {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--accent);
        }

        .folder-info {
            flex: 1;
            min-width: 0;
            padding-right: 20px;
        }

        .folder-info h4 {
            margin: 0 0 0.25rem 0;
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .folder-code {
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: var(--bg);
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }

        /* Card Actions (Dropdown) */
        .card-actions {
            position: absolute;
            top: 0;
            right: 0;
        }

        .action-btn-trigger {
            background: transparent;
            border: none;
            color: var(--muted);
            font-size: 1.25rem;
            padding: 4px;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
        }

        .action-btn-trigger:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            min-width: 140px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: var(--transition);
            z-index: 10;
            padding: 0.5rem 0;
        }

        .card-actions:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.5rem 1rem;
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .dropdown-item:hover {
            background: var(--bg);
            color: var(--accent);
        }

        .dropdown-item.delete:hover {
            background: var(--danger-light);
            color: var(--danger);
        }

        /* Card Meta */
        .folder-meta {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
            background: #f8fafc;
            padding: 1rem;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
        }

        .meta-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .meta-item span {
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .meta-item strong {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        /* Card Footer */
        .folder-footer {
            margin-top: auto;
            padding-top: 1rem;
            border-top: 1px dashed var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-date {
            font-size: 0.8rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-weight: 500;
        }

        .view-link {
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--accent);
            display: flex;
            align-items: center;
            gap: 0.25rem;
            transition: var(--transition);
        }

        .folder-card:hover .view-link {
            gap: 0.5rem;
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            grid-column: 1 / -1;
            padding: 4rem 2rem;
            text-align: center;
            background: var(--card);
            border: 2px dashed var(--border);
            border-radius: var(--radius-xl);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .empty-icon {
            font-size: 3.5rem;
            opacity: 0.8;
            margin-bottom: 0.5rem;
        }

        .empty-state h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
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
            animation: fadeInModal 0.2s ease-out forwards;
        }

        .modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            position: relative;
            background: var(--card);
            width: 100%;
            max-width: 450px;
            border-radius: var(--radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            z-index: 2;
            transform: scale(0.95);
            animation: scaleUpModal 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeInModal {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleUpModal {
            from {
                transform: scale(0.95) translateY(10px);
            }

            to {
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-close {
            background: var(--bg);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            cursor: pointer;
            transition: var(--transition);
        }

        .modal-close:hover {
            background: #f1f5f9;
            color: var(--danger);
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary-light);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            font-size: 0.95rem;
            color: var(--primary);
            background: var(--bg);
            outline: none;
            transition: var(--transition);
            font-family: inherit;
        }

        .form-control:focus {
            background: var(--card);
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 2rem;
        }

        .btn-secondary {
            background: var(--card);
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-secondary:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .btn-primary {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 2rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .folder-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        <div class="breadcrumb-nav">
            <a href="{{ route('document.project.index') ?? '#' }}"><i class="bx bx-briefcase"></i> Projects</a>
            <i class="bx bx-chevron-right"></i>
            <span class="text-slate-800">{{ $project->project_name ?? 'Project Detail' }}</span>
        </div>

        <div class="page-header">
            <div class="header-content">
                <h2><i class="bx bx-folder-open"></i> Folder System</h2>
                <p>Kelola struktur folder dan dokumen transmittal untuk proyek
                    <strong>{{ $project->project_name ?? 'Unnamed Project' }}</strong>.
                </p>
            </div>

            <div class="header-actions">
                <button id="open-add-folder" class="btn-add" type="button" aria-haspopup="dialog"
                    aria-controls="folder-modal">
                    <i class="bx bx-plus"></i> Tambah Folder
                </button>
            </div>
        </div>

        @if ($folders->count() > 0)
            <div class="filter-stats">
                <div class="stat-badge">Total Folder <span>{{ $folders->count() }}</span></div>
                <div class="stat-badge">Total Dokumen <span>{{ $folders->sum('documents_count') }}</span></div>
            </div>
        @endif

        <div id="folder-grid" class="folder-grid">
            @forelse($folders as $folder)
                <div class="folder-card">

                    <div class="folder-header">
                        <div class="folder-avatar"><i class="bx bx-folder"></i></div>
                        <div class="folder-info">
                            <h4 title="{{ $folder->folder_name }}">{{ $folder->folder_name }}</h4>
                            <div class="folder-code">{{ $folder->folder_code ?? 'NO-CODE' }}</div>
                        </div>

                        <div class="card-actions">
                            <button class="action-btn-trigger"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item btn-edit" data-id="{{ $folder->id }}"
                                    data-name="{{ $folder->folder_name }}" data-code="{{ $folder->folder_code }}"
                                    data-route="{{ route('document.folders.update', ['project' => $project->id, 'folder' => $folder->id]) }}">
                                    <i class="bx bx-edit"></i> Edit Folder
                                </button>

                                <form
                                    action="{{ route('document.folders.destroy', ['project' => $project->id, 'folder' => $folder->id]) }}"
                                    method="POST" class="delete-form" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item delete">
                                        <i class="bx bx-trash"></i> Hapus Folder
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('document.list', ['project' => $project->id, 'folder' => $folder->id]) }}"
                        style="text-decoration: none; color: inherit; display:flex; flex-direction:column; flex:1;">
                        <div class="folder-meta">
                            <div class="meta-item">
                                <span>Documents Inside</span>
                                <strong>{{ $folder->documents_count ?? 0 }}</strong>
                            </div>
                        </div>

                        <div class="folder-footer">
                            <div class="footer-date"><i class="bx bx-calendar"></i>
                                {{ optional($folder->updated_at)->format('d M Y') ?? '—' }}</div>
                            <div class="view-link">Buka <i class="bx bx-right-arrow-alt"></i></div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-icon"><i class="bx bx-folder-open"></i></div>
                    <h3>Belum ada Folder</h3>
                    <p>Proyek ini belum memiliki folder. Silakan klik tombol "Tambah Folder" untuk mulai mengelola dokumen
                        Anda.</p>
                </div>
            @endforelse
        </div>

    </div>

    {{-- MODAL (Digunakan untuk Tambah & Edit) --}}
    <div id="folder-modal" class="modal" role="dialog" aria-hidden="true" aria-labelledby="folder-title">
        <div class="modal-overlay" data-close-modal></div>

        <div class="modal-content">
            <div class="modal-header">
                <h3 id="folder-title" class="modal-title"><i class="bx bx-folder-plus"></i> Tambah Folder Baru</h3>
                <button class="modal-close" type="button" aria-label="Tutup modal" data-close-modal>
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <form id="folder-form" method="POST"
                action="{{ route('document.folders.store', ['project' => $project->id]) }}">
                @csrf
                <input type="hidden" name="_method" id="form-method" value="POST">

                <div class="form-group">
                    <label for="folder_name">Nama Folder <span style="color:var(--danger)">*</span></label>
                    <input id="folder_name" name="folder_name" type="text" class="form-control" required maxlength="120"
                        placeholder="Contoh: Phase 1 Drawings" autocomplete="off" />
                </div>

                <div class="form-group">
                    <label for="folder_code">Kode Folder <span
                            style="color:var(--muted); font-weight:normal;">(Opsional)</span></label>
                    <input id="folder_code" name="folder_code" type="text" class="form-control" maxlength="40"
                        placeholder="Contoh: F-001" autocomplete="off" />
                </div>

                {{-- TAMBAHAN: Kolom Deskripsi --}}
                <div class="form-group" style="margin-bottom: 24px;">
                    <label for="description">Deskripsi <span
                            style="color:var(--muted); font-weight:normal;">(Opsional)</span></label>
                    <textarea id="description" name="description" class="form-control" rows="3"
                        placeholder="Tambahkan keterangan atau tujuan folder ini dibuat..." style="resize: vertical; min-height: 80px;"></textarea>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" data-close-modal>Batal</button>
                    <button type="submit" class="btn-primary" id="btn-submit-text">Simpan Folder</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            'use strict';

            // Modal Elements
            const modal = document.getElementById('folder-modal');
            const form = document.getElementById('folder-form');
            const title = document.getElementById('folder-title');
            const methodInput = document.getElementById('form-method');
            const inputName = document.getElementById('folder_name');
            const inputCode = document.getElementById('folder_code');
            const btnSubmit = document.getElementById('btn-submit-text');

            // Base URL for Store
            const storeRoute = "{{ route('document.folders.store', ['project' => $project->id]) }}";

            // Open Modal Helper
            const openModal = () => {
                modal.setAttribute('aria-hidden', 'false');
                document.documentElement.style.overflow = 'hidden';
                setTimeout(() => {
                    if (inputName) inputName.focus();
                }, 100);
            };

            // Close Modal Helper
            const closeModal = () => {
                modal.setAttribute('aria-hidden', 'true');
                document.documentElement.style.overflow = '';
            };

            // 1. ADD ACTION
            const btnAdd = document.getElementById('open-add-folder');
            if (btnAdd) {
                btnAdd.addEventListener('click', (e) => {
                    e.preventDefault();
                    title.innerHTML = '<i class="bx bx-folder-plus"></i> Tambah Folder Baru';
                    form.action = storeRoute;
                    methodInput.value = 'POST';
                    inputName.value = '';
                    inputCode.value = '';
                    btnSubmit.textContent = 'Buat Folder';
                    openModal();
                });
            }

            // 2. EDIT ACTION
            const editBtns = document.querySelectorAll('.btn-edit');
            editBtns.forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    title.innerHTML = '<i class="bx bx-edit"></i> Edit Folder';
                    form.action = btn.dataset.route; // Ganti URL action ke URL update
                    methodInput.value = 'PUT'; // Ubah method menjadi PUT
                    inputName.value = btn.dataset.name;
                    inputCode.value = btn.dataset.code;
                    btnSubmit.textContent = 'Update Folder';
                    openModal();
                });
            });

            // CLOSE ACTIONS
            const closeTriggers = modal.querySelectorAll('[data-close-modal]');
            closeTriggers.forEach(btn => btn.addEventListener('click', (e) => {
                e.preventDefault();
                closeModal();
            }));

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modal.getAttribute('aria-hidden') === 'false') {
                    closeModal();
                }
            });

            // 3. DELETE CONFIRMATION
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Semua dokumen di dalam folder ini juga akan terhapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'rounded-xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // 4. SWEETALERT NOTIFICATIONS (Dari Session Controller)
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-xl'
                    }
                });
            @endif
        });
    </script>
@endpush
