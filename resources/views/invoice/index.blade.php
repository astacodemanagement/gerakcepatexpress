
@extends('layouts.app')
@section('title','Halaman Invoice')
@section('subtitle','Menu Invoice')

@section('content')
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <!-- Tambahkan input tanggal untuk rentang tanggal -->
            <form action="">
                <div class="row">
                    <div class="col-md-6">
                        @hasrole('superadmin')
                            <div class="form-group">
                                <label for="cabang">Cabang</label>
                                <select name="cabang" id="cabang" class="form-control">
                                    <option value="">--Pilih Cabang--</option>
                                    @isset($cabang)
                                        <option value="{{ $cabang->id }}" selected>{{ $cabang->nama_cabang }}</option>
                                    @endisset
                                </select>
                            </div>
                        @endhasrole
                        <div class="form-group">
                            <label for="start_date">Tanggal</label>
                            <input type="text" class="form-control tanggal" value="@if(request()->start_date && request()->end_date){{ \Carbon\Carbon::parse(request()->start_date)->format('d/m/Y')}} - {{\Carbon\Carbon::parse(request()->end_date)->format('d/m/Y') }}@endif">
                            <input type="hidden" name="start_date" class="start-date d-none" value="{{ request()->start_date ? request()->start_date : \Carbon\Carbon::now()->format('Y-m-d') }}">
                            <input type="hidden" name="end_date" class="end-date d-none" value="{{ request()->end_date ? request()->end_date : \Carbon\Carbon::now()->format('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="konsumen">Konsumen</label>
                            <select name="konsumen" id="konsumen" class="form-control">
                                <option value="">--Pilih Konsumen--</option>
                                @isset($konsumen)
                                    <option value="{{ $konsumen->id }}" selected>{{ $konsumen->nama_konsumen }}</option>
                                @endisset
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @hasrole('superadmin')
                            <div class="form-group">
                                <label for="cabang_asal">Kota Asal</label>
                                <select name="cabang_asal" id="cabang-asal" class="form-control">
                                    <option value="">--Pilih Kota Asal--</option>
                                    @isset($cabangAsal)
                                        <option value="{{ $cabangAsal->id }}" selected>{{ $cabangAsal->nama_cabang }}</option>
                                    @endisset
                                </select>
                            </div>
                        @endhasrole
                        <div class="form-group">
                            <label for="cabang_tujuan">Kota Tujuan</label>
                            <select name="cabang_tujuan" id="cabang-tujuan" class="form-control">
                                <option value="">--Pilih Kota Tujuan--</option>
                                @isset($cabangTujuan)
                                    <option value="{{ $cabangTujuan->id }}" selected>{{ $cabangTujuan->nama_cabang }}</option>
                                @endisset
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="konsumen">Bill To</label>
                            <select name="billto" id="billto" class="form-control">
                                <option value="">--Pilih Konsumen--</option>
                                @isset($billTo)
                                    <option value="{{ $billTo->id }}" selected>{{ $billTo->nama_konsumen }}</option>
                                @endisset
                            </select>
                        </div>
                    </div>
                </div>
                <button class="btn btn-sm btn-primary" conclick="filterData()"> <i class="fas fa-search"></i> Filter</button>
            </form>
            <hr>

            <table id="invoice" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Cabang</th>
                        <th>Tanggal Transaksi</th>
                        <th>No Invoice</th>
                        <th>Bill To</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach ($invoice as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td><b>{{ $p->nama_cabang }}</b></td>
                            <td><span class="float-left badge bg-success">{{ \Carbon\Carbon::parse($p->tanggal_invoice)->format('d-m-Y') }}</span></td>
                            <td>{{ $p->no_invoice}}</td>
                            <td>{{ $p->bill_to}}</td>
                            <td class="text-center">
                                @if ($p->foto)
                                    <img src="{{ asset('uploads/invoice/'.$p->foto) }}" class="img-fluid img-invoice" data-toggle="modal" data-target="#modal-invoice-foto" style="max-height: 50px;cursor:pointer">
                                @endif
                            </td>
                            @if($p->status_invoice === 'Telah Dibuat')
                                <td class="text-center"><span class="badge bg-primary">{{ $p->status_invoice }}</span></td>
                            @elseif($p->status_invoice === 'Sudah Lunas')
                                <td class="text-center">
                                    <span class="badge bg-success">{{ $p->status_invoice }}</span>
                                    <div><small class="text-muted" style="font-size: 70%"><b>Tanggal Pelunasan:</b> {{ Carbon\Carbon::parse($p->updated_at)->format('d F Y') }}</small></div>
                                </td>
                            @else
                                <td>{{ $p->status_invoice }}</td>
                            @endif
                            <td>
                                <button class="btn btn-sm btn-warning text-white btn-upload-foto" data-id="{{ $p->id }}" data-toggle="modal" data-target="#modal-upload-foto">
                                    <i class="fas fa-camera"></i> Upload Foto
                                </button>
                                <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-detail" data-toggle="modal" data-target="#modal-invoie-detail" data-id="{{ $p->id }}" style="color: black">
                                    <i class="fas fa-edit"></i> Detail
                                </a>
                                @if($p->status_invoice !== 'Sudah Lunas')
                                    <button class="btn btn-sm btn-success btn-status" data-id="{{ $p->id }}" style="color: white">
                                        <i class="fas fa-check"></i> Bayar
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-hapus" data-id="{{ $p->id }}" style="color: white">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @php
                            $i++
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                    <th width="5%">No</th>
                        <th>Cabang</th>
                        <th>Tanggal Transaksi</th>
                        <th>No Invoice</th>
                        <th>Bill To</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
    <div class="modal fade" id="modal-invoice-detail" tabindex="-1" role="dialog" aria-labelledby="modal-invoice-detail-label" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="invoice-old modal-detail-invoice" style="height: 78vh">
                   
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-danger download-pdf"><i class="fas fa-file-pdf"></i> Download PDF</a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade" id="modal-upload-foto" tabindex="-1" role="dialog" aria-labelledby="modal-invoice-detail-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Upload Foto Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="mdoal-body p-3">
                    <form action="" class="form-upload-foto">
                        @csrf
                        <div class="form-group">
                            <input type="file" name="upload_foto" class="form-control" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-success btn-submit-upload"><i class="fas fa-upload"></i> Upload</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade" id="modal-invoice-foto" tabindex="-1" role="dialog" aria-labelledby="modal-invoice-detail-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Foto Invoice</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3">
                    <img src="" alt="" class="modal-foto-invoice" style="width: 100%">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
@endsection

@push('css')
    <style>
        body {
            font-family: sans-serif;
        }

        .invoice {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
        }

        .invoice-logo {
            width: 100px;
            height: 100px;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid black;
            padding: 5px;
        }

        .invoice-total {
            font-weight: bold;
            position: absolute;
            right: 70px;
            bottom: 0;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        const baseUrl = '{{ url('') }}'

        $(document).on('click', '.btn-detail', function () {
            // Get the invoice ID from the button
            const invoiceId = $(this).data('id');


            // Send an Ajax request to the `detailInvoice` route
            $.ajax({
                url: `/invoice/${invoiceId}/detail`,
                type: 'GET',
                success: function (response) {
                    $(`<iframe src="${baseUrl}/invoice/${invoiceId}/detail/iframe?billto={{ request('billto') }}" frameborder="0" style="width:100%;height:100%"></iframe>`).appendTo('.modal-detail-invoice');
                    // $('#modal-invoice-detail').find('.invoice-total p').text(`Total: Rp. ${totalBayar}`);
                        // Tampilkan modal
                    $('#modal-invoice-detail').modal('show');
                    $('.download-pdf').prop('href', `${baseUrl}/invoice/${invoiceId}/export/pdf?billto={{ request('billto') }}`)
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
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

        $(function() {
            $('.tanggal').daterangepicker({
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY'
                }
            }, function(start, end, label) {
                // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                $('.start-date').val(start.format('YYYY-MM-DD'))
                $('.end-date').val(end.format('YYYY-MM-DD'))
            });

            $('#modal-invoice-detail').on('hidden.bs.modal', function (e) {
                $('.modal-detail-invoice').html('')
            })

            $('#cabang').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('getCabangData') }}',
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

            $('#cabang-asal').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('getCabangData') }}',
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

            $('#cabang-tujuan').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('getCabangData') }}',
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

            $('#konsumen').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('getKonsumenData') }}',
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
            })

            $('#billto').select2({
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('getKonsumenData') }}',
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
            })

            $(document).on('select2:open', () => {
                document.querySelector('.select2-search__field').focus();
            });
        });

        $('.table').on('click', 'tr td .btn-upload-foto', function() {
            const t = $(this)
            const id = t.data('id')

            $('.btn-submit-upload').attr('data-id', id)
        })
  
        $("#modal-upload-foto").on('hide.bs.modal', function(){
            const t = $(this)
            t.find('form')[0].reset()
            t.find('.error-message').remove()
        });

        $('.btn-submit-upload').on('click', function(){
            const t = $(this)
            const id = t.attr('data-id')
            var formData = new FormData($('.form-upload-foto')[0]);

            $.ajax({
                url: `{{ url('/') }}/invoice/${id}/upload-foto`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $('.form-upload-foto').find('.error-message').remove()
                    t.prop('disabled', true)
                },
                success: function(response) {
                    // Tampilkan SweetAlert untuk notifikasi berhasil
                    Swal.fire({
                        title: 'Sukses!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            location.reload(); // Merefresh halaman saat pengguna menekan OK pada SweetAlert
                        }
                    });
                },
                complete: function() {
                    t.prop('disabled', false)
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(i, item) {
                                $('.form-upload-foto').find(`input[name="${i}"],select[name="${i}"],textarea[name="${i}"]`).closest('div').append(`<small class="error-message text-danger">${item}</small>`)
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
        })

        $('.table').on('click', 'tr td .img-invoice', function() {
            const t = $(this)
            const src = t.attr('src')

            $('.modal-foto-invoice').attr('src', src)
        })
        
        $("#invoice").DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            "lengthMenu": [10, 20, 50, 100, 150, 200], // Set the desired length change options,
            "order": false
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    </script>
    
    <script>
     $(document).ready(function() {
    $(document).on('click', '.btn-hapus', function() {
        const invoiceId = $(this).data('id');

        // Menampilkan konfirmasi SweetAlert sebelum menghapus
        Swal.fire({
            title: 'Anda yakin?',
            text: 'Data invoice akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, lakukan penghapusan
                $.ajax({
                    url: `/invoice/${invoiceId}/delete`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Menampilkan pesan SweetAlert jika penghapusan berhasil
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: 'Data invoice berhasil dihapus.',
                            showCancelButton: false,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Lakukan tindakan setelah tombol OK diklik
                                
                                // Jika ingin reload halaman setelah menghapus
                                location.reload();
                            }
                        });

  
                    },
                    error: function(xhr, status, error) {
                        // Menampilkan pesan SweetAlert jika terjadi kesalahan saat penghapusan
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan dalam penghapusan data invoice.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        console.error('Terjadi kesalahan dalam penghapusan data invoice:', error);
                    }
                });
            }
        });
    });
});


    </script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-status', function() {
            const invoiceId = $(this).data('id');

            // Menampilkan konfirmasi dengan SweetAlert sebelum melakukan pembaruan status
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin memperbarui status invoice menjadi Lunas?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika dikonfirmasi, maka lakukan pembaruan status menggunakan AJAX

                    // Menggunakan metode PUT untuk memperbarui status invoice
                    $.ajax({
                        url: `/invoice/${invoiceId}/update-status`,
                        type: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Tampilkan pesan SweetAlert jika status berhasil diperbarui
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: 'Status invoice dan pembayaran berhasil diperbarui.',
                                showCancelButton: false,
                                showConfirmButton: true,
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Lakukan tindakan setelah tombol OK diklik
                                    // Contoh: reload halaman, perbarui tampilan, dll.
                                    console.log('Tombol OK diklik');
                                    // Jika ingin reload halaman setelah pembaruan status
                                    location.reload();
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Menampilkan pesan SweetAlert jika terjadi kesalahan saat memperbarui status
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan dalam memperbarui status invoice dan pembayaran.',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.error('Terjadi kesalahan dalam memperbarui status invoice dan pembayaran:', error);
                        }
                    });
                }
            });
        });
    });
</script>

    
@endpush
