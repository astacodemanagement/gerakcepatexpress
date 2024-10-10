@extends('layouts.app')
@section('title','Halaman All Summary')
@section('subtitle','Menu All Summary')

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
                    <th>Kota Tujuan</th>
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
                    $total_cad_all = 0;
                    $total_pendapatan_all = 0;
                @endphp
                @foreach ($summary as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $p->cabang->nama_cabang }}</td>
                    <td>{{ $p->cabangTujuan->nama_cabang  }}</td>
                    <td>
                        @php
                            $totalPendapatan = $total_pendapatan_per_cabang
                                ->where('cabang_id_tujuan', $p->cabang_id_tujuan)
                                ->first();
                        @endphp
                    
                        @if($totalPendapatan)
                            <span class="badge badge-success">Rp. {{ number_format($totalPendapatan->total_pendapatan) }}</span>
                        @else
                            Belum ada pendapatan
                        @endif
                    </td>
                    
                    <td>
                        @php
                        $totalPengeluaran = $total_pengeluaran_per_cabang
                            ->where('cabang_id', $p->cabang_id) // Ubah menjadi cabang_id yang sesuai dengan data Anda
                            ->first();
                        @endphp
                    
                        @if($totalPengeluaran)
                            <span class="badge badge-success">Rp. {{ number_format($totalPengeluaran->total_pengeluaran) }}</span>
                        @else
                            Belum ada pengeluaran
                        @endif
                    </td>
                    
                   
                    <td><span class="badge badge-success">Rp. {{ number_format($totalPendapatan->total_pendapatan - $totalPengeluaran->total_pengeluaran ) }}</span></td>





                </tr>
                <?php
                $total_cash_all = 0;
                $total_cod_all = 0;
                $total_cad_all = 0;
                $total_pendapatan_all = 0;
                $i = 1;
            
                foreach ($summary as $p) {
                    $total_cash_all += $p->total_cash;
                    $total_cod_all += $p->total_cod;
                    $total_cad_all += $p->total_cad;
            
                    $total_pendapatan_obj = $total_pendapatan_per_cabang
                        ->where('cabang_id_tujuan', $p->cabang_id_tujuan)
                        ->first();
            
                    if ($total_pendapatan_obj) {
                        $total_pendapatan_all += $total_pendapatan_obj->total_pendapatan;
                    } else {
                        // Handle ketika data tidak ditemukan atau bernilai null
                        // Misalnya, Anda dapat mengaturnya menjadi nol atau pesan yang sesuai
                        // $total_pendapatan_all += 0;
                        // atau
                        // $total_pendapatan_all += "Data tidak tersedia";
                    }
            
                    $i++;
                }
            ?>
            
                @endforeach
                <tfoot>
                    <tr style="font-size: 20px;">
                        <td><strong></strong></td>
                        <td><strong></strong></td>
                        <td><strong>Total Keseluruhan</strong></td>
                        <td><strong><span class="badge badge-success">Rp. {{ number_format($total_pendapatan_all) }}</span></strong></td>
                        @php
                        $total_pengeluaran_all = $total_pengeluaran_per_cabang->sum('total_pengeluaran');
                        @endphp

                        <td><strong><span class="badge badge-success">Rp. {{ number_format($total_pengeluaran_all) }}</span></strong></td>

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
