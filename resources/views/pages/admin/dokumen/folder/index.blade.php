@extends('layouts.admin')
@section('title', 'Document | Project & Folder')

@push('css')
<style>
    /* Custom Styling untuk Folder Cards */
    .folder-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.25rem;
        padding: 1rem 0;
    }
    .folder-card {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.2s ease-in-out;
        background: #fff;
        text-decoration: none !important;
        position: relative;
    }
    .folder-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-color: #5166ff;
    }
    .folder-icon {
        font-size: 2.5rem;
        color: #ffca28; /* Warna kuning folder standar */
        margin-bottom: 0.75rem;
        display: block;
    }
    .folder-name {
        font-weight: 700;
        color: #2d3a71;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .folder-meta {
        font-size: 0.75rem;
        color: #64748b;
    }
    .accordion-button:not(.collapsed) {
        background-color: #f8faff;
        color: #5166ff;
    }
    .project-status-dot {
        height: 8px;
        width: 8px;
        background-color: #10b981;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
</style>
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">
            <span class="text-muted fw-light">Document /</span> Project Management
        </h4>
        <button class="btn btn-outline-primary btn-sm">
            <i class="bx bx-filter-alt me-1"></i> Filter Project
        </button>
    </div>

    <div class="accordion" id="projectAccordion">
        @forelse ($projects as $project)
            <div class="accordion-item mb-3 border shadow-none rounded">
                <h2 class="accordion-header" id="heading{{ $project->id }}">
                    <button class="accordion-button collapsed px-4 py-3"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $project->id }}">
                        
                        <div class="w-100 d-flex justify-content-between align-items-center pe-3">
                            <div>
                                <span class="project-status-dot"></span>
                                <span class="h6 mb-0 fw-bold">{{ $project->project_name }}</span>
                                <div class="mt-1">
                                    <span class="badge bg-label-primary small me-2">{{ $project->project_number ?? 'NO-CODE' }}</span>
                                    <small class="text-muted"><i class="bx bx-folder me-1"></i>{{ $project->folders->count() }} Folders</small>
                                </div>
                            </div>
                            <div class="d-none d-md-block text-end">
                                <small class="text-muted d-block small text-uppercase fw-semibold">Last Modified</small>
                                <small class="fw-bold text-dark">{{ $project->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </button>
                </h2>

                <div id="collapse{{ $project->id }}"
                     class="accordion-collapse collapse"
                     data-bs-parent="#projectAccordion">

                    <div class="accordion-body bg-light-subtle px-4 py-4">
                        
                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                            <h6 class="mb-0 fw-bold text-muted text-uppercase small">Sub-Folders List</h6>
                            <a href="{{ route('document.folders.create', $project->id) }}"
                               class="btn btn-primary btn-sm px-3 shadow-sm">
                                <i class="bx bx-plus me-1"></i> Create Folder
                            </a>
                        </div>

                        @if ($project->folders->isEmpty())
                            <div class="text-center py-5 bg-white rounded border border-dashed">
                                <i class="bx bx-folder-open display-4 text-muted mb-2"></i>
                                <p class="text-muted mb-0">Belum ada folder di project ini.</p>
                                <small>Silakan tambahkan folder baru untuk mulai menyimpan dokumen.</small>
                            </div>
                        @else
                            <div class="folder-grid">
                                @foreach ($project->folders as $folder)
                                    <a href="#" class="folder-card shadow-sm border-0">
                                        <i class="bx bxs-folder folder-icon"></i>
                                        <span class="folder-name">{{ $folder->folder_name }}</span>
                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <span class="folder-meta">{{ $folder->folder_code }}</span>
                                            <span class="badge bg-label-secondary rounded-pill" style="font-size: 10px;">Open</span>
                                        </div>
                                        
                                        @if($folder->description)
                                        <div class="mt-2 pt-2 border-top">
                                            <small class="text-muted d-block text-truncate" title="{{ $folder->description }}">
                                                {{ $folder->description }}
                                            </small>
                                        </div>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="card shadow-none border border-dashed">
                <div class="card-body text-center py-5">
                    <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/empty-folder.png" alt="No data" width="120" class="mb-3 opacity-50">
                    <h5 class="fw-bold">No Projects Found</h5>
                    <p class="text-muted mb-0">Anda belum memiliki daftar project dokumen.</p>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection