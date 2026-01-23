@extends('layouts.home')

@section('title', 'Projects — Transmittal Portal')

@push('css')
<style>
    :root{
        --primary: #0f172a;
        --accent: linear-gradient(90deg,#2563eb,#7c3aed);
        --bg: #f8fafc;
        --card: #ffffff;
        --muted: #64748b;
        --border: #e6eefb;
        --radius: 14px;
        --shadow: 0 8px 24px rgba(15,23,42,.06);
    }

    body { background: var(--bg); font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; color: var(--primary); }
    .container-main { max-width: 1280px; margin: 32px auto; padding: 24px; }

    .page-header { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:12px; margin-bottom:20px; }
    .page-header-left h2 { font-size:22px; font-weight:700; margin:0 0 4px 0; }
    .page-header-left small { color:var(--muted); font-size:13px; display:block; }

    .page-actions { display:flex; gap:12px; align-items:center; }
    .search {
        display:flex; align-items:center; gap:8px;
        background:#fff; border:1px solid var(--border); padding:8px 12px; border-radius:999px;
        min-width:240px;
    }
    .search input { border:0; outline:none; width:220px; font-size:14px; color:var(--primary); }
    .btn-primary {
        background: var(--accent);
        color: #fff;
        padding:9px 14px;
        border-radius:10px;
        font-weight:600;
        display:inline-flex;
        gap:8px;
        align-items:center;
        text-decoration:none;
        border: none;
    }

    .project-grid { display:grid; grid-template-columns: repeat(auto-fill, minmax(300px,1fr)); gap:18px; margin-top:6px; }

    .project-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.9), var(--card));
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding:18px;
        transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        display:flex; flex-direction:column; min-height:170px; text-decoration:none; color:inherit;
        box-shadow: var(--shadow);
    }
    .project-card:hover {
        transform: translateY(-6px);
        border-color: rgba(37,99,235,.18);
        box-shadow: 0 18px 40px rgba(15,23,42,.12);
    }

    .project-top { display:flex; justify-content:space-between; gap:12px; align-items:flex-start; margin-bottom:12px; }
    .project-info h4 { margin:0; font-size:16px; font-weight:700; letter-spacing: -0.2px; }
    .project-code { font-size:12px; color:var(--muted); margin-top:6px; }

    .status {
        font-size:12px; font-weight:700; padding:6px 10px; border-radius:999px; display:inline-block;
        text-transform:capitalize;
    }
    .status--active { background: linear-gradient(90deg,#dcfce7,#bbf7d0); color:#065f46; }
    .status--pending { background: linear-gradient(90deg,#fff7ed,#ffedd5); color:#92400e; }
    .status--archived { background: linear-gradient(90deg,#f1f5f9,#e2e8f0); color:#334155; }

    .project-meta { display:grid; grid-template-columns: repeat(2,1fr); gap:12px; margin-bottom:14px; }
    .meta-box {
        background: rgba(15,23,42,0.03);
        border-radius:10px;
        padding:10px;
        text-align:center;
        display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px;
    }
    .meta-box strong { display:block; font-size:18px; font-weight:800; }
    .meta-box span { font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:.4px; }

    .project-footer { margin-top:auto; padding-top:12px; border-top: 1px dashed var(--border); display:flex; justify-content:space-between; align-items:center; font-size:13px; color:var(--muted); gap:8px; }
    .view-project { color: #2563eb; font-weight:700; display:inline-flex; gap:6px; align-items:center; text-decoration:none; }
    .view-project:hover { transform: translateX(4px); transition: transform .15s ease; }

    .empty-state { text-align:center; padding:40px 18px; color:var(--muted); background:linear-gradient(0deg, rgba(255,255,255,0.6), transparent); border-radius:12px; border:1px dashed var(--border); }

    @media (max-width:480px){
        .page-header { flex-direction:column; align-items:stretch; }
        .search input { width:120px; }
        .project-meta { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@section('content')
<div class="container-main">

    <!-- HEADER -->
    <div class="page-header">
        <div class="page-header-left">
            <h2>Project Transmittal Portal</h2>
            <small>Portal distribusi dokumen resmi per project</small>
        </div>

        <div class="page-actions">
            <div class="search" role="search" aria-label="Search projects">
                <i class="bi bi-search" aria-hidden="true"></i>
                <input id="project-search" type="search" placeholder="Cari project atau kode..." />
            </div>

            <!-- Keep New Project button for future use; you can hide it if not needed -->
            {{-- <a href="#" class="btn-primary" title="Buat Project Baru">
                <i class="bi bi-plus-lg" aria-hidden="true"></i>
                New Project
            </a> --}}
        </div>
    </div>

    @php
        /**
         * For now: use dummy data for UI preview.
         * When you later provide real $projects from controller,
         * the view will use that instead automatically.
         *
         * Expected project object properties (for future DB data):
         * - id
         * - name
         * - code
         * - status    ('active'|'pending'|'archived')
         * - folders_count
         * - documents_count
         * - updated_at (DateTime / Carbon)
         *
         * Implementation detail: if a $projects variable is already set
         * (from controller), we won't override it.
         */
        if (!isset($projects)) {
            $projects = [
                (object)[
                    'id' => 1,
                    'name' => 'Valve Manufacturing',
                    'code' => 'PRJ-VAL-2026-001',
                    'status' => 'active',
                    'folders_count' => 6,
                    'documents_count' => 42,
                    'updated_at' => \Carbon\Carbon::parse('2026-01-20'),
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Pipeline Expansion',
                    'code' => 'PRJ-PIP-2025-014',
                    'status' => 'pending',
                    'folders_count' => 4,
                    'documents_count' => 18,
                    'updated_at' => \Carbon\Carbon::parse('2025-12-05'),
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Refinery Upgrade',
                    'code' => 'PRJ-REF-2024-092',
                    'status' => 'archived',
                    'folders_count' => 12,
                    'documents_count' => 128,
                    'updated_at' => \Carbon\Carbon::parse('2024-08-11'),
                ],
            ];
        }
    @endphp

    <!-- PROJECT GRID -->
    <div id="project-grid" class="project-grid">

        @forelse($projects as $project)
            @php
                // Normalize status -> css class (compatible with PHP 7.x)
                $status = isset($project->status) ? $project->status : 'active';
                $statusMap = [
                    'active' => 'status--active',
                    'pending' => 'status--pending',
                    'archived' => 'status--archived',
                ];
                $statusClass = isset($statusMap[$status]) ? $statusMap[$status] : 'status--active';

                // Prepare strings for data- attributes (avoid using Str facade in view)
                $dataTitle = isset($project->name) ? strtolower($project->name) : '';
                $dataCode = isset($project->code) ? strtolower($project->code) : '';
            @endphp

            <a href="#" {{-- replace '#' with route('projects.show', $project->id) later --}}
               class="project-card"
               data-title="{{ $dataTitle }}"
               data-code="{{ $dataCode }}"
               aria-label="Open {{ $project->name ?? 'project' }}">
                <div class="project-top">
                    <div class="project-info">
                        <h4>{{ $project->name }}</h4>
                        <div class="project-code">{{ $project->code }}</div>
                    </div>

                    <span class="status {{ $statusClass }}">{{ $status }}</span>
                </div>

                <div class="project-meta">
                    <div class="meta-box" title="Folders">
                        <i class="bi bi-folder2-open" aria-hidden="true"></i>
                        <strong>{{ $project->folders_count ?? 0 }}</strong>
                        <span>Folders</span>
                    </div>
                    <div class="meta-box" title="Documents">
                        <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
                        <strong>{{ $project->documents_count ?? 0 }}</strong>
                        <span>Documents</span>
                    </div>
                </div>

                <div class="project-footer">
                    <span>
                        <i class="bi bi-clock" aria-hidden="true"></i>
                        Last Update : {{ isset($project->updated_at) ? \Carbon\Carbon::parse($project->updated_at)->format('d M Y') : '-' }}
                    </span>
                    <span class="view-project">
                        Open <i class="bi bi-arrow-right-short" aria-hidden="true"></i>
                    </span>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <h3>Tidak ada project</h3>
                <p>Belum ada project yang dibuat. Klik "New Project" untuk memulai.</p>
            </div>
        @endforelse

    </div>

</div>
@endsection

@push('scripts')
<script>
    // Simple client-side search by title or code (progressive enhancement only)
    (function(){
        const input = document.getElementById('project-search');
        if (!input) return;
        const grid = document.getElementById('project-grid');
        const cards = Array.from(grid.querySelectorAll('.project-card'));

        function normalize(s){ return (s || '').toString().trim().toLowerCase(); }

        input.addEventListener('input', function(){
            const q = normalize(this.value);
            let visible = 0;
            cards.forEach(card => {
                const title = normalize(card.dataset.title);
                const code = normalize(card.dataset.code);
                const match = q === '' || title.includes(q) || code.includes(q);
                card.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            // optional: show empty state when no matches
            const existingEmpty = document.querySelector('.empty-search-state');
            if (visible === 0) {
                if (!existingEmpty) {
                    const el = document.createElement('div');
                    el.className = 'empty-state empty-search-state';
                    el.innerHTML = '<h3>No results</h3><p>Tidak ada project yang cocok dengan pencarian.</p>';
                    grid.parentNode.insertBefore(el, grid.nextSibling);
                }
            } else {
                if (existingEmpty) existingEmpty.remove();
            }
        });
    })();
</script>
@endpush