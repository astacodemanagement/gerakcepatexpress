@extends('layouts.app')
@section('title','Halaman Pengeluaran')
@section('subtitle','Menu Pengeluaran')

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
                    <th>Tanggal Pengeluaran</th>
                    <th>Kode Pengeluaran</th>
                    <th>Nama Pengeluaran</th>
                    <th>Jumlah Pengeluaran</th>
                    <th>Keterangan</th>
                    <th>PIC</th>
                    <th>Bukti</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($pengeluaran as $p)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $p->cabang?->nama_cabang }}</</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pengeluaran)->format('d-m-Y') }}</td>
                    <td>{{ $p->kode_pengeluaran}}</td>
                    <td>{{ $p->nama_pengeluaran}}</td>
                    <td>Rp. {{ number_format($p->jumlah_pengeluaran) }}</td>
                    <td>{{ $p->keterangan}}</td>
                    <td>{{ $p->pic}}</td>
                    <td>
                        <a href="/uploads/bukti_pengeluaran/{{ $p->bukti}}" target="_blank">
                            <img style="max-width:50px; max-height:50px" src="/uploads/bukti_pengeluaran/{{ $p->bukti}}" alt="{{ $p->alias}}">
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
