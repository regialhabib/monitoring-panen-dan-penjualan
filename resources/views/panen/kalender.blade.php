@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Perencanaan Panen
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Kalender Rencana Panen
                    </h6>
                </div>
                <div class="card-body">

                    <!-- Kalender -->
                    <div id="calendar"></div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Rencana Panen -->
    <div class="modal fade" id="modalRencanaPanen" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Rencana Panen</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <form id="formRencanaPanen">
                    <div class="modal-body">

                        <input type="hidden" name="id" id="rencana_id">
                        <!-- tanggal (auto dari kalender) -->
                        <div class="form-group">
                            <label>Tanggal Rencana</label>
                            <input type="date" class="form-control" id="tanggal_rencana" name="tanggal_rencana" readonly>
                        </div>

                        <!-- jenis jeruk -->
                        <div class="form-group">
                            <label>Jenis Jeruk</label>
                            <select name="id_jenis" id="id_jenis_rencana" class="form-control" required>
                                <option value="" disabled selected hidden>
                                    Pilih Jenis Jeruk
                                </option>
                                @forelse ($jenisJeruks as $jeruk)
                                    <option value="{{ $jeruk->id }}">{{ $jeruk->jenis_jeruk }}</option>
                                @empty
                                    <option disabled>Tidak ada data jenis jeruk</option>
                                @endforelse

                            </select>
                        </div>

                        <!-- jumlah -->
                        <div class="form-group">
                            <label>Jumlah Rencana (kg)</label>
                            <input type="number" step="0.1" min="0" class="form-control" name="jumlah_rencana"
                                placeholder="Contoh: 120 atau 120.5" required id="jumlah_rencana">
                        </div>

                        <!-- catatan -->
                        <div class="form-group">
                            <label>Catatan</label>
                            <textarea class="form-control" name="catatan" rows="3" placeholder="Opsional" id="catatan_rencana"></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>
                        <button type="button" class="btn btn-danger d-none" id="btnDeleteRencana">
                            Hapus
                        </button>
                        <button type="submit" class="btn btn-primary" id="btnSubmitRencana">
                            Simpan Rencana
                        </button>

                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <style>
        .fc-event:hover {
            opacity: 0.85;
            transform: scale(1.01);
            transition: all 0.15s ease-in-out;
            cursor: pointer;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        window.routes = {

            destroy: "{{ route('rencana-panen.destroy', ':id') }}"
        };

        document.addEventListener('DOMContentLoaded', function() {

            const calendarEl = document.getElementById('calendar');

            window.calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 650,
                locale: 'id',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },

                events: "{{ route('perencanaan-panen.events') }}",


                dateClick: function(info) {
                    $('#formRencanaPanen')[0].reset();
                    $('#rencana_id').val('');
                    $('#tanggal_rencana').val(info.dateStr);
                    $('#btnSubmitRencana').text('Simpan Rencana');
                    $('#btnDeleteRencana').addClass('d-none'); // 👈 sembunyikan
                    $('#modalRencanaPanen').modal('show');
                },
                eventClick: function(info) {
                    console.log(info.event.id);


                    $.get(`/rencana-panen/${info.event.id}`, function(res) {
                        console.log(res);

                        $('#rencana_id').val(res.id);
                        $('#tanggal_rencana').val(res.tanggal_rencana);
                        $('#id_jenis_rencana').val(res.id_jenis);
                        $('#jumlah_rencana').val(res.jumlah_rencana);
                        $('#catatan_rencana').val(res.catatan);
                        $('#btnSubmitRencana').text('Update Rencana');
                        $('#btnDeleteRencana').removeClass('d-none'); // 👈 tampilkan
                        $('#modalRencanaPanen').modal('show');
                    });
                }



            });


            calendar.render();
        });

        $(document).ready(function() {

            $('#formRencanaPanen').on('submit', function(e) {
                e.preventDefault();

                let id = $('#rencana_id').val();

                let url = id ?
                    "{{ route('perencanaan-panen.update') }}" :
                    "{{ route('perencanaan-panen.store') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        $('#modalRencanaPanen').modal('hide');
                        calendar.refetchEvents(); // 🔄 refresh kalender

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message ?? 'Data berhasil disimpan',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        let msg = 'Terjadi kesalahan';

                        if (xhr.responseJSON?.message) {
                            msg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: msg
                        });
                    }
                });
            });

        });

        $('#btnDeleteRencana').on('click', function() {

            let id = $('#rencana_id').val();

            Swal.fire({
                title: 'Yakin?',
                text: 'Rencana panen ini akan dihapus permanen',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        url: window.routes.destroy.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire('Berhasil', res.message, 'success');
                            $('#modalRencanaPanen').modal('hide');
                            calendar.refetchEvents(); // 🔥 refresh kalender
                        },
                        error: function() {
                            Swal.fire('Gagal', 'Data tidak bisa dihapus', 'error');
                        }
                    });
                }

            });
        });
    </script>
@endsection
