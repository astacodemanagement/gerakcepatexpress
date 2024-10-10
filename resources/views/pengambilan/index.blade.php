
@extends('layouts.app')
@section('title','Halaman Pengambilan')
@section('subtitle','Menu Pengambilan')

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
            <div class="row">
                <div class="col-12">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="card card-primary">
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="POST" id="form-simpan-pengambilan" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
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
                                    <div class="form-group" id="nama_konsumen_penerima_container" style="display: none;">
                                        <label for="nama_konsumen_penerima">Nama Penerima</label>
                                        <input type="text" class="form-control" id="nama_konsumen_penerima" name="nama_konsumen_penerima" readonly >
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
                                    <div class="form-group" id="pengambil_container" style="display: none;">
                                        <label for="pengambil">Pengambil</label>
                                        <input type="text" class="form-control" id="pengambil" name="pengambil">
                                    </div>

                                    <div class="form-group" id="gambar_pengambil_container" style="display: none;">
                                        <label for="gambar_pengambil">Upload Pengambil</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="gambar_pengambil" name="gambar_pengambil" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(event)">
                                                <label class="custom-file-label" for="gambar_pengambil">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="preview-container" style="display:none;">
                                            <img id="preview-image" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
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

                                    <div class="form-group" id="status_bawa_container" style="display: none;">
                                        <label for="status_bawa">Status Pengambilan</label>
                                        <select class="form-control select2" style="width: 100%;" id="status_bawa" name="status_bawa">
                                            <option value="">--Pilih status pengambilan--</option>
                                            {{-- <option value="1">Belum Diambil</option>
                                            <option value="1">Siap Diambil</option> --}}
                                            <option value="Sudah Dibawa" selected>Sudah Dibawa</option>

                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    {{-- <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Cetak Resi</button> --}}
                                    <button type="submit" class="btn btn-primary btn-simpan" id="btn-simpan-pengambilan"><i class="fas fa-save"></i> Simpan</button>
                                    {{-- <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    @endif
@else
    <div class="card">
        <div class="row">
            <div class="col-12">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="POST" id="form-simpan-pengambilan" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
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
                                <div class="form-group" id="nama_konsumen_penerima_container" style="display: none;">
                                    <label for="nama_konsumen_penerima">Nama Penerima</label>
                                    <input type="text" class="form-control" id="nama_konsumen_penerima" name="nama_konsumen_penerima" readonly >
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
                                <div class="form-group" id="pengambil_container" style="display: none;">
                                    <label for="pengambil">Pengambil</label>
                                    <input type="text" class="form-control" id="pengambil" name="pengambil">
                                </div>


                                <div class="form-group" id="gambar_pengambil_container" style="display: none;">
                                    <label for="gambar_pengambil">Upload Pengambil</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="gambar_pengambil" name="gambar_pengambil" accept="image/jpeg,image/png,image/jpg,image/gif" onchange="previewImage(event)">
                                            <label class="custom-file-label" for="gambar_pengambil">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div id="preview-container" style="display:none;">
                                        <img id="preview-image" src="#" alt="Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;">
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



                                <div class="form-group" id="status_bawa_container" style="display: none;">
                                    <label for="status_bawa">Status Pengambilan</label>
                                    <select class="form-control select2" style="width: 100%;" id="status_bawa" name="status_bawa">
                                    <option value="">--Pilih status pengambilan--</option>
                                    {{-- <option value="1">Belum Diambil</option>
                                    <option value="1">Siap Diambil</option> --}}
                                    <option value="Sudah Dibawa" selected>Sudah Dibawa</option>

                                    </select>
                                </div>


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                {{-- <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Cetak Resi</button> --}}
                                <button type="submit" class="btn btn-primary btn-simpan" id="btn-simpan-pengambilan"><i class="fas fa-save"></i> Simpan</button>
                                {{-- <button type="button" class="btn btn-danger float-right" data-dismiss="modal"><span aria-hidden="true">&times;</span> Close</button> --}}
                            </div>
                        </form>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.card -->
@endif

   {{--SKRIP TAMBAHAN  --}}
<!-- jQuery -->
<script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('template') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
 <!-- SweetAlert CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


{{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}
<script>
  $(document).ready(function() {

    $('#kode_resi').select2({
        // Opsi Select2 jika diperlukan
    });
     // Mendapatkan data awal untuk kode resi
     $.ajax({
         url: '/getResiDataPengambilan', // Ganti dengan URL yang sesuai untuk memuat data kode resi
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
                     url: '/getResiDataPengambilan',
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
            url: '/getDetailResiDataPengambilan', // Ubah sesuai dengan URL yang sesuai untuk mendapatkan data terkait kode resi
            data: { term: selectedResi },
            dataType: 'json',
            success: function(data) {
              // console.log(data)
                // Isi input dengan data yang diterima
                // if (data.length > 0) {
                    $('#nama_konsumen').val(data.nama_konsumen);
                    $('#nama_konsumen_penerima').val(data.nama_konsumen_penerima);
                    $('#nama_barang').val(data.nama_barang);
                    $('#koli').val(data.koli);
                    $('#berat').val(data.berat);
                    // $('#status_bawa').val(data.status_bawa);
                // }
                // Memeriksa jika data diterima, lalu menampilkan form-group container
                if (data.nama_barang && data.koli && data.berat && data.nama_konsumen) {
                    $('#nama_konsumen_container').show();
                    $('#nama_konsumen_penerima_container').show();
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




            $('#form-simpan-pengambilan').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(); // Buat objek FormData untuk mengirim data form termasuk file
                const tombolSimpan = $('#btn-simpan-pengambilan')

            var id = $('#kode_resi').val();
            var status_bawa = $('#status_bawa').val();
            var pengambil = $('#pengambil').val();
            var gambar_pengambil = $('#gambar_pengambil')[0].files[0]; // Dapatkan file gambar

            if (!gambar_pengambil || !pengambil) {
                // Jika gambar_pengambil atau pengambil kosong, tampilkan notifikasi
                Swal.fire({
                    title: 'Peringatan!',
                    text: 'Pastikan semua field terisi dan gambar pengambil wajib diunggah.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return; // Hentikan proses pengiriman data jika ada field yang kosong
            }

            formData.append('_token', '{{ csrf_token() }}');
            formData.append('status_bawa', status_bawa);
            formData.append('pengambil', pengambil);
            formData.append('gambar_pengambil', gambar_pengambil);

            $.ajax({
                type: 'POST',
                url: '/simpan-pengambilan/' + id,
                data: formData, // Gunakan formData sebagai data yang dikirim
                contentType: false, // Hindari default "application/x-www-form-urlencoded"
                processData: false, // Hindari proses otomatis data
                beforeSend: function(){
                    $('form').find('.error-message').remove()
                    tombolSimpan.prop('disabled',true)
                },
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
                complete: function()
                     {tombolSimpan.prop('disabled',false)},
                error: function(xhr, status, error) {
                    // Tampilkan pesan error jika terjadi masalah saat penyimpanan/update
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
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
                            title: 'Oops...',
                            text: 'Terjadi kesalahan, coba lagi nanti!'
                        });
                    }
                }
            });
        });



 });
</script>
{{-- PERINTAH CARI KODE RESI DAN KONSUMEN --}}




@endsection
@push('script')
<script>
  $(document).on('select2:open', () => {
      document.querySelector('.select2-search__field').focus();
  });



</script>

<script>
  $(document).ready(function() {
    //   $('.btn-buka').on('click', function() {
    //       Swal.fire({
    //           title: 'Buka Closingan?',
    //           text: 'Apakah Anda yakin ingin membuka closingan?',
    //           icon: 'question',
    //           showCancelButton: true,
    //           confirmButtonColor: '#3085d6',
    //           cancelButtonColor: '#d33',
    //           confirmButtonText: 'Ya',
    //           cancelButtonText: 'Tidak'
    //       }).then((result) => {
    //           if (result.isConfirmed) {
    //               // Lakukan AJAX request ke route 'buka.closing'
    //               $.ajax({
    //                   url: '{{ route("buka.closing") }}',
    //                   type: 'PUT',
    //                   dataType: 'json',
    //                   headers: {
    //                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                   },
    //                   success: function(response) {
    //                       if (response.success) {
    //                           Swal.fire({
    //                               title: 'Berhasil!',
    //                               text: response.message,
    //                               icon: 'success'
    //                           }).then(() => {
    //                               // Lakukan reload halaman
    //                               location.reload();
    //                           });
    //                       } else {
    //                           Swal.fire('Gagal!', response.message, 'error');
    //                       }
    //                   },
    //                   error: function(xhr, status, error) {
    //                       console.error(error);
    //                   }
    //               });
    //           }
    //       });
    //   });
  });
</script>

@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush
