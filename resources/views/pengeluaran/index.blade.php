@extends('layouts.app')
@section('title','Halaman Pengeluaran')
@section('subtitle','Menu Pengeluaran')

@section('content')
    <div class="card">
        <!-- /.card-header -->
        @php
        $user = Auth::user();
        $statusCabang = $user->cabang ? $user->cabang->status : null;
        $isSuperAdmin = $user->superAdmin; // Pastikan ini sesuai dengan properti superAdmin yang ada pada model User
    @endphp
    
    @if(!empty($user->cabang_id) && !$isSuperAdmin)
        @if($statusCabang === 'Nonaktif')
            <div class="alert alert-warning">
                Status masih dalam masa closing
                <hr>
                {{-- <button class="btn btn-sm btn-primary btn-buka" style="color: white">
                    <i class="fas fa-ban"></i> Buka Closingan
                </button> --}}
            </div>
        @else
        <div class="card-body">
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-pengeluaran" id="tambahDataButton"><i class="fas fa-plus-circle"></i> Tambah Data</a>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal Pengeluaran</th>
                        @hasrole('superadmin')<th>Cabang</th>@endhasrole
                        <th>Kode Pengeluaran</th>
                        <th>Nama Pengeluaran</th>
                        <th>Jumlah Pengeluaran</th>
                        <th>Keterangan</th>
                        <th>PIC</th>
                        <th>Bukti</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach ($pengeluaran as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_pengeluaran)->format('d-m-Y') }}</td>
                            @hasrole('superadmin')<td>{{ $p->cabang?->nama_cabang }}</td>@endhasrole
                            <td>{{ $p->kode_pengeluaran}}</td>
                            <td>{{ $p->nama_pengeluaran}}</td>
                            <td><span class="float-left badge bg-success">Rp. {{ number_format($p->jumlah_pengeluaran) }}</span></td>
                            <td>{{ $p->keterangan}}</td>
                            <td>{{ $p->pic}}</td>
                            <td>
                                <a href="{{ asset('uploads/bukti_pengeluaran/' . $p->bukti) }}" target="_blank"><img style="max-width:50px; max-height:50px" src="/uploads/bukti_pengeluaran/{{ $p->bukti}}" alt="{{ $p->alias}}"></a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#modal-pengeluaran-edit" data-id="{{ $p->id }}" style="color: black">
                                    <i class="fas fa-edit"></i>  Edit
                                </a>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}" style="color: white">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal Pengeluaran</th>
                        @hasrole('superadmin')<th>Cabang</th>@endhasrole
                        <th>Kode Pengeluaran</th>
                        <th>Nama Pengeluaran</th>
                        <th>Jumlah Pengeluaran</th>
                        <th>Keterangan</th>
                        <th>PIC</th>
                        <th>Bukti</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
        @else
        <div class="card-body">
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-pengeluaran" id="tambahDataButton"><i class="fas fa-plus-circle"></i> Tambah Data</a>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal Pengeluaran</th>
                        @hasrole('superadmin')<th>Cabang</th>@endhasrole
                        <th>Kode Pengeluaran</th>
                        <th>Nama Pengeluaran</th>
                        <th>Jumlah Pengeluaran</th>
                        <th>Keterangan</th>
                        <th>PIC</th>
                        <th>Bukti</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach ($pengeluaran as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_pengeluaran)->format('d-m-Y') }}</td>
                            @hasrole('superadmin')<td>{{ $p->cabang?->nama_cabang }}</td>@endhasrole
                            <td>{{ $p->kode_pengeluaran}}</td>
                            <td>{{ $p->nama_pengeluaran}}</td>
                            <td><span class="float-left badge bg-success">Rp. {{ number_format($p->jumlah_pengeluaran) }}</span></td>
                            <td>{{ $p->keterangan}}</td>
                            <td>{{ $p->pic}}</td>
                            <td>
                                <a href="{{ asset('uploads/bukti_pengeluaran/' . $p->bukti) }}" target="_blank"><img style="max-width:50px; max-height:50px" src="/uploads/bukti_pengeluaran/{{ $p->bukti}}" alt="{{ $p->alias}}"></a>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#modal-pengeluaran-edit" data-id="{{ $p->id }}" style="color: black">
                                    <i class="fas fa-edit"></i>  Edit
                                </a>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}" style="color: white">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal Pengeluaran</th>
                        @hasrole('superadmin')<th>Cabang</th>@endhasrole
                        <th>Kode Pengeluaran</th>
                        <th>Nama Pengeluaran</th>
                        <th>Jumlah Pengeluaran</th>
                        <th>Keterangan</th>
                        <th>PIC</th>
                        <th>Bukti</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
        <!-- /.card-body -->
    </div>
    <!-- /.card -->


    <div class="modal fade" id="modal-pengeluaran">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Pengeluaran</h4>
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
                        <form id="form-pengeluaran" action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="tanggal_pengeluaran">Tanggal Pengeluaran</label>
                                    <input type="date" class="form-control" id="tanggal_pengeluaran" name="tanggal_pengeluaran" value="{{ now()->format('Y-m-d') }}" required>
                                </div>
                                @hasrole('superadmin')
                                  <div class="form-group">
                                      <label for="cabang_edit">Cabang</label>
                                      <select class="form-control cabang w-100" id="cabang" name="cabang_id">
                                          <option value="">--Pilih Cabang--</option>
                                      </select>
                                  </div>
                                @endhasrole
                                <div class="form-group">
                                    <label for="kode_pengeluaran">Kode Pengeluaran</label>
                                    <input type="text" class="form-control" id="kode_pengeluaran" name="kode_pengeluaran" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pengeluaran">Nama Pengeluaran</label>
                                    <input type="text" class="form-control" id="nama_pengeluaran" name="nama_pengeluaran" placeholder="Masukkan Nama Pengeluaran" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_pengeluaran">Jumlah Pengeluaran</label>
                                    <input type="text" class="form-control input-price-format" id="jumlah_pengeluaran" name="jumlah_pengeluaran" placeholder="Masukkan Jumlah Pengeluaran" required>
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" required>
                                </div>
                                <div class="form-group">
                                    <label for="pic">PIC</label>
                                    <input type="text" class="form-control" id="pic" name="pic" placeholder="Masukkan PIC" required>
                                </div>


                                <div class="form-group" id="bukti_container" >
                                    <label for="bukti">Upload Bukti Bayar</label>
                                    <div class="input-group">
                                      <div class="custom-file">
                                        <label class="custom-file-label" for="bukti">Choose file</label>
                                        <input type="file" class="custom-file-input" id="bukti" name="bukti" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(event, 'preview-image', 'preview-container')">
                                      </div>
                                      <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                      </div>
                                    </div>
                                    <div id="preview-container" style="display:none;">
                                      <img id="preview-image" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                                    </div>
                                  </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btn-simpan-pengeluaran"><i class="fas fa-save"></i> Simpan</button>
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

    <div class="modal fade" id="modal-pengeluaran-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Edit Pengeluaran</h4>
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
                        <form id="form-edit-pengeluaran" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf <!-- Tambahkan token CSRF -->
                            <input type="hidden" id="id" name="id" value="">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="tanggal_pengeluaran_edit">Tanggal Pengeluaran</label>
                                    <input type="date" class="form-control" id="tanggal_pengeluaran_edit" name="tanggal_pengeluaran">
                                </div>
                                @hasrole('superadmin')
                                  <div class="form-group">
                                      <label for="cabang_edit">Cabang</label>
                                      <select class="form-control cabang-edit" id="cabang_edit" disabled></select>
                                  </div>
                                @endhasrole
                                <div class="form-group">
                                    <label for="kode_pengeluaran_edit">Kode Pengeluaran</label>
                                    <input type="text" class="form-control" id="kode_pengeluaran_edit" name="kode_pengeluaran" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama_pengeluaran_edit">Nama Pengeluaran</label>
                                    <input type="text" class="form-control" id="nama_pengeluaran_edit" name="nama_pengeluaran" placeholder="Masukkan Nama Pengeluaran">
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_pengeluaran_edit">Jumlah Pengeluaran</label>
                                    <input type="text" class="form-control input-price-format" id="jumlah_pengeluaran_edit" name="jumlah_pengeluaran" placeholder="Masukkan Jumlah Pengeluaran">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan_edit">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan_edit" name="keterangan" placeholder="Masukkan Keterangan">
                                </div>
                                <div class="form-group">
                                    <label for="pic_edit">PIC</label>
                                    <input type="text" class="form-control" id="pic_edit" name="pic" placeholder="Masukkan PIC">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Bukti Pengeluaran</label>
                                    <br>
                                    <!-- Tempat untuk menampilkan bukti -->
                                    <a id="link-bukti" href="#" target="_blank">
                                        <img id="bukti-pengeluaran" style="max-width:50px; max-height:50px" src="#" alt="Bukti Pengeluaran">
                                    </a>
                                </div>

                                <div class="form-group" id="bukti_bayar_edit_container">
                                    <label for="bukti_edit">Upload Bukti Bayar</label>
                                    <div class="input-group">
                                      <div class="custom-file">
                                        <label class="custom-file-label" for="bukti_edit">Choose file</label>
                                        <input type="file" class="custom-file-input" id="bukti_edit" name="bukti" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(event, 'preview-image-edit', 'preview-container-edit')">
                                      </div>
                                      <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                      </div>
                                    </div>
                                    <div id="preview-container-edit" style="display:none;">
                                      <img id="preview-image-edit" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                                    </div>
                                  </div>
                            </div>
                        </form>

                        <div class="card-footer">
                            <button type="button" class="btn btn-primary btn-simpan" id="btn-update-pengeluaran"><i class="fas fa-check"></i> Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
                        </div>
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

@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
    <style>
        .select2-container {
            width: 100% !important
        }
    </style>
@endpush

@push('script')
    {{--SKRIP TAMBAHAN  --}}
    @include('js.cleave-js')

    {{-- Kode Otomatis --}}
    <script>
        function previewImage(event, previewImage, previewContainer) {
            var input = event.target;
            var previewImage = document.getElementById(previewImage);
            var previewContainer = document.getElementById(previewContainer);

            if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function() {
            initPriceFormat()
        })

        document.getElementById('tambahDataButton').addEventListener('click', function() {
          fetch('/getLatestCodePengeluaran')
              .then(response => response.json())
              .then(data => {
                  let latestCode = data.latestCode;
                  console.log('Nilai latestCode:', latestCode); // Tambahkan ini untuk memeriksa nilai latestCode
                  document.getElementById('kode_pengeluaran').value = latestCode;
              })
              .catch(error => {
                  console.error('Error:', error);
              });
        });
    </script>

    <script>
        function generateNextCode(lastCode) {
            let lastNumber = parseInt(lastCode.slice(3)) + 1;
            let nextCode = lastCode.slice(0, 3) + lastNumber.toString().padStart(4, '0');
            return nextCode;
        }
    </script>
    {{-- Kode Otomatis --}}

    {{-- perintah simpan data --}}
    <script>
        document.getElementById('form-pengeluaran').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form melakukan submit default
            const tombolSimpan = $('#btn-simpan-pengeluaran')
            var tanggalPengeluaran = document.getElementById('tanggal_pengeluaran').value.trim();
            var kodePengeluaran = document.getElementById('kode_pengeluaran').value.trim();
            var namaPengeluaran = document.getElementById('nama_pengeluaran').value.trim();
            var jumlahPengeluaran = document.getElementById('jumlah_pengeluaran').value.trim();
            var keterangan = document.getElementById('keterangan').value.trim();
            var pic = document.getElementById('pic').value.trim();
            var bukti = document.getElementById('bukti').files[0];
            const btnSimpan = $('.btn-simpan')

            if ($(this)[0].checkValidity()) {
                $(this)[0].reportValidity()
            }

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route('simpan.pengeluaran') }}', // Ganti dengan URL endpoint Anda
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
                            $.each(xhr.responseJSON.errors, function(i, item) {
                                $('form').find(`input[name="${i}"],select[name="${i}"],textarea[name="${i}"]`).closest('div.form-group').append(`<small class="error-message text-danger">${item}</small>`)
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
                var pengeluaranId = $(this).data('id');

                // Ajax request untuk mendapatkan data pengeluaran
                $.ajax({
                    type: 'GET',
                    url: '/pengeluaran/' + pengeluaranId + '/edit',
                    success: function(data) {
                        // Mengisi data pada form modal
                        $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi
                        $('#tanggal_pengeluaran_edit').val(data.tanggal_pengeluaran);
                        $('#kode_pengeluaran_edit').val(data.kode_pengeluaran);
                        $('#nama_pengeluaran_edit').val(data.nama_pengeluaran);
                        $('#jumlah_pengeluaran_edit').val(data.jumlah_pengeluaran);
                        $('#keterangan_edit').val(data.keterangan);
                        $('#pic_edit').val(data.pic);
                        $('#cabang_edit').html(`<option value="${data.cabang_id}" selected>${data.nama_cabang}</option>`);

                        var buktiUrl = '/uploads/bukti_pengeluaran/' + data.bukti;
                        $('#modal-pengeluaran-edit #bukti-pengeluaran').attr('src', buktiUrl);
                        $('#modal-pengeluaran-edit #link-bukti').attr('href', buktiUrl);
                        // Menampilkan modal
                        $('#modal-pengeluaran-edit').modal('show');

                        initPriceFormat()
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
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
    {{-- perintah edit data --}}

    {{-- perintah update data --}}
    <script>
        $(document).ready(function() {
            // Sisanya adalah script AJAX yang sudah ada sebelumnya
            $('#btn-update-pengeluaran').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-update-pengeluaran')
                var pengeluaranId = $('#id').val(); // Ambil ID pengeluaran dari input tersembunyi
                var formData = new FormData($('#form-edit-pengeluaran')[0]);

                // Lakukan permintaan Ajax untuk update data pengeluaran
                $.ajax({
                    type: 'POST', // Ganti menjadi POST
                    url: '/pengeluaran/update/' + pengeluaranId,
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT' // Menggunakan header untuk menentukan metode PUT
                    },
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
                        $('#modal-pengeluaran-edit').modal('hide');
                    },
                    complete: function()
                     {tombolUpdate.prop('disabled',false)},
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
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
                            url: '/pengeluaran/' + id,
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
                            error: function(xhr, status, error) {
                                if (xhr.responseJSON) {
                                    if (xhr.responseJSON.errors) {
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
                    }
                });
            });
        });
    </script>
    {{-- perintah hapus data --}}

    <script>
        $(function(){
            $('#cabang').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('getCabangData') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama_cabang,
                                    id: item.id
                                };
                            })
                        };
                    },
                    cache: true
                }
            });

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });

            $('#modal-pengeluaran-edit').on('hidden.bs.modal', function (e) {
                $('#form-edit-pengeluaran')[0].reset()
                $('form').find('.error-message').remove()
            })

            $('#modal-pengeluaran').on('hidden.bs.modal', function (e) {
                $('#form-pengeluaran')[0].reset()
                $('form').find('.error-message').remove()
            })
        })
    </script>

    
<script>
    $(document).ready(function() {
        $('.btn-buka').on('click', function() {
            Swal.fire({
                title: 'Buka Closingan?',
                text: 'Apakah Anda yakin ingin membuka closingan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan AJAX request ke route 'buka.closing'
                    $.ajax({
                        url: '{{ route("buka.closing") }}',
                        type: 'PUT',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: response.message,
                                    icon: 'success'
                                }).then(() => {
                                    // Lakukan reload halaman
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
