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
    <li>
      <a href="{{ route('announcements.index') }}" class="flex items-center text-blue-600 hover:underline">
        Pengumuman
      </a>
    </li>
    <li>/</li>
    <li class="text-gray-400">Detail</li>
  </ol>
</nav>


    <div class="md:flex md:space-x-6 gap-6">
        {{-- Kiri: Detail Pengumuman --}}
        <div class="md:w-1/2 bg-white shadow rounded-xl p-6 md:p-8 mb-6 md:mb-0">
            {{-- Judul --}}
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">{{ $announcement->title }}</h2>

            {{-- Info --}}
            <div class="flex flex-wrap gap-2 mb-4">
                <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800">
                    Jenis: {{ ucfirst($announcement->type) }}
                </span>
                <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                    Departemen: {{ $announcement->department ?? 'Semua' }}
                </span>
                <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800 flex items-center">
                    Prioritas: 
                    @php
                        $priorityColors = [
                            'low' => 'bg-green-200 text-green-800',
                            'medium' => 'bg-yellow-200 text-yellow-800',
                            'high' => 'bg-red-200 text-red-800',
                        ];
                    @endphp
                    <span class="ml-2 px-2 py-1 rounded {{ $priorityColors[$announcement->priority] ?? 'bg-gray-200' }}">
                        {{ ucfirst($announcement->priority) }}
                    </span>
                </span>
                <span class="px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800">
                    Status: 
                    @if ($announcement->is_active)
                        <span class="text-green-700 font-semibold">Aktif</span>
                    @else
                        <span class="text-gray-500 font-semibold">Nonaktif</span>
                    @endif
                </span>
            </div>

            {{-- Tanggal --}}
            <div class="text-gray-500 text-sm mb-6 space-y-1">
                <p>Dibuat oleh: <span class="font-medium">{{ $announcement->author->name ?? 'Admin' }}</span></p>
                <p>Tanggal dibuat: <span class="font-medium">{{ $announcement->created_at->translatedFormat('d M Y, H:i') }}</span></p>
                @if($announcement->expiry_date)
                    <p>Berlaku hingga: <span class="font-medium">{{ \Carbon\Carbon::parse($announcement->expiry_date)->translatedFormat('d M Y') }}</span></p>
                @endif
            </div>

            {{-- Konten --}}
            <div class="text-gray-700 leading-relaxed mb-6">
                {!! nl2br(e($announcement->content)) !!}
            </div>

            {{-- Kembali --}}
            <a href="{{ route('announcements.index') }}"
               class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition mt-4">
               ← Kembali
            </a>
        </div>

        {{-- Kanan: Preview PDF --}}
        @if($announcement->attachment && Str::endsWith($announcement->attachment, '.pdf'))
            <div class="md:w-1/2 h-[600px] bg-white shadow rounded-xl overflow-hidden">
                <iframe src="{{ asset('storage/'.$announcement->attachment) }}" 
                        class="w-full h-full" frameborder="0"></iframe>
            </div>
        @endif
    </div>
</div>
@endsection

