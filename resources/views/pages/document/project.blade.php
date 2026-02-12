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

    body {
        background: var(--bg);
        font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial;
        color: var(--primary);
    }

    .container-main {
        max-width: 1280px;
        margin: 32px auto;
        padding: 24px;
    }

    /* HEADER */
    .page-header {
        display:flex;
        flex-wrap:wrap;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        margin-bottom:20px;
    }

    .page-header-left h2 {
        font-size:22px;
        font-weight:700;
        margin:0 0 4px 0;
    }

    .page-header-left small {
        color:var(--muted);
        font-size:13px;
    }

    .page-actions {
        display:flex;
        gap:12px;
        align-items:center;
    }

    .search {
        display:flex;
        align-items:center;
        gap:8px;
        background:#fff;
        border:1px solid var(--border);
        padding:8px 12px;
        border-radius:999px;
        min-width:240px;
    }

    .search input {
        border:0;
        outline:none;
        width:220px;
        font-size:14px;
    }

    /* GRID */
    .project-grid {
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(300px,1fr));
        gap:18px;
    }

    /* CARD */
    .project-card {
        background: linear-gradient(180deg, rgba(255,255,255,0.9), var(--card));
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding:18px;
        display:flex;
        flex-direction:column;
        min-height:170px;
        text-decoration:none;
        color:inherit;
        box-shadow: var(--shadow);
        transition:.18s ease;
    }

    .project-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(15,23,42,.12);
        border-color: rgba(37,99,235,.18);
    }

    .project-top {
        display:flex;
        justify-content:space-between;
        gap:12px;
        margin-bottom:12px;
    }

    .project-info h4 {
        margin:0;
        font-size:16px;
        font-weight:700;
    }

    .project-code {
        font-size:12px;
        color:var(--muted);
        margin-top:6px;
    }

    .project-meta {
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:12px;
        margin-bottom:14px;
    }

    .meta-box {
        background: rgba(15,23,42,0.03);
        border-radius:10px;
        padding:10px;
        text-align:center;
    }

    .meta-box strong {
        font-size:18px;
        font-weight:800;
        display:block;
    }

    .meta-box span {
        font-size:11px;
        color:var(--muted);
        text-transform:uppercase;
    }

    .project-footer {
        margin-top:auto;
        padding-top:12px;
        border-top:1px dashed var(--border);
        display:flex;
        justify-content:space-between;
        font-size:13px;
        color:var(--muted);
    }

    .view-project {
        color:#2563eb;
        font-weight:700;
        display:flex;
        gap:6px;
        align-items:center;
    }

    .view-project:hover {
        transform: translateX(4px);
    }

    /* EMPTY STATE */
    .empty-state {
        grid-column: 1 / -1;
        min-height: 260px;
        display:flex;
        flex-direction:column;
        align-items:center;
        justify-content:center;
        text-align:center;
        gap:10px;
        border:1px dashed var(--border);
        border-radius:14px;
        background:linear-gradient(0deg, rgba(255,255,255,.6), transparent);
        color:var(--muted);
    }

    .empty-state i {
        font-size:42px;
        color:#94a3b8;
    }

    .empty-state h3 {
        margin:0;
        font-size:18px;
        font-weight:700;
        color:var(--primary);
    }

    .empty-state p {
        margin:0;
        font-size:13px;
        max-width:360px;
    }

    @media (max-width:480px){
        .page-header {
            flex-direction:column;
            align-items:stretch;
        }
        .search input {
            width:120px;
        }
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
            <div class="search">
                <i class="bi bi-search"></i>
                <input id="project-search" type="search" placeholder="Cari project atau kode..." />
            </div>
        </div>
    </div>

    <!-- GRID -->
    <div id="project-grid" class="project-grid">

        @forelse ($projects as $project)
            <a href="{{ route('document.folder', $project->id) }}"
               class="project-card"
               data-title="{{ strtolower($project->project_name) }}"
               data-code="{{ strtolower($project->project_number) }}">

                <div class="project-top">
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
                    <span>
                        Last update:
                        {{ optional($project->updated_at)->format('d M Y') ?? '-' }}
                    </span>
                    <span class="view-project">
                        Open <i class="bi bi-arrow-right-short"></i>
                    </span>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <i class="bi bi-folder-x"></i>
                <h3>Belum ada project</h3>
                <p>
                    Project belum dibuat.
                    Silakan buat project terlebih dahulu untuk mulai mengelola folder dan dokumen.
                </p>
            </div>
        @endforelse

    </div>

</div>
@endsection

@push('scripts')
<script>
(function(){
    const input = document.getElementById('project-search');
    if (!input) return;

    const cards = document.querySelectorAll('.project-card');

    function normalize(v){
        return (v || '').toLowerCase().trim();
    }

    input.addEventListener('input', function(){
        const q = normalize(this.value);
        cards.forEach(card => {
            const title = normalize(card.dataset.title);
            const code  = normalize(card.dataset.code);
            card.style.display =
                q === '' || title.includes(q) || code.includes(q)
                ? ''
                : 'none';
        });
    });
})();
</script>
@endpush
