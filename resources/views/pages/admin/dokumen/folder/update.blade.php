@extends('layouts.admin')

@section('title', 'Edit Folder | Document Portal')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Document / Folder /</span> Edit
        </h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-folder-open"></i> Edit Folder
                </h5>
                <a href="{{ route('document.folder.index') }}" class="btn btn-light btn-sm">
                    <i class="bx bx-left-arrow-alt"></i> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ route('document.folder.update', $folder->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Folder Name --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">Folder Name</label>
                        <div class="col-sm-10">
                            <input type="text" name="folder_name" class="form-control"
                                value="{{ old('folder_name', $folder->folder_name) }}" required>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label fw-semibold">Description</label>
                        <div class="col-sm-10">
                            <textarea name="description" class="form-control" rows="3">
{{ old('description', $folder->description) }}</textarea>
                        </div>
                    </div>

                    {{-- Action --}}
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-save"></i> Update Folder
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection
