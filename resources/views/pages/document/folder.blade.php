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

            {{-- <div class="page-actions">
                <div class="search-wrapper">
                    <i class="bi bi-search"></i>
                    <input id="folder-search" type="search" placeholder="Cari folder atau kode..." aria-label="Cari folder" />
                </div>
            </div> --}}
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
@endsection

@push('scripts')
    <script>
        (function() {
            'use strict';

            const input = document.getElementById('folder-search');
            const grid = document.getElementById('folder-grid');
            const noResults = document.getElementById('no-results');

            if (!input) return;

            const cards = Array.from(document.querySelectorAll('.folder-card'));
            const emptyState = document.querySelector('.empty-state');

            function normalize(v) {
                return (v || '').toLowerCase().trim();
            }

            function updateDisplay() {
                const query = normalize(input.value);
                let visibleCount = 0;

                cards.forEach(card => {
                    const title = normalize(card.dataset.title);
                    const code = normalize(card.dataset.code);
                    const matches = query === '' || title.includes(query) || code.includes(query);

                    if (matches) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide empty state and no results
                if (emptyState) {
                    emptyState.style.display = cards.length === 0 ? '' : 'none';
                }

                if (noResults) {
                    noResults.style.display = (cards.length > 0 && visibleCount === 0) ? '' : 'none';
                }
            }

            // Event listeners
            input.addEventListener('input', updateDisplay);
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    input.value = '';
                    updateDisplay();
                }
            });

            // Initial display
            updateDisplay();

            // Focus management
            cards.forEach(card => {
                card.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        card.click();
                    }
                });
            });
        })();
    </script>
@endpush
