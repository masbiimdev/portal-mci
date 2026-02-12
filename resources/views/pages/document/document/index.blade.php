@extends('layouts.home')

@section('title', 'Folder ' . $folder->folder_name . ' — Document Transmittal')

@push('css')
    <style>
        /* Page-scoped styles (self-contained) - smoother UI */
        :root {
            --bg: #f6f8fb;
            --card: #fff;
            --muted: #6b7280;
            --accent: #0b5ed7;
            --accent-600: #0a58ca;
            --success: #10b981;
            --radius: 12px;
            --shadow-soft: 0 6px 20px rgba(11, 20, 40, 0.06);
            --shadow-strong: 0 14px 40px rgba(11, 20, 40, 0.12);
            --max-width: 1100px;
            --modal-z: 2000;
            --transition-fast: 180ms;
            --transition-medium: 280ms;
        }

        body {
            background: var(--bg);
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
        }

        .container-main {
            max-width: var(--max-width);
            margin: 44px auto;
            padding: 20px;
        }

        .card-soft {
            background: var(--card);
            border-radius: var(--radius);
            box-shadow: var(--shadow-soft);
            border: 1px solid rgba(15, 23, 42, 0.04);
            transition: box-shadow var(--transition-medium), transform var(--transition-medium);
        }

        .card-soft:hover {
            box-shadow: var(--shadow-strong);
            transform: translateY(-4px);
        }

        .card-header-compact {
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px
        }

        .folder-title {
            font-size: 1.35rem;
            margin: 0;
            letter-spacing: -0.2px
        }

        .folder-desc {
            color: var(--muted);
            margin: 6px 0 0;
            font-size: .95rem
        }

        .meta-small {
            color: var(--muted);
            font-size: .9rem;
            margin-top: 8px
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            color: var(--muted)
        }

        /* Toolbar */
        .toolbar {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 12px 16px;
            flex-wrap: wrap
        }

        .search {
            flex: 1 1 320px;
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f2f6ff;
            padding: 8px 12px;
            border-radius: 12px;
            transition: box-shadow var(--transition-fast), transform var(--transition-fast);
            border: 1px solid rgba(11, 92, 214, 0.04)
        }

        .search:focus-within {
            box-shadow: 0 6px 18px rgba(11, 92, 214, 0.08);
            transform: translateY(-1px)
        }

        .search input {
            border: 0;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: .95rem;
            color: #0f172a
        }

        .select-wrap {
            min-width: 160px
        }

        .form-select {
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid rgba(15, 23, 42, 0.06)
        }

        .btn-primary-outline,
        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: transform var(--transition-fast), box-shadow var(--transition-fast), background var(--transition-fast)
        }

        .btn-primary-outline {
            border: 1px solid rgba(11, 92, 214, 0.12);
            background: transparent;
            color: var(--accent)
        }

        .btn-primary {
            background: linear-gradient(180deg, var(--accent), var(--accent-600));
            color: #fff;
            border: 0
        }

        /* Table */
        .table-wrap {
            padding: 12px 0 18px 0
        }

        table.doc-table {
            width: 100%;
            border-collapse: collapse;
            font-size: .95rem;
            border-radius: 8px;
            overflow: hidden
        }

        table.doc-table thead th {
            text-align: left;
            font-weight: 700;
            color: var(--muted);
            padding: 14px 12px;
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
            background: linear-gradient(180deg, #fbfdff, #ffffff)
        }

        table.doc-table tbody td {
            padding: 14px 12px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(15, 23, 42, 0.03);
            transition: background var(--transition-fast)
        }

        table.doc-table tbody tr {
            transition: transform var(--transition-fast), box-shadow var(--transition-fast)
        }

        table.doc-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(11, 20, 40, 0.04)
        }

        .file-cell {
            display: flex;
            gap: 12px;
            align-items: center
        }

        .file-badge {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            font-size: .85rem;
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.06), rgba(0, 0, 0, 0.02));
            flex-shrink: 0;
            transition: transform var(--transition-fast)
        }

        tr:hover .file-badge {
            transform: scale(1.04)
        }

        .ext-pdf {
            background: #e11d48
        }

        .ext-docx {
            background: #0ea5e9
        }

        .ext-xlsx {
            background: #059669
        }

        .ext-dwg {
            background: #7c3aed
        }

        .ext-unknown {
            background: #6b7280
        }

        .file-meta {
            color: var(--muted);
            font-size: .88rem;
            margin-top: 2px
        }

        .badge-status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            color: #fff;
            font-weight: 700;
            font-size: .82rem
        }

        .badge-final {
            background: var(--success)
        }

        .badge-draft {
            background: #9ca3af
        }

        .actions {
            display: flex;
            gap: 8px;
            justify-content: flex-end
        }

        .btn {
            padding: 6px 10px;
            border-radius: 8px;
            border: 1px solid rgba(15, 23, 42, 0.06);
            background: #fff;
            cursor: pointer;
            transition: transform var(--transition-fast), box-shadow var(--transition-fast)
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(11, 20, 40, 0.06)
        }

        .btn-sm {
            padding: 6px 8px;
            font-size: .86rem
        }

        .empty-row {
            padding: 40px 0;
            text-align: center;
            color: var(--muted);
            font-size: 0.98rem
        }

        /* Modal */
        #documentModal {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(4, 10, 25, 0.45);
            z-index: var(--modal-z);
            padding: 20px;
            opacity: 0;
            transition: opacity var(--transition-medium) ease;
            pointer-events: none;
        }

        #documentModal.show {
            display: flex;
            opacity: 1;
            pointer-events: auto;
        }

        .document-modal {
            width: 100%;
            max-width: 920px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            transform: translateY(8px) scale(.995);
            opacity: 0;
            transition: transform var(--transition-medium) ease, opacity var(--transition-medium) ease;
            box-shadow: 0 16px 48px rgba(2, 6, 23, 0.12);
        }

        #documentModal.show .document-modal {
            transform: translateY(0) scale(1);
            opacity: 1;
        }

        .document-modal .modal-header,
        .document-modal .modal-footer {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(15, 23, 42, 0.04);
        }

        .document-modal .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .document-modal .modal-body {
            padding: 16px;
            max-height: 72vh;
            overflow: hidden;
            -webkit-overflow-scrolling: touch;
        }

        .modal-title {
            margin: 0;
            font-weight: 700;
            font-size: 1.05rem;
        }

        .modal-close-btn {
            background: transparent;
            border: 0;
            font-size: 20px;
            cursor: pointer;
            color: var(--muted);
            padding: 6px;
            border-radius: 6px;
        }

        .modal-close-btn:hover {
            background: rgba(0, 0, 0, 0.03);
            color: #111827;
        }

        /* small helpers */
        .form-row {
            display: flex;
            gap: 12px
        }

        .form-group {
            margin-bottom: 12px;
            width: 100%
        }

        label {
            display: block;
            font-size: .92rem;
            margin-bottom: 8px;
            color: #111827
        }

        input.form-control,
        textarea.form-control {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid rgba(15, 23, 42, 0.06);
            transition: box-shadow var(--transition-fast), border-color var(--transition-fast);
            font-size: .95rem
        }

        input.form-control:focus,
        textarea.form-control:focus {
            outline: none;
            box-shadow: 0 6px 18px rgba(11, 92, 214, 0.06);
            border-color: rgba(11, 92, 214, 0.18)
        }

        .small-muted {
            color: var(--muted);
            font-size: .88rem;
            margin-top: 6px;
            display: block
        }

        @media(max-width:720px) {
            .form-row {
                flex-direction: column
            }

            .file-badge {
                width: 42px;
                height: 42px;
                font-size: .85rem
            }

            .toolbar {
                gap: 10px
            }
        }
    </style>
    <style>
        /* === FIX TOGGLE FINAL === */
        .toggle-switch {
            width: 42px;
            height: 24px;
            border-radius: 999px;
            background: #e5e7eb;
            position: relative;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .toggle-switch.on {
            background: #10b981;
        }

        .switch-track {
            position: absolute;
            inset: 0;
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
        }

        .toggle-switch.on .switch-thumb {
            transform: translateX(18px);
        }

        /* === FIX BUTTON VISIBILITY === */
        .btn-primary {
            background: linear-gradient(180deg, var(--accent), var(--accent-600));
            color: #fff;
            border: none;
        }

        .btn-ghost {
            background: transparent;
            border: none;
            color: var(--muted);
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        /* PREVIEW */
        .btn-preview {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            box-shadow: 0 6px 16px rgba(99, 102, 241, .25);
        }

        .btn-preview:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(99, 102, 241, .35);
        }

        /* DOWNLOAD */
        .btn-download {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            box-shadow: 0 6px 16px rgba(37, 99, 235, .25);
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(37, 99, 235, .35);
        }

        /* UPDATE */
        .btn-update {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 6px 16px rgba(16, 185, 129, .25);
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(16, 185, 129, .35);
        }
    </style>
    <style>
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
        }

        .form-final {
            max-width: 140px;
            justify-content: flex-end;
        }

        .final-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 6px;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        {{-- HEADER --}}
        <div class="card-soft card mb-3">
            <div class="card-header-compact">
                <div style="flex:1">
                    <h3 class="folder-title">{{ $folder->folder_name }}</h3>
                    <div class="folder-desc">{{ $folder->description ?? 'Dokumen resmi project.' }}</div>
                    <div class="meta-small">
                        <strong>{{ $documents->count() }} dokumen</strong> &middot; Update terakhir
                        <strong>{{ $documents->isNotEmpty() ? $documents->first()->updated_at->format('d M Y') : '-' }}</strong>
                    </div>
                </div>
                <div style="text-align:right; min-width:160px;">
                    <div style="font-weight:700; color:var(--muted);">Project</div>
                    <div style="color:var(--muted)">{{ $project->project_name ?? '—' }}</div>
                </div>
            </div>
            <div style="padding:0 16px 16px;">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">{{ $folder->folder_name }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        {{-- TOOLBAR --}}
        <div class="card-soft card mb-3">
            <div class="toolbar">
                <div class="search" role="search" aria-label="Cari dokumen">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                        <path d="M21 21l-4.35-4.35" stroke="#6b7280" stroke-width="1.6" stroke-linecap="round" />
                        <circle cx="11" cy="11" r="6" stroke="#6b7280" stroke-width="1.6" fill="none" />
                    </svg>
                    <input id="searchInput" type="search" placeholder="Cari judul, nomor, revisi, atau tipe..."
                        autocomplete="off" aria-label="Cari dokumen">
                </div>

                <div class="select-wrap">
                    <select id="statusFilter" class="form-select" aria-label="Filter status">
                        <option value="">Semua Status</option>
                        <option value="FINAL">Final</option>
                        <option value="DRAFT">Draft</option>
                    </select>
                </div>

                @auth
                    <button type="button" class="btn-primary" data-action="open-document-modal" data-mode="add">Tambah
                        Dokumen</button>
                @endauth

                <a class="btn-primary-outline"
                    href="{{ route('portal.document.download.all', ['project' => $project->id, 'folder' => $folder->id]) }}">Download
                    Semua</a>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="card-soft card">
            <div class="table-wrap">
                <table class="doc-table" id="documentTable" role="table" aria-label="Daftar dokumen">
                    <thead>
                        <tr>
                            <th>Dokumen</th>
                            <th>Nomor</th>
                            <th>Revisi</th>
                            <th>Status</th>
                            <th>Update Terakhir</th>
                            <th style="width:180px;text-align:right">Aksi</th>
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
                                    $sizeDisplay =
                                        $size >= 1024 * 1024
                                            ? number_format($size / 1024 / 1024, 1) . ' MB'
                                            : number_format($size / 1024, 0) . ' KB';
                                }
                                $isFinal = $doc->is_final;
                                $extClassMap = [
                                    'pdf' => 'ext-pdf',
                                    'docx' => 'ext-docx',
                                    'doc' => 'ext-docx',
                                    'xlsx' => 'ext-xlsx',
                                    'xls' => 'ext-xlsx',
                                ];
                                $extClass = $extClassMap[$ext] ?? 'ext-unknown';
                                $previewUrl = $exists ? route('document.show', $doc->id) : '';
                            @endphp

                            <tr data-status="{{ $isFinal ? 'FINAL' : 'DRAFT' }}">
                                <td>
                                    <div class="file-cell">
                                        <div class="file-badge {{ $extClass }}" aria-hidden>{{ $extLabel }}</div>
                                        <div>
                                            <div style="font-weight:700">{{ $doc->title }}</div>
                                            <div class="file-meta">{{ $extLabel }} • {{ $sizeDisplay }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $doc->document_no ?: '-' }}</td>
                                <td>Rev. {{ $doc->revision ?: '-' }}</td>
                                <td><span
                                        class="badge-status {{ $isFinal ? 'badge-final' : 'badge-draft' }}">{{ $isFinal ? 'FINAL' : 'DRAFT' }}</span>
                                </td>
                                <td><time
                                        datetime="{{ $doc->updated_at->toDateString() }}">{{ $doc->updated_at->format('d M Y') }}</time>
                                </td>
                                <td>
                                    <div class="actions" aria-hidden="true">

                                        @if ($exists)
                                            {{-- PREVIEW --}}
                                            @if (in_array($ext, ['pdf', 'html', 'htm']))
                                                <button type="button" class="btn btn-sm btn-preview"
                                                    data-action="open-document-modal" data-mode="preview"
                                                    data-preview-url="{{ $previewUrl }}"
                                                    data-title="{{ $doc->title }}">
                                                    Preview
                                                </button>
                                            @endif

                                            {{-- DOWNLOAD --}}
                                            <a href="{{ route('portal.document.download', $doc->id) }}"
                                                class="btn btn-sm btn-download">
                                                Download
                                            </a>
                                        @else
                                            <span class="btn btn-sm btn-disabled">
                                                File hilang
                                            </span>
                                        @endif


                                        {{-- UPDATE (AUTH ONLY) --}}
                                        @auth
                                            <button type="button" class="btn btn-sm btn-update"
                                                data-action="open-document-modal" data-mode="update"
                                                data-id="{{ $doc->id }}" data-title="{{ $doc->title }}"
                                                data-document_no="{{ $doc->document_no }}"
                                                data-revision="{{ $doc->revision }}"
                                                data-is_final="{{ $doc->is_final ? 1 : 0 }}"
                                                data-description="{{ $doc->description }}"
                                                data-update-route="{{ route('document.update', $doc->id) }}">
                                                Update
                                            </button>
                                        @endauth

                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-row">Belum ada dokumen di folder ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div id="documentModal" aria-hidden="true" role="dialog" aria-labelledby="documentModalTitle">
        <div class="document-modal" role="document" aria-modal="true">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 id="documentModalTitle" class="modal-title">Dokumen</h5>
                <button type="button" class="modal-close-btn" data-action="close-modal" aria-label="Tutup">
                    &times;
                </button>
            </div>

            <!-- BODY -->
            <div class="modal-body" id="documentModalBody">
                <form id="documentForm" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <input type="hidden" name="document_project_id" value="{{ $project->id }}">
                    <input type="hidden" name="document_folder_id" value="{{ $folder->id }}">
                    <input type="hidden" name="_method" id="documentFormMethod" value="POST">

                    {{-- ROW 1 --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label for="f_document_no">Nomor Dokumen</label>
                            <input id="f_document_no" name="document_no" type="text" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="f_revision">Revisi</label>
                            <input id="f_revision" name="revision" type="text" class="form-control">
                        </div>

                        <div class="form-group form-final">
                            <input type="hidden" name="is_final" value="0">

                            <div class="final-wrapper">
                                <div class="toggle-switch" id="f_isFinalSwitch" role="switch" tabindex="0"
                                    aria-checked="false" aria-labelledby="f_isFinalLabel">

                                    <input id="f_is_final" name="is_final" type="checkbox" value="1" hidden>

                                    <span class="switch-track">
                                        <span class="switch-thumb"></span>
                                    </span>
                                </div>

                                <label id="f_isFinalLabel" for="f_is_final" class="small-muted">
                                    Final
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- FILE --}}
                    <div class="form-group">
                        <label for="f_file">
                            File
                            <span class="small-muted">
                                (.pdf,.docx,.xlsx,.dwg,.jpg,.png,.zip)
                            </span>
                            <span class="text-danger">*</span>
                        </label>

                        <input id="f_file" name="file" type="file" class="form-control"
                            accept=".pdf,.doc,.docx,.xls,.xlsx,.dwg,.jpg,.jpeg,.png,.zip">

                        <div id="f_fileHelp" class="small-muted">
                            Untuk Add wajib pilih file. Untuk Update wajib mengganti file lama.
                        </div>

                        <div class="text-danger small" id="err_file" style="display:none;"></div>
                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="form-group">
                        <label for="f_description">Keterangan (opsional)</label>
                        <textarea id="f_description" name="description" class="form-control" rows="3"></textarea>
                    </div>

                    {{-- ACTION BUTTON --}}
                    <div class="modal-actions">
                        <button type="button" class="btn btn-ghost" data-action="close-modal">
                            Batal
                        </button>

                        <button type="submit" id="f_btnSave" class="btn btn-primary">
                            <span id="f_btnText">Simpan</span>

                            <svg id="f_btnSpinner" style="display:none;margin-left:8px" width="14" height="14"
                                viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" stroke="rgba(255,255,255,0.45)"
                                    stroke-width="3"></circle>
                                <path d="M22 12a10 10 0 0 0-10-10" stroke="#fff" stroke-width="3"
                                    stroke-linecap="round"></path>
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

            /* =====================================================
               MODAL CONTROL
            ===================================================== */
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

            /* =====================================================
               TOGGLE FINAL SWITCH
            ===================================================== */
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

            /* =====================================================
               FILE HELPER
            ===================================================== */
            function initFileHelper() {
                const fileInput = $('#f_file');
                const help = $('#f_fileHelp');
                if (!fileInput || !help) return;

                fileInput.addEventListener('change', function() {
                    if (fileInput.files.length) {
                        const f = fileInput.files[0];
                        help.textContent = f.name + ' • ' + Math.round(f.size / 1024) + ' KB';
                    } else {
                        help.textContent = 'Pilih file.';
                    }
                });
            }

            /* =====================================================
               SUBMIT HANDLER (NO TITLE VALIDATION)
            ===================================================== */
            function initSubmitHandler() {
                const form = $('#documentForm');
                if (!form) return;

                form.addEventListener('submit', function(e) {

                    const fileInput = $('#f_file');
                    const submitBtn = $('#f_btnSave');
                    const btnText = $('#f_btnText');
                    const spinner = $('#f_btnSpinner');

                    // File wajib
                    if (!fileInput.files.length) {
                        e.preventDefault();
                        alert('File wajib diupload.');
                        return;
                    }

                    // Anti double submit
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

            /* =====================================================
               OPEN ADD
            ===================================================== */
            function openAdd() {
                modalTitle.textContent = 'Tambah Dokumen Baru';
                modalBody.innerHTML = originalFormHTML;

                const form = $('#documentForm');

                form.action =
                    "{{ route('document.store', ['project' => $project->id, 'folder' => $folder->id]) }}";

                $('#documentFormMethod').value = 'POST';

                form.reset();
                $('#f_fileHelp').textContent = 'Pilih file untuk diupload.';

                initToggle();
                initFileHelper();
                initSubmitHandler();

                showModal();
            }

            /* =====================================================
               OPEN UPDATE
            ===================================================== */
            function openUpdate(data) {

                modalTitle.textContent = 'Update Dokumen';
                modalBody.innerHTML = originalFormHTML;

                const form = $('#documentForm');

                form.action = data.updateRoute;
                $('#documentFormMethod').value = 'PUT';

                // Tidak ada title lagi
                $('#f_document_no').value = data.document_no || '';
                $('#f_revision').value = data.revision || '';
                $('#f_description').value = data.description || '';
                $('#f_is_final').checked = (data.is_final === '1');

                $('#f_fileHelp').textContent =
                    'Pilih file pengganti untuk diupload.';

                initToggle();
                initFileHelper();
                initSubmitHandler();

                showModal();
            }

            /* =====================================================
               OPEN PREVIEW
            ===================================================== */
            function openPreview(url, title) {
                modalTitle.textContent = title || 'Preview';

                modalBody.innerHTML = `
            <div style="height:72vh;border-radius:8px;overflow:hidden">
                <iframe src="${url}" style="width:100%;height:100%;border:0"></iframe>
            </div>
        `;

                showModal();
            }

            /* =====================================================
               CLICK DELEGATION
            ===================================================== */
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
                    openPreview(
                        previewBtn.dataset.previewUrl,
                        previewBtn.dataset.title
                    );
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

                if (e.target.closest('[data-action="close-modal"]') ||
                    e.target === modalRoot) {
                    hideModal();
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' &&
                    modalRoot.classList.contains('show')) {
                    hideModal();
                }
            });

        });
    </script>
@endpush
