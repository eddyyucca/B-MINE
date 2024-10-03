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
                        <div class="col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>Total Pengajuan</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
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


                        <div class="col-sm-12">
                            <h1 class="m-2"><i class="fas fa-chart-line"></i> <b>Mine Permit</b>
                            </h1>
                        </div><!-- /.col -->
                        <div class="col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>Pengajuan Total</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar"></i>
                                </div>
                                <a href="" class="small-box-footer">View Data <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-warning">
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


                        <div class="col-sm-12">
                            <h1 class="m-2"><i class="fas fa-chart-line"></i> <b>Total Outstanding</b>
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
                        <div class="col-md-4">
                            <!-- small box -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>22</h3>
                                    <p>BEC Proses</p>
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
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Perusahaan</th>
                                        <th>Jabatan</th>
                                        <th>Section</th>
                                        <th class="no-export">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>1234567890</td>
                                        <td>Ahmad Fauzi</td>
                                        <td>Buma</td>
                                        <td>Manager</td>
                                        <td>Finance</td>
                                        <td align="center" class="no-export">
                                            <button id="openPdfButton" class="btn btn-primary"><i
                                                    class="far fa-eye"></i></button>
                                            <a href="" class="btn btn-success"> <i class="fas fa-check"></i></a>
                                            <a href="" class="btn btn-danger"> <i class="fas fa-times"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>9876543210</td>
                                        <td>Siti Aisyah</td>
                                        <td>Buma</td>
                                        <td>Supervisor</td>
                                        <td>HRD</td>
                                        <td align="center" class="no-export">
                                            <button id="openPdfButton" class="btn btn-primary"><i
                                                    class="far fa-eye"></i></button>
                                            <a href="" class="btn btn-success"> <i class="fas fa-check"></i></a>
                                            <a href="" class="btn btn-danger"> <i class="fas fa-times"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>5678901234</td>
                                        <td>Budi Santoso</td>
                                        <td>PT. Sukses Selalu</td>
                                        <td>Staff</td>
                                        <td>IT</td>
                                        <td align="center" class="no-export">
                                            <button id="openPdfButton" class="btn btn-primary"><i
                                                    class="far fa-eye"></i></button>
                                            <a href="" class="btn btn-success"> <i class="fas fa-check"></i></a>
                                            <a href="" class="btn btn-danger"> <i class="fas fa-times"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        document.getElementById('openPdfButton').addEventListener('click', function() {
            var pdfUrl = '{{ asset('storage/data/view_data.pdf') }}'; // Path ke PDF yang akan dibuka
            window.open(pdfUrl, '_blank'); // Membuka di tab baru
        });
    </script>
    <script>
        //--------------
        //- DONAT CHART -
        //--------------

        var donutChartCanvas = $('#myDonutChart').get(0).getContext('2d')
        var donutData = {
            labels: [
                'SIMPER',
                'Mine Permit',
            ],
            datasets: [{
                data: [200, 200], // Ganti dengan data SIMPER dan Mine Permit Anda
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
