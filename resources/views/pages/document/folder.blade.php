@extends('layouts.home')
@section('title', 'Folder — Transmittal Portal')

@push('css')
    <style>
        :root {
            --primary: #0f172a;
            --accent: linear-gradient(90deg, #2563eb, #7c3aed);
            --bg: #f8fafc;
            --card: #ffffff;
            --muted: #64748b;
            --border: #e6eefb;
            --radius: 14px;
            --shadow: 0 8px 24px rgba(15, 23, 42, .06);
        }

        body {
            background: var(--bg);
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
            color: var(--primary);
        }

        .container-main {
            max-width: 1280px;
            margin: 32px auto;
            padding: 24px;
        }

        /* HEADER */
        .page-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
        }

        .page-header-left h3 {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 4px 0;
        }

        .page-header-left small {
            color: var(--muted);
            font-size: 13px;
            display: block;
        }

        .page-actions {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 16px;
        }

        .search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid var(--border);
            padding: 8px 12px;
            border-radius: 999px;
            min-width: 240px;
        }

        .search input {
            border: 0;
            outline: none;
            width: 220px;
            font-size: 14px;
            color: var(--primary);
        }

        /* GRID FOLDER */
        .folder-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 18px;
        }

        /* FOLDER CARD */
        .folder-card {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.9), var(--card));
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
            display: flex;
            flex-direction: column;
            min-height: 150px;
            text-decoration: none;
            color: inherit;
            box-shadow: var(--shadow);
        }

        .folder-card:hover {
            transform: translateY(-6px);
            border-color: rgba(37, 99, 235, .18);
            box-shadow: 0 18px 40px rgba(15, 23, 42, .12);
        }

        /* HEADER CARD */
        .folder-header {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-bottom: 12px;
        }

        .folder-icon {
            font-size: 28px;
            color: #2563eb;
        }

        .folder-title {
            font-weight: 700;
            font-size: 16px;
        }

        .folder-code {
            font-size: 12px;
            color: var(--muted);
            margin-top: 4px;
        }

        /* STATS */
        .folder-stats {
            display: flex;
            gap: 12px;
            margin-bottom: 14px;
        }

        .meta-box {
            background: rgba(15, 23, 42, 0.03);
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .meta-box strong {
            display: block;
            font-size: 16px;
            font-weight: 800;
        }

        .meta-box span {
            font-size: 11px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        /* LAST UPDATE */
        .last-update {
            margin-bottom: 14px;
            font-size: 12px;
            color: var(--muted);
        }

        /* FOOTER */
        .folder-footer {
            margin-top: auto;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            font-size: 13px;
            color: var(--muted);
        }

        .view-link {
            color: #2563eb;
            font-weight: 700;
            display: inline-flex;
            gap: 6px;
            align-items: center;
            text-decoration: none;
            cursor: pointer;
            transition: .15s ease;
        }

        .view-link:hover {
            transform: translateX(4px);
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 40px 18px;
            color: var(--muted);
            background: linear-gradient(0deg, rgba(255, 255, 255, 0.6), transparent);
            border-radius: 12px;
            border: 1px dashed var(--border);
            display: none;
        }

        @media (max-width:480px) {
            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .search input {
                width: 120px;
            }

            .folder-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-main">

        <!-- HEADER -->
        <div class="page-header">
            <div class="page-header-left">
                <h3>Project: {{ $project->project_name ?? 'Unnamed Project' }}</h3>
                <small>Folder dokumen resmi dalam project</small>
            </div>

            <div class="page-actions">
                <div class="search">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <input id="folder-search" type="search" placeholder="Cari folder atau kode..." />
                </div>
            </div>
        </div>

        <!-- FOLDER GRID -->
        <div id="folder-grid" class="folder-grid">
            @forelse($folders as $folder)
                <a href="{{ route('document.list', ['project' => $project->id, 'folder' => $folder->id]) }}" class="folder-card"
                    data-title="{{ strtolower($folder->folder_name) }}" data-code="{{ strtolower($folder->folder_code) }}">

                    <div class="folder-header">
                        <div class="folder-icon"><i class="bi bi-folder2-open"></i></div>
                        <div>
                            <div class="folder-title">{{ $folder->folder_name }}</div>
                            <div class="folder-code">{{ $folder->folder_code }}</div>
                        </div>
                    </div>

                    <div class="folder-stats">
                        <div class="meta-box">
                            <strong>{{ $folder->documents_count ?? 0 }}</strong>
                            <span>Files</span>
                        </div>
                    </div>

                    <div class="last-update">
                        {{ optional($folder->updated_at)->format('d F Y • H:i') ?? '-' }}
                    </div>

                    <div class="folder-footer">
                        <span class="view-link">Open Folder →</span>
                    </div>

                </a>
            @empty
                <div class="empty-state">
                    Tidak ada folder untuk project ini.
                </div>
            @endforelse


        </div>

        <div class="empty-state" id="empty-search">Tidak ada folder yang cocok dengan pencarian.</div>

    </div>
@endsection

@push('script')
    <script>
        (function() {
            const input = document.getElementById('folder-search');
            const grid = document.getElementById('folder-grid');
            const cards = Array.from(grid.querySelectorAll('.folder-card'));
            const empty = document.getElementById('empty-search');

            function normalize(s) {
                return (s || '').toString().trim().toLowerCase();
            }

            input.addEventListener('input', function() {
                const q = normalize(this.value);
                let visible = 0;
                cards.forEach(card => {
                    const title = normalize(card.dataset.title);
                    const code = normalize(card.dataset.code);
                    const match = q === '' || title.includes(q) || code.includes(q);
                    card.style.display = match ? '' : 'none';
                    if (match) visible++;
                });
                empty.style.display = visible === 0 ? 'block' : 'none';
            });
        })();
    </script>
@endpush
