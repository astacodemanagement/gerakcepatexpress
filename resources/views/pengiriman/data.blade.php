
@extends('layouts.app')
@section('title','Halaman Pengiriman')
@section('subtitle','Menu Pengiriman')

@section('content')
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <form method="get">
                @hasrole('superadmin')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tanggal_awal">Cabang</label>
                                <select name="cabang" id="cabang" class="form-control">
                                    <option value="">--Pilih Cabang--</option>
                                    @if($cabang)
                                        <option value="{{ $cabang->id }}" selected>{{ $cabang->nama_cabang }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                @endhasrole
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_awal">Tanggal Awal:</label>
                            <input type="date" class="form-control" name="start_date" id="tanggal_awal" value="{{ $filterStartDate }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_akhir">Tanggal Akhir:</label>
                            <input type="date" class="form-control" name="end_date" id="tanggal_akhir" value="{{ $filterEndDate }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Kolom 6 untuk tombol filter -->
                        <button class="btn btn-sm btn-primary"> <i class="fas fa-search"></i> Filter Berdasarkan Range</button>
                    </div>
                </div>
            </form>
            <br>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th width="3%">No</th>
                <th>Cabang</th>
                <th>Tanggal Kirim</th>
                <th>Kode Resi</th>
                <th>Pengirim</th>
                <th>Nama Barang</th>
                <th>Koli</th>
                <th>Berat</th>
                <th>Kota Asal</th>
                <th>Kota Tujuan</th>
                <th>Total Bayar</th>
                <th>Status Bayar</th>
                <th>Status Bawa</th>
                <th>Status Batal</th>
                <th>Jenis Bayar</th>
                <th>Metode Bayar</th>
                <th>Bukti Bayar</th>
                <th>No Invoice</th>
                <th>Aksi</th>
                </tr>
                </thead>
                <tbody>

                <?php $i = 1; ?>
                @foreach ($pengiriman as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td><b>{{ $p->nama_cabang }}</b></td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_kirim)->format('d-m-Y') }}</td>
                    <td>{{ $p->kode_resi}}</td>
                    <td>{{ $p->nama_konsumen}}</td>
                    <td>{{ $p->nama_barang}}</td>
                    <td>{{ $p->koli}}</td>
                    <td>{{ $p->berat}}</td>
                    <td><b>{{ $p->cabangAsal?->nama_cabang }}</b></td>
                    <td>{{ $p->cabangTujuan?->nama_cabang }}</td>
                    <td>{{ number_format($p->total_bayar) }}</td>
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
                    <td>{{ $p->jenis_pembayaran}}</td>
                    <td>{{ $p->metode_pembayaran}}</td>
                    <td>
                        <a href="{{ asset('uploads/bukti_bayar_pengiriman/' . $p->bukti_bayar) }}" target="_blank"><img style="max-width:50px; max-height:50px" src="/uploads/bukti_bayar_pengiriman/{{ $p->bukti_bayar}}" alt="{{ $p->alias}}"></a>
                    </td>
                    <td>{{ $p->no_invoice}}</td>
                    <td>

                        <a style="color: rgb(242, 236, 236)" href="#" class="btn btn-sm btn-primary btn-detail" data-toggle="modal" data-target="#modal-cetak-resi" data-id="{{ $p->id }}" style="color: rgb(253, 253, 253)">
                            <i class="fas fa-print"></i> Cetak Resi
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


  <div class="modal fade" id="modal-cetak-resi" tabindex="-1" role="dialog" aria-labelledby="modal-cetak-resi-label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Resi</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="resi-old modal-detail-resi" style="height: 78vh">

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-cetak-resi"><i class="fas fa-print"></i> Cetak</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
<div class="print-element d-none"></div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush

@push('script')

<script>
    const baseUrl = '{{ url('') }}'

    $(document).on('click', '.btn-detail', function () {
        // Get the resi ID from the button
        const resiId = $(this).data('id');

        $('.btn-cetak-resi').attr('data-id', resiId)
        $(`<iframe src="${baseUrl}/resi/${resiId}/detail" class="iframe-resi" frameborder="0" style="width:100%;height:100%"></iframe>`).appendTo('.modal-detail-resi');

        // Tampilkan modal
        $('#modal-cetak-resi').modal('show');
    });

    $('.btn-cetak-resi').on('click', function(){
        const resiId = $(this).attr('data-id');
        $('.print-element').html(`<iframe src="${baseUrl}/resi/${resiId}/detail?print=true" class="iframe-resi" frameborder="0" style="width:100%;height:100%"></iframe>`);
    })

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

        $('#modal-cetak-resi').on('hidden.bs.modal', function (e) {
            $('.modal-detail-resi').html('')
            $('.print-element').html('')
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

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
    });

</script>


    <script>
        @hasrole('superadmin')
            $(function() {
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

                $(document).on('select2:open', () => {
                    document.querySelector('.select2-search__field').focus();
                });
            })
        @endhasrole
    </script>
@endpush
