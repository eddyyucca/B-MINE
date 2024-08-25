@extends('layouts.main')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Simper & Minepermit Boxes -->
            <div class="row mt-2">
                <!-- SIMPER -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>1</h3>
                            <p>SUBMISSION</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
                <!-- Minepermit -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>2</h3>
                            <p>SUBMISSION</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                    </div>
                </div>
                <!-- Outstanding Proses -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>6</h3>
                            <p>BEC Proses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-sync"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-light">
                        <div class="inner">
                            <h3>12</h3>
                            <p>KTT Proses</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-sync"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trend Simper & Minepermit -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">The trend of Simper & Minepermit</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="simperMinepermitChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('simperMinepermitChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['JAN', 'FEB', 'MAR', 'APR', 'MEI'],
                datasets: [{
                        label: 'SIMPER',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        data: [3, 4, 5, 2, 3],
                        fill: true
                    },
                    {
                        label: 'MINEPERMIT',
                        backgroundColor: 'rgba(210,214,222,1)',
                        borderColor: 'rgba(210,214,222,1)',
                        data: [1, 3, 4, 6, 2],
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endsection
