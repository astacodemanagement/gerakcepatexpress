
@extends('layouts.app')
@section('title','Halaman Verifikasi Pembatalan')
@section('subtitle','Menu Verifikasi Pembatalan')

@section('content')
<div class="card">

    <!-- /.card-header -->
    <div class="card-body">


      <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th width="5%">No</th>
              <th>Cabang</th>
              <th>Tanggal Aju</th>
              <th>Tanggal Verifikasi</th>
              <th>Tanggal Ambil</th>
              <th>Kode Resi</th>
              <th>Nama Barang</th>
              <th>Koli</th>
              <th>Berat</th>
              <th>Konsumen</th>
              <th>Status</th>
              <th>Kode Pembatalan</th>
              <th width="10%">Aksi</th>
            </tr>
            </thead>
            <tbody>

              <?php $i = 1; ?>
              @foreach ($verifikasi_pembatalan as $p)
              <tr>
                  <td>{{ $i }}</td>
                  <td><b>{{ $p->nama_cabang }}</b></td>
                  <td>{{ \Carbon\Carbon::parse($p->tanggal_aju_pembatalan)->format('d-m-Y') }}</td>
                  <td>
                    @if(empty($p->tanggal_verifikasi_pembatalan))
                        <span class="badge badge-primary">Belum Ada</span>
                    @else
                        {{ \Carbon\Carbon::parse($p->tanggal_verifikasi_pembatalan)->format('d-m-Y') }}
                    @endif
                  </td>

                  <td>
                    @if(empty($p->tanggal_ambil_pembatalan))
                        <span class="badge badge-primary">Belum Ada</span>
                    @else
                        {{ \Carbon\Carbon::parse($p->tanggal_ambil_pembatalan)->format('d-m-Y') }}
                    @endif
                  </td>

                  <td>{{ $p->kode_resi}}</td>
                  <td>{{ $p->nama_barang}}</td>
                  <td>{{ $p->koli}}</td>
                  <td>{{ $p->berat}}</td>
                  <td>{{ $p->nama_konsumen}}</td>
                  @if($p->status_batal === 'Pengajuan Batal')
                      <td><span class="float-left badge bg-danger">{{ $p->status_batal }}</span></td>
                  @elseif($p->status_batal === 'Verifikasi Disetujui')
                      <td><span class="float-left badge bg-success">{{ $p->status_batal }}</span></td>
                  @elseif($p->status_batal === 'Telah Diambil Pembatalan')
                      <td><span class="float-left badge bg-success">{{ $p->status_batal }}</span></td>
                  @elseif($p->status_batal === 'Verifikasi Ditolak')
                      <td><span class="float-left badge bg-warning" data-toggle="tooltip" data-placement="top" title="{{ $p->alasan_tolak }}">{{ $p->status_batal }}</span></td>
                  @else
                      <td>{{ $p->status_batal }}</td>
                  @endif

                  <td><b>
                    @if(empty($p->kode_pembatalan))
                        <span class="badge badge-secondary">Empty</span>
                    @else
                        {{ $p->kode_pembatalan }}
                    @endif
                </b></td>

                 
                <td>
                  @if($p->status_batal === 'Telah Diambil Pembatalan')
                  <span class="badge badge-danger"><b>Sudah melakukan verifikasi</b></span>
                  @else
                       
                      <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-verifikasi" data-toggle="modal" data-target="#modal-verifikasi_pembatalan-edit" data-id="{{ $p->id }}" style="color: black">
                        <i class="fas fa-edit"></i> Verifikasi
                    </a>
                  @endif
              </td>


              </tr>
              <?php $i++; ?>
              @endforeach


            </tbody>
            <tfoot>
            <tr>
              <th width="5%">No</th>
              <th>Cabang</th>
              <th>Tanggal Aju</th>
              <th>Tanggal Verifikasi</th>
              <th>Tanggal Ambil</th>
              <th>Kode Resi</th>
              <th>Nama Barang</th>
              <th>Koli</th>
              <th>Berat</th>
              <th>Konsumen</th>
              <th>Status</th>
              <th>Kode Pembatalan</th>
              <th width="10%">Aksi</th>
            </tr>
            </tfoot>
          </table>
    </div>
    <!-- /.card-body -->
</div>
  <!-- /.card -->



  <div class="modal fade" id="modal-verifikasi_pembatalan-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Edit Verifikasi Pembatalan</h4>
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
                <form method="POST" id="form-verifikasi_pembatalan">

                  @method('PUT')
                  @csrf <!-- Tambahkan token CSRF -->
                  {{-- <input type="hidden" id="id" name="id" value=""> --}}
                  <div class="card-body">
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
                                <input type="hidden" name="id" id="id">
                                <input type="hidden" name="_method" value="PUT"> <!-- Ganti PUT dengan PATCH jika menggunakan PATCH method -->

                              </div>
                              <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->

                      </div>


                    <div class="form-group">
                      <label for="nama_barang_edit">Nama Barang</label>
                      <input type="text" class="form-control" id="nama_barang_edit"  readonly >
                    </div>
                    <div class="form-group">
                      <label for="koli_edit">Koli</label>
                      <input type="text" class="form-control" id="koli_edit"   readonly>
                    </div>
                    <div class="form-group">
                        <label for="berat_edit">Berat</label>
                        <input type="text" class="form-control" id="berat_edit"  readonly  >
                      </div>
                    <div class="form-group">
                      <label for="keterangan_batal_edit">Keterangan Batal</label>
                      <input type="text" class="form-control" id="keterangan_batal_edit"  readonly>
                    </div>
                    <div class="form-group">
                      <label for="biaya_pembatalan_edit">Biaya Pembatalan</label>
                      <input type="text" class="form-control" id="biaya_pembatalan_edit" readonly >
                    </div>
                    <div class="form-group">
                      <label for="bukti_pembatalan_edit">Bukti Pembatalan</label>
                      <br>
                      <a id="link-bukti_pembatalan" href="#" target="_blank">
                        <img id="bukti_bukti_pembatalan" style="max-width:100px; max-height:100px" src="#" alt="Bukti Pembatalan">
                    </a>

                    </div>

                    <div class="form-group">
                      <label for="status_batal">Status Pembatalan</label>
                      <select class="form-control select2" style="width: 100%;" id="status_batal" name="status_batal" required>
                          <option value="">--Pilih status--</option>
                          <option value="Verifikasi Disetujui">Verifikasi Disetujui</option>
                          <option value="Verifikasi Ditolak">Verifikasi Ditolak</option>
                      </select>
                    </div>
                    <div class="form-group" id="alasan_tolak_container" style="display: none;">
                      <label for="alasan_tolak">Alasan Batal</label>
                      <input type="text" class="form-control" id="alasan_tolak" name="alasan_tolak"  >
                    </div>

                    <style>
                      #kode_pembatalan {
                          font-size: 18px; /* Ubah ukuran font sesuai keinginan */
                          font-weight: bold; /* Teks menjadi tebal */
                          font-style: italic; /* Teks menjadi miring */
                      }
                    </style>

                    <!-- Kemudian, tambahkan input yang diinginkan -->
                    <div class="form-group">
                        <label for="kode_pembatalan">Kode Pembatalan</label>
                        <input type="text" class="form-control" id="kode_pembatalan" name="kode_pembatalan" readonly>
                    </div>


                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="btn-update-verifikasi_pembatalan"><i class="fas fa-check"></i> Update</button>
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
    {{--SKRIP TAMBAHAN  --}}

    <script>
        $(document).ready(function() {
            $('#status_batal').on('change', function() {
                var selectedValue = $(this).val();
                if (selectedValue === 'Verifikasi Ditolak') {
                    $('#alasan_tolak_container').show();
                } else {
                    $('#alasan_tolak_container').hide();
                }
            });
        });
    </script>

    {{-- PERINTAH EDIT/TAMPIL DATA --}}
    <script>
      $(document).ready(function() {

          $('.dataTable tbody').on('click', '.btn-verifikasi', function(e){
              e.preventDefault();
              var verifikasi_pembatalanId = $(this).data('id');

              // Ajax request untuk mendapatkan data verifikasi_pembatalan
              $.ajax({
                  type: 'GET',
                  url: '/verifikasi_pembatalan/' + verifikasi_pembatalanId + '/edit_verifikasi_pembatalan',
                  success: function(data) {
                      // Mengisi data pada form modal
                      $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi

                      // $('#tanggal_verifikasi_pembatalan_edit').val(data.tanggal_verifikasi_pembatalan);
                      $('#kode_resi_edit').val(data.kode_resi);
                      $('#nama_barang_edit').val(data.nama_barang);
                      $('#koli_edit').val(data.koli);
                      $('#berat_edit').val(data.berat);
                      $('#keterangan_edit').val(data.keterangan);
                      $('#keterangan_batal_edit').val(data.keterangan_batal);
                      $('#biaya_pembatalan_edit').val(data.biaya_pembatalan);
                      $('#bukti_pembatalan_edit').val(data.bukti_pembatalan);
                      $('#alasan_tolak').val(data.alasan_tolak);

                      // Menampilkan kode_resi pada input dan h3 setelah mendapatkan data

                      $('#kode_resi_edit_text').text(data.kode_resi);

                      // Generate kode_pembatalan baru
                      $.ajax({
                          url: '/generateKodePembatalan',
                          method: 'GET',
                          dataType: 'json',
                          success: function(kodeData) {
                              $('#kode_pembatalan').val(kodeData.kode_pembatalan);
                          },
                          error: function(xhr, status, error) {
                              console.error(error);
                              // Handle error here
                          }
                      });

                      // Menampilkan gambar bukti_pembatalan
                      var buktiPembatalanPath = '/uploads/bukti_bayar_pengiriman/' + data.bukti_pembatalan;
                      $('#bukti_bukti_pembatalan').attr('src', buktiPembatalanPath);
                      $('#link-bukti_pembatalan').attr('href', buktiPembatalanPath);

                      $('#modal-verifikasi_pembatalan-edit').modal('show');
                  },
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
    {{-- PERINTAH EDIT/TAMPIL DATA --}}

    {{-- PERINTAH UPDATE/PERBAHARUI DATA --}}
    <script>
        $(document).ready(function() {
            // Sisanya adalah script AJAX yang sudah ada sebelumnya
            // $('.dataTable tbody').on('click', 'td .btn-update-verifikasi_pembatalan', function(e) {
            $('#btn-update-verifikasi_pembatalan').click(function(e) {
                e.preventDefault();

                var id = $('#id').val();
                var formData = new FormData($('#form-simpan-pengiriman')[0]);

                const form = $('#form-verifikasi_pembatalan')

                if (!form[0].checkValidity()) {
                    return form[0].reportValidity()
                }

                // Ambil nilai konsumen_id dan nama_konsumen_hidden
                var kode_pembatalan = $('#kode_pembatalan').val();
                var status_batal = $('#status_batal').val();
                var alasan_tolak = $('#alasan_tolak').val();

                // var status_bayar = $('#status_bayar').val();

                // Tambahkan nilai konsumen_id dan nama_konsumen ke dalam FormData
                formData.append('kode_pembatalan', kode_pembatalan);
                formData.append('status_batal', status_batal);
                formData.append('alasan_tolak', alasan_tolak);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

                // Lakukan permintaan Ajax untuk update data profil
                $.ajax({
                    type: 'POST',
                    url: '/verifikasi_pembatalan/update_verifikasi/' + id,
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
                        $('#modal-penerimaan').modal('hide');
                    },
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
    {{-- PERINTAH UPDATE/PERBAHARUI DATA --}}
@endpush
