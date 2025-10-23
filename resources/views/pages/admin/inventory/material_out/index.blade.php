@extends('layouts.admin')
@section('title', 'Material Keluar')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold mb-3">📤 Material Keluar</h4>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <a href="{{ route('material_out.create') }}" class="btn btn-primary mb-3">+ Tambah Data</a>

        <div class="card p-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Material</th>
                        <th>Qty</th>
                        <th>Tanggal</th>
                        <th>Stok Setelah</th>
                        <th>Input Oleh</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materialOuts as $m)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $m->material->material_code ?? '-' }}</td>
                            <td>{{ $m->qty_out }}</td>
                            <td>{{ $m->date_out }}</td>
                            <td>{{ $m->stock_after }}</td>
                            <td>{{ $m->user->name ?? 'Admin' }}</td>
                            <td>{{ $m->notes ?? '-' }}</td>
                            <td>
                                <a href="{{ route('material_out.edit', $m->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('material_out.destroy', $m->id) }}" method="POST"
                                    style="display:inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
