@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Panen</h1>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Filter Tanggal
            </h6>
        </div>
        <div class="card-body">

            <form id="formFilter">
                <div class="row align-items-center">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Awal</label>
                            <input type="date" class="form-control" id="tanggal_awal" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tanggal_akhir" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search mr-1"></i> Tampilkan Data
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <!-- Tabel Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                Data Panen
            </h6>

            <a href="#" id="btnPrint" class="btn btn-danger btn-sm d-none" target="_blank">
                <i class="fas fa-file-pdf mr-1"></i> Print PDF
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="tablePanen" width="100%">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Panen</th>
                            <th>Jenis Jeruk</th>
                            <th>Jumlah (Kg)</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function formatKg(value) {
            let num = parseFloat(value);

            if (Number.isInteger(num)) {
                return num; // 23
            }

            return num.toFixed(1).replace(/\.0$/, '');
        }

        let table;

        $(document).ready(function() {

            table = $('#tablePanen').DataTable({
                processing: true,
                serverSide: false,
                searching: false,
                ordering: false,
                paging: true,
                info: true,
                language: {
                    emptyTable: "Silakan pilih rentang tanggal"
                },
                columns: [{
                        data: null
                    },
                    {
                        data: 'tanggal_panen'
                    },
                    {
                        data: 'jenis.jenis_jeruk'
                    },
                    {
                        data: 'jumlah_panen'
                    },
                    {
                        data: 'keterangan'
                    },
                ],
                columnDefs: [{
                    targets: 0,
                    render: (data, type, row, meta) => meta.row + 1
                }, {
                    targets: 3,
                    render: function(data) {
                        return formatKg(data) + ' kg';
                    }
                }]
            });

        });



        $('#formFilter').on('submit', function(e) {
            e.preventDefault();

            let tanggalAwal = $('#tanggal_awal').val();
            let tanggalAkhir = $('#tanggal_akhir').val();

            if (!tanggalAwal || !tanggalAkhir) {
                alert('Tanggal wajib diisi');
                return;
            }

            $.ajax({
                url: "{{ route('laporan.panen.data') }}",
                type: "GET",
                data: {
                    tanggal_awal: tanggalAwal,
                    tanggal_akhir: tanggalAkhir
                },
                success: function(res) {

                    table.clear().rows.add(res).draw();

                    // tampilkan tombol print
                    $('#btnPrint')
                        .removeClass('d-none')
                        .attr('href',
                            "{{ route('laporan.panen.print') }}?tanggal_awal=" + tanggalAwal +
                            "&tanggal_akhir=" + tanggalAkhir
                        );
                }
            });
        });
    </script>
@endsection
