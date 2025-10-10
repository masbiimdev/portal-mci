@extends('layouts.admin')
@section('title', 'Tambah Modul | MCI')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Modules /</span> Tambah</h4>
        <div class="card p-4">
            <form action="{{ route('modules.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama Modul</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Route Name</label>
                    <input type="text" name="route_name" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('modules.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
