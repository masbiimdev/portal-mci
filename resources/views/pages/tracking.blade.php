@extends('layouts.home')

@section('title', 'MCI | Tracking Jobcard')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-3xl font-bold text-blue-700 tracking-tight mb-2">🔍 Tracking Jobcard</h1>
        <p class="text-gray-500 text-sm">Cari dan lihat riwayat proses setiap Jobcard secara real-time</p>
    </div>

    <!-- Search Box -->
    <div class="bg-white shadow-sm border border-blue-100 rounded-xl p-6 mb-8 transition hover:shadow-md">
        <label class="block mb-2 text-sm font-semibold text-gray-600">Cari Jobcard</label>
        <div class="relative">
            <input type="text" id="searchBox" placeholder="Ketik Jobcard No atau ID..."
                class="w-full border rounded-lg px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition text-gray-700 placeholder-gray-400">
            <svg class="w-5 h-5 absolute right-3 top-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Search Results -->
    <ul id="searchResults"
        class="mt-4 hidden bg-white border border-gray-200 rounded-xl shadow-sm divide-y overflow-hidden"></ul>

    <!-- History Section -->
    <div id="historySection" class="mt-10 hidden">
        <div class="bg-white border border-blue-100 shadow-sm rounded-xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-blue-700">
                    History Scan
                </h2>
                <button onclick="closeHistory()"
                    class="text-xs text-red-500 hover:underline">Tutup</button>
            </div>

            <div class="overflow-x-auto rounded-lg border border-gray-200">
                <table class="w-full text-sm text-gray-700">
                    <thead class="bg-blue-50 text-blue-700 text-xs uppercase tracking-wide">
                        <tr>
                            <th class="px-4 py-2 text-left border">Operator</th>
                            <th class="px-4 py-2 text-left border">NIK</th>
                            <th class="px-4 py-2 text-left border">Departemen</th>
                            <th class="px-4 py-2 text-left border">Process</th>
                            <th class="px-4 py-2 text-left border">Keterangan</th>
                            <th class="px-4 py-2 text-left border text-center">Action</th>
                            <th class="px-4 py-2 text-left border">Scan At</th>
                        </tr>
                    </thead>
                    <tbody id="historyTable" class="divide-y bg-white"></tbody>
                </table>
            </div>
            <p id="lastUpdate" class="text-xs text-gray-400 mt-2 text-right italic"></p>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let currentJobcardId = null;
let currentJobcardNo = null;
let refreshInterval = null;

// 🔍 Search handler
$(function () {
    $('#searchBox').on('keyup', function () {
        const q = $(this).val().trim();
        if (q.length < 2) {
            $('#searchResults').addClass('hidden').empty();
            return;
        }

        $.get(`/tracking/search`, { q }, function (data) {
            let html = '';
            if (data.length > 0) {
                data.forEach(jobcard => {
                    html += `
                        <li class="p-4 hover:bg-blue-50 cursor-pointer transition"
                            onclick="loadHistory(${jobcard.id}, '${jobcard.jobcard_id}')">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="font-medium text-gray-800">${jobcard.jobcard_id}</span>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Dibuat: ${new Date(jobcard.created_at).toLocaleDateString('id-ID', {
                                            weekday: 'long',
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric',
                                            hour: '2-digit',
                                            minute: '2-digit'
                                        })}
                                    </div>
                                </div>
                            </div>
                        </li>`;
                });
            } else {
                html = '<li class="p-4 text-gray-500 text-center">Tidak ditemukan</li>';
            }
            $('#searchResults').removeClass('hidden').html(html);
        });
    });
});

// 📊 Load jobcard history
function loadHistory(jobcardId, jobcardNo) {
    currentJobcardId = jobcardId;
    currentJobcardNo = jobcardNo;
    fetchHistory();

    // 🚀 Realtime update setiap 5 detik
    if (refreshInterval) clearInterval(refreshInterval);
    refreshInterval = setInterval(fetchHistory, 5000);
}

function fetchHistory() {
    if (!currentJobcardId) return;

    $.get(`/tracking/${currentJobcardId}/history`, function (data) {
        let html = '';
        if (data.length > 0) {
            data.forEach(h => {
                const badge = h.action === 'Scan In'
                    ? `<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">IN</span>`
                    : `<span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">OUT</span>`;

                const date = new Date(h.scanned_at).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                html += `
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-2 border">${h.user?.name ?? '-'}</td>
                        <td class="px-4 py-2 border">${h.user?.nik ?? '-'}</td>
                        <td class="px-4 py-2 border">${h.user?.departemen ?? '-'}</td>
                        <td class="px-4 py-2 border">${h.process_name ?? '-'}</td>
                        <td class="px-4 py-2 border">${h.remarks ?? '-'}</td>
                        <td class="px-4 py-2 border text-center">${badge}</td>
                        <td class="px-4 py-2 border">${date}</td>
                    </tr>`;
            });
        } else {
            html = `<tr><td colspan="7" class="text-center py-4 text-gray-500">Belum ada history</td></tr>`;
        }

        $('#historyTable').html(html);
        $('#historySection').removeClass('hidden')
            .find('h2')
            .html(`History Scan - <span class="text-blue-500 font-semibold">${currentJobcardNo}</span>`);
        $('#searchResults').addClass('hidden');

        const now = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        $('#lastUpdate').text(`Terakhir diperbarui: ${now}`);
    });
}

// 🔴 Tutup history dan hentikan realtime
function closeHistory() {
    $('#historySection').addClass('hidden');
    if (refreshInterval) clearInterval(refreshInterval);
    currentJobcardId = null;
}
</script>
@endsection
