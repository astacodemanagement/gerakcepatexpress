
@extends('layouts.app')
@section('title','Halaman Pengiriman')
@section('subtitle','Menu Pengiriman')

@section('content')

<div class="card">

    <!-- /.card-header -->
    <div class="card-body">
      <a href="/" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-pengiriman"><i class="fas fa-plus-circle"></i> Tambah Data</a>
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th width="3%">No</th>
          <th>Cabang</th>
          <th>Tanggal Kirim</th>
          <th>Kode Resi</th>
          <th>Nama Pengirim</th>
          <th>Nama Barang</th>
          <th>Total Koli</th>
          <th>Berat</th>
          <th>Kota Asal</th>
          <th>Kota Tujuan</th>
          <th>Total Bayar</th>
          <th>Status Bayar</th>
          <th>Status Bawa</th>
          <th>Status Batal</th>
          <th>Jenis Pembayaran</th>
          <th width="20%">Aksi</th>
        </tr>
        </thead>
        <tbody>

          <?php $i = 1; ?>
          @foreach ($pengiriman as $p)
          <tr>
              <td>{{ $i }}</td>
              <td><b>{{ $p->nama_cabang }}</b></td>
              <td>{{ $p->tanggal_kirim}}</td>
              <td>{{ $p->kode_resi}}</td>
              <td>{{ $p->nama_konsumen}}</td>
              <td>{{ $p->nama_barang}}</td>
              <td>{{ $p->koli}}</td>
              <td>{{ $p->berat}}</td>
              <td><b>{{ $p->cabangAsal?->nama_cabang }}</b></td>
              <td>{{ $p->cabangTujuan?->nama_cabang }}</td>
              <td>{{ $p->total_bayar}}</td>
              @if($p->status_bayar === 'Belum Lunas')
                  <td><span class="float-left badge bg-danger">{{ $p->status_bayar }}</span></td>
              @elseif($p->status_bayar === 'Sudah Lunas')
                  <td><span class="float-left badge bg-success">{{ $p->status_bayar }}</span></td>
              @else
                  <td>{{ $p->status_bayar }}</td>
              @endif

              @if($p->status_bawa === 'Belum Dibawa')
                  <td><span class="float-left badge bg-danger">{{ $p->status_bawa }}</span></td>
              @elseif($p->status_bawa === 'Siap Dibawa')
                  <td><span class="float-left badge bg-warning">{{ $p->status_bawa }}</span></td>
              @elseif($p->status_bawa === 'Sudah Dibawa')
                  <td><span class="float-left badge bg-success">{{ $p->status_bawa }}</span></td>
              @elseif($p->status_bawa === 'Pengajuan Batal')
                  <td><span class="float-left badge bg-primary">{{ $p->status_bawa }}</span></td>

              @else
                  <td>{{ $p->status_bawa }}</td>
              @endif

              @if(empty($p->status_batal))
              <td><span class="float-left badge bg-secondary">Empty</span></td>
              @elseif($p->status_batal === 'Pengajuan Batal')
                  <td>
                    <span class="float-left badge bg-primary">{{ $p->status_batal }}</span>
                  </td>
              @elseif($p->status_batal === 'Verifikasi Disetujui')
                  <td>
                    <span class="float-left badge bg-warning">{{ $p->status_batal }}</span>
                    <br>
                    <span class="float-left badge bg-warning" style="font-size: larger;">Kode: {{ $p->kode_pembatalan }}</span>

                  </td>
              @elseif($p->status_batal === 'Telah Diambil Pembatalan')
                  <td><span class="float-left badge bg-success">{{ $p->status_batal }}</span></td>
              @elseif($p->status_batal === 'Verifikasi Ditolak')
                  <td>
                    <span class="float-left badge bg-danger" style="font-size: 14px;">{{ $p->status_batal }}</span>
                    <br>
                    <span class="float-left badge bg-danger" style="font-size: 10;">Alasan: {{ $p->alasan_tolak }}</span>
                  </td>
              @else
                  <td>{{ $p->status_batal }}</td>
              @endif

              <td>
                @if($p->status_batal === 'Telah Diambil Pembatalan')
                    <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-secondary" style="color: black" disabled>
                        <i class="fas fa-edit"></i> Tidak Ada Akses Pembatalan 
                    </a>
                @else
                    <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-danger btn-edit" data-toggle="modal" data-target="#modal-pembatalan" data-id="{{ $p->id }}" style="color: black">
                        <i class="fas fa-edit"></i> Pembatalan
                    </a>
                @endif
            </td>   
             <td>{{ $p->jenis_pembayaran}}</td>
            

          </tr>
          <?php $i++; ?>
          @endforeach


        </tbody>
        <tfoot>
        <tr>
          <th width="3%">No</th>
          <th>Cabang</th>
          <th>Tanggal Kirim</th>
          <th>Kode Resi</th>
          <th>Nama Pengirim</th>
          <th>Nama Barang</th>
          <th>Total Koli</th>
          <th>Berat</th>
          <th>Kota Asal</th>
          <th>Kota Tujuan</th>
          <th>Total</th>
          <th>Status Bayar</th>
          <th>Status Bawa</th>
          <th>Status Batal</th>
          <th width="20%">Aksi</th>
        </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.card-body -->
