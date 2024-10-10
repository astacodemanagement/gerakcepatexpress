
@extends('layouts.app')
@section('title','Halaman Pengguna')
@section('subtitle','Menu Cabang')

@section('content')
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-pengguna"><i class="fas fa-plus-circle"></i> Tambah Data</a>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Cabang</th>
                        <th>Role</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1; @endphp
                    @foreach ($pengguna as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $p->name }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{!! $p->cabang_id == 0 ? '<b>SEMUA CABANG</b>' : $p->cabang?->nama_cabang !!}</td>
                            <td class="text-center"><span class="badge bg-success">{{ ucwords($p->roles[0]->name) }}</span></td>
                            <td>
                                <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-edit" data-toggle="modal" data-target="#modal-pengguna-edit" data-id="{{ $p->id }}" style="color: black">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @if (auth()->user()->id != $p->id)
                                    <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}" style="color: white">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Cabang</th>
                        <th>Role</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="modal fade" id="modal-pengguna">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Pengguna</h4>
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
                        <form id="form-pengguna" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Tambahkan token CSRF -->
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama">Name</label>
                                    <input type="text" class="form-control" id="nama" name="name" placeholder="Masukkan Nama Pengguna" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="id_kota">Role</label>
                                    <select class="form-control role" style="width: 100%;" id="role" name="role" required>
                                        <option value="">--Pilih Role--</option>
                                        @foreach($roles as $r)
                                            <option value="{{ $r->id }}">{{ ucwords($r->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @hasrole('superadmin')
                                    <div class="form-group">
                                        <label for="id_kota">Cabang</label>
                                        <select class="form-control cabang" style="width: 100%;" id="cabang" name="cabang_id" required>
                                            <option value="">--Pilih Cabang--</option>
                                            <!-- Opsi kota akan dimuat secara dinamis -->
                                        </select>
                                    </div>
                                @endhasrole
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Pengguna" required>
                                </div>
                                <div class="form-group">
                                    <label for="re-password">Ulangi Password</label>
                                    <input type="password" class="form-control" id="re-password" name="password_confirmation" placeholder="Ulangi Password Pengguna" required>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btn-simpan-pengguna"><i class="fas fa-save"></i> Simpan</button>
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

    <div class="modal fade" id="modal-pengguna-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Edit Pengguna</h4>
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
                        <form id="form-edit-pengguna" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf <!-- Tambahkan token CSRF -->
                            <input type="hidden" id="id" name="id" value="">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama">Name</label>
                                    <input type="text" class="form-control" id="nama_edit" name="name" placeholder="Masukkan Nama Pengguna" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email_edit" name="email" placeholder="Masukkan Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="id_kota">Role</label>
                                    <select class="form-control role" style="width: 100%;" id="role_edit" name="role" required>
                                        <option value="">--Pilih Role--</option>
                                        @foreach($roles as $r)
                                            <option value="{{ $r->id }}">{{ ucwords($r->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @hasrole('superadmin')
                                    <div class="form-group">
                                        <label for="id_kota">Cabang</label>
                                        <select class="form-control cabang" style="width: 100%;" id="cabang_edit" name="cabang_id" required>
                                            <option value="">--Pilih Cabang--</option>
                                            <option value="0">SEMUA CABANG</option>
                                            <!-- Opsi kota akan dimuat secara dinamis -->
                                        </select>
                                    </div>
                                @endhasrole
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Pengguna">
                                </div>
                                <div class="form-group">
                                    <label for="re-password">Ulangi Password</label>
                                    <input type="password" class="form-control" id="re-password" name="password_confirmation" placeholder="Ulangi Password Pengguna">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" id="btn-update-pengguna"><i class="fas fa-check"></i> Update</button>
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

    {{-- PERINTAH CARI CABANG --}}
    <script>
        $(document).ready(function() {
            $('.role').select2();

            $('.cabang').select2({
                minimumInputLength: 3,
                ajax: {
                    url: '/getCabangData',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        data.push({
                            alamat_cabang : "",
                            created_at : null,
                            id : 0,
                            id_kota : 0,
                            kode_cabang : "000",
                            nama_cabang : "SEMUA CABANG",
                            nama_kota : ""
                        })
                        console.log(data)
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama_cabang,
                                    id: item.id
                                };
                            })
                        };
                    }
                }
            });
        });
    </script>
    {{-- PERINTAH CARI CABANG --}}

    {{-- perintah simpan data --}}
    <script>
        document.getElementById('form-pengguna').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form melakukan submit default
            const tombolSimpan = $('#btn-simpan-pengguna')
            const form = $('#form-pengguna')

            if (!form[0].checkValidity()) {
                form[0].reportValidity()
                return false
            }

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route('pengguna.store') }}', // Ganti dengan URL endpoint Anda
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

    {{-- perintah edit & update data --}}
    <script>
        $(document).ready(function() {

            // Logika untuk menampilkan data pengguna yang akan diedit pada modal
            $('.dataTable tbody').on('click', 'td .btn-edit', function(e) {
                e.preventDefault();
                var cabangId = $(this).data('id');

                // Ajax request untuk mendapatkan data pengguna
                $.ajax({
                    type: 'GET',
                    url: '/pengguna/' + cabangId + '/edit',
                    success: function(data) {
                        // Mengisi data pada form modal
                        $('#id').val(data.id);
                        $('#nama_edit').val(data.name);
                        $('#email_edit').val(data.email);
                        $('#role_edit').val(data.role).trigger('change');
                        $('#cabang_edit').append(`<option value="${data.cabang_id}">${data.cabang_title}</option>`)
                        $('#cabang_edit').val(data.cabang_id).trigger('change');

                        $('#modal-pengguna-edit').modal('show');
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: error.responseJSON.message,
                            confirmButtonText: 'OK'
                        })
                    }
                });
            });

            // Sisanya adalah script AJAX yang sudah ada sebelumnya
            $('#btn-update-pengguna').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-update-pengguna')
                var penggunaId = $('#id').val();
                var formData = new FormData($('#form-edit-pengguna')[0]);
                const form = $('#form-edit-pengguna')

                if (!form[0].checkValidity()) {
                    form[0].reportValidity()
                    return false
                }

                // Lakukan permintaan Ajax untuk update data pengguna
                $.ajax({
                    type: 'POST', // Ganti menjadi POST
                    url: '/pengguna/' + penggunaId,
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
                        $('#modal-pengguna-edit').modal('hide');
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
    {{-- perintah edit & update data --}}

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
                            url: '/pengguna/' + id,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response){
                                // Tambahkan kode lain yang perlu dilakukan setelah penghapusan berhasil
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

        $('#modal-pengguna-edit').on('hidden.bs.modal', function (e) {
            $('#form-edit-pengguna')[0].reset()
            $('form').find('.error-message').remove()
        })

        $('#modal-pengguna').on('hidden.bs.modal', function (e) {
            $('#form-pengguna')[0].reset()
            $('form').find('.error-message').remove()
        })
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush
