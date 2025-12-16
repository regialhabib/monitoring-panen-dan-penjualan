@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Penjualan</h1>
    </div>

    <!-- Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Tanggal</h6>
        </div>
        <div class="card-body">
            <form id="formFilter">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label>Tanggal Awal</label>
                        <input type="date" id="tanggal_awal" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label>Tanggal Akhir</label>
                        <input type="date" id="tanggal_akhir" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>

                        <a href="#" id="btnPrint" class="btn btn-danger d-none" target="_blank">
                            <i class="fas fa-file-pdf"></i> Print PDF
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablePenjualan" class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Jeruk</th>
                            <th>Jumlah (kg)</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">TOTAL</th>
                            <th id="totalPendapatan">Rp 0</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function formatRupiah(angka) {
            return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
        }

        function formatKg(value) {
            let num = parseFloat(value);
            return Number.isInteger(num) ? num : num.toFixed(1).replace(/\.0$/, '');
        }

        let table;

        $(document).ready(function() {

            table = $('#tablePenjualan').DataTable({
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
                        data: 'tanggal_penjualan'
                    },
                    {
                        data: 'jenis.jenis_jeruk'
                    },
                    {
                        data: 'jumlah_penjualan'
                    },
                    {
                        data: 'harga'
                    },
                    {
                        data: 'total_harga'
                    }
                ],
                columnDefs: [{
                        targets: 0,
                        render: (data, type, row, meta) => meta.row + 1
                    },
                    {
                        targets: 3,
                        render: data => formatKg(data) + ' kg'
                    },
                    {
                        targets: 4,
                        render: data => formatRupiah(data)
                    },
                    {
                        targets: 5,
                        render: data => formatRupiah(data)
                    }
                ]
            });

            $('#formFilter').on('submit', function(e) {
                e.preventDefault();

                let awal = $('#tanggal_awal').val();
                let akhir = $('#tanggal_akhir').val();

                $.ajax({
                    url: "{{ route('laporan.penjualan.data') }}",
                    type: "GET",
                    data: {
                        tanggal_awal: awal,
                        tanggal_akhir: akhir
                    },
                    success: function(res) {

                        table.clear().rows.add(res.data).draw();

                        $('#totalPendapatan').text(formatRupiah(res.total));

                        $('#btnPrint')
                            .removeClass('d-none')
                            .attr('href',
                                "{{ route('laporan.penjualan.print') }}?tanggal_awal=" +
                                awal + "&tanggal_akhir=" + akhir
                            );
                    }
                });
            });

        });
    </script>
@endsection
