@extends('layouts.app')
@section('title', 'Halaman Konsumen')
@section('subtitle', 'Menu Konsumen')

@section('content')
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <a href="#" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-konsumen"><i
                    class="fas fa-plus-circle"></i> Tambah Data</a>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Status CAD</th>
                        <th>No Kontrak</th>
                        <th>Jatuh Tempo</th>
                        <th>Nama Konsumen</th>
                        <th>Nama Perusahaan</th>
                        <th>No Telp</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        @hasrole('superadmin')
                            <th>Cabang</th>
                        @endhasrole
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach ($konsumen as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $p->status_cad }}</td>
                           
                            <td>
                                <?php if(empty($p->no_kontrak)): ?>
                                    <span class="float-left badge bg-warning">Tidak Ada Kontrak</span>
                                <?php else: ?>
                                    <span class="float-left badge bg-success"><?php echo $p->no_kontrak; ?></span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if(empty($p->jatuh_tempo)): ?>
                                    <span class="float-left badge bg-warning">Tidak Ada Jatuh Tempo</span>
                                <?php else: ?>
                                    <span class="float-left badge bg-success"><?php echo $p->jatuh_tempo; ?> Hari</span>
                                <?php endif; ?>
                            </td>
                            
                            <td>{{ $p->nama_konsumen }}</td>
                            <td>{{ $p->nama_perusahaan }}</td>
                            <td>{{ $p->no_telp }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->alamat }}</td>
                            @hasrole('superadmin')
                                <td>{{ $p->cabang?->nama_cabang }}</td>
                            @endhasrole
                            <td>
                                <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-edit"
                                    data-toggle="modal" data-target="#modal-konsumen-edit" data-id="{{ $p->id }}"
                                    style="color: black">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}"
                                    style="color: white">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @php $i++ @endphp
                    @endforeach
                </tbody>
                
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

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
                                @hasrole('superadmin')
                                    <div class="form-group">
                                        <label for="cabang">Cabang</label>
                                        <select class="form-control cabang" style="width: 100%;" id="cabang" name="cabang_id"
                                            required>
                                            <option value="">--Pilih Cabang--</option>
                                            <!-- Opsi kota akan dimuat secara dinamis -->
                                        </select>
                                    </div>
                                @endhasrole
                                <div class="form-group">
                                    <label for="nama_konsumen">Nama Konsumen</label>
                                    <input type="text" class="form-control" id="nama_konsumen" name="nama_konsumen"
                                        placeholder="Masukkan Nama Konsumen" required>
                                </div>
                                <div class="form-group">
                                    <label for="status_cad">Status CAD</label>
                                    <select name="status_cad" id="status_cad" class="form-control">
                                        
                                        <option value="Non CAD">Non CAD</option>
                                        <option value="CAD">CAD</option>
                                    </select>
                                </div>
                                <div class="form-group" id="no_kontrak_container">
                                    <label for="no_kontrak">No Kontrak</label>
                                    <input type="text" class="form-control" id="no_kontrak"
                                        name="no_kontrak" placeholder="Masukkan No Kontrak">
                                </div>
                                <div class="form-group" id="jatuh_tempo_container">
                                    <label for="jatuh_tempo">Jatuh Tempo (Hitungan Hari)</label>
                                    <input type="text" class="form-control" id="jatuh_tempo"
                                        name="jatuh_tempo" placeholder="Masukkan Jumlah Jatuh Tempo dalam Hari">
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var statusCadSelect = document.getElementById("status_cad");
                                        var noKontrakContainer = document.getElementById("no_kontrak_container");
                                        var jatuhTempoContainer = document.getElementById("jatuh_tempo_container");
                                    
                                        // Sembunyikan kontainer no_kontrak saat halaman dimuat
                                        noKontrakContainer.style.display = "none";
                                        jatuhTempoContainer.style.display = "none";
                                    
                                        // Tambahkan event listener untuk setiap kali pilihan berubah
                                        statusCadSelect.addEventListener("change", function() {
                                            // Jika status_cad dipilih sebagai CAD, tampilkan no_kontrak_container
                                            if (statusCadSelect.value === "CAD") {
                                                noKontrakContainer.style.display = "block";
                                                jatuhTempoContainer.style.display = "block";
                                            } else {
                                                // Jika tidak, sembunyikan no_kontrak_container
                                                noKontrakContainer.style.display = "none";
                                                jatuhTempoContainer.style.display = "none";
                                            }
                                        });
                                    });
                                    </script>
                                    
                                <div class="form-group">
                                    <label for="nama_konsumen">Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan"
                                        placeholder="Masukkan Nama Perusahaan">
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">No Telp</label>
                                    <input type="text" class="form-control input-phone-number" id="no_telp"
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

    <div class="modal fade" id="modal-konsumen-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Edit Konsumen</h4>
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
                        <form id="form-edit-konsumen" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf <!-- Tambahkan token CSRF -->
                            <input type="hidden" id="id" name="id" value="">
                            <div class="card-body">
                                @hasrole('superadmin')
                                    <div class="form-group">
                                        <label for="cabang">Cabang</label>
                                        <select class="form-control cabang" style="width: 100%;" id="cabang_edit"
                                            name="cabang_id" required>
                                            <option value="">--Pilih Cabang--</option>
                                            <!-- Opsi kota akan dimuat secara dinamis -->
                                        </select>
                                    </div>
                                @endhasrole
                                <div class="form-group">
                                    <label for="nama_konsumen_edit">Nama Konsumen</label>
                                    <input type="text" class="form-control" id="nama_konsumen_edit"
                                        name="nama_konsumen" placeholder="Masukkan Nama Konsumen" required>
                                </div>
                                <div class="form-group">
                                    <label for="status_cad_edit">Status CAD</label>
                                    <select name="status_cad" id="status_cad_edit" class="form-control">
                                        
                                        <option value="Non CAD">Non CAD</option>
                                        <option value="CAD">CAD</option>
                                    </select>
                                </div>
                                <div class="form-group" id="no_kontrak_container_edit">
                                    <label for="no_kontrak">No Kontrak</label>
                                    <input type="text" class="form-control" id="no_kontrak_edit"
                                        name="no_kontrak" placeholder="Masukkan No Kontrak">
                                </div>
                                <div class="form-group" id="jatuh_tempo_container_edit">
                                    <label for="jatuh_tempo_edit">Jatuh Tempo (Hitungan Hari)</label>
                                    <input type="text" class="form-control" id="jatuh_tempo_edit"
                                        name="jatuh_tempo" placeholder="Masukkan Jumlah Jatuh Tempo dalam Hari">
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var statusCadSelect = document.getElementById("status_cad_edit");
                                        var noKontrakContainer = document.getElementById("no_kontrak_container_edit");
                                        var jatuhTempoContainer = document.getElementById("jatuh_tempo_container_edit");
                                    
                                        // Sembunyikan kontainer jatuh_tempo saat halaman dimuat
                                        noKontrakContainer.style.display = "none";
                                        jatuhTempoContainer.style.display = "none";
                                    
                                        // Tambahkan event listener untuk setiap kali pilihan berubah
                                        statusCadSelect.addEventListener("change", function() {
                                            // Jika status_cad dipilih sebagai CAD, tampilkan jatuh_tempo_container
                                            if (statusCadSelect.value === "CAD") {
                                                noKontrakContainer.style.display = "block";
                                                jatuhTempoContainer.style.display = "block";
                                            } else {
                                                // Jika tidak, sembunyikan jatuh_tempo_container
                                                noKontrakContainer.style.display = "none";
                                                jatuhTempoContainer.style.display = "none";
                                            }
                                        });
                                    });
                                    </script>
                                    
                                <div class="form-group">
                                    <label for="nama_perusahaan">Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="nama_perusahaan_edit"
                                        name="nama_perusahaan" placeholder="Masukkan Nama Perusahaan">
                                </div>
                                <div class="form-group">
                                    <label for="no_telp_edit">No Telp</label>
                                    <input type="text" class="form-control input-phone-number" id="no_telp_edit"
                                        name="no_telp" placeholder="Masukkan No Telp" required>
                                </div>
                                <div class="form-group">
                                    <label for="email_edit">Email</label>
                                    <input type="email" class="form-control" id="email_edit" name="email"
                                        placeholder="Masukkan Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat_edit">Alamat</label>
                                    <textarea name="alamat" class="form-control" id="alamat_edit" cols="20" rows="5" required></textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" id="btn-update-konsumen"><i
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
    <!-- /.modal -->
