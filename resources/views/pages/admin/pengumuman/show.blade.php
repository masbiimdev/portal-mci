@extends('layouts.home')

@section('title', 'Detail Pengumuman | MCI')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="flex flex-wrap items-center text-sm text-gray-500 space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="flex items-center text-blue-600 hover:underline">
                        <i class="bx bx-home-alt mr-1"></i> Home
                    </a>
                </li>
                <li>/</li>
                <li class="text-gray-400">Detail</li>
            </ol>
        </nav>

        <div class="md:flex md:space-x-6 gap-6">
            {{-- Kiri: Detail Pengumuman --}}
            <div class="md:w-1/2 bg-white shadow rounded-xl p-6 md:p-8 mb-6 md:mb-0">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">{{ $announcement->title }}</h2>

                {{-- Info --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="flex items-center px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                        Jenis: {{ ucfirst($announcement->type) }}
                    </span>

                    <span class="flex items-center px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                        Departemen: {{ $announcement->department ?? 'Semua' }}
                    </span>

                    @php
                        $priorityColors = [
                            'low' => 'bg-green-200 text-green-800',
                            'medium' => 'bg-yellow-200 text-yellow-800',
                            'high' => 'bg-red-200 text-red-800',
                        ];
                    @endphp
                    <span class="flex items-center px-3 py-1 text-sm rounded-full {{ $priorityColors[$announcement->priority] ?? 'bg-gray-200 text-gray-800' }}">
                        Prioritas: {{ ucfirst($announcement->priority) }}
                    </span>

                    <span class="flex items-center px-3 py-1 text-sm rounded-full {{ $announcement->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-500' }}">
                        {{ $announcement->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                {{-- Info tambahan --}}
                <div class="text-gray-700 text-sm mb-6 space-y-2">
                    <div>
                        Dibuat oleh: <span class="font-medium">{{ $announcement->author->name ?? 'Admin' }}</span>
                    </div>
                    <div>
                        Tanggal dibuat:
                        <span class="font-medium">{{ $announcement->created_at->translatedFormat('d M Y, H:i') }}</span>
                    </div>

                    @if ($announcement->expiry_date)
                        <div>
                            Berlaku hingga:
                            <span class="font-medium text-red-600">
                                {{ \Carbon\Carbon::parse($announcement->expiry_date)->translatedFormat('d M Y') }}
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Konten --}}
                <div class="text-gray-700 leading-relaxed mb-6">
                    {!! nl2br(e($announcement->content)) !!}
                </div>

                <a href="{{ route('home') }}"
                    class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition mt-4">
                    ← Kembali
                </a>
            </div>

            {{-- Kanan: Lampiran --}}
            @if ($announcement->attachment)
                @php
                    $filePath = secure_asset('storage/' . $announcement->attachment);
                    $isPdf = \Illuminate\Support\Str::endsWith($announcement->attachment, '.pdf');
                @endphp

                <div class="md:w-1/2 h-[600px] bg-white shadow rounded-xl overflow-hidden relative flex flex-col">
                    {{-- Loading Overlay --}}
                    <div id="fileLoader"
                        class="absolute inset-0 bg-white/80 backdrop-blur-sm flex flex-col items-center justify-center z-10">
                        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-b-4 border-blue-500 mb-3"></div>
                        <p class="text-gray-700 font-medium">Memuat...</p>
                    </div>

                    @if ($isPdf)
                        {{-- PDF Viewer --}}
                        <iframe id="fileViewer" src="{{ $filePath }}" class="w-full flex-1" frameborder="0"></iframe>
                        <div class="p-2 text-center bg-gray-100">
                            <button id="fullscreenBtn"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Fullscreen
                            </button>
                        </div>
                    @else
                        {{-- Gambar Viewer --}}
                        <img id="fileViewer" src="{{ $filePath }}" alt="Lampiran"
                            class="object-contain w-full h-full p-2">
                    @endif
                </div>

                {{-- Script --}}
                <script>
                    const fileViewer = document.getElementById('fileViewer');
                    const fileLoader = document.getElementById('fileLoader');
                    const fullscreenBtn = document.getElementById('fullscreenBtn');

                    // Hilangkan loader setelah file selesai dimuat
                    fileViewer.addEventListener('load', () => {
                        fileLoader.style.display = 'none';
                    });

                    // Tombol fullscreen (hanya jika PDF)
                    if (fullscreenBtn) {
                        fullscreenBtn.addEventListener('click', () => {
                            if (fileViewer.requestFullscreen) {
                                fileViewer.requestFullscreen();
                            } else if (fileViewer.webkitRequestFullscreen) {
                                fileViewer.webkitRequestFullscreen();
                            } else if (fileViewer.msRequestFullscreen) {
                                fileViewer.msRequestFullscreen();
                            }
                        });
                    }
                </script>
            @endif
        </div>
    </div>
@endsection
