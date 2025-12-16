@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Panen</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Data Panen</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tablePanen" class="table table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis Jeruk</th>
                            <th>Jumlah (kg)</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
function formatKg(value) {
    let num = parseFloat(value);
    return Number.isInteger(num) ? num : num.toFixed(1).replace(/\.0$/, '');
}

let table;

$(document).ready(function () {

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
        columns: [
            { data: null },
            { data: 'tanggal_panen' },
            { data: 'jenis.jenis_jeruk' },
            { data: 'jumlah_panen' },
            { data: 'keterangan' }
        ],
        columnDefs: [
            {
                targets: 0,
                render: (data, type, row, meta) => meta.row + 1
            },
            {
                targets: 3,
                render: data => formatKg(data) + ' kg'
            }
        ]
    });

    $('#formFilter').on('submit', function (e) {
        e.preventDefault();

        let awal  = $('#tanggal_awal').val();
        let akhir = $('#tanggal_akhir').val();

        $.ajax({
            url: "{{ route('laporan.panen.data') }}",
            type: "GET",
            data: {
                tanggal_awal: awal,
                tanggal_akhir: akhir
            },
            success: function (res) {

                table.clear().rows.add(res).draw();

                $('#btnPrint')
                    .removeClass('d-none')
                    .attr('href',
                        "{{ route('laporan.panen.print') }}?tanggal_awal=" +
                        awal + "&tanggal_akhir=" + akhir
                    );
            }
        });
    });

});
</script>
@endsection

