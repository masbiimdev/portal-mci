@extends('layouts.admin')
@section('title')
    Dashboard | Main
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">
            <div class="col-12 col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="text-muted mb-1">Total Jobcard</h6>
                                <h3 class="fw-bold text-dark mb-0">
                                    {{ $totalMachining + $totalAssembling }}
                                    <span class="fs-6 text-secondary fw-normal">jobcards</span>
                                </h3>
                            </div>
                            <a href="{{ route('jobcards.index') }}" class="btn btn-sm btn-outline-primary">
                                Detail <i class="bx bx-right-arrow-alt"></i>
                            </a>
                        </div>

                        <div class="row text-center mt-4">
                            <div class="col-md-6 mb-3 mb-md-0 border-end">
                                <h5 class="text-primary fw-bold mb-1">{{ $totalMachining }}</h5>
                                <p class="text-muted mb-0">
                                    <i class="bx bx-cog bx-spin text-primary"></i> Machining
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-success fw-bold mb-1">{{ $totalAssembling }}</h5>
                                <p class="text-muted mb-0">
                                    <i class="bx bx-wrench text-success bx-tada"></i> Assembling
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 px-3">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ ($totalMachining / max($totalMachining + $totalAssembling, 1)) * 100 }}%">
                                </div>
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ ($totalAssembling / max($totalMachining + $totalAssembling, 1)) * 100 }}%">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between small text-muted mt-1">
                                <span>Machining</span>
                                <span>Assembling</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="text-muted mb-1">Total Users</h6>
                                <h3 class="fw-bold text-dark mb-0">
                                    {{ $totalUsers }}
                                    <span class="fs-6 text-secondary fw-normal">users</span>
                                </h3>
                            </div>
                            <a href="{{ route('users.index') }}" class="btn btn-sm btn-outline-primary">
                                Detail <i class="bx bx-right-arrow-alt"></i>
                            </a>
                        </div>

                        <div class="row text-center mt-4">
                            @php
                                $departments = [
                                    'QC' => $engineeringCount ?? 0,
                                    'Assembling' => $productionCount ?? 0,
                                    'Machining' => $qaCount ?? 0,
                                    'Packing' => $adminCount ?? 0,
                                ];

                                $colors = [
                                    'QC' => 'text-primary',
                                    'Assembling' => 'text-success',
                                    'Machining' => 'text-warning',
                                    'Packing' => 'text-danger',
                                ];

                                $icons = [
                                    'QC' => 'bx bx-search-alt-2 bx-tada',
                                    'Assembling' => 'bx bx-cog bx-spin',
                                    'Machining' => 'bx bx-wrench bx-tada',
                                    'Packing' => 'bx bx-package bx-tada',
                                ];

                                $totalUsers = array_sum($departments);
                            @endphp

                            @foreach ($departments as $dept => $count)
                                <div class="col-6 mb-3 mb-md-0 border-end">
                                    <h5 class="fw-bold mb-1 {{ $colors[$dept] }}">{{ $count }}</h5>
                                    <p class="text-muted mb-0">
                                        <i class="{{ $icons[$dept] }} {{ $colors[$dept] }} fs-5 me-1"></i>
                                        {{ $dept }}
                                    </p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 px-3">
                            <div class="progress" style="height: 8px;">
                                @foreach ($departments as $dept => $count)
                                    <div class="progress-bar {{ $colors[$dept] }}" role="progressbar"
                                        style="width: {{ ($count / max($totalUsers, 1)) * 100 }}%"></div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between small text-muted mt-1">
                                @foreach ($departments as $dept => $count)
                                    <span>{{ $dept }}</span>
                                @endforeach
                            </div>
                        </div>
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
