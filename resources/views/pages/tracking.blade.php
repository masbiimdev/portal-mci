@extends('layouts.home')

@section('title', 'Tracking Jobcard')

@section('content')
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-blue-600 mb-6">
            Tracking Jobcard
        </h1>

        <!-- Search Box -->
        <div class="bg-white shadow-md rounded-lg p-5 border border-blue-100 mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-600">Cari Jobcard</label>
            <input type="text" id="searchBox" placeholder="Ketik Jobcard No atau ID..."
                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
        </div>

        <!-- Hasil pencarian -->
        <ul id="searchResults"
            class="mt-4 hidden bg-white border border-gray-200 rounded-lg shadow-md divide-y overflow-hidden"></ul>

        <!-- History Section -->
        <div id="historySection" class="mt-8 hidden">
            <div class="bg-white shadow-md rounded-lg p-5 border border-blue-100">
                <h2 class="text-2xl font-semibold text-blue-700 mb-4">
                    History Scan
                </h2>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-blue-50 text-blue-700">
                                <th class="px-4 py-2 text-left border">Operator</th>
                                <th class="px-4 py-2 text-left border">NIK</th>
                                <th class="px-4 py-2 text-left border">Departemen</th>
                                <th class="px-4 py-2 text-left border">Process</th>
                                <th class="px-4 py-2 text-left border">Keterangan</th>
                                <th class="px-4 py-2 text-left border">Action</th>
                                <th class="px-4 py-2 text-left border">Scan At</th>
                            </tr>
                        </thead>
                        <tbody id="historyTable" class="divide-y"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // Search
            $('#searchBox').on('keyup', function() {
                let q = $(this).val();
                if (q.length < 2) {
                    $('#searchResults').addClass('hidden').empty();
                    return;
                }

                $.get("{{ url('tracking/search') }}", {
                    q: q
                }, function(data) {
                    let html = '';
                    if (data.length > 0) {
                        data.forEach(jobcard => {
                            html += `
                                <li class="p-4 hover:bg-blue-50 cursor-pointer transition"
                                    onclick="loadHistory(${jobcard.id}, '${jobcard.jobcard_no}')">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="font-medium text-gray-700">${jobcard.jobcard_no}</span>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Dibuat: ${new Date(jobcard.created_at).toLocaleDateString('id-ID', {
                                                    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
                                                    hour: '2-digit', minute: '2-digit'
                                                })}
                                            </div>
                                        </div>
                                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">ID: ${jobcard.id}</span>
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

        // Load History
        function loadHistory(jobcardId, jobcardNo) {
            $.get(`{{ url('tracking') }}/${jobcardId}/history`, function(data) {
                let html = '';
                if (data.length > 0) {
                    data.forEach(h => {
                        let badge = h.action === 'Scan In' ?
                            `<span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">IN</span>` :
                            `<span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">OUT</span>`;

                        // Format tanggal ke Indonesia
                        let date = new Date(h.scanned_at);
                        let options = {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        };
                        let formattedDate = date.toLocaleDateString('id-ID', options);

                        html += `
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-2 border">${h.user ? h.user.name : '-'}</td>
                        <td class="px-4 py-2 border">${h.user ? h.user.nik : '-'}</td>
                        <td class="px-4 py-2 border">${h.user ? h.user.departemen : '-'}</td>
                        <td class="px-4 py-2 border">${h.process_name ? h.process_name : '-'}</td>
                        <td class="px-4 py-2 border">${h.remarks ? h.remarks : '-'}</td>
                        <td class="px-4 py-2 border">${badge}</td>
                        <td class="px-4 py-2 border">${formattedDate}</td>
                    </tr>`;
                    });
                } else {
                    html = `<tr><td colspan="7" class="text-center py-4 text-gray-500">Belum ada history</td></tr>`;
                }

                $('#historyTable').html(html);
                $('#historySection').removeClass('hidden')
                    .find('h2').html(`History Scan - <span class="text-blue-500">${jobcardNo}</span>`);
                $('#searchResults').addClass('hidden');
            });
        }
    </script>
@endsection
