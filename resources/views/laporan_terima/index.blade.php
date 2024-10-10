
@extends('layouts.app')
@section('title','Halaman Penerimaan')
@section('subtitle','Menu Penerimaan')

@section('content')
<div class="card">

    <!-- /.card-header -->
    <div class="card-body">
      {{-- <a href="/" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-penerimaan-edit"><i class="fas fa-plus-circle"></i> Tambah Data</a> --}}
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th width="5%">No</th>
          <th>Tanggal Kirim</th>
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
          <th>Jenis Pembayaran</th>
          <th width="20%">Aksi</th>
        </tr>
        </thead>
        <tbody>

          <?php $i = 1; ?>
          @foreach ($penerimaan as $p)
          <tr>
              <td>{{ $i }}</td>
              <td>{{ $p->tanggal_kirim}}</td>
              <td>{{ $p->kode_resi}}</td>
              <td>{{ $p->nama_konsumen}}</td>
              <td>{{ $p->nama_konsumen_penerima}}</td>
              <td>{{ $p->nama_barang}}</td>
              <td>{{ $p->koli}}</td>
              <td>{{ $p->berat}}</td>
              <td>{{ $p->cabangAsal?->nama_cabang }}</td>
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
              @else
                  <td>{{ $p->status_bawa }}</td>
              @endif

              <td>
                {{ $p->jenis_pembayaran }}
              </td>

              <td>
                @if($p->status_bawa === 'Sudah Dibawa')
                    <a href="#" class="btn btn-sm btn-warning btn-edit" style="color: black" style="color: grey" disabled>
                        <i class="fas fa-edit"></i> Sudah Diterima
                    </a>
                @else
                    <a href="#" class="btn btn-sm btn-warning btn-edit" data-toggle="modal" data-target="#modal-penerimaan-edit" data-id="{{ $p->id }}" style="color: black">
                        <i class="fas fa-edit"></i> Terima
                    </a>
                @endif
              </td>
          </tr>
          <?php $i++; ?>
          @endforeach


        </tbody>
        <tfoot>
        <tr>
          <th width="5%">No</th>
          <th>Tanggal Kirim</th>
          <th>Kode Resi</th>
          <th>Nama Pengirim</th>
          <th>Nama Penerima</th>
          <th>Nama Barang</th>
          <th>Total Koli</th>
          <th>Berat</th>
          <th>Kota Asal</th>
          <th>Kota Tujuan</th>
          <th>Total</th>
          <th>Status Bayar</th>
          <th>Status Bawa</th>
          <th>Jenis Pembayaran</th>
          <th width="20%">Aksi</th>
        </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.card-body -->
</div>
  <!-- /.card -->

 
@endsection

@push('script')
    {{--SKRIP TAMBAHAN  --}}
    @include('js.cleave-js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
   
@endpush
