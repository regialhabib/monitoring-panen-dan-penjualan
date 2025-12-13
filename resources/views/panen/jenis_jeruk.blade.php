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

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Jenis Jeruk</h6>
                <div>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal"><i
                            class="fa fa-plus mr-1"></i>Tambah</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Jeruk</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>


                    <tbody>

                        @php
                            $no = 1;
                        @endphp

                        @foreach ($jenisJeruks as $jenisJeruk)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $jenisJeruk->jenis_jeruk }}</td>
                                <td> <button id="btn-edit" data-toggle="modal" data-target="#modalEdit"
                                        class="btn btn-primary btn-sm " data-id="{{ $jenisJeruk->id }}"
                                        data-jenis_jeruk="{{ $jenisJeruk->jenis_jeruk }}"><i
                                            class="fa fa-edit mr-1"></i>Edit</button>
                                    <a href="{{ route('jenis-jeruk.destroy', $jenisJeruk->id) }}"
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
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Jeruk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('jenis-jeruk.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="namaInput">Nama jenis jeruk</label>
                            <input type="text" class="form-control" id="jenis_jeruk" name="jenis_jeruk"
                                placeholder="Masukkan jenis jeruk">
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
                    <h5 class="modal-title" id="exampleModalLabel">Edit Jenis Jeruk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('jenis-jeruk.update') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="namaInput">Nama jenis jeruk</label>
                            <input type="text" class="form-control" id="jenis_jeruk_edit" name="jenis_jeruk"
                                placeholder="Masukkan jenis jeruk">
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
                let jenis_jeruk = $(this).data('jenis_jeruk');

                // Masukkan ke form modal
                $('#id').val(id);
                $('#jenis_jeruk_edit').val(jenis_jeruk);

                // Tampilkan modal
                $('#modalEdit').modal('show');
            });

        })
    </script>
@endsection
