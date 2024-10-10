@extends('layouts.app')
@section('title','Halaman Booking')
@section('subtitle','Menu Booking')

@section('content')
    @php
    $user = Auth::user();
    $statusCabang = $user->cabang ? $user->cabang->status : null;
    $isSuperAdmin = $user->superAdmin; // Pastikan ini sesuai dengan properti superAdmin yang ada pada model User
    @endphp

    @if(!empty($user->cabang_id) && !$isSuperAdmin)
        @if($statusCabang === 'Nonaktif')
            <div class="alert alert-warning">
                Status masih dalam masa closing
                {{-- <hr>
                <button class="btn btn-sm btn-primary btn-buka" style="color: white">
                    <i class="fas fa-ban"></i> Buka Closingan
                </button> --}}
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal:</label>
                                <input type="date" class="form-control" id="tanggal_awal">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input type="date" class="form-control" id="tanggal_akhir">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Kolom 6 untuk tombol filter -->
                            <button class="btn btn-sm btn-primary" onclick="filterData()"> <i class="fas fa-search"></i> Filter Berdasarkan Range</button>
                        </div>
                    </div>

                    <br>
                    <hr>
                    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-booking" id="tambahDataButton">
                        <i class="fas fa-plus-circle"></i> Tambah Data
                    </a>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Cabang</th>
                                <th>Tanggal Booking</th>
                                <th>Kode Resi</th>
                                <th>Nama Barang</th>
                                <th>Koli</th>
                                <th>Berat</th>
                                <th>Keterangan</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @foreach ($booking as $p)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td><b>{{ $p->nama_cabang }}</b></td>
                                    <td>{{ \Carbon\Carbon::parse($p->tanggal_booking)->format('d-m-Y') }}</td>

                                    <td>{{ $p->kode_resi}}</td>
                                    <td>{{ $p->nama_barang}}</td>
                                    <td>{{ $p->koli}}</td>
                                    <td>{{ $p->berat}}</td>
                                    <td>{{ $p->keterangan}}</td>
                                    <td>
                                        @if($p->tanggal_kirim != '')
                                        <span class="badge badge-danger"><b>Sudah melakukan transaksi</b></span>
                                        @else
                                            <!-- Tambahkan aksi jika tanggal_kirim belum terisi -->
                                            <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-edit" data-toggle="modal" data-target="#modal-booking-edit" data-id="{{ $p->id }}" style="color: black">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}" style="color: white">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                                @php $i++ @endphp
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        @endif
    @else
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_awal">Tanggal Awal:</label>
                            <input type="date" class="form-control" id="tanggal_awal">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_akhir">Tanggal Akhir:</label>
                            <input type="date" class="form-control" id="tanggal_akhir">
                        </div>
                    </div>
                </div>






                <div class="row">
                    <div class="col-md-6">
                        <!-- Kolom 6 untuk tombol filter -->
                        <button class="btn btn-sm btn-primary" onclick="filterData()"> <i class="fas fa-search"></i> Filter Berdasarkan Range</button>
                    </div>
                </div>



                <br>
                <hr>
                <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-booking" id="tambahDataButton">
                    <i class="fas fa-plus-circle"></i> Tambah Data
                </a>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Cabang</th>
                            <th>Tanggal Booking</th>
                            <th>Kode Resi</th>
                            <th>Nama Barang</th>
                            <th>Koli</th>
                            <th>Berat</th>
                            <th>Keterangan</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $i = 1 @endphp
                        @foreach ($booking as $p)
                            <tr>
                                <td>{{ $i }}</td>
                                <td><b>{{ $p->nama_cabang }}</b></td>
                                <td>{{ \Carbon\Carbon::parse($p->tanggal_booking)->format('d-m-Y')  }}</td>

                                <td>{{ $p->kode_resi}}</td>
                                <td>{{ $p->nama_barang}}</td>
                                <td>{{ $p->koli}}</td>
                                <td>{{ $p->berat}}</td>
                                <td>{{ $p->keterangan}}</td>
                                <td>
                                    @if($p->tanggal_kirim != '')
                                    <span class="badge badge-danger"><b>Sudah melakukan transaksi</b></span>
                                    @else
                                        <!-- Tambahkan aksi jika tanggal_kirim belum terisi -->
                                        <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-edit" data-toggle="modal" data-target="#modal-booking-edit" data-id="{{ $p->id }}" style="color: black">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}" style="color: white">
                                            <i class="fas fa-trash-alt"></i> Delete
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @php $i++ @endphp
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    @endif
    <!-- /.card -->

    <div class="modal fade" id="modal-booking">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Booking</h4>
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
                        <form id="form-booking" action="" method="POST" enctype="multipart/form-data">
                            @csrf <!-- Tambahkan token CSRF -->
                            <div class="card-body">
                                @hasrole('superadmin')
                                    <div class="form-group">
                                        <label for="nama_barang">Cabang</label>
                                        <select name="cabang_id" id="cabang" class="form-control">
                                            <option value="">--Pilih Cabang--</option>
                                        </select>
                                    </div>
                                @endhasrole

                                <div class="form-group">
                                    <label for="kode_resi">Kode Resi/Pengiriman</label>
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-truck"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Kode Resi/Pengiriman Anda adalah</span>
                                            <!-- Tampilkan kode_resi yang akan digunakan -->
                                            <h3 class="info-box-number" id="kodeResiDisplay">Loading...</h3>
                                            <!-- Input hidden untuk menyimpan kode_resi saat disubmit -->
                                            <input type="hidden" name="kode_resi" id="kode_resi" value="">
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>


                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="koli">Koli</label>
                                    <input type="number" class="form-control" id="koli" name="koli" placeholder="Masukkan Koli" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="berat">Berat</label>
                                    <input type="number" class="form-control" id="berat" name="berat" placeholder="Masukkan Berat" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" autocomplete="off">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btn-simpan-booking"><i class="fas fa-save"></i> Simpan</button>
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

    <div class="modal fade" id="modal-booking-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Edit Booking</h4>
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
                        <form id="form-edit-booking" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf <!-- Tambahkan token CSRF -->
                            <input type="hidden" id="id" name="id" value="">
                            <div class="card-body">
                                @hasrole('superadmin')
                                    <div class="form-group">
                                        <label for="nama_barang">Cabang</label>
                                        <select class="form-control" id="cabang_edit" disabled>
                                        </select>
                                    </div>
                                @endhasrole
                                <div class="form-group">
                                    <label for="kode_resi_edit">Kode Resi/Pengiriman</label>
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fas fa-truck"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Kode Resi/Pengiriman Anda adalah</span>
                                            <!-- Tampilkan kode_resi yang akan digunakan -->
                                            <h3 class="info-box-number" id="kode_resi_edit_text">Loading...</h3>
                                            <!-- Input hidden untuk menyimpan kode_resi saat disubmit -->
                                            <input type="hidden" name="kode_resi" id="kode_resi_edit">
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>


                                <div class="form-group">
                                    <label for="nama_barang_edit">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang_edit" name="nama_barang" placeholder="Masukkan Nama Barang">
                                </div>
                                <div class="form-group">
                                    <label for="koli_edit">Koli</label>
                                    <input type="text" class="form-control" id="koli_edit" name="koli" placeholder="Masukkan Satuan">
                                </div>
                                <div class="form-group">
                                    <label for="berat_edit">Berat</label>
                                    <input type="text" class="form-control" id="berat_edit" name="berat" placeholder="Masukkan Berat">
                                </div>
                                <div class="form-group">
                                    <label for="keterangan_edit">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan_edit" name="keterangan" placeholder="Masukkan Keterangan">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" id="btn-update-booking"><i class="fas fa-check"></i> Update</button>
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
    {{-- Default tanggal --}}
    <script>
        // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        function getTodayDate() {
            const today = new Date();
            let month = '' + (today.getMonth() + 1);
            let day = '' + today.getDate();
            const year = today.getFullYear();

            if (month.length < 2) {
                month = '0' + month;
            }
            if (day.length < 2) {
                day = '0' + day;
            }

            return [year, month, day].join('-');
        }

        // Mengatur nilai default ke input tanggal
        document.getElementById('tanggal_awal').value = getTodayDate();
        document.getElementById('tanggal_akhir').value = getTodayDate();
    </script>

    {{-- Default tanggal --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Dapatkan semua elemen dengan class btn-edit dan btn-hapus
            var editButtons = document.querySelectorAll('.btn-edit');
            var deleteButtons = document.querySelectorAll('.btn-hapus');

            // Loop melalui setiap baris tabel
            editButtons.forEach(function(btn, index) {
                var tanggalKirim = document.querySelectorAll('td[hidden]')[index].textContent.trim();

                // Cek apakah tanggal_kirim sudah terisi
                if (tanggalKirim !== '') {
                    btn.style.display = 'none'; // Sembunyikan tombol Edit
                    deleteButtons[index].style.display = 'none'; // Sembunyikan tombol Delete

                    // Tambahkan keterangan di baris tabel terkait
                    var row = deleteButtons[index].parentNode.parentNode; // Ambil baris yang berkaitan
                    var cell = row.insertCell(-1); // Tambahkan sel baru untuk keterangan
                    cell.textContent = 'Sudah melakukan transaksi'; // Isi dengan keterangan yang diinginkan
                }
            });
        });
    </script>



    <script>
        function filterData() {
            var tanggalAwal = document.getElementById('tanggal_awal').value;
            var tanggalAkhir = document.getElementById('tanggal_akhir').value;

            $.ajax({
                url: '{{ route("booking.filter") }}',
                method: 'GET',
                data: {
                    tanggal_awal: tanggalAwal,
                    tanggal_akhir: tanggalAkhir
                },
                success: function(response) {
                    // Perbarui tabel dengan data yang difilter
                    updateTable(response);
                },
                error: function(xhr, status, error) {
                    // Tangani error jika diperlukan
                    console.error(error);
                }
            });
        }

        function updateTable(data) {
            var tableBody = $('#example1 tbody');
            tableBody.empty(); // Menghapus isi tabel sebelum menambahkan data baru

            data.forEach(function(item, index) {
                var actionHtml = '';

            // Tambahkan kondisi berdasarkan tanggal_kirim
            if (item.tanggal_kirim != '') {
                actionHtml = '<span class="badge badge-danger"><b>Sudah melakukan transaksi</b></span>';
            } else {
                actionHtml = `
                    <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-edit" data-toggle="modal" data-target="#modal-booking-edit" data-id="${item.id}" style="color: black">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button class="btn btn-sm btn-danger btn-hapus" data-id="${item.id}" style="color: white">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                `;
            }

                var row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td><b>${item.nama_cabang}</b></td>
                        <td>${item.tanggal_booking}</td>
                        <td>${item.kode_resi}</td>
                        <td>${item.nama_barang}</td>
                        <td>${item.koli}</td>
                        <td>${item.berat}</td>
                        <td>${item.keterangan}</td>
                        <td>${actionHtml}</td>
                    </tr>
                `;
                tableBody.append(row);
            });
        }

    </script>

    <script>
        @hasrole('superadmin')
            document.getElementById('kodeResiDisplay').innerText = '...';

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
            }).on('select2:select', function(e) {
                var data = e.params.data;
                getKodeBooking(data.id)
            });
        @else
            document.getElementById('tambahDataButton').addEventListener('click', function() {
                const cabangId = document.getElementById('cabang_id').value;
                getKodeBooking(cabangId)
            });
        @endhasrole

        function getKodeBooking(cabangId) {
            fetch('{{ route('getLatestCode') }}')
                .then(response => response.json())
                .then(data => {
                    let latestCode = data.latestCode;
                    let userId = document.getElementById('id').value;

                    fetch(`/getKodeCabangKota/${cabangId}/${userId}`)
                        .then(response => response.json())
                        .then(result => {
                            let kodeKota = result.kode_kota;
                            let kodeCabang = result.kode_cabang;
                            let nextCode = `GCE${kodeKota}${kodeCabang}${latestCode}`;

                            console.log('Kode Resi Baru:', nextCode);
                            document.getElementById('kode_resi').value = nextCode;
                            document.getElementById('kodeResiDisplay').innerText = nextCode;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

    {{-- PERINTAH SIMPAN/SAVE DATA --}}
    <script>
        document.getElementById('form-booking').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form melakukan submit default
            const tombolSimpan = $('#btn-simpan-booking')

            // var cabangID = document.getElementById('cabang').value.trim();
            var kodeResi = document.getElementById('kode_resi').value.trim();
            var namaBarang = document.getElementById('nama_barang').value.trim();
            var koli = document.getElementById('koli').value.trim();
            var berat = document.getElementById('berat').value.trim();
            var keterangan = document.getElementById('keterangan').value.trim();

            // if (!kodeResi || !namaBarang || !koli || !berat || !cabangID || !keterangan) {
            if (!kodeResi || !namaBarang || !koli || !berat || !keterangan) {
                alert('Harap lengkapi semua bidang!');
                return;
            }

            var formData = new FormData(this);
            // formData.append('cabang_id', cabangID);
            formData.append('_token', '{{ csrf_token() }}'); // Tambahkan token CSRF ke FormData

            $.ajax({
                url: '{{ route('booking.store_booking') }}',
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
                    // var errorMessage = xhr.responseText ? xhr.responseText : 'Terjadi kesalahan saat menyimpan data';
                    // console.error('Terjadi kesalahan:', error);
                    // alert(errorMessage);
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            // console.log(xhr.responseJSON.errors)
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
    {{-- PERINTAH SIMPAN/SAVE DATA --}}

    {{-- PERINTAH EDIT/TAMPIL DATA --}}
    <script>
        $(document).ready(function() {
            $('.dataTable tbody').on('click', 'td .btn-edit', function(e) {
                e.preventDefault();
                var bookingId = $(this).data('id');


                // Ajax request untuk mendapatkan data booking
                $.ajax({
                    type: 'GET',
                    url: '/booking/' + bookingId + '/edit_booking',
                    success: function(data) {
                        // Mengisi data pada form modal
                        $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi

                        // $('#tanggal_booking_edit').val(data.tanggal_booking);
                        $('#kode_resi_edit').val(data.kode_resi);
                        $('#nama_barang_edit').val(data.nama_barang);
                        $('#koli_edit').val(data.koli);
                        $('#berat_edit').val(data.berat);
                        $('#keterangan_edit').val(data.keterangan);

                        // Menampilkan kode_resi pada input dan h3 setelah mendapatkan data
                        $('#kode_resi_edit_text').text(data.kode_resi);

                        @hasrole('superadmin')
                            $('#cabang_edit').html(`<option value="${data.cabang_id}" selected>${data.nama_cabang}</option>`)
                        @endhasrole

                        $('#modal-booking-edit').modal('show');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                // console.log(xhr.responseJSON.errors)
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
    {{-- PERINTAH EDIT/TAMPIL DATA --}}

    {{-- PERINTAH UPDATE/PERBAHARUI DATA --}}
    <script>
        $(document).ready(function() {
          // Logika untuk menampilkan data booking yang akan diedit pada modal
            $('.btn-edit').click(function(e) {
                e.preventDefault();
                var bookingId = $(this).data('id');


                // Ajax request untuk mendapatkan data booking
                $.ajax({
                    type: 'GET',
                    url: '/booking/' + bookingId + '/edit_booking',
                    success: function(data) {
                        // Mengisi data pada form modal
                        $('#id').val(data.id);
                        $('#kode_booking_edit').val(data.kode_booking);
                        $('#nama_booking_edit').val(data.nama_booking);

                        // Mengatur nilai Select2 untuk ID kota dan men-trigger agar Select2 menampilkan nama kota
                        $('#id_kota_edit').val(data.id_kota).trigger('change');

                        $('#modal-booking-edit').modal('show');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                // console.log(xhr.responseJSON.errors)
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

            // Sisanya adalah script AJAX yang sudah ada sebelumnya
            $('#btn-update-booking').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-update-booking')

                var bookingId = $('#id').val(); // Ambil ID booking dari input tersembunyi
                var formData = new FormData($('#form-edit-booking')[0]);
                var cabangID = $('#cabang_id').val(); // Ambil nilai cabang_id dari input di luar form-edit-booking

                formData.append('cabang_id', cabangID); // Menambahkan nilai cabang_id ke dalam formData

                // Lakukan permintaan Ajax untuk update data booking
                $.ajax({
                    type: 'POST', // Ganti menjadi POST
                    url: '/booking/update_booking/' + bookingId,
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
                        $('#modal-booking-edit').modal('hide');
                    },
                    complete: function()
                     {tombolUpdate.prop('disabled',false)},
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                // console.log(xhr.responseJSON.errors)
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
    {{-- PERINTAH UPDATE/PERBAHARUI DATA --}}

    {{-- PERINTAH HAPUS DATA --}}
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
                            url: '/booking/' + id,
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
    {{-- PERINTAH HAPUS DATA --}}



 @endpush



 @push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
    <style>
        .select2-container {
            width: 100% !important
        }
    </style>
@endpush
