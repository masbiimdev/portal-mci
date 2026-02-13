@extends('layouts.home')

@section('title', 'Folder ' . $folder->folder_name . ' — Document Transmittal')

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

        html, body {
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

        /* ========== CARD ========== */
        .card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .card:hover {
            box-shadow: var(--shadow);
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 50%, var(--primary-light) 50%);
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

        /* ========== TOOLBAR ========== */
        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--card);
        }

        .search-wrapper {
            flex: 1;
            min-width: 220px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg);
            border: 1.5px solid var(--border);
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
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
            background: transparent;
            width: 100%;
            font-size: 13px;
            color: var(--primary);
        }

        .search-wrapper input::placeholder {
            color: var(--muted-light);
        }

        .filter-select {
            padding: 8px 12px;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            background: var(--card);
            color: var(--primary);
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-select:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .filter-select:hover {
            border-color: var(--accent);
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: linear-gradient(135deg, var(--accent), #7c3aed);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            color: #fff;
            text-decoration: none;
        }

        .btn-action:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: var(--card);
            color: var(--accent);
            border: 1.5px solid var(--accent);
        }

        .btn-secondary:hover {
            background: var(--accent-soft);
        }

        /* ========== TABLE ========== */
        .table-wrapper {
            max-height: 600px;
            overflow-y: hidden;
            background: var(--card);
        }

        .table-wrapper::-webkit-scrollbar {
            width: 6px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: rgba(37, 99, 235, 0.05);
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: rgba(37, 99, 235, 0.3);
            border-radius: 3px;
        }

        .table-wrapper::-webkit-scrollbar-thumb:hover {
            background: rgba(37, 99, 235, 0.5);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        table thead th {
            position: sticky;
            top: 0;
            background: var(--card);
            z-index: 10;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            font-weight: 700;
            border-bottom: 1px solid var(--border);
            padding: 14px 16px;
        }

        table tbody td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
            font-size: 13px;
        }

        table tbody tr {
            transition: background 0.15s ease, box-shadow 0.15s ease;
        }

        table tbody tr:hover {
            background: var(--bg);
            box-shadow: inset 3px 0 0 var(--accent);
        }

        /* ========== FILE INFO ========== */
        .file-cell {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .file-badge {
            width: 44px;
            height: 44px;
            min-width: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-weight: 700;
            color: #fff;
            font-size: 11px;
            text-transform: uppercase;
            transition: transform 0.2s ease;
        }

        table tbody tr:hover .file-badge {
            transform: scale(1.06);
        }

        .file-badge.ext-pdf {
            background: linear-gradient(135deg, #dc2626, #991b1b);
        }

        .file-badge.ext-docx,
        .file-badge.ext-doc {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
        }

        .file-badge.ext-xlsx,
        .file-badge.ext-xls {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .file-badge.ext-dwg {
            background: linear-gradient(135deg, #7c3aed, #6d28d9);
        }

        .file-badge.ext-unknown {
            background: linear-gradient(135deg, #64748b, #475569);
        }

        .file-name {
            font-weight: 700;
            color: var(--primary);
            margin: 0;
        }

        .file-meta {
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* ========== BADGES ========== */
        .badge-status {
            display: inline-block;
            font-size: 11px;
            padding: 6px 12px;
            border-radius: 999px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-final {
            background: #ecfdf5;
            color: #027a3b;
        }

        .badge-draft {
            background: #f3f4f6;
            color: #374151;
        }

        /* ========== ACTIONS ========== */
        .actions {
            display: flex;
            gap: 6px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: var(--card);
            cursor: pointer;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
            color: var(--primary);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
        }

        .btn-preview {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            border: none;
        }

        .btn-preview:hover {
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-download {
            background: linear-gradient(135deg, var(--accent), #1d4ed8);
            color: #fff;
            border: none;
        }

        .btn-download:hover {
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-update {
            background: linear-gradient(135deg, var(--success), #15803d);
            color: #fff;
            border: none;
        }

        .btn-update:hover {
            box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
        }

        .btn-disabled {
            background: var(--bg);
            color: var(--muted);
            cursor: not-allowed;
        }

        /* ========== EMPTY STATE ========== */
        .empty-row {
            padding: 60px 20px;
            text-align: center;
            color: var(--muted);
        }

        .empty-state-icon {
            font-size: 48px;
            color: var(--muted-light);
            margin-bottom: 16px;
        }

        .empty-state h3 {
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
        }

        .empty-state p {
            margin: 0;
            font-size: 13px;
            color: var(--muted);
        }

        /* ========== MODAL ========== */
        #documentModal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(15, 23, 42, 0.5);
            z-index: 2000;
            padding: 20px;
            opacity: 0;
            transition: opacity 0.2s ease;
            pointer-events: none;
        }

        #documentModal.show {
            display: flex;
            opacity: 1;
            pointer-events: auto;
        }

        .document-modal {
            width: 100%;
            max-width: 600px;
            background: var(--card);
            border-radius: var(--radius);
            overflow: hidden;
            transform: translateY(20px) scale(0.95);
            opacity: 0;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-lg);
        }

        #documentModal.show .document-modal {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--border);
        }

        .modal-title {
            margin: 0;
            font-weight: 700;
            font-size: 18px;
            color: var(--primary);
        }

        .modal-close-btn {
            background: transparent;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: var(--muted);
            padding: 4px 8px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .modal-close-btn:hover {
            background: var(--bg);
            color: var(--primary);
        }

        .modal-body {
            padding: 20px;
            max-height: 70vh;
            overflow-y: hidden;
        }

        /* ========== FORM ========== */
        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 160px;
        }

        label {
            display: block;
            font-size: 13px;
            margin-bottom: 8px;
            color: var(--primary);
            font-weight: 600;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1.5px solid var(--border);
            transition: all 0.2s ease;
            font-size: 13px;
            font-family: inherit;
            color: var(--primary);
        }

        .form-control:focus,
        .form-select:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        .small-muted {
            color: var(--muted);
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        /* ========== TOGGLE SWITCH ========== */
        .toggle-switch {
            width: 44px;
            height: 24px;
            border-radius: 999px;
            background: var(--border);
            position: relative;
            cursor: pointer;
            transition: background 0.2s ease;
            border: none;
            padding: 0;
        }

        .toggle-switch.on {
            background: var(--success);
        }

        .switch-thumb {
            position: absolute;
            top: 3px;
            left: 3px;
            width: 18px;
            height: 18px;
            background: #fff;
            border-radius: 50%;
            transition: transform 0.2s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .toggle-switch.on .switch-thumb {
            transform: translateX(20px);
        }

        /* ========== MODAL ACTIONS ========== */
        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-ghost {
            background: transparent;
            border: 1px solid var(--border);
            color: var(--primary);
        }

        .btn-ghost:hover {
            background: var(--bg);
        }

        #f_btnSave {
            background: linear-gradient(135deg, var(--accent), #1d4ed8);
            color: #fff;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        #f_btnSave:hover {
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        #f_btnSave:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .container-main {
                padding: 24px 16px;
            }

            .page-header {
                flex-direction: column;
                gap: 16px;
                padding: 24px;
            }

            .header-main h2 {
                font-size: 22px;
            }

            .toolbar {
                flex-direction: column;
            }

            .search-wrapper {
                width: 100%;
            }

            .filter-select {
                width: 100%;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }

            .document-modal {
                max-width: 90vw;
            }

            .table-wrapper {
                max-height: 400px;
            }

            table thead th {
                font-size: 10px;
                padding: 10px;
            }

            table tbody td {
                padding: 12px;
                font-size: 12px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .container-main {
                padding: 16px 12px;
            }

            .page-header {
                padding: 16px;
            }

            .header-main h2 {
                font-size: 18px;
            }

            .header-meta {
                width: 100%;
            }

            .form-row {
                flex-direction: column;
            }

            .file-badge {
                width: 40px;
                height: 40px;
                font-size: 10px;
            }

            .breadcrumb-nav {
                font-size: 11px;
            }
        }

        /* ========== ACCESSIBILITY ========== */
        button:focus-visible,
        a:focus-visible,
        input:focus-visible,
        select:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* ========== ANIMATIONS ========== */
        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        <!-- BREADCRUMB -->
        {{-- <div class="breadcrumb-nav">
            <a href="{{ route('projects.index') }}">
                <i class="bi bi-house-fill"></i> Projects
            </a>
            <i class="bi bi-chevron-right"></i>
            <a href="{{ route('document.folder', $project->id) }}">
                {{ $project->project_name ?? 'Project' }}
            </a>
            <i class="bi bi-chevron-right"></i>
            <span>{{ $folder->folder_name }}</span>
        </div> --}}

        <!-- PAGE HEADER -->
        <div class="page-header">
            <div class="header-main">
                <h2>📄 {{ $folder->folder_name }}</h2>
                <small>
                    {{ $folder->description ?? 'Dokumen resmi project' }}<br>
                    <strong>{{ $documents->count() }} dokumen</strong> 
                    • Update terakhir 
                    <strong>
                        {{ $documents->isNotEmpty() ? $documents->first()->updated_at->format('d M Y') : '—' }}
                    </strong>
                </small>
            </div>

            <div class="header-meta">
                <div class="header-meta-label">📁 Project</div>
                <div class="header-meta-value">{{ $project->project_name ?? '—' }}</div>
            </div>
        </div>

        <!-- DOCUMENT LIST CARD -->
        <div class="card">

            <!-- TOOLBAR -->
            <div class="toolbar">
                <div class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input 
                        id="searchInput" 
                        type="search" 
                        placeholder="Cari dokumen, nomor, atau revisi..." 
                        aria-label="Cari dokumen"
                        autocomplete="off"
                    />
                </div>

                <select class="filter-select" id="statusFilter" aria-label="Filter berdasarkan status">
                    <option value="">Semua Status</option>
                    <option value="FINAL">Final</option>
                    <option value="DRAFT">Draft</option>
                </select>

                @auth
                    <button type="button" class="btn-action" data-action="open-document-modal" data-mode="add">
                        <i class="bi bi-plus-lg"></i>
                        Tambah Dokumen
                    </button>
                @endauth

                <a href="{{ route('portal.document.download.all', ['project' => $project->id, 'folder' => $folder->id]) }}"
                   class="btn-action btn-secondary">
                    <i class="bi bi-download"></i>
                    Download Semua
                </a>
            </div>

            <!-- TABLE -->
            <div class="table-wrapper">
                <table id="documentTable" role="table" aria-label="Daftar dokumen">
                    <thead>
                        <tr>
                            <th>Dokumen</th>
                            <th>Nomor</th>
                            <th>Revisi</th>
                            <th>Status</th>
                            <th>Update</th>
                            <th style="text-align:right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documents as $doc)
                            @php
                                $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION) ?: 'unknown');
                                $extLabel = strtoupper($ext);
                                $exists = $doc->file_path && Storage::exists($doc->file_path);
                                $sizeDisplay = '-';
                                if ($exists) {
                                    $size = Storage::size($doc->file_path);
                                    $sizeDisplay = $size >= 1024 * 1024
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
                                            <div class="file-name">{{ $doc->title }}</div>
                                            <div class="file-meta">{{ $extLabel }} • {{ $sizeDisplay }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $doc->document_no ?: '—' }}</td>
                                <td><strong>Rev. {{ $doc->revision ?: '—' }}</strong></td>
                                <td>
                                    <span class="badge-status {{ $isFinal ? 'badge-final' : 'badge-draft' }}">
                                        {{ $isFinal ? 'FINAL' : 'DRAFT' }}
                                    </span>
                                </td>
                                <td>
                                    <time datetime="{{ $doc->updated_at->toDateString() }}">
                                        {{ $doc->updated_at->format('d M Y') }}
                                    </time>
                                </td>
                                <td>
                                    <div class="actions">
                                        @if ($exists)
                                            @if (in_array($ext, ['pdf', 'html', 'htm']))
                                                <button type="button" class="btn btn-preview"
                                                    data-action="open-document-modal" 
                                                    data-mode="preview"
                                                    data-preview-url="{{ $previewUrl }}"
                                                    data-title="{{ $doc->title }}">
                                                    <i class="bi bi-eye"></i>
                                                    Preview
                                                </button>
                                            @endif

                                            <a href="{{ route('portal.document.download', $doc->id) }}"
                                               class="btn btn-download">
                                                <i class="bi bi-download"></i>
                                                Download
                                            </a>
                                        @else
                                            <span class="btn btn-disabled">
                                                <i class="bi bi-exclamation-circle"></i>
                                                File hilang
                                            </span>
                                        @endif

                                        @auth
                                            <button type="button" class="btn btn-update"
                                                data-action="open-document-modal" 
                                                data-mode="update"
                                                data-id="{{ $doc->id }}" 
                                                data-title="{{ $doc->title }}"
                                                data-document_no="{{ $doc->document_no }}"
                                                data-revision="{{ $doc->revision }}"
                                                data-is_final="{{ $doc->is_final ? 1 : 0 }}"
                                                data-description="{{ $doc->description }}"
                                                data-update-route="{{ route('document.update', $doc->id) }}">
                                                <i class="bi bi-pencil"></i>
                                                Update
                                            </button>
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-row">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">📂</div>
                                        <h3>Belum ada dokumen</h3>
                                        <p>Folder ini belum memiliki dokumen. Silakan upload dokumen terlebih dahulu.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>

    <!-- MODAL -->
    <div id="documentModal" aria-hidden="true" role="dialog" aria-labelledby="documentModalTitle">
        <div class="document-modal" role="document" aria-modal="true">

            <div class="modal-header">
                <h5 id="documentModalTitle" class="modal-title">Dokumen</h5>
                <button type="button" class="modal-close-btn" data-action="close-modal" aria-label="Tutup">
                    ✕
                </button>
            </div>

            <div class="modal-body" id="documentModalBody">
                <form id="documentForm" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <input type="hidden" name="document_project_id" value="{{ $project->id }}">
                    <input type="hidden" name="document_folder_id" value="{{ $folder->id }}">
                    <input type="hidden" name="_method" id="documentFormMethod" value="POST">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="f_document_no">Nomor Dokumen</label>
                            <input id="f_document_no" name="document_no" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="f_revision">Revisi</label>
                            <input id="f_revision" name="revision" type="text" class="form-control">
                        </div>

                        <div class="form-group" style="max-width: 140px; justify-content: flex-end;">
                            <label for="f_is_final">Final</label>
                            <div style="display: flex; align-items: center; gap: 8px; margin-top: 6px;">
                                <div class="toggle-switch" id="f_isFinalSwitch" role="switch" tabindex="0"
                                    aria-checked="false" aria-labelledby="f_isFinalLabel">
                                    <input id="f_is_final" name="is_final" type="checkbox" value="1" hidden>
                                    <span class="switch-thumb"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="f_file">
                            File 
                            <span class="small-muted">(.pdf, .docx, .xlsx, .dwg, .jpg, .png, .zip) *</span>
                        </label>
                        <input id="f_file" name="file" type="file" class="form-control"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.dwg,.jpg,.jpeg,.png,.zip">
                        <div id="f_fileHelp" class="small-muted">
                            Untuk tambah pilih file. Untuk update ganti file lama.
                        </div>
                        <div class="text-danger small" id="err_file" style="display:none; color: var(--danger); margin-top: 6px;"></div>
                    </div>

                    <div class="form-group">
                        <label for="f_description">Keterangan (opsional)</label>
                        <textarea id="f_description" name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn btn-ghost" data-action="close-modal">
                            Batal
                        </button>

                        <button type="submit" id="f_btnSave" class="btn btn-action">
                            <span id="f_btnText">Simpan</span>
                            <svg id="f_btnSpinner" style="display:none; width: 14px; height: 14px;" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="rgba(255,255,255,0.45)" stroke-width="3"></circle>
                                <path d="M22 12a10 10 0 0 0-10-10" stroke="#fff" stroke-width="3" stroke-linecap="round"></path>
                            </svg>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const $ = (s) => document.querySelector(s);

            const modalRoot = $('#documentModal');
            const modalBody = $('#documentModalBody');
            const modalTitle = $('#documentModalTitle');
            const originalFormHTML = modalBody.innerHTML;

            /* MODAL CONTROL */
            function showModal() {
                modalRoot.classList.add('show');
                modalRoot.setAttribute('aria-hidden', 'false');
                document.documentElement.style.overflow = 'hidden';
                document.body.style.overflow = 'hidden';
            }

            function hideModal() {
                modalRoot.classList.remove('show');
                modalRoot.setAttribute('aria-hidden', 'true');
                document.documentElement.style.overflow = '';
                document.body.style.overflow = '';
                modalBody.innerHTML = originalFormHTML;
            }

            /* TOGGLE FINAL SWITCH */
            function initToggle() {
                const root = $('#f_isFinalSwitch');
                const cb = $('#f_is_final');
                if (!root || !cb) return;

                function setVisual(on) {
                    root.classList.toggle('on', on);
                    cb.checked = on;
                    root.setAttribute('aria-checked', on ? 'true' : 'false');
                }

                setVisual(cb.checked);

                root.onclick = () => setVisual(!cb.checked);

                root.onkeydown = (e) => {
                    if (e.key === ' ' || e.key === 'Enter') {
                        e.preventDefault();
                        setVisual(!cb.checked);
                    }
                };

                cb.onchange = () => setVisual(cb.checked);
            }

            /* FILE HELPER */
            function initFileHelper() {
                const fileInput = $('#f_file');
                const help = $('#f_fileHelp');
                if (!fileInput || !help) return;

                fileInput.addEventListener('change', function() {
                    if (fileInput.files.length) {
                        const f = fileInput.files[0];
                        help.textContent = f.name + ' • ' + Math.round(f.size / 1024) + ' KB';
                    } else {
                        help.textContent = 'Pilih file untuk diupload.';
                    }
                });
            }

            /* SUBMIT HANDLER */
            function initSubmitHandler() {
                const form = $('#documentForm');
                if (!form) return;

                form.addEventListener('submit', function(e) {

                    const fileInput = $('#f_file');
                    const submitBtn = $('#f_btnSave');
                    const btnText = $('#f_btnText');
                    const spinner = $('#f_btnSpinner');

                    if (!fileInput.files.length) {
                        e.preventDefault();
                        alert('File wajib diupload.');
                        return;
                    }

                    if (submitBtn.dataset.submitted === '1') {
                        e.preventDefault();
                        return;
                    }

                    submitBtn.dataset.submitted = '1';
                    submitBtn.disabled = true;
                    spinner.style.display = 'inline-block';
                    btnText.textContent = 'Menyimpan...';
                });
            }

            /* OPEN ADD */
            function openAdd() {
                modalTitle.textContent = 'Tambah Dokumen Baru';
                modalBody.innerHTML = originalFormHTML;

                const form = $('#documentForm');
                form.action = "{{ route('document.store', ['project' => $project->id, 'folder' => $folder->id]) }}";
                $('#documentFormMethod').value = 'POST';

                form.reset();
                $('#f_fileHelp').textContent = 'Pilih file untuk diupload.';

                initToggle();
                initFileHelper();
                initSubmitHandler();

                showModal();
            }

            /* OPEN UPDATE */
            function openUpdate(data) {

                modalTitle.textContent = 'Update Dokumen';
                modalBody.innerHTML = originalFormHTML;

                const form = $('#documentForm');
                form.action = data.updateRoute;
                $('#documentFormMethod').value = 'PUT';

                $('#f_document_no').value = data.document_no || '';
                $('#f_revision').value = data.revision || '';
                $('#f_description').value = data.description || '';
                $('#f_is_final').checked = (data.is_final === '1');

                $('#f_fileHelp').textContent = 'Pilih file pengganti untuk diupload.';

                initToggle();
                initFileHelper();
                initSubmitHandler();

                showModal();
            }

            /* OPEN PREVIEW */
            function openPreview(url, title) {
                modalTitle.textContent = title || 'Preview';

                modalBody.innerHTML = `
                    <div style="height: 70vh; border-radius: 8px; overflow: hidden;">
                        <iframe src="${url}" style="width: 100%; height: 100%; border: 0;"></iframe>
                    </div>
                `;

                showModal();
            }

            /* SEARCH & FILTER */
            document.getElementById('searchInput')?.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();
                document.querySelectorAll('#documentTable tbody tr').forEach(row => {
                    row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
                });
            });

            document.getElementById('statusFilter')?.addEventListener('change', function() {
                const status = this.value;
                document.querySelectorAll('#documentTable tbody tr').forEach(row => {
                    row.style.display = (status === '' || row.dataset.status === status) ? '' : 'none';
                });
            });

            /* CLICK DELEGATION */
            document.addEventListener('click', function(e) {

                const addBtn = e.target.closest('[data-mode="add"]');
                if (addBtn) {
                    e.preventDefault();
                    openAdd();
                    return;
                }

                const previewBtn = e.target.closest('[data-mode="preview"]');
                if (previewBtn) {
                    e.preventDefault();
                    openPreview(previewBtn.dataset.previewUrl, previewBtn.dataset.title);
                    return;
                }

                const updateBtn = e.target.closest('[data-mode="update"]');
                if (updateBtn) {
                    e.preventDefault();
                    openUpdate({
                        id: updateBtn.dataset.id,
                        document_no: updateBtn.dataset.document_no,
                        revision: updateBtn.dataset.revision,
                        is_final: updateBtn.dataset.is_final,
                        description: updateBtn.dataset.description,
                        updateRoute: updateBtn.dataset.updateRoute
                    });
                    return;
                }

                if (e.target.closest('[data-action="close-modal"]') || e.target === modalRoot) {
                    hideModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modalRoot.classList.contains('show')) {
                    hideModal();
                }
            });

        });
    </script>
@endpush