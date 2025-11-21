@extends('layouts.home')

@section('title', 'MCI | Portal Kalibrasi')

@section('content')

<div class="max-w-7xl mx-auto py-10 px-4">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-blue-700 tracking-tight mb-2">🛠️ Portal Kalibrasi</h1>
        <p class="text-gray-500 text-sm sm:text-base">Pantau status kalibrasi alat, jadwal ulang, dan ringkasan status alat secara real-time.</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $statusOk = $statusOk ?? 0;
            $statusProses = $statusProses ?? 0;
            $dueSoon = $dueSoon ?? 0;
            $totalTools = $totalTools ?? 0;
        @endphp

        <div class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
            <p class="text-sm text-gray-500 mb-1">Total Alat</p>
            <h3 class="text-2xl font-bold text-blue-700">{{ $totalTools }}</h3>
        </div>

        <div class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
            <p class="text-sm text-gray-500 mb-1">Status OK</p>
            <h3 class="text-2xl font-bold text-green-700">{{ $statusOk }}</h3>
        </div>

        <div class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
            <p class="text-sm text-gray-500 mb-1">Proses Kalibrasi</p>
            <h3 class="text-2xl font-bold text-yellow-500">{{ $statusProses }}</h3>
        </div>

        <div class="summary-card bg-white border border-blue-100 rounded-xl shadow p-5 text-center">
            <p class="text-sm text-gray-500 mb-1">Akan Jatuh Tempo < 30 Hari</p>
            <h3 class="text-2xl font-bold text-red-600">{{ $dueSoon }}</h3>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white border border-blue-100 shadow rounded-xl p-6">
        <h2 class="text-lg font-semibold text-blue-700 mb-4">📋 Data Alat</h2>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full text-sm text-gray-700 border-collapse">
                <thead class="bg-gradient-to-r from-blue-600 to-blue-500 text-white text-xs uppercase tracking-wide">
                    <tr>
                        <th class="px-4 py-3 text-left w-12">No</th>
                        <th class="px-4 py-3 text-left">Nama Item</th>
                        <th class="px-4 py-3 text-left">Merk</th>
                        <th class="px-4 py-3 text-left">Status Kalibrasi</th>
                        <th class="px-4 py-3 text-left">Tanggal Kalibrasi</th>
                        <th class="px-4 py-3 text-left">Tanggal Kalibrasi Ulang</th>
                        <th class="px-4 py-3 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($tools as $index => $tool)
                        @php
                            $history = $tool->latestHistory;
                            $status = optional($history)->status_kalibrasi ?? '-';

                            if($status == 'OK') {
                                $statusClass = 'bg-green-50 text-green-700';
                            } elseif($status == 'Proses') {
                                $statusClass = 'bg-yellow-50 text-yellow-700';
                            } elseif($status == 'Jatuh Tempo') {
                                $statusClass = 'bg-red-50 text-red-700';
                            } else {
                                $statusClass = 'bg-gray-50 text-gray-700';
                            }
                        @endphp
                        <tr class="hover:bg-blue-50 transition">
                            <td class="px-4 py-3 border align-top">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 border align-top">{{ $tool->nama_alat }}</td>
                            <td class="px-4 py-3 border align-top">{{ $tool->merek }}</td>
                            <td class="px-4 py-3 border align-top">
                                <span class="inline-block px-2 py-0.5 rounded text-sm font-medium {{ $statusClass }}">
                                    {{ $status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 border align-top">
                                {{ optional($history)->tgl_kalibrasi ? \Carbon\Carbon::parse($history->tgl_kalibrasi)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 border align-top">
                                {{ optional($history)->tgl_kalibrasi_ulang ? \Carbon\Carbon::parse($history->tgl_kalibrasi_ulang)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-3 border align-top">{{ optional($history)->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-gray-400">Tidak ada data alat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- <!-- Chart -->
    <div class="bg-white border border-blue-100 shadow rounded-xl p-6 mt-6">
        <h2 class="text-lg font-semibold text-blue-700 mb-4">📈 Grafik Status Alat</h2>
        <div class="h-72 sm:h-96">
            <canvas id="kalibrasiChart"></canvas>
        </div>
    </div> --}}
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const pieData = @json($pieData ?? ['ok'=>0,'proses'=>0,'due'=>0]);
    const ctx = document.getElementById('kalibrasiChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['OK', 'Proses', 'Jatuh Tempo'],
            datasets: [{
                data: [pieData.ok, pieData.proses, pieData.due],
                backgroundColor: ['#16a34a','#f59e0b','#dc2626']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed;
                        }
                    }
                }
            }
        }
    });
</script>

@endsection
