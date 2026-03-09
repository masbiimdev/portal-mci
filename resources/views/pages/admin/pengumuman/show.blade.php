@extends('layouts.home')

@section('title', 'Detail Pengumuman | MCI Command Center')

@push('css')
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --brand: #2563eb;
            --brand-hover: #1d4ed8;
            --brand-soft: #eff6ff;
            --surface: #ffffff;
            --bg-body: #f8fafc;
            --text-heading: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --border-light: rgba(226, 232, 240, 0.8);
            --radius-xl: 24px;
            --radius-lg: 16px;
            --radius-md: 12px;
            --shadow-soft: 0 10px 40px -10px rgba(15, 23, 42, 0.06);
            --shadow-hover: 0 20px 40px -10px rgba(37, 99, 235, 0.1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-body);
            background-image:
                radial-gradient(at 100% 0%, rgba(37, 99, 235, 0.04) 0px, transparent 40%),
                radial-gradient(at 0% 100%, rgba(16, 185, 129, 0.04) 0px, transparent 40%);
            background-attachment: fixed;
        }

        /* ============== ANIMATIONS ============== */
        @keyframes slideFadeUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-in {
            animation: slideFadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .delay-1 {
            animation-delay: 0.1s;
        }

        .delay-2 {
            animation-delay: 0.2s;
        }

        /* ============== BREADCRUMB ============== */
        .mci-breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 2rem;
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 100px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
            border: 1px solid var(--border-light);
        }

        .mci-breadcrumb a {
            color: var(--brand);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            transition: 0.2s;
        }

        .mci-breadcrumb a:hover {
            opacity: 0.7;
        }

        .mci-breadcrumb svg {
            width: 14px;
            height: 14px;
        }

        /* ============== LAYOUT ============== */
        .detail-layout {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 2rem;
            align-items: stretch;
        }

        .mci-card {
            background: var(--surface);
            border-radius: var(--radius-xl);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-soft);
            display: flex;
            flex-direction: column;
        }

        /* ============== LEFT: ARTICLE CONTENT ============== */
        .article-container {
            padding: 3rem;
        }

        .article-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-heading);
            margin: 0 0 1.5rem 0;
            line-height: 1.25;
            letter-spacing: -0.03em;
        }

        /* Badges */
        .badge-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .modern-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 1rem;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            background: var(--bg-body);
            color: var(--text-heading);
            border: 1px solid var(--border-light);
            text-transform: uppercase;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: block;
        }

        .dot-high {
            background: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
        }

        .dot-medium {
            background: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
        }

        .dot-low {
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }

        /* Author Block */
        .author-block {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            background: var(--bg-body);
            border-radius: var(--radius-lg);
            margin-bottom: 2.5rem;
            border: 1px solid var(--border-light);
        }

        .author-avatar {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--brand), #60a5fa);
            color: white;
            display: grid;
            place-items: center;
            font-size: 1.25rem;
            font-weight: 800;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
        }

        .author-info {
            flex: 1;
        }

        .author-name {
            font-weight: 700;
            color: var(--text-heading);
            font-size: 1rem;
            margin-bottom: 0.2rem;
        }

        .author-meta {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
            display: flex;
            gap: 1rem;
        }

        .author-meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Typography */
        .article-body {
            font-size: 1.05rem;
            line-height: 1.8;
            color: #475569;
            margin-bottom: 3rem;
        }

        .article-body p {
            margin-bottom: 1.5rem;
        }

        /* Actions */
        .action-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            padding-top: 2rem;
            border-top: 1px solid var(--border-light);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: var(--brand);
            color: white;
            box-shadow: 0 4px 15px rgba(29, 78, 216, 0.25);
        }

        .btn-primary:hover {
            background: var(--brand-hover);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(29, 78, 216, 0.35);
        }

        .btn-outline {
            background: white;
            color: var(--text-heading);
            border-color: var(--border-light);
        }

        .btn-outline:hover {
            background: var(--bg-body);
            transform: translateY(-3px);
            border-color: #cbd5e1;
        }

        /* ============== RIGHT: VIEWER ============== */
        .viewer-card {
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: #f8fafc;
        }

        .viewer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: white;
            border-bottom: 1px solid var(--border-light);
        }

        .viewer-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--text-heading);
        }

        .viewer-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: var(--brand-soft);
            color: var(--brand);
            display: grid;
            place-items: center;
        }

        .viewer-tools {
            display: flex;
            gap: 0.5rem;
        }

        .tool-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: white;
            border: 1px solid var(--border-light);
            color: var(--text-muted);
            display: grid;
            place-items: center;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
        }

        .tool-btn:hover {
            background: var(--brand-soft);
            color: var(--brand);
            border-color: var(--brand);
        }

        .viewer-frame {
            flex: 1;
            position: relative;
            min-height: 600px;
            display: grid;
            place-items: center;
            padding: 1rem;
        }

        .file-loader {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(248, 250, 252, 0.9);
            backdrop-filter: blur(8px);
            z-index: 10;
        }

        .spinner {
            width: 48px;
            height: 48px;
            border: 4px solid var(--border-light);
            border-top: 4px solid var(--brand);
            border-radius: 50%;
            animation: spin 1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            margin-bottom: 1rem;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            color: var(--text-muted);
        }

        .empty-illustration {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: grid;
            place-items: center;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            color: var(--brand);
        }

        @media (max-width: 1024px) {
            .detail-layout {
                grid-template-columns: 1fr;
            }

            .viewer-frame {
                min-height: 500px;
            }
        }

        @media (max-width: 640px) {
            .article-container {
                padding: 1.5rem;
            }

            .author-block {
                flex-direction: column;
                align-items: flex-start;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .mci-card {
                box-shadow: none;
                border: none;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y p-4 md:p-6 lg:p-8">

        <nav class="mci-breadcrumb no-print animate-in" aria-label="breadcrumb">
            <a href="{{ route('home') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                </svg>
                Beranda
            </a>
            <span style="color:var(--border-light);">/</span>
            <span style="color: var(--text-heading); font-weight:700;">Pengumuman Sistem</span>
        </nav>

        <div class="detail-layout">

            {{-- ================= LEFT: ARTICLE CONTENT ================= --}}
            <article class="mci-card article-container animate-in delay-1" role="article">

                <h1 class="article-title">{{ $announcement->title }}</h1>

                <div class="badge-group">
                    @php
                        $p = strtolower($announcement->priority ?? 'low');
                        $dotClass = $p === 'high' ? 'dot-high' : ($p === 'medium' ? 'dot-medium' : 'dot-low');
                    @endphp
                    <span class="modern-badge">
                        <span class="status-dot {{ $dotClass }}"></span>
                        Prioritas {{ ucfirst($p) }}
                    </span>

                    <span class="modern-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                            <line x1="7" y1="7" x2="7.01" y2="7"></line>
                        </svg>
                        {{ ucfirst($announcement->type ?? 'Umum') }}
                    </span>

                    <span class="modern-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
                            <path d="M9 22v-4h6v4"></path>
                        </svg>
                        {{ $announcement->department ?? 'Semua Departemen' }}
                    </span>
                </div>

                @php
                    use Carbon\Carbon;
                    $createdDate = $announcement->created_at ?? Carbon::now();
                    $expiryDate = $announcement->expiry_date ?? $createdDate->copy()->addDays(7);
                    $authorName = $announcement->author->name ?? 'Administrator MCI';
                @endphp

                <div class="author-block">
                    <div class="author-avatar">
                        {{ strtoupper(substr($authorName, 0, 1)) }}
                    </div>
                    <div class="author-info">
                        <div class="author-name">{{ $authorName }}</div>
                        <div class="author-meta">
                            <span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                Diterbitkan: {{ Carbon::parse($createdDate)->translatedFormat('d M Y') }}
                            </span>
                            <span style="color: var(--danger);">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                Expired: {{ Carbon::parse($expiryDate)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="article-body">
                    {!! nl2br(e($announcement->content)) !!}
                </div>

                <div class="action-bar no-print">
                    <a href="{{ route('home') }}" class="btn btn-outline">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Kembali
                    </a>

                    @if ($announcement->attachment)
                        <a href="{{ \Illuminate\Support\Facades\Storage::url($announcement->attachment) }}" download
                            class="btn btn-primary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="7 10 12 15 17 10"></polyline>
                                <line x1="12" y1="15" x2="12" y2="3"></line>
                            </svg>
                            Unduh File
                        </a>
                    @endif

                    @can('update', $announcement)
                        <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-outline"
                            style="margin-left: auto;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            Edit
                        </a>
                    @endcan
                </div>
            </article>

            {{-- ================= RIGHT: NATIVE-LIKE VIEWER ================= --}}
            <div class="mci-card viewer-card animate-in delay-2">
                @if ($announcement->attachment)
                    @php
                        $path = $announcement->attachment;
                        $url = \Illuminate\Support\Facades\Storage::url($path);
                        $isPdf = \Illuminate\Support\Str::endsWith(strtolower($path), '.pdf');
                        $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path);
                        $attachmentName = basename($path);
                    @endphp

                    <div class="viewer-header no-print">
                        <div class="viewer-title">
                            <div class="viewer-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                </svg>
                            </div>
                            <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px;"
                                title="{{ $attachmentName }}">{{ $attachmentName }}</span>
                        </div>

                        <div class="viewer-tools">
                            <a href="{{ $url }}" target="_blank" class="tool-btn" title="Buka di Tab Baru">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                    <polyline points="15 3 21 3 21 9"></polyline>
                                    <line x1="10" y1="14" x2="21" y2="3"></line>
                                </svg>
                            </a>
                            @if ($isPdf || $isImage)
                                <button id="fullscreenBtn" class="tool-btn" title="Mode Layar Penuh">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
                                        </path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="viewer-frame">
                        <div id="fileLoader" class="file-loader">
                            <div class="spinner"></div>
                            <div style="font-weight: 700; color: var(--text-heading); letter-spacing: 0.05em;">MEMUAT
                                DOKUMEN</div>
                        </div>

                        @if ($isPdf)
                            <iframe id="fileViewer" src="{{ $url }}"
                                style="width: 100%; height: 100%; border: none;" title="Pratinjau Dokumen"></iframe>
                        @elseif ($isImage)
                            <img id="fileViewer" src="{{ $url }}" alt="Lampiran"
                                style="max-width: 100%; max-height: 100%; object-fit: contain;" />
                        @else
                            <div class="empty-state">
                                <div class="empty-illustration">
                                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                                        <polyline points="13 2 13 9 20 9"></polyline>
                                    </svg>
                                </div>
                                <h3 style="font-weight: 800; color: var(--text-heading); margin: 0 0 0.5rem 0;">Format
                                    Tidak Dikenal</h3>
                                <p style="margin-bottom: 1.5rem;">Pratinjau tidak tersedia langsung di browser.</p>
                                <a href="{{ $url }}" download class="btn btn-primary">Unduh File Sekarang</a>
                            </div>
                        @endif
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const viewer = document.getElementById('fileViewer');
                            const loader = document.getElementById('fileLoader');
                            const fsBtn = document.getElementById('fullscreenBtn');

                            if (viewer && loader) {
                                viewer.addEventListener('load', () => loader.style.opacity = '0');
                                setTimeout(() => {
                                    loader.style.display = 'none';
                                }, 3000); // safety fallback
                            } else if (loader) {
                                loader.style.display = 'none';
                            }

                            if (fsBtn && viewer) {
                                fsBtn.addEventListener('click', () => {
                                    if (viewer.requestFullscreen) viewer.requestFullscreen();
                                    else if (viewer.webkitRequestFullscreen) viewer.webkitRequestFullscreen();
                                    else window.open(viewer.src, '_blank');
                                });
                            }
                        });
                    </script>
                @else
                    {{-- Empty State Premium --}}
                    <div class="viewer-frame" style="background: white;">
                        <div class="empty-state">
                            <div class="empty-illustration">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="8" y1="6" x2="21" y2="6"></line>
                                    <line x1="8" y1="12" x2="21" y2="12"></line>
                                    <line x1="8" y1="18" x2="21" y2="18"></line>
                                    <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                    <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                    <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                </svg>
                            </div>
                            <h3
                                style="font-size: 1.25rem; font-weight: 800; color: var(--text-heading); margin: 0 0 0.5rem 0;">
                                Pengumuman Teks</h3>
                            <p style="margin: 0; max-width: 250px; line-height: 1.5;">Tidak ada dokumen pendukung yang
                                dilampirkan pada informasi ini.</p>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
