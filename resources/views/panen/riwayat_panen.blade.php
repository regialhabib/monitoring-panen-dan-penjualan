
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
                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">Stok {{ $stok->jenis->jenis_jeruk }}</div>
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
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Panen</h6>
                <div>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"><i
                            class="fa fa-plus mr-1"></i>Tambah data panen</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Panen</th>
                            <th>Jumlah Panen (kg)</th>
                            <th>Jenis Jeruk</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>


                    <tbody>

                        @php
                            $no = 1;
                        @endphp

                        @foreach ($panens as $panen)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $panen->tanggal_panen }}</td>
                                <td>{{ formatKg($panen->jumlah_panen) }}</td>
                                <td>{{ $panen->jenis->jenis_jeruk }}</td>
                                <td>{{ $panen->keterangan }}</td>
                                <td> <button id="btn-edit" data-toggle="modal" data-target="#modalEdit"
                                        class="btn btn-primary btn-sm " data-id="{{ $panen->id }}"
                                        data-id_jenis="{{ $panen->jenis->id }}" data-tanggal_panen="{{ $panen->tanggal_panen }}" data-jumlah_panen="{{ $panen->jumlah_panen }}" data-keterangan="{{ $panen->keterangan }}"><i class="fa fa-edit mr-1"></i>Edit</button>
                                    <a href="{{ route('riwayat-panen.destroy', $panen->id) }}" class="btn btn-danger btn-sm"
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
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Panen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('riwayat-panen.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tanggal_panen" class="form-control-label">Tanggal Panen</label>
                                    <input type="date" class="form-control" id="tanggal_panen" name="tanggal_panen" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="jumlah_panen" class="form-control-label">Jumlah Panen (kg)</label>
                                    <input type="number" min="0" step="0.01" class="form-control" id="jumlah_panen (kg)" name="jumlah_panen" required
                                        placeholder="Jumlah Panen">
                                </div>
                            </div>
                            
                        </div>
                         <div class="row">
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
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="keterangan" class="form-control-label">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan"
                                        placeholder="Masukkan keterangan">
                                </div>
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
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Panen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('riwayat-panen.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id_panen">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="tanggal_panen" class="form-control-label">Tanggal Panen</label>
                                    <input type="date" class="form-control" id="tanggal_panen_edit" name="tanggal_panen" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="jumlah_panen" class="form-control-label">Jumlah Panen (kg)</label>
                                    <input type="number" min="0" step="0.01" class="form-control" id="jumlah_panen_edit" name="jumlah_panen" required
                                        placeholder="Jumlah Panen">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-select">
                                    <label for="id" class="form-control-label">Jenis Jeruk</label>
                                    <select name="id_jenis" id="id_jenis" class="form-control">
                                        @foreach ($jenisJeruks as $jeruk)
                                            <option value="{{ $jeruk->id }}">{{ $jeruk->jenis_jeruk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="keterangan" class="form-control-label">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan_edit" name="keterangan"
                                        placeholder="Masukkan keterangan">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

            </div>
        </div>
    </div>




@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#btn-edit', function() {

                let id = $(this).data('id');
                let id_jenis = $(this).data('id_jenis');
                let tanggal_panen = $(this).data('tanggal_panen');
                let jumlah_panen = $(this).data('jumlah_panen');
                let keterangan = $(this).data('keterangan');
                // Masukkan ke form modal

                $('#id_panen').val(id);
                $('#id_jenis').val(id_jenis).trigger('change');
                $('#tanggal_panen_edit').val(tanggal_panen);
                $('#jumlah_panen_edit').val(jumlah_panen);
                $('#keterangan_edit').val(keterangan);
                // Tampilkan modal
                $('#modalEdit').modal('show');
            });

        })

        
    </script>
@endsection
