<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $invoice->no_invoice }}</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .invoice {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
            border: #000;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
        }

        .invoice-logo {
            width: 100px;
            height: 100px;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid black;
            padding: 5px;
        }

        .invoice-total {
            font-weight: bold;
            position: absolute;
            right: 70px;
            bottom: 0;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
            border-collapse: collapse;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6;
            padding: 0.75rem;
            vertical-align: top;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            /* color: #212529; */
            background-color: transparent;
        }

        table {
            border-collapse: collapse;
        }
        .border, .border tr td, .border tr th {
            border: solid 2px #000
        }
        .border-list {
            border-left: solid 2px #000;
            border-top: solid 2px #000;
            border-right: solid 2px #000;
        }
        .border-list-end {
            border-left: solid 2px #000;
            border-bottom: solid 2px #000;
            border-right: solid 2px #000;
        }
    </style>
</head>
<body style="border:solid 2px #000; padding:1%;" >
    <table style="width: 98%" class="invoice">
        <thead>
        {{-- <thead style="border:solid 4px #000"> --}}
            <tr>
                <td colspan="5" style="text-align: left"><h1 style="color: #026EC2;margin:unset">PT. GERAK CEPAT EXPRESS</h2></td>
                <td colspan="5" style="text-align: right"><h1 style="color: #026EC2;margin:unset">INVOICE</h2></td>
            </tr>
        </thead>
        <thead>
            <tr>
                <td colspan="10" style="text-align: left">{{ $profil->alamat }}, Phone : {{ $profil->no_telp }}, E-mail : {{ $profil->email }}</td>
            </tr>
        </thead>

        <tr>
            <td colspan="10">&nbsp;</td>
        </tr>

        <thead>
            <tr>
                <td colspan="4" style="border:solid 2px #000;background: #D9E1F4; text-align: center">Tanggal dan Waktu</td>
                <td colspan="4" style="border:solid 2px #000;background: #D9E1F4; text-align: center">INVOICE NO</td>
                <td colspan="2"> </td>

            </tr>
            <tr>
                <td colspan="4" style="border:solid 2px #000; text-align: center">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d-m-Y H:i') }}</td>
                <td colspan="4" style="border:solid 2px #000; text-align: center">{{ $invoice->no_invoice }}</td>
                <td colspan="2"> </td>
            </tr>
        </thead>


        <tr>
            <td colspan="10">&nbsp;</td>
        </tr>

        <thead class="border">
            <tr>
                <td colspan="10" style="background: #D9E1F4; text-align: center">Bill To</td>
            </tr>
            <tr>
                <td colspan="3" style="background: #D9E1F4">Nama</td>
                <td colspan="7" style="text-align: center">{{ $invoice->bill_to ?? $billto?->nama_konsumen }}</td>
            </tr>
            <tr>
                <td colspan="3" style="background: #D9E1F4">Alamat</td>
                <td colspan="7" style="text-align: center">{{ $billto?->alamat }}</td>
            </tr>
            <tr>
                <td colspan="3" style="background: #D9E1F4">Keterangan</td>
                <td colspan="7" style="text-align: center">{{ $transaksi[0]->cabangAsal?->nama_cabang }} - {{ $transaksi[0]->cabangTujuan?->nama_cabang }}</td>
            </tr>
            <tr>
                <td colspan="3" style="background: #D9E1F4">Alamat E-Mail</td>
                <td colspan="7" style="text-align: center">{{ $billto?->email }}</td>
            </tr>
        </thead>

        <tr>
            <td colspan="10">&nbsp;</td>
        </tr>

        <thead class="border" style="background:#DEECF7">
            <tr>
                <th width="5%">No</th>
                <th width="10%">TANGGAL</th>
                <th width="10%">RESI</th>
                <th width="12%">PENGIRIM</th>
                <th width="12%">PENERIMA</th>
                <th width="12%">KOTA ASAL</th>
                <th width="12%">KOTA TUJUAN</th>
                <th width="5%">KOLI</th>
                <th width="5%">BERAT</th>
                <th width="17%">TRANSFER</th>
            </tr>
        </thead>

        <tbody>
            @php
                $no = 1;
                $total = 0;
                $totalKoli = 0;
                $totalBerat = 0;
            @endphp
            @foreach ($transaksi as $tr)
                @php
                    $totalBayar = $tr->status_batal == 'Telah Diambil Pembatalan' && $tr->tanggal_aju_pembatalan != null && $tr->tanggal_verifikasi_pembatalan != null && $tr->tanggal_ambil_pembatalan != null ? $tr->biaya_pembatalan : $tr->total_bayar
                @endphp
                <tr>
                    <td class="border-list" style="text-align: center; padding: 4px;">{{ $no }}</td>
                    <td class="border-list" style="text-align: center">{{ $tr->tanggal_booking }}</td>
                    <td class="border-list" style="text-align: center">{{ $tr->kode_resi }}</td>
                    <td class="border-list" style="text-align: center">{{ $tr->nama_konsumen }}</td>
                    <td class="border-list" style="text-align: center">{{ $tr->nama_konsumen_penerima }}</td>
                    <td class="border-list" style="text-align: center">{{ $tr->cabangAsal?->nama_cabang }}</td>
                    <td class="border-list" style="text-align: center">{{ $tr->cabangTujuan?->nama_cabang }}</td>
                    <td class="border-list" style="text-align: center">{{ number_format($tr->koli) }}</td>
                    <td class="border-list" style="text-align: center">{{ number_format($tr->berat) }}</td>
                    <td class="border-list" style="text-align: right">
                        <table style="width: 100%">
                            <tr>
                                <td style="text-align: left">Rp</td>
                                <td style="text-align: right">{{ number_format($totalBayar) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @php
                    $total += $totalBayar;
                    $totalKoli += $tr->koli;
                    $totalBerat += $tr->berat;
                    $no++;
                @endphp
            @endforeach
            <tr>
                <td class="border-list-end">&nbsp;</td>
                <td class="border-list-end"></td>
                <td class="border-list-end"></td>
                <td class="border-list-end"></td>
                <td class="border-list-end"></td>
                <td class="border-list-end"></td>
                <td class="border-list-end"></td>
                <td class="border-list-end"></td>
                <td class="border-list-end"></td>
                <td class="border-list-end"></td>
            </tr>
        </tbody>
        <thead class="border">
            <tr>
                <th colspan="7" style="text-align: center;background: #D9E1F4">Total</th>
                <th style="text-align: center;background: #D9E1F4">{{ number_format($totalKoli) }}</th>
                <th style="text-align: center;background: #D9E1F4">{{ number_format($totalBerat) }}</th>
                <th style="background: #D9E1F4">
                    <table style="width: 100%;border:unset">
                        <tr>
                            <td style="text-align: left;border:unset">Rp</td>
                            <td style="text-align: right;border:unset">{{ number_format($total) }}</td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr>
                <th style="background: #D9E1F4;text-align:center" colspan="9">Done Payment</th>
                <th style="background: #D9E1F4"></th>
            </tr>
            <tr>
                <th style="background: #D9E1F4;text-align:center" colspan="9">Sisa Tagihan</th>
                <th style="background: #D9E1F4">
                    <table style="width: 100%;border:unset">
                        <tr>
                            <td style="text-align: left;border:unset">Rp</td>
                            <td style="text-align: right;border:unset">{{ number_format($total) }}</td>
                        </tr>
                    </table>
                </th>
            </tr>
        </thead>
        <thead>
            <tr>
                <td colspan="10">&nbsp;</td>
            </tr>
        </thead>
        <thead>
            <tr>
                <td colspan="5">
                    <table width="100%" style="background: #D9E1F4;border:solid 2px #000">
                        <tr>
                            <td>Note: Untuk Pembayaran di Transfer Ke:</td>
                        </tr>
                        <tr>
                            <td>Bank {{ $profil->bank }}</td>
                        </tr>
                        <tr>
                            <td>No. Rek. {{ $profil->no_rekening }}</td>
                        </tr>
                    </table>
                </td>
                <td colspan="5" style="padding-left: 10px">
                    <i style="font-size:18px;"> Jatuh Tempo Invoice adalah <br>
                    <b>{{ $konsumen?->jatuh_tempo }}</b> Hari </i>
                </td>
            </tr>
        </thead>
    </table>
</body>
</html>
