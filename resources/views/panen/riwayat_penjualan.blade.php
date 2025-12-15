@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"></h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-block-helper me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="row">
        @foreach ($stoks as $stok)
            <div class="col-lg-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Stok
                                    {{ $stok->jenis->jenis_jeruk }}</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ formatKg($stok->jumlah_stok) }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-apple-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Penjualan</h6>
                <div>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"><i
                            class="fa fa-plus mr-1"></i>Tambah data penjualan</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Penjualan</th>
                            <th>Jenis Jeruk</th>
                            <th>Jumlah Penjualan (kg)</th>
                            <th>Harga</th>
                            <th>Total Harga</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>


                    <tbody>

                        @php
                            $no = 1;
                        @endphp

                        @foreach ($penjualans as $penjualan)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $penjualan->tanggal_penjualan }}</td>
                                <td>{{ $penjualan->jenis->jenis_jeruk }}</td>
                                <td>{{ formatKg($penjualan->jumlah_penjualan) }}</td>
                                <td>{{ formatRupiah($penjualan->harga) }}</td>
                                <td>{{ formatRupiah($penjualan->total_harga) }}</td>
                                <td>{{ $penjualan->keterangan }}</td>
                                <td> <button  data-toggle="modal" data-target="#modalEdit"
                                        class="btn btn-primary btn-sm  btn-edit" data-id="{{ $penjualan->id }}"
                                        data-id_jenis="{{ $penjualan->jenis->id }}"
                                        data-tanggal_penjualan="{{ $penjualan->tanggal_penjualan }}"
                                        data-jumlah_penjualan="{{ $penjualan->jumlah_penjualan }}"
                                        data-keterangan="{{ $penjualan->keterangan }}"
                                        data-total_harga="{{ $penjualan->total_harga }}"
                                        data-harga ="{{ $penjualan->harga }}" ><i
                                            class="fa fa-edit mr-1"></i>Edit</button>
                                    <a href="{{ route('riwayat-penjualan.destroy', $penjualan->id) }}"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')"><i
                                            class="fa fa-trash mr-1"></i>Hapus</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal Created-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('riwayat-penjualan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tanggal_penjualan" class="form-control-label">Tanggal Penjualan</label>
                                    <input type="date" class="form-control" id="tanggal_penjualan"
                                        name="tanggal_penjualan" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-select">
                                    <label for="id" class="form-control-label">Jenis Jeruk</label>
                                    <select name="id_jenis" id="id" class="form-control">
                                        @foreach ($jenisJeruks as $jeruk)
                                            <option value="{{ $jeruk->id }}">{{ $jeruk->jenis_jeruk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="jumlah_penjualan" class="form-control-label">Jumlah Penjualan (kg)</label>
                                    <input type="number" min="0" step="0.01" class="form-control"
                                        id="jumlah_penjualan" name="jumlah_penjualan" required
                                        placeholder="Jumlah Penjualan">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="harga" class="form-control-label">Harga</label>
                                    <input type="number" min="0" step="0.01" class="form-control"
                                        id="harga" name="harga" required placeholder="Harga">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="keterangan" class="form-control-label">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan"
                                        placeholder="Masukkan keterangan">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="total_harga" class="form-control-label ">Total Harga</label>
                                    <input type="text" class="form-control" readonly id="total_harga_display" required
                                        placeholder="Total Harga">
                                </div>
                                <!-- INI YANG DIKIRIM KE SERVER -->
                                <input type="hidden" id="total_harga" name="total_harga">
                            </div>
                        </div>


                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>


    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Penjualan</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form action="{{ route('riwayat-penjualan.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <input type="hidden" name="id" id="id_penjualan">

                        <!-- Tanggal & Jumlah -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Tanggal Penjualan</label>
                                    <input type="date" class="form-control" id="tanggal_penjualan_edit"
                                        name="tanggal_penjualan" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Jumlah Penjualan (kg)</label>
                                    <input type="number" min="0" step="0.01" class="form-control"
                                        id="jumlah_penjualan_edit" name="jumlah_penjualan" required>
                                </div>
                            </div>
                        </div>

                        <!-- Harga & Total -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" min="0" step="0.01" class="form-control"
                                        id="harga_edit" name="harga" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Total Harga</label>

                                    <!-- tampil ke user -->
                                    <input type="text" class="form-control" id="total_harga_view_edit" readonly>

                                    <!-- dikirim ke server -->
                                    <input type="hidden" id="total_harga_edit" name="total_harga">
                                </div>
                            </div>
                        </div>

                        <!-- Jenis Jeruk & Keterangan -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Jenis Jeruk</label>
                                    <select name="id_jenis" id="id_jenis" class="form-control">
                                        @foreach ($jenisJeruks as $jeruk)
                                            <option value="{{ $jeruk->id }}">
                                                {{ $jeruk->jenis_jeruk }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan_edit" name="keterangan">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>





@endsection

@section('js')
    <script>

        // Format angka ke Rupiah
function formatRupiah(angka) {
    return "Rp " + angka.toLocaleString('id-ID');
}


        function hitungTotalEdit() {
            let jumlah = parseFloat($('#jumlah_penjualan_edit').val()) || 0;
            let harga = parseFloat($('#harga_edit').val()) || 0;

            let total = jumlah * harga;

            $('#total_harga_edit').val(total);
            $('#total_harga_view_edit').val(formatRupiah(total));
        }

        $(document).on('click', '.btn-edit', function() {

            $('#id_penjualan').val($(this).data('id'));
            $('#tanggal_penjualan_edit').val($(this).data('tanggal_penjualan'));
            $('#jumlah_penjualan_edit').val($(this).data('jumlah_penjualan'));
            $('#harga_edit').val($(this).data('harga'));
            
            
            
            $('#keterangan_edit').val($(this).data('keterangan'));
            
            $('#id_jenis').val($(this).data('id_jenis')).trigger('change');

            let total = $(this).data('total_harga');
            $('#total_harga_edit').val(total);
            $('#total_harga_view_edit').val(formatRupiah(total));
        });

        $('#jumlah_penjualan_edit, #harga_edit').on('input', function() {
            hitungTotalEdit();
        });

        $(document).ready(function() {



            function hitungTotal() {
                let jumlah = parseFloat($('#jumlah_penjualan').val()) || 0;
                let harga = parseFloat($('#harga').val()) || 0;

                let total = jumlah * harga;

                // Tampilkan ke user (format rupiah)
                $('#total_harga_display').val(formatRupiah(total));

                // Simpan nilai murni ke hidden input
                $('#total_harga').val(total);
            }

            $('#jumlah_penjualan, #harga').on('input', hitungTotal);

        });
    </script>
@endsection
