@extends('layouts.home')

@section('title', 'Detail Pengumuman | MCI')

@push('css')
    <style>
        /* Card + layout */
        .ann-card {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.06);
            overflow: hidden;
            background: #fff;
        }

        .ann-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .35rem .6rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: .85rem;
        }

        .priority-low {
            background: #ecfdf5;
            color: #065f46;
        }

        .priority-medium {
            background: #fffbeb;
            color: #92400e;
        }

        .priority-high {
            background: #fff1f2;
            color: #991b1b;
        }

        .meta-pill {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .25rem .6rem;
            border-radius: 999px;
            background: #f8fafc;
            color: #0f172a;
            font-size: .85rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem .8rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: .92rem;
            transition: transform .12s ease, box-shadow .12s ease, background-color .12s ease;
            cursor: pointer;
            text-decoration: none;
            border: 0;
        }

        .btn:focus { outline: 3px solid rgba(99,102,241,0.12); outline-offset: 2px; }

        .btn-primary {
            background: linear-gradient(90deg,#2563eb,#4f46e5);
            color: white;
            box-shadow: 0 8px 20px rgba(79,70,229,0.08);
        }
        .btn-primary:hover { transform: translateY(-2px); }

        .btn-outline {
            background: white;
            border: 1px solid #e6eefb;
            color: #0f172a;
        }
        .btn-outline:hover {
            background: #f8fbff;
            transform: translateY(-2px);
        }

        .btn-ghost {
            background: transparent;
            border: 1px solid #e6eefb;
            color: #0f172a;
            padding: .45rem .6rem;
            border-radius: 8px;
        }
        .btn-ghost:hover { background: rgba(14,165,233,0.05); }

        .btn-danger {
            background: linear-gradient(90deg,#ef4444,#dc2626);
            color: white;
        }

        .btn-print {
            background: linear-gradient(90deg,#06b6d4,#06b6d4);
            color: white;
        }

        .file-actions .btn {
            padding: .45rem .6rem;
            font-size: .88rem;
            border-radius: 8px;
        }

        /* Attachment area */
        .attachment-wrap {
            min-height: 220px;
            background: linear-gradient(180deg, #ffffff, #fbfdff);
            border-left: 1px solid #eef2ff;
            position: relative;
        }

        .file-loader {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .75rem;
            background: rgba(255, 255, 255, 0.86);
            backdrop-filter: blur(4px);
            z-index: 20;
            flex-direction: column;
        }

        .file-actions {
            display: flex;
            gap: .5rem;
            align-items: center;
        }

        .prose { font-size: 1rem; line-height: 1.6; }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .md\\:w-1\\/2 { width: 100%; }
            .md\\:flex { display: block; }
            .attachment-wrap { min-height: 200px; }
            .file-actions { justify-content: flex-start; flex-wrap: wrap; }
            .btn { font-size: .88rem; padding: .45rem .65rem; }
        }

        /* print friendly */
        @media print {
            .no-print { display: none !important; }
        }
    </style>
@endpush

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex flex-wrap items-center text-sm text-gray-500 space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="flex items-center text-blue-600 hover:underline">
                        <i class="bx bx-home-alt mr-1" aria-hidden="true"></i> Home
                    </a>
                </li>
                <li aria-hidden="true">/</li>
                <li class="text-gray-400" aria-current="page">Detail Pengumuman</li>
            </ol>
        </nav>

        <div class="md:flex md:space-x-6 gap-6">
            {{-- Left: Announcement detail --}}
            <article class="md:w-1/2 ann-card p-6 md:p-8 mb-6 md:mb-0" role="article" aria-labelledby="ann-title">
                <header class="mb-4">
                    <h1 id="ann-title" class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">{{ $announcement->title }}</h1>

                    <div class="flex flex-wrap items-center gap-2">
                        {{-- priority badge --}}
                        @php
                            $p = strtolower($announcement->priority ?? 'low');
                            $prioClass = $p === 'high' ? 'priority-high' : ($p === 'medium' ? 'priority-medium' : 'priority-low');
                        @endphp
                        <span class="ann-badge {{ $prioClass }}" aria-hidden="true">
                            @if ($p === 'high')
                                ⚠️
                            @elseif($p === 'medium')
                                ℹ️
                            @else
                                ✅
                            @endif
                            <span class="sr-only">Prioritas: </span> {{ ucfirst($p) }}
                        </span>

                        <span class="meta-pill" title="Tipe">
                            <i class="bx bx-tag"></i> {{ ucfirst($announcement->type ?? 'Umum') }}
                        </span>

                        <span class="meta-pill" title="Departemen">
                            <i class="bx bx-building"></i> {{ $announcement->department ?? 'Semua' }}
                        </span>

                        <span class="meta-pill" title="Status">
                            <i class="bx bx-toggle-right"></i> {{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </header>

                <div class="text-gray-600 text-sm mb-6 space-y-2">
                    {{-- Penulis --}}
                    <div>
                        Dibuat oleh:
                        <strong class="text-gray-800">{{ $announcement->author->name ?? 'Admin' }}</strong>
                    </div>

                    {{-- Tanggal dibuat --}}
                    <div>
                        Tanggal dibuat:
                        <strong class="text-gray-800">
                            @php
                                use Carbon\Carbon;
                                $createdDate = $announcement->created_at ?? Carbon::now();
                            @endphp
                            {{ Carbon::parse($createdDate)->translatedFormat('d F Y') }}
                        </strong>
                    </div>

                    {{-- Tanggal berlaku --}}
                    <div>
                        Berlaku hingga:
                        <strong class="text-red-600">
                            @php
                                $expiryDate = $announcement->expiry_date ?? $createdDate->copy()->addDays(7);
                            @endphp
                            {{ Carbon::parse($expiryDate)->translatedFormat('d F Y') }}
                        </strong>
                    </div>
                </div>

                <div class="prose max-w-full text-gray-700 mb-6 leading-relaxed">
                    {!! nl2br(e($announcement->content)) !!}
                </div>

                <div class="flex flex-wrap items-center gap-3 no-print">
                    <a href="{{ route('home') }}" class="btn btn-outline" aria-label="Kembali ke beranda">
                        <!-- back icon -->
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Kembali
                    </a>

                    @if ($announcement->attachment)
                        @php
                            $attachmentUrl = \Illuminate\Support\Facades\Storage::url($announcement->attachment);
                            $attachmentName = basename($announcement->attachment);
                        @endphp
                        <a href="{{ $attachmentUrl }}" download class="btn btn-primary" aria-label="Download lampiran">
                            <!-- download icon -->
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 11l4 4 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 21H3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Unduh Lampiran
                        </a>
                    @endif
{{-- 
                    <button type="button" class="btn btn-print" onclick="window.print()" aria-label="Cetak pengumuman">
                        <!-- print icon -->
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 9V3h12v6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><rect x="6" y="13" width="12" height="8" rx="2" stroke="currentColor" stroke-width="1.6"/></svg>
                        Cetak
                    </button> --}}

                    @can('update', $announcement)
                        <a href="{{ route('announcements.edit', $announcement->id) }}" class="btn btn-outline" aria-label="Edit pengumuman">
                            <!-- edit icon -->
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 21v-3.75L14.06 6.19l3.75 3.75L6.75 21H3z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Edit
                        </a>
                    @endcan
                </div>
            </article>

            {{-- Right: Attachment preview --}}
            <div class="md:w-1/2 ann-card attachment-wrap">
                @if ($announcement->attachment)
                    @php
                        $path = $announcement->attachment;
                        $url = \Illuminate\Support\Facades\Storage::url($path);
                        $isPdf = \Illuminate\Support\Str::endsWith(strtolower($path), '.pdf');
                        $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $path);
                        $attachmentName = basename($path);
                    @endphp

                    <div id="fileLoader" class="file-loader" role="status" aria-live="polite">
                        <svg class="animate-spin h-10 w-10 text-sky-600" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="10" stroke="rgba(59,130,246,0.25)" stroke-width="4"></circle>
                            <path d="M22 12a10 10 0 00-10-10" stroke="#2563EB" stroke-width="4" stroke-linecap="round"></path>
                        </svg>
                        <div class="text-gray-700 font-medium">Memuat lampiran...</div>
                        <div class="text-xs text-gray-500 mt-1">Jika proses memuat lama, klik "Buka di tab baru" atau "Unduh"</div>
                    </div>

                    <div id="fileViewerWrap" class="w-full h-full flex flex-col">
                        <div class="flex-1 relative">
                            @if ($isPdf)
                                <iframe id="fileViewer" src="{{ $url }}" class="w-full h-full" frameborder="0" title="Preview PDF Lampiran"></iframe>
                            @elseif ($isImage)
                                <img id="fileViewer" src="{{ $url }}" alt="Lampiran gambar {{ $attachmentName }}" class="object-contain w-full h-full" />
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-500 p-6">
                                    <div>
                                        <p class="mb-2">Pratinjau tidak tersedia untuk jenis file ini.</p>
                                        <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-primary">Buka / Unduh</a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="p-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between gap-3 no-print">
                            <div class="text-sm text-gray-600">Nama file: <strong class="text-gray-800">{{ $attachmentName }}</strong></div>

                            <div class="file-actions">
                                @if ($isPdf)
                                    <button id="fullscreenBtn" type="button" class="btn btn-outline" aria-label="Fullscreen PDF">
                                        <!-- fullscreen icon -->
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 8V4h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 16v4h-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Fullscreen
                                    </button>
                                @else
                                    <button id="fullscreenBtn" type="button" class="btn btn-outline" aria-label="Fullscreen Image">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 8V4h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M20 16v4h-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Fullscreen
                                    </button>
                                @endif

                                <a href="{{ $url }}" download class="btn btn-outline" aria-label="Unduh lampiran">
                                    <!-- download icon -->
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 11l4 4 4-4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M21 21H3" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    Unduh
                                </a>

                                <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-outline" aria-label="Buka di tab baru">Open</a>
                            </div>
                        </div>
                    </div>

                    {{-- Inline script to handle loader / fullscreen safely --}}
                    <script>
                        (function () {
                            document.addEventListener('DOMContentLoaded', function () {
                                const fileViewer = document.getElementById('fileViewer');
                                const fileLoader = document.getElementById('fileLoader');
                                const fullscreenBtn = document.getElementById('fullscreenBtn');

                                function hideLoader() {
                                    if (fileLoader) fileLoader.style.display = 'none';
                                }

                                // hide loader after load event or after timeout (fallback)
                                if (fileViewer) {
                                    // Images/iframes fire 'load'
                                    try {
                                        fileViewer.addEventListener && fileViewer.addEventListener('load', hideLoader);
                                    } catch (e) { /* ignore */ }

                                    // Fallback: hide loader after 5s to avoid permanent blocking
                                    setTimeout(hideLoader, 5000);
                                } else {
                                    // no viewer (unsupported) - hide loader
                                    setTimeout(hideLoader, 300);
                                }

                                if (fullscreenBtn && fileViewer) {
                                    fullscreenBtn.addEventListener('click', function () {
                                        const el = fileViewer;
                                        // if viewer is img or iframe, request fullscreen on its container where possible
                                        const target = el.tagName.toLowerCase() === 'iframe' ? el : el;
                                        if (target.requestFullscreen) {
                                            target.requestFullscreen().catch(() => {
                                                // fallback open in new tab
                                                window.open(el.src || el.getAttribute('src'), '_blank', 'noopener');
                                            });
                                        } else if (target.webkitRequestFullscreen) {
                                            target.webkitRequestFullscreen();
                                        } else if (target.msRequestFullscreen) {
                                            target.msRequestFullscreen();
                                        } else {
                                            window.open(el.src || el.getAttribute('src'), '_blank', 'noopener');
                                        }
                                    });
                                }
                            });
                        })();
                    </script>
                @else
                    {{-- No attachment --}}
                    <div class="w-full h-full flex items-center justify-center p-8">
                        <div class="text-center text-gray-500">
                            <div class="mb-3 text-4xl">📎</div>
                            <div class="font-medium mb-2">Tidak ada lampiran</div>
                            <div class="text-sm">Pengumuman ini tidak memiliki file yang dilampirkan.</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection