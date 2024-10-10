@extends('layouts.app')
@section('title','Halaman Kasir Summary')
@section('subtitle','Menu Kasir Summary')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card">
    <div class="card-body">
        <div class="col-md-12 col-sm-12 col-12">
            <form action="">
                <label for="tanggal_awal">Tanggal Awal:</label>
                <input type="date" class="form-control" id="tanggal_awal" name="start_date" value="{{ $filterStartDate }}">
                <br>
                <label for="tanggal_akhir">Tanggal Akhir:</label>
                <input type="date" class="form-control" id="tanggal_akhir" name="end_date" value="{{ $filterEndDate }}">

                <br>
                {{-- <button class="btn btn-sm btn-primary" onclick="filterData()"> <i class="fas fa-search"></i> Filter Berdasarkan Range</button> --}}
                <button class="btn btn-sm btn-primary"> <i class="fas fa-search"></i> Filter Berdasarkan Range</button>
            </form>
            <br>
            <hr>
        </div>

        <br>

        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Cabang</th>
                    <th>Total Pembayaran Kas</th>
                    <th>Total Pembayaran COD</th>
                    <th>Total Pembatalan</th>
                    <th>Total Pendapatan</th>
                    <th>Total Pengeluaran</th>
                    <th>Total Setoran</th>

                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @php
                    $total_cash_all = 0;
                    $total_cod_all = 0;
                    $total_pembatalan_all = 0;
                    $total_pendapatan_all = 0;
                @endphp
                @foreach ($summary as $p)
                    @php
                        $totalPendapatan = $p->total_cash + $p->total_cod + $p->total_pembatalan;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td>{{ $p->nama_cabang }}</td>
                        <td>Rp. {{ number_format($p->total_cash) }}</td>
                        <td>Rp. {{ number_format($p->total_cod) }}</td>
                        <td>Rp. {{ number_format($p->total_pembatalan) }}</td>
                        <td>
                            @if($totalPendapatan)
                                <span class="badge badge-success">Rp. {{ number_format($totalPendapatan) }}</span>
                            @else
                                Belum ada pendapatan
                            @endif
                        </td>
                        @php
                            $userRole = Auth::user()->role; // Mengambil informasi peran dari data autentikasi (ini hanya contoh)
                        @endphp

                        <td>
                            @php
                                if ($p->sumber_cabang == 'cabang_id') {
                                    $totalPengeluaran = ($userRole === '') ?
                                        $total_pengeluaran_per_cabang :
                                        $total_pengeluaran_per_cabang->where('cabang_id', $p->cabang_id)->first();
                                }

                                else if ($p->sumber_cabang == 'cabang_tujuan_id') {
                                    $totalPengeluaran = ($userRole === '') ?
                                        $total_pengeluaran_per_cabang :
                                        $total_pengeluaran_per_cabang->where('cabang_id', $p->cabang_tujuan_id)->first();
                                }
                            @endphp
                            
                            @if($totalPengeluaran)
                                <span class="badge badge-success">Rp. {{ number_format($totalPengeluaran->total_pengeluaran) }}</span>
                            @else
                                Belum ada pengeluaran
                            @endif
                        </td>

                        <td>
                            @php
                                $totalPengeluaran = $totalPengeluaran ? $totalPengeluaran->total_pengeluaran : 0;
                                $totalSetoran = $totalPendapatan - $totalPengeluaran;
                            @endphp
                            <span class="badge badge-success">Rp. {{ number_format($totalSetoran) }}</span>
                        </td>
                    </tr>
                    @php
                        $i++;
                        $total_cash_all += $p->total_cash;
                        $total_cod_all += $p->total_cod;
                        $total_pembatalan_all += $p->total_pembatalan;
                        $total_pendapatan_all += $totalPendapatan;
                    @endphp
                @endforeach
                <tfoot>
                    <tr style="font-size: 20px;">
                        <td><strong></strong></td>
                        <td><strong>Total Keseluruhan</strong></td>
                        <td><strong>Rp. {{ number_format($total_cash_all) }}</strong></td>
                        <td><strong>Rp. {{ number_format($total_cod_all) }}</strong></td>
                        <td><strong>Rp. {{ number_format($total_pembatalan_all) }}</strong></td>
                        <td><strong><span class="badge badge-success">Rp. {{ number_format($total_pendapatan_all) }}</span></strong></td>
                        <td><strong><span class="badge badge-success">Rp. {{ number_format($total_pengeluaran) }}</span></strong></td>
                        <td><strong><span class="badge badge-success">Rp. {{ number_format($total_harus_disetor) }}</span></strong></td>
                    </tr>
                </tfoot>

            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

{{-- SCRIPT TAMBAHAN --}}
<!-- jQuery -->
<script src="{{ asset('template') }}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('template') }}/plugins/jquery-ui/jquery-ui.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    // Tangkap elemen input tanggal
    // const tanggalAwalInput = document.getElementById('tanggal_awal');
    // const tanggalAkhirInput = document.getElementById('tanggal_akhir');

    // Tambahkan event listener untuk input tanggal
    // tanggalAwalInput.addEventListener('change', filterData);
    // tanggalAkhirInput.addEventListener('change', filterData);

    // function filterData() {
    //     // Ambil nilai tanggal dari input
    //     const tanggalAwal = new Date(tanggalAwalInput.value);
    //     const tanggalAkhir = new Date(tanggalAkhirInput.value);

    //     // Ambil semua baris data dari tabel
    //     const rows = document.querySelectorAll('#example1 tbody tr');

    //     // Loop melalui setiap baris dan sembunyikan/munculkan berdasarkan rentang tanggal
    //     rows.forEach(row => {
    //         const tanggalRow = new Date(row.cells[2].textContent); // Mengakses langsung cell dari indeks

    //         if (tanggalRow >= tanggalAwal && tanggalRow <= tanggalAkhir) {
    //             row.style.display = ''; // Tampilkan baris jika dalam rentang tanggal
    //         } else {
    //             row.style.display = 'none'; // Sembunyikan baris jika di luar rentang tanggal
    //         }
    //     });
    // }
</script>

@endsection
