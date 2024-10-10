
@extends('layouts.app')
@section('title','Halaman Cabang')
@section('subtitle','Menu Cabang')

@section('content')
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-cabang"><i class="fas fa-plus-circle"></i> Tambah Data</a>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Cabang</th>
                        <th>Nama Cabang</th>
                        <th>Nama Kota</th>
                        <th>Alamat</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($cabang as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $p->kode_cabang }}</td>
                            <td>{{ $p->nama_cabang }}</td>
                            <td>{{ $p->nama_kota }}</td>
                            <td>{{ $p->alamat_cabang }}</td>
                            <td>
                                <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-edit" data-toggle="modal" data-target="#modal-cabang-edit" data-id="{{ $p->id }}" style="color: black">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}" style="color: white">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th width="5%">No</th>
                        <th>Kode Cabang</th>
                        <th>Nama Cabang</th>
                        <th>Nama Kota</th>
                        <th>Alamat</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="modal fade" id="modal-cabang">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Cabang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Main content -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="form-cabang" action="{{ route('cabang.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Tambahkan token CSRF -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="kode_cabang">Kode Cabang</label>
                                    <input type="text" class="form-control" id="kode_cabang" name="kode_cabang" placeholder="Masukkan Kode Cabang" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_cabang">Nama Cabang</label>
                                    <input type="text" class="form-control" id="nama_cabang" name="nama_cabang" placeholder="Masukkan Nama Cabang" required>
                                </div>
                                <div class="form-group">
                                    <label for="id_kota">Nama Kota</label>
                                    <select class="form-control select2" style="width: 100%;" id="id_kota" name="id_kota" required>
                                        <option value="">--Pilih kota--</option>
                                        <!-- Opsi kota akan dimuat secara dinamis -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nama_cabang_edit">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat_cabang" placeholder="Masukkan Alamat Cabang" required></textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btn-simpan-cabang"><i class="fas fa-save"></i> Simpan</button>
                                <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-cabang-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Edit Cabang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Main content -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title"></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form id="form-edit-cabang" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf <!-- Tambahkan token CSRF -->
                            <input type="hidden" id="id" name="id" value="">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="kode_cabang_edit">Kode Cabang</label>
                                    <input type="text" class="form-control" id="kode_cabang_edit" name="kode_cabang" placeholder="Masukkan Kode Cabang" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama_cabang_edit">Nama Cabang</label>
                                    <input type="text" class="form-control" id="nama_cabang_edit" name="nama_cabang" placeholder="Masukkan Nama Cabang" required>
                                </div>

                                <div class="form-group">
                                    <label for="id_kota_edit">Nama Kota</label>
                                    <select class="form-control select2" style="width: 100%;" id="id_kota_edit" name="id_kota" required>
                                        <option value="">--Pilih kota--</option>
                                        <!-- Opsi kota akan dimuat secara dinamis -->
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="nama_cabang_edit">Alamat</label>
                                    <textarea class="form-control" id="alamat_cabang_edit" name="alamat_cabang" placeholder="Masukkan Alamat Cabang" required></textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" id="btn-update-cabang"><i class="fas fa-check"></i> Update</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@push('script')
    {{-- SKRIP TAMBAHAN --}}

    {{-- PERINTAH CARI KOTA --}}
    <script>
        $(document).ready(function() {
            // Mendapatkan data awal
            $.ajax({
                url: '/getKotaData', // Ganti dengan URL yang sesuai untuk memuat data kota
                dataType: 'json',
                success: function(data) {
                    // Memproses hasil dan menambahkannya ke dalam Select2
                    var initialData = $.map(data.slice(0, 5), function(item) {
                        return {
                            text: item.nama_kota,
                            id: item.id
                        };
                    });

                    $('.select2').select2({
                        minimumInputLength: 1,
                        data: initialData, // Menambahkan data awal ke dalam Select2
                        ajax: {
                            url: '/getKotaData', // Ganti dengan URL yang sesuai untuk memuat data kota
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.nama_kota,
                                            id: item.id
                                        };
                                    })
                                };
                            },
                            cache: true
                        }
                    });
                }
            });
        });
    </script>
    {{-- PERINTAH CARI KOTA --}}

    {{-- perintah simpan data --}}
    <script>
        document.getElementById('form-cabang').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form melakukan submit default
            const tombolSimpan = $('#btn-simpan-cabang')
            var kodeCabang = document.getElementById('kode_cabang').value.trim();
            var namaCabang = document.getElementById('nama_cabang').value.trim();
            var idKota = document.getElementById('id_kota').value; // Ambil nilai id_kota dari Select2
            const form = $('#form-cabang')
            if (!form[0].checkValidity()) {
                form[0].reportValidity()
                return false
            }
            var formData = new FormData(this);
            formData.append('id_kota', idKota); // Tambahkan id_kota ke FormData

            $.ajax({
                url: '{{ route('cabang.store') }}', // Ganti dengan URL endpoint Anda
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('form').find('.error-message').remove()
                    tombolSimpan.prop('disabled',true)
                },
                success: function(response) {
                    // Tampilkan SweetAlert untuk notifikasi berhasil
                    Swal.fire({
                        title: 'Sukses!',
                        text: 'Data berhasil disimpan.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            location.reload(); // Merefresh halaman saat pengguna menekan OK pada SweetAlert
                        }
                    });
                },
                complete: function()
                     {tombolSimpan.prop('disabled',false)},
                error: function(xhr, status, error) {
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            console.log(xhr.responseJSON.errors)
                            $.each(xhr.responseJSON.errors, function(i, item) {
                                $('form').find(`input[name="${i}"],select[name="${i}"],textarea[name="${i}"]`).closest('div').append(`<small class="error-message text-danger">${item}</small>`)
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: xhr.responseJSON.message,
                                confirmButtonText: 'OK'
                            })
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: '',
                            confirmButtonText: 'OK'
                        })
                    }
                }
            });
        });
    </script>
    {{-- perintah simpan data --}}

    {{-- perintah edit data --}}
    <script>
        $(document).ready(function() {
            $('.dataTable tbody').on('click', 'td .btn-edit', function(e) {
                e.preventDefault();
                var cabangId = $(this).data('id');

                // Ajax request untuk mendapatkan data cabang
                $.ajax({
                    type: 'GET',
                    url: '/cabang/' + cabangId + '/edit',
                    success: function(data) {
                        // Mengisi data pada form modal
                        $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi
                        $('#kode_cabang_edit').val(data.kode_cabang);
                        $('#nama_cabang_edit').val(data.nama_cabang);
                        $('#id_kota_edit').val(data.id_kota);
                        $('#modal-cabang-edit').modal('show');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
    {{-- perintah edit data --}}

    {{-- perintah update data --}}
    <script>
        $(document).ready(function() {
            $('#id_kota_edit').select2({
                placeholder: '--Pilih kota--',
                ajax: {
                    url: '/getKotaData', // Ganti dengan URL yang sesuai untuk memuat data kota
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama_kota,
                                    id: item.id
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            // Logika untuk menampilkan data cabang yang akan diedit pada modal
            $('.btn-edit').click(function(e) {
                e.preventDefault();
                var cabangId = $(this).data('id');



                // Ajax request untuk mendapatkan data cabang
                $.ajax({
                    type: 'GET',
                    url: '/cabang/' + cabangId + '/edit',
                    success: function(data) {
                        // Mengisi data pada form modal
                        $('#id').val(data.id);
                        $('#kode_cabang_edit').val(data.kode_cabang);
                        $('#nama_cabang_edit').val(data.nama_cabang);
                        $('#alamat_cabang_edit').val(data.alamat_cabang);

                        // Mengatur nilai Select2 untuk ID kota dan men-trigger agar Select2 menampilkan nama kota
                        $('#id_kota_edit').val(data.id_kota).trigger('change');

                        $('#modal-cabang-edit').modal('show');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            // Sisanya adalah script AJAX yang sudah ada sebelumnya
            $('#btn-update-cabang').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-update-cabang')
                var cabangId = $('#id').val(); // Ambil ID cabang dari input tersembunyi
                var formData = new FormData($('#form-edit-cabang')[0]);
                const form = $('#form-edit-cabang')

                if (!form[0].checkValidity()) {
                    form[0].reportValidity()
                    return false
                }

                // Lakukan permintaan Ajax untuk update data cabang
                $.ajax({
                    type: 'POST', // Ganti menjadi POST
                    url: '/cabang/update/' + cabangId,
                    data: formData,
                    // headers: {
                    //     'X-HTTP-Method-Override': 'PUT' // Menggunakan header untuk menentukan metode PUT
                    // },
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $('form').find('.error-message').remove()
                        tombolUpdate.prop('disabled',true)
                    },
                    success: function(response) {
                        // Tampilkan pesan sukses menggunakan SweetAlert
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Data berhasil diperbarui.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                location.reload(); // Merefresh halaman saat pengguna menekan OK pada SweetAlert
                            }
                        });
                        // Tutup modal atau lakukan sesuatu setelah update berhasil
                        $('#modal-cabang-edit').modal('hide');
                    },
                    complete: function()
                     {tombolUpdate.prop('disabled',false)},
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                console.log(xhr.responseJSON.errors)
                                $.each(xhr.responseJSON.errors, function(i, item) {
                                    $('form').find(`input[name="${i}"],select[name="${i}"],textarea[name="${i}"]`).closest('div').append(`<small class="error-message text-danger">${item}</small>`)
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: xhr.responseJSON.message,
                                    confirmButtonText: 'OK'
                                })
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: '',
                                confirmButtonText: 'OK'
                            })
                        }
                    }
                });
            });
        });
    </script>
    {{-- perintah update data --}}

    {{-- perintah hapus data --}}
    <script>
        $(document).ready(function() {
            $('.dataTable tbody').on('click', 'td .btn-hapus', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin mau hapus data?',
                    text: "Tindakan ini tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika dikonfirmasi, lakukan permintaan AJAX ke endpoint penghapusan
                        $.ajax({
                            url: '/cabang/' + id,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response){
                                // Tambahkan kode lain yang perlu dilakukan setelah penghapusan berhasil
                                console.log(response);
                                // Contoh: Hapus baris dari tabel setelah penghapusan berhasil
                                // $('#baris_' + id).remove();
                                location.reload(); // Refresh halaman setelah hapus
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText); // Tampilkan pesan error jika terjadi
                            }
                        });
                    }
                });
            });
        });
    </script>
    {{-- perintah hapus data --}}

    <script>
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $('#modal-cabang-edit').on('hidden.bs.modal', function (e) {
            $('#form-edit-cabang')[0].reset()
            $('form').find('.error-message').remove()
        })

        $('#modal-cabang').on('hidden.bs.modal', function (e) {
            $('#form-cabang')[0].reset()
            $('form').find('.error-message').remove()
        })
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush
