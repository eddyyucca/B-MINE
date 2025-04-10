@extends('layouts.main')

@section('content')
    <style>
        /* Mengatur styling seluruh content area */
        .dashboard-content {
            background-color: #f8f9fa;
            padding: 15px 30px;
        }

        /* Styling untuk section titles */
        .section-title {
            color: #495057;
            font-weight: 600;
            font-size: 20px;
            margin: 25px 10px 20px 0;
            display: flex;
            align-items: center;
            border-left: 4px solid #3f6791;
            padding-left: 15px;
        }

        .section-title i {
            margin-right: 10px;
            color: #6c757d;
        }

        /* Stats Card Styling */
        .stats-card {
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: transform 0.3s;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-card-body {
            padding: 20px;
            flex-grow: 1;
            position: relative;
            color: white;
        }

        .stats-card h3 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stats-card p {
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 0;
        }

        .stats-card .icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 40px;
            opacity: 0.4;
        }

        .stats-card-footer {
            padding: 10px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.1);
        }

        .stats-card-footer a {
            color: white;
            text-decoration: none;
            display: block;
        }

        .stats-card-footer a:hover {
            opacity: 0.9;
        }

        /* Background Colors */
        .bg-green {
            background-color: #28a745;
        }

        .bg-yellow {
            background-color: #ffc107;
        }

        .bg-red {
            background-color: #dc3545;
        }

        .bg-blue {
            background-color: #007bff;
        }

        .bg-teal {
            background-color: #17a2b8;
        }

        .bg-gray {
            background-color: #6c757d;
        }

        /* Chart Container Styling */
        .chart-container {
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }

        .chart-header {
            background-color: #28a745;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chart-header h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .chart-header .btn-collapse {
            background: none;
            border: none;
            color: white;
            padding: 0;
        }

        .chart-body {
            padding: 20px;
        }

        .chart-footer {
            padding: 15px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
        }

        .year-selector {
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            width: 120px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dashboard-content {
                padding: 10px;
            }

            .stats-card h3 {
                font-size: 2rem;
            }
        }

        /* Loading indicator styles */
        .loading-spinner {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading-spinner i {
            font-size: 24px;
            color: #007bff;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <div class="dashboard-content">
        <!-- SIMPER Section -->
        <div class="section-title">
            <i class="fas fa-id-card"></i> SIMPER
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-card-body bg-green">
                        <h3>{{ $simper_data ?? 0 }}</h3>
                        <p>TOTAL SUBMISSION</p>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-green">
                        <a href="#">View Data <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-card-body bg-yellow">
                        <h3>{{ $simper_oneMonthToExpire }}</h3>
                        <p>1 MONTH TO EXPIRE</p>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-yellow">
                        <a href="#">View Data <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-card-body bg-red">
                        <h3>{{ $simper_twoMonthsToExpire }}</h3>
                        <p>2 MONTHS TO EXPIRE</p>
                        <div class="icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-red">
                        <a href="#">View Data <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- MINE PERMIT Section -->
        <div class="section-title">
            <i class="fas fa-hard-hat"></i> MINE PERMIT
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-card-body bg-green">
                        <h3>{{ $minepermit_data ?? 3 }}</h3>
                        <p>TOTAL SUBMISSION</p>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-green">
                        <a href="#">View Data <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-card-body bg-yellow">
                        <h3>{{ $minepermit_oneMonthToExpire }}</h3>
                        <p>1 MONTH TO EXPIRE</p>
                        <div class="icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-yellow">
                        <a href="#">View Data <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <div class="stats-card-body bg-red">
                        <h3>{{ $minepermit_twoMonthsToExpire }}</h3>
                        <p>2 MONTHS TO EXPIRE</p>
                        <div class="icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-red">
                        <a href="#">View Data <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- OUTSTANDING PROCESS Section -->
        <div class="section-title">
            <i class="fas fa-tasks"></i> OUTSTANDING PROCESS
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="stats-card">
                    <div class="stats-card-body bg-blue">
                        <h3>{{ $totaloutstanding ?? 3 }}</h3>
                        <p>TOTAL OUTSTANDING</p>
                        <div class="icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-blue">
                        <a href="#">View <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card">
                    <div class="stats-card-body bg-teal">
                        <h3>{{ $sheprosess ?? 3 }}</h3>
                        <p>SHE PROCESS</p>
                        <div class="icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-teal">
                        <a href="#">View <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card">
                    <div class="stats-card-body bg-teal">
                        <h3>{{ $pjoprosess ?? 0 }}</h3>
                        <p>PJO PROCESS</p>
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-teal">
                        <a href="#">View <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card">
                    <div class="stats-card-body bg-teal">
                        <h3>{{ $becprosess ?? 0 }}</h3>
                        <p>BEC PROCESS</p>
                        <div class="icon">
                            <i class="fas fa-user-cog"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-teal">
                        <a href="#">View <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card">
                    <div class="stats-card-body bg-teal">
                        <h3>{{ $kttprosess ?? 0 }}</h3>
                        <p>KTT PROCESS</p>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-teal">
                        <a href="#">View <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stats-card">
                    <div class="stats-card-body bg-gray">
                        <h3>{{ ($totaloutstanding ?? 3) - ($sheprosess ?? 3) - ($pjoprosess ?? 0) - ($becprosess ?? 0) - ($kttprosess ?? 0) }}
                        </h3>
                        <p>OTHER PROCESS</p>
                        <div class="icon">
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                    </div>
                    <div class="stats-card-footer bg-gray">
                        <a href="#">View <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- PERMIT DISTRIBUTION Section -->
        <div class="section-title">
            <i class="fas fa-chart-pie"></i> PERMIT DISTRIBUTION
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>SIMPER & Mine Permit Distribution</h3>
                        <button class="btn-collapse" type="button" data-toggle="collapse"
                            data-target="#donutChartContent">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <div class="chart-body collapse show" id="donutChartContent">
                        <div style="height: 300px; width: 100%;">
                            <canvas id="myDonutChart"></canvas>
                        </div>
                        <div class="loading-spinner" id="donutChartLoading">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submission Statistics Section -->
        <div class="row">
            <div class="col-md-12">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3>SIMPER & Mine Permit Submission Statistics</h3>
                        <button class="btn-collapse" type="button" data-toggle="collapse"
                            data-target="#lineChartContent">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                    <div class="chart-body collapse show" id="lineChartContent">
                        <div style="height: 300px; width: 100%;">
                            <canvas id="simperMinePermitChart"></canvas>
                        </div>
                        <div class="loading-spinner" id="lineChartLoading">
                            <i class="fas fa-spinner"></i>
                        </div>
                    </div>
                    <div class="chart-footer">
                        <select class="year-selector" id="yearFilter">
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Alert for password change
            @if (session()->has('password_change_required'))
                // Show alert for password change
                Swal.fire({
                    title: 'Password Change Required',
                    text: 'You are still using the default password. Please change your password for security reasons.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Change Password Now',
                    cancelButtonText: 'Remind Me Later',
                    allowOutsideClick: true,
                    allowEscapeKey: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to change password page
                        window.location.href = '/akun/change-password';
                    }
                });
            @endif

            // Deklarasi variabel chart di level yang lebih tinggi agar bisa diakses dari fungsi lain
            var lineChart;
            var donutChart;

            // Setup donut chart
            var donutCtx = document.getElementById('myDonutChart').getContext('2d');
            var donutData = {
                labels: ['SIMPER', 'Mine Permit'],
                datasets: [{
                    data: [{{ $simper ?? 40 }}, {{ $minepermit ?? 60 }}],
                    backgroundColor: ['#3498db', '#00a65a'],
                    borderWidth: 0
                }]
            };
            donutChart = new Chart(donutCtx, {
                type: 'doughnut',
                data: donutData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Line chart setup
            var lineCtx = document.getElementById('simperMinePermitChart').getContext('2d');
            lineChart = new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                        'September', 'October', 'November', 'December'
                    ],
                    datasets: [{
                        label: 'SIMPER Submissions',
                        data: [],
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 3
                    }, {
                        label: 'Mine Permit Submissions',
                        data: [],
                        borderColor: '#00a65a',
                        backgroundColor: 'rgba(0, 166, 90, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2,
                        pointRadius: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                stepSize: 1, // Menetapkan interval langkah ke 1
                                precision: 0, // Memastikan tidak ada angka desimal
                                callback: function(value) {
                                    return Math.floor(
                                        value); // Memastikan nilai selalu dibulatkan ke bawah
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'start',
                            labels: {
                                boxWidth: 12,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Fungsi untuk menampilkan loading spinner
            function showLoading(chartId) {
                document.getElementById(chartId + 'Loading').style.display = 'block';
            }

            // Fungsi untuk menyembunyikan loading spinner
            function hideLoading(chartId) {
                document.getElementById(chartId + 'Loading').style.display = 'none';
            }

            // Fungsi untuk memuat data dari API
            function loadChartData(year) {
                // Tampilkan loading indicator
                showLoading('lineChart');
                showLoading('donutChart');

                // Ambil data dari server
                fetch('/api/permit-requests?year=' + year)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Update line chart dengan data dari server
                        if (data.labels && data.labels.length > 0) {
                            lineChart.data.labels = data.labels;
                        }

                        if (data.simper) {
                            lineChart.data.datasets[0].data = data.simper;
                        }

                        if (data.minePermit) {
                            lineChart.data.datasets[1].data = data.minePermit;
                        }

                        lineChart.update();

                        // Update donut chart dengan data total
                        if (data.totalSimper !== undefined && data.totalMinePermit !== undefined) {
                            donutChart.data.datasets[0].data = [data.totalSimper, data.totalMinePermit];
                            donutChart.update();
                        }

                        // Sembunyikan loading indicator
                        hideLoading('lineChart');
                        hideLoading('donutChart');
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                        // Sembunyikan loading indicator dan tampilkan pesan error jika diperlukan
                        hideLoading('lineChart');
                        hideLoading('donutChart');

                        // Fallback ke data dummy jika fetch gagal
                        lineChart.data.datasets[0].data = [2, 19, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                        lineChart.data.datasets[1].data = [1, 10, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                        lineChart.update();

                        // Tampilkan alert atau notifikasi error
                        alert('Gagal memuat data: ' + error.message);
                    });
            }

            // Muat data untuk tahun default saat halaman dimuat
            var defaultYear = document.getElementById('yearFilter').value;
            loadChartData(defaultYear);

            // Event listener untuk perubahan tahun
            document.getElementById('yearFilter').addEventListener('change', function() {
                var selectedYear = this.value;
                console.log('Year changed to: ' + selectedYear);
                loadChartData(selectedYear);
            });
        });
    </script>
@endsection
