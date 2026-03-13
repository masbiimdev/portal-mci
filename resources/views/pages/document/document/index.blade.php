@extends('layouts.home')

@section('title', 'Folder ' . $folder->folder_name . ' — Document Transmittal')

@push('css')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        /* ========== CSS VARIABLES ========== */
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
            --muted-light: #94a3b8;
            --border: #e2e8f0;
            --radius: 16px;
            --shadow-sm: 0 2px 4px rgba(15, 23, 42, 0.04);
            --shadow: 0 8px 16px rgba(15, 23, 42, 0.06);
            --shadow-lg: 0 20px 40px rgba(15, 23, 42, 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--primary);
            -webkit-font-smoothing: antialiased;
            /* Blueprint Background Tipis */
            background-image:
                linear-gradient(rgba(37, 99, 235, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 99, 235, 0.03) 1px, transparent 1px);
            background-size: 30px 30px;
        }

        .container-main {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2.5rem 2rem;
            min-height: 100vh;
        }

        /* ========== BREADCRUMB ========== */
        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 2rem;
            font-size: 0.9rem;
            color: var(--muted);
            font-weight: 500;
        }

        .breadcrumb-nav a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--card);
            padding: 6px 14px;
            border-radius: 999px;
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .breadcrumb-nav a:hover {
            background: var(--accent-soft);
            border-color: #bfdbfe;
            transform: translateY(-1px);
        }

        .breadcrumb-nav i {
            font-size: 1.1rem;
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: var(--radius);
            padding: 2.5rem 3rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
            box-shadow: var(--shadow);
            margin-bottom: 3.5rem;
            /* Jarak lega dengan tabel */
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .page-header::after {
            content: '';
            position: absolute;
            right: -10%;
            top: -50%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .page-header::before {
            content: '\eb31';
            /* boxicon folder icon */
            font-family: 'boxicons';
            position: absolute;
            right: 5%;
            bottom: -20%;
            font-size: 15rem;
            color: rgba(255, 255, 255, 0.03);
            pointer-events: none;
        }

        .header-main {
            position: relative;
            z-index: 2;
            flex: 1;
            min-width: 280px;
        }

        .header-main h2 {
            font-size: 2rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 12px;
            letter-spacing: -0.5px;
        }

        .header-main h2 i {
            color: #60a5fa;
        }

        .header-main p {
            color: #cbd5e1;
            font-size: 1rem;
            margin: 0;
            max-width: 600px;
            line-height: 1.6;
            font-weight: 500;
        }

        .header-meta {
            position: relative;
            z-index: 2;
            background: var(--card);
            color: var(--primary);
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            min-width: 280px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .meta-label {
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .meta-val {
            font-weight: 800;
            font-size: 0.95rem;
        }

        .meta-count {
            background: var(--accent-soft);
            color: var(--accent);
            padding: 4px 12px;
            border-radius: 999px;
            font-weight: 800;
            font-size: 0.9rem;
        }

        .meta-divider {
            height: 1px;
            background: var(--border);
            margin: 16px 0;
        }

        .meta-update h5 {
            margin: 0 0 6px 0;
        }

        .meta-update a {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 220px;
            transition: color 0.2s;
        }

        .meta-update a:hover {
            color: var(--accent);
        }

        .meta-update p {
            margin: 6px 0 0 0;
            font-size: 0.75rem;
            color: var(--muted);
            font-weight: 500;
        }

        /* ========== TOOLBAR ========== */
        .toolbar {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius) var(--radius) 0 0;
            padding: 1.25rem 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
            justify-content: space-between;
            border-bottom: none;
        }

        .toolbar-left {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            flex: 1;
        }

        .toolbar-right {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 280px;
            max-width: 400px;
            background: var(--bg);
            border: 1px solid var(--border);
            padding: 0.7rem 1.2rem;
            border-radius: 10px;
            transition: var(--transition);
        }

        .search-box:focus-within {
            border-color: var(--accent);
            background: var(--card);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .search-box i {
            color: var(--muted);
            font-size: 1.2rem;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--primary);
            font-weight: 500;
        }

        .filter-box {
            padding: 0.7rem 1.2rem;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--bg);
            color: var(--primary);
            font-size: 0.9rem;
            font-weight: 600;
            outline: none;
            transition: var(--transition);
            cursor: pointer;
            min-width: 160px;
        }

        .filter-box:focus,
        .filter-box:hover {
            border-color: var(--accent);
            background: var(--card);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0.7rem 1.5rem;
            background: linear-gradient(135deg, var(--accent), #1d4ed8);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
        }

        .btn-action i {
            font-size: 1.2rem;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.35);
            color: #fff;
        }

        .btn-secondary {
            background: var(--card);
            color: var(--primary);
            border: 1px solid var(--border);
            box-shadow: var(--shadow-sm);
        }

        .btn-secondary:hover {
            background: var(--bg);
            color: var(--accent);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* ========== TABLE MAIN ========== */
        .table-container {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 0 0 var(--radius) var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 4rem;
            /* Jarak bawah halaman */
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
            min-width: 900px;
        }

        th {
            background: #f1f5f9;
            padding: 1.2rem 2rem;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            text-align: left;
            border-bottom: 2px solid var(--border);
        }

        td {
            padding: 1.2rem 2rem;
            font-size: 0.95rem;
            color: var(--primary);
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: var(--accent-soft);
        }

        /* File Info & Clickable Link */
        .file-cell {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .file-badge {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: #fff;
            font-size: 0.8rem;
            text-transform: uppercase;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        .ext-pdf {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
        }

        .ext-docx,
        .ext-doc {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        }

        .ext-xlsx,
        .ext-xls {
            background: linear-gradient(135deg, #10b981, #047857);
        }

        .ext-dwg {
            background: linear-gradient(135deg, #8b5cf6, #6d28d9);
        }

        .ext-unknown {
            background: linear-gradient(135deg, #64748b, #334155);
        }

        /* PERUBAHAN NAMA FILE MENJADI LINK */
        .file-name {
            font-weight: 800;
            color: var(--primary);
            margin: 0 0 4px 0;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 1rem;
            text-decoration: none;
            display: block;
            transition: all 0.2s ease;
        }

        .file-name:hover {
            color: var(--accent);
            text-decoration: underline;
            text-underline-offset: 3px;
            text-decoration-thickness: 2px;
        }

        .file-meta {
            font-size: 0.8rem;
            color: var(--muted);
            font-weight: 600;
        }

        /* Status & Actions */
        .badge-status {
            padding: 0.4rem 1rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .badge-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .badge-final {
            background: #dcfce7;
            color: #059669;
            border: 1px solid #bbf7d0;
        }

        .badge-draft {
            background: var(--bg);
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .btn-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            color: var(--muted);
            border: 1px solid var(--border);
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-icon i {
            font-size: 1.2rem;
        }

        .btn-icon:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        .btn-icon.preview:hover {
            color: #4f46e5;
            background: #e0e7ff;
            border-color: #c7d2fe;
        }

        .btn-icon.download:hover {
            color: var(--accent);
            background: var(--accent-soft);
            border-color: #bfdbfe;
        }

        .btn-icon.update:hover {
            color: var(--success);
            background: #dcfce7;
            border-color: #bbf7d0;
        }

        .btn-icon.delete:hover {
            color: var(--danger);
            background: #fee2e2;
            border-color: #fecaca;
        }

        .btn-icon.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .btn-icon.disabled:hover {
            transform: none;
            background: var(--bg);
            color: var(--muted);
            border-color: var(--border);
            box-shadow: none;
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            padding: 6rem 2rem;
            text-align: center;
            color: var(--muted);
            background: #f8fafc;
        }

        .empty-icon {
            font-size: 4rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--primary);
        }

        /* ========== MODAL ========== */
        .modal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 2000;
        }

        .modal[aria-hidden="false"] {
            display: flex;
        }

        .modal-overlay {
            position: absolute;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: relative;
            background: var(--card);
            width: 100%;
            max-width: 550px;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            z-index: 2;
            transform: translateY(20px) scale(0.98);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .modal[aria-hidden="false"] .modal-content {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border);
            background: #f8fafc;
            border-radius: 20px 20px 0 0;
        }

        .modal-title {
            margin: 0;
            font-weight: 800;
            font-size: 1.25rem;
            color: var(--primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-title i {
            font-size: 1.5rem;
            color: var(--accent);
        }

        .modal-close-btn {
            background: var(--card);
            border: 1px solid var(--border);
            font-size: 1.5rem;
            color: var(--muted);
            cursor: pointer;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .modal-close-btn:hover {
            background: #fee2e2;
            color: var(--danger);
            border-color: #fecaca;
        }

        .modal-body {
            padding: 2rem;
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Form */
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            flex: 1;
            min-width: 180px;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        label {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--primary-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 10px;
            border: 1.5px solid var(--border);
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--primary);
            background: var(--bg);
            font-weight: 500;
            outline: none;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--accent);
            background: var(--card);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        .small-muted {
            color: var(--muted);
            font-size: 0.75rem;
            margin-top: 4px;
            display: block;
            font-weight: 500;
        }

        .form-control.is-invalid {
            border-color: var(--danger) !important;
            background: #fff5f5;
        }

        .file-error-box {
            display: none;
            margin-top: 8px;
            padding: 10px 12px;
            border-radius: 8px;
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: var(--danger);
            font-size: 0.85rem;
            align-items: center;
            gap: 8px;
            font-weight: 700;
        }

        /* Toggle Switch iOS Style */
        .toggle-switch {
            width: 54px;
            height: 30px;
            border-radius: 999px;
            background: #cbd5e1;
            position: relative;
            cursor: pointer;
            transition: background 0.3s ease;
            border: none;
            padding: 0;
            outline: none;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle-switch.on {
            background: var(--success);
        }

        .switch-thumb {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .toggle-switch.on .switch-thumb {
            transform: translateX(24px);
        }

        .modal-actions {
            padding: 1.5rem 2rem;
            border-top: 1px solid var(--border);
            background: #f8fafc;
            border-radius: 0 0 20px 20px;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-meta {
                width: 100%;
            }
        }

        @media (max-width: 600px) {
            .toolbar {
                flex-direction: column;
                align-items: stretch;
                padding: 1rem;
            }

            .toolbar-left,
            .toolbar-right {
                flex-direction: column;
                width: 100%;
            }

            .search-box {
                min-width: 100%;
            }

            .action-btns {
                justify-content: flex-start;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        <div class="breadcrumb-nav">
            <a href="{{ url('/portal/document') }}">
                <i class="bx bx-briefcase"></i> Projects
            </a>
            <i class="bx bx-chevron-right"></i>
            <a href="{{ route('document.folder', $project->id) ?? '#' }}">
                {{ $project->project_name ?? 'Project' }}|{{ $project->project_number ?? '1234' }}
            </a>
            <i class="bx bx-chevron-right"></i>
            <span
                style="color: var(--primary); font-weight: 800; background: var(--card); padding: 6px 14px; border-radius: 999px; border: 1px solid var(--border); box-shadow: var(--shadow-sm);">{{ $folder->folder_name }}</span>
        </div>

        @php
            $last = $lastDocument ?? ($documents->count() ? $documents->sortByDesc('updated_at')->first() : null);
            if ($last) {
                $lastRev = $last->revision ?? '0';
                $lastTitle = $last->title ?? '—';
                $lastUser = optional($last->user)->name ?? ($last->updated_by ?? 'System');
                $lastDate = $last->updated_at ? $last->updated_at->format('d M Y H:i') . ' WIB' : '—';
            }
        @endphp

        <div class="page-header">
            <div class="header-main">
                <h2><i class="bx bx-folder-open"></i> {{ $folder->folder_name }}</h2>
                <p>{{ $folder->description ?? 'Manajemen dokumen resmi, log revisi, dan arsip transmittal untuk folder ini.' }}
                </p>
            </div>

            <div class="header-meta">
                <div class="meta-row">
                    <span class="meta-label">Kode Project</span>
                    <span class="meta-val"
                        style="font-family: monospace; font-size: 1.1rem; color: var(--accent);">{{ $project->project_number ?? '—' }}</span>
                </div>
                <div class="meta-row">
                    <span class="meta-label">Total Dokumen</span>
                    <span class="meta-count">{{ $documents->count() }}</span>
                </div>

                @if ($last)
                    <div class="meta-divider"></div>
                    <div class="meta-update">
                        <h5 class="meta-label" style="color: var(--primary);">Update Terakhir</h5>
                        <a href="{{ route('document.show', $last->id) }}"
                            title="{{ $lastTitle }}">{{ $lastTitle }}</a>
                        <p>Oleh <strong style="color: var(--primary);">{{ $lastUser }}</strong> &bull;
                            {{ $lastDate }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- INI BAGIAN TOOLBAR DAN TABLE YANG DISATUKAN --}}
        <div>
            <div class="toolbar">
                <div class="toolbar-left">
                    <div class="search-box">
                        <i class="bx bx-search"></i>
                        <input id="searchInput" type="search" placeholder="Cari nama dokumen, nomor..."
                            autocomplete="off" />
                    </div>
                    <select class="filter-box" id="statusFilter" aria-label="Filter berdasarkan status">
                        <option value="">Semua Status</option>
                        <option value="FINAL">Final</option>
                        <option value="DRAFT">Draft</option>
                    </select>
                </div>

                <div class="toolbar-right">
                    @auth
                        <button type="button" class="btn-action" data-action="open-document-modal" data-mode="add">
                            <i class="bx bx-cloud-upload"></i> Upload Dokumen
                        </button>
                    @endauth

                    @if ($documents->count() > 0)
                        <a href="{{ route('portal.document.download.all', ['project' => $project->id, 'folder' => $folder->id]) }}"
                            class="btn-action btn-secondary btn-download" data-title="Download Semua Dokumen">
                            <i class="bx bx-archive-in"></i> Download Semua
                        </a>
                    @endif
                </div>
            </div>

            <div class="table-container">
                <div class="table-wrapper">
                    <table id="documentTable" aria-label="Daftar Dokumen">
                        <thead>
                            <tr>
                                <th width="40%">File / Dokumen</th>
                                <th width="15%">No. Registrasi</th>
                                <th width="10%">Revisi</th>
                                <th width="12%">Status</th>
                                <th width="13%">Update Terakhir</th>
                                <th width="10%" style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $doc)
                                @php
                                    $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION) ?: 'unknown');
                                    $extLabel = strtoupper($ext);
                                    $exists = $doc->file_path && file_exists(public_path($doc->file_path));
                                    $sizeDisplay = '-';

                                    if ($exists) {
                                        $size = filesize(public_path($doc->file_path));
                                        $sizeDisplay =
                                            $size >= 1024 * 1024
                                                ? number_format($size / 1024 / 1024, 1) . ' MB'
                                                : number_format($size / 1024, 0) . ' KB';
                                    }

                                    $isFinal = $doc->is_final;
                                    $extClassMap = [
                                        'pdf' => 'ext-pdf',
                                        'docx' => 'ext-docx',
                                        'doc' => 'ext-doc',
                                        'xlsx' => 'ext-xlsx',
                                        'xls' => 'ext-xls',
                                        'dwg' => 'ext-dwg',
                                    ];
                                    $extClass = $extClassMap[$ext] ?? 'ext-unknown';
                                    $previewUrl = $exists ? route('document.show', $doc->id) : '';
                                @endphp

                                <tr data-status="{{ $isFinal ? 'FINAL' : 'DRAFT' }}">
                                    <td>
                                        <div class="file-cell">
                                            <div class="file-badge {{ $extClass }}">{{ $extLabel }}</div>
                                            <div>
                                                {{-- PERUBAHAN NAMA FILE MENJADI LINK --}}
                                                <a href="{{ route('document.show', $doc->id) }}" class="file-name"
                                                    title="Lihat detail: {{ $doc->title }}">
                                                    {{ $doc->title }}
                                                </a>
                                                <div class="file-meta"><i class='bx bx-hdd'></i> {{ $extLabel }} &bull;
                                                    {{ $sizeDisplay }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td
                                        style="font-family: monospace; font-weight: 700; font-size: 1rem; color: var(--primary-light);">
                                        {{ $doc->document_no ?: '—' }}</td>
                                    <td>
                                        <span
                                            style="background: var(--bg); padding: 4px 10px; border-radius: 8px; font-family: monospace; font-weight: 800; color: var(--muted); border: 1px solid var(--border);">v{{ $doc->revision ?: '0' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge-status {{ $isFinal ? 'badge-final' : 'badge-draft' }}">
                                            {{ $isFinal ? 'FINAL' : 'DRAFT' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-weight: 700; font-size: 0.9rem;">
                                            {{ $doc->updated_at->format('d M Y') }}</div>
                                        <div
                                            style="font-size: 0.75rem; color: var(--muted); font-weight: 600; margin-top: 2px;">
                                            {{ $doc->updated_at->format('H:i') }} WIB</div>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            @if ($exists)
                                                @if (in_array($ext, ['pdf', 'html', 'htm']))
                                                    <button type="button" class="btn-icon preview" title="Preview Dokumen"
                                                        data-action="open-document-modal" data-mode="preview"
                                                        data-preview-url="{{ $previewUrl }}"
                                                        data-title="{{ $doc->title }}">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                @endif
                                                @auth
                                                    <a href="{{ route('portal.document.download', $doc->id) }}"
                                                        class="btn-icon download btn-download" data-title="{{ $doc->title }}"
                                                        title="Download File">
                                                        <i class="bx bx-download"></i>
                                                    </a>
                                                @endauth
                                            @else
                                                <button type="button" class="btn-icon disabled"
                                                    title="File Hilang / Tidak Ditemukan" disabled>
                                                    <i class="bx bx-error-circle"></i>
                                                </button>
                                            @endif

                                            @auth
                                                <button type="button"
                                                    class="btn-icon update {{ $doc->is_final ? 'disabled' : '' }}"
                                                    title="{{ $doc->is_final ? 'Dokumen Final tidak dapat diubah' : 'Edit Dokumen' }}"
                                                    data-action="open-document-modal" data-mode="update"
                                                    data-id="{{ $doc->id }}" data-title="{{ $doc->title }}"
                                                    data-document_no="{{ $doc->document_no }}"
                                                    data-revision="{{ $doc->revision }}"
                                                    data-is_final="{{ $doc->is_final ? 1 : 0 }}"
                                                    data-description="{{ $doc->description }}"
                                                    data-update-route="{{ route('document.update', $doc->id) }}"
                                                    @if ($doc->is_final) disabled @endif>
                                                    <i class="bx bx-pencil"></i>
                                                </button>

                                                <form action="{{ route('documents.destroy', $doc->id) }}" method="POST"
                                                    class="form-delete" style="display:inline; margin:0;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-icon delete" title="Hapus Dokumen">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            @endauth
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon"><i class="bx bx-folder-open"></i></div>
                                            <h3>Belum Ada Dokumen</h3>
                                            <p>Folder ini kosong. Silakan klik tombol <b>"Upload Dokumen"</b> di atas untuk
                                                menambahkan file pertama Anda ke dalam folder ini.</p>
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

    <div id="documentModal" class="modal" aria-hidden="true" role="dialog" aria-labelledby="documentModalTitle">
        <div class="modal-overlay" data-action="close-modal"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="documentModalTitle" class="modal-title"><i class="bx bx-cloud-upload"></i> Upload Dokumen</h3>
                <button type="button" class="modal-close-btn" data-action="close-modal" aria-label="Tutup">
                    <i class="bx bx-x"></i>
                </button>
            </div>

            <div class="modal-body" id="documentModalBody">
                <form id="documentForm" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <input type="hidden" name="document_project_id" value="{{ $project->id }}">
                    <input type="hidden" name="document_folder_id" value="{{ $folder->id }}">
                    <input type="hidden" name="_method" id="documentFormMethod" value="POST">

                    <div class="form-row">
                        <div class="form-group" style="flex: 2;">
                            <label for="f_document_no">Nomor Registrasi Dokumen</label>
                            <input id="f_document_no" name="document_no" type="text" class="form-control"
                                placeholder="Cth: DOC-2026-001">
                        </div>

                        <div class="form-group" style="flex: 1;">
                            <label for="f_revision">Revisi</label>
                            <input id="f_revision" name="revision" type="number" min="0" class="form-control"
                                value="0" required>
                        </div>
                    </div>

                    <div class="form-group"
                        style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; background: var(--bg); padding: 14px 18px; border-radius: 12px; border: 1.5px solid var(--border);">
                        <div>
                            <label style="margin:0; font-size: 0.95rem; color: var(--primary);">Kunci Status
                                Dokumen</label>
                            <span class="small-muted" style="margin: 2px 0 0 0;">Jika diset "Final", file tidak bisa
                                diedit lagi.</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="font-weight: 800; font-size: 0.9rem;" id="statusLabel">DRAFT</span>
                            <div class="toggle-switch" id="f_isFinalSwitch" role="switch" tabindex="0"
                                aria-checked="false">
                                <input id="f_is_final" name="is_final" type="checkbox" value="1" hidden>
                                <span class="switch-thumb"></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_file">Pilih File PDF <span style="color:var(--danger)">*</span></label>
                        <input id="f_file" name="file" type="file" class="form-control"
                            accept=".pdf,application/pdf" style="padding: 0.6rem;">
                        <div id="f_fileHelp" class="small-muted"><i class='bx bx-info-circle'></i> Maksimal ukuran file
                            adalah 20MB.</div>
                        <div id="err_file" class="file-error-box"><i class="bx bx-error-circle"></i> <span
                                id="err_file_text"></span></div>
                    </div>

                    <div class="form-group">
                        <label for="f_description">Catatan Transmittal (Opsional)</label>
                        <textarea id="f_description" name="description" class="form-control"
                            placeholder="Tuliskan keterangan mengenai dokumen ini..."></textarea>
                    </div>
                </form>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-action btn-secondary" data-action="close-modal"
                    style="box-shadow: none;">Batal</button>
                <button type="submit" form="documentForm" id="f_btnSave" class="btn-action">
                    <i class="bx bx-save"></i> <span id="f_btnText">Simpan Dokumen</span>
                </button>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        (function() {
            'use strict';
            // ==========================================
            // LOGIKA DOWNLOAD PROGRESS
            // ==========================================
            const MIN_VISIBLE_MS = 2500;

            function sleep(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }

            function createProgressOverlay() {
                const overlay = document.createElement('div');
                overlay.id = 'downloadProgressOverlay';
                overlay.style.position = 'fixed';
                overlay.style.inset = '0';
                overlay.style.zIndex = '99999';
                overlay.style.display = 'flex';
                overlay.style.alignItems = 'center';
                overlay.style.justifyContent = 'center';
                overlay.style.background = 'rgba(15, 23, 42, 0.7)';
                overlay.style.backdropFilter = 'blur(4px)';
                overlay.innerHTML = `
            <div style="width:380px; max-width:92%; background:#fff; border-radius:16px; padding:24px; box-shadow:0 20px 50px rgba(0,0,0,0.3); text-align:left; font-family:'Plus Jakarta Sans',sans-serif;">
                <div style="display:flex; align-items:center; gap:16px; margin-bottom:16px;">
                    <div style="width:52px; height:52px; border-radius:12px; background:linear-gradient(135deg,#2563eb,#1d4ed8); display:flex; align-items:center; justify-content:center; color:#fff; box-shadow:0 4px 10px rgba(37,99,235,0.3);"><i class="bx bx-cloud-download" style="font-size:28px;"></i></div>
                    <div style="flex:1;">
                        <div id="downloadProgressTitle" style="font-weight:800; color:#0f172a; font-size:16px; margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:240px;">Mengunduh...</div>
                        <div id="downloadProgressSub" style="font-size:13px; color:#64748b; font-weight:600;">Menyiapkan koneksi aman</div>
                    </div>
                </div>
                <div>
                    <div style="height:10px; background:#f1f5f9; border-radius:10px; overflow:hidden; box-shadow:inset 0 1px 2px rgba(0,0,0,0.05);">
                        <div id="downloadProgressBar" style="width:0%; height:100%; background:linear-gradient(90deg,#2563eb,#38bdf8); transition:width 200ms ease;"></div>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:12px;">
                        <div id="downloadProgressPercent" style="font-size:14px; color:#0f172a; font-weight:800;">0%</div>
                        <button id="downloadProgressCancel" style="background:#f8fafc; border:1px solid #e2e8f0; padding:6px 14px; border-radius:8px; font-weight:700; color:#dc2626; cursor:pointer; font-size:12px; transition:all 0.2s;">Batalkan</button>
                    </div>
                </div>
            </div>
        `;
                return overlay;
            }

            function extractFilenameFromHeaders(response, url) {
                const cd = response.headers.get('content-disposition') || '';
                let filename = '';
                const re = /filename\*?=(?:UTF-8'')?["']?([^;"']+)/i;
                const m = re.exec(cd);
                if (m && m[1]) {
                    try {
                        filename = decodeURIComponent(m[1].replace(/['"]/g, ''));
                    } catch (e) {
                        filename = m[1].replace(/['"]/g, '');
                    }
                }
                if (!filename) {
                    try {
                        const u = new URL(url, window.location.href);
                        filename = decodeURIComponent(u.pathname.split('/').pop()) || 'download';
                    } catch (e) {
                        filename = 'download';
                    }
                }
                return filename;
            }

            function prettyBytes(n) {
                if (!n && n !== 0) return '-';
                if (n >= 1024 * 1024) return (n / 1024 / 1024).toFixed(1) + ' MB';
                return Math.round(n / 1024) + ' KB';
            }

            async function downloadWithProgress(url, title) {
                const overlay = createProgressOverlay();
                document.body.appendChild(overlay);

                const progressBar = overlay.querySelector('#downloadProgressBar');
                const percentEl = overlay.querySelector('#downloadProgressPercent');
                const titleEl = overlay.querySelector('#downloadProgressTitle');
                const subEl = overlay.querySelector('#downloadProgressSub');
                const cancelBtn = overlay.querySelector('#downloadProgressCancel');

                titleEl.textContent = title || 'Mengunduh...';

                const startedAt = Date.now();
                let indeterminateInterval = null;
                const controller = new AbortController();
                let aborted = false;

                cancelBtn.addEventListener('click', () => {
                    controller.abort();
                    aborted = true;
                });

                try {
                    const response = await fetch(url, {
                        method: 'GET',
                        credentials: 'same-origin',
                        signal: controller.signal
                    });

                    if (!response.ok) throw new Error('Gagal mengunduh file. HTTP ' + response.status);

                    const contentLengthHeader = response.headers.get('content-length');
                    const total = contentLengthHeader ? parseInt(contentLengthHeader, 10) : 0;
                    const filename = extractFilenameFromHeaders(response, url);

                    if (!total) {
                        subEl.textContent = 'Mengunduh (ukuran tak diketahui)...';
                        let w = 0;
                        indeterminateInterval = setInterval(() => {
                            w = (w + 5) % 100;
                            progressBar.style.width = w + '%';
                            percentEl.textContent = '...';
                        }, 200);
                    } else {
                        subEl.textContent = '0 KB / ' + prettyBytes(total);
                    }

                    const reader = response.body && response.body.getReader();
                    if (!reader) {
                        const blob = await response.blob();
                        await finalizeDownload(blob, filename, startedAt, progressBar, percentEl, subEl,
                            indeterminateInterval, overlay);
                        return;
                    }

                    const chunks = [];
                    let received = 0;

                    while (true) {
                        const {
                            done,
                            value
                        } = await reader.read();
                        if (done) break;
                        chunks.push(value);
                        received += value.byteLength || value.length || 0;

                        if (total) {
                            const pct = Math.min(100, Math.round((received / total) * 100));
                            progressBar.style.transition = 'width 100ms linear';
                            progressBar.style.width = pct + '%';
                            percentEl.textContent = pct + '%';
                            subEl.textContent = prettyBytes(received) + ' / ' + prettyBytes(total);
                        }
                    }

                    const blob = new Blob(chunks);
                    await finalizeDownload(blob, filename, startedAt, progressBar, percentEl, subEl,
                        indeterminateInterval, overlay);

                } catch (err) {
                    if (err.name === 'AbortError' || aborted) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Dibatalkan',
                                text: 'Unduhan dihentikan.',
                                icon: 'info',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                title: 'Gagal',
                                text: err.message || 'Terjadi kesalahan jaringan.',
                                icon: 'error'
                            });
                        } else {
                            alert('Gagal mengunduh: ' + (err.message || err));
                        }
                    }
                    if (indeterminateInterval) clearInterval(indeterminateInterval);
                    if (overlay && overlay.parentNode) overlay.parentNode.removeChild(overlay);
                }
            }

            async function finalizeDownload(blob, filename, startedAt, progressBar, percentEl, subEl,
                indeterminateInterval, overlay) {
                if (indeterminateInterval) clearInterval(indeterminateInterval);

                const elapsed = Date.now() - startedAt;
                const remaining = Math.max(0, MIN_VISIBLE_MS - elapsed);

                try {
                    subEl.textContent = prettyBytes(blob.size) + ' Selesai';
                } catch (e) {}

                progressBar.style.transition = `width ${Math.min(remaining, 800)}ms ease`;
                progressBar.style.width = '100%';
                percentEl.textContent = '100%';
                await sleep(remaining + 200);

                const objectUrl = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = objectUrl;
                a.download = filename || 'document';
                document.body.appendChild(a);
                a.click();
                a.remove();

                setTimeout(() => URL.revokeObjectURL(objectUrl), 2000);
                if (overlay && overlay.parentNode) overlay.parentNode.removeChild(overlay);

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Sukses',
                        text: 'Dokumen berhasil diunduh.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            }

            document.addEventListener('click', function(e) {
                const anchor = e.target.closest('a.btn-download, a[href*="/portal/document/download"]');
                if (!anchor) return;
                const href = anchor.getAttribute('href');
                if (!href) return;
                e.preventDefault();
                const title = anchor.dataset.title || anchor.getAttribute('data-title') || 'Mengunduh Dokumen';
                downloadWithProgress(href, title);
            }, true);
        })();

        // ==========================================
        // UI & MODAL SCRIPT
        // ==========================================
        document.addEventListener('DOMContentLoaded', function() {
            const $ = (s) => document.querySelector(s);

            // Search & Filter
            $('#searchInput')?.addEventListener('input', function() {
                const q = this.value.toLowerCase().trim();
                document.querySelectorAll('#documentTable tbody tr').forEach(row => {
                    if (row.querySelector('td[colspan]')) return;
                    row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
                });
            });

            $('#statusFilter')?.addEventListener('change', function() {
                const st = this.value;
                document.querySelectorAll('#documentTable tbody tr').forEach(row => {
                    if (row.querySelector('td[colspan]')) return;
                    row.style.display = (st === '' || row.dataset.status === st) ? '' : 'none';
                });
            });

            // Modal Logic
            const modalRoot = $('#documentModal');
            const modalBody = $('#documentModalBody');
            const modalTitle = $('#documentModalTitle');
            const originalFormHTML = modalBody.innerHTML;

            function showModal() {
                modalRoot.setAttribute('aria-hidden', 'false');
                document.body.style.overflow = 'hidden';
            }

            function hideModal() {
                modalRoot.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
                setTimeout(() => {
                    modalBody.innerHTML = originalFormHTML;
                }, 300);
            }

            function initToggle() {
                const root = $('#f_isFinalSwitch');
                const cb = $('#f_is_final');
                const label = $('#statusLabel');
                if (!root || !cb) return;

                function updateVis(on) {
                    root.classList.toggle('on', on);
                    cb.checked = on;
                    root.setAttribute('aria-checked', on ? 'true' : 'false');
                    if (label) {
                        label.textContent = on ? 'FINAL' : 'DRAFT';
                        label.style.color = on ? 'var(--success)' : 'var(--muted)';
                    }
                }

                updateVis(cb.checked);
                root.onclick = () => updateVis(!cb.checked);
            }

            function initFileHelper() {
                const fileIn = $('#f_file');
                const errBox = $('#err_file');
                const errTxt = $('#err_file_text');
                const help = $('#f_fileHelp');

                if (!fileIn) return;

                fileIn.addEventListener('change', function() {
                    errBox.style.display = 'none';
                    fileIn.classList.remove('is-invalid');

                    if (!this.files.length) {
                        help.innerHTML =
                            '<i class="bx bx-info-circle"></i> Maksimal ukuran file adalah 20MB.';
                        return;
                    }

                    const f = this.files[0];
                    if (f.type !== 'application/pdf' && !f.name.toLowerCase().endsWith('.pdf')) {
                        errTxt.textContent = 'Hanya menerima format PDF.';
                        errBox.style.display = 'flex';
                        fileIn.classList.add('is-invalid');
                        this.value = '';
                        return;
                    }

                    if (f.size > 20 * 1024 * 1024) {
                        errTxt.textContent = 'Ukuran file melebihi batas 20MB.';
                        errBox.style.display = 'flex';
                        fileIn.classList.add('is-invalid');
                        this.value = '';
                        return;
                    }

                    help.innerHTML =
                        `<i class='bx bx-check-circle' style='color:var(--success)'></i> <b>${f.name}</b> (${Math.round(f.size / 1024)} KB) siap diunggah.`;
                });

                $('#documentForm')?.addEventListener('submit', function(e) {
                    if (!fileIn.files.length && !$('#documentFormMethod').value.includes('PUT')) {
                        e.preventDefault();
                        errTxt.textContent = 'File PDF wajib dilampirkan!';
                        errBox.style.display = 'flex';
                        fileIn.classList.add('is-invalid');
                    }
                });
            }

            function openAdd() {
                modalTitle.innerHTML = '<i class="bx bx-cloud-upload"></i> Upload Dokumen';
                modalBody.innerHTML = originalFormHTML;

                const form = $('#documentForm');
                form.action =
                    "{{ route('document.store', ['project' => $project->id ?? 0, 'folder' => $folder->id ?? 0]) }}";
                $('#documentFormMethod').value = 'POST';
                $('#f_btnText').textContent = "Upload Sekarang";

                initToggle();
                initFileHelper();
                showModal();
            }

            function openUpdate(data) {
                modalTitle.innerHTML = '<i class="bx bx-edit"></i> Edit Properti Dokumen';
                modalBody.innerHTML = originalFormHTML;

                const form = $('#documentForm');
                form.action = data.updateRoute;
                $('#documentFormMethod').value = 'PUT';
                $('#f_btnText').textContent = "Simpan Perubahan";

                if ($('#f_document_no')) $('#f_document_no').value = data.document_no || '';
                if ($('#f_revision')) $('#f_revision').value = data.revision || 0;
                if ($('#f_description')) $('#f_description').value = data.description || '';
                if ($('#f_is_final')) $('#f_is_final').checked = (data.is_final === '1');

                if ($('#f_fileHelp')) $('#f_fileHelp').innerHTML =
                    '<i class="bx bx-info-circle"></i> Biarkan kosong jika <b>tidak ingin mengganti</b> file PDF.';

                initToggle();
                initFileHelper();
                showModal();
            }

            function openPreview(url, title) {
                modalTitle.innerHTML = `<i class="bx bx-show"></i> Preview: ${title}`;
                modalBody.innerHTML = `
                    <div style="height: 70vh; border-radius: 12px; overflow: hidden; background: #334155; display:flex; align-items:center; justify-content:center;">
                        <iframe src="${url}#toolbar=0" style="width: 100%; height: 100%; border: none;"></iframe>
                    </div>
                `;
                showModal();
            }

            document.addEventListener('click', e => {
                const addBtn = e.target.closest('[data-mode="add"]');
                if (addBtn) {
                    e.preventDefault();
                    openAdd();
                    return;
                }

                const updateBtn = e.target.closest('[data-mode="update"]');
                if (updateBtn) {
                    e.preventDefault();
                    if (updateBtn.classList.contains('disabled')) return;
                    openUpdate(updateBtn.dataset);
                    return;
                }

                const prevBtn = e.target.closest('[data-mode="preview"]');
                if (prevBtn) {
                    e.preventDefault();
                    openPreview(prevBtn.dataset.previewUrl, prevBtn.dataset.title);
                    return;
                }

                if (e.target.closest('[data-action="close-modal"]')) {
                    hideModal();
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && modalRoot.getAttribute('aria-hidden') === 'false') hideModal();
            });

            // SweetAlert Deletion
            document.querySelectorAll('.form-delete').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus Dokumen?',
                        text: "File PDF dan seluruh riwayat akan terhapus permanen.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Hapus Permanen!',
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'rounded-2xl'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            // Toasts Notifications
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
                customClass: {
                    popup: 'rounded-xl shadow-lg border border-slate-100'
                }
            });
            @if (session('success_add'))
                Toast.fire({
                    icon: 'success',
                    title: "{{ session('success_add') }}"
                });
            @endif
            @if (session('success_update'))
                Toast.fire({
                    icon: 'info',
                    title: "{{ session('success_update') }}"
                });
            @endif
            @if (session('success_delete'))
                Toast.fire({
                    icon: 'warning',
                    title: "{{ session('success_delete') }}"
                });
            @endif
        });
    </script>
@endpush
