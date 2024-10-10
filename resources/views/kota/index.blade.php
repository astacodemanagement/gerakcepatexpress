
@extends('layouts.app')
@section('title','Halaman Kota')
@section('subtitle','Menu Kota')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card">
            
    <!-- /.card-header -->
    <div class="card-body">
     
    <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-kota"><i class="fas fa-plus-circle"></i> Tambah Data</a>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th width="5%">No</th>
              <th>Kode Kota</th>
              <th>Nama Kota</th>
              <th width="20%">Aksi</th>
            </tr>
            </thead>
            <tbody>
             
              <?php $i = 1; ?>
              @foreach ($kota as $p)
              <tr>
                  <td>{{ $i }}</td>
                  <td>{{ $p->kode_kota}}</td>
                  <td>{{ $p->nama_kota}}</td>
                   
                  <td>
                    <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-edit" data-toggle="modal" data-target="#modal-kota-edit" data-id="{{ $p->id }}" style="color: black">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}" style="color: white">
                      <i class="fas fa-trash-alt"></i> Delete
                  </button>
                  
                  

                </td>
                
                
              </tr>
              <?php $i++; ?>
              @endforeach
          
          
            </tbody>
            <tfoot>
            <tr>
              <th width="5%">No</th>
              <th>Kode Kota</th>
              <th>Nama Kota</th>
              <th width="20%">Aksi</th>
            </tr>
            </tfoot>
          </table>
    </div>
    <!-- /.card-body -->
</div>
  <!-- /.card -->


  <div class="modal fade" id="modal-kota">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Kota</h4>
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
                <form id="form-kota" action="{{ route('kota.store') }}" method="POST" enctype="multipart/form-data">
                   
                  @csrf <!-- Tambahkan token CSRF -->
                  <div class="card-body">
                    
                    <div class="form-group">
                      <label for="kode_kota">Kode Kota</label>
                      <input type="text" class="form-control" id="kode_kota" name="kode_kota" placeholder="Masukkan Kode Kota">
                    </div>
                    <div class="form-group">
                      <label for="nama_kota">Nama Kota</label>
                      <input type="text" class="form-control" id="nama_kota" name="nama_kota" placeholder="Masukkan Nama Kota">
                    </div>


                    
                     
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="btn-simpan-kota"><i class="fas fa-save"></i> Simpan</button>
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
 

  <div class="modal fade" id="modal-kota-edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Edit Kota</h4>
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
                <form id="form-edit-kota" method="POST" enctype="multipart/form-data">
                  @method('PUT')
                  @csrf <!-- Tambahkan token CSRF -->
                  <input type="hidden" id="id" name="id" value="">
                  <div class="card-body">
                    
                    <div class="form-group">
                      <label for="kode_kota_edit">Kode Kota</label>
                      <input type="text" class="form-control" id="kode_kota_edit" name="kode_kota" placeholder="Masukkan Kode Kota">
                    </div>

                    <div class="form-group">
                      <label for="nama_kota_edit">Nama Kota</label>
                      <input type="text" class="form-control" id="nama_kota_edit" name="nama_kota" placeholder="Masukkan Nama Kota">
                    </div>
                   
                    
                     
                  </div>
                  <!-- /.card-body -->
  
                  <div class="card-footer">
                    <button type="button" class="btn btn-primary" id="btn-update-kota"><i class="fas fa-check"></i> Update</button>
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
{{-- perintah simpan data --}}
<script>
  document.getElementById('form-kota').addEventListener('submit', function(e) {
    e.preventDefault(); // Mencegah form melakukan submit default
    const tombolSimpan = $('#btn-simpan-kota')
    var kodeKota = document.getElementById('kode_kota').value.trim();
    var namaKota = document.getElementById('nama_kota').value.trim();

    if (!namaKota || !kodeKota) {
        alert('Harap lengkapi semua bidang!');
        return;
    }
    var formData = new FormData(this);

    $.ajax({
        url: '/simpan-kota', // Ganti dengan URL endpoint Anda
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
            var errorMessage = xhr.responseText ? xhr.responseText : 'Terjadi kesalahan saat menyimpan data';
            console.error('Terjadi kesalahan:', error);
            alert(errorMessage);
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
        var kotaId = $(this).data('id');
        
        // Ajax request untuk mendapatkan data kota
        $.ajax({
    type: 'GET',
    url: '/kota/' + kotaId + '/edit',
    success: function(data) {
        // Mengisi data pada form modal
        $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi
        $('#kode_kota_edit').val(data.kode_kota);
        $('#nama_kota_edit').val(data.nama_kota);
        $('#modal-kota-edit').modal('show');
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
     

    // Sisanya adalah script AJAX yang sudah ada sebelumnya
    $('#btn-update-kota').click(function(e) {
      e.preventDefault();
      const tombolUpdate = $('#btn-update-kota')
      var kotaId = $('#id').val(); // Ambil ID kota dari input tersembunyi
      var formData = new FormData($('#form-edit-kota')[0]);

      // Lakukan permintaan Ajax untuk update data kota
      $.ajax({
        type: 'POST', // Ganti menjadi POST
        url: '/kota/update/' + kotaId,
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
          $('#modal-kota-edit').modal('hide');
        },
        complete: function()
          {tombolUpdate.prop('disabled',false)},
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
  
{{-- perintah update data --}}
 
 
 
{{-- perintah hapus data --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
                        url: '/kota/' + id,
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

{{-- perintah hapus data --}}
@endpush
