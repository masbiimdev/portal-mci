@extends('layouts.home')

@section('title', 'Projects — Transmittal Portal')

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

        /* ========== FILTERS & STATS ========== */
        .filter-stats {
            display: flex;
            gap: 16px;
            align-items: center;
            font-size: 13px;
            color: var(--muted);
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
        .project-grid {
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

        /* ========== PROJECT CARD ========== */
        .project-card {
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

        .project-card::before {
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

        .project-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(37, 99, 235, 0.2);
        }

        .project-card:hover::before {
            transform: scaleX(1);
        }

        /* ========== CARD HEADER ========== */
        .project-header {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .project-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--accent-soft), #e0e7ff);
            border-radius: 12px;
            font-size: 20px;
        }

        .project-info {
            flex: 1;
            min-width: 0;
        }

        .project-info h4 {
            margin: 0 0 4px 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .project-code {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ========== CARD META ========== */
        .project-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
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

        .project-card:hover .meta-box {
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
        .project-footer {
            margin-top: auto;
            padding-top: 14px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--muted);
        }

        .footer-date {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .footer-date i {
            font-size: 12px;
        }

        .view-project {
            color: var(--accent);
            font-weight: 700;
            display: flex;
            gap: 4px;
            align-items: center;
            transition: all 0.2s ease;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .project-card:hover .view-project {
            background: var(--accent-soft);
            transform: translateX(4px);
        }

        .view-project i {
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
            .project-grid {
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

            .project-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 16px;
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

            .project-grid {
                grid-template-columns: 1fr;
            }

            .page-actions {
                width: 100%;
            }

            .search-wrapper {
                width: 100%;
            }

            .filter-stats {
                flex-wrap: wrap;
                font-size: 12px;
            }
        }

        /* ========== ACCESSIBILITY ========== */
        .project-card:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* ========== ANIMATIONS ========== */
        @media (prefers-reduced-motion: reduce) {

            .project-card,
            .search-wrapper {
                transition: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        <!-- HEADER -->
        <div class="page-header">
            <div class="header-main">
                <h2>📁 Transmittal Document</h2>
                <small>
                    Kelola folder dan dokumen resmi per project dengan mudah<br>
                </small>
            </div>

            {{-- <div class="header-meta">
                <div class="header-meta-label">📊 Statistik</div>
                <div class="header-meta-value">{{ $projects->count() }} Project</div>
                <div class="header-meta-value">{{ $projects->sum('folders_count') }} Folder</div>
                <div class="header-meta-value">{{ $projects->sum('documents_count') }} Dokumen</div>
                
            </div> --}}
        </div>

        <!-- STATS -->
        @if ($projects->count() > 0)
            <div class="filter-stats" style="margin-bottom: 20px;">
                <span class="stat-item">
                    📊 Total Project:
                    <span class="stat-badge" id="total-projects">{{ $projects->count() }}</span>
                </span>
                <span class="stat-item">
                    📂 Total Folder:
                    <span class="stat-badge" id="total-folders">{{ $projects->sum('folders_count') }}</span>
                </span>
                <span class="stat-item">
                    📄 Total Dokumen:
                    <span class="stat-badge" id="total-documents">{{ $projects->sum('documents_count') }}</span>
                </span>
            </div>
        @endif

        <!-- GRID -->
        <div id="project-grid" class="project-grid">

            @forelse ($projects as $project)
                <a href="{{ route('document.folder', $project->id) }}" class="project-card"
                    data-title="{{ strtolower($project->project_name) }}"
                    data-code="{{ strtolower($project->project_number) }}" role="link" tabindex="0">

                    <div class="project-header">
                        <div class="project-icon">📋</div>
                        <div class="project-info">
                            <h4>{{ $project->project_name }}</h4>
                            <div class="project-code">{{ $project->project_number }}</div>
                        </div>
                    </div>

                    <div class="project-meta">
                        <div class="meta-box">
                            <strong>{{ $project->folders_count }}</strong>
                            <span>Folders</span>
                        </div>
                        <div class="meta-box">
                            <strong>{{ $project->documents_count }}</strong>
                            <span>Documents</span>
                        </div>
                    </div>

                    <div class="project-footer">
                        <span class="footer-date">
                            <i class="bi bi-calendar3"></i>
                            {{ optional($project->updated_at)->format('d M Y') ?? '—' }}
                        </span>
                        <span class="view-project">
                            Open <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">📂</div>
                    <h3>Belum ada project</h3>
                    <p>
                        Project belum dibuat. Silakan buat project terlebih dahulu untuk mulai mengelola
                        folder dan dokumen transmittal.
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

            const input = document.getElementById('project-search');
            const grid = document.getElementById('project-grid');
            const noResults = document.getElementById('no-results');

            if (!input) return;

            const cards = Array.from(document.querySelectorAll('.project-card'));
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
