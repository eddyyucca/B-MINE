@extends('layouts.main')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-chart-line"></i> Summary Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-8">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-4">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>22</h3>
                                <p>Total of All Units</p>
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
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>22</h3>

                                <p>Unit Ready</p>
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
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>22</h3>

                                <p>Unit Ready</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <a href="" class="small-box-footer">View Data <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-md-4">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>22</h3>
                                <p>2 Months to Re-Commissioning</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <a href="" class="small-box-footer">View Data <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-md-4">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>22</h3>
                                <p>1 Months to Re-Commissioning</p>
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
                                <p>Expired Unit</p>
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
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>22</h3>
                                <p>Follow Up Unit</p>
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
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>22</h3>
                                <p>Follow Up Unit</p>
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
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>22</h3>
                                <p>Follow Up Unit</p>
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
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Donut Chart Status Unit</h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="myDonutChart" width="600" height="370"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Achievement of Follow-Up Commissioning Deviation</h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="barChart">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-widget widget-user-2 shadow-sm">
                    <div class="widget-user-header bg-success">
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" src="dist/img/pie-chart.png" alt="User Avatar">
                        </div>
                        <h3 class="widget-user-username">All Unit</h3>
                        <h5 class="widget-user-desc">Expired And Safe</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Hauler
                                    <span class="float-right badge bg-success">22</span>
                                    <span class="float-right badge">/</span>
                                    <span class="float-right badge bg-danger">22</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Digger
                                    <span class="float-right badge bg-success">22</span>
                                    <span class="float-right badge">/</span>
                                    <span class="float-right badge bg-danger">22</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    Support
                                    <span class="float-right badge bg-success">22</span>
                                    <span class="float-right badge">/</span>
                                    <span class="float-right badge bg-danger">22</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    SGE
                                    <span class="float-right badge bg-success">22</span>
                                    <span class="float-right badge">/</span>
                                    <span class="float-right badge bg-danger">22</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    All Unit
                                    <span class="float-right badge bg-success">22</span>
                                    <span class="float-right badge">/</span>
                                    <span class="float-right badge bg-danger">22</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    @endsection

    @section('scripts')
        <script>
            var donutChartCanvas = $('#myDonutChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Chrome',
                    'IE',
                    'FireFox',
                    'Safari',
                    'Opera',
                    'Navigator',
                ],
                datasets: [{
                    data: [700, 500, 400, 600, 300, 100],
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })
        </script>
    @endsection
