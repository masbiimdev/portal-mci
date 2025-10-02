@extends('layouts.home')
@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Selamat Datang di ERP System</h1>
            <p class="text-lg md:text-xl text-blue-200">Kelola jadwal, dokumen, dan informasi penting dengan mudah.</p>
        </div>
    </section>
{{-- 
    <!-- Quick Access -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-6">
            <a href="/schedule"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <i data-feather="calendar" class="w-8 h-8 text-blue-600 mb-3"></i>
                <h3 class="font-semibold">Jadwal</h3>
                <p class="text-sm text-gray-600">Lihat dan kelola jadwal kegiatan.</p>
            </a>
            <a href="/dokumen"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <i data-feather="folder" class="w-8 h-8 text-blue-600 mb-3"></i>
                <h3 class="font-semibold">Dokumen</h3>
                <p class="text-sm text-gray-600">Akses dokumen penting dengan mudah.</p>
            </a>
            <a href="/statistik"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <i data-feather="bar-chart-2" class="w-8 h-8 text-blue-600 mb-3"></i>
                <h3 class="font-semibold">Statistik</h3>
                <p class="text-sm text-gray-600">Pantau progres dengan grafik interaktif.</p>
            </a>
            <a href="/profil"
                class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <i data-feather="user" class="w-8 h-8 text-blue-600 mb-3"></i>
                <h3 class="font-semibold">Profil</h3>
                <p class="text-sm text-gray-600">Kelola akun dan preferensi Anda.</p>
            </a>
        </div>
    </section> --}}

    <!-- Pengumuman Terbaru (Statik) -->
    <section class="py-12 max-w-7xl mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6">Pengumuman Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <h3 class="font-semibold text-lg mb-2">Maintenance ERP System</h3>
                <p class="text-sm text-gray-600 mb-2">Sistem ERP akan offline pada Sabtu, 5 Oktober 2025, pukul 01.00 -
                    05.00 WIB.</p>
                <p class="text-xs text-gray-400 mb-2">Dibuat oleh: Admin IT</p>
                <p class="text-xs text-gray-400">Periode: 5 Okt 2025</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <h3 class="font-semibold text-lg mb-2">Training Pengguna Baru</h3>
                <p class="text-sm text-gray-600 mb-2">Training ERP untuk karyawan baru akan dilaksanakan pada Senin, 7
                    Oktober 2025.</p>
                <p class="text-xs text-gray-400 mb-2">Dibuat oleh: HR</p>
                <p class="text-xs text-gray-400">Periode: 7 Okt 2025</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                <h3 class="font-semibold text-lg mb-2">Update Fitur Statistik</h3>
                <p class="text-sm text-gray-600 mb-2">Fitur statistik telah diperbarui dengan grafik interaktif baru.</p>
                <p class="text-xs text-gray-400 mb-2">Dibuat oleh: Tim Development</p>
                <p class="text-xs text-gray-400">Periode: 1 Okt 2025</p>
            </div>
        </div>
    </section>

    <!-- Hal Menarik Lainnya -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-2xl font-bold mb-6">Hal Menarik Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                    <h3 class="font-semibold">Tips & Trik</h3>
                    <p class="text-sm text-gray-600">Pelajari cara memaksimalkan penggunaan ERP system.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                    <h3 class="font-semibold">Fitur Baru</h3>
                    <p class="text-sm text-gray-600">Temukan fitur terbaru untuk produktivitas lebih tinggi.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                    <h3 class="font-semibold">Laporan Cepat</h3>
                    <p class="text-sm text-gray-600">Dapatkan ringkasan laporan harian dan mingguan.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition transform hover:-translate-y-1">
                    <h3 class="font-semibold">Support</h3>
                    <p class="text-sm text-gray-600">Hubungi tim support jika mengalami kendala.</p>
                </div>
            </div>
        </div>
    </section>

    </section>
@endsection
