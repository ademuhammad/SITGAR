@extends('template.header-footer')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card buy-card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Temuan Keseluruhan</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="tgl-lhp-number">{{ $jumlahTemuan }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card sales-card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Nilai Rekomendasi</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="tes" style="font-size: 16px">
                                                Rp.{{ number_format($jumlahRekomendasi, 2, ',', '.') }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Sales Card -->
                        <!-- Revenue Card -->
                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card revenue-card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Nilai Telah Dibayar </h5>

                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-check-all"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="tes" style="font-size: 16px">
                                                Rp.{{ number_format($jumlahDibayar, 2, ',', '.') }}
                                            </h6>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- New Card for Remaining Amount to be Paid -->
                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card sales-card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Sisa Yang Belum Dibayar</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-currency-dollar"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="tes" style="font-size: 16px">
                                                Rp.{{ number_format($sisaBayar, 2, ',', '.') }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- End Sisa Bayar Card -->

                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card customers-card h-100">
                                <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>
                                        @foreach ($jumlahTemuanStatus as $status => $count)
                                            <li>
                                                <a class="dropdown-item" href="#"
                                                    onclick="updateStatus('{{ $status }}', {{ $count }})">
                                                    {{ $status }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="card-body">
                                    @php
                                        $firstStatus = $jumlahTemuanStatus->keys()->first();
                                        $firstCount = $jumlahTemuanStatus->first();
                                    @endphp
                                    <h5 class="card-title">Temuan Berdasarkan Status <span id="status-label">|
                                            {{ $firstStatus }}</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-info-square-fill"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="status-number">{{ $firstCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Customers Card -->
                    </div>
                </div><!-- End Left side columns -->
            </div>

            <div class="row">
                <!-- Temuan Dalam Bulan -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Temuan Dalam Bulan</h5>
                            <div class="form-group">
                                <label for="monthSelect">Pilih Bulan:</label>
                                <select class="form-control" id="monthSelect" onchange="updateMonthChart()">
                                    <option value="Jan">Januari</option>
                                    <option value="Feb">Februari</option>
                                    <option value="Mar">Maret</option>
                                    <option value="Apr">April</option>
                                    <option value="May">Mei</option>
                                    <option value="Jun">Juni</option>
                                    <option value="Jul">Juli</option>
                                    <option value="Aug">Agustus</option>
                                    <option value="Sep">September</option>
                                    <option value="Oct">Oktober</option>
                                    <option value="Nov">November</option>
                                    <option value="Dec">Desember</option>
                                </select>
                            </div>
                            <canvas id="monthChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Temuan Dalam Tahun -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Temuan Dalam Tahun</h5>
                            <div class="form-group">
                                <label for="yearSelect">Pilih Tahun:</label>
                                <select class="form-control" id="yearSelect" onchange="updateYearChart()">
                                    @foreach ($temuanPerYearMonth as $year => $data)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <canvas id="yearChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Temuan Per Bulan - Tahun -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Temuan Per Bulan - Tahun {{ $year }}</h5>
                            <form method="GET" action="{{ route('dashboard.index') }}">
                                <select name="year" onchange="this.form.submit()" class="form-control mb-3">
                                    @for ($i = 2020; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </form>
                            <canvas id="monthlyFindingsChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Jumlah nilai (Rp) berdasarkan OPD -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Nilai (Rp) Berdasarkan OPD</h5>
                            <canvas id="opdValueChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Sisa Pembayaran per OPD (Rp)</h5>

                            <!-- Bar Chart -->
                            <canvas id="barChartopd" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const labels = @json($sisaPembayaranPerOpd->keys());
                                    const data = @json($sisaPembayaranPerOpd->values());

                                    new Chart(document.querySelector('#barChartopd'), {
                                        type: 'bar',
                                        data: {
                                            labels: labels,
                                            datasets: [{
                                                data: data,
                                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                borderColor: 'rgb(75, 192, 192)',
                                                borderWidth: 1
                                            }]
                                        },
                                        options: {
                                            plugins: {
                                                legend: {
                                                    display: false // Menghilangkan legend
                                                }
                                            },
                                            scales: {
                                                y: {
                                                    beginAtZero: true
                                                }
                                            }
                                        }
                                    });
                                });
                            </script>
                            <!-- End Bar Chart -->
                        </div>
                    </div>

            </div>

        </section>

    </main><!-- End #main -->
    <script>
        function updateTemuanCount(tgl_lhp, count) {
            document.getElementById('tgl-lhp-label').innerText = '| ' + tgl_lhp;
            document.getElementById('tgl-lhp-number').innerText = count;
        }

        function updateStatus(status, count) {
            document.getElementById('status-label').innerText = '| ' + status;
            document.getElementById('status-number').innerText = count;
        }
    </script>
    <script>
        function updateSales(year, jumlahTemuan, jumlahRekomendasi) {
            document.querySelector('#sales-status-label').textContent = '| ' + year;
            document.querySelector('.tes').textContent = jumlahTemuan;
            document.querySelector('.nilai-rekomendasi').textContent = formatRupiah(jumlahRekomendasi);
        }

        function formatRupiah(amount) {
            return 'Rp' + Number(amount).toLocaleString('id-ID');
        }
    </script>
    <script>
        function updateStatus(status, number) {
            document.getElementById('status-label').innerText = '| ' + status;
            document.getElementById('status-number').innerText = number;
        }
    </script>
    <script>
        function updateSales(status, number) {
            document.getElementById('sales-status-label').innerText = '| ' + status;
            document.getElementById('sales-status-number').innerText = number;
        }
    </script>
    <script>
        // Data for charts
        const dataPerMonth = {
            Jan: [5, 12, 9, 14, 7, 18, 10, 23, 15, 21, 11, 17, 19, 22, 16, 24, 20, 25, 23, 19, 22, 28, 24, 26, 30, 27, 25, 29, 31, 30],
            Feb: [4, 8, 12, 9, 14, 7, 18, 10, 23, 15, 21, 11, 17, 19, 22, 16, 24, 20, 25, 23, 19, 22, 28, 24, 26, 30, 27, 25],
            Mar: [6, 9, 11, 15, 8, 13, 17, 19, 21, 20, 14, 18, 22, 25, 29, 28, 23, 21, 26, 24, 27, 30, 32, 35, 31, 33, 34, 30, 28, 25, 20],
            // Add data for other months here
        };

        const dataPerYear = @json($temuanPerYearMonth->mapWithKeys(function ($items, $year) {
            return [
                $year => $items->mapWithKeys(function ($item) {
                    return [$item->month => $item->total];
                }),
            ];
        }));

        // Initialize charts
        let monthChartCtx = document.getElementById('monthChart').getContext('2d');
        let monthChart = new Chart(monthChartCtx, {
            type: 'line',
            data: {
                labels: Array.from({ length: 31 }, (_, i) => (i + 1).toString()),
                datasets: [{
                    label: 'Temuan',
                    data: dataPerMonth.Jan,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        let yearChartCtx = document.getElementById('yearChart').getContext('2d');
        let yearChart = new Chart(yearChartCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Temuan',
                    data: Object.values(dataPerYear[Object.keys(dataPerYear)[0]]), // Default to first year
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: false,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        let monthlyFindingsChartCtx = document.getElementById('monthlyFindingsChart').getContext('2d');
        let monthlyFindingsChart = new Chart(monthlyFindingsChartCtx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Jumlah Temuan',
                    data: @json($counts),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        let opdValueChartCtx = document.getElementById('opdValueChart').getContext('2d');
        let opdValueChart = new Chart(opdValueChartCtx, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: 'Jumlah nilai (Rp)',
                    data: [65, 59, 80, 81, 56, 55, 40],
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Update functions
        function updateMonthChart() {
            const selectedMonth = document.getElementById('monthSelect').value;
            monthChart.data.datasets[0].data = dataPerMonth[selectedMonth];
            monthChart.update();
        }

        function updateYearChart() {
            const selectedYear = document.getElementById('yearSelect').value;
            yearChart.data.datasets[0].data = Object.values(dataPerYear[selectedYear]);
            yearChart.update();
        }
    </script>
@endsection
