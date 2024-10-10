<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Invoice;
use App\Models\Konsumen;
use App\Models\Kota;
use App\Models\Profil;
use App\Models\Transaksi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;


class TransaksiController extends Controller
{

    public function create() {}

    public function show($id)
    {
        //
    }

    // ALL KONFIGURASI


    // ================================= Fungsi Booking ================================
    public function index_booking()
    {
        $booking = Transaksi::join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
            ->select('transaksi.*', 'cabang.nama_cabang')
            ->orderBy('id', 'desc');

        if (!$this->isSuperadmin()) {
            $booking->where('cabang_id', Auth::user()->cabang_id);
        }

        // Tambahkan filter berdasarkan tanggal hari ini
        $booking->whereDate('tanggal_booking', today());

        $booking = $booking->get();
        return view('booking.index', compact('booking'));
    }

    public function filterByDate(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $booking = Transaksi::join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
            ->select('transaksi.*', 'cabang.nama_cabang')
            ->orderBy('id', 'desc')
            ->whereBetween('tanggal_booking', [$tanggalAwal, $tanggalAkhir]);

        if (!$this->isSuperadmin()) {
            $booking->where('cabang_id', Auth::user()->cabang_id);
        }

        $booking = $booking->get();

        foreach ($booking as $item) {
            $item->tanggal_booking = Carbon::parse($item->tanggal_booking)->format('d-m-Y');
        }

        return response()->json($booking);
    }

    public function filterByDatePenerimaan(Request $request)
    {
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        $booking = Transaksi::join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
            ->select('transaksi.*', 'cabang.nama_cabang')
            ->orderBy('id', 'desc')
            ->whereBetween('tanggal_terima', [$tanggalAwal, $tanggalAkhir]);

        if (!$this->isSuperadmin()) {
            $booking->where('cabang_id', Auth::user()->cabang_id);
        }

        foreach ($booking as $item) {
            $item->tanggal_booking = Carbon::parse($item->tanggal_booking)->format('d-m-Y');
        }

        $booking = $booking->get();
        return response()->json($booking);
    }

    public function store_booking(Request $request)
    {
        // Validasi request

        $validator = Validator::make(
            $request->all(),
            [
                // 'tanggal_booking' => 'required',
                'kode_resi' => [
                    'required',
                    'unique:transaksi,kode_resi', // Memastikan kode_resi unik pada tabel transaksi
                ],
                'nama_barang' => 'required',
                'koli' => 'required',
                'berat' => 'required',
                'cabang_id' => $this->isSuperadmin() ? 'required' : 'nullable'
            ],
            [
                'kode_resi.unique' => 'Kode resi sudah ada dalam database.',
            ]
        );

        if ($this->isSuperadmin()) {
            $validator = Validator::make(
                $request->all(),
                [
                    'cabang_id' => 'required'
                ]
            );
        }

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Simpan data booking ke database
        $booking = new Transaksi();
        $booking->tanggal_booking = Carbon::now()->toDateString();
        $booking->cabang_id = $this->isSuperadmin() ? $request->cabang_id : Auth::user()->cabang_id;
        $booking->kode_resi = $request->kode_resi;
        $booking->nama_barang = $request->nama_barang;
        $booking->koli = $request->koli;
        $booking->berat = $request->berat;
        $booking->keterangan = $request->keterangan;

        $booking->save();

        return response()->json(['message' => 'Data booking berhasil disimpan']);
    }


    public function edit_booking($id)
    {
        $booking = Transaksi::when(!$this->isSuperadmin(), function ($q) {
            return $q->where('cabang_id', Auth::user()->cabang_id);
        })
            ->where('id', $id)
            ->first(); // Ganti "Transaksi" dengan model yang sesuai

        if (!$booking) {
            return response(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
        }

        if ($this->isSuperadmin()) {
            $booking->nama_cabang = $booking->cabang?->nama_cabang;
        }

        return response()->json($booking);
    }

    public function update_booking(Request $request, $id)
    {
        // Ambil data booking yang akan diperbarui
        $booking = Transaksi::when(!$this->isSuperadmin(), function ($q) {
            return $q->where('cabang_id', Auth::user()->cabang_id);
        })
            ->where('id', $id)
            ->first(); // Ganti "Transaksi" dengan model yang sesuai

        if (!$booking) {
            return response(['success' => false, 'message' => 'Booking tidak ditemukan'], 404);
        }

        // Validasi request
        $request->validate([
            // 'tanggal_booking' => 'required',
            'kode_resi' => 'required',
            'nama_barang' => 'required',
            'koli' => 'required',
            'berat' => 'required',
        ]);

        // Update data resi berdasarkan request
        // $booking->tanggal_booking = $request->tanggal_booking;
        // $booking->cabang_id = $request->cabang_id;
        $booking->kode_resi = $request->kode_resi;
        $booking->nama_barang = $request->nama_barang;
        $booking->koli = $request->koli;
        $booking->berat = $request->berat;
        $booking->keterangan = $request->keterangan;

        // Simpan perubahan
        $booking->save();

        return response()->json(['message' => 'Data booking berhasil diperbarui']);
    }


    public function destroy_booking($id)
    {
        $booking = Transaksi::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Data booking tidak ditemukan'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Data booking berhasil dihapus']);
    }

    // Fungsi untuk mendapatkan data terakhir kode_resi
    public function getLatestCode(Request $request)
    {
        $cabangId = $this->isSuperadmin() ? $request->cabang_id : Auth::user()->cabang_id;
        $lastTransaksi = Transaksi::select(DB::raw('RIGHT(kode_resi, 6) kode_resi'))
            ->where('cabang_id', $cabangId)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastTransaksi) {
            $lastCode = $lastTransaksi->kode_resi;
            $lastNumber = (int)$lastCode + 1;
            $nextCode = str_pad($lastNumber, 6, '0', STR_PAD_LEFT);

            return response()->json(['latestCode' => $nextCode]);
        }

        return response()->json(['latestCode' => '000001']);
    }




    public function getKodeCabangKota($cabang_id, $user_id)
    {
        $user = User::find($user_id);
        $cabang = Cabang::find($cabang_id);

        if ($user && $cabang) {
            $kota = Kota::find($cabang->id_kota);

            return response()->json([
                'kode_kota' => $kota->kode_kota,
                'kode_cabang' => $cabang->kode_cabang
            ]);
        }

        return response()->json([
            'error' => 'Data not found'
        ], 404);
    }


    // ================================= Fungsi Booking ================================

    // ================================= Fungsi Pembatalan ================================
    public function index_pembatalan()
    {
        $pengiriman = Transaksi::join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
            ->whereNotNull('tanggal_kirim')
            ->select('transaksi.*', 'cabang.nama_cabang')
            ->orderBy('id', 'desc');

        if (!$this->isSuperadmin()) {
            $pengiriman->where('cabang_id', Auth::user()->cabang_id);
        }

        $pengiriman = $pengiriman->get();

        return view('pembatalan.index', compact('pengiriman'));
    }
    // ================================= Fungsi Pembatalan ================================

    // ================================= Fungsi Pengiriman ================================
    public function index_pengiriman()
    {
        $pengiriman = Transaksi::join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
            ->whereNotNull('tanggal_kirim')
            ->select('transaksi.*', 'cabang.nama_cabang')
            ->orderBy('id', 'desc');

        if (!$this->isSuperadmin()) {
            $pengiriman->where('cabang_id', Auth::user()->cabang_id);
        }

        $pengiriman = $pengiriman->get();

        return view('pengiriman.index', compact('pengiriman'));
    }



    public function ubah_pengiriman(Request $request)
    {
        // Mengatur tanggal mulai dan tanggal akhir default ke hari ini
        $filterStartDate = $request->start_date ?? date('Y-m-d');
        $filterEndDate = $request->end_date ?? date('Y-m-d');

        $pengiriman = Transaksi::with('cabang') // Memuat hubungan cabang
            ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereDate('tanggal_kirim', '>=', $filterStartDate)
                    ->whereDate('tanggal_kirim', '<=', $filterEndDate);
            })->get();

        return view('pengiriman.ubah', compact('pengiriman', 'filterStartDate', 'filterEndDate'));
    }


    public function edit($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($transaksi);
    }
    public function update(Request $request, $id)
    {
        $request->merge([
            'total_bayar' => str_replace(',', '', $request->total_bayar),
        ]);

        $request->validate([
            'koli' => 'required|integer',
            'berat' => 'required|numeric',
            'harga_kirim' => 'required|numeric',
            'total_bayar' => 'required|numeric',
        ]);

        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $transaksi->update($request->all());

        return response()->json(['message' => 'Data berhasil diperbarui']);
    }






    public function edit_pengiriman($id)
    {
        $pengiriman = Transaksi::findOrFail($id);
        return response()->json($pengiriman);
    }



    public function data_pengiriman(Request $request)
    {
        $filterStartDate = $request->start_date ?? now()->format('Y-m-d');
        $filterEndDate = $request->end_date ?? now()->format('Y-m-d');
        $filterCabang = $request->cabang;
        $cabang = Cabang::where('id', $filterCabang)->first();

        $pengiriman = Transaksi::join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
            ->select('transaksi.*', 'cabang.nama_cabang')
            ->whereNotNull('tanggal_kirim')
            ->whereDate('tanggal_kirim', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
            ->whereDate('tanggal_kirim', '<=', $filterEndDate) // Menambahkan kondisi untuk filter tanggal akhir
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id', Auth::user()->cabang_id);
            })
            ->when($this->isSuperadmin() && $filterCabang, function ($q) use ($filterCabang) {
                return $q->where('cabang_id', $filterCabang);
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('pengiriman.data', compact('pengiriman', 'cabang', 'filterStartDate', 'filterEndDate'));
    }



    public function data_belum_ambil(Request $request)
    {
        // Menggunakan waktu server yang nyata
        $currentServerDate = Carbon::now()->format('Y-m-d');

        // Mengambil tanggal filter dari request atau menggunakan waktu server jika tidak ada
        $filterStartDate = $request->start_date ?? $currentServerDate;
        $filterEndDate = $request->end_date ?? $currentServerDate;
        $filterCabang = $request->cabang;
        $cabang = Cabang::where('id', $filterCabang)->first();

        // Ambil tanggal terima otomatis terkecil dari database
        $tanggalTerimaOtomatis = Transaksi::min('tanggal_terima_otomatis');

        // Jika waktu server sekarang kurang dari tanggal_terima_otomatis, jangan tampilkan data
        $pengiriman = [];
        if ($currentServerDate >= $tanggalTerimaOtomatis) {
            // Jika sudah sesuai, baru jalankan query untuk mengambil data
            $pengiriman = Transaksi::join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
                ->select('transaksi.*', 'cabang.nama_cabang')
                ->whereNotNull('tanggal_terima_otomatis') // Hanya data dengan 'tanggal_terima_otomatis' tidak null
                ->whereNull('tanggal_bawa') // Pastikan 'tanggal_ambil' null
                ->whereDate('tanggal_terima_otomatis', '>=', $filterStartDate) // Filter berdasarkan tanggal awal
                ->whereDate('tanggal_terima_otomatis', '<=', $filterEndDate) // Filter berdasarkan tanggal akhir
                ->when(!$this->isSuperadmin(), function ($q) {
                    return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
                })
                ->when($this->isSuperadmin() && $request->cabang, function ($q) use ($request) {
                    return $q->where('cabang_id_tujuan', $request->cabang);
                })
                ->whereNull('status_batal')
                ->orderBy('id', 'desc')
                ->get();
        }

        // Kirimkan variabel pengiriman, filter date ke view
        return view('pengiriman.data_belum_ambil', compact('pengiriman', 'filterStartDate', 'filterEndDate', 'cabang'));
    }



    public function getResiData(Request $request)
    {
        $term = $request->input('term'); // Pastikan istilah pencarian ada di parameter 'term'
        $data = Transaksi::where('kode_resi', 'LIKE', '%' . $term . '%')
            ->where(function ($query) {
                $query->whereNull('tanggal_kirim')
                    ->orWhere('tanggal_kirim', '');
            })
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id', Auth::user()->cabang_id);
            })
            ->get();

        return response()->json($data);
    }

    public function getResiDataBatal(Request $request)
    {
        $term = $request->input('term');
        $data = Transaksi::where('kode_resi', 'LIKE', '%' . $term . '%')
            ->whereNotNull('tanggal_kirim') // Hanya entri dengan tanggal_kirim null
            ->whereNull('tanggal_terima') // Hanya entri dengan tanggal_kirim null
            ->whereNull('tanggal_ambil_pembatalan'); // Menambahkan kondisi whereNull untuk tanggal_aju_batal

        if (!$this->isSuperadmin()) {
            $data->where('cabang_id', Auth::user()->cabang_id);
        }

        $data = $data->get();
        return response()->json($data);
    }



    public function getDetailResiData(Request $request)
    {
        $term = $request->term;
        $data = Transaksi::where('id', $term)
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id', Auth::user()->cabang_id);
            })
            ->first();

        return response()->json($data);
    }

    // public function getKonsumenData(Request $request)
    // {
    //     $term = $request->term;
    //     $cabang_id = Auth::user()->cabang_id; // Ambil cabang_id dari user yang sedang login

    //     $data = Konsumen::where(function ($query) use ($term) {
    //             $query->where('nama_konsumen', 'LIKE', '%' . $term . '%')
    //                 ->orWhere('status_cad', 'CAD'); // Menambahkan kondisi status_cad
    //         })
    //         ->when(!$this->isSuperadmin(), function ($query) use ($cabang_id) {
    //             if (!$this->isAllBranch()) {
    //                 return $query->where('cabang_id', $cabang_id);
    //             }
    //         })
    //         ->get();

    //     return response()->json($data);
    // }


    public function getKonsumenData(Request $request)
    {
        $term = $request->term;
        $cabang_id = Auth::user()->cabang_id; // Ambil cabang_id dari user yang sedang login

        $data = Konsumen::where(function ($query) use ($term) {
            if (!empty($term)) {
                $query->where('nama_konsumen', 'LIKE', '%' . $term . '%')
                    ->orWhere('no_telp', 'LIKE', '%' . $term . '%'); // Menambahkan kondisi pencarian berdasarkan nomor telepon
            }
        })
            ->when(!$this->isSuperadmin(), function ($query) use ($cabang_id) {
                if (!$this->isAllBranch()) {
                    $query->where('cabang_id', $cabang_id);
                }
            })
            ->where('status_cad', 'Non CAD') // Filter hanya konsumen dengan status_cad = Non CAD
            ->get();

        // Jika ada istilah pencarian dan tidak ditemukan konsumen Non CAD yang sesuai,
        // tambahkan konsumen dengan status_cad = CAD juga
        if (!empty($term) && $data->isEmpty()) {
            $cadData = Konsumen::where('status_cad', 'CAD')
                ->where(function ($query) use ($term) {
                    $query->where('nama_konsumen', 'LIKE', '%' . $term . '%')
                        ->orWhere('no_telp', 'LIKE', '%' . $term . '%'); // Menambahkan kondisi pencarian berdasarkan nomor telepon
                })
                ->get();
            $data = $cadData->merge($data);
        }

        return response()->json($data);
    }


    // public function getKonsumenData(Request $request)
    // {
    //     $term = $request->term;
    //     $cabang_id = Auth::user()->cabang_id; // Ambil cabang_id dari user yang sedang login

    //     $data = Konsumen::where(function ($query) use ($term) {
    //         if (!empty($term)) {
    //             $query->where('nama_konsumen', 'LIKE', '%' . $term . '%');
    //         }
    //     })
    //         ->when(!$this->isSuperadmin(), function ($query) use ($cabang_id) {
    //             if (!$this->isAllBranch()) {
    //                 $query->where('cabang_id', $cabang_id);
    //             }
    //         })
    //         ->where('status_cad', 'Non CAD') // Filter hanya konsumen dengan status_cad = Non CAD
    //         ->get();

    //     // Jika tidak ditemukan hasil untuk istilah pencarian, coba cari konsumen dengan status CAD
    //     if ($data->isEmpty()) {
    //         $data = Konsumen::where('status_cad', 'CAD')
    //             ->where('nama_konsumen', 'LIKE', '%' . $term . '%')
    //             ->get();
    //     }

    //     return response()->json($data);
    // }


    public function getKonsumenPenerimaData(Request $request)
    {
        $term = $request->term;
        $cabang_id = Auth::user()->cabang_id; // Ambil cabang_id dari user yang sedang login

        $data = Konsumen::where(function ($query) use ($term) {
            if (!empty($term)) {
                $query->where('nama_konsumen', 'LIKE', '%' . $term . '%')
                    ->orWhere('no_telp', 'LIKE', '%' . $term . '%'); // Menambahkan kondisi pencarian berdasarkan nomor telepon
            }
        })
            ->when(!$this->isSuperadmin(), function ($query) use ($cabang_id) {
                if (!$this->isAllBranch()) {
                    $query->where('cabang_id', $cabang_id);
                }
            })
            ->where('status_cad', 'Non CAD') // Filter hanya konsumen dengan status_cad = Non CAD
            ->get();

        // Jika ada istilah pencarian dan tidak ditemukan konsumen Non CAD yang sesuai,
        // tambahkan konsumen dengan status_cad = CAD juga
        if (!empty($term) && $data->isEmpty()) {
            $cadData = Konsumen::where('status_cad', 'CAD')
                ->where(function ($query) use ($term) {
                    $query->where('nama_konsumen', 'LIKE', '%' . $term . '%')
                        ->orWhere('no_telp', 'LIKE', '%' . $term . '%'); // Menambahkan kondisi pencarian berdasarkan nomor telepon
                })
                ->get();
            $data = $cadData->merge($data);
        }

        return response()->json($data);
    }




    // public function getBillTo(Request $request)
    // {
    //     $term = $request->term;
    //     $cabang_id = Auth::user()->cabang_id; // Ambil cabang_id dari user yang sedang login

    //     $data = Konsumen::where('nama_konsumen', 'LIKE', '%' . $term . '%')
    //         ->when(!$this->isSuperadmin(), function ($query) use ($cabang_id) {
    //             return $query->where('cabang_id', $cabang_id);
    //         })
    //         ->get();

    //     return response()->json($data);
    // }
    public function getBillTo(Request $request)
    {
        $term = $request->term;
        $selectedKonsumen = $request->selectedKonsumen; // Terima objek selectedKonsumen dari permintaan

        // Lakukan query untuk mendapatkan data bill_to berdasarkan nama konsumen dan konsumen_penerima yang dipilih
        $data = Konsumen::where(function ($query) use ($term, $selectedKonsumen) {
            $query->where('nama_konsumen', 'LIKE', '%' . $term . '%')
                ->orWhere('no_telp', 'LIKE', '%' . $term . '%'); // Menambahkan kondisi pencarian berdasarkan nomor telepon
        })
            ->where('status_cad', 'CAD')
            ->whereIn('id', [$selectedKonsumen['konsumen'], $selectedKonsumen['konsumenPenerima']]) // Filter berdasarkan kedua konsumen yang dipilih
            ->get();

        return response()->json($data);
    }




    public function getCabangData(Request $request)
    {
        $term = $request->term;

        // Mendapatkan cabang yang sedang login
        $userCabangId = Auth::user()->cabang_id;

        // Menampilkan data cabang kecuali yang sedang login
        $data = Cabang::where('nama_cabang', 'LIKE', '%' . $term . '%')
            ->where('id', '!=', $userCabangId) // Mengecualikan cabang yang sedang login
            ->get();

        return response()->json($data);
    }


    // Fungsi untuk mendapatkan nilai biaya_admin dari tabel Profil
    public function getBiayaAdmin()
    {
        // Ambil nilai biaya_admin dari tabel Profil (misalnya, dengan mengambil data pertama)
        $profil = Profil::first();

        // Jika data Profil ditemukan, kembalikan nilai biaya_admin
        if ($profil) {
            return response()->json(['biaya_admin' => $profil->biaya_admin]);
        }

        // Jika tidak ada data Profil atau nilai biaya_admin kosong, kembalikan nilai default
        return response()->json(['biaya_admin' => 0]);
    }

    // Fungsi untuk mendapatkan nilai biaya_pembatalan dari tabel Profil
    public function getBiayaPembatalan()
    {
        // Ambil nilai biaya_pembatalan dari tabel Profil (misalnya, dengan mengambil data pertama)
        $profil = Profil::first();

        // Jika data Profil ditemukan, kembalikan nilai biaya_pembatalan
        if ($profil) {
            return response()->json(['biaya_pembatalan' => $profil->biaya_pembatalan]);
        }

        // Jika tidak ada data Profil atau nilai biaya_pembatalan kosong, kembalikan nilai default
        return response()->json(['biaya_pembatalan' => 0]);
    }





    public function update_pengiriman(Request $request, $kode_resi)
    {
        // Ambil data pengiriman yang akan diperbarui
        $pengiriman = Transaksi::when(!$this->isSuperadmin(), function ($q) {
            return $q->where('cabang_id', Auth::user()->cabang_id);
        })
            ->where('id', $kode_resi)
            ->first();

        if (!$pengiriman) {
            return response(['message' => 'Pengiriman tidak ditemukan'], 404);
        }

        $request->merge([
            'jumlah_bayar' => str_replace(',', '', $request->jumlah_bayar),
            'harga_kirim' => str_replace(',', '', $request->harga_kirim),
            'sub_charge' => str_replace(',', '', $request->sub_charge),
            'biaya_admin' => str_replace(',', '', $request->biaya_admin),
            'total_bayar' => str_replace(',', '', $request->total_bayar),
        ]);

        // Validasi request
        $request->validate([
            'jenis_pembayaran' => 'required',
            // 'keterangan_kasir' => 'required',
            'metode_pembayaran' => 'required_if:jenis_pembayaran,CASH',
            'jumlah_bayar' => 'required_if:jenis_pembayaran,CASH|numeric',
            'harga_kirim' => 'required|numeric',
            'sub_charge' => 'required|numeric',
            'biaya_admin' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'bukti_bayar' => 'image|mimes:jpeg,png,jpg,gif|max:6000|required_if:metode_pembayaran,Transfer', // Validasi file gambar
        ]);

        // Update data pengiriman
        $pengiriman->fill($request->except(['bukti_bayar', 'kode_resi'])); // Isi data kecuali bukti_bayar

        $pengiriman->bukti_bayar = $pengiriman->bukti_bayar; // Tetap gunakan bukti_bayar lama jika tidak ada bukti_bayar baru

        DB::beginTransaction();

        try {
            // Cek apakah ada file bukti_bayar yang diunggah
            if ($request->hasFile('bukti_bayar')) {
                // Hapus bukti_bayar lama jika ada
                if ($pengiriman->bukti_bayar) {
                    // Hapus bukti_bayar dari penyimpanan (misalnya folder uploads)
                    $bukti_bayarPath = public_path('uploads/bukti_bayar_pengiriman/' . $pengiriman->bukti_bayar);
                    if (file_exists($bukti_bayarPath)) {
                        unlink($bukti_bayarPath);
                    }
                }

                // Simpan bukti_bayar baru
                $bukti_bayarFile = $request->file('bukti_bayar');
                $namaFile = time() . '.webp';
                $manager = ImageManager::imagick();

                $uploadPath = public_path('uploads/bukti_bayar_pengiriman/');

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, TRUE);
                }

                $image = $manager->read($bukti_bayarFile);
                $image = $image->toWebp()->save($uploadPath . $namaFile);

                // Update atribut bukti_bayar pada pengiriman
                $pengiriman->bukti_bayar = $namaFile;
            }

            // Logika untuk status_bayar
            if ($request->filled('jumlah_bayar')) {
                $pengiriman->status_bayar = 'Sudah Lunas';
            } else {
                $pengiriman->status_bayar = 'Belum Lunas';
            }

            // Default untuk status_bawa
            $pengiriman->status_bawa = 'Belum Dibawa';

            // Set nilai konsumen_id dan nama_konsumen dari request ke model Transaksi
            $konsumen = Konsumen::select('nama_konsumen')->find($request->konsumen);
            $konsumenPenerima = Konsumen::select('nama_konsumen')->find($request->konsumen_penerima);
            $konsumenBillTo = Konsumen::select('nama_konsumen')->find($request->bill_to);

            $pengiriman->tanggal_kirim = Carbon::now()->toDateString();
            $pengiriman->tanggal_terima_otomatis = Carbon::now()->addDay()->toDateString();
            $pengiriman->konsumen_id = $request->konsumen;
            $pengiriman->nama_konsumen = $konsumen?->nama_konsumen;
            $pengiriman->konsumen_penerima_id = $request->konsumen_penerima;
            $pengiriman->nama_konsumen_penerima = $konsumenPenerima?->nama_konsumen;
            $pengiriman->bill_to = $request->bill_to;
            $pengiriman->nama_bill_to = $konsumenBillTo?->nama_konsumen;
            $pengiriman->total_bayar = $request->total_bayar;
            $pengiriman->cabang_id_asal = $request->cabang_id_asal;
            $pengiriman->cabang_id_tujuan = $request->cabang_id_tujuan;
            $pengiriman->keterangan_kasir = $request->keterangan_kasir;

            // Simpan perubahan
            $pengiriman->save();

            DB::commit();

            return response()->json(['message' => 'Data pengiriman berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    public function pembatalan_pengiriman(Request $request, $kode_resi)
    {
        // Ambil data penerimaan yang akan diperbarui
        $pengiriman = Transaksi::where('kode_resi', $kode_resi)->firstOrFail();

        // Validasi request
        $request->validate([
            // 'nama_konsumen' => 'required',
            // 'bukti_pembatalan' => 'image|mimes:jpeg,png,jpg,gif|max:6000', // Validasi file gambar
        ]);

        // Update data pengiriman
        $pengiriman->fill($request->except(['bukti_pembatalan', 'kode_resi'])); // Isi data kecuali bukti_pembatalan

        $pengiriman->bukti_pembatalan = $pengiriman->bukti_pembatalan; // Tetap gunakan bukti_pembatalan lama jika tidak ada bukti_pembatalan baru

        DB::beginTransaction();

        try {
            // Cek apakah ada file bukti_pembatalan yang diunggah
            if ($request->hasFile('bukti_pembatalan')) {
                $request->validate([
                    // 'nama_konsumen' => 'required',
                    'bukti_pembatalan' => 'image|mimes:jpeg,png,jpg,gif|max:6000', // Validasi file gambar
                ]);
                // Hapus bukti_pembatalan lama jika ada
                if ($pengiriman->bukti_pembatalan) {
                    // Hapus bukti_pembatalan dari penyimpanan (misalnya folder uploads)
                    $bukti_pembatalanPath = public_path('uploads/bukti_bayar_pengiriman/' . $pengiriman->bukti_pembatalan);
                    if (file_exists($bukti_pembatalanPath)) {
                        unlink($bukti_pembatalanPath);
                    }
                }

                // Simpan bukti_pembatalan baru
                $bukti_pembatalanFile = $request->file('bukti_pembatalan');
                // $namaFile = time() . '.' . $bukti_pembatalanFile->getClientOriginalExtension();
                // $bukti_pembatalanFile->move(public_path('uploads/bukti_bayar_pengiriman'), $namaFile);

                // $bukti_bayarFile = $request->file('bukti_bayar');
                $namaFile = time() . '.webp';
                $manager = ImageManager::imagick();

                $uploadPath = public_path('uploads/bukti_bayar_pengiriman/');

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, TRUE);
                }

                $image = $manager->read($bukti_pembatalanFile);
                $image = $image->toWebp()->save($uploadPath . $namaFile);

                // Update atribut bukti_pembatalan pada pengiriman
                $pengiriman->bukti_pembatalan = $namaFile;
            }

            // Logika untuk status_pembatalan
            // if ($request->filled('jumlah_pembatalan')) {
            //     $pengiriman->status_pembatalan = 'Sudah Lunas';
            // } else {
            //     $pengiriman->status_pembatalan = 'Belum Lunas';
            // }



            // Set nilai konsumen_id dan nama_konsumen dari request ke model Transaksi
            $pengiriman->total_bayar = str_replace(',', '', $request->total_bayar);
            $pengiriman->biaya_pembatalan = str_replace(',', '', $request->biaya_pembatalan);
            $pengiriman->keterangan_batal = $request->keterangan_batal;
            $pengiriman->tanggal_aju_pembatalan = Carbon::now()->toDateString();
            $pengiriman->status_batal = 'Pengajuan Batal';

            // Simpan perubahan
            $pengiriman->save();

            DB::commit();

            return response()->json(['message' => 'Data pembatalan berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }



    // ================================= Fungsi Pengiriman ================================




    // ================================= Fungsi Penerimaan ================================

    public function index_penerimaan()
    {
        $penerimaan = Transaksi::with(['cabangTujuan', 'cabangAsal'])
            ->whereNotNull('tanggal_kirim')
            ->whereNull('tanggal_bawa')
            ->whereNull('status_batal')
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            ->orderBy('id', 'desc') // Mengurutkan berdasarkan kolom 'id' secara descending
            ->get();

        return view('terima.index', compact('penerimaan'));
    }



    public function data_penerimaan(Request $request)
    {
        // Menggunakan waktu server yang nyata (mengambil tanggal sekarang)
        $currentServerDate = Carbon::now()->format('Y-m-d');

        // Mengambil tanggal filter dari request atau menggunakan waktu server hari ini
        $filterStartDate = $request->start_date ?? Carbon::today()->format('Y-m-d');
        $filterEndDate = $request->end_date ?? Carbon::today()->format('Y-m-d');
        $filterCabang = $request->cabang;

        // Mengambil cabang yang dipilih
        $cabang = Cabang::where('id', $filterCabang)->first();

        // Ambil tanggal kirim terkecil dari database
        $tanggalKirimTerkecil = Transaksi::min('tanggal_terima_otomatis');

        // Jika waktu server sekarang kurang dari tanggal_terima_otomatis terkecil, jangan tampilkan data
        $penerimaan = [];
        if ($currentServerDate >= $tanggalKirimTerkecil) {
            // Jika sudah sesuai, baru jalankan query untuk mengambil data
            $penerimaan = Transaksi::with(['cabangTujuan', 'cabangAsal'])
                ->whereNotNull('tanggal_terima_otomatis')
                ->whereNull('status_batal')
                ->whereDate('tanggal_terima_otomatis', '>=', $filterStartDate) // Filter tanggal mulai
                ->whereDate('tanggal_terima_otomatis', '<=', $filterEndDate) // Filter tanggal akhir
                // Tambahkan validasi bahwa data tidak boleh muncul sebelum tanggal sekarang
                ->whereDate('tanggal_terima_otomatis', '<=', $currentServerDate)
                ->when(!$this->isSuperadmin(), function ($q) {
                    return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
                })
                ->when($this->isSuperadmin() && $filterCabang, function ($q) use ($filterCabang) {
                    return $q->where('cabang_id_tujuan', $filterCabang);
                })
                ->orderBy('id', 'desc')
                ->get();
        }

        return view('terima.data', compact('penerimaan', 'cabang', 'filterStartDate', 'filterEndDate'));
    }


    public function edit_penerimaan($id)
    {
        $penerimaan = Transaksi::with(['cabangAsal', 'cabangTujuan'])
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            ->where('id', $id)
            ->first();

        if (!$penerimaan) {
            return response(['success' => false, 'message' => 'Penerimaan tidak ditemukan'], 404);
        }

        return response()->json($penerimaan);
    }

    public function update_penerimaan(Request $request, $id)
    {
        // Ambil data penerimaan yang akan diperbarui
        $penerimaan = Transaksi::with(['cabangAsal', 'cabangTujuan'])
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            ->where('id', $id)
            ->first();

        if (!$penerimaan) {
            return response(['success' => false, 'message' => 'Penerimaan tidak ditemukan'], 404);
        }

        $request->merge([
            'jumlah_bayar' => str_replace(',', '', $request->jumlah_bayar)
        ]);

        // Validasi request
        $request->validate([
            'jumlah_bayar' => 'required|numeric'
            // 'bukti_bayar' => 'image|mimes:jpeg,png,jpg,gif|max:6000', // Validasi file gambar
        ]);

        if ($request->jenis_pembayaran == 'COD') {
            $request->validate([
                'bukti_bayar' => 'required_if:metode_pembayaran,Transfer', // Validasi file gambar
            ]);

            if ($request->metode_pembayaran == 'Transfer') {
                $request->validate([
                    'bukti_bayar' => 'image|mimes:jpeg,png,jpg,gif|max:6000', // Validasi file gambar
                ]);
            }
        }

        // Update data penerimaan
        $penerimaan->fill($request->except(['bukti_bayar', 'kode_resi', 'harga_kirim', 'sub_charge', 'biaya_kirim'])); // Isi data kecuali bukti_bayar

        $penerimaan->bukti_bayar = $penerimaan->bukti_bayar; // Tetap gunakan bukti_bayar lama jika tidak ada bukti_bayar baru

        DB::beginTransaction();

        try {
            // Cek apakah ada file bukti_bayar yang diunggah
            if ($request->hasFile('bukti_bayar')) {
                $request->validate([
                    // 'nama_konsumen' => 'required',
                    'bukti_bayar' => 'image|mimes:jpeg,png,jpg,gif|max:6000', // Validasi file gambar
                ]);

                // Hapus bukti_bayar lama jika ada
                if ($penerimaan->bukti_bayar) {
                    // Hapus bukti_bayar dari penyimpanan (misalnya folder uploads)
                    $bukti_bayarPath = public_path('uploads/bukti_bayar_pengiriman/' . $penerimaan->bukti_bayar);
                    if (file_exists($bukti_bayarPath)) {
                        unlink($bukti_bayarPath);
                    }
                }

                // Simpan bukti_bayar baru
                $bukti_bayarFile = $request->file('bukti_bayar');
                $namaFile = time() . '.webp';
                $manager = ImageManager::imagick();

                $uploadPath = public_path('uploads/bukti_bayar_pengiriman/');

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, TRUE);
                }

                $image = $manager->read($bukti_bayarFile);
                $image = $image->toWebp()->save($uploadPath . $namaFile);

                // Update atribut bukti_bayar pada penerimaan
                $penerimaan->bukti_bayar = $namaFile;
            }

            // Logika untuk status_bayar
            if ($penerimaan->jenis_pembayaran === 'CAD') {
                $penerimaan->status_bayar = 'Belum Lunas';
            } else {
                $penerimaan->status_bayar = 'Sudah Lunas';
            }


            // Set nilai konsumen_id dan nama_konsumen dari request ke model Transaksi
            $penerimaan->tanggal_terima = $request->tanggal_terima;
            $penerimaan->status_bawa = $request->status_bawa;
            $penerimaan->jumlah_bayar = $request->jumlah_bayar;
            $penerimaan->metode_pembayaran = $request->metode_pembayaran;

            // Simpan perubahan
            $penerimaan->save();

            DB::commit();

            return response()->json(['message' => 'Data penerimaan berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function getResiDataPenerimaan(Request $request)
    {
        $term = $request->input('term');

        $data = Transaksi::with(['cabangAsal', 'cabangTujuan'])
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            ->where('tanggal_kirim', '<', Carbon::now()->format('Y-m-d'))
            ->where('status_bawa', 'Belum Dibawa')
            ->where(function ($query) use ($term) {
                $query->where('kode_resi', 'LIKE', "%$term%")
                    ->orWhere('nama_konsumen', 'LIKE', "%$term%");
            })
            // ->whereNotIn('status_batal', ['Telah Diambil Pembatalan', 'Verifikasi Disetujui'])
            ->whereNull('status_batal')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json($data);
    }



    public function getDetailResiDataPenerimaan(Request $request)
    {
        $term = $request->term;
        $data = Transaksi::with(['cabangAsal', 'cabangTujuan'])
            ->where('id', $term)
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            ->first();

        if (!$data) {
            return response(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    // ================================= Fungsi Penerimaan ================================




    // ================================= Fungsi Pengambilan ================================

    public function index_pengambilan()
    {
        $pengambilan = Transaksi::with(['cabangTujuan', 'cabangAsal'])
            ->whereNotNull('tanggal_kirim')
            ->whereNull('status_batal') // Menambahkan kondisi status_batal kosong
            ->get();

        return view('pengambilan.index', compact('pengambilan'));
    }



    public function index_barang_turun(Request $request)
    {
        // Menggunakan waktu server yang nyata
        $currentServerDate = Carbon::now()->format('Y-m-d');

        // Mengambil tanggal filter dari request atau menggunakan waktu server jika tidak ada
        $filterStartDate = $request->start_date ?? $currentServerDate;
        $filterEndDate = $request->end_date ?? $currentServerDate;

        // Ambil tanggal terima otomatis terkecil dari database
        $tanggalTerimaOtomatis = Transaksi::min('tanggal_terima_otomatis');

        // Jika waktu server sekarang kurang dari tanggal_terima_otomatis, jangan tampilkan data
        $barang_turun = [];
        if ($tanggalTerimaOtomatis && $currentServerDate >= $tanggalTerimaOtomatis) {
            // Jika sudah sesuai, jalankan query untuk mengambil data
            $barang_turun = Transaksi::select(
                'transaksi.*',
                'cabang_asal.nama_cabang as nama_cabang_asal',
                'cabang_tujuan.nama_cabang as nama_cabang_tujuan',
                'konsumen.no_telp'
            )
                ->leftJoin('cabang as cabang_asal', 'transaksi.cabang_id_asal', '=', 'cabang_asal.id')
                ->leftJoin('cabang as cabang_tujuan', 'transaksi.cabang_id_tujuan', '=', 'cabang_tujuan.id')
                ->leftJoin('konsumen', 'transaksi.nama_konsumen_penerima', '=', 'konsumen.nama_konsumen')
                ->when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate, $currentServerDate) {
                    return $q->whereDate('tanggal_terima_otomatis', '>=', $filterStartDate)
                             ->whereDate('tanggal_terima_otomatis', '<=', $filterEndDate)
                             // Tambahkan validasi bahwa data tidak boleh muncul sebelum tanggal sekarang
                             ->whereDate('tanggal_terima_otomatis', '<=', $currentServerDate);
                })
                ->when(!$this->isSuperadmin(), function ($q) {
                    return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
                })
                // Tambahkan validasi status_batal tidak terisi
                ->whereNull('status_batal')
                ->get();
        }

        // Kirimkan variabel barang_turun, filter date ke view tanpa pesan error
        return view('pengambilan.data', compact('barang_turun', 'filterStartDate', 'filterEndDate'));
    }





    public function getResiDataPengambilan(Request $request)
    {
        $term = $request->input('term');
        $data = Transaksi::where('kode_resi', 'LIKE', '%' . $term . '%')
            ->where(function ($query) {
                $query->whereNull('tanggal_bawa')
                    ->whereNull('status_batal')
                    ->whereNotNull('tanggal_kirim')
                    ->where(function ($query) {
                        $query->whereNull('tanggal_bawa')
                            ->orWhereNull('status_batal');
                    })
                    ->where('status_bawa', 'Siap Dibawa'); // Menambahkan kondisi status_bawa = 'Siap Dibawa'
            })
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            ->get();

        return response()->json($data);
    }

    public function getDetailResiDataPengambilan(Request $request)
    {
        $term = $request->term;
        $data = Transaksi::where('id', $term)
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            ->first();

        if (!$data) {
            return response(['success' => false, 'message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($data);
    }

    public function simpanPengambilan(Request $request, $id)
    {
        // Lakukan pencarian data berdasarkan id
        $pengambilan = Transaksi::where('id', $id)
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_tujuan', Auth::user()->cabang_id);
            })
            ->first();

        if (!$pengambilan) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Validasi request
        $request->validate([
            'gambar_pengambil' => 'image|mimes:jpeg,png,jpg,gif|max:10240', // Validasi file gambar
        ]);

        DB::beginTransaction();

        try {
            // Update data pengambilan
            $pengambilan->tanggal_bawa = Carbon::now()->toDateString();
            $pengambilan->status_bawa = $request->status_bawa;
            $pengambilan->pengambil = $request->pengambil;

            // Simpan gambar jika ada yang diunggah
            if ($request->hasFile('gambar_pengambil')) {
                $image = $request->file('gambar_pengambil');
                $imageName = time() . '.webp';
                // $image->move(public_path('/uploads/bukti_pengambilan'), $imageName);
                $manager = ImageManager::imagick();

                $uploadPath = public_path('uploads/bukti_pengambilan/');

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, TRUE);
                }

                $image = $manager->read($image);
                $image = $image->toWebp()->save($uploadPath . $imageName);
                $pengambilan->gambar_pengambil = $imageName;
            }

            $pengambilan->save();

            DB::commit();

            return response()->json(['success' => 'Data berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }




    // ================================= Fungsi Pengambilan ================================

    // ================================= Fungsi Ambil Pembatalan ================================

    public function index_ambil_pembatalan()
    {
        $pembatalan = Transaksi::with(['cabangTujuan', 'cabangAsal'])
            ->whereNotNull('tanggal_kirim')

            ->get();
        return view('ambil_pembatalan.index', compact('pembatalan'));
    }

    public function getResiDataAmbilPembatalan(Request $request)
    {
        $term = $request->input('term'); // Pastikan istilah pencarian ada di parameter 'term'
        $data = Transaksi::with(['cabangAsal', 'cabangTujuan'])
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id_asal', Auth::user()->cabang_id);
            })
            ->where('status_batal', 'Verifikasi Disetujui')
            ->get();
        return response()->json($data);
    }



    public function getDetailResiDataPembatalan(Request $request)
    {
        $term = $request->term;
        $data = Transaksi::with(['cabangTujuan', 'cabangAsal'])
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('cabang_id', Auth::user()->cabang_id);
            })
            ->where('id', $term)->first();

        // Mengambil biaya_pembatalan dari Profil
        $profil = Profil::first();
        $biaya_pembatalan = ($profil) ? $profil->biaya_pembatalan : 0;

        // Menambahkan biaya_pembatalan ke dalam data yang dikembalikan
        if ($data) {
            $data->biaya_pembatalan = $biaya_pembatalan;
        }

        return response()->json($data);
    }


    public function getDetailResiDataAmbilPembatalan(Request $request)
    {
        $term = $request->term;
        $data = Transaksi::where('id', $term)->first();
        return response()->json($data);
    }


    public function simpanAmbilPembatalan(Request $request, $id)
    {
        $status_batal = $request->status_batal;

        // Lakukan pencarian data berdasarkan id
        $pengambilan = Transaksi::where('id', $id)->first();

        if ($pengambilan) {
            // Update data pengambilan
            $pengambilan->tanggal_ambil_pembatalan = Carbon::now()->toDateString();
            $pengambilan->status_batal = $request->status_batal;
            $pengambilan->save();

            return response()->json(['success' => 'Data berhasil disimpan']);
        } else {
            return response()->json(['error' => 'Data not found'], 404);
        }
    }





    // ================================= Fungsi Pembatalan ================================



    // ================================= Fungsi Verifikasi Pembatalan ================================

    public function index_verifikasi_pembatalan()
    {
        $verifikasi_pembatalan = Transaksi::join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
            ->select('transaksi.*', 'cabang.nama_cabang')
            ->whereNotNull('transaksi.tanggal_aju_pembatalan') // Menambahkan kondisi tidak null pada tanggal_aju_pembatalan
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('transaksi.cabang_id', Auth::user()->cabang_id);
            })
            ->orderByRaw("CASE WHEN transaksi.status_batal = 'Pengajuan Batal' THEN 0 ELSE 1 END, transaksi.tanggal_aju_pembatalan DESC")
            ->get();

        return view('verifikasi_pembatalan.index', compact('verifikasi_pembatalan'));
    }


    public function generateKodePembatalan()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code_length = 6; // Panjang kode yang diinginkan

        do {
            $kode_pembatalan = substr(str_shuffle($characters), 0, $code_length);
            $existing = DB::table('transaksi')->where('kode_pembatalan', $kode_pembatalan)->exists();
        } while ($existing); // Lakukan loop sampai kode_pembatalan unik

        return response()->json(['kode_pembatalan' => $kode_pembatalan]);
    }

    public function edit_verifikasi_pembatalan($id)
    {
        $verifikasi_pembatalan = Transaksi::when(!$this->isSuperadmin(), function ($q) {
            return $q->where('cabang_id', Auth::user()->cabang_id);
        })
            ->where('id', $id)
            ->first(); // Ganti "Transaksi" dengan model yang sesuai

        if (!$verifikasi_pembatalan) {
            return response(['success' => false, 'message' => 'Verifikasi pembatalan tidak ditemukan'], 404);
        }

        return response()->json($verifikasi_pembatalan);
    }

    public function update_verifikasi(Request $request, $id)
    {
        // Ambil data penerimaan yang akan diperbarui
        $verifikasi = Transaksi::when(!$this->isSuperadmin(), function ($q) {
            return $q->where('cabang_id', Auth::user()->cabang_id);
        })
            ->where('id', $id)
            ->first();

        if (!$verifikasi) {
            return response(['success' => false, 'message' => 'Verifikasi pembatalan tidak ditemukan'], 404);
        }

        // Validasi request
        $request->validate([
            // 'nama_konsumen' => 'required',
            // 'bukti_bayar' => 'image|mimes:jpeg,png,jpg,gif|max:6000', // Validasi file gambar
        ]);

        // Logika untuk status_bayar
        // if ($request->filled('jumlah_bayar')) {
        //     $verifikasi->status_bayar = 'Sudah Lunas';
        // } else {
        //     $verifikasi->status_bayar = 'Belum Lunas';
        // }

        // Set nilai konsumen_id dan nama_konsumen dari request ke model Transaksi
        $verifikasi->kode_pembatalan = $request->kode_pembatalan;
        $verifikasi->status_batal = $request->status_batal;
        $verifikasi->alasan_tolak = $request->alasan_tolak;
        $verifikasi->tanggal_verifikasi_pembatalan = Carbon::now()->toDateString();

        // Simpan perubahan
        $verifikasi->save();

        return response()->json(['message' => 'Data verifikasi berhasil diperbarui']);
    }

    // Fungsi untuk mendapatkan data terakhir kode_resi
    public function getLatestCodePembatalan()
    {
        $lastTransaksi = Transaksi::latest('kode_resi')->first(); // Ambil data terakhir berdasarkan kode_resi

        if ($lastTransaksi) {
            $lastCode = $lastTransaksi->kode_resi;
            // Ambil bagian numerik dari kode terakhir dan tambahkan 1
            $lastNumber = (int)substr($lastCode, 3) + 1;
            $nextCode = substr($lastCode, 0, 3) . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);
            return response()->json(['latestCode' => $nextCode]);
        }

        // Jika tidak ada data sebelumnya, kembalikan kode awal sebagai default
        return response()->json(['latestCode' => 'GCE0001']);
    }

    // ================================= Fungsi Booking ================================
    public function getDataTransaksi()
    {
        $transaksiData = Transaksi::selectRaw('SUM(total_bayar) as total, DATE_FORMAT(tanggal_kirim, "%M") as bulan')
            ->where('status_bayar', 'Sudah Lunas')
            ->where('status_bawa', 'Sudah Dibawa')
            ->groupByRaw('MONTH(tanggal_kirim)')
            ->orderByRaw('MONTH(tanggal_kirim)')
            ->get();

        return response()->json($transaksiData);
    }

    public function getDataTransaksi2(Request $request)
    {
        $cabangId = $request->input('cabang_id');
        $filter = $request->input('filter');

        // Menggunakan switch untuk menentukan kolom yang akan dihitung berdasarkan pilihan filter
        switch ($filter) {
            case 'koli':
                $field = 'koli';
                break;
            case 'berat':
                $field = 'berat';
                break;
            case 'total_bayar':
                $field = 'total_bayar';
                break;
                // default:
                //     $field = 'total_bayar'; // Atur default ke total_bayar jika filter tidak cocok
                //     break;
        }

        $transaksiData = Transaksi::selectRaw("SUM($field) as total, DATE_FORMAT(tanggal_kirim, '%d') as tanggal")
            ->where('cabang_id', $cabangId)
            ->where('status_bayar', 'Sudah Lunas')
            ->where('status_bawa', 'Sudah Dibawa')
            ->whereRaw('MONTH(tanggal_kirim) = MONTH(CURRENT_DATE())') // Filter untuk bulan yang sedang berjalan
            ->groupByRaw('DAY(tanggal_kirim)')
            ->orderByRaw('DAY(tanggal_kirim)')
            ->get();

        return response()->json($transaksiData);
    }





    public function detailResi($id, $module = null)
    {
        $resi = Transaksi::when(!$this->isSuperadmin(), function ($q) use ($module) {
            return $q->when($module == null | $module != 'belum-diambil', function ($qm) {
                return $qm->where('cabang_id', Auth::user()->cabang_id);
            })
                ->when($module == 'belum-diambil', function ($qm) {
                    return $qm->where('cabang_id_tujuan', Auth::user()->cabang_id);
                });
        })
            ->where('id', $id)
            ->firstOrFail();

        $profil = Profil::first();

        return view('export.pdf.resi', compact('resi', 'profil'));
    }

    public function replaceComma()
    {
        $transaksi = Transaksi::select('id', 'harga_kirim', 'sub_charge', 'biaya_admin')
            ->whereNotNull('harga_kirim')
            ->whereNotNull('sub_charge')
            ->whereNotNull('biaya_admin')
            ->get();

        foreach ($transaksi as $t) {
            Transaksi::find($t->id)
                ->update([
                    'harga_kirim' => str_replace(',', '', $t->harga_kirim),
                    'sub_charge' => str_replace(',', '', $t->sub_charge),
                    'biaya_admin' => str_replace(',', '', $t->biaya_admin),
                ]);
        }

        return count($transaksi) . ' data updated';
    }
}
