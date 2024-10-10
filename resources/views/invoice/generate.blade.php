
@extends('layouts.app')
@section('title','Halaman Generate Invoice')
@section('subtitle','Menu Generate Invoice')

@section('content')
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">

            <a href="#" class="btn btn-primary mb-3" id="generateInvoice">
                <i class="fas fa-plus-circle"></i> Generate Invoice
            </a>
            <a href="{{ route('invoice.index') }}" class="btn btn-success mb-3">
                <i class="fas fa-eye"></i> Lihat Invoice
            </a>
            <br>
            {{-- <input type="text" name="no_invoice" id="no_invoice" value="123456"> --}}
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="checkAll"></th>
                        <th width="5%">No</th>
                        @hasrole('superadmin')<th>Cabang</th>@endhasrole
                        <th>Tanggal Transaksi</th>
                        <th>Kode Resi</th>
                        <th>Nama Konsumen</th>
                        <th>Nama Konsumen Penerima</th>
                        <th>Bill To</th>
                        <th>Nama Barang</th>
                        <th>Koli</th>
                        <th>Berat</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1
                    @endphp
                    @foreach ($invoice as $p)
                        <tr>
                            <td><input type="checkbox" data-kode-resi="{{ $p->kode_resi }}"></td>
                            <td>{{ $i }}</td>
                            @hasrole('superadmin')<td><b>{{ $p->nama_cabang }}</b></td>@endhasrole
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_kirim)->format('d-m-Y') }}</td>
                            <td>{{ $p->kode_resi}}</td>
                            <td>{{ $p->nama_konsumen}}</td>
                            <td>{{ $p->nama_konsumen_penerima}}</td>
                            <td>{{ $p->nama_bill_to}}</td>
                            <td>{{ $p->nama_barang}}</td>
                            <td>{{ $p->koli}}</td>
                            <td>{{ $p->berat}}</td>
                            <td>{{ $p->keterangan}}</td>
                        </tr>
                        @php
                            $i++
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th width="5%">No</th>
                        @hasrole('superadmin')<th>Cabang</th>@endhasrole
                        <th>Tanggal Transaksi</th>
                        <th>Kode Resi</th>
                        <th>Nama Konsumen</th>
                        <th>Nama Konsumen Penerima</th>
                        <th>Bill To</th>
                        <th>Nama Barang</th>
                        <th>Koli</th>
                        <th>Berat</th>
                        <th>Keterangan</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@endsection

@push('css')
    <style>
        /* Style untuk judul "Check All" */
        #checkAll {
            transform: scale(1.5);
        }

        /* Style untuk kotak centang pada setiap baris */
        tbody input[type="checkbox"] {
            transform: scale(1.2);
        }
    </style>
@endpush

@push('script')
    {{--SKRIP TAMBAHAN  --}}
    <script>
        // Fungsi untuk mengatur centang pada semua baris
        function checkAll() {
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
            checkboxes.forEach((checkbox) => {
            checkbox.checked = document.getElementById('checkAll').checked;
            });
        }

        // Tambahkan event listener ke kotak centang "Check All"
        document.getElementById('checkAll').addEventListener('change', checkAll);

        // Tambahkan event listener ke setiap kotak centang pada baris
        const rowCheckboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        rowCheckboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', () => {
            const allChecked = [...rowCheckboxes].every((cb) => cb.checked);
            document.getElementById('checkAll').checked = allChecked;
            });
        });
    </script>

    <script>
        document.getElementById('generateInvoice').addEventListener('click', function() {
            const selectedItems = [];
            const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');

            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    const kodeResi = checkbox.getAttribute('data-kode-resi');

                    selectedItems.push({ kodeResi });
                }
            });


            if (selectedItems.length > 0) {
                // Tampilkan konfirmasi dengan SweetAlert
                Swal.fire({
                    icon: 'question',
                    title: 'Yakin ingin melakukan proses?',
                    text: 'Proses ini akan membuat satu invoice dari data yang dipilih.',
                    showCancelButton: true,
                    confirmButtonText: 'Yakin',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pengguna menekan 'Ya', lanjutkan dengan permintaan AJAX
                        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const xhr = new XMLHttpRequest();
                        const url = '{{ route('invoice.update-generate') }}'; // Ubah URL ini sesuai dengan endpoint update
                        xhr.open('PUT', url, true);
                        xhr.setRequestHeader('Content-Type', 'application/json');
                        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    // Respon dari server saat berhasil
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: 'Invoice berhasil dibuat!'
                                    }).then(() => {
                                        location.reload(); // Reload halaman setelah pengguna menekan OK
                                    });
                                } else {
                                    // Respon dari server saat gagal
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Terjadi kesalahan, data tidak dapat diperbarui.'
                                    });
                                }
                            }
                        };
                        xhr.send(JSON.stringify(selectedItems));
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Tidak ada data yang dipilih untuk digenerate.',
                    cancelButtonText: 'Batal'
                })
            }
        });

    </script>
@endpush