@endsection

@push('script')
    {{-- SKRIP TAMBAHAN  --}}
    <script src="{{ asset('template/plugins/cleave-js/cleave.min.js') }}"></script>
    <script src="{{ asset('template/plugins/cleave-js/addons/cleave-phone.id.js') }}"></script>

    

    <script>
        $('.input-phone-number').toArray().forEach(function(field) {
            new Cleave(field, {
                phone: true,
                phoneRegionCode: 'ID'
            })
        })

        $(document).ready(function() {
            $('.cabang').select2({
                minimumInputLength: 3,
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
                    }
                }
            });
        });
    </script>

    <script>
        document.getElementById('form-konsumen').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah form melakukan submit default
            const tombolSimpan = $('#btn-simpan-konsumen')
            var namaKonsumen = document.getElementById('nama_konsumen').value.trim();
            var statusCAD = document.getElementById('status_cad').value.trim();
            var noKontrak = document.getElementById('no_kontrak').value.trim();
            var jatuhTempo = document.getElementById('jatuh_tempo').value.trim();
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
                            var errorMessage = '';

                            $.each(xhr.responseJSON.errors, function(i, item) {
                                if (i === 'no_telp' && item ===
                                    'Nomor telepon sudah terdaftar.') {
                                    var additionalData = xhr.responseJSON.additional_data;
                                    if (additionalData && additionalData.nama_konsumen) {
                                        errorMessage += 'Nomor telepon sudah terdaftar untuk ' +
                                            additionalData.nama_konsumen + '. ';
                                    } else {
                                        errorMessage += item + ' ';
                                    }
                                } else {
                                    errorMessage += `${item} `;
                                    // Tampilkan pesan kesalahan lainnya di form
                                    $('form').find(
                                            `input[name="${i}"],select[name="${i}"],textarea[name="${i}"]`
                                        )
                                        .closest('div').append(
                                            `<small class="error-message text-danger">${item}</small>`
                                        );
                                }
                            });

                            // Tampilkan SweetAlert untuk semua pesan kesalahan
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                html: errorMessage,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Tampilkan SweetAlert untuk kesalahan lainnya
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: xhr.responseJSON.message,
                                confirmButtonText: 'OK'
                            });
                        }
                    } else {
                        // Tampilkan SweetAlert untuk kesalahan tanpa pesan JSON
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
    </script>



    {{-- perintah edit data --}}
    <script>
        $(document).ready(function() {
            // Mendapatkan elemen input nomor telepon
            var inputNoTelp = document.getElementById('no_telp');

            // Menambahkan event listener untuk membatasi panjang maksimum
            inputNoTelp.addEventListener('input', function() {
                if (this.value.length > 15) {
                    this.value = this.value.slice(0,
                        15); // Memotong input jika panjangnya lebih dari 15 karakter
                }
            });

            $('.dataTable tbody').on('click', 'td .btn-edit', function(e) {
                e.preventDefault();
                var konsumenId = $(this).data('id');

                // Ajax request untuk mendapatkan data konsumen
                $.ajax({
                    type: 'GET',
                    url: '/konsumen/' + konsumenId + '/edit',
                    success: function(data) {
                        // Mengisi data pada form modal
                        $('#id').val(data.id); // Menambahkan nilai id ke input tersembunyi
                        $('#nama_konsumen_edit').val(data.nama_konsumen);
                        $('#status_cad_edit').val(data.status_cad);
                        $('#no_kontrak_edit').val(data.no_kontrak);
                        $('#jatuh_tempo_edit').val(data.jatuh_tempo);
                        $('#no_telp_edit').val(data.no_telp);
                        $('#email_edit').val(data.email);
                        $('#alamat_edit').val(data.alamat);
                        $('#nama_perusahaan_edit').val(data.nama_perusahaan);
                        $('#modal-konsumen-edit').modal('show');
                        @hasrole('superadmin')
                            $('#cabang_edit').html(
                                `<option value="${data.cabang_id}" selected>${data.nama_cabang}</option>`
                            )
                        @endhasrole
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
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
                    this.value = this.value.slice(0,
                        15); // Memotong input jika panjangnya lebih dari 15 karakter
                }
            });

            // Sisanya adalah script AJAX yang sudah ada sebelumnya
            $('#btn-update-konsumen').click(function(e) {
                e.preventDefault();

                const tombolUpdate = $('#btn-update-konsumen')
                const form = $('#form-edit-konsumen')
                if (!form[0].checkValidity()) {
                    form[0].reportValidity()
                    return false;
                }
                var konsumenId = $('#id').val(); // Ambil ID konsumen dari input tersembunyi
                var formData = new FormData($('#form-edit-konsumen')[0]);
                // Lakukan permintaan Ajax untuk update data konsumen
                $.ajax({
                    type: 'POST', // Ganti menjadi POST
                    url: '/konsumen/update/' + konsumenId,
                    data: formData,
                    headers: {
                        'X-HTTP-Method-Override': 'PUT' // Menggunakan header untuk menentukan metode PUT
                    },
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('form').find('.error-message').remove()
                        tombolUpdate.prop('disabled', true)
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
                        $('#modal-konsumen-edit').modal('hide');
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
        });
    </script>
    {{-- perintah update data --}}


    {{-- perintah hapus data --}}
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
                            url: '/konsumen/' + id,
                            type: 'DELETE',
                            data: {
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                // Tambahkan kode lain yang perlu dilakukan setelah penghapusan berhasil
                                console.log(response);
                                // Contoh: Hapus baris dari tabel setelah penghapusan berhasil
                                // $('#baris_' + id).remove();
                                location.reload(); // Refresh halaman setelah hapus
                            },
                            error: function(xhr, status, error) {
                                if (xhr.responseJSON) {
                                    if (xhr.responseJSON.errors) {
                                        console.log(xhr.responseJSON.errors)
                                        $.each(xhr.responseJSON.errors, function(i,
                                            item) {
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
                    }
                });
            });
        });
    </script>

    {{-- perintah hapus data --}}

    <script>
        $('#modal-konsumen-edit').on('hidden.bs.modal', function(e) {
            $('#form-edit-konsumen')[0].reset()
            $('form').find('.error-message').remove()
        })

        $('#modal-konsumen').on('hidden.bs.modal', function(e) {
            $('#form-konsumen')[0].reset()
            $('form').find('.error-message').remove()
        })

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    </script>
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush
