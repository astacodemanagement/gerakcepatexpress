<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Resi</title>
    <style>
        @page {
            width: 210mm;
            margin: 0;
            size: landscape
        }

        @media print {
            .keterangan {
                display: none;
            }
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px
        }

        table {
            width: 100%;
        }

        .text-center {
            text-align: center !important
        }

        .text-end {
            text-align: right !important
        }

        .text-left {
            text-align: left !important
        }
    </style>

    <?php
    function terbilang($angka)
    {
        $angka = abs($angka);
        $huruf = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        $terbilang = '';
        if ($angka < 12) {
            $terbilang = ' ' . $huruf[$angka];
        } elseif ($angka < 20) {
            $terbilang = terbilang($angka - 10) . ' belas';
        } elseif ($angka < 100) {
            $terbilang = terbilang($angka / 10) . ' puluh' . terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = ' seratus' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = terbilang($angka / 100) . ' ratus' . terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = ' seribu' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = terbilang($angka / 1000) . ' ribu' . terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = terbilang($angka / 1000000) . ' juta' . terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $terbilang = terbilang($angka / 1000000000) . ' milyar' . terbilang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            $terbilang = terbilang($angka / 1000000000000) . ' trilyun' . terbilang($angka % 1000000000000);
        }
        return $terbilang;
    }
    ?>



</head>

<body class="print-resi">

    <table>
        <tr>
            <td width="33.33%" style="font-size: 15px">
                Pengirim<br><br>
                <span>{{ $resi->cabangAsal?->kode_cabang }} - {{ $resi->cabangAsal?->nama_kota }}</span>
                <br>
            </td>
            <td width="33.33%" class="text-center" style="font-size: 20px">RESI PENGIRIMAN</td>
            <td width="33.33%">
                <div>
                    <img src="{{ asset('template/dist/img/logo_gce.png') }}" alt="GCE Logo" style="height:36px">
                    <span style="font-size: 14px;font-weight:700;top: -13px;position: relative;">GERAK CEPAT
                        EXPRESS</span>
                </div>

               <i><span><b>{{ $profil->no_telp }} - {{ $profil->email }} 
                <br>
                {{ $profil->link }}  </b></span></i>
                <br>

            </td>
        </tr>
        <tr style="font-size: 15px;">
            <td>
                <table>
                    <tr>
                        <td width="37%">Jenis Bayar :</td>
                        <td>{{ $resi->jenis_pembayaran }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="37%">Asal :</td>
                        <td>{{ $resi->cabangAsal?->nama_cabang }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="37%">No. Resi :</td>
                        <td>{{ $resi->kode_resi }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="font-size: 15px;">
            <td>
                <table>
                    <tr>
                        <td width="37%">Metode Bayar :</td>
                        <td>{{ $resi->metode_pembayaran }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="37%">Tujuan :</td>
                        <td>{{ $resi->cabangTujuan?->nama_cabang }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="37%">Tanggal Transaksi :</td>
                        <td>{{ \Carbon\Carbon::parse($resi->tanggal_kirim)->format('d/m/Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td class="keterangan">
                <table>
                    <tr style="font-size: 15px;">
                        <td width="37%">Keterangan :</td>
                        <td>{{ $resi->keterangan }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr style="border: solid 1px">
    <table>
        <tr style="font-size: 15px">
            <td width="40%"><u>Pengirim</u></td>
            <td width="33.33%"><u>Penerima</u></td>
            <td width="33.33%"><u>Keterangan Kasir</u> </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr style="font-size: 17px;">
                        <td width="20%">Nama</td>
                        <td>{{ $resi->nama_konsumen }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr style="font-size: 17px;">
                        <td width="20%">Nama</td>
                        <td>{{ $resi->nama_konsumen_penerima }}</td>
                    </tr>
                </table>
            <td>
                <table>
                    <tr>
                        {{-- <td width="40%"><b>Keterangan Kasir : </b></td> --}}
                    </tr>
                    <tr style="font-size: 17px;">

                        <td>{{ $resi->keterangan_kasir }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr style="font-size: 17px;">
                        <td width="20%">Alamat</td>
                        <td>{{ $resi->konsumen?->alamat }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr style="font-size: 17px;">
                        <td width="20%">Alamat</td>
                        <td>{{ $resi->penerima?->alamat }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="20%"></td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table>
                    <tr style="font-size: 17px;">
                        <td width="20%">Telp</td>
                        <td>08x-xxx-xxx-xxx</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr style="font-size: 17px;">
                        <td width="20%">Telp</td>
                        <td>{{ $resi->penerima?->no_telp }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table>
                    <tr>
                        <td width="20%"></td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr style="border: solid 1px">
    <table style="font-size: 15px;">
        <tr>
            <td class="text-center">ISI BARANG</td>
            <td class="text-center" width="6%">KOLI</td>
            <td class="text-center" width="8%">BERAT (KG)</td>
            {{-- <td class="text-center">KETERANGAN KASIR</td> --}}
            <td class="text-center">HARGA KIRIM</td>
            <td class="text-center">SUB CHARGE</td>
            <td class="text-center">BIAYA ADMIN</td>
            <td class="text-center">TOTAL</td>
            <td width="5%"></td>
        </tr>
        <tr>
            <td class="text-center">{{ $resi->nama_barang }}</td>
            <td class="text-center">{{ $resi->koli }}</td>
            <td class="text-center">{{ $resi->berat }}</td>
            {{-- <td class="text-center">{{ $resi->keterangan_kasir }}</td> --}}
            <td class="text-center">{{ number_format($resi->harga_kirim) }}</td>
            <td class="text-center">{{ number_format($resi->sub_charge) }}</td>
            <td class="text-center">
                {{ ($resi->biaya_admin != null) | ($resi->biaya_admin != '') ? number_format($resi->biaya_admin) : 0 }}
            </td>
            <td class="text-center">{{ number_format($resi->total_bayar) }}</td>
            <td></td>
        </tr>
    </table>
    <br>
    <br>
    Terbilang : <?php
    $terbilang = terbilang($resi->total_bayar);
    echo ucwords($terbilang); // Untuk membuat huruf pertama menjadi kapital
    ?> Rupiah

    <br>
    Tanggal Cetak : {{ Carbon\Carbon::now()->format('d/m/Y H:i:s') }}
    <br>
    {{-- <i><b>Bank - Nomor Rekening : {{ $profil->bank }} - {{ $profil->no_rekening }}</b></i>
    <br>
    <i><b>Atas Nama : {{ $profil->atas_nama }}</b></i> --}}
    <div class="text-center">
        <table style="margin-top: -30px;">
            <tr>
                <td width="30%"></td>
                <td>
                    <u style="text-underline-offset: 0.6em">{{ auth()->user()->name }}</u>
                </td>
                <td>
                    <u style="text-underline-offset: 0.6em">(...........................)</u>
                </td>
                <td>
                    <u style="text-underline-offset: 0.6em">(...........................)</u>
                </td>
                <td width="36%" style="font-size: 13px;"><b>
                            Rekening Resmi: {{ $profil->nama_profil }}
                            <br>
                            Bank : {{ $profil->bank }} - No Rekening : {{ $profil->no_rekening }}
                            <br>
                            an : {{ $profil->atas_nama }}
                            <br>
                            <i><span>(Selain rekening tersebut pembayaran tidak sah)</span></i></b>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding-top: 0.6em">Petugas</td>
                <td style="padding-top: 0.6em">Pengirim</td>
                <td style="padding-top: 0.6em">Penerima</td>
                <td></td>
            </tr>
        </table>
    </div>

</body>

<script>
    @if (request('print') == true)
        window.print()
    @endif
</script>

</html>
