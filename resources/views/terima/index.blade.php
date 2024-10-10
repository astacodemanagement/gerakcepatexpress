
@extends('layouts.app')
@section('title','Halaman Penerimaan')
@section('subtitle','Menu Penerimaan')

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
            <!-- Main content -->
            <div class="form-group">
                <label for="kode_resi">Cari Kode Resi</label>
                <select class="form-control select2" style="width: 100%;" id="kode_resi" name="kode_resi">
                    <option value="">--Pilih kode resi--</option>
                    <!-- Opsi kode resi akan dimuat secara dinamis -->
                </select>
            </div>
            <hr>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="form-simpan-pengiriman" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                            <div class="form-group">
                            <label for="tanggal_terima">Tanggal Penerimaan</label>
                            <input type="date" class="form-control" id="tanggal_terima" name="tanggal_terima" readonly>
                            </div>
                            <script>
                            // Dapatkan elemen input tanggal
                                const inputTanggal1 = document.getElementById('tanggal_terima');

                                // Dapatkan tanggal hari ini dalam format YYYY-MM-DD
                                const today = new Date().toISOString().split('T')[0];

                                // Set nilai default input tanggal menjadi tanggal hari ini
                                inputTanggal1.value = today;

                            </script>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="kode_resi_tampil">Kode Resi</label>
                                    <input type="text" class="form-control" id="kode_resi_tampil" name="kode_resi" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="nama_konsumen">Nama Konsumen</label>
                                    <input type="text" class="form-control" id="nama_konsumen" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama_konsumen_penerima">Nama Penerima</label>
                                    <input type="text" class="form-control" id="nama_konsumen_penerima"   readonly>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                            <!-- Kolom untuk input kode resi dan nama konsumen -->

                            <div class="form-group">
                                <label for="cabang_id_asal">Kota Asal</label>
                                <input type="text" class="form-control" id="cabang_id_asal" name="cabang_id_asal" readonly>
                            </div>

                            <div class="form-group">
                                <label for="cabang_id_tujuan">Kota Tujuan</label>
                                <input type="text" class="form-control" id="cabang_id_tujuan" name="cabang_id_tujuan" readonly>
                            </div>

                            </div>

                        </div>

                        <div class="row">
                           <div class="col-12">
                                <div class="card">
                                    <div class="card-header" style="background-color: gray; color: aliceblue;">
                                        <h3 class="card-title">Tabel Penerimaan</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Barang</th>
                                                        <th>Koli</th>
                                                        <th>Berat</th>
                                                        <th>Keterangan</th>
                                                        <th>Ket Kasir</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 250px;" id="nama_barang" name="nama_barang" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 150px;" id="koli" name="koli" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 100px;" id="berat" name="berat" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 250px;" id="keterangan" name="keterangan" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 250px;" id="keterangan_kasir" name="keterangan_kasir" readonly>
                                                        </td>
                                                    </tr>
                                                    <!-- More rows can be added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>



                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="jenis_pembayaran">Jenis Pembayaran</label>
                                    <input type="text" class="form-control" id="jenis_pembayaran" name="jenis_pembayaran" readonly>
                                </div>

                                {{-- <div class="form-group" id="metode_pembayaran_container"  > --}}
                                <div class="form-group" id="metode_pembayaran_container" style="display: none;">
                                    <label for="metode_pembayaran">Metode Pembayaran</label>
                                    <select class="form-control select2" style="width: 100%;" id="metode_pembayaran" name="metode_pembayaran" required>
                                    <option value="">--Pilih metode pembayaran--</option>
                                    <option value="Transfer">Transfer</option>
                                    <option value="Tunai">Tunai</option>
                                </select>
                            </div>


                            <div class="form-group" id="bukti_bayar_container" style="display: none;">
                                <label for="bukti_bayar">Upload Bukti Bayar</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="bukti_bayar" name="bukti_bayar" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(event)">
                                        <label class="custom-file-label" for="bukti_bayar">Choose file</label>
                                    </div>
                                </div>
                                <div id="preview-container" style="display:none;">
                                    <img id="preview-image" src="#" alt="..." class="d-none" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                                </div>
                                <!-- Tempat untuk menampilkan bukti_pengiriman -->
                                <a id="link-bukti_bayar_penerimaan" href="#" target="_blank">
                                    <img id="bukti_bayar-penerimaan" class="d-none" style="max-width:100px; max-height:100px" src="#" alt="..">
                                </a>
                            </div>

                            {{-- <div class="form-group" id="jumlah_bayar_container"  > --}}
                            <div class="form-group" id="jumlah_bayar_container" style="display: none;">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="text" class="form-control input-price-format" id="jumlah_bayar" name="jumlah_bayar" readonly>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="harga_kirim">Harga Kirim</label>
                                    <input type="text" class="form-control" id="harga_kirim" name="harga_kirim" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="sub_charge">Sub Charge</label>
                                    <input type="text" class="form-control" id="sub_charge" name="sub_charge" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="biaya_admin">Biaya Admin</label>
                                    <input type="text" class="form-control" id="biaya_admin" name="biaya_admin" readonly>
                                </div>

                                <div class="form-group">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i class="fas fa-book"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total adalah</span>
                                            <h3 class="info-box-number">Rp. </h3>
                                            <input type="hidden" id="total_bayar">
                                        </div>
                                    <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>

                            </div>

                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group" id="status_bayar" >
                                    <label for="status_bayar_tampil">Status Bayar</label>
                                    <input type="text" class="form-control" id="status_bayar_tampil"   readonly>
                                </div>

                                <div class="form-group">
                                    <label for="status_bawa_edit">Status Bawa</label>
                                    <select class="form-control select2" style="width: 100%;" id="status_bawa" name="status_bawa">
                                        <option value="">--Pilih status bawa--</option>
                                        <option value="Siap Dibawa" selected>Siap Dibawa</option>
                                        <option value="Belum Dibawa">Belum Dibawa</option>
                                        {{-- <option value="Sudah Dibawa">Sudah Dibawa</option> --}}
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="btn-simpan-pengiriman"><i class="fas fa-save"></i> Simpan</button>
                        {{-- <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button> --}}
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        @endif
        @else
        <div class="card-body">
            <!-- Main content -->
            <div class="form-group">
                <label for="kode_resi">Cari Kode Resi</label>
                <select class="form-control select2" style="width: 100%;" id="kode_resi" name="kode_resi">
                    <option value="">--Pilih kode resi--</option>
                    <!-- Opsi kode resi akan dimuat secara dinamis -->
                </select>
            </div>
            <hr>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form id="form-simpan-pengiriman" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                            <div class="form-group">
                            <label for="tanggal_terima">Tanggal Penerimaan</label>
                            <input type="date" class="form-control" id="tanggal_terima" name="tanggal_terima" readonly>
                            </div>
                            <script>
                            // Dapatkan elemen input tanggal
                                const inputTanggal1 = document.getElementById('tanggal_terima');

                                // Dapatkan tanggal hari ini dalam format YYYY-MM-DD
                                const today = new Date().toISOString().split('T')[0];

                                // Set nilai default input tanggal menjadi tanggal hari ini
                                inputTanggal1.value = today;

                            </script>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="kode_resi_tampil">Kode Resi</label>
                                    <input type="text" class="form-control" id="kode_resi_tampil" name="kode_resi" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="nama_konsumen">Nama Konsumen</label>
                                    <input type="text" class="form-control" id="nama_konsumen" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama_konsumen_penerima">Nama Penerima</label>
                                    <input type="text" class="form-control" id="nama_konsumen_penerima"   readonly>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                            <!-- Kolom untuk input kode resi dan nama konsumen -->

                            <div class="form-group">
                                <label for="cabang_id_asal">Kota Asal</label>
                                <input type="text" class="form-control" id="cabang_id_asal" name="cabang_id_asal" readonly>
                            </div>

                            <div class="form-group">
                                <label for="cabang_id_tujuan">Kota Tujuan</label>
                                <input type="text" class="form-control" id="cabang_id_tujuan" name="cabang_id_tujuan" readonly>
                            </div>

                            </div>

                        </div>

                        <div class="row">
                           <div class="col-12">
                                <div class="card">
                                    <div class="card-header" style="background-color: gray; color: aliceblue;">
                                        <h3 class="card-title">Tabel Penerimaan</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Barang</th>
                                                        <th>Koli</th>
                                                        <th>Berat</th>
                                                        <th>Keterangan</th>
                                                        <th>Ket Kasir</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 250px;" id="nama_barang" name="nama_barang" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 150px;" id="koli" name="koli" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 100px;" id="berat" name="berat" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 250px;" id="keterangan" name="keterangan" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control form-control-lg" style="width: 250px;" id="keterangan_kasir" name="keterangan_kasir" readonly>
                                                        </td>
                                                    </tr>
                                                    <!-- More rows can be added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                            </div>



                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="jenis_pembayaran">Jenis Pembayaran</label>
                                    <input type="text" class="form-control" id="jenis_pembayaran" name="jenis_pembayaran" readonly>
                                </div>

                                {{-- <div class="form-group" id="metode_pembayaran_container"  > --}}
                                <div class="form-group" id="metode_pembayaran_container" style="display: none;">
                                    <label for="metode_pembayaran">Metode Pembayaran</label>
                                    <select class="form-control select2" style="width: 100%;" id="metode_pembayaran" name="metode_pembayaran" required>
                                    <option value="">--Pilih metode pembayaran--</option>
                                    <option value="Transfer">Transfer</option>
                                    <option value="Tunai">Tunai</option>
                                </select>
                            </div>


                            <div class="form-group" id="bukti_bayar_container" style="display: none;">
                                <label for="bukti_bayar">Upload Bukti Bayar</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="bukti_bayar" name="bukti_bayar" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(event)">
                                        <label class="custom-file-label" for="bukti_bayar">Choose file</label>
                                    </div>
                                </div>
                                <div id="preview-container" style="display:none;">
                                    <img id="preview-image" src="#" alt="..." class="d-none" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                                </div>
                                <!-- Tempat untuk menampilkan bukti_pengiriman -->
                                <a id="link-bukti_bayar_penerimaan" href="#" target="_blank">
                                    <img id="bukti_bayar-penerimaan" class="d-none" style="max-width:100px; max-height:100px" src="#" alt="..">
                                </a>
                            </div>

                            {{-- <div class="form-group" id="jumlah_bayar_container"  > --}}
                            <div class="form-group" id="jumlah_bayar_container" style="display: none;">
                                <label for="jumlah_bayar">Jumlah Bayar</label>
                                <input type="text" class="form-control input-price-format" id="jumlah_bayar" name="jumlah_bayar" readonly>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="harga_kirim">Harga Kirim</label>
                                    <input type="text" class="form-control" id="harga_kirim" name="harga_kirim" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="sub_charge">Sub Charge</label>
                                    <input type="text" class="form-control" id="sub_charge" name="sub_charge" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="biaya_admin">Biaya Admin</label>
                                    <input type="text" class="form-control" id="biaya_admin" name="biaya_admin" readonly>
                                </div>

                                <div class="form-group">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i class="fas fa-book"></i></span>

                                        <div class="info-box-content">
                                            <span class="info-box-text">Total adalah</span>
                                            <h3 class="info-box-number">Rp. </h3>
                                            <input type="hidden" id="total_bayar">
                                        </div>
                                    <!-- /.info-box-content -->
                                    </div>
                                    <!-- /.info-box -->
                                </div>

                            </div>

                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group" id="status_bayar" >
                                    <label for="status_bayar_tampil">Status Bayar</label>
                                    <input type="text" class="form-control" id="status_bayar_tampil"   readonly>
                                </div>

                                <div class="form-group">
                                    <label for="status_bawa_edit">Status Bawa</label>
                                    <select class="form-control select2" style="width: 100%;" id="status_bawa" name="status_bawa">
                                        <option value="">--Pilih status bawa--</option>
                                        <option value="Siap Dibawa" selected>Siap Dibawa</option>
                                        <option value="Belum Dibawa">Belum Dibawa</option>
                                        {{-- <option value="Sudah Dibawa">Sudah Dibawa</option> --}}
                                    </select>
                                </div>
                            </div>

                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" id="btn-simpan-pengiriman"><i class="fas fa-save"></i> Simpan</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        @endif
    </div>
    <!-- /.card -->
@endsection

@push('script')
    {{--SKRIP TAMBAHAN  --}}
    @include('js.cleave-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script>
        initPriceFormat()
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
                $('#preview-image').removeClass('d-none')
            } else {
                $('#preview-image').addClass('d-none')
            }
        }

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



    {{-- PERINTAH UPDATE DATA --}}
    <script>
        $(document).ready(function() {
            // Sisanya adalah script AJAX yang sudah ada sebelumnya
            $('#btn-simpan-pengiriman').click(function(e) {
                e.preventDefault();
                const tombolUpdate = $('#btn-simpan-pengiriman')

                var jenisPembayaranVal = $('#jenis_pembayaran').val();
                var metodePembayaranVal = $('#metode_pembayaran').val();

                if (jenisPembayaranVal !== 'CAD' && metodePembayaranVal === '') {
                    Swal.fire({
                        title: 'Peringatan!',
                        text: 'Pilih metode pembayaran terlebih dahulu.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return; // Berhenti eksekusi jika metode pembayaran kosong untuk jenis_pembayaran bukan 'CAD'
                }

                var jumlahBayar = parseFloat($('#jumlah_bayar').val().replaceAll(',', ''));
                var totalBayar = parseFloat($('#total_bayar').val().replaceAll(',', ''));
                var biayaAdmin = parseFloat(document.getElementById('biaya_admin').value);
                var hargaKirim = parseFloat(document.getElementById('harga_kirim').value);
                var kembalian = jumlahBayar - totalBayar;

                console.log($('#total_bayar').val())

                var totalBiayaAdminHargaKirim = biayaAdmin + hargaKirim;

                if ($('#jenis_pembayaran').val() !== 'CAD') {
                    if (jumlahBayar < totalBayar || jumlahBayar < totalBiayaAdminHargaKirim) {
                        Swal.fire({
                            title: 'Peringatan!',
                            text: 'Jumlah bayar tidak boleh kurang dari total bayar',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                        return; // Berhenti eksekusi jika validasi gagal
                    }
                }

                var kodeResi = $('#kode_resi').val();
                var formData = new FormData($('#form-simpan-pengiriman')[0]);

                // Ambil nilai konsumen_id dan nama_konsumen_hidden
                var tanggal_terima = $('#tanggal_terima').val();
                var status_bawa = $('#status_bawa').val();
                var metode_pembayaran = $('#metode_pembayaran').val();
                var bukti_bayar = $('#bukti_bayar').val();
                var jumlah_bayar = $('#jumlah_bayar').val();
                // var status_bayar = $('#status_bayar').val();

                // Tambahkan nilai konsumen_id dan nama_konsumen ke dalam FormData
                formData.append('status_bawa', status_bawa);
                formData.append('tanggal_terima', tanggal_terima);
                formData.append('metode_pembayaran', metode_pembayaran);
                formData.append('bukti_bayar', bukti_bayar);
                formData.append('jumlah_bayar', jumlah_bayar);
                // formData.append('status_bayar', status_bayar);

                // Lakukan permintaan Ajax untuk update data profil
                $.ajax({
                    type: 'POST',
                    url: '/penerimaan/update_penerimaan/' + kodeResi,
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
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
                          text: jenisPembayaranVal === 'COD' ? `Data berhasil diperbarui. Kembalian: Rp ${numeral(kembalian).format('0,0')}` : 'Data berhasil diperbarui.',
                          icon: 'success',
                          confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                location.reload();
                            }
                        });
                        $('#modal-penerimaan').modal('hide');
                    },
                    complete: function()
                     {tombolUpdate.prop('disabled',false)},
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                console.log(xhr.responseJSON.errors)
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
        });
    </script>

    {{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}
    <script>
        $(document).ready(function() {
            $('#kode_resi').select2({
                // Opsi Select2 jika diperlukan
            });

            // Mendapatkan data awal untuk kode resi
            $.ajax({
                url: '/getResiDataPenerimaan', // Ganti dengan URL yang sesuai untuk memuat data kode resi
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
                            url: '/getResiDataPenerimaan',
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

            // Mendapatkan data terkait setelah memilih kode resi
            $('#kode_resi').on('change', function() {
                var selectedResi = $(this).val();
                let namaCabangAsal, namaCabangTujuan

                // Lakukan permintaan AJAX untuk mendapatkan data terkait dengan kode resi yang dipilih
                $.ajax({
                    url: '/getDetailResiDataPenerimaan', // Ubah sesuai dengan URL yang sesuai untuk mendapatkan data terkait kode resi
                    data: { term: selectedResi },
                    dataType: 'json',
                    success: function(data) {
                    // console.log(data)
                        // Isi input dengan data yang diterima
                        // if (data.length > 0) {
                        namaCabangAsal = data.cabang_asal.nama_cabang;
                        namaCabangTujuan = data.cabang_tujuan.nama_cabang;

                        $('#kode_resi_tampil').val(data.kode_resi);
                        $('#nama_konsumen').val(data.nama_konsumen);
                        $('#nama_konsumen_penerima').val(data.nama_konsumen_penerima);
                        $('#nama_barang').val(data.nama_barang);
                        $('#koli').val(data.koli);
                        $('#berat').val(data.berat);
                        $('#keterangan').val(data.keterangan);
                        $('#keterangan_kasir').val(data.keterangan_kasir);
                        $('#total').val(numeral(data.total).format('0,0'));
                        $('#jenis_pembayaran').val(data.jenis_pembayaran);
                        $('#metode_pembayaran').val(data.metode_pembayaran);
                        $('#jumlah_bayar').val(numeral(data.jumlah_bayar).format('0,0'));
                        // $('#bukti_bayar').val(data.bukti_bayar); //cek cek
                        $('#harga_kirim').val(numeral(data.harga_kirim).format('0,0'));
                        $('#sub_charge').val(numeral(data.sub_charge).format('0,0'));
                        $('#biaya_admin').val(numeral(data.biaya_admin).format('0,0'));
                        // total bayar pada text
                        $('#total_bayar').val(numeral(data.total_bayar).format('0,0'));
                        $('#status_bayar_tampil').val(data.status_bayar);
                        $('#cabang_id_asal').val(namaCabangAsal);
                        $('#cabang_id_tujuan').val(namaCabangTujuan)

                        // Menyimpan nilai total bayar
                        var totalBayar = data.total_bayar;
                        var statusBayar = data.status_bayar;
                        var jenisPembayaran = data.jenis_pembayaran;
                        var metodePembayaran = data.metode_pembayaran;

                        // Menyisipkan nilai total bayar ke dalam elemen h3
                        $('.info-box-number').text('Rp. ' + numeral(totalBayar).format('0,0')); // Atur teks dengan nilai total bayar

                        var bukti_bayarUrl = '/uploads/bukti_bayar_pengiriman/' + data.bukti_bayar;
                        // $('#bukti_bayar-penerimaan').attr('src', bukti_bayarUrl);
                        // $('#link-bukti_bayar_penerimaan').attr('href', bukti_bayarUrl);
                        $('.custom-file-input').prop('disabled', false)
                        $('.custom-file').removeClass('d-none')

                        if (statusBayar === 'Sudah Lunas') {
                            if (jenisPembayaran === 'CASH') {
                                if (metodePembayaran === 'Transfer') {
                                    $('#bukti_bayar_container').show();
                                    $('#jumlah_bayar_container').show();
                                    $('#jumlah_bayar').prop('readonly', true);
                                    $('#metode_pembayaran').val('Transfer').prop('readonly', true);
                                    $('.custom-file-input').prop('disabled', true)
                                    $('.custom-file').addClass('d-none')
                                    $('#link-bukti_bayar_penerimaan').attr('href', bukti_bayarUrl);
                                    $('#bukti_bayar-penerimaan').removeClass('d-none').attr('src', bukti_bayarUrl)
                                } else if (metodePembayaran === 'Tunai') {
                                    $('#bukti_bayar_container').hide();
                                    $('#jumlah_bayar_container').show();
                                    $('#jumlah_bayar').prop('readonly', true);
                                    $('#metode_pembayaran').val('Tunai').prop('readonly', true);
                                }

                                $('#metode_pembayaran_container').show().find('select').prop('disabled', true);
                            }

                            else if (jenisPembayaran === 'COD') {
                                if (metodePembayaran === 'Transfer') {
                                    $('#bukti_bayar_container').show();
                                    $('#jumlah_bayar_container').show();
                                    $('#jumlah_bayar').prop('readonly', true);
                                    $('#metode_pembayaran').val('Transfer').prop('readonly', true);
                                    $('.custom-file-input').prop('disabled', true)
                                    $('.custom-file').addClass('d-none')
                                    $('#link-bukti_bayar_penerimaan').attr('href', bukti_bayarUrl);
                                    $('#bukti_bayar-penerimaan').removeClass('d-none').attr('src', bukti_bayarUrl)
                                }
                            }
                        } else {
                            if (jenisPembayaran === 'CASH' && metodePembayaran === 'Tunai') {
                                $('#bukti_bayar_container').hide();
                                $('#jumlah_bayar_container').show();
                                $('#jumlah_bayar').prop('readonly', true);
                                $('#metode_pembayaran').val('Tunai').prop('readonly', true);
                                $('#metode_pembayaran_container').show().find('select').prop('disabled', true);
                            }
                        }

                        if (jenisPembayaran !== 'CASH' && (jenisPembayaran === 'COD' || jenisPembayaran === 'CAD')) {
                            if (jenisPembayaran === 'CAD') {
                                $('#metode_pembayaran_container').hide().find('select').prop('disabled', true);
                                $('#bukti_bayar_container').hide();
                                $('#jumlah_bayar_container').hide();
                                $('#metode_pembayaran').prop('readonly', true);
                                $('#jumlah_bayar').prop('readonly', true);
                            } else {
                                $('#metode_pembayaran_container').show().find('select').prop('disabled', false);
                                $('#bukti_bayar_container').hide();
                                $('#jumlah_bayar_container').show();
                                $('#metode_pembayaran').prop('readonly', false);
                                $('#jumlah_bayar').prop('readonly', false);
                            }
                        }

                        if (data.nama_barang && data.koli && data.berat && data.nama_konsumen) {
                            $('#nama_konsumen_container').show();
                            $('#nama_barang_container').show();
                            $('#koli_container').show();
                            $('#berat_container').show();
                            $('#pengambil_container').show();
                            $('#gambar_pengambil_container').show();
                            $('#status_bawa_container').show();
                        }
                    }
                });
            });
        });
    </script>
    {{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}

    <script>
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
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

@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush
