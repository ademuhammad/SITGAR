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
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
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
                            <h5 class="card-title">Temuan Dalam Tahun {{ date('Y') }}</h5>
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
                            <h5 class="card-title">Temuan Per Bulan - Tahun</h5>
                            <select id="yearMonthlySelect" class="form-control" onchange="updateMonthlyFindingsChart()">
                                @for ($i = 2020; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            <canvas id="monthlyFindingsChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Jumlah nilai (Rp) berdasarkan OPD -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Jumlah Temuan Berdasarkan OPD</h5>
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
            
                                // Fungsi untuk memecah nama panjang menjadi beberapa baris
                                function splitLabel(label) {
                                    return label.split(" ");
                                }
            
                                const formattedLabels = labels.map(label => splitLabel(label));
            
                                new Chart(document.querySelector('#barChartopd'), {
                                    type: 'bar',
                                    data: {
                                        labels: formattedLabels,
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
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    title: function(context) {
                                                        const index = context[0].dataIndex;
                                                        return labels[index]; // Menampilkan nama lengkap dalam tooltip
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                ticks: {
                                                    callback: function(value, index, values) {
                                                        return formattedLabels[index]; // Menampilkan label dengan format baru
                                                    }
                                                }
                                            },
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
        let monthChart;
        let yearChart;
        let monthlyFindingsChart;
        let opdValueChart;

        // Fungsi untuk memperbarui grafik Temuan Dalam Bulan
        function updateMonthChart() {
            const selectedMonth = document.getElementById('monthSelect').value;
            const data = @json($temuanPerDayInMonth);
            const filteredData = data.filter(item => new Date(item.date).getMonth() + 1 == selectedMonth);

            const labels = Array.from({
                length: new Date(new Date().getFullYear(), selectedMonth, 0).getDate()
            }, (_, i) => i + 1);
            const counts = labels.map(day => {
                const found = filteredData.find(item => new Date(item.date).getDate() == day);
                return found ? found.count : 0;
            });

            if (monthChart) monthChart.destroy();
            const ctx = document.getElementById('monthChart').getContext('2d');
            monthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Temuan',
                        data: counts,
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
        }

        // Fungsi untuk memperbarui grafik Temuan Dalam Tahun
        function updateYearChart() {
            const data = @json($temuanPerMonthInYear);

            const labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const counts = labels.map((_, index) => {
                const found = data.find(item => item.month - 1 == index);
                return found ? found.count : 0;
            });

            if (yearChart) yearChart.destroy();
            const ctx = document.getElementById('yearChart').getContext('2d');
            yearChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Temuan',
                        data: counts,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
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
        }

        // Fungsi untuk memperbarui grafik Temuan Per Bulan - Tahun
        function updateMonthlyFindingsChart() {
            const selectedYear = document.getElementById('yearMonthlySelect').value;
            const data = @json($temuanPerMonth);
            const filteredData = data.filter(item => item.year == selectedYear);

            const labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const counts = labels.map((_, index) => {
                const found = filteredData.find(item => item.month - 1 == index);
                return found ? found.count : 0;
            });

            if (monthlyFindingsChart) monthlyFindingsChart.destroy();
            const ctx = document.getElementById('monthlyFindingsChart').getContext('2d');
            monthlyFindingsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Temuan',
                        data: counts,
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        borderColor: 'rgba(255, 159, 64, 1)',
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
        }

        // Inisialisasi grafik Temuan Per OPD
        function initializeOpdValueChart() {
            const data = @json($temuanPerOPD);
            const opdNames = @json($opds);
            const maxLength = 15; // Maximum label length
            const labels = data.map(item => {
                const name = opdNames[item.opd_id] || 'Tidak Diketahui';
                return name.length > maxLength ? name.substring(0, maxLength) + '...' : name;
            });
            const fullLabels = data.map(item => opdNames[item.opd_id] || 'Tidak Diketahui'); // Full labels for tooltip
            const counts = data.map(item => item.count);

            const ctx = document.getElementById('opdValueChart').getContext('2d');
            opdValueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Temuan',
                        data: counts,
                        backgroundColor: 'rgba(255, 206, 86, 0.2)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            ticks: {
                                display: false
                                // callback: function(value, index, values) {
                                //     return labels[index]; // Display truncated label
                                // }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    const index = context[0].dataIndex;
                                    return fullLabels[index]; // Display full label in tooltip
                                }
                            }
                        }
                    }
                }
            });
        }

        // Inisialisasi semua grafik pada saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateMonthChart();
            updateYearChart();
            updateMonthlyFindingsChart();
            initializeOpdValueChart();
        });
    </script>
@endsection
