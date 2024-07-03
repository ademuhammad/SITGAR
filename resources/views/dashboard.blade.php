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

                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-xxl-3 col-md-3">
                            <div class="card info-card buy-card">

                                <div class="card-body">

                                    <h5 class="card-title">Temuan Keseluruhan <span id="tgl-lhp-label">| </span></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="tgl-lhp-number">{{ $jumlahTemuan }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-3 col-md-3">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Nilai Rekomendasi</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
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
                           <div class="col-xxl-3 col-md-3">
                            <div class="card info-card revenue-card">
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
                        <div class="col-xxl-3 col-md-3">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Sisa Yang Belum Dibayar</h5>
                                    <br>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
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





                        <div class="col-xxl-3 col-md-3">
                            <div class="card info-card customers-card">
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
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Temuan Dalam Bulan</h5>

                            <!-- Filter Dropdown -->
                            <div class="form-group">
                                <label for="monthSelect">Pilih Bulan:</label>
                                <select class="form-control" id="monthSelect" onchange="updateChart()">
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

                            <!-- Line Chart -->
                            <div id="lineChart"></div>

                            <script>
                                const dataPerMonth = {
                                    Jan: [5, 12, 9, 14, 7, 18, 10, 23, 15, 21, 11, 17, 19, 22, 16, 24, 20, 25, 23, 19, 22, 28, 24, 26, 30, 27,
                                        25, 29, 31, 30
                                    ],
                                    Feb: [4, 8, 12, 9, 14, 7, 18, 10, 23, 15, 21, 11, 17, 19, 22, 16, 24, 20, 25, 23, 19, 22, 28, 24, 26, 30,
                                        27, 25
                                    ],
                                    Mar: [6, 9, 11, 15, 8, 13, 17, 19, 21, 20, 14, 18, 22, 25, 29, 28, 23, 21, 26, 24, 27, 30, 32, 35, 31, 33,
                                        34, 30, 28, 25, 20
                                    ],
                                    // Data untuk bulan lainnya bisa ditambahkan di sini
                                };

                                let chart;

                                document.addEventListener("DOMContentLoaded", () => {
                                    chart = new ApexCharts(document.querySelector("#lineChart"), {
                                        series: [{
                                            name: "Temuan",
                                            data: dataPerMonth.Jan
                                        }],
                                        chart: {
                                            height: 350,
                                            type: 'line',
                                            zoom: {
                                                enabled: false
                                            },
                                            toolbar: {
                                                show: false // Menghilangkan tools toolbar termasuk download
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        stroke: {
                                            curve: 'straight'
                                        },
                                        grid: {
                                            row: {
                                                colors: ['#f3f3f3',
                                                    'transparent'
                                                ], // takes an array which will be repeated on columns
                                                opacity: 0.5
                                            },
                                        },
                                        xaxis: {
                                            categories: Array.from({
                                                length: 31
                                            }, (_, i) => (i + 1).toString())
                                        }
                                    });
                                    chart.render();
                                });

                                function updateChart() {
                                    const selectedMonth = document.getElementById("monthSelect").value;
                                    chart.updateSeries([{
                                        name: "Temuan",
                                        data: dataPerMonth[selectedMonth]
                                    }]);
                                }
                            </script>
                            <!-- End Line Chart -->

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Temuan Dalam Tahun</h5>

                            <!-- Filter Dropdown -->
                            <div class="form-group">
                                <label for="yearSelect">Pilih Tahun:</label>
                                <select class="form-control" id="yearSelect" onchange="updateYearChart()">
                                    @foreach ($temuanPerYearMonth as $year => $data)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Line Chart -->
                            <div id="lineChart2"></div>

                            <script>
                                const dataPerYear = @json(
                                    $temuanPerYearMonth->mapWithKeys(function ($items, $year) {
                                        return [
                                            $year => $items->mapWithKeys(function ($item) {
                                                return [$item->month => $item->total];
                                            }),
                                        ];
                                    }));

                                let yearChart;
                                const years = Object.keys(dataPerYear);
                                const defaultYear = years[years.length - 1]; // Set the last year as default

                                document.addEventListener("DOMContentLoaded", () => {
                                    document.getElementById("yearSelect").value = defaultYear; // Set default year in dropdown
                                    yearChart = new ApexCharts(document.querySelector("#lineChart2"), {
                                        series: [{
                                            name: "Temuan",
                                            data: Object.values(dataPerYear[defaultYear])
                                        }],
                                        chart: {
                                            height: 200,
                                            type: 'line',
                                            zoom: {
                                                enabled: false
                                            },
                                            toolbar: {
                                                show: false // Hide the toolbar tools including download
                                            }
                                        },
                                        dataLabels: {
                                            enabled: false
                                        },
                                        colors: ['#FF5733'],
                                        stroke: {
                                            curve: 'straight'
                                        },
                                        grid: {
                                            row: {
                                                colors: ['#f3f3f3', 'transparent'], // Alternating row colors
                                                opacity: 0.5
                                            },
                                        },
                                        xaxis: {
                                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                                                'Nov', 'Dec'
                                            ],
                                        }
                                    });
                                    yearChart.render();
                                });

                                function updateYearChart() {
                                    const selectedYear = document.getElementById("yearSelect").value;
                                    const selectedData = Object.values(dataPerYear[selectedYear]);
                                    yearChart.updateSeries([{
                                        name: "Temuan",
                                        data: selectedData
                                    }]);
                                }
                            </script>
                            <!-- End Line Chart -->

                        </div>
                    </div>
                </div>


            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h1>Temuan Per Bulan - Tahun {{ $year }}</h1>

                            <form method="GET" action="{{ route('dashboard.index') }}">
                                <select name="year" onchange="this.form.submit()">
                                    @for ($i = 2020; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </form>

                            <canvas id="temuanChart" width="400" height="200"></canvas>
                            <script>
                                const ctx = document.getElementById('temuanChart').getContext('2d');
                                const temuanChart = new Chart(ctx, {
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
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                });
                            </script>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah nilai (Rp) berdasarkan OPD</h5>

                            <!-- Bar Chart -->
                            <canvas id="barChart2" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    new Chart(document.querySelector('#barChart2'), {
                                        type: 'bar',
                                        data: {
                                            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
                                            datasets: [{
                                                data: [65, 59, 80, 81, 56, 55, 40],
                                                backgroundColor: [
                                                    'rgba(255, 99, 132, 0.2)',
                                                    'rgba(255, 159, 64, 0.2)',
                                                    'rgba(255, 205, 86, 0.2)',
                                                    'rgba(75, 192, 192, 0.2)',
                                                    'rgba(54, 162, 235, 0.2)',
                                                    'rgba(153, 102, 255, 0.2)',
                                                    'rgba(201, 203, 207, 0.2)'
                                                ],
                                                borderColor: [
                                                    'rgb(255, 99, 132)',
                                                    'rgb(255, 159, 64)',
                                                    'rgb(255, 205, 86)',
                                                    'rgb(75, 192, 192)',
                                                    'rgb(54, 162, 235)',
                                                    'rgb(153, 102, 255)',
                                                    'rgb(201, 203, 207)'
                                                ],
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
@endsection
