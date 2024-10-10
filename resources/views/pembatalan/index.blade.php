@extends('layouts.app')
@section('title', 'Halaman Pembatalan')
@section('subtitle', 'Menu Pembatalan')

@section('content')

    <div class="card">
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
        <div class="row">
            <div class="col-12">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="card card-primary">

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" id="form-simpan-pembatalan" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="kode_resi">Cari Kode Resi</label>
                                    <select class="form-control select2" style="width: 100%;" id="kode_resi"
                                        name="kode_resi">
                                        <option value="">--Pilih kode resi--</option>
                                        <!-- Opsi kode resi akan dimuat secara dinamis -->
                                    </select>

                                </div>

                                <div class="form-group" id="nama_konsumen_container" style="display: none;">
                                    <label for="nama_konsumen">Nama Konsumen</label>
                                    <input type="text" class="form-control" id="nama_konsumen" readonly>
                                    <input type="hidden" class="form-control" id="kode_resi_tampil"
                                        name="kode_resi_tampil">
                                </div>
                                <div class="form-group" id="nama_konsumen_penerima_container" style="display: none;">
                                    <label for="nama_konsumen_penerima">Nama Penerima</label>
                                    <input type="text" class="form-control" id="nama_konsumen_penerima" readonly>
                                </div>
                                <div class="form-group" id="cabang_id_asal_tampil_container" style="display: none;">
                                    <label for="cabang_id_asal_tampil">Kota Asal</label>
                                    <input type="text" class="form-control" id="cabang_id_asal_tampil" readonly>
                                </div>

                                <div class="form-group" id="cabang_id_tujuan_tampil_container" style="display: none;">
                                    <label for="cabang_id_tujuan_tampil">Kota Tujuan</label>
                                    <input type="text" class="form-control" id="cabang_id_tujuan_tampil" readonly>
                                </div>

                                <div class="row" id="tabel_container" style="display: none;">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header" style="background-color: gray; color:aliceblue;">
                                                <h3 class="card-title">Tabel Pengiriman</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="nama_barang_tampil">Nama Barang</label>
                                                            <input type="text" class="form-control"
                                                                id="nama_barang_tampil" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="koli_tampil">Koli</label>
                                                            <input type="text" class="form-control" id="koli_tampil"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="berat_tampil">Berat</label>
                                                            <input type="text" class="form-control" id="berat_tampil"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <label for="keterangan_tampil">Keterangan</label>
                                                            <input type="text" class="form-control"
                                                                id="keterangan_tampil" readonly>
                                                        </div>
                                                    </div>




                                                </div>
                                            </div>

                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>




                                </div>
                                <!-- /.row -->

                                <div class="row" id="isi_container" style="display: none;">
                                    <div class="col-md-6 col-sm-6 col-12">


                                        <div class="form-group">
                                            <label for="biaya_pembatalan">Biaya Pembatalan</label>
                                            <input type="text" class="form-control" id="biaya_pembatalan"
                                                name="biaya_pembatalan" readonly>
                                        </div>


                                        <div class="form-group">
                                            <label for="bukti_pembatalan">Upload Bukti Pembatalan</label>
                                            <div class="input-group w-100">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="bukti_pembatalan" accept="image/jpeg,image/png,image/jpg,image/gif" name="bukti_pembatalan" onchange="previewImage(event)">
                                                    <label class="custom-file-label" for="bukti_pembatalan">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="w-100">
                                                <div id="preview-container" style="display:none;">
                                                    <img id="preview-image" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                                                </div>
                                                <br>
                                                <a id="link-bukti_pembatalan" href="#" target="_blank">
                                                    <img id="bukti_bukti_pembatalan" style="max-width:200px; max-height:200px" src="#" alt="Bukti Pembatalan">
                                                </a>
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



                                    </div>

                                    <div class="col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="total_bayar">Biaya Pembayaran</label>
                                            <input type="text" class="form-control" id="total_bayar"
                                                name="total_bayar" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_pembayaran">Jenis Pembayaran</label>
                                            <input type="text" class="form-control" id="jenis_pembayaran"
                                                 readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="metode_pembayaran">Metode Pembayaran</label>
                                            <input type="text" class="form-control" id="metode_pembayaran"
                                                  readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan_batal">Keterangan Batal</label>
                                            <textarea name="keterangan_batal" class="form-control" id="keterangan_batal" cols="30" rows="3"></textarea>

                                        </div>



                                    </div>



                                    <div class="col-12 mt-3">
                                        <label for="status_batal">Status Pembatalan</label>
                                        <input style="font-size: 20px;" type="text" class="form-control"
                                            id="status_batal" placeholder="Pengajuan Batal" readonly>
                                    </div>

                                    <div class="col-12 mt-3 d-none" id="alasan_tolak_container">
                                        <label for="alasan_tolak">Alasan Reject (Jika Ada)</label>
                                        <input style="font-size: 20px;" type="text" class="form-control"
                                            id="alasan_tolak" readonly>
                                    </div>

                                    <div class="col-12 mt-3" id="kode_pembatalan_container">
                                        <label for="kode_pembatalan">Kode Pembatalan</label>
                                        <input style="font-size: 30px;" type="text" class="form-control"
                                            id="kode_pembatalan" readonly placeholder="Belum Ada Kode Pembatalan">
                                    </div>

                                    <div class="col-12 mt-3" id="kembalian-container">
                                        <label>Kembalian</label>
                                        <div class="alert alert-danger">
                                            <h3>Rp <span class="kembalian"></span></h3>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3" id="pembayaran_konsumen-container">
                                        <label>Biaya Yang Harus Dibayar Konsumen</label>
                                        <div class="alert alert-danger">
                                            <h3>Rp <span class="pembayaran_konsumen"></span></h3>
                                        </div>
                                    </div>

                                </div>



                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                {{-- <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Cetak Resi</button> --}}
                                <button type="submit" class="btn btn-primary btn-simpan-pembatalan"
                                    id="btn-simpan-pembatalan"><i class="fas fa-save"></i> Simpan</button>
                                {{-- <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button> --}}
                            </div>
                        </form>

                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
        @endif
        @else
        <div class="row">
            <div class="col-12">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="card card-primary">

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" id="form-simpan-pembatalan" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="kode_resi">Cari Kode Resi</label>
                                    <select class="form-control select2" style="width: 100%;" id="kode_resi"
                                        name="kode_resi">
                                        <option value="">--Pilih kode resi--</option>
                                        <!-- Opsi kode resi akan dimuat secara dinamis -->
                                    </select>

                                </div>

                                <div class="form-group" id="nama_konsumen_container" style="display: none;">
                                    <label for="nama_konsumen">Nama Konsumen</label>
                                    <input type="text" class="form-control" id="nama_konsumen" readonly>
                                    <input type="hidden" class="form-control" id="kode_resi_tampil"
                                        name="kode_resi_tampil">
                                </div>
                                <div class="form-group" id="nama_konsumen_penerima_container" style="display: none;">
                                    <label for="nama_konsumen_penerima">Nama Penerima</label>
                                    <input type="text" class="form-control" id="nama_konsumen_penerima" readonly>
                                </div>
                                <div class="form-group" id="cabang_id_asal_tampil_container" style="display: none;">
                                    <label for="cabang_id_asal_tampil">Kota Asal</label>
                                    <input type="text" class="form-control" id="cabang_id_asal_tampil" readonly>
                                </div>

                                <div class="form-group" id="cabang_id_tujuan_tampil_container" style="display: none;">
                                    <label for="cabang_id_tujuan_tampil">Kota Tujuan</label>
                                    <input type="text" class="form-control" id="cabang_id_tujuan_tampil" readonly>
                                </div>

                                <div class="row" id="tabel_container" style="display: none;">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header" style="background-color: gray; color:aliceblue;">
                                                <h3 class="card-title">Tabel Pengiriman</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="nama_barang_tampil">Nama Barang</label>
                                                            <input type="text" class="form-control"
                                                                id="nama_barang_tampil" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="koli_tampil">Koli</label>
                                                            <input type="text" class="form-control" id="koli_tampil"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="berat_tampil">Berat</label>
                                                            <input type="text" class="form-control" id="berat_tampil"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <div class="form-group">
                                                            <label for="keterangan_tampil">Keterangan</label>
                                                            <input type="text" class="form-control"
                                                                id="keterangan_tampil" readonly>
                                                        </div>
                                                    </div>




                                                </div>
                                            </div>

                                            <!-- /.card-body -->
                                        </div>
                                        <!-- /.card -->
                                    </div>




                                </div>
                                <!-- /.row -->

                                <div class="row" id="isi_container" style="display: none;">
                                    <div class="col-md-6 col-sm-6 col-12">


                                        <div class="form-group">
                                            <label for="biaya_pembatalan">Biaya Pembatalan</label>
                                            <input type="text" class="form-control" id="biaya_pembatalan"
                                                name="biaya_pembatalan" readonly>
                                        </div>


                                        <div class="form-group">
                                            <label for="bukti_pembatalan">Upload Bukti Pembatalan</label>
                                            <div class="input-group w-100">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="bukti_pembatalan" accept="image/jpeg,image/png,image/jpg,image/gif" name="bukti_pembatalan" onchange="previewImage(event)">
                                                    <label class="custom-file-label" for="bukti_pembatalan">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="w-100">
                                                <div id="preview-container" style="display:none;">
                                                    <img id="preview-image" src="#" alt="Preview"
                                                        style="max-width: 200px; max-height: 200px; margin-top: 10px;">
                                                </div>
                                                <br>
                                                <a id="link-bukti_pembatalan" href="#" target="_blank">
                                                    <img id="bukti_bukti_pembatalan"
                                                        style="max-width:200px; max-height:200px" src="#"
                                                        alt="Bukti Pembatalan">
                                                </a>
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



                                    </div>

                                    <div class="col-md-6 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label for="total_bayar">Biaya Pembayaran</label>
                                            <input type="text" class="form-control" id="total_bayar"
                                                name="total_bayar" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_pembayaran">Jenis Pembayaran</label>
                                            <input type="text" class="form-control" id="jenis_pembayaran"
                                                 readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="metode_pembayaran">Metode Pembayaran</label>
                                            <input type="text" class="form-control" id="metode_pembayaran"
                                                  readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="keterangan_batal">Keterangan Batal</label>
                                            <textarea name="keterangan_batal" class="form-control" id="keterangan_batal" cols="30" rows="3"></textarea>

                                        </div>



                                    </div>



                                    <div class="col-12 mt-3">
                                        <label for="status_batal">Status Pembatalan</label>
                                        <input style="font-size: 20px;" type="text" class="form-control"
                                            id="status_batal" placeholder="Pengajuan Batal" readonly>
                                    </div>

                                    <div class="col-12 mt-3 d-none" id="alasan_tolak_container">
                                        <label for="alasan_tolak">Alasan Reject (Jika Ada)</label>
                                        <input style="font-size: 20px;" type="text" class="form-control"
                                            id="alasan_tolak" readonly>
                                    </div>

                                    <div class="col-12 mt-3" id="kode_pembatalan_container">
                                        <label for="kode_pembatalan">Kode Pembatalan</label>
                                        <input style="font-size: 30px;" type="text" class="form-control"
                                            id="kode_pembatalan" readonly placeholder="Belum Ada Kode Pembatalan">
                                    </div>

                                    <div class="col-12 mt-3" id="kembalian-container">
                                        <label>Kembalian</label>
                                        <div class="alert alert-danger">
                                            <h3>Rp <span class="kembalian"></span></h3>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3" id="pembayaran_konsumen-container">
                                        <label>Biaya Yang Harus Dibayar Konsumen</label>
                                        <div class="alert alert-danger">
                                            <h3>Rp <span class="pembayaran_konsumen"></span></h3>
                                        </div>
                                    </div>

                                </div>



                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                {{-- <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Cetak Resi</button> --}}
                                <button type="submit" class="btn btn-primary btn-simpan-pembatalan"
                                    id="btn-simpan-pembatalan"><i class="fas fa-save"></i> Simpan</button>
                                {{-- <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button> --}}
                            </div>
                        </form>

                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
        @endif
    </div>
    <!-- /.card -->
@endsection

@push('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script>
        function formatNumber(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(number);
        }
    </script>
    {{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}
    <script>
        $(document).ready(function() {
            // Mendapatkan data awal untuk kode resi
            $.ajax({
                url: '/getResiDataBatal', // Ganti dengan URL yang sesuai untuk memuat data kode resi
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
                            url: '/getResiDataBatal',
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


            // Function untuk mengatur tampilan berdasarkan nilai status_batal
            function showHideKodePembatalan(status) {
                if (status === 'Verifikasi Disetujui') {
                    $('#kode_pembatalan_container').show();
                    $('#alasan_tolak_container').hide();
                } else {
                    $('#kode_pembatalan_container').hide();

                }
            }

            // Mendapatkan data terkait setelah memilih kode resi
            $('#kode_resi').on('change', function() {
                var selectedResi = $(this).val();

                // Lakukan permintaan AJAX untuk mendapatkan data terkait dengan kode resi yang dipilih
                $.ajax({
                    url: '/getDetailResiDataPembatalan', // Ubah sesuai dengan URL yang sesuai untuk mendapatkan data terkait kode resi
                    data: {
                        term: selectedResi
                    },
                    dataType: 'json',
                    success: function(data) {
                        const biayaPembatalan = data.biaya_pembatalan
                        const totalBayar = data.total_bayar
                        // console.log(data)
                        // Isi input dengan data yang diterima
                        // if (data.length > 0) {
                        $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi
                        $('#kode_resi_tampil').val(data.kode_resi);
                        $('#nama_konsumen').val(data.nama_konsumen);
                        $('#nama_konsumen_penerima').val(data.nama_konsumen_penerima);
                        $('#cabang_id_asal_tampil').val(data.cabang_asal.nama_cabang);
                        $('#cabang_id_tujuan_tampil').val(data.cabang_tujuan.nama_cabang);
                        $('#nama_barang_tampil').val(data.nama_barang);
                        $('#koli_tampil').val(data.koli);
                        $('#berat_tampil').val(data.berat);
                        $('#keterangan_tampil').val(data.keterangan);
                        $('#biaya_pembatalan').val(numeral(biayaPembatalan).format('0,0'));
                        $('#total_bayar').val(numeral(totalBayar).format('0,0'));
                        $('#keterangan_batal').val(data.keterangan_batal);
                        $('#jenis_pembayaran').val(data.jenis_pembayaran);
                        $('#metode_pembayaran').val(data.metode_pembayaran);
                        $('#kode_pembatalan').val(data.kode_pembatalan);
                        $('#status_batal').val(data.status_batal);
                        $('#alasan_tolak').val(data.alasan_tolak);


                        // Menampilkan data pada input sesuai dengan kondisi status_batal
                        $('#status_batal').val(data.status_batal);
                        $('#alasan_tolak').val(data.alasan_tolak);
                        showHideKodePembatalan(data.status_batal);



                        // Menampilkan gambar bukti_pembatalan
                        var buktiPembatalanPath = '/uploads/bukti_bayar_pengiriman/' + data
                            .bukti_pembatalan;

                        $('#bukti_bukti_pembatalan').removeClass('d-none')
                        $('#link-bukti_pembatalan').removeClass('d-none')

                        if (data.bukti_pembatalan === null) {
                            $('#bukti_bukti_pembatalan').addClass('d-none')
                            $('#link-bukti_pembatalan').addClass('d-none')
                        }

                        $('#bukti_bukti_pembatalan').attr('src', buktiPembatalanPath);
                        $('#link-bukti_pembatalan').attr('href', buktiPembatalanPath);

                        $('#nama_konsumen_container').show();
                        $('#nama_konsumen_penerima_container').show();
                        $('#cabang_id_asal_tampil_container').show();
                        $('#cabang_id_tujuan_tampil_container').show();
                        $('#tabel_container').show();
                        $('#isi_container').show();
                        $('#kembalian-container').addClass('d-none')
                        $('#pembayaran_konsumen-container').addClass('d-none')
                        $('#alasan_tolak_container').addClass('d-none')

                        if (data.status_batal === 'Verifikasi Disetujui') {
                        if (data.jenis_pembayaran === 'COD' || data.jenis_pembayaran === 'CAD') {
                        // if (jenis_pembayaran === 'COD' || jenis_pembayaran === 'CAD') {
                            $('.pembayaran_konsumen').text(numeral(biayaPembatalan).format('0,0'));
                            $('#pembayaran_konsumen-container').removeClass('d-none')

                        } else {
                            const kembalian = parseFloat(totalBayar) - parseFloat(biayaPembatalan);
                            $('.kembalian').text(numeral(kembalian).format('0,0'));
                            $('#kembalian-container').removeClass('d-none')

                        }
                        } else if (data.status_batal === 'Verifikasi Ditolak') {
                            $('#alasan_tolak_container').removeClass('d-none');
                        }


                        // Mengatur kondisi tombol Simpan berdasarkan status_batal
                        if (data.status_batal === 'Verifikasi Disetujui') {
                            $('#btn-simpan-pembatalan').attr('disabled', true).html(
                                '<i class="fas fa-save"></i> Sudah Disimpan');
                        } else {
                            $('#btn-simpan-pembatalan').attr('disabled', false).html(
                                '<i class="fas fa-save"></i> Simpan');
                        }
                    }
                });

            });
        });
    </script>
    {{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}


    <script>
        $(document).ready(function() {
            // Sisanya adalah script AJAX yang sudah ada sebelumnya
            $('#btn-simpan-pembatalan').click(function(e) {
                e.preventDefault();

                btnSimpan = $('.btn-simpan-pembatalan')
                var kode_resi = $('#kode_resi_tampil').val();
                var formData = new FormData($('#form-simpan-pembatalan')[0]);

                // Ambil nilai konsumen_id dan nama_konsumen_hidden
                var biaya_pembatalan = $('#biaya_pembatalan').val();
                var bukti_pembatalan = $('#bukti_pembatalan').val();
                var keterangan_batal = $('#keterangan_batal').val();


                // Tambahkan nilai konsumen_id dan nama_konsumen ke dalam FormData
                formData.append('biaya_pembatalan', biaya_pembatalan);
                formData.append('bukti_pembatalan', bukti_pembatalan);
                formData.append('keterangan_batal', keterangan_batal);

                // formData.append('status_bayar', status_bayar);

                // Lakukan permintaan Ajax untuk update data profil
                $.ajax({
                    type: 'POST',
                    url: '/pengiriman/pembatalan_pengiriman/' + kode_resi,
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT'
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('form').find('.error-message').remove()
                        btnSimpan.prop('disabled', true)
                    },
                    success: function(response) {
                        var statusBatal = $('#status_batal').val();

                        if (statusBatal === 'Verifikasi Disetujui') {
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Data berhasil diperbarui. Jumlah yang harus dikembalikan pada konsumen adalah ',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed || result.isDismissed) {
                                    location.reload();
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
                                    location.reload();
                                }
                            });
                        }
                    },
                    complete: function() {
                        btnSimpan.prop('disabled', false)
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
        });
    </script>

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
