
@extends('layouts.app')
@section('title','Halaman Pengambilan Pembatalan')
@section('subtitle','Menu Pengambilan Pembatalan')

@section('content')



<div class="card">
   <div class="row">
    <div class="col-12">
    <!-- /.card-header -->
    <div class="card-body">
      <div class="card card-primary">

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
        <form method="POST" id="form-simpan-pengambilan">
          
          @csrf
          <div class="card-body">
            {{-- <div class="form-group">
              <label for="tanggal_bawa">Tanggal Pengambilan</label>
              <input type="date" class="form-control" id="tanggal_bawa" name="tanggal_bawa" >
            </div>
            <script>
              // Dapatkan elemen input tanggal
                const inputTanggal1 = document.getElementById('tanggal_bawa');

                // Dapatkan tanggal hari ini dalam format YYYY-MM-DD
                const today = new Date().toISOString().split('T')[0];

                // Set nilai default input tanggal menjadi tanggal hari ini
                inputTanggal1.value = today;

            </script> --}}
            <div class="form-group">
              <label for="kode_resi">Cari Kode Resi</label>
              <select class="form-control select2" style="width: 100%;" id="kode_resi" name="kode_resi">
                  <option value="">--Pilih kode resi--</option>
                  <!-- Opsi kode resi akan dimuat secara dinamis -->
              </select>

            </div>

            <div class="form-group" id="nama_konsumen_container" style="display: none;">
              <label for="nama_konsumen">Nama Konsumen</label>
              <input type="text" class="form-control" id="nama_konsumen" name="nama_konsumen" readonly >
            </div>
            <div class="form-group"  id="nama_barang_container"style="display: none;">
              <label for="nama_barang">Nama Barang</label>
              <input type="text" class="form-control" id="nama_barang" name="nama_barang" readonly>

          </div>
            <div class="form-group" id="koli_container" style="display: none;">
              <label for="koli">Koli</label>
              <input type="text" class="form-control" id="koli" name="koli" readonly>
            </div>

            <div class="form-group" id="berat_container" style="display: none;">
                <label for="berat">Berat</label>
                <input type="text" class="form-control" id="berat" name="berat" readonly>
            </div>

            <div class="form-group" id="bukti_pembatalan_container" style="display: none;">
              <label for="bukti_pembatalan_edit">Bukti Pembatalan</label>
              <br>
              <a id="link-bukti_pembatalan" href="#" target="_blank">
                <img id="bukti_bukti_pembatalan" style="max-width:100px; max-height:100px" src="#" alt="Bukti Pembatalan">
            </a>

            </div>

            <div class="form-group" id="kode_pembatalan_konfirmasi_container" style="display: none;">
                <label for="kode_pembatalan_konfirmasi">Kode Pembatalan</label>
                <input type="text" class="form-control" id="kode_pembatalan_konfirmasi">
            </div>
            <div class="form-group" id="kode_pembatalan_container" style="display: none;">
              <label for="kode_pembatalan">Kode Pembatalan</label>
              <input type="text" class="form-control" id="kode_pembatalan" name="kode_pembatalan" readonly>
          </div>
            <div class="form-group" id="status_batal_container" style="display: none;">
              <label for="status_batal">Status Pengambilan</label>
              <select class="form-control select2" style="width: 100%;" id="status_batal" name="status_batal">
                <option value="">--Pilih status pengambilan--</option>
                {{-- <option value="1">Belum Diambil</option>
                <option value="1">Siap Diambil</option> --}}
                <option value="Telah Diambil Pembatalan" selected>Telah Diambil Pembatalan</option>

              </select>
            </div>


          </div>
          <!-- /.card-body -->

          <div class="card-footer">
            {{-- <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Cetak Resi</button> --}}
            <button type="submit" class="btn btn-primary " id="btn-simpan-pengambilan" style="display: none;"><i class="fas fa-save"></i> Simpan</button>
            {{-- <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button> --}}

          </div>
        </form>
        @endif
        @else
        <form method="POST" id="form-simpan-pengambilan">

          @csrf
          <div class="card-body">
            {{-- <div class="form-group">
              <label for="tanggal_bawa">Tanggal Pengambilan</label>
              <input type="date" class="form-control" id="tanggal_bawa" name="tanggal_bawa" >
            </div>
            <script>
              // Dapatkan elemen input tanggal
                const inputTanggal1 = document.getElementById('tanggal_bawa');

                // Dapatkan tanggal hari ini dalam format YYYY-MM-DD
                const today = new Date().toISOString().split('T')[0];

                // Set nilai default input tanggal menjadi tanggal hari ini
                inputTanggal1.value = today;

            </script> --}}
            <div class="form-group">
              <label for="kode_resi">Cari Kode Resi</label>
              <select class="form-control select2" style="width: 100%;" id="kode_resi" name="kode_resi">
                  <option value="">--Pilih kode resi--</option>
                  <!-- Opsi kode resi akan dimuat secara dinamis -->
              </select>

            </div>

            <div class="form-group" id="nama_konsumen_container" style="display: none;">
              <label for="nama_konsumen">Nama Konsumen</label>
              <input type="text" class="form-control" id="nama_konsumen" name="nama_konsumen" readonly >
            </div>
            <div class="form-group"  id="nama_barang_container"style="display: none;">
              <label for="nama_barang">Nama Barang</label>
              <input type="text" class="form-control" id="nama_barang" name="nama_barang" readonly>

          </div>
            <div class="form-group" id="koli_container" style="display: none;">
              <label for="koli">Koli</label>
              <input type="text" class="form-control" id="koli" name="koli" readonly>
            </div>

            <div class="form-group" id="berat_container" style="display: none;">
                <label for="berat">Berat</label>
                <input type="text" class="form-control" id="berat" name="berat" readonly>
            </div>

            <div class="form-group" id="bukti_pembatalan_container" style="display: none;">
              <label for="bukti_pembatalan_edit">Bukti Pembatalan</label>
              <br>
              <a id="link-bukti_pembatalan" href="#" target="_blank">
                <img id="bukti_bukti_pembatalan" style="max-width:100px; max-height:100px" src="#" alt="Bukti Pembatalan">
            </a>

            </div>

            <div class="form-group" id="kode_pembatalan_konfirmasi_container" style="display: none;">
                <label for="kode_pembatalan_konfirmasi">Kode Pembatalan</label>
                <input type="text" class="form-control" id="kode_pembatalan_konfirmasi">
            </div>
            <div class="form-group" id="kode_pembatalan_container" style="display: none;">
              <label for="kode_pembatalan">Kode Pembatalan</label>
              <input type="text" class="form-control" id="kode_pembatalan" name="kode_pembatalan" readonly>
          </div>
            <div class="form-group" id="status_batal_container" style="display: none;">
              <label for="status_batal">Status Pengambilan</label>
              <select class="form-control select2" style="width: 100%;" id="status_batal" name="status_batal">
                <option value="">--Pilih status pengambilan--</option>
                {{-- <option value="1">Belum Diambil</option>
                <option value="1">Siap Diambil</option> --}}
                <option value="Telah Diambil Pembatalan" selected>Telah Diambil Pembatalan</option>

              </select>
            </div>


          </div>
          <!-- /.card-body -->

          <div class="card-footer">
            {{-- <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Cetak Resi</button> --}}
            <button type="submit" class="btn btn-primary " id="btn-simpan-pengambilan" style="display: none;"><i class="fas fa-save"></i> Simpan</button>
            {{-- <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button> --}}

          </div>
        </form>
        @endif

      </div>

    </div>
    <!-- /.card-body -->
    </div>
  </div>
</div>
  <!-- /.card -->






   {{--SKRIP TAMBAHAN  --}}
<!-- jQuery -->
<script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('template') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
 <!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


@endsection


@push('script')
{{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}
<script>
  $(document).ready(function() {

    $('#kode_resi').select2({
        // Opsi Select2 jika diperlukan

    });
     // Mendapatkan data awal untuk kode resi
     $.ajax({
         url: '/getResiDataAmbilPembatalan', // Ganti dengan URL yang sesuai untuk memuat data kode resi
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
                     url: '/getResiDataAmbilPembatalan',
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

        // Lakukan permintaan AJAX untuk mendapatkan data terkait dengan kode resi yang dipilih
        $.ajax({
            url: '/getDetailResiDataAmbilPembatalan', // Ubah sesuai dengan URL yang sesuai untuk mendapatkan data terkait kode resi
            data: { term: selectedResi },
            dataType: 'json',
            success: function(data) {
              // console.log(data)
                // Isi input dengan data yang diterima
                // if (data.length > 0) {
                    $('#nama_konsumen').val(data.nama_konsumen);
                    $('#nama_barang').val(data.nama_barang);
                    $('#koli').val(data.koli);
                    $('#berat').val(data.berat);
                    $('#kode_pembatalan').val(data.kode_pembatalan);
                    $('#bukti_pembatalan_edit').val(data.bukti_pembatalan);

                        // Menampilkan gambar bukti_pembatalan
                        var buktiPembatalanPath = '/uploads/bukti_bayar_pengiriman/' + data.bukti_pembatalan;
                      $('#bukti_bukti_pembatalan').attr('src', buktiPembatalanPath);
                      $('#link-bukti_pembatalan').attr('href', buktiPembatalanPath);

                // }
                // Memeriksa jika data diterima, lalu menampilkan form-group container
                if (data.nama_barang && data.koli && data.berat && data.nama_konsumen && data.kode_pembatalan) {
                    $('#nama_konsumen_container').show();
                    $('#nama_barang_container').show();
                    $('#koli_container').show();
                    $('#berat_container').show();
                    $('#bukti_pembatalan_container').show();
                    // $('#status_batal_container').show();
                    $('#kode_pembatalan_konfirmasi_container').show();
                    $('#kode_pembatalan_konfirmasi').focus();

                }
            }
        });


    });

    // Menyimpan/update data pengambilan
    $('#form-simpan-pengambilan').submit(function(event) {
      event.preventDefault();
      var id = $('#kode_resi').val();
      // var tanggalPengambilan = $('#tanggal_bawa').val();
      var status_batal = $('#status_batal').val();

      $.ajax({
          type: 'POST',
          url: '/simpan-ambil-pembatalan/' + id,
          data: {
            _token: '{{ csrf_token() }}',
              // _method: 'PUT', // Atau bisa gunakan @method('PUT') dalam form Laravel
              // tanggal_bawa: tanggalPengambilan,
              status_batal: status_batal,
              // kode_resi: kodeResi,
              // ... (data lainnya jika ada)
          },
          dataType: 'json',
          success: function(response) {
              // Menampilkan SweetAlert setelah berhasil menyimpan/update
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

          },
          error: function(xhr, status, error) {
              console.error(error);
              // Tampilkan pesan error jika terjadi masalah saat penyimpanan/update
              Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Terjadi kesalahan, coba lagi nanti!'
              });
          }
      });
    });

    // Memberikan penanganan peristiwa pada formulir
    $('#form-simpan-pengambilan').on('keypress', function(event) {
        // Cek apakah tombol Enter ditekan (kode tombol 13 adalah tombol Enter)
        if (event.key === 'Enter') {
            event.preventDefault(); // Mencegah pengiriman formulir secara otomatis
            // Tempatkan kode validasi di sini untuk menampilkan sweetalert atau melakukan tindakan lain
        }
    });


 });
</script>
{{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}



<script>
 // Ambil elemen input
const inputKonfirmasi = document.getElementById('kode_pembatalan_konfirmasi');
const inputKodePembatalan = document.getElementById('kode_pembatalan');
const statusBatalContainer = document.getElementById('status_batal_container');
const btnSimpanPengambilan = document.getElementById('btn-simpan-pengambilan');

// Tambahkan event listener untuk input konfirmasi
inputKonfirmasi.addEventListener('keypress', function(event) {
    // Cek apakah tombol Enter ditekan (kode tombol 13 adalah tombol Enter)
    if (event.key === 'Enter') {
        // Ambil nilai dari kedua input
        const konfirmasiValue = inputKonfirmasi.value;
        const kodePembatalanValue = inputKodePembatalan.value;

        // Periksa apakah kedua nilai sama
        if (konfirmasiValue === kodePembatalanValue) {
            Swal.fire({
                title: 'Konfirmasi',
                text: `Yes, kode ${kodePembatalanValue} sudah sesuai.`,
                icon: 'success'
            });

            // Jika validasi berhasil, tampilkan #status_batal_container
            $(statusBatalContainer).show();
            $(btnSimpanPengambilan).show();
        } else {
            Swal.fire({
                title: 'Ops!',
                text: `Kode yang kamu masukkan tidak cocok.`,
                icon: 'error'
            });

            // Jika validasi gagal, sembunyikan #status_batal_container
            $(statusBatalContainer).hide();
        }
    }
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






<script>
  $(document).on('select2:open', () => {
      document.querySelector('.select2-search__field').focus();
  });
</script>

@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush
