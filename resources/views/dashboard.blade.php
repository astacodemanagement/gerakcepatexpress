@extends('layouts.app')
@section('title', 'Halaman Dashboard')
@section('subtitle', 'Menu Dashboard')

@section('content')
    @php
        $userRole = ucwords(auth()->user()->roles[0]->name);
    @endphp
    @if ($userRole === 'Superadmin' || $userRole === 'Kasir' || $userRole === 'Manager')
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <?php $formattedTotalCash = number_format($summaryCash[0]->total, 0, ',', '.'); ?>
                        <h4><b>Rp. {{ $formattedTotalCash }}</b></h4>

                        <p>Summary CASH Tunai</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <?php $formattedTotalsummaryCashTransfer = number_format($summaryCashTransfer[0]->total, 0, ',', '.'); ?>
                        <h4><b>Rp. {{ $formattedTotalsummaryCashTransfer }}</b></h4>

                        <p>Summary Cash Transfer</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">

                        <?php $formattedTotalCod = number_format($summaryCod[0]->total, 0, ',', '.'); ?>
                        <h4><b>Rp. {{ $formattedTotalCod }}</b></h4>

                        <p>Summary COD</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <?php $formattedTotalCad = number_format($summaryCad[0]->total, 0, ',', '.'); ?>
                        <h4><b>Rp. {{ $formattedTotalCad }}</b></h4>

                        <p>Summary CAD</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <div class="row">
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <?php $formattedTotalPembatalan = number_format($summaryPembatalan->total, 0, ',', '.'); ?>
                        <h4><b>Rp. {{ $formattedTotalPembatalan }}</b></h4>

                        <p>Summary Pembatalan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h4><b>Rp. {{ number_format($summaryCODBarangTurunTunai->total, 0, ',', '.') }}</b></h4>

                        <p>Summary COD Barang Turun Tunai</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box text-white" style="background-color: rgb(230, 126, 34) !important">
                    <div class="inner">
                        <h4><b>Rp. {{ number_format($summaryCODBarangTurunTransfer->total, 0, ',', '.') }}</b></h4>

                        <p>Summary COD Barang Turun Transfer</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    @endif
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12">
            @if (ucwords(auth()->user()->roles[0]->name) === 'Superadmin')
                <div id="grafik-table">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-1 h-print">
                                </div>
                                <div class="col-lg-2 label-print">
                                    <div class="row">
                                        <div class="col-lg-4 text-right">
                                            <label class="mt-2">Cabang</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select name="cabang" id="" class="form-control grafik-cabang">
                                                <option value="all">All</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 label-print">
                                    <div class="row">
                                        <div class="col-lg-4 text-right">
                                            <label class="mt-2">Ringkasan</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select name="ringkasan" id="" class="form-control grafik-ringkasan">
                                                <option value="tahunan">Tahunan</option>
                                                <option value="bulanan" selected>Bulanan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 label-print">
                                    <div class="row">
                                        <div class="col-lg-3 text-right">
                                            <label class="mt-2">Date</label>
                                        </div>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control daterange">
                                            <input type="hidden" name="tanggal_awal" class="grafik-start-date">
                                            <input type="hidden" name="tanggal_akhir" class="grafik-end-date">
                                            <input type="hidden" class="h-daterangepicker">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 label-print">
                                    <div class="row mb-3">
                                        <div class="col-lg-4 text-right">
                                            <label class="mt-2">Type Data</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <select name="ringkasan" id=""
                                                class="form-control grafik-type-data">
                                                <option value="rp">Rupiah</option>
                                                <option value="kg">Kg</option>
                                                <option value="koli">Koli</option>
                                                <option value="resi">Resi</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 btn-filter-export">
                                    <button class="btn btn-primary btn-filter-grafik"
                                        data-html2canvas-ignore="true">Filter</button>
                                    <button class="btn btn-danger btn-export-pdf" data-html2canvas-ignore="true"><i
                                            class="fa fa-file-pdf"></i> Export PDF</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="grafik-label">&nbsp;</div>
                            <canvas id="myChart" width="600" height="220"></canvas>
                        </div>
                    </div>

                    <div class="card profit-card">
                        <div class="card-body mb-4">
                            <canvas id="profitChart" width="600" height="220"></canvas>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Bulan</th>
                                        <th>Cabang</th>
                                        <th>Cabang Tujuan</th>
                                        <th>Cash Tunai</th>
                                        <th>Cash Transfer</th>
                                        <th>COD (Barang Naik)</th>
                                        <th>CAD</th>
                                        <th>Pembatalan</th>
                                        <th>Tonase (Kg/Koli)</th>
                                        <th>Total Resi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Profit</h3>
                            {{-- <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-3">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label class="mt-2">Cabang</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <select name="cabang" id="" class="form-control grafik-cabang w-100">
                                            <option value="all">All</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row mb-3">
                                    <div class="col-3">
                                        <label class="mt-2">Date</label>
                                    </div>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control daterange">
                                        <input type="hidden" name="tanggal_awal" class="grafik-start-date">
                                        <input type="hidden" name="tanggal_akhir" class="grafik-end-date">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <button class="btn btn-primary btn-filter-grafik">Filter</button>
                            </div>
                        </div> --}}
                        </div>
                        <div class="card-body">
                            <table class="table datatable-1">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Cabang</th>
                                        <th>Pendapatan</th>
                                        <th>Pengeluaran</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Profit All
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table datatable-2">
                                <thead>
                                    <tr>
                                        <th>Bulan</th>
                                        <th>Pendapatan</th>
                                        <th>Pengeluaran</th>
                                        <th>Profit</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Penjualan Filter
                    </h3>
                  
                    <br>
                    <hr>
                    <div class="form-group">
                        <label for="cabang">Cabang</label>
                        <select class="form-control cabang" style="width: 100%;" id="cabang" name="cabang_id" required>
                            <option value="">--Pilih Cabang--</option>
                            <!-- Opsi kota akan dimuat secara dinamis -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="filter">Filter</label>
                        <select class="form-control select2" style="width: 100%;" id="filter" name="filter" >
                            <option value="">--Pilih filter--</option>
                            <option value="koli">Koli</option>
                            <option value="berat">Berat</option>
                            <option value="total_bayar">Total Bayar</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- Kolom 6 untuk tombol filter -->
                                <button id="filterButton" class="btn btn-sm btn-primary"> <i class="fas fa-search"></i> Filter Data</button>
                            </div>
                        </div> 
                    </div>

                    <br>

                </div><!-- /.card-header -->
                <div class="card-body">
                    <canvas id="myChart2" width="600" height="220"></canvas>
                </div><!-- /.card-body -->
                <br>
               
            </div> --}}
            @endif

            {{-- @if (ucwords(auth()->user()->roles[0]->name) === 'Superadmin')
        <div class="card direct-chat direct-chat-primary">
            <div class="card-header">
                <h3 class="card-title">Tabel Pendapatan</h3>
                <br><br>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Cabang</th>
                            <th>Total Pembayaran CASH</th>
                            <th>Total Pembayaran COD</th>
                            <th>Total Pembayaran CAD</th>
                            <th>Total Pendapatan</th>
                            <th>Total Pengeluaran</th>
                            <th>Total Koli</th>
                            <th>Total Berat</th>
                            <th>Total Resi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        @foreach ($summary as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->cabang->nama_cabang }}</td>
                                <td>Rp. {{ number_format($p->total_cash) }}</td>
                                <td>Rp. {{ number_format($p->total_cod) }}</td>
                                <td>Rp. {{ number_format($p->total_cad) }}</td>
                                <td>
                                    <span class="badge badge-info">
                                        @if ($p->total_cash + $p->total_cod + $p->total_cad > 0)
                                            Rp. {{ number_format($p->total_cash + $p->total_cod + $p->total_cad) }}
                                        @else
                                            Data tidak tersedia
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-danger">
                                        @if ($transaksi->where('cabang_id', $p->cabang_id)->isNotEmpty())
                                            Rp. {{ number_format($total_pengeluaran_per_cabang[$p->cabang_id]) }}
                                        @else
                                            Data tidak tersedia
                                        @endif
                                    </span>
                                </td>
                                <td>{{ $p->total_koli }}</td>
                                <td>{{ $p->total_berat }}</td>
                                <td>{{ $p->total_resi }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-header -->
        </div>
        @endif --}}



            @if (ucwords(auth()->user()->roles[0]->name) === 'Kasir')

                <div>

                    <table id="example1" class="table table-bordered table-striped" style="display: none;">
                        {{-- <table id="example1" class="table table-bordered table-striped"> --}}
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
                                <td colspan="2"><strong>Total Pendapatan</strong></td>
                                <td>Rp. {{ number_format($totalBayar) }}</td>
                                <td>Rp. {{ number_format($totalBayarCod) }}</td>
                                <td>Rp. {{ number_format($biaya_pembatalan) }}</td>
                                <td style="font-size: 20px;"><span class="badge badge-primary">Rp.
                                        {{ number_format($totalBayar + $totalBayarCod + $biaya_pembatalan) }} </span></td>
                                <td style="font-size: 20px;"><span class="badge badge-warning">Rp.
                                        {{ number_format($total_pengeluaran) }} </span></td>
                                <td style="font-size: 20px;"><span class="badge badge-success">Rp.
                                        {{ number_format($totalBayar + $totalBayarCod + $biaya_pembatalan - $total_pengeluaran) }}
                                    </span></td>
                                {{-- <td style="font-size: 20px;"><span class="badge badge-success">Rp. {{ number_format($totalBayar + $total_cod + $biaya_pembatalan - $total_pengeluaran) }} </span></td> --}}
                            </tr>
                        </tbody>
                    </table>



                </div>
                <div class="card direct-chat direct-chat-primary">
                    <div class="card-header">

                        <table id="closing" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Cabang</th>

                                    <th> @php
                                        $namaCabang = auth()->user()->cabang
                                            ? auth()->user()->cabang->nama_cabang
                                            : null;
                                    @endphp
                                        {{ $namaCabang ? $namaCabang : 'SEMUA CABANG' }}
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Total Pembayaran CASH</td>

                                    <td>

                                        @php
                                            $statusCabang = Auth::user()->cabang ? Auth::user()->cabang->status : null;
                                            $cabangId = Auth::user()->cabang ? Auth::user()->cabang->id : null;

                                            if ($statusCabang === 'Nonaktif' && $cabangId == $cabangId) {
                                                $totalBayar = 0; // Set nilai total menjadi 0 jika cabang Nonaktif dan ID sesuai
                                            } else {
                                                $totalBayar;
                                            }
                                        @endphp
                                        Rp. {{ number_format($totalBayar) }}



                                    </td>

                                </tr>
                                <tr>
                                    <td>Total Pembayaran COD</td>

                                    <td>

                                        @php
                                            $statusCabang = Auth::user()->cabang ? Auth::user()->cabang->status : null;
                                            $cabangId = Auth::user()->cabang ? Auth::user()->cabang->id : null;

                                            if ($statusCabang === 'Nonaktif' && $cabangId == $cabangId) {
                                                $totalBayarCod = 0; // Set nilai total menjadi 0 jika cabang Nonaktif dan ID sesuai
                                            } else {
                                                $totalBayarCod;
                                            }
                                        @endphp
                                        Rp. {{ number_format($totalBayarCod) }}



                                    </td>

                                </tr>
                                <tr>
                                    <td>Total Pembatalan</td>

                                    <td>
                                        @php
                                            $statusCabang = Auth::user()->cabang ? Auth::user()->cabang->status : null;
                                            $cabangId = Auth::user()->cabang ? Auth::user()->cabang->id : null;

                                            if ($statusCabang === 'Nonaktif' && $cabangId == $cabangId) {
                                                $biaya_pembatalan = 0; // Set nilai total menjadi 0 jika cabang Nonaktif dan ID sesuai
                                            } else {
                                                $biaya_pembatalan;
                                            }
                                        @endphp
                                        Rp. {{ number_format($biaya_pembatalan) }}
                                    </td>





                                </tr>
                                <!-- Sisipkan baris lain sesuai kebutuhan dengan struktur yang serupa -->

                                <tr>
                                    <td>Total Pendapatan</td>

                                    <td>


                                        <span class="badge badge-primary">
                                            @php
                                                $statusCabang = Auth::user()->cabang
                                                    ? Auth::user()->cabang->status
                                                    : null;
                                                $cabangId = Auth::user()->cabang ? Auth::user()->cabang->id : null;

                                                if ($statusCabang === 'Nonaktif' && $cabangId == $cabangId) {
                                                    $total_pendapatan = 0; // Set nilai total menjadi 0 jika cabang Nonaktif dan ID sesuai
                                                } else {
                                                    $total_pendapatan =
                                                        $totalBayar + $totalBayarCod + $biaya_pembatalan;
                                                }
                                            @endphp
                                            Rp. {{ number_format($total_pendapatan) }}
                                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Total Pengeluaran</td>

                                    <td>

                                        <span class="badge badge-warning">
                                            @php
                                                $statusCabang = Auth::user()->cabang
                                                    ? Auth::user()->cabang->status
                                                    : null;
                                                $cabangId = Auth::user()->cabang ? Auth::user()->cabang->id : null;

                                                if ($statusCabang === 'Nonaktif' && $cabangId == $cabangId) {
                                                    $total_pengeluaran = 0; // Set nilai total menjadi 0 jika cabang Nonaktif dan ID sesuai
                                                } else {
                                                    $total_pengeluaran;
                                                }
                                            @endphp
                                            Rp. {{ number_format($total_pengeluaran) }}
                                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Total Setor</td>

                                    <td>
                                        <span class="badge badge-success">
                                            @php
                                                $statusCabang = Auth::user()->cabang
                                                    ? Auth::user()->cabang->status
                                                    : null;
                                                $cabangId = Auth::user()->cabang ? Auth::user()->cabang->id : null;

                                                if ($statusCabang === 'Nonaktif' && $cabangId == $cabangId) {
                                                    $total_setor = 0; // Set nilai total menjadi 0 jika cabang Nonaktif dan ID sesuai
                                                } else {
                                                    $total_setor = $total_pendapatan - $total_pengeluaran;
                                                }
                                            @endphp
                                            Rp. {{ number_format($total_setor) }}
                                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <td>Nama Kasir</td>
                                    <td>{{ Auth::user()->name }}</td>
                                    <!-- Jika propertinya bukan 'name', ganti 'name' dengan properti yang berisi nama pengguna -->
                                </tr>

                                <tr>
                                    <td>Tanggal Closing</td>
                                    <td>
                                        {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}
                                        {{--  --}}
                                        @php
                                            $statusCabang = Auth::user()->cabang ? Auth::user()->cabang->status : null;

                                            if ($statusCabang === null) {
                                                $statusText = 'Open';
                                                $badgeClass = 'badge-success';
                                                $iconClass = 'online-icon'; // Ganti dengan nama kelas ikon online yang Anda gunakan
                                                $closingButtonEnabled = true;
                                            } elseif ($statusCabang === 'Nonaktif') {
                                                $statusText = 'Nonaktif';
                                                $badgeClass = 'badge-secondary';
                                                $iconClass = 'nonaktif-icon'; // Ganti dengan nama kelas ikon nonaktif yang Anda gunakan
                                                $closingButtonEnabled = false;
                                            } else {
                                                $statusText = $statusCabang;
                                                $badgeClass = 'badge-secondary';
                                                $iconClass = ''; // Jika tidak ada ikon khusus untuk status lainnya
                                                $closingButtonEnabled = false;
                                            }
                                        @endphp
                                    </td>
                                </tr>
                                <span id="unhide" class="badge {{ $badgeClass }}">Status : {{ $statusText }}
                                    @if ($statusText === 'Open' && $statusText !== 'Nonaktif')
                                        <i class="{{ $iconClass }}"></i>
                                    @elseif($statusText === 'Nonaktif')
                                        <!-- Tambahkan ikon khusus untuk status Nonaktif di sini jika diperlukan -->
                                    @endif
                                </span>

                                <br><br>
                                <div id="unhide">
                                    @if ($statusText === 'Open')
                                        <button class="btn btn-sm btn-danger btn-closing" style="color: white">
                                            <i class="fas fa-ban"></i> Closing
                                        </button>
                                    @elseif(
                                        $statusText === 'Nonaktif' &&
                                            \Carbon\Carbon::today()->greaterThan(
                                                \Carbon\Carbon::parse(Auth::user()->cabang?->tanggal_closing)->format('Y-m-d')))
                                        <button class="btn btn-sm btn-success btn-open-closing" style="color: white">
                                            <i class="fas fa-lock-open"></i> Open Closing
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-danger btn-closing" style="color: white" disabled>
                                            <i class="fas fa-ban"></i> Closing
                                        </button>
                                    @endif
                                </div>

                                <br><br>





                            </tbody>
                        </table>



                    </div>
                    <!-- /.card-header -->

                </div>
            @endif

            @if (ucwords(auth()->user()->roles[0]->name) === 'Gudang')
                <div class="card direct-chat direct-chat-primary">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Muat</h3>

                        <br><br>
                        <table id="gudang" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>

                                    <th>Kota Tujuan</th>

                                    <th>Koli</th>
                                    <th>Berat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($daftar_muat as $p)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            {{ $p->cabangTujuan->nama_cabang }}
                                        </td>
                                        <td>{{ $p->total_koli }}</td>
                                        <td>{{ $p->total_berat }}</td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach

                            </tbody>
                        </table>
                        <br>


                    </div>
                    <!-- /.card-header -->

                </div>
            @endif

        </section>
        <!-- /.Left col -->

    </div>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .row {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                margin-right: -7.5px;
                margin-left: -7.5px;
            }

            .col-lg-1 {
                -ms-flex: 0 0 8.333333%;
                flex: 0 0 8.333333%;
                max-width: 8.333333%;
            }

            .col-lg-2 {
                -ms-flex: 0 0 16.666667%;
                flex: 0 0 16.666667%;
                max-width: 16.666667%;
            }

            .col-lg-3 {
                -ms-flex: 0 0 25%;
                flex: 0 0 25%;
                max-width: 25%;
            }

            .col-lg-4 {
                -ms-flex: 0 0 33.333333%;
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }

            .col-lg-8 {
                -ms-flex: 0 0 66.666667%;
                flex: 0 0 66.666667%;
                max-width: 66.666667%;
            }

            .col-lg-9 {
                -ms-flex: 0 0 75%;
                flex: 0 0 75%;
                max-width: 75%;
            }

            .text-right {
                text-align: right !important;
            }

            .btn-filter-export {
                display: none;
                width: 0px !important;
                max-width: 0px !important;
            }

            .small-box .icon {
                display: block
            }

            .label-print {
                -ms-flex: 0 0 19%;
                flex: 0 0 19%;
                max-width: 19%;
            }
        }
    </style>
@endpush

@push('script')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            let cabang = $('.grafik-cabang').val()
            let ringkasan = $('.grafik-ringkasan').val()
            let tglAwal = $('.grafik-start-date').val()
            let tglAkhir = $('.grafik-end-date').val()
            let typeData = $('.grafik-type-data').val()


            var ctx = document.getElementById("myChart").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: [],
                options: {
                    scales: {
                        // yAxes: [{
                        //     ticks: {
                        //         beginAtZero: true
                        //     }
                        // }]

                        yAxes: [{
                            ticks: {
                                callback: function(value) {
                                    return numeral(value).format('0,0')
                                }
                            }
                        }]
                    },

                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return numeral(tooltipItem.yLabel).format('0,0')
                            }
                        }
                    }
                }
            });

            var ctxP = document.getElementById("profitChart").getContext('2d');
            var profitChart = new Chart(ctxP, {
                type: 'bar',
                data: [],
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                callback: function(value) {
                                    return numeral(value).format('0,0')
                                }
                            }
                        }]
                    },

                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return numeral(tooltipItem.yLabel).format('0,0')
                            }
                        }
                    }
                }
            });

            let dtTable = $('.datatable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            let column = dtTable.column(1);
            let columnBulan = dtTable.column(2);
            let columnCabangTujuan = dtTable.column(4);

            let vTableCabangTujuan = false

            column.visible(cabang === 'all' ? false : true)
            columnBulan.visible((cabang === 'all' | cabang !== 'all') && ringkasan === 'tahunan' ? true : false)
            columnCabangTujuan.visible(cabang !== 'all' && ringkasan === 'bulanan' && tglAwal === '' && tglAkhir ===
                '' | (cabang !== 'all' | cabang === 'all') && tglAwal !== '' && tglAkhir !== '' ? true : false)

            let dtTable1 = $('.datatable-1').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });

            let columnBulanProfit = dtTable1.column(0);
            columnBulanProfit.visible(cabang === 'all' && ringkasan === 'tahunan' ? true : false)

            let dtTable2 = $('.datatable-2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            })

            let columnBulanProfitAll = dtTable2.column(0);
            columnBulanProfitAll.visible(cabang === 'all' && ringkasan === 'tahunan' ? true : false)

            setGraph()
            setTable()
            setProfitTable()
            setProfitAllTable()

            $('.daterange').daterangepicker({
                opens: 'left',
                autoUpdateInput: false,
                maxSpan: {
                    days: 30
                },
                locale: {
                    cancelLabel: 'Clear'
                }
            })

            $('.daterange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
                $('.h-daterangepicker').val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate
                    .format('DD/MM/YYYY'))

                $('.grafik-start-date').val(picker.startDate.format('YYYY-MM-DD'))
                $('.grafik-end-date').val(picker.endDate.format('YYYY-MM-DD'))
            });

            $('.daterange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('')
                $('.h-daterangepicker').val('')
                $('.grafik-start-date').val('')
                $('.grafik-end-date').val('')
            });

            $('.btn-filter-grafik').on('click', function() {
                cabang = $('.grafik-cabang').val()
                ringkasan = $('.grafik-ringkasan').val()
                tglAwal = $('.grafik-start-date').val()
                tglAkhir = $('.grafik-end-date').val()
                typeData = $('.grafik-type-data').val()

                column.visible((cabang !== 'all' && ringkasan === 'bulanan') | (cabang !== 'all' &&
                    tglAwal !== '' && tglAkhir !== '') ? true : false)
                columnCabangTujuan.visible((cabang !== 'all' && ringkasan === 'bulanan' && tglAwal === '' &&
                    tglAkhir === '') | ((cabang !== 'all' | cabang === 'all') && tglAwal !== '' &&
                    tglAkhir !== '') ? true : false)
                columnBulan.visible((cabang === 'all' | cabang !== 'all') && ringkasan === 'tahunan' &&
                    tglAwal === '' && tglAkhir === '' ? true : false)

                columnBulanProfit.visible((cabang === 'all' | cabang !== 'all') && ringkasan ===
                    'tahunan' && tglAwal === '' && tglAkhir === '' ? true : false)
                columnBulanProfitAll.visible((cabang === 'all' | cabang !== 'all') && ringkasan ===
                    'tahunan' && tglAwal === '' && tglAkhir === '' ? true : false)

                setGraph()
                setTable()
                setProfitTable()
                setProfitAllTable()
            })

            $('.grafik-cabang').select2({
                minimumInputLength: 2,
                ajax: {
                    url: '/getCabangData',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        let datas = [{
                            text: 'All',
                            id: 'all'
                        }];

                        $.map(data, function(item) {
                            datas.push({
                                text: item.nama_cabang,
                                id: item.id
                            })
                        })

                        return {
                            results: datas
                        }
                    }
                }
            })
            var elementHandler = {
                '#ignoreElement': function(element, renderer) {
                    return true;
                },
                '#anotherIdToBeIgnored': function(element, renderer) {
                    return true;
                }
            };

            $('.btn-export-pdf').on('click', function() {
                var opt = {
                    filename: 'Export Dashboar {{ \Carbon\Carbon::now()->format('YmdHis') }}.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 1
                    },
                    html2canvas: {
                        dpi: 300,
                        letterRendering: true
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: [500, 240],
                        orientation: 'landscape'
                    },
                    pagebreak: {
                        mode: ['avoid-all', 'css']
                    }
                };
                html2pdf().from(document.getElementById('grafik-table')).set(opt).save();
            })

            function setGraph() {
                $.ajax({
                    url: "{{ route('dashboard.grafik-transaksi') }}",
                    method: "GET",
                    data: {
                        cabang: cabang,
                        ringkasan: ringkasan,
                        tanggal_awal: tglAwal,
                        tanggal_akhir: tglAkhir,
                        type_data: typeData
                    },
                    beforeSend: function() {
                        $('.btn-filter-grafik').prop('disabled', true)
                    },
                    success: function(data) {
                        var labels = []
                        var dataSetPendapatan = []
                        var dataSetPengeluaran = []
                        var dataSetBerat = []
                        var dataSetKoli = []
                        var dataSetResi = []
                        // var dataSet = []

                        var pLabels = []
                        var dataSetProfit = []

                        myChart.data.labels = []
                        myChart.data.datasets = []
                        myChart.update();

                        profitChart.data.labels = []
                        profitChart.data.datasets = []
                        profitChart.update();

                        data.forEach(function(item) {
                            myChart.data.labels.push(item.label)
                            profitChart.data.labels.push(item.label)
                            dataSetPendapatan.push(item.pendapatan);
                            dataSetPengeluaran.push(item.pengeluaran);
                            dataSetBerat.push(item.berat);
                            dataSetKoli.push(item.koli);
                            dataSetResi.push(item.resi);
                            dataSetProfit.push(item.profit);
                        });

                        $('.profit-card').addClass('d-none')

                        if (typeData === 'rp') {
                            $('.profit-card').removeClass('d-none')
                            myChart.data.datasets.push({
                                label: 'Pendapatan',
                                backgroundColor: 'rgb(52, 152, 219)',
                                borderColor: 'rgb(41, 128, 185)',
                                borderWidth: 1,
                                data: dataSetPendapatan
                            })
                            myChart.data.datasets.push({
                                label: 'Pengeluaran',
                                backgroundColor: 'rgb(231, 76, 60)',
                                borderColor: 'rgb(192, 57, 43)',
                                borderWidth: 1,
                                data: dataSetPengeluaran
                            })
                            profitChart.data.datasets.push({
                                label: 'Profit',
                                backgroundColor: 'rgb(46, 204, 113)',
                                borderColor: 'rgb(39, 174, 96)',
                                borderWidth: 1,
                                data: dataSetProfit
                            })
                        } else if (typeData === 'kg') {
                            myChart.data.datasets.push({
                                label: 'Kg',
                                backgroundColor: 'rgb(52, 152, 219)',
                                borderColor: 'rgb(41, 128, 185)',
                                borderWidth: 1,
                                data: dataSetBerat
                            })
                        } else if (typeData === 'koli') {
                            myChart.data.datasets.push({
                                label: 'Koli',
                                backgroundColor: 'rgb(52, 152, 219)',
                                borderColor: 'rgb(41, 128, 185)',
                                borderWidth: 1,
                                data: dataSetKoli
                            })
                        } else if (typeData === 'resi') {
                            myChart.data.datasets.push({
                                label: 'Resi',
                                backgroundColor: 'rgb(52, 152, 219)',
                                borderColor: 'rgb(41, 128, 185)',
                                borderWidth: 1,
                                data: dataSetResi
                            })
                        }

                        myChart.update()
                        profitChart.update()

                        $('.grafik-label').html(`&nbsp;`)

                        if ($('.h-daterangepicker').val() !== '') {
                            $('.grafik-label').html(`<b>${$('.h-daterangepicker').val()}</b>`)
                        }
                    },
                    complete: function() {
                        $('.btn-filter-grafik').prop('disabled', false)
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function setTable() {
                $.ajax({
                    url: "{{ route('dashboard.table-transaksi') }}",
                    method: "GET",
                    data: {
                        cabang: cabang,
                        ringkasan: ringkasan,
                        tanggal_awal: tglAwal,
                        tanggal_akhir: tglAkhir,
                        type_data: typeData
                    },
                    beforeSend: function() {
                        $('.btn-filter-grafik').prop('disabled', true)
                        dtTable.clear().draw();
                    },
                    success: function(data) {
                        let dataTables = []

                        data.forEach(function(item, i) {
                            dtTable.row.add([
                                parseInt(i) + 1,
                                item.tanggal_kirim,
                                item.format_bulan,
                                cabang === 'all' && ringkasan === 'tahunan' &&
                                tglAwal == '' && tglAkhir == '' ? 'All' : item.cabang
                                .nama_cabang,
                                (item.cabang_tujuan) ? item.cabang_tujuan.nama_cabang :
                                '',
                                numeral(item.cash_tunai).format('0,0'),
                                numeral(item.cash_transfer).format('0,0'),
                                numeral(item.cod).format('0,0'),
                                numeral(item.cad).format('0,0'),
                                numeral(item.pembatalan).format('0,0'),
                                numeral(item.berat).format('0,0') + '/' + numeral(item
                                    .koli).format('0,0'),
                                numeral(item.resi).format('0,0')
                            ]).draw(false);
                        })
                    },
                    complete: function() {
                        $('.btn-filter-grafik').prop('disabled', false)
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function setProfitTable() {
                $.ajax({
                    url: "{{ route('dashboard.table-profit') }}",
                    method: "GET",
                    data: {
                        cabang: cabang,
                        ringkasan: ringkasan,
                        tanggal_awal: tglAwal,
                        tanggal_akhir: tglAkhir,
                        type_data: typeData
                    },
                    beforeSend: function() {
                        $('.btn-filter-grafik').prop('disabled', true)
                        dtTable1.clear().draw();
                    },
                    success: function(data) {
                        let dataTables = []

                        data.forEach(function(item, i) {
                            dtTable1.row.add([
                                item.format_bulan,
                                cabang === 'all' && ringkasan === 'tahunan' &&
                                tglAwal == '' && tglAkhir == '' ? 'All' : item.cabang
                                .nama_cabang,
                                numeral(item.pendapatan).format('0,0'),
                                numeral(item.pengeluaran).format('0,0'),
                                numeral(item.profit).format('0,0')
                            ]).draw(false);
                        })
                    },
                    complete: function() {
                        $('.btn-filter-grafik').prop('disabled', false)
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function setProfitAllTable() {
                $.ajax({
                    url: "{{ route('dashboard.table-profit-all') }}",
                    method: "GET",
                    data: {
                        cabang: cabang,
                        ringkasan: ringkasan,
                        tanggal_awal: tglAwal,
                        tanggal_akhir: tglAkhir,
                        type_data: typeData
                    },
                    beforeSend: function() {
                        $('.btn-filter-grafik').prop('disabled', true)
                        dtTable2.clear().draw();
                    },
                    success: function(data) {
                        let dataTables = []

                        data.forEach(function(item, i) {
                            dtTable2.row.add([
                                item.format_bulan,
                                numeral(item.pendapatan).format('0,0'),
                                numeral(item.pengeluaran).format('0,0'),
                                numeral(item.profit).format('0,0')
                            ]).draw(false);
                        })
                    },
                    complete: function() {
                        $('.btn-filter-grafik').prop('disabled', false)
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
        })
    </script>

    <script>
        $(document).ready(function() {
            $('.cabang').select2({
                minimumInputLength: 2,
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
        $(function() {
            $("#gudang").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#gudang_wrapper .col-md-6:eq(0)');


            $("#closing").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false,
                "info": false,
                "paging": false, // Menyembunyikan penomoran halaman
                "lengthMenu": [], // Menyembunyikan pilihan jumlah data per halaman
                "dom": 'Bfrtip', // Hanya tombol aksi yang ditampilkan
                "buttons": ["copy", "csv", "excel", "pdf", "print"]
            }).buttons().container().appendTo('#closing_wrapper .col-md-6:eq(0)');
        });
    </script>

    <script>
        // $(document).ready(function() {
        //    // Menggunakan jQuery untuk melakukan AJAX saat halaman dimuat
        //    loadData();

        //     // Menangani perubahan pada pemilihan cabang atau filter
        //     $('#cabang, #filter').on('change', function() {
        //         loadData();
        //     });

        //     // Menangani klik pada tombol filter
        //     $('#filterButton').on('click', function() {
        //         loadData();
        //     });
        // });

        // function loadData() {
        //     var cabangId = $('#cabang').val();
        //     var filter = $('#filter').val();

        //     // Menggunakan jQuery untuk melakukan AJAX dengan parameter cabangId dan filter
        //     $.ajax({
        //         url: "{{ route('data.transaksi2') }}",
        //         method: "GET",
        //         data: { cabang_id: cabangId, filter: filter },
        //         success: function(data) {
        //             updateChart(data);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(error);
        //         }
        //     });
        // }

        function updateChart(data) {
            var labels = [];
            var dataSet = [];

            data.forEach(function(item) {
                labels.push(item.tanggal); // Menggunakan item.tanggal karena telah diubah pada controller
                dataSet.push(item.total);
            });

            // Update data dalam grafik
            var ctx = document.getElementById("myChart2").getContext('2d');
            var myChart2 = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan Pengiriman',
                        data: dataSet,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    </script>



    <script>
        @hasrole('kasir')
            $(document).ready(function() {
                $('.btn-closing').on('click', function() {
                    const cabangId =
                        '{{ Auth::user()->cabang_id }}'; // Mengambil cabang_id dari session yang sedang login
                    const tanggalClosing = $('#tanggal_closing')
                        .val(); // Mendapatkan nilai tanggal_closing dari input

                    // Tampilkan konfirmasi SweetAlert sebelum menjalankan proses
                    Swal.fire({
                        title: 'Anda yakin ingin melakukan closing?',
                        text: 'Tindakan ini akan mengubah status cabang.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Lakukan Closing!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika pengguna mengkonfirmasi, jalankan proses AJAX
                            $.ajax({
                                url: '/update-closing/' + cabangId,
                                type: 'POST',
                                dataType: 'json',
                                data: {
                                    tanggal_closing: tanggalClosing // Mengirim nilai tanggal_closing ke controller
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function(response) {
                                    window.print();
                                    // Tampilkan notifikasi SweetAlert setelah pembaruan berhasil
                                    if (response.file.length > 0) {
                                        var a = $("<a class='download' />");
                                        a.attr("download",
                                            `{{ url('download-backup?file=') }} ${response.file}`
                                        );
                                        a.attr("href",
                                            `{{ url('download-backup?file=') }} ${response.file}`
                                        );
                                        $("body").append(a);
                                        a[0].click();
                                        $("body").remove(a);
                                    }
                                    var printButton = document.createElement('button');
                                    printButton.textContent = 'Print';
                                    printButton.classList.add('btn',
                                    'btn-primary'); // Add Bootstrap classes for styling (optional)

                                    // Add click event listener to the button
                                    printButton.addEventListener('click', function() {
                                        window
                                    .print(); // Trigger print dialog when clicked
                                    });
                                    appendDom: printButton
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Closing berhasil!',
                                        text: response.message
                                    }).then(function() {
                                       
                                        // Melakukan reload halaman setelah alert ditutup
                                        location.reload();
                                    });
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseJSON) {
                                        if (xhr.responseJSON.errors) {
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

                $('.btn-open-closing').on('click', function() {
                    // Tampilkan konfirmasi SweetAlert sebelum menjalankan proses
                    Swal.fire({
                        title: 'Anda yakin ingin membuka closing?',
                        text: 'Tindakan ini akan mengubah status cabang.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Buka Closing!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Jika pengguna mengkonfirmasi, jalankan proses AJAX
                            $.ajax({
                                url: '/buka-closing',
                                type: 'PUT',
                                dataType: 'json',
                                data: {
                                    status: 1 // Mengirim nilai tanggal_closing ke controller
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                        'content')
                                },
                                success: function(response) {
                                    // Tampilkan notifikasi SweetAlert setelah pembaruan berhasil
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Closing berhasil dibuka',
                                        text: response.message
                                    }).then(function() {
                                        // Melakukan reload halaman setelah alert ditutup
                                        location.reload();
                                    });
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.responseJSON) {
                                        if (xhr.responseJSON.errors) {
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
        @endhasrole
    </script>
@endpush

@push('css')
    <link rel="stylesheet" href="{{ asset('template/plugins/select2/css/custom.css') }}">
@endpush
