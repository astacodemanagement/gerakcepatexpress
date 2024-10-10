@extends('layouts.app')
@section('title','Halaman Daftar Muat Detail')
@section('subtitle','Menu Daftar Muat Detail')

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
                <button class="btn btn-sm btn-primary" > <i class="fas fa-search"></i> Filter Berdasarkan Range</button>
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
                    <th>Tanggal Pengiriman</th>
                    <th>Tanggal Penerimaan</th>
                    <th>Kode Resi</th>
                    <th>Kota Asal</th>
                    <th>Kota Penerima</th>
                    <th>Penerima</th>
                    <th>Nomor Penerima</th>
                    <th>Koli</th>
                    <th>Berat</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($daftar_muat as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $p->cabang->nama_cabang }}</</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_kirim)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_terima)->format('d-m-Y') }}</td>
                    <td>{{ $p->kode_resi}}</td>
                    <td>{{ $p->nama_cabang_asal }}</td>
                    <td>{{ $p->nama_cabang_tujuan }}</td>
                    <td>{{ $p->nama_konsumen_penerima }}</td>
                    <td>{{ $p->no_telp }}</td>
                    <td>{{ $p->koli}}</td>
                    <td>{{ $p->berat}}</td>
                    <td>{{ $p->status_batal}}</td>
                </tr>
                <?php $i++; ?>
                @endforeach
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
