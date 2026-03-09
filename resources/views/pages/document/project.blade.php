@extends('layouts.home')

@section('title', 'Projects — Transmittal Portal')

@push('css')
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
            --bg: #f8fafc;
            --card: #ffffff;
            --muted: #64748b;
            --muted-light: #94a3b8;
            --border: #e2e8f0;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(15, 23, 42, 0.05), 0 2px 4px -2px rgba(15, 23, 42, 0.05);
            --shadow-lg: 0 15px 35px -5px rgba(37, 99, 235, 0.08);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

        /* Abstract glowing blobs inside header */
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
        }

        .header-content h2 {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-content p {
            color: #cbd5e1;
            font-size: 1.05rem;
            margin: 0;
            max-width: 500px;
            line-height: 1.5;
        }

        /* ========== SEARCH BAR IN HEADER ========== */
        .header-actions {
            position: relative;
            z-index: 2;
            flex-grow: 1;
            max-width: 400px;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 12px 20px;
            border-radius: 999px;
            backdrop-filter: blur(10px);
            transition: var(--transition);
            width: 100%;
        }

        .search-wrapper:focus-within {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.3);
        }

        .search-wrapper i {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.25rem;
        }

        .search-wrapper input {
            border: none;
            outline: none;
            background: transparent;
            color: white;
            width: 100%;
            font-size: 0.95rem;
            font-family: inherit;
        }

        .search-wrapper input::placeholder {
            color: rgba(255, 255, 255, 0.6);
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

        /* ========== PROJECT GRID ========== */
        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
            gap: 1.5rem;
        }

        /* ========== PROJECT CARD ========== */
        .project-card {
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
            outline: none;
        }

        /* Top Accent Line */
        .project-card::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), #60a5fa);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
            opacity: 0;
            transition: var(--transition);
        }

        .project-card:hover,
        .project-card:focus-visible {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
            border-color: #bfdbfe;
        }

        .project-card:hover::before,
        .project-card:focus-visible::before {
            opacity: 1;
        }

        /* Header Area (Avatar + Title) */
        .project-header {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }

        .project-avatar {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--accent-soft), #e0e7ff);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--accent);
            text-transform: uppercase;
        }

        .project-info {
            flex: 1;
            min-width: 0;
        }

        .project-info h4 {
            margin: 0 0 0.25rem 0;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .project-code {
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

        /* Meta Data (Folders & Docs) */
        .project-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
            background: #f8fafc;
            padding: 1rem;
            border-radius: var(--radius-md);
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

        /* Footer Area */
        .project-footer {
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

        .project-card:hover .view-link {
            gap: 0.5rem;
            /* Animate arrow moving right */
        }

        /* ========== EMPTY & NO RESULTS ========== */
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

        .empty-state p {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
            max-width: 400px;
            line-height: 1.5;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .page-header {
                padding: 2rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
                max-width: 100%;
            }

            .project-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        <div class="page-header">
            <div class="header-content">
                <h2>📁 Transmittal Documents</h2>
                <p>Kelola struktur folder dan manajemen dokumen resmi untuk setiap proyek dengan mudah dan aman.</p>
            </div>

            <div class="header-actions">
                <div class="search-wrapper">
                    <i class="bx bx-search"></i>
                    <input type="text" id="project-search" placeholder="Cari nama project atau kode..." autocomplete="off">
                </div>
            </div>
        </div>

        @if ($projects->count() > 0)
            <div class="filter-stats">
                <div class="stat-badge">
                    Total Project <span>{{ $projects->count() }}</span>
                </div>
                <div class="stat-badge">
                    Total Folder <span>{{ $projects->sum('folders_count') }}</span>
                </div>
                <div class="stat-badge">
                    Total Dokumen <span>{{ $projects->sum('documents_count') }}</span>
                </div>
            </div>
        @endif

        <div id="project-grid" class="project-grid">

            @forelse ($projects as $project)
                @php
                    // Get first 1 or 2 letters of project name for avatar
                    $initials = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $project->project_name), 0, 2));
                    if (empty($initials)) {
                        $initials = 'PR';
                    }
                @endphp

                <a href="{{ route('document.folder', $project->id) }}" class="project-card"
                    data-title="{{ strtolower($project->project_name) }}"
                    data-code="{{ strtolower($project->project_number) }}">

                    <div class="project-header">
                        <div class="project-avatar">{{ $initials }}</div>
                        <div class="project-info">
                            <h4 title="{{ $project->project_name }}">{{ $project->project_name }}</h4>
                            <div class="project-code">{{ $project->project_number }}</div>
                        </div>
                    </div>

                    <div class="project-meta">
                        <div class="meta-item">
                            <span>Folders</span>
                            <strong>{{ $project->folders_count }}</strong>
                        </div>
                        <div class="meta-item">
                            <span>Documents</span>
                            <strong>{{ $project->documents_count }}</strong>
                        </div>
                    </div>

                    <div class="project-footer">
                        <div class="footer-date">
                            <i class="bx bx-calendar"></i>
                            Updated {{ optional($project->updated_at)->format('d M Y') ?? '—' }}
                        </div>
                        <div class="view-link">
                            Buka <i class="bx bx-right-arrow-alt"></i>
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <div class="empty-icon">🗂️</div>
                    <h3>Belum ada Project</h3>
                    <p>Sistem saat ini belum memiliki data project. Silakan hubungi Administrator untuk membuat project baru
                        dan memulai manajemen dokumen.</p>
                </div>
            @endforelse

            <div id="no-results" class="empty-state" style="display: none;">
                <div class="empty-icon">🔍</div>
                <h3>Hasil tidak ditemukan</h3>
                <p>Tidak ada proyek yang cocok dengan kata kunci pencarian Anda. Coba gunakan kata kunci lain.</p>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('project-search');
            const noResults = document.getElementById('no-results');

            if (!input) return;

            const cards = Array.from(document.querySelectorAll('.project-card'));
            const emptyState = document.querySelector('.empty-state:not(#no-results)');

            function updateDisplay() {
                const query = input.value.toLowerCase().trim();
                let visibleCount = 0;

                cards.forEach(card => {
                    const title = card.dataset.title;
                    const code = card.dataset.code;
                    const isMatch = query === '' || title.includes(query) || code.includes(query);

                    if (isMatch) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Hide empty state if doing search
                if (emptyState) {
                    emptyState.style.display = (cards.length === 0) ? '' : 'none';
                }

                // Handle no results message
                if (noResults) {
                    noResults.style.display = (cards.length > 0 && visibleCount === 0) ? '' : 'none';
                }
            }

            input.addEventListener('input', updateDisplay);

            // Clear on Escape key
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    input.value = '';
                    updateDisplay();
                }
            });
        });
    </script>
@endpush
