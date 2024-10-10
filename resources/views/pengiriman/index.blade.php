@extends('layouts.app')
@section('title', 'Halaman Pengiriman')
@section('subtitle', 'Menu Pengiriman')

@section('content')

    {{-- <div class="card"> --}}
    <!-- Main content -->
    @php
        $user = Auth::user();
        $statusCabang = $user->cabang ? $user->cabang->status : null;
        $isSuperAdmin = $user->superAdmin; // Pastikan ini sesuai dengan properti superAdmin yang ada pada model User
    @endphp

    @if (!empty($user->cabang_id) && !$isSuperAdmin)
        @if ($statusCabang === 'Nonaktif')
            <div class="alert alert-warning">
                Status masih dalam masa closing
                <hr>
                {{-- <button class="btn btn-sm btn-primary btn-buka" style="color: white">
                        <i class="fas fa-ban"></i> Buka Closingan
                    </button> --}}
            </div>
        @else
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="card">
                    <form id="form-simpan-pengiriman" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12">
                                    <!-- Kolom untuk input kode resi dan nama konsumen -->
                                    <div class="form-group">
                                        <label for="kode_resi">Cari Kode Resi</label>
                                        <select class="form-control select2" style="width: 100%;" id="kode_resi"
                                            name="kode_resi">
                                            <option value="">--Pilih kode resi--</option>
                                            <!-- Opsi kode resi akan dimuat secara dinamis -->
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="konsumen">Cari Konsumen</label>
                                        <br>
                                        <a href="/" class="mb-3" data-toggle="modal"
                                            data-target="#modal-konsumen"><i class="fas fa-plus-circle"></i> Tambah
                                            Konsumen</a>
                                        <br><br>
                                        <select class="form-control select2" style="width: 100%;" id="konsumen"
                                            name="konsumen">
                                            <option value="">--Pilih konsumen--</option>
                                            <!-- Opsi konsumen akan dimuat secara dinamis -->
                                        </select>
                                    </div>
                                    <input type="hidden" name="" id="status_cad_tampil">

                                    {{-- <input type="hidden" name="konsumen_id" id="konsumen_id" value="">
                                        <input type="hidden" name="nama_konsumen_hidden" id="nama_konsumen_hidden" value=""> --}}

                                    <div class="form-group">
                                        <label for="no_konsumen">Nomor Handphone Konsumen</label>
                                        <input type="text" class="form-control" id="no_konsumen" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email_konsumen">Email Konsumen</label>
                                        <input type="text" class="form-control" id="email_konsumen" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="cabang_id_asal">Kota Asal</label>
                                        <select class="form-control select2" style="width: 100%;" id="cabang_id_asal"
                                            name="cabang_id_asal">
                                            <option value="{{ auth()->user()->cabang_id }}">
                                                {{ auth()->user()->cabang->nama_cabang ?? 'Nama Cabang Tidak Tersedia' }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <!-- Kolom untuk input kode resi dan nama konsumen -->
                                    <div class="form-group">
                                        <label for="konsumen_penerima">Cari Penerima</label>
                                        <br>
                                        <a href="/" class="mb-3" data-toggle="modal"
                                            data-target="#modal-konsumen"><i class="fas fa-plus-circle"></i> Tambah
                                            Penerima</a>
                                        <br><br>
                                        <select class="form-control select2" style="width: 100%;" id="konsumen_penerima"
                                            name="konsumen_penerima" required>
                                            <option value="">--Pilih penerima--</option>
                                            <!-- Opsi konsumen akan dimuat secara dinamis -->
                                        </select>
                                    </div>
                                    <input type="hidden" name="" id="status_cad_tampil_2">
                                    {{-- <input type="hidden" name="konsumen_id" id="konsumen_id" value="">
                                        <input type="hidden" name="nama_konsumen_penerima_hidden" id="nama_konsumen_penerima_hidden" value=""> --}}

                                    <div class="form-group">
                                        <label for="">Nomor Handphone Penerima</label>
                                        <input type="text" class="form-control" id="no_telp_penerima" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Email Penerima</label>
                                        <input type="text" class="form-control" id="email_penerima" readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="cabang_id_tujuan">Kota Tujuan</label>
                                        <select class="form-control select2" style="width: 100%;" id="cabang_id_tujuan"
                                            name="cabang_id_tujuan" required>
                                            <option value="">--Pilih kota tujuan--</option>
                                            <!-- Opsi cabang tujuan akan dimuat secara dinamis -->
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header" style="background-color: gray; color: aliceblue;">
                                            <h3 class="card-title">Tabel Pengiriman</h3>
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Barang</th>
                                                            <th>Koli</th>
                                                            <th>Berat</th>
                                                            <th>Keterangan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="text" class="form-control form-control-lg"
                                                                    style="width: 250px;" id="nama_barang"
                                                                    name="nama_barang" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-lg"
                                                                    style="width: 150px;" id="koli" name="koli"
                                                                    readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-lg"
                                                                    style="width: 100px;" id="berat" name="berat"
                                                                    readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-lg"
                                                                    style="width: 250px;" id="keterangan"
                                                                    name="keterangan" readonly>
                                                            </td>
                                                        </tr>
                                                        <!-- More rows can be added here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="keterangan_kasir">Keterangan Kasir</label>
                                        <input type="text" class="form-control" id="keterangan_kasir"
                                            name="keterangan_kasir" placeholder="Masukkan Keterangan Tambahan">
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_pembayaran">Jenis Pembayaran</label>
                                        <select class="form-control select2" style="width: 100%;" id="jenis_pembayaran"
                                            name="jenis_pembayaran" required>
                                            <option value="">--Pilih jenis pembayaran--</option>
                                            <option value="CASH">CASH</option>
                                            <option value="COD">COD</option>
                                            <option value="CAD">CAD</option>
                                        </select>
                                    </div>




                                    <div class="form-group" id="bill_to_container" style="display: none;">
                                        <label for="bill_to">Bill To</label>
                                        <select class="form-control select2" style="width: 100%;" id="bill_to"
                                            name="bill_to" required>
                                            <option value="">--Pilih bill to--</option>
                                            <!-- Opsi konsumen akan dimuat secara dinamis -->
                                        </select>
                                    </div>


                                    <div class="form-group" id="metode_pembayaran_container" style="display: none;">
                                        <label for="metode_pembayaran">Metode Pembayaran</label>
                                        <select class="form-control select2" style="width: 100%;" id="metode_pembayaran"
                                            name="metode_pembayaran">
                                            <option value="">--Pilih metode pembayaran--</option>
                                            <option value="Transfer">Transfer</option>
                                            <option value="Tunai">Tunai</option>
                                        </select>
                                    </div>

                                    <div class="form-group" id="bukti_bayar_container" style="display:none;">
                                        <label for="bukti_bayar">Upload Bukti Bayar</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="bukti_bayar">Choose file</label>
                                                <input type="file" class="custom-file-input" id="bukti_bayar"
                                                    name="bukti_bayar" onchange="previewImage(event)">
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                        <div id="preview-container" style="display:none;">
                                            <img id="preview-image" src="#" alt="Preview"
                                                style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                                        </div>
                                    </div>

                                    <script>
                                        function previewImage(event) {
                                            var input = event.target;
                                            var previewImage = document.getElementById('preview-image');
                                            var previewContainer = document.getElementById('preview-container');

                                            if (input.files && input.files[0]) {
                                                var reader = new FileReader();

                                                reader.onload = function(e) {
                                                    previewImage.src = e.target.result;
                                                    previewContainer.style.display = 'block';
                                                };

                                                reader.readAsDataURL(input.files[0]);
                                            }
                                        }
                                    </script>

                                    <div class="form-group" id="jumlah_bayar_container" style="display: none;">
                                        <label for="jumlah_bayar">Jumlah Bayar</label>
                                        <input type="text" class="form-control input-price-format" id="jumlah_bayar"
                                            name="jumlah_bayar" placeholder="Total Jumlah Bayar">
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="harga_kirim">Harga Kirim</label>
                                        <input type="text" class="form-control input-price-format" id="harga_kirim"
                                            name="harga_kirim" placeholder="Masukkan Harga Kirim">
                                    </div>
                                    <div class="form-group">
                                        <label for="sub_charge">Sub Charge</label>
                                        <input type="text" class="form-control input-price-format" id="sub_charge"
                                            name="sub_charge" placeholder="Masukkan Sub Charge" value="0" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="biaya_admin">Biaya Admin</label>
                                        <input type="text" class="form-control" id="biaya_admin" name="biaya_admin"
                                            readonly>
                                    </div>

                                    <div class="form-group">
                                        <div class="info-box">
                                            <span class="info-box-icon bg-danger"><i class="fas fa-book"></i></span>

                                            <div class="info-box-content">
                                                <span class="info-box-text">Total adalah</span>
                                                <h3 class="info-box-number">Rp. </h3>
                                                <input type="hidden" name="total_bayar" id="total_bayar">
                                            </div>
                                            <!-- /.info-box-content -->
                                        </div>
                                        <!-- /.info-box -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="btn-simpan-pengiriman"><i
                                    class="fas fa-save"></i> Simpan</button>
                            {{-- <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button> --}}
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @else
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card">
                <form id="form-simpan-pengiriman" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-12">
                                <!-- Kolom untuk input kode resi dan nama konsumen -->
                                <div class="form-group">
                                    <label for="kode_resi">Cari Kode Resi</label>
                                    <select class="form-control select2" style="width: 100%;" id="kode_resi"
                                        name="kode_resi">
                                        <option value="">--Pilih kode resi--</option>
                                        <!-- Opsi kode resi akan dimuat secara dinamis -->
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="konsumen">Cari Konsumen</label>
                                    <br>
                                    <a href="/" class="mb-3" data-toggle="modal"
                                        data-target="#modal-konsumen"><i class="fas fa-plus-circle"></i> Tambah
                                        Konsumen</a>
                                    <br><br>
                                    <select class="form-control select2" style="width: 100%;" id="konsumen"
                                        name="konsumen">
                                        <option value="">--Pilih konsumen--</option>
                                        <!-- Opsi konsumen akan dimuat secara dinamis -->
                                    </select>
                                </div>



                                <div class="form-group">
                                    <label for="no_konsumen">Nomor Handphone Konsumen</label>
                                    <input type="text" class="form-control" id="no_konsumen" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="email_konsumen">Email Konsumen</label>
                                    <input type="text" class="form-control" id="email_konsumen" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="cabang_id_asal">Kota Asal</label>
                                    <select class="form-control select2" style="width: 100%;" id="cabang_id_asal"
                                        name="cabang_id_asal">
                                        <option value="{{ auth()->user()->cabang_id }}">
                                            {{ auth()->user()->cabang->nama_cabang ?? 'Nama Cabang Tidak Tersedia' }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <!-- Kolom untuk input kode resi dan nama konsumen -->
                                <div class="form-group">
                                    <label for="konsumen_penerima">Cari Penerima</label>
                                    <br>
                                    <a href="/" class="mb-3" data-toggle="modal"
                                        data-target="#modal-konsumen"><i class="fas fa-plus-circle"></i> Tambah
                                        Penerima</a>
                                    <br><br>
                                    <select class="form-control select2" style="width: 100%;" id="konsumen_penerima"
                                        name="konsumen_penerima" required>
                                        <option value="">--Pilih penerima--</option>
                                        <!-- Opsi konsumen akan dimuat secara dinamis -->
                                    </select>
                                </div>



                                <div class="form-group">
                                    <label for="">Nomor Handphone Penerima</label>
                                    <input type="text" class="form-control" id="no_telp_penerima" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="">Email Penerima</label>
                                    <input type="text" class="form-control" id="email_penerima" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="cabang_id_tujuan">Kota Tujuan</label>
                                    <select class="form-control select2" style="width: 100%;" id="cabang_id_tujuan"
                                        name="cabang_id_tujuan" required>
                                        <option value="">--Pilih kota tujuan--</option>
                                        <!-- Opsi cabang tujuan akan dimuat secara dinamis -->
                                    </select>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header" style="background-color: gray; color: aliceblue;">
                                        <h3 class="card-title">Tabel Pengiriman</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Barang</th>
                                                        <th>Koli</th>
                                                        <th>Berat</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg"
                                                                style="width: 250px;" id="nama_barang" name="nama_barang"
                                                                readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg"
                                                                style="width: 150px;" id="koli" name="koli"
                                                                readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg"
                                                                style="width: 100px;" id="berat" name="berat"
                                                                readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg"
                                                                style="width: 250px;" id="keterangan" name="keterangan"
                                                                readonly>
                                                        </td>
                                                    </tr>
                                                    <!-- More rows can be added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="keterangan_kasir">Keterangan Kasir</label>
                                    <input type="text" class="form-control" id="keterangan_kasir"
                                        name="keterangan_kasir" placeholder="Masukkan Keterangan Tambahan">
                                </div>
                                <div class="form-group">
                                    <label for="jenis_pembayaran">Jenis Pembayaran</label>
                                    <select class="form-control select2" style="width: 100%;" id="jenis_pembayaran"
                                        name="jenis_pembayaran" required>
                                        <option value="">--Pilih jenis pembayaran--</option>
                                        <option value="CASH">CASH</option>
                                        <option value="COD">COD</option>
                                        <option value="CAD">CAD</option>
                                    </select>
                                </div>

                                <div class="form-group" id="metode_pembayaran_container" style="display: none;">
                                    <label for="metode_pembayaran">Metode Pembayaran</label>
                                    <select class="form-control select2" style="width: 100%;" id="metode_pembayaran"
                                        name="metode_pembayaran">
                                        <option value="">--Pilih metode pembayaran--</option>
                                        <option value="Transfer">Transfer</option>
                                        <option value="Tunai">Tunai</option>
                                    </select>
                                </div>



                                <div class="form-group" id="bukti_bayar_container" style="display:none;">
                                    <label for="bukti_bayar">Upload Bukti Bayar</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="bukti_bayar">Choose file</label>
                                            <input type="file" class="custom-file-input" id="bukti_bayar"
                                                name="bukti_bayar" onchange="previewImage(event)">
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                    <div id="preview-container" style="display:none;">
                                        <img id="preview-image" src="#" alt="Preview"
                                            style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                                    </div>
                                </div>

                                <script>
                                    function previewImage(event) {
                                        var input = event.target;
                                        var previewImage = document.getElementById('preview-image');
                                        var previewContainer = document.getElementById('preview-container');

                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                previewImage.src = e.target.result;
                                                previewContainer.style.display = 'block';
                                            };

                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>


                                <div class="form-group" id="jumlah_bayar_container" style="display: none;">
                                    <label for="jumlah_bayar">Jumlah Bayar</label>
                                    <input type="text" class="form-control input-price-format" id="jumlah_bayar"
                                        name="jumlah_bayar" placeholder="Total Jumlah Bayar">
                                </div>

                            </div>

                            <div class="col-md-6 col-sm-6 col-12">

                                <div class="form-group">
                                    <label for="harga_kirim">Harga Kirim</label>
                                    <input type="text" class="form-control input-price-format" id="harga_kirim"
                                        name="harga_kirim" placeholder="Masukkan Harga Kirim">
                                </div>
                                <div class="form-group">
                                    <label for="sub_charge">Sub Charge</label>
                                    <input type="text" class="form-control input-price-format" id="sub_charge"
                                        name="sub_charge" placeholder="Masukkan Sub Charge" required>
                                </div>




                                <div class="form-group">
                                    <label for="biaya_admin">Biaya Admin</label>
                                    <input type="text" class="form-control" id="biaya_admin" name="biaya_admin"
                                        readonly>
                                </div>


                                <div class="form-group">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i class="fas fa-book"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total adalah</span>
                                            <h3 class="info-box-number">Rp. </h3>
                                            <input type="hidden" name="total_bayar" id="total_bayar">
                                        </div>
                                        <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>

                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="btn-simpan-pengiriman"><i
                                class="fas fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span> Close</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    {{-- </div> --}}

    <div class="modal fade" id="modal-konsumen">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Konsumen</h4>
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
                        <form id="form-konsumen" action="{{ route('konsumen.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf <!-- Tambahkan token CSRF -->
                            <div class="card-body">
                                <div class="form-group" hidden>
                                    <label for="status_cad">Status CAD</label>
                                    <select name="status_cad" id="status_cad" class="form-control">
                                        <option value="Non CAD">Non CAD</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_konsumen">Nama Konsumen</label>
                                    <input type="text" class="form-control" id="nama_konsumen" name="nama_konsumen"
                                        placeholder="Masukkan Nama Konsumen" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_konsumen">Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="nama_perusahaan"
                                        name="nama_perusahaan" placeholder="Masukkan Nama Perusahaan">
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">No Telp</label>
                                    <input type="number" class="form-control input-phone-number" id="no_telp"
                                        name="no_telp" placeholder="Masukkan No Telp" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Masukkan Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea name="alamat" class="form-control" id="alamat" cols="20" rows="5" required></textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="btn-simpan-konsumen"><i
                                        class="fas fa-save"></i> Simpan</button>
                                <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span
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
    <div class="modal fade" id="modal-cetak-resi" tabindex="-1" role="dialog"
        aria-labelledby="modal-cetak-resi-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Resi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="resi-old modal-detail-resi" style="height: 78vh"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-cetak-resi"><i class="fas fa-print"></i> Cetak</button>
                </div>
            </div>
        </div>
    </div>
    <div class="print-element d-none"></div @endsection @push('script') <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    @include('js.cleave-js')

    {{-- SKRIP TAMBAHAN  --}}
    <script>
        $(document).ready(function() {
            initPriceFormat()
            // Lakukan permintaan AJAX untuk mendapatkan nilai biaya_pembatalan dari tabel profil
            $.ajax({
                url: '/getBiayaPembatalan', // Ganti dengan URL yang sesuai untuk mendapatkan biaya_pembatalan dari tabel profil
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Isi input biaya_pembatalan dengan nilai yang diterima dari tabel profil
                    $('#biaya_pembatalan').val(data.biaya_pembatalan);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Atur nilai input biaya_pembatalan ke 0 atau pesan error jika tidak berhasil memuat data
                    $('#biaya_pembatalan').val(0);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#jenis_pembayaran').on('change', function() {
                var selectedJenisPembayaran = $(this).val();

                // Lakukan permintaan AJAX untuk mendapatkan nilai biaya_admin dari tabel profil
                $.ajax({
                    url: '/getBiayaAdmin', // Ganti dengan URL yang sesuai untuk mendapatkan biaya_admin dari tabel profil
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Isi input biaya_admin dengan nilai yang diterima dari tabel profil
                        $('#biaya_admin').val(numeral(data.biaya_admin).format('0,0'));
                        calculateTotal();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Atur nilai input biaya_admin ke 0 atau pesan error jika tidak berhasil memuat data
                        $('#biaya_admin').val(0);
                    }
                });

                // Jika jenis pembayaran adalah "CASH", tampilkan form-group untuk metode_pembayaran
                if (selectedJenisPembayaran === 'CASH') {
                    $('#metode_pembayaran_container').show();
                    $('#bill_to_container').hide();

                    // Fungsi untuk memformat angka dengan pemisah ribuan
                    // function formatNumber(number) {
                    //   return Number(number).toLocaleString('id-ID'); // Ganti 'id-ID' dengan kode bahasa yang sesuai
                    // }
                } else if (selectedJenisPembayaran === 'CAD') {
                    $('#bill_to_container').show();
                    $('#metode_pembayaran_container').hide();
                    $('#metode_pembayaran').val('');
                    $('#jumlah_bayar_container').hide();
                    $('#bukti_bayar_container').hide();
                    // Kosongkan input biaya_admin jika jenis pembayaran bukan "CASH"
                    $('#biaya_admin').val('');
                } else {

                    // Lakukan permintaan AJAX untuk mendapatkan nilai biaya_admin dari tabel profil
                    // Sembunyikan form-group untuk metode_pembayaran jika jenis pembayaran bukan "CASH" atau "CAD"
                    $('#metode_pembayaran_container').hide();
                    $('#bill_to_container').hide(); // tambahan untuk menyembunyikan #bill_to_container
                    $('#metode_pembayaran').val('');
                    $('#jumlah_bayar_container').hide();
                    $('#bukti_bayar_container').hide();
                    // Kosongkan input biaya_admin jika jenis pembayaran bukan "CASH" atau "CAD"
                    $('#biaya_admin').val('');
                }

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#metode_pembayaran').on('change', function() {
                var selectedMetodePembayaran = $(this).val();

                // Sembunyikan semua form-group terlebih dahulu
                $('#bukti_bayar_container, #jumlah_bayar_container').hide();

                // Jika metode pembayaran adalah "Transfer", tampilkan form-group bukti bayar dan jumlah bayar
                if (selectedMetodePembayaran === 'Transfer') {
                    $('#bukti_bayar_container, #jumlah_bayar_container').show();
                } else if (selectedMetodePembayaran === 'Tunai') {
                    // Jika metode pembayaran adalah "Tunai", tampilkan hanya form-group jumlah bayar
                    $('#jumlah_bayar_container').show();
                }
            });
        });
    </script>

    {{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}
    <script>
        $(document).ready(function() {
            // Mendapatkan data awal untuk kode resi
            $.ajax({
                url: '/getResiData', // Ganti dengan URL yang sesuai untuk memuat data kode resi
                dataType: 'json',
                success: function(data) {
                    var initialResiData = $.map(data.slice(0, 5), function(item) {
                        return {
                            text: item.kode_resi,
                            id: item.id
                        };
                    });

                    $('#kode_resi').select2({
                        minimumInputLength: 1,
                        data: initialResiData,
                        ajax: {
                            url: '/getResiData',
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.kode_resi,
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


            // Event handler untuk opsi konsumen
            $('#konsumen').on('change', function() {
                var status_cad_tampil = $(this).find('option:selected').data('status-cad');
                $('#status_cad_tampil').val(status_cad_tampil).trigger('change');
            });

            // Event handler untuk opsi konsumen penerima
            $('#konsumen_penerima').on('change', function() {
                var status_cad_tampil_2 = $(this).find('option:selected').data('status-cad');
                $('#status_cad_tampil_2').val(status_cad_tampil_2).trigger('change');
            });

            // Fungsi untuk menyesuaikan opsi jenis_pembayaran berdasarkan status CAD
            function handlePaymentOption(status_cad_1, status_cad_2) {
                if (status_cad_1 === 'CAD' || status_cad_2 === 'CAD') {
                    // Jika salah satu atau kedua status CAD
                    $('#jenis_pembayaran option[value="CASH"]').show();
                    $('#jenis_pembayaran option[value="COD"]').show();
                    $('#jenis_pembayaran option[value="CAD"]').show();
                } else {
                    // Jika tidak ada atau keduanya non-CAD
                    $('#jenis_pembayaran option[value="CASH"]').show();
                    $('#jenis_pembayaran option[value="COD"]').show();
                    $('#jenis_pembayaran option[value="CAD"]').hide();
                    $('#bill_to_container').hide();
                }
            }

            // Inisialisasi select2 untuk opsi konsumen
            $('#konsumen').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '/getKonsumenData',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama_konsumen + ' - ' + item
                                        .no_telp, // Menampilkan nama dan nomor telepon
                                    id: item.id,
                                    no_telp: item.no_telp,
                                    status_cad: item.status_cad,
                                    email: item.email
                                };
                            })
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                $('#status_cad_tampil').val(data.status_cad); // Menampilkan status CAD
                $('#no_konsumen').val(data.no_telp); // Menampilkan nomor telepon konsumen
                $('#email_konsumen').val(data.email); // Menampilkan email konsumen
                // Menyesuaikan opsi jenis_pembayaran berdasarkan status CAD
                handlePaymentOption($('#status_cad_tampil').val(), $('#status_cad_tampil_2').val());
            }).trigger('change'); // Trigger event change saat inisialisasi


            // Inisialisasi select2 untuk opsi konsumen penerima
            $('#konsumen_penerima').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '/getKonsumenPenerimaData',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama_konsumen + ' - ' + item
                                    .no_telp, // Menampilkan nama dan nomor telepon
                                    id: item.id,
                                    no_telp: item.no_telp,
                                    status_cad: item.status_cad,
                                    email: item.email
                                };
                            })
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                $('#status_cad_tampil_2').val(data.status_cad); // Menampilkan status CAD
                $('#no_telp_penerima').val(data.no_telp); // Menampilkan nomor telepon penerima
                $('#email_penerima').val(data.email); // Menampilkan email penerima
                // Menyesuaikan opsi jenis_pembayaran berdasarkan status CAD
                handlePaymentOption($('#status_cad_tampil').val(), $('#status_cad_tampil_2').val());
            }).trigger('change'); // Trigger event change saat inisialisasi



            $('#bill_to').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '/getBillTo',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            term: params.term,
                            selectedKonsumen: {
                                konsumen: $('#konsumen')
                            .val(), // Kirim nilai konsumen yang dipilih dari input #konsumen
                                konsumenPenerima: $('#konsumen_penerima')
                                .val() // Kirim nilai konsumen yang dipilih dari input #konsumen_penerima
                            }
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.nama_konsumen + ' - ' + item
                                    .no_telp, // Menampilkan nama dan nomor telepon
                                    id: item.id,
                                    no_telp: item.no_telp,
                                    email: item.email
                                };
                            })
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function(e) {
                var data = e.params.data;
                // Tambahkan kode Anda di sini untuk menangani peristiwa select2:select
            });


            // Mendapatkan data awal untuk cabang tujuan
            $.ajax({
                url: '/getCabangData', // Ganti dengan URL yang sesuai untuk memuat data asal
                dataType: 'json',
                success: function(data) {
                    var initialCabangData = $.map(data.slice(0, 5), function(item) {
                        return {
                            text: item.nama_cabang,
                            id: item.id
                        };
                    });

                    $('#cabang_id_tujuan').select2({
                        minimumInputLength: 1,
                        data: initialCabangData,
                        ajax: {
                            url: '/getCabangData',
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
                }
            });

            // Mendapatkan data terkait setelah memilih kode resi
            $('#kode_resi').on('change', function() {
                var selectedResi = $(this).val();

                // Lakukan permintaan AJAX untuk mendapatkan data terkait dengan kode resi yang dipilih
                $.ajax({
                    url: '/getDetailResiData', // Ubah sesuai dengan URL yang sesuai untuk mendapatkan data terkait kode resi
                    data: {
                        term: selectedResi
                    },
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data)
                        // Isi input dengan data yang diterima
                        // if (data.length > 0) {
                        $('#nama_barang').val(data.nama_barang);
                        $('#koli').val(data.koli);
                        $('#berat').val(data.berat);
                        $('#keterangan').val(data.keterangan);
                        // }
                    }
                });
            });
        });
    </script>
    {{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}

    {{-- perintah simpan data --}}

    <script>
        document.getElementById('form-konsumen').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form melakukan submit default
            const tombolSimpan = $('#btn-simpan-konsumen')
            var namaKonsumen = document.getElementById('nama_konsumen').value.trim();
            var noTelp = document.getElementById('no_telp').value.trim();
            var email = document.getElementById('email').value.trim();
            var alamat = document.getElementById('alamat').value.trim();

            const form = $('#form-konsumen')

            if (!form[0].checkValidity()) {
                form[0].reportValidity()
                return false;
            }

            var formData = new FormData(this);

            $.ajax({
                url: '/simpan-konsumen', // Ganti dengan URL endpoint Anda
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('form').find('.error-message').remove()
                    tombolSimpan.prop('disabled', true)
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
                            location
                                .reload(); // Merefresh halaman saat pengguna menekan OK pada SweetAlert
                        }
                    });
                },
                complete: function() {
                    tombolSimpan.prop('disabled', false)
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            console.log(xhr.responseJSON.errors)
                            $.each(xhr.responseJSON.errors, function(i, item) {
                                $('form').find(
                                    `input[name="${i}"],select[name="${i}"],textarea[name="${i}"]`
                                ).closest('div').append(
                                    `<small class="error-message text-danger">${item}</small>`
                                )
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

    <script>
        const baseUrl = '{{ url('') }}'

        $(document).ready(function() {
            $('#btn-simpan-pengiriman').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-simpan-pengiriman')
                var jumlahBayar = parseFloat($('#jumlah_bayar').val().replaceAll(',', ''));
                var totalBayar = parseFloat($('#total_bayar').val().replaceAll(',', ''));
                var jenisPembayaran = $('#jenis_pembayaran').val();

                if (jumlahBayar < totalBayar) {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Jumlah bayar tidak boleh kurang dari total bayar.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                var requiredFields = ['konsumen', 'konsumen_penerima', 'cabang_id_tujuan', 'sub_charge',
                    'harga_kirim', 'jenis_pembayaran'
                ];
                var requiredFieldName = {
                    'konsumen': 'Nama Konsumen',
                    'konsumen_penerima': 'Nama konsumen penerima',
                    'cabang_id_tujuan': 'Cabang tujuan',
                    'sub_charge': 'Sub charge',
                    'harga_kirim': 'Harga kirim',
                    'jenis_pembayaran': 'Jenis pembayaran'
                }

                var emptyFields = [];

                requiredFields.forEach(function(fieldId) {
                    var fieldValue = $('#' + fieldId).val().trim();

                    if (!fieldValue) {
                        emptyFields.push(requiredFieldName[fieldId]);
                    }
                });

                if (emptyFields.length > 0) {
                    var emptyFieldsText = emptyFields.join(', ');
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Field berikut wajib diisi: ' + emptyFieldsText,
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                var kembalian = jumlahBayar - totalBayar;
                var kodeResi = $('#kode_resi').val();
                var formData = new FormData($('#form-simpan-pengiriman')[0]);
                // var konsumenId = $('#konsumen_id').val();
                // var namaKonsumen = $('#nama_konsumen_hidden').val();
                // var namaKonsumenPenerima = $('#nama_konsumen_penerima_hidden').val();
                var totalBayar = $('#total_bayar').val();
                var cabangIdAsal = $('#cabang_id_asal').val();
                var cabangIdTujuan = $('#cabang_id_tujuan').val();
                var keterangan_kasir = $('#keterangan_kasir').val();

                // formData.append('konsumen_id', konsumenId);
                // formData.append('nama_konsumen_hidden', namaKonsumen);
                // formData.append('nama_konsumen_penerima_hidden', namaKonsumenPenerima);
                formData.append('total_bayar', totalBayar);
                formData.append('cabang_id_asal', cabangIdAsal);
                formData.append('cabang_id_tujuan', cabangIdTujuan);
                formData.append('keterangan_kasir', keterangan_kasir);

                $.ajax({
                    type: 'POST',
                    url: '/pengiriman/update_pengiriman/' + kodeResi,
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('form').find('.error-message').remove()
                        tombolUpdate.prop('disabled', true)
                    },
                    success: function(response) {
                        if (jenisPembayaran === 'CASH') {
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil diperbarui. Kembalian: ' + numeral(
                                    kembalian).format('0,0'),
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed || result.isDismissed) {
                                    printResi(kodeResi)
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil diperbarui.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed || result.isDismissed) {
                                    printResi(kodeResi)
                                }
                            });
                        }
                        $('#modal-pengiriman').modal('hide');
                    },
                    complete: function() {
                        tombolUpdate.prop('disabled', false)
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                console.log(xhr.responseJSON.errors)
                                $.each(xhr.responseJSON.errors, function(i, item) {
                                    $('form').find(
                                        `input[name="${i}"],select[name="${i}"],textarea[name="${i}"]`
                                    ).closest('div.form-group').append(
                                        `<small class="error-message text-danger">${item}</small>`
                                    )
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

            function printResi(id) {
                $('.btn-cetak-resi').attr('data-id', id)
                $(`<iframe src="${baseUrl}/resi/${id}/detail" class="iframe-resi" frameborder="0" style="width:100%;height:100%"></iframe>`)
                    .appendTo('.modal-detail-resi');

                // Tampilkan modal
                $('#modal-cetak-resi').modal('show');
            }

            $('.btn-cetak-resi').on('click', function() {
                const resiId = $(this).attr('data-id');
                $('.print-element').html(
                    `<iframe src="${baseUrl}/resi/${resiId}/detail?print=true" class="iframe-resi" frameborder="0" style="width:100%;height:100%"></iframe>`
                );
            })

            $("#modal-cetak-resi").on('hide.bs.modal', function() {
                location.reload()
            });
        });
    </script>

    <script>
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>

    <script>
        // Fungsi untuk memformat angka dengan pemisah ribuan
        function formatNumber(number) {
            return Number(number).toLocaleString('id-ID'); // Ganti 'id-ID' dengan kode bahasa yang sesuai
        }

        const biayaKirimInput = document.getElementById('harga_kirim');
        const subChargeInput = document.getElementById('sub_charge');
        const biayaAdminInput = document.getElementById('biaya_admin');
        const totalBayarInput = document.getElementById('total_bayar');

        function calculateTotal() {
            const biayaKirim = parseFloat(biayaKirimInput.value.replaceAll(',', '')) || 0;
            const subCharge = parseFloat(subChargeInput.value.replaceAll(',', '')) || 0;
            const biayaAdmin = parseFloat(biayaAdminInput.value.replaceAll(',', '')) || 0;

            const totalBiaya = biayaKirim + subCharge + biayaAdmin;

            const resultElement = document.querySelector('.info-box-number');
            resultElement.textContent = 'Rp. ' + formatNumber(totalBiaya);

            totalBayarInput.value = totalBiaya; // Mengubah nilai input jumlah_bayar
        }

        biayaKirimInput.addEventListener('input', calculateTotal);
        subChargeInput.addEventListener('input', calculateTotal);
        biayaAdminInput.addEventListener('change', calculateTotal);

        calculateTotal(); // Memanggil calculateTotal() saat halaman dimuat
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
                            url: '{{ route('buka.closing') }}',
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
@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush
