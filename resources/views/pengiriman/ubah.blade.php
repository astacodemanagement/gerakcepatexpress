@extends('layouts.app')
@section('title', 'Halaman Pengiriman')
@section('subtitle', 'Menu Pengiriman')

@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="card">
        <div class="card-body">
            <div class="col-md-12 col-sm-12 col-12">
                <form action="">
                    <label for="tanggal_awal">Tanggal Awal:</label>
                    <input type="date" class="form-control" id="tanggal_awal" name="start_date"
                        value="{{ $filterStartDate }}">
                    <br>
                    <label for="tanggal_akhir">Tanggal Akhir:</label>
                    <input type="date" class="form-control" id="tanggal_akhir" name="end_date"
                        value="{{ $filterEndDate }}">

                    <br>
                    {{-- <button class="btn btn-sm btn-primary" onclick="filterData()"> <i class="fas fa-search"></i> Filter Berdasarkan Range</button> --}}
                    <button class="btn btn-sm btn-primary"> <i class="fas fa-search"></i> Filter Berdasarkan Range</button>
                </form>
                <br>
                <hr>
            </div>

            <br>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Cabang</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Tanggal Penerimaan</th>
                        <th>Kode Resi</th>
                        <th>Nama Pengirim</th>

                        <th>Nama Barang</th>
                        <th>Koli</th>
                        <th>Berat</th>
                        <th>Jumlah</th>
                        <th>Jenis Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th width="10%">Aksi</th>

                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    @foreach ($pengiriman as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $p->cabang->nama_cabang ?? 'Tidak tersedia' }}</td>
                            <td>{{ $p->tanggal_kirim }}</td>
                            <td>{{ $p->tanggal_terima }}</td>
                            <td>{{ $p->kode_resi }}</td>
                            <td>{{ $p->nama_konsumen }}</td>

                            <td>{{ $p->nama_barang }}</td>
                            <td>{{ $p->koli }}</td>
                            <td>{{ $p->berat }}</td>
                            <td>Rp. {{ number_format($p->total_bayar) }}</td>
                            <td>{{ $p->jenis_pembayaran }}</td>
                            <td>{{ $p->metode_pembayaran }}</td>
                            <td>
                                <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-edit"
                                    data-toggle="modal" data-target="#modal-cabang-edit" data-id="{{ $p->id }}"
                                    style="color: black">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                            </td>

                        </tr>
                        <?php $i++; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    {{-- SCRIPT TAMBAHAN --}}
    <!-- jQuery -->
    <script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('template') }}/plugins/jquery-ui/jquery-ui.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


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
                        <form id="form-edit-transaksi" method="POST" enctype="multipart/form-data">
                            @method('PUT') <!-- Pastikan metode PUT jika diperlukan -->
                            @csrf
                            <input type="hidden" id="id" name="id" value="">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_barang_edit">Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang_edit" name="nama_barang"
                                        placeholder="Masukkan Nama Barang">
                                </div>
                                <div class="form-group">
                                    <label for="jenis_pembayaran_edit">Jenis Pembayaran</label>
                                    <select class="form-control select2" style="width: 100%;" id="jenis_pembayaran_edit"
                                        name="jenis_pembayaran" required>
                                        <option value="">--Pilih jenis pembayaran--</option>
                                        <option value="CASH">CASH</option>
                                        <option value="COD">COD</option>
                                        <option value="CAD">CAD</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="koli_edit">Koli</label>
                                    <input type="text" class="form-control" id="koli_edit" name="koli"
                                        placeholder="Masukkan Koli">
                                </div>

                                <div class="form-group">
                                    <label for="berat_edit">Berat</label>
                                    <input type="text" class="form-control" id="berat_edit" name="berat"
                                        placeholder="Masukkan Berat">
                                </div>

                                <div class="form-group">
                                    <label for="harga_kirim_edit">Harga Kirim</label>
                                    <input type="text" class="form-control" id="harga_kirim_edit" name="harga_kirim"
                                        placeholder="Masukkan Harga Kirim">
                                </div>

                                <div class="form-group">
                                    <label for="sub_charge_edit">Sub Charge</label>
                                    <input type="text" class="form-control" id="sub_charge_edit" name="sub_charge"
                                        placeholder="Masukkan Sub Charge">
                                </div>

                                <div class="form-group">
                                    <label for="biaya_admin_edit">Biaya Admin</label>
                                    <input type="text" class="form-control" id="biaya_admin_edit" name="biaya_admin"
                                        placeholder="Masukkan Biaya Admin">
                                </div>

                                <div class="form-group">
                                    <label for="total_bayar_edit">Total Bayar</label>
                                    <input type="text" class="form-control" id="total_bayar_edit" name="total_bayar"
                                        placeholder="Masukkan Total Bayar" readonly>
                                </div>





                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" id="btn-update-transaksi"><i
                                        class="fas fa-check"></i> Update</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                        aria-hidden="true">&times;</span> Close</button>
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
@endsection

@push('script')
    {{-- SKRIP TAMBAHAN --}}


    <script>
        $(document).ready(function() {
            function calculateTotal() {
                var hargaKirim = parseFloat($('#harga_kirim_edit').val()) || 0;
                var subCharge = parseFloat($('#sub_charge_edit').val()) || 0;
                var biayaAdmin = parseFloat($('#biaya_admin_edit').val()) || 0;

                var totalBayar = hargaKirim + subCharge + biayaAdmin;
                $('#total_bayar_edit').val(totalBayar.toFixed(0));
            }

            // Event listener untuk mengupdate total bayar ketika input berubah
            $('#harga_kirim_edit, #sub_charge_edit, #biaya_admin_edit').on('input', function() {
                calculateTotal();
            });

            // Jika ada data awal, hitung total bayar saat halaman dimuat
            calculateTotal();
        });
    </script>



    {{-- perintah edit data --}}
    <script>
        $(document).ready(function() {
            $('.dataTable tbody').on('click', 'td .btn-edit', function(e) {
                e.preventDefault();
                var pengirimanId = $(this).data('id');

                // Ajax request untuk mendapatkan data cabang
                $.ajax({
                    type: 'GET',
                    url: '/ubah_pengiriman/' + pengirimanId + '/edit',
                    success: function(data) {
                        // Mengisi data pada form modal
                        $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi
                        $('#nama_barang_edit').val(data.nama_barang);
                        $('#koli_edit').val(data.koli);
                        $('#berat_edit').val(data.berat);
                        $('#harga_kirim_edit').val(data.harga_kirim);
                        $('#sub_charge_edit').val(data.sub_charge);
                        $('#biaya_admin_edit').val(data.biaya_admin);
                        $('#total_bayar_edit').val(data.total_bayar);
                        $('#jenis_pembayaran_edit').val(data.jenis_pembayaran);
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
    <script>
        $(document).ready(function() {
            $('#btn-update-transaksi').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-update-transaksi');
                var transaksiId = $('#id').val(); // Ambil ID transaksi dari input tersembunyi
                var formData = new FormData($('#form-edit-transaksi')[0]); // Gunakan form transaksi
                const form = $('#form-edit-transaksi');

                if (!form[0].checkValidity()) {
                    form[0].reportValidity();
                    return false;
                }

                // Lakukan permintaan Ajax untuk update data transaksi
                $.ajax({
                    type: 'POST', // Ganti menjadi POST
                    url: '/ubah_pengiriman/' +
                        transaksiId, // Sesuaikan URL dengan rute update transaksi
                    data: formData,
                    // headers: {
                    //     'X-HTTP-Method-Override': 'PUT' // Menggunakan header untuk menentukan metode PUT
                    // },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('form').find('.error-message').remove();
                        tombolUpdate.prop('disabled', true);
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
                                location
                                    .reload(); // Merefresh halaman saat pengguna menekan OK pada SweetAlert
                            }
                        });
                        // Tutup modal atau lakukan sesuatu setelah update berhasil
                        $('#modal-transaksi-edit').modal('hide');
                    },
                    complete: function() {
                        tombolUpdate.prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                console.log(xhr.responseJSON.errors);
                                $.each(xhr.responseJSON.errors, function(i, item) {
                                    $('form').find(
                                        `input[name="${i}"],select[name="${i}"],textarea[name="${i}"]`
                                    ).closest('div').append(
                                        `<small class="error-message text-danger">${item}</small>`
                                    );
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan',
                                    text: xhr.responseJSON.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: '',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>

    {{-- perintah update data --}}
@endpush
