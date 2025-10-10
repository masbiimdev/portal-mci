@extends('layouts.admin')
@section('title')
    Dashboard | Main
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-3 d-flex align-items-stretch">
            <!-- Card Total Jobcard -->
            <div class="col-12 col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column">
                        <!-- Header: Title + Button -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-muted mb-0">Total Jobcard</h6>
                            <a href="{{ route('jobcards.index') }}" class="btn btn-sm btn-outline-primary">
                                Detail
                            </a>
                        </div>
                        <!-- Main Content: Number -->
                        <h3 class="fw-bold">{{ $totalMachining + $totalAssembling }} Job Card</h3>
                    </div>
                </div>
            </div>

            <!-- Card Total Users -->
            <div class="col-12 col-md-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body d-flex flex-column">
                        <!-- Header: Title + Button -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-muted mb-0">Total Users</h6>
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary">
                                Detail
                            </a>
                        </div>
                        <!-- Main Content: Number -->
                        <h3 class="fw-bold">{{ $totalUsers }} User</h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- Optional Chart Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="bx bx-bar-chart-alt-2 text-info"></i> Jobcard Summary (Monthly)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="jobcardChart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari controller
            const chartData = @json($monthlyData);

            // Ambil nama bulan dan jumlah jobcard
            const months = chartData.map(item => item.month_name);
            const machining = chartData.map(item => item.machining);
            const assembling = chartData.map(item => item.assembling);

            const options = {
                chart: {
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: false
                    },
                },
                series: [{
                        name: 'Machining',
                        data: machining
                    },
                    {
                        name: 'Assembling',
                        data: assembling
                    }
                ],
                xaxis: {
                    categories: months,
                    title: {
                        text: 'Bulan'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Jobcard'
                    },
                    min: 0,
                    forceNiceScale: true
                },
                colors: ['#007bff', '#28a745'],
                legend: {
                    position: 'top'
                },
                dataLabels: {
                    enabled: true
                },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        horizontal: false,
                        columnWidth: '30%'
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " Jobcard";
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#jobcardChart"), options);
            chart.render();
        });
    </script>
@endsection
