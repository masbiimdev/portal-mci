<style>
    /* ================= ROOT & VARIABLES ================= */
    :root {
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --primary-light: #eef2ff;
        --success: #16a34a;
        --success-light: #dcfce7;
        --warning: #f59e0b;
        --warning-light: #fef3c7;
        --danger: #dc2626;
        --danger-light: #fee2e2;
        --gray-900: #111827;
        --gray-800: #1f2937;
        --gray-700: #374151;
        --gray-600: #4b5563;
        --gray-500: #6b7280;
        --gray-400: #9ca3af;
        --gray-300: #d1d5db;
        --gray-200: #e5e7eb;
        --gray-100: #f3f4f6;
        --gray-50: #f9fafb;
        --border-radius: 12px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ================= MODAL WRAPPER ================= */
    .modal-doc-wrapper {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        color: var(--gray-800);
        padding: 28px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 16px;
    }

    /* ================= HEADER ================= */
    .modal-doc-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 28px;
        padding-bottom: 20px;
        border-bottom: 2px solid var(--gray-200);
        gap: 16px;
    }

    .modal-doc-title {
        font-size: 28px;
        font-weight: 800;
        margin: 0;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .badge-folder {
        background: linear-gradient(135deg, var(--primary-light), #e0e7ff);
        color: #3730a3;
        padding: 8px 16px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(37, 99, 235, 0.1);
        white-space: nowrap;
    }

    .badge-final {
        background: linear-gradient(135deg, var(--success-light), #bbf7d0);
        color: #166534;
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(22, 163, 74, 0.1);
        display: inline-block;
    }

    /* ================= STATS GRID ================= */
    .info-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: white;
        padding: 16px;
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-200);
        transition: var(--transition);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        transform: scaleX(0);
        transform-origin: left;
        transition: var(--transition);
    }

    .stat-card:hover {
        border-color: var(--primary);
        box-shadow: 0 8px 16px rgba(37, 99, 235, 0.12);
        transform: translateY(-2px);
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--gray-400);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .stat-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--gray-900);
        word-break: break-word;
    }

    /* ================= DESCRIPTION ================= */
    .description-content {
        font-size: 15px;
        color: var(--gray-600);
        line-height: 1.8;
        padding: 20px;
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius);
        margin-bottom: 28px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        transition: var(--transition);
        border-left: 4px solid var(--primary);
    }

    .description-content:hover {
        border-left-color: var(--primary-dark);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
    }

    /* ================= PREVIEW SECTION ================= */
    .preview-section {
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        background: white;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        animation: fadeInUp 0.6s ease-out;
    }

    .preview-header {
        background: linear-gradient(135deg, var(--gray-50), #f3f4f6);
        padding: 16px 20px;
        font-size: 14px;
        font-weight: 700;
        color: var(--gray-700);
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .preview-header::before {
        content: '📄';
        font-size: 16px;
    }

    .iframe-container {
        width: 100%;
        height: 60vh;
        border: none;
        display: block;
    }

    .preview-error {
        padding: 40px;
        text-align: center;
        color: var(--gray-500);
        font-size: 14px;
    }

    /* ================= DOWNLOAD STATS ================= */
    .download-stats-container {
        background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        border-left: 4px solid #0284c7;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 28px;
        animation: fadeInUp 0.6s ease-out;
    }

    .download-stats-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .download-stats-title {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #0c4a6e;
    }

    .download-count-badge {
        background: #0284c7;
        color: white;
        padding: 4px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .download-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }

    .download-stat-item {
        background: white;
        padding: 12px;
        border-radius: 8px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .download-stat-label {
        font-size: 11px;
        color: var(--gray-500);
        font-weight: 700;
        margin-bottom: 4px;
    }

    .download-stat-value {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary);
    }

    .download-users-section {
        margin-top: 16px;
    }

    .download-users-title {
        font-size: 12px;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 10px;
    }

    .download-users-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .download-user-item {
        background: white;
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 12px;
        border: 1px solid #e0e7ff;
    }

    .download-user-name {
        font-weight: 700;
        color: var(--gray-900);
    }

    .download-user-meta {
        font-size: 11px;
        color: var(--gray-500);
    }

    /* ================= HISTORY TIMELINE ================= */
    .history-section {
        margin-bottom: 30px;
    }

    .history-title {
        font-size: 16px;
        font-weight: 800;
        color: var(--gray-900);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .history-title::before {
        content: '📋';
        font-size: 18px;
    }

    .timeline {
        position: relative;
        padding-left: 28px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 6px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, var(--primary), var(--primary-light));
    }

    .timeline-item {
        position: relative;
        margin-bottom: 24px;
        opacity: 0;
        animation: slideIn 0.5s ease-out forwards;
    }

    .timeline-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .timeline-item:nth-child(2) {
        animation-delay: 0.2s;
    }

    .timeline-item:nth-child(3) {
        animation-delay: 0.3s;
    }

    .timeline-item:nth-child(n+4) {
        animation-delay: 0.4s;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .timeline-dot {
        position: absolute;
        left: -23px;
        top: 6px;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background: white;
        border: 3px solid var(--primary);
        box-shadow: 0 0 0 4px var(--primary-light);
        z-index: 2;
        transition: var(--transition);
    }

    .timeline-dot.download {
        border-color: #a855f7;
        box-shadow: 0 0 0 4px #f3e8ff;
    }

    .timeline-item:hover .timeline-dot {
        transform: scale(1.2);
        box-shadow: 0 0 0 6px var(--primary-light), 0 4px 12px rgba(37, 99, 235, 0.3);
    }

    .timeline-card {
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius);
        padding: 16px 18px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: var(--transition);
    }

    .timeline-card:hover {
        border-color: var(--primary);
        box-shadow: 0 8px 16px rgba(37, 99, 235, 0.12);
        transform: translateX(4px);
    }

    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 10px;
        font-size: 13px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .timeline-action {
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .timeline-meta {
        font-size: 12px;
        color: var(--gray-400);
        white-space: nowrap;
    }

    .timeline-note {
        font-size: 13px;
        color: var(--gray-600);
        margin-top: 8px;
        line-height: 1.6;
        padding: 8px 0;
        border-top: 1px solid var(--gray-100);
    }

    .badge-revision {
        background: linear-gradient(135deg, var(--primary-light), #e0e7ff);
        color: #3730a3;
        padding: 3px 10px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        white-space: nowrap;
    }

    /* ================= FOOTER ================= */
    .modal-doc-footer {
        margin-top: 32px;
        padding-top: 20px;
        border-top: 2px solid var(--gray-200);
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-download-action {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white !important;
        padding: 12px 28px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: 0 8px 16px rgba(37, 99, 235, 0.3);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-download-action:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.4);
    }

    .btn-download-action:active {
        transform: translateY(-1px);
    }

    .btn-download-action::before {
        content: '⬇️';
        font-size: 16px;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 768px) {
        .modal-doc-wrapper {
            padding: 20px;
        }

        .modal-doc-header {
            flex-direction: column;
            gap: 12px;
        }

        .modal-doc-title {
            font-size: 22px;
        }

        .info-stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .stat-card {
            padding: 14px;
        }

        .stat-value {
            font-size: 16px;
        }

        .timeline {
            padding-left: 24px;
        }

        .timeline-dot {
            left: -20px;
            width: 14px;
            height: 14px;
            border-width: 2px;
        }

        .timeline-header {
            flex-direction: column;
        }

        .timeline-meta {
            white-space: normal;
        }

        .iframe-container {
            height: 50vh;
        }

        .download-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .download-users-list {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .modal-doc-wrapper {
            padding: 16px;
        }

        .modal-doc-title {
            font-size: 18px;
        }

        .info-stats-grid {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .badge-folder {
            padding: 6px 12px;
            font-size: 11px;
        }

        .iframe-container {
            height: 40vh;
        }

        .download-stats-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ================= ANIMATIONS ================= */
    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    .loading {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<div class="modal-doc-wrapper">

    {{-- HEADER --}}
    <div class="modal-doc-header">
        <div>
            <h2 class="modal-doc-title">
                {{ $document->title }}
                @if ($document->is_final)
                    <span class="badge-final">Final</span>
                @endif
            </h2>
        </div>
        <div class="badge-folder">
            📁 {{ $document->folder->folder_name ?? 'General' }}
        </div>
    </div>

    {{-- STATS --}}
    @php
        $fullPath = $document->file_path ? public_path($document->file_path) : null;
        $fileExists = $fullPath && file_exists($fullPath);
        $fileSize = '-';
        if ($fileExists) {
            $size = filesize($fullPath);
            $fileSize =
                $size >= 1024 * 1024
                    ? number_format($size / 1024 / 1024, 1) . ' MB'
                    : number_format($size / 1024, 0) . ' KB';
        }
    @endphp

    <div class="info-stats-grid">
        <div class="stat-card">
            <span class="stat-label">📌 Doc Number</span>
            <span class="stat-value">{{ $document->document_no ?? '-' }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">🔄 Revision</span>
            <span class="stat-value">Rev {{ $document->revision ?? '0' }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">💾 Size</span>
            <span class="stat-value">{{ $fileSize }}</span>
        </div>
        <div class="stat-card">
            <span class="stat-label">📅 Date</span>
            <span class="stat-value">{{ $document->created_at->format('d M Y') }}</span>
        </div>
    </div>

    {{-- DESCRIPTION --}}
    @if ($document->description)
        <div class="description-content">
            {{ $document->description }}
        </div>
    @endif

    {{-- PREVIEW --}}
    @if ($fileExists)
        <div class="preview-section">
            <div class="preview-header">Document Preview</div>
            <iframe class="iframe-container" src="{{ route('document.preview', $document->id) }}"></iframe>
        </div>
    @else
        <div class="preview-error">
            <p>📄 File tidak ditemukan atau belum diunggah</p>
        </div>
    @endif




    {{-- TIMELINE HISTORY --}}
    @if ($document->histories->count())
        <div class="history-section">
            <div class="history-title">Document Activity</div>

            <div class="timeline">
                @php
                    $actionIcons = [
                        'Initial Upload' => '➕',
                        'Update Dokumen' => '✏️',
                        'delete' => '🗑️',
                        'downloaded' => '⬇️',
                        'view' => '👁️',
                    ];

                    // Urutkan history terbaru di atas
                    $histories = $document->histories->sortByDesc('created_at');

                    // Group downloaded per user
                    $downloadedGrouped = $histories->where('action', 'downloaded')->groupBy('user_id');
                @endphp

                {{-- Loop untuk Initial Upload dan Update Dokumen --}}
                @foreach ($histories as $history)
                    @if (in_array($history->action, ['Initial Upload', 'Update Dokumen']))
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>

                            <div class="timeline-card">
                                <div class="timeline-header">
                                    <div class="timeline-action">
                                        <span>{!! $actionIcons[$history->action] ?? 'ℹ️' !!}</span>
                                        <span>{{ ucfirst($history->action) }}</span>

                                        {{-- Tampilkan revision hanya untuk Update --}}
                                        @if ($history->action === 'Update Dokumen' && $history->revision)
                                            <span class="badge-revision">Rev {{ $history->revision }}</span>
                                        @endif
                                    </div>

                                    <div class="timeline-meta">
                                        👤 {{ $history->user->name ?? 'System' }} •
                                        {{ $history->created_at->format('d M Y H:i') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                {{-- Loop untuk Downloaded, digabung per user --}}
                @foreach ($downloadedGrouped as $userId => $histories)
                    @php
                        // Ambil entry terbaru user
                        $latestHistory = $histories->sortByDesc('created_at')->first();
                        $count = $histories->count();
                    @endphp

                    <div class="timeline-item">
                        <div class="timeline-dot highlight"></div>

                        <div class="timeline-card">
                            <div class="timeline-header">
                                <div class="timeline-action">
                                    <span>{!! $actionIcons['downloaded'] !!}</span>
                                    <span>Downloaded</span>
                                    @if ($count > 1)
                                        <span class="badge-count">{{ $count }}×</span>
                                    @endif
                                </div>

                                <div class="timeline-meta">
                                    👤 {{ $latestHistory->user->name ?? 'System' }} •
                                    {{ $latestHistory->created_at->format('d M Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    @endif


</div>
