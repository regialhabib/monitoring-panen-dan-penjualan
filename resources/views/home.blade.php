@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    {{-- KPI --}}
    <div class="row">

        <!-- Total Panen -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Panen
                            </div>
                            <div class="h5 font-weight-bold text-gray-800 kpi-counter"
                                data-value="{{ $kpi['total_panen'] }}" data-suffix=" kg">
                                0
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-seedling fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Penjualan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Penjualan
                            </div>
                            <div class="h5 font-weight-bold text-gray-800 kpi-counter"
                                data-value="{{ $kpi['total_penjualan'] }}" data-suffix=" kg">
                                0
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Saat Ini -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Stok Saat Ini
                            </div>
                            <div class="h5 font-weight-bold text-gray-800 kpi-counter"
                                data-value="{{ $kpi['stok_saat_ini'] }}" data-suffix=" kg">
                                0
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pendapatan
                            </div>
                            <div class="h5 font-weight-bold text-gray-800 kpi-counter" data-value="{{ $kpi['pendapatan'] }}"
                                data-prefix="Rp ">
                                0
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- CHART ROW 1 --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Panen per Bulan (kg)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="panenChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Penjualan per Bulan (kg)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="penjualanChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART ROW 2 --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Panen vs Penjualan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="panenVsPenjualanChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Stok per Jenis Jeruk (kg)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="stokChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART ROW 3 --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Pendapatan per Bulan (Rp)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="pendapatanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Kontribusi Penjualan per Jenis
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4">
                        <canvas id="kontribusiChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('css')
    <style>
        .chart-pie {
            position: relative;
            height: 15rem;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        Chart.defaults.font.family = "'Nunito', '-apple-system', BlinkMacSystemFont";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#858796';

        const gridStyle = {
            color: "rgba(234, 236, 244, 1)",
            zeroLineColor: "rgba(234, 236, 244, 1)",
            drawBorder: false
        };
        const bulan = @json($bulan);
        const panenData = @json($panenPerBulan);
        const penjualanData = @json($penjualanPerBulan);
        const pendapatanData = @json($pendapatanPerBulan);

        const stokJenisLabel = @json($stokPerJenis->pluck('jenis_jeruk'));
        const stokJenisData = @json($stokPerJenis->pluck('total'));

        const kontribusiLabel = @json($kontribusiPenjualan->pluck('jenis_jeruk'));
        const kontribusiData = @json($kontribusiPenjualan->pluck('total'));
        const colors = {
            primary: '#4e73df',
            success: '#1cc88a',
            info: '#36b9cc',
            warning: '#f6c23e',
            danger: '#e74a3b',
            gray: '#858796'
        };

        $('.kpi-counter').each(function() {
            const el = $(this);
            const value = parseFloat(el.data('value')) || 0;
            const prefix = el.data('prefix') || '';
            const suffix = el.data('suffix') || '';

            $({
                count: 0
            }).animate({
                count: value
            }, {
                duration: 1000,
                easing: 'swing',
                step: function() {
                    el.text(
                        prefix +
                        Math.floor(this.count).toLocaleString('id-ID') +
                        suffix
                    );
                },
                complete: function() {
                    el.text(
                        prefix +
                        value.toLocaleString('id-ID') +
                        suffix
                    );
                }
            });
        });



        new Chart(document.getElementById('panenChart'), {
            type: 'line',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Panen (kg)',
                    data: panenData,
                    borderColor: colors.primary,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    pointRadius: 3,
                    pointBackgroundColor: colors.primary,
                    pointBorderColor: colors.primary,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: "#fff",
                        bodyColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: gridStyle
                    }
                }
            }
        });

        new Chart(document.getElementById('penjualanChart'), {
            type: 'line',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Penjualan (kg)',
                    data: penjualanData,
                    borderColor: colors.success,
                    backgroundColor: 'rgba(28, 200, 138, 0.05)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: gridStyle
                    }
                }
            }
        });

        new Chart(document.getElementById('panenVsPenjualanChart'), {
            type: 'line',
            data: {
                labels: bulan,
                datasets: [{
                        label: 'Panen',
                        data: panenData,
                        borderColor: colors.primary,
                        borderWidth: 2,
                        tension: 0.4
                    },
                    {
                        label: 'Penjualan',
                        data: penjualanData,
                        borderColor: colors.success,
                        borderWidth: 2,
                        tension: 0.4
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: gridStyle
                    }
                }
            }
        });

        new Chart(document.getElementById('stokChart'), {
            type: 'bar',
            data: {
                labels: stokJenisLabel,
                datasets: [{
                    data: stokJenisData,
                    backgroundColor: colors.info
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: gridStyle
                    }
                }
            }
        });

        new Chart(document.getElementById('pendapatanChart'), {
            type: 'bar',
            data: {
                labels: bulan,
                datasets: [{
                    data: pendapatanData,
                    backgroundColor: colors.warning
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: gridStyle,
                        ticks: {
                            callback: value => 'Rp ' + value.toLocaleString('id-ID')
                        }
                    }
                }
            }
        });

        new Chart(document.getElementById('kontribusiChart'), {
            type: 'doughnut',
            data: {
                labels: kontribusiLabel,
                datasets: [{
                    data: kontribusiData,
                    backgroundColor: [
                        colors.primary,
                        colors.success,
                        colors.info
                    ],
                    hoverBorderColor: "rgba(234, 236, 244, 1)"
                }]
            },
            options: {
                maintainAspectRatio: false, // 🔥 WAJIB
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15
                        }
                    }
                }
            }
        });
    </script>
@endsection
