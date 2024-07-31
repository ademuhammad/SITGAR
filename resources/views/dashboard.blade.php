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
                        {{-- temuan keseluruhan --}}
                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card buy-card">
                                <div class="card-body">
                                    <h5 class="card-title">Temuan Keseluruhan</h5>
                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="tes" style="font-size: 16px" id="tgl-lhp-number">
                                                {{ $jumlahTemuan }}
                                            </h6>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- temuan berdasarkan status --}}
                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card customers-card ">
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
                                            <h6 class="tes" style="font-size: 16px" id="status-number">
                                                {{ $firstCount }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- jumlah opd  --}}
                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card ">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah OPD dengan Temuan</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-building"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="tes" style="font-size: 16px">{{ $jumlahOPDTemuan }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- jumlah nilai yg sudah dibayar --}}
                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card revenue-card ">
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
                        </div>
                        {{-- jumlah nilai rekomendasi --}}
                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card sales-card ">
                                <div class="card-body">
                                    <h5 class="card-title">Jumlah Nilai Rekomendasi</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-wallet"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 class="tes" style="font-size: 16px">
                                                Rp.{{ number_format($jumlahRekomendasi, 2, ',', '.') }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- sisa yang belum dibayar --}}
                        <div class="col-xxl-4 col-md-4 mb-3">
                            <div class="card info-card sales-card ">
                                <div class="card-body">
                                    <h5 class="card-title">Sisa Yang Belum Dibayar</h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bi bi-credit-card"></i>

                                        </div>
                                        <div class="ps-3">
                                            <h6 class="tes" style="font-size: 16px">
                                                Rp.{{ number_format($sisaBayar, 2, ',', '.') }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Temuan Dalam Bulan -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-center">Temuan Dalam Bulan</h5>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="yearSelect">Pilih Tahun:</label>
                                    <select class="form-control" id="yearSelect" onchange="updateMonthChart()">
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
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
                            </div>
                            <canvas id="monthChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Temuan Per Bulan - Tahun -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-center">Temuan Per Tahun</h5>
                            <label for="yearMonthlySelect">Pilih Tahun:</label>
                            <select id="yearMonthlySelect" class="form-control" onchange="updateMonthlyFindingsChart()">
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                            <canvas id="monthlyFindingsChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Temuan berdasarkan OPD -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-center">Temuan Berdasarkan OPD</h5>
                            <canvas id="opdValueChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">Jumlah Sisa Pembayaran per OPD (Rp)</h5>

                            <!-- Bar Chart -->
                            <canvas id="barChartopd" height="200"></canvas>
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
                                                            return formattedLabels[
                                                                index]; // Menampilkan label dengan format baru
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
            </div>


            <div class="row">
                <!-- Temuan per Jenis Status TGR -->
                <div class="col-lg-6">
                    <div class="card"> <!-- Adjust card height here -->
                        <div class="card-body">
                            <h5 class="card-title text-center">Temuan Per Status TGR</h5>
                            <canvas id="statusTGRChart" height="200"></canvas> <!-- Adjust chart height here -->
                        </div>
                    </div>
                </div>

                <!-- Temuan Status Selesai per Tahun -->
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title text-center">Temuan Selesai Per Tahun</h5>
                            <canvas id="statusSelesaiChart" height="200"></canvas>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">

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

        function updateSales(year, jumlahTemuan, jumlahRekomendasi) {
            document.querySelector('#sales-status-label').textContent = '| ' + year;
            document.querySelector('.tes').textContent = jumlahTemuan;
            document.querySelector('.nilai-rekomendasi').textContent = formatRupiah(jumlahRekomendasi);
        }

        function formatRupiah(amount) {
            return 'Rp' + Number(amount).toLocaleString('id-ID');
        }

        function updateStatus(status, number) {
            document.getElementById('status-label').innerText = '| ' + status;
            document.getElementById('status-number').innerText = number;
        }

        function updateSales(status, number) {
            document.getElementById('sales-status-label').innerText = '| ' + status;
            document.getElementById('sales-status-number').innerText = number;
        }
    </script>

    <script>
        let monthChart;
        let monthlyFindingsChart;
        let opdValueChart;
        let statusSelesaiChart;
        let statusTGRChart;

        // Fungsi untuk memperbarui grafik Temuan Dalam Bulan
        function updateMonthChart() {
            const selectedYear = document.getElementById('yearSelect').value;
            const selectedMonth = document.getElementById('monthSelect').value;
            const data = @json($temuanPerDayInMonth);
            const filteredData = data.filter(item => new Date(item.date).getFullYear() == selectedYear && new Date(item
                .date).getMonth() + 1 == selectedMonth);

            const labels = Array.from({
                length: new Date(selectedYear, selectedMonth, 0).getDate()
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


        // Fungsi untuk memperbarui grafik Temuan Per Bulan - Tahun
        function updateMonthlyFindingsChart() {
            const selectedYear = document.getElementById('yearMonthlySelect').value;
            const data = @json($temuanPerMonth);

            const labels = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const counts = labels.map((_, index) => {
                const found = data.find(item => item.year == selectedYear && item.month - 1 == index);
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

        // Inisialisasi grafik Temuan Status Selesai per Tahun
        function initializeStatusSelesaiChart() {
            const data = @json($temuanStatus);

            // Extract unique years and sort them in ascending order
            const labels = [...new Set(data.map(item => item.year))].sort((a, b) => a - b);
            const statusNames = [...new Set(data.map(item => item.status_name))];

            // Define a color palette (example colors, adjust as needed)
            const colors = [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 206, 86, 1)'
            ];

            // Prepare datasets
            const datasets = statusNames.map((statusName, index) => {
                const statusData = data.filter(item => item.status_name === statusName);
                const counts = labels.map(year => {
                    const record = statusData.find(item => item.year == year);
                    return record ? record.count : 0; // Default to 0 if no record for that year
                });

                return {
                    label: statusName,
                    data: counts,
                    backgroundColor: colors[index % colors.length].replace('1)', '0.2)'),
                    borderColor: colors[index % colors.length],
                    borderWidth: 1
                };
            });

            const ctx = document.getElementById('statusSelesaiChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: datasets
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



        function initializeStatusTGRChart() {
            const data = @json($temuanPerStatusTGR);
            const statusTGRNames = @json($statusTGRs);

            // Define an array of colors
            const colors = [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(199, 199, 199, 1)',
                'rgba(255, 99, 71, 1)',
                'rgba(144, 238, 144, 1)',
                'rgba(0, 191, 255, 1)'
            ];

            // Extract unique years and statusTGR IDs from the data
            const years = [...new Set(data.map(item => item.year))];
            const statusTGRIds = [...new Set(data.map(item => item.statustgr_id))];

            // Create datasets for each TGR status
            const datasets = statusTGRIds.map((statusTGRId, index) => {
                return {
                    label: statusTGRNames[statusTGRId] || 'Belum Ada Status',
                    data: years.map(year => {
                        const item = data.find(d => d.year === year && d.statustgr_id === statusTGRId);
                        return item ? item.count : 0;
                    }),
                    backgroundColor: colors[index % colors.length],
                    borderColor: colors[index % colors.length],
                    borderWidth: 1,
                    fill: false // Set to true if you want an area chart
                };
            });

            const ctx = document.getElementById('statusTGRChart').getContext('2d');
            statusTGRChart = new Chart(ctx, {
                type: 'line', // Set to 'line' or 'area'
                data: {
                    labels: years,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    const label = tooltipItem.dataset.label || '';
                                    const value = tooltipItem.raw || 0;
                                    return `${label}: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Inisialisasi semua grafik pada saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            updateMonthChart();
            updateMonthlyFindingsChart();
            initializeOpdValueChart();
            initializeStatusSelesaiChart();
            initializeStatusTGRChart();
        });
    </script>
@endsection
