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
                    <th>Total Pembayaran CASH</th>
                    <th>Total Pembayaran COD</th>
                    <th>Total Pembatalan</th>
                    <th>Total Pendapatan</th>
                    <th>Total Pengeluaran</th>
                    <th>Total Setoran</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $total_cash = 0;
                $total_cod = 0;
                $biaya_pembatalan = 0;
                ?>
                @foreach ($transaksi as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>
                        @if ($p->jenis_pembayaran == 'COD')
                            {{ $p->cabangAsal->nama_cabang }}
                        @else
                            {{ $p->cabang->nama_cabang }}
                        @endif
                    </td>
                    <td>{{ number_format($p->total_bayar) }}</td>
                    <td>
                        @if ($p->jenis_pembayaran == 'COD')
                            <?php $total_cod += $p->total_bayar; ?>
                            Rp. {{ number_format($p->total_bayar) }}
                        @else
                            0
                        @endif
                    </td>
                    <td>
                        @if (!is_null($p->biaya_pembatalan))
                            <?php $biaya_pembatalan += $p->biaya_pembatalan; ?>
                            Rp. {{ number_format($p->biaya_pembatalan) }}
                        @else
                            0
                        @endif
                    </td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                   
                     
                </tr>
                <?php $i++; ?>
                @endforeach

                @foreach ($transaksiCod as $pCod)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $pCod->cabangAsal->nama_cabang }}</td>
                    <td>0</td> {{-- Total Pembayaran CASH pada transaksi COD dianggap 0 --}}
                    <td>Rp. {{ number_format($pCod->total_bayar) }}</td>
                    <td>
                        @if (!is_null($pCod->biaya_pembatalan))
                            <?php $biaya_pembatalan += $pCod->biaya_pembatalan; ?>
                            Rp. {{ number_format($pCod->biaya_pembatalan) }}
                        @else
                            0
                        @endif
                    </td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                <?php $i++; ?>
                @endforeach

        
                <tr>
                    <td><strong>Total Pendapatan</strong></td>
                    <td><strong> </strong></td>
                    <td>Rp. {{ number_format($totalBayar > 0 ? $totalBayar : 0) }}</td>
                    <td>Rp. {{ number_format($totalBayarCod > 0 ? $totalBayarCod : 0) }}</td>
                    <td>Rp. {{ number_format($biaya_pembatalan > 0 ? $biaya_pembatalan : 0) }}</td>
                    <td style="font-size: 20px;">
                        <span class="badge badge-primary">
                            Rp. {{ number_format(max($totalBayar + $totalBayarCod + $biaya_pembatalan, 0)) }}
                        </span>
                    </td>
                    
                    <td style="font-size: 20px;"><span class="badge badge-warning">Rp. {{ number_format($total_pengeluaran) }} </span></td>
                    <td style="font-size: 20px;"><span class="badge badge-success">Rp. {{ number_format($totalBayar + $totalBayarCod + $biaya_pembatalan - $total_pengeluaran) }} </span></td>
                    {{-- <td style="font-size: 20px;"><span class="badge badge-success">Rp. {{ number_format($totalBayar + $total_cod + $biaya_pembatalan - $total_pengeluaran) }} </span></td> --}}
                </tr>
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
