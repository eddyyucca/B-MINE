@extends('layouts.main')

@section('content')
    <style>
        .chart {
            width: 100%;
            /* Membuat elemen chart selebar div card-body */
            height: 100%;
            /* Membuat chart (canvas) setinggi card-body */
            display: flex;
            /* Flexbox digunakan agar konten dalamnya bisa mengisi tinggi penuh */
            justify-content: center;
            align-items: center;
        }

        #myDonutChart {
            width: 100%;
            /* Lebar canvas mengikuti lebar induknya */
            height: 100%;
            /* Tinggi canvas mengikuti tinggi induknya */
        }

        .card-body {
            height: 68vh;
            /* Membuat card-body memiliki tinggi penuh dari viewport, sesuaikan dengan kebutuhan */
        }
    </style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-8">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="m-2"><i class="fas fa-chart-line"></i> <b>Simper</b>
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>Total Submission</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>1 Months to Expired</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>2 Months to Expired</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h1 class="m-2"><i class="fas fa-chart-line"></i> <b>Mine Permit</b>
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>Total Submission</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>1 Months to Expired</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>2 Months to Expired</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <h1 class="m-2"><i class="fas fa-chart-line"></i> <b>Outstanding Process</b>
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>Total Outstanding</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>SHE Prosess</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>PJO Prosess</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>BEC Prosess</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>KTT Prosess</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="col-sm-12">
                        <h4 class="m-2"><i class="fas fa-chart-line"></i> <b>Total Mine Permit & Simper</b></h4>
                    </div><!-- /.col -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Donut Chart Simper & Mine Permit</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="myDonutChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Outstanding Submission Simper & Mine Permit</h3>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart">
                                <canvas id="simperMinePermitChart" width="auto" height="auto"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        //--------------
        //- AREA CHART -
        //--------------

        // Get context with jQuery - using jQuery's .get() method.
        var ctx = document.getElementById('simperMinePermitChart').getContext('2d');

        var simperMinePermitChart = new Chart(ctx, {
            type: 'line', // Menggunakan line chart untuk menampilkan trend
            data: {
                labels: [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ], // Label bulan dalam setahun
                datasets: [{
                        label: 'Pengajuan SIMPER', // Label untuk SIMPER
                        data: [70, 26, 33, 32, 99, 45, 65, 9, 87, 33, 54, 66,
                            90
                        ], // Data pengajuan SIMPER bulanan
                        borderColor: '#3498db', // Warna biru untuk SIMPER
                        fill: false, // Garis tanpa fill
                        tension: 0.1 // Smooth curve di antara titik
                    },
                    {
                        label: 'Pengajuan Mine Permit', // Label untuk Mine Permit
                        data: [32, 44, 55, 33, 43, 54, 65, 22, 22, 33, 44,
                            5
                        ], // Data pengajuan Mine Permit bulanan
                        borderColor: '#00a65a', // Warna hijau untuk Mine Permit
                        fill: true, // Garis tanpa fill
                        tension: 0.1 // Smooth curve di antara titik
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: { // Konfigurasi untuk sumbu X (bulan)
                        title: {
                            display: true,
                            text: 'Bulan' // Label sumbu X
                        }
                    },
                    y: { // Konfigurasi untuk sumbu Y (jumlah pengajuan)
                        beginAtZero: true, // Memulai sumbu Y dari nol
                        title: {
                            display: true,
                            text: 'Jumlah Pengajuan' // Label sumbu Y
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true, // Tampilkan label legend
                    }
                }
            }
        });

        // donat
        var donutChartCanvas = $('#myDonutChart').get(0).getContext('2d')
        var donutData = {
            labels: [
                'SIMPER',
                'Mine Permit',
            ],
            datasets: [{
                data: [{{ $simper }},
                    {{ $minepermit }}
                ], // Ganti dengan data SIMPER dan Mine Permit Anda
                backgroundColor: ['#3498db', '#00a65a'], // Warna untuk SIMPER dan Mine Permit
            }]
        }
        var donutOptions = {
            maintainAspectRatio: false,
            responsive: true,
        }
        // Create doughnut chart
        new Chart(donutChartCanvas, {
            type: 'doughnut',
            data: donutData,
            options: donutOptions
        })
    </script>
@endsection
