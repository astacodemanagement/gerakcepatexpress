
@extends('layouts.app')
@section('title','Halaman Profil')
@section('subtitle','Menu Profil')

@section('content')

<div class="card">
            
    <!-- /.card-header -->
    <div class="card-body">
     
    {{-- <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-profil"><i class="fas fa-plus-circle"></i> Tambah Data</a> --}}
     
    
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th width="5%">No</th>
          <th>Nama Profil</th>
          <th>Alias</th>
          <th>No Telp</th>
          <th>Email</th>
          <th>Website</th>
          <th>Alamat</th>
          <th>Biaya Admin</th>
          <th>Gambar</th>
          <th width="20%">Aksi</th>
        </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @foreach ($profil as $p)
          <tr>
              <td>{{ $i }}</td>
              <td>{{ $p->nama_profil}}</td>
              <td>{{ $p->alias}}</td>
              <td>{{ $p->no_telp}}</td>
              <td>{{ $p->email}}</td>
              <td>{{ $p->link}}</td>
              <td>{{ $p->alamat}}</td>
              <td><span class="float-left badge bg-success">Rp. {{ number_format($p->biaya_admin) }}</span></td>

              
              <td>
                <a href="/uploads/gambar_profil/{{ $p->gambar}}" target="_blank"><img style="max-width:50px; max-height:50px" src="/uploads/gambar_profil/{{ $p->gambar}}" alt="{{ $p->alias}}"></a>
              </td>
            
               
          
              <td>
                <a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#modal-profil-edit" data-id="{{ $p->id }}" style="color: black">
                    <i class="fas fa-edit"></i> Lihat & Edit
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




  <div class="modal fade" id="modal-profil">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Profil</h4>
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
                <form id="form-profil" action="{{ route('profil.store') }}" method="POST" enctype="multipart/form-data">
                   
                  @csrf <!-- Tambahkan token CSRF -->
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-12">
                          <!-- Kolom untuk input kode resi dan nama konsumen -->
                          <div class="form-group">
                              <label for="nama_profil">Nama Profil</label>
                              <input type="text" class="form-control" id="nama_profil" name="nama_profil" placeholder="Masukkan Nama Profil">
                          </div>
                          <div class="form-group">
                              <label for="alias">Alias</label>
                              <input type="text" class="form-control" id="alias" name="alias" placeholder="Masukkan Alias">
                          </div>
                      </div>

                      <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="no_telp">No Telp</label>
                          <input type="number" class="form-control" id="no_telp" name="no_telp" placeholder="Masukkan No Telp">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">
                        </div>
                        
                      </div>
                     
                    </div>

                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-12">
                          
                          <div class="form-group">
                              <label for="alamat">Alamat</label>
                              <textarea  id="alamat" name="alamat" class="form-control" cols="30" rows="3"></textarea>
                          </div>
                        
                          <div class="form-group">
                            <label for="biaya_admin">Biaya Admin</label>
                            <input type="number" class="form-control" id="biaya_admin" name="biaya_admin" placeholder="Masukkan Biaya Admin">
                          </div>
                          <div class="form-group">
                            <label for="biaya_pembatalan">Biaya Pembatalan</label>
                            <input type="number" class="form-control" id="biaya_pembatalan" name="biaya_pembatalan" placeholder="Masukkan Biaya Pembatalan">
                          </div>
                          
                        <div class="form-group">
                          <label for="gambar">Upload Gambar</label>
                          <div class="input-group">
                              <input type="file" name="gambar" id="gambar">
                          </div>
                        </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Gambar Profil</label>
                            <br>
                            {{-- <a href="/uploads/gambar_profil/{{ $p->gambar}}" target="_blank"><img style="max-width:50px; max-height:50px" src="/uploads/gambar_profil/{{ $p->gambar}}" alt="{{ $p->alias}}"></a>
               --}}
                          </div>
                      </div>
                     
                    </div>
                  

                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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


  <div class="modal fade" id="modal-profil-edit">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Edit Profil</h4>
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
                <form id="form-edit-profil" method="POST" enctype="multipart/form-data">
                  @method('PUT')
                  @csrf <!-- Tambahkan token CSRF -->
                  <input type="hidden" id="id" name="id" value="">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-12">
                          <!-- Kolom untuk input kode resi dan nama konsumen -->
                          <div class="form-group">
                              <label for="nama_profil_edit">Nama Profil</label>
                              <input type="text" class="form-control" id="nama_profil_edit" name="nama_profil" placeholder="Masukkan Nama Profil">
                          </div>
                          <div class="form-group">
                              <label for="alias_edit">Alias</label>
                              <input type="text" class="form-control" id="alias_edit" name="alias" placeholder="Masukkan Alias">
                          </div>
                      </div>

                      <div class="col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                          <label for="no_telp_edit">No Telp</label>
                          <input type="number" class="form-control" id="no_telp_edit" name="no_telp" placeholder="Masukkan No Telp">
                        </div>
                        <div class="form-group">
                            <label for="email_edit">Email</label>
                            <input type="email" class="form-control" id="email_edit" name="email" placeholder="Masukkan Email">
                        </div>
                        
                      </div>
                     
                    </div>

                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-12">
                          
                          <div class="form-group">
                              <label for="alamat_edit">Alamat</label>
                              <textarea  id="alamat_edit" name="alamat" class="form-control" cols="30" rows="3"></textarea>
                          </div>
                          <div class="form-group">
                            <label for="link">Website</label>
                            <input type="text" class="form-control" id="link_edit" name="link" placeholder="Masukkan Alamat Website">
                          </div>
                          <div class="form-group">
                            <label for="biaya_admin_edit">Biaya Admin</label>
                            <input type="number" class="form-control" id="biaya_admin_edit" name="biaya_admin" placeholder="Masukkan Biaya Admin">
                          </div>
                          <div class="form-group">
                            <label for="biaya_pembatalan_edit">Biaya Pembatalan</label>
                            <input type="number" class="form-control" id="biaya_pembatalan_edit" name="biaya_pembatalan" placeholder="Masukkan Biaya Pembatalan">
                          </div>
                      </div>
                    </div>

                      <div class="row">
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="no_rekening_edit">No Rekening</label>
                                <input type="number" class="form-control" id="no_rekening_edit" name="no_rekening" placeholder="Masukkan No Rekening">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-12">
                            <div class="form-group">
                                <label for="bank_edit">Bank</label>
                                <input type="text" class="form-control" id="bank_edit" name="bank" placeholder="Masukkan Nama Bank">
                            </div>
                        </div>
                      </div>
                    
                      <div class="row">
                        <div class="col-md-12 col-sm-12 col-12">
                          <div class="form-group">
                            <label for="atas_nama_edit">Atas Nama</label>
                            <input type="text" class="form-control" id="atas_nama_edit" name="atas_nama" placeholder="Masukkan Atas Nama">
                          </div>
                        </div>
                      </div>

                      <div class="row">
                      <div class="col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                          <label for="gambar_edit">Upload Gambar</label>
                          <div class="input-group">
                              <input type="file" name="gambar" id="gambar_edit">
                          </div>
                        </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Gambar Profil</label>
                            <br>
                           <!-- Tempat untuk menampilkan gambar -->
                            <a id="link-gambar" href="#" target="_blank">
                                <img id="gambar-profil" style="max-width:50px; max-height:50px" src="#" alt="Gambar Profil">
                            </a>
                          </div>
                      </div>
                     
                    </div>
                  

                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="btn-update-profil"><i class="fas fa-check"></i> Update</button>
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
 {{--SKRIP TAMBAHAN  --}}
 <!-- jQuery -->
 <script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
 <!-- jQuery UI 1.11.4 -->
 <script src="{{ asset('template') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
 <!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

@push('script')  




 

  
{{-- perintah edit data --}}
<script>
$(document).ready(function() {
    // Mendapatkan elemen input nomor telepon
    var inputNoTelp = document.getElementById('no_telp');

    // Menambahkan event listener untuk membatasi panjang maksimum
    inputNoTelp.addEventListener('input', function() {
      if (this.value.length > 15) {
        this.value = this.value.slice(0, 15); // Memotong input jika panjangnya lebih dari 15 karakter
      }
    });


    $('.dataTable tbody').on('click', 'td .btn-edit', function(e) {
    // $('.btn-edit').click(function(e) {
        e.preventDefault();
        var profilId = $(this).data('id');
       
        
        // Ajax request untuk mendapatkan data profil
        $.ajax({
    type: 'GET',
    url: '/profil/' + profilId + '/edit',
    
    success: function(data) {
      console.log(data)
        // Mengisi data pada form modal
        $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi
        $('#nama_profil_edit').val(data.nama_profil);
        $('#alias_edit').val(data.alias);
        $('#no_telp_edit').val(data.no_telp);
        $('#email_edit').val(data.email);
        $('#alamat_edit').val(data.alamat);
        $('#biaya_admin_edit').val(data.biaya_admin);
        $('#biaya_pembatalan_edit').val(data.biaya_pembatalan);
        $('#no_rekening_edit').val(data.no_rekening);
        $('#bank_edit').val(data.bank);
        $('#atas_nama_edit').val(data.atas_nama);
        $('#link_edit').val(data.link);

        var gambarUrl = '/uploads/gambar_profil/' + data.gambar;
        $('#modal-profil-edit #gambar-profil').attr('src', gambarUrl);
        $('#modal-profil-edit #link-gambar').attr('href', gambarUrl);
        // Menampilkan modal
        $('#modal-profil-edit').modal('show');
    },
    error: function(error) {
        console.log(error);
    }
});

    });
});
</script>

{{-- perintah edit data --}}
 

{{-- perintah update data --}}
<script>
  $(document).ready(function() {
    // Mendapatkan elemen input nomor telepon
    var inputNoTelp = document.getElementById('no_telp_edit');

    // Menambahkan event listener untuk membatasi panjang maksimum
    inputNoTelp.addEventListener('input', function() {
      if (this.value.length > 15) {
        this.value = this.value.slice(0, 15); // Memotong input jika panjangnya lebih dari 15 karakter
      }
    });

    // Sisanya adalah script AJAX yang sudah ada sebelumnya
    $('#btn-update-profil').click(function(e) {
      e.preventDefault();
      const tombolUpdate = $('#btn-update-profil')
      var profilId = $('#id').val(); // Ambil ID profil dari input tersembunyi
      var formData = new FormData($('#form-edit-profil')[0]);

      // Lakukan permintaan Ajax untuk update data profil
      $.ajax({
        type: 'POST', // Ganti menjadi POST
        url: '/profil/update/' + profilId,
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
          $('#modal-profil-edit').modal('hide');
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


  
{{-- perintah update data --}}
 
 
@endpush

 
    