</div>
  <!-- /.card -->



  <div class="modal fade" id="modal-pengiriman">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Pengiriman</h4>
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
                <form id="form-simpan-pengiriman" method="POST" enctype="multipart/form-data">
                  @method('PUT')
                  @csrf
                  <div class="card-body">
 
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-12">
                          <!-- Kolom untuk input kode resi dan nama konsumen -->
                          <div class="form-group">
                            <label for="kode_resi">Cari Kode Resi</label>
                            <select class="form-control select2" style="width: 100%;" id="kode_resi" name="kode_resi">
                                <option value="">--Pilih kode resi--</option>
                                <!-- Opsi kode resi akan dimuat secara dinamis -->
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="nama_konsumen">Cari Konsumen</label>
                            <select class="form-control select2" style="width: 100%;" id="nama_konsumen" name="nama_konsumen">
                                <option value="">--Pilih konsumen--</option>
                                <!-- Opsi konsumen akan dimuat secara dinamis -->
                            </select>
                          </div>
                          <input type="hidden" name="konsumen_id" id="konsumen_id" value="">
                          <input type="hidden" name="nama_konsumen_hidden" id="nama_konsumen_hidden" value="">


                          <div class="form-group">
                            <a href="/" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-default"><i class="fas fa-plus-circle"></i> Tambah Konsumen</a>
                          </div>
                      </div>

                      <div class="col-md-6 col-sm-6 col-12">
                        <!-- Kolom untuk input kode resi dan nama konsumen -->

                        <div class="form-group">
                          <label for="cabang_id_asal">Kota Asal</label>
                          <select class="form-control select2" style="width: 100%;" id="cabang_id_asal" name="cabang_id_asal">

                            <option value="{{ auth()->user()->cabang_id }}">{{ auth()->user()->cabang->nama_cabang ?? 'Nama Cabang Tidak Tersedia' }}</option>

                          </select>
                        </div>

                        <div class="form-group">
                          <label for="cabang_id_tujuan">Kota Tujuan</label>
                          <select class="form-control select2" style="width: 100%;" id="cabang_id_tujuan" name="cabang_id_tujuan">
                              <option value="">--Pilih kota tujuan--</option>
                              <!-- Opsi cabang tujuan akan dimuat secara dinamis -->
                          </select>
                        </div>

                      </div>

                    </div>




                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header" style="background-color: gray; color:aliceblue;">
                            <h3 class="card-title" >Tabel Pengiriman</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body table-responsive p-0">
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="nama_barang">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" readonly>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="koli">Koli</label>
                                        <input type="text" class="form-control" id="koli" name="koli" readonly>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <label for="berat">Berat</label>
                                        <input type="text" class="form-control" id="berat" name="berat" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                      <label for="keterangan">Keterangan</label>
                                      <input type="text" class="form-control" id="keterangan" name="keterangan" readonly>
                                  </div>
                                </div>
                                {{-- <div class="col-2">
                                  <div class="form-group">
                                      <label for="total">Total</label>
                                      <input type="text" class="form-control" id="total" name="total">
                                  </div>
                                </div> --}}




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
                          <label for="keterangan_kasir">Keterangan Kasir</label>
                          <input type="text" class="form-control" id="keterangan_kasir" name="keterangan_kasir" placeholder="Masukkan Keterangan Tambahan">
                        </div>
                        <div class="form-group">
                          <label for="jenis_pembayaran">Jenis Pembayaran</label>
                          <select class="form-control select2" style="width: 100%;" id="jenis_pembayaran" name="jenis_pembayaran">
                              <option value="">--Pilih jenis pembayaran--</option>
                              <option value="CASH">CASH</option>
                              <option value="COD">COD</option>
                              <option value="CAD">CAD</option>
                          </select>
                      </div>

                        <div class="form-group" id="metode_pembayaran_container" style="display: none;">
                          <label for="metode_pembayaran">Metode Pembayaran</label>
                          <select class="form-control select2" style="width: 100%;" id="metode_pembayaran" name="metode_pembayaran">
                              <option value="">--Pilih metode pembayaran--</option>
                              <option value="Transfer">Transfer</option>
                              <option value="Tunai">Tunai</option>
                          </select>
                      </div>


                          <div class="form-group" id="bukti_bayar_container" style="display: none;">
                            <label for="bukti_bayar">Upload Bukti Bayar</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="bukti_bayar" name="bukti_bayar">
                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                              </div>
                              <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                              </div>
                            </div>
                          </div>

                          <div class="form-group" id="jumlah_bayar_container" style="display: none;">
                            <label for="jumlah_bayar">Jumlah Bayar</label>
                            <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_bayar" placeholder="Total Jumlah Bayar">
                          </div>

                      </div>

                      <div class="col-md-6 col-sm-6 col-12">

                        <div class="form-group">
                          <label for="harga_kirim">Harga Kirim</label>
                          <input type="number" class="form-control" id="harga_kirim" name="harga_kirim" placeholder="Masukkan Harga Kirim">
                        </div>
                        <div class="form-group">
                          <label for="sub_charge">Sub Charge</label>
                          <input type="number" class="form-control" id="sub_charge" name="sub_charge" placeholder="Masukkan Sub Charge">
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
                    <button type="submit" class="btn btn-primary" id="btn-simpan-pengiriman"><i class="fas fa-save"></i> Simpan</button>
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

  <div class="modal fade" id="modal-pembatalan">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Pembatalan</h4>
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
                <form id="form-pembatalan" method="POST" enctype="multipart/form-data">
                  @method('PUT')
                  @csrf
                  <div class="card-body">


                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-12">
                          <!-- Kolom untuk input kode resi dan nama konsumen -->
                          <div class="form-group">
                            <label for="kode_resi_tampil">Kode Resi</label>
                            <input type="text" class="form-control" id="kode_resi_tampil" readonly>
                            <input type="hidden" class="form-control" id="id" name="id">
                          </div>

                          <div class="form-group">
                            <label for="nama_konsumen_tampil">Cari Konsumen</label>
                            <input type="text" class="form-control" id="nama_konsumen_tampil" readonly>
                          </div>

                      </div>

                      <div class="col-md-6 col-sm-6 col-12">
                        <!-- Kolom untuk input kode resi dan nama konsumen -->

                        <div class="form-group">
                          <label for="cabang_id_asal_tampil">Kota Asal</label>
                          <input type="text" class="form-control" id="cabang_id_asal_tampil" readonly>
                        </div>

                        <div class="form-group">
                          <label for="cabang_id_tujuan_tampil">Kota Tujuan</label>
                          <input type="text" class="form-control" id="cabang_id_tujuan_tampil" readonly>
                        </div>

                      </div>

                    </div>




                    <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header" style="background-color: gray; color:aliceblue;">
                            <h3 class="card-title" >Tabel Pengiriman</h3>
                          </div>
                          <!-- /.card-header -->
                          <div class="card-body table-responsive p-0">
                            <hr>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="nama_barang_tampil">Nama Barang</label>
                                        <input type="text" class="form-control" id="nama_barang_tampil"  readonly>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label for="koli_tampil">Koli</label>
                                        <input type="text" class="form-control" id="koli_tampil" readonly>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <div class="form-group">
                                        <label for="berat_tampil">Berat</label>
                                        <input type="text" class="form-control" id="berat_tampil" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-group">
                                      <label for="keterangan_tampil">Keterangan</label>
                                      <input type="text" class="form-control" id="keterangan_tampil"   readonly>
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

                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-12">


                        <div class="form-group">
                          <label for="biaya_pembatalan">Biaya Pembatalan</label>
                          <input type="number" class="form-control" id="biaya_pembatalan" name="biaya_pembatalan" readonly>
                        </div>

                        <div class="form-group"   >
                          <label for="bukti_pembatalan">Upload Gambar</label>
                          <input type="file" id="bukti_pembatalan" name="bukti_pembatalan">
                        </div>



                      </div>

                      <div class="col-md-6 col-sm-6 col-12">

                        <div class="form-group">
                          <label for="keterangan_batal">Keterangan Batal</label>
                          <textarea name="keterangan_batal" class="form-control" id="keterangan_batal" cols="30" rows="4"></textarea>

                        </div>



                      </div>

                    </div>


                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="btn-simpan-pembatalan"><i class="fas fa-save"></i> Simpan Pembatalan</button>
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


   {{--SKRIP TAMBAHAN  --}}
<!-- jQuery -->
<script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('template') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
 <!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>



<script>
  $(document).ready(function() {


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

        // Jika jenis pembayaran adalah "CASH", tampilkan form-group untuk metode_pembayaran
        if (selectedJenisPembayaran === 'CASH') {
            $('#metode_pembayaran_container').show();

           // Fungsi untuk memformat angka dengan pemisah ribuan
                // function formatNumber(number) {
                //   return Number(number).toLocaleString('id-ID'); // Ganti 'id-ID' dengan kode bahasa yang sesuai
                // }

            // Lakukan permintaan AJAX untuk mendapatkan nilai biaya_admin dari tabel profil
            $.ajax({
                url: '/getBiayaAdmin', // Ganti dengan URL yang sesuai untuk mendapatkan biaya_admin dari tabel profil
                method: 'GET',
                dataType: 'json',
                success: function(data) {

                    // Isi input biaya_admin dengan nilai yang diterima dari tabel profil
                    $('#biaya_admin').val(data.biaya_admin);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Atur nilai input biaya_admin ke 0 atau pesan error jika tidak berhasil memuat data
                    $('#biaya_admin').val(0);
                }
            });
        } else {
           // Lakukan permintaan AJAX untuk mendapatkan nilai biaya_admin dari tabel profil


  // Lakukan permintaan AJAX untuk mendapatkan nilai biaya_admin dari tabel profil
  $.ajax({
                url: '/getBiayaAdmin', // Ganti dengan URL yang sesuai untuk mendapatkan biaya_admin dari tabel profil
                method: 'GET',
                dataType: 'json',
                success: function(data) {

                    // Isi input biaya_admin dengan nilai yang diterima dari tabel profil
                    $('#biaya_admin').val(data.biaya_admin);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Atur nilai input biaya_admin ke 0 atau pesan error jika tidak berhasil memuat data
                    $('#biaya_admin').val(0);
                }
            });
            // Sembunyikan form-group untuk metode_pembayaran jika jenis pembayaran bukan "CASH"
            $('#metode_pembayaran_container').hide();
            $('#jumlah_bayar_container').hide();
            $('#bukti_bayar_container').hide();
            // Kosongkan input biaya_admin jika jenis pembayaran bukan "CASH"
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

     // Mendapatkan data awal untuk konsumen
     $('#nama_konsumen').select2({
        minimumInputLength: 1,
        ajax: {
            url: '/getKonsumenData',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.nama_konsumen,
                            id: item.id
                        };
                    })
                };
            },
            cache: true
        }
    }).on('select2:select', function(e) {
        var data = e.params.data;
        $('#konsumen_id').val(data.id); // Menyimpan ID konsumen
        $('#nama_konsumen_hidden').val(data.text); // Menyimpan nama konsumen
    }).on('select2:opening', function(e) {
        var searchText = $(this).val(); // Mendapatkan teks yang sedang dicari
        $('#nama_konsumen_hidden').val(searchText); // Menyimpan teks yang sedang dicari
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
            data: { term: selectedResi },
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

<script>
  $(document).ready(function() {


    // Sisanya adalah script AJAX yang sudah ada sebelumnya
    $('#btn-simpan-pengiriman').click(function(e) {
  e.preventDefault();

  var kodeResi = $('#kode_resi').val();
  var formData = new FormData($('#form-simpan-pengiriman')[0]);

  // Ambil nilai konsumen_id dan nama_konsumen_hidden
  var konsumenId = $('#konsumen_id').val();
  var namaKonsumen = $('#nama_konsumen_hidden').val();
  var totalBayar = $('#total_bayar').val();
  var cabangIdAsal = $('#cabang_id_asal').val();
  var cabangIdTujuan = $('#cabang_id_tujuan').val();
  var keterangan_kasir = $('#keterangan_kasir').val();


  // Tambahkan nilai konsumen_id dan nama_konsumen ke dalam FormData
  formData.append('konsumen_id', konsumenId);
  formData.append('nama_konsumen_hidden', namaKonsumen);
  formData.append('total_bayar', totalBayar);
  formData.append('cabang_id_asal', cabangIdAsal);
  formData.append('cabang_id_tujuan', cabangIdTujuan);
  formData.append('keterangan_kasir', keterangan_kasir);

  // Lakukan permintaan Ajax untuk update data profil
  $.ajax({
    type: 'POST',
    url: '/pengiriman/update_pengiriman/' + kodeResi,
    data: formData,
    headers: {
      'X-HTTP-Method-Override': 'PUT'
    },
    contentType: false,
    processData: false,
    success: function(response) {
      // Tampilkan pesan sukses menggunakan SweetAlert
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
      $('#modal-pengiriman').modal('hide');
    },
    error: function(xhr, status, error) {
      console.error('Terjadi kesalahan saat update:', error);
      Swal.fire({
        title: 'Error!',
        text: 'Terjadi kesalahan saat melakukan pembaruan.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });
});

});
</script>

{{-- PERINTAH TAMPIL/EDIT DATA --}}
<script>
  $(document).ready(function() {

    $('.btn-edit').click(function(e) {
          e.preventDefault();
          var pengirimanId = $(this).data('id');

          // Ajax request untuk mendapatkan data pengiriman
          $.ajax({
      type: 'GET',
      url: '/pengiriman/' + pengirimanId + '/edit',
      success: function(data) {
          // Mengisi data pada form modal
          $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi
          $('#kode_resi_tampil').val(data.kode_resi);
          $('#nama_konsumen_tampil').val(data.nama_konsumen);
          $('#cabang_id_asal_tampil').val(data.cabang_id_asal);
          $('#cabang_id_tujuan_tampil').val(data.cabang_id_tujuan);
          $('#nama_barang_tampil').val(data.nama_barang);
          $('#koli_tampil').val(data.koli);
          $('#berat_tampil').val(data.berat);
          $('#keterangan_tampil').val(data.keterangan);
          $('#total_bayar_tampil').val(data.total_bayar);


          console.log(data)

          // Menampilkan modal
          $('#modal-pembatalan').modal('show');
      },
      error: function(error) {
          console.log(error);
      }
  });



      });


  });
</script>


 {{-- PERINTAH UPDATE DATA --}}

<script>
  $(document).ready(function() {


    // Sisanya adalah script AJAX yang sudah ada sebelumnya
  $('#btn-simpan-pembatalan').click(function(e) {
  e.preventDefault();

  var id = $('#id').val();
  var formData = new FormData($('#form-pembatalan')[0]);

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
    url: '/pengiriman/pembatalan_pengiriman/' + id,

    data: formData,
    headers: {
      'X-HTTP-Method-Override': 'PUT'
    },
    contentType: false,
    processData: false,
    success: function(response) {
      // Tampilkan pesan sukses menggunakan SweetAlert
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
      $('#modal-pembatalan').modal('hide');
    },
    error: function(xhr, status, error) {
      console.error('Terjadi kesalahan saat update:', error);
      Swal.fire({
        title: 'Error!',
        text: 'Terjadi kesalahan saat melakukan pembaruan.',
        icon: 'error',
        confirmButtonText: 'OK'
      });
    }
  });
});


});
</script>







@endsection

@push('script')
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
          const biayaKirim = parseFloat(biayaKirimInput.value) || 0;
          const subCharge = parseFloat(subChargeInput.value) || 0;
          const biayaAdmin = parseFloat(biayaAdminInput.value) || 0;

          const totalBiaya = biayaKirim + subCharge + biayaAdmin;

          const resultElement = document.querySelector('.info-box-number');
          resultElement.textContent = 'Rp. ' + formatNumber(totalBiaya);

          totalBayarInput.value = formatNumber(totalBiaya); // Mengubah nilai input jumlah_bayar
      }

      biayaKirimInput.addEventListener('input', calculateTotal);
      subChargeInput.addEventListener('input', calculateTotal);
      biayaAdminInput.addEventListener('change', calculateTotal);

      calculateTotal(); // Memanggil calculateTotal() saat halaman dimuat

  </script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush