@extends('layouts.app')
@section('title', 'Data Penerimaan')
@section('subtitle', 'Menu Data Penerimaan')

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
                                    @if ($cabang)
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
                            <input type="date" class="form-control" name="start_date" id="tanggal_awal"
                                value="{{ $filterStartDate }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal_akhir">Tanggal Akhir:</label>
                            <input type="date" class="form-control" name="end_date" id="tanggal_akhir"
                                value="{{ $filterEndDate }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <!-- Kolom 6 untuk tombol filter -->
                        <button class="btn btn-sm btn-primary"> <i class="fas fa-search"></i> Filter Berdasarkan
                            Range</button>
                    </div>
                </div>
            </form>
            <br>

            {{-- <a href="/" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-penerimaan-edit"><i class="fas fa-plus-circle"></i> Tambah Data</a> --}}
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Tanggal Kirim</th>
                        <th>Tanggal Terima</th>
                        <th>Tanggal Bawa</th>
                        <th>Kode Resi</th>
                        <th>Nama Pengirim</th>
                        <th>Nama Penerima</th>
                        <th>Nama Barang</th>
                        <th>Total Koli</th>
                        <th>Berat</th>
                        <th>Kota Asal</th>
                        <th>Kota Tujuan</th>
                        <th>Total Bayar</th>
                        <th>Status Bayar</th>
                        <th>Status Bawa</th>
                        <th>Nama Pengambil</th>
                        <th>Foto Pengambil</th>
                        <th>Jenis Pembayaran</th>
                        <th>Metode Pembayaran</th>
                        <th>Bukti Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i = 1 @endphp
                    @foreach ($penerimaan as $p)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_kirim)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_terima)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_bawa)->format('d-m-Y') }}</td>
                            <td>{{ $p->kode_resi }}</td>
                            <td>{{ $p->nama_konsumen }}</td>
                            <td>{{ $p->nama_konsumen_penerima }}</td>
                            <td>{{ $p->nama_barang }}</td>
                            <td>{{ $p->koli }}</td>
                            <td>{{ $p->berat }}</td>
                            <td>{{ $p->cabangAsal?->nama_cabang }}</td>
                            <td>{{ $p->cabangTujuan?->nama_cabang }}</td>
                            <td>{{ number_format($p->total_bayar) }}</td>
                            @if ($p->status_bayar === 'Belum Lunas')
                                <td><span class="float-left badge bg-danger">{{ $p->status_bayar }}</span></td>
                            @elseif($p->status_bayar === 'Sudah Lunas')
                                <td><span class="float-left badge bg-success">{{ $p->status_bayar }}</span></td>
                            @else
                                <td>{{ $p->status_bayar }}</td>
                            @endif

                            @if ($p->status_bawa === 'Belum Dibawa')
                                <td><span class="float-left badge bg-danger">{{ $p->status_bawa }}</span></td>
                            @elseif($p->status_bawa === 'Siap Dibawa')
                                <td><span class="float-left badge bg-warning">{{ $p->status_bawa }}</span></td>
                            @elseif($p->status_bawa === 'Sudah Dibawa')
                                <td><span class="float-left badge bg-success">{{ $p->status_bawa }}</span></td>
                            @else
                                <td>{{ $p->status_bawa }}</td>
                            @endif
                            <td>{{ $p->pengambil }}</td>
                            <td>
                                <a href="{{ asset('uploads/bukti_pengambilan/' . $p->gambar_pengambil) }}"
                                    target="_blank"><img style="max-width:50px; max-height:50px"
                                        src="/uploads/bukti_pengambilan/{{ $p->gambar_pengambil }}"
                                        alt="{{ $p->alias }}"></a>
                            </td>
                            <td>
                                <span class="float-left badge bg-secondary"> {{ $p->jenis_pembayaran }}</span>
                            </td>
                            <td>
                                <span class="float-left badge bg-primary"> {{ $p->metode_pembayaran }}</span>
                            </td>
                            <td>
                                <a href="{{ asset('uploads/bukti_bayar_pengiriman/' . $p->bukti_bayar) }}"
                                    target="_blank"><img style="max-width:50px; max-height:50px"
                                        src="/uploads/bukti_bayar_pengiriman/{{ $p->bukti_bayar }}"
                                        alt="{{ $p->alias }}"></a>
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
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush

@push('script')
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
