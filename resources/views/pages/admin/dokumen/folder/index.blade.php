@extends('layouts.admin')
@section('title', 'Document | Project & Folder')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Document /</span> Project
    </h4>

    <div class="accordion" id="projectAccordion">

        @forelse ($projects as $project)
            <div class="accordion-item mb-2 shadow-sm">

                <h2 class="accordion-header" id="heading{{ $project->id }}">
                    <button class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $project->id }}">

                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $project->project_name }}</strong><br>
                                <small class="text-muted">
                                    Project Code: {{ $project->project_number ?? '-' }}
                                </small>
                            </div>

                            <span class="badge bg-secondary me-3">
                                {{ $project->folders->count() }} Folder
                            </span>
                        </div>

                    </button>
                </h2>

                <div id="collapse{{ $project->id }}"
                     class="accordion-collapse collapse"
                     data-bs-parent="#projectAccordion">

                    <div class="accordion-body">

                        <div class="d-flex justify-content-end mb-2">
                            <a href="{{ route('document.folders.create', $project->id) }}"
                               class="btn btn-sm btn-primary">
                                + Tambah Folder
                            </a>
                        </div>

                        @if ($project->folders->isEmpty())
                            <div class="text-muted text-center py-3">
                                Belum ada folder pada project ini
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="40">No</th>
                                            <th>Folder Name</th>
                                            <th>Folder Code</th>
                                            <th>Description</th>
                                            <th width="120">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($project->folders as $index => $folder)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $folder->folder_name }}</td>
                                                <td>{{ $folder->folder_code }}</td>
                                                <td>{{ $folder->description ?? '-' }}</td>
                                                <td class="text-center">
                                                    <a href="#"
                                                       class="btn btn-sm btn-outline-primary">
                                                        Open
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-5">
                Belum ada project
            </div>
        @endforelse

    </div>

</div>
@endsection
