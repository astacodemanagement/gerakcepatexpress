<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengeluaran = Pengeluaran::when(!$this->isSuperadmin(), function ($q) {
                                        return $q->where('cabang_id', Auth::user()->cabang_id);
                                    })
                                    ->get();
                                    
        return view('pengeluaran.index', compact('pengeluaran'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pengeluaran.create');
    }

    public function show($id)
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Metode untuk menyimpan data pengeluaran
    public function store(Request $request)
    {
        $request->merge([
            'jumlah_pengeluaran' => str_replace(',', '', $request->jumlah_pengeluaran)
        ]);

        // Validasi request
        $request->validate([
            'tanggal_pengeluaran' => 'required',
            'kode_pengeluaran' => 'required',
            'nama_pengeluaran' => 'required',
            'jumlah_pengeluaran' => 'required|numeric',
            'pic' => 'required',
            'bukti' => 'required|image|mimes:jpeg,png,jpg,gif|max:6000', // Validasi file bukti
        ]);

        DB::beginTransaction();

        try {
            // Simpan data pengeluaran ke database
            $pengeluaran = new Pengeluaran();
            $pengeluaran->tanggal_pengeluaran = $request->tanggal_pengeluaran;
            $pengeluaran->kode_pengeluaran = $request->kode_pengeluaran;
            $pengeluaran->nama_pengeluaran = $request->nama_pengeluaran;
            $pengeluaran->jumlah_pengeluaran = $request->jumlah_pengeluaran;
            $pengeluaran->keterangan = $request->keterangan;
            $pengeluaran->pic = $request->pic;
            $pengeluaran->cabang_id = $this->isSuperadmin() ? $request->cabang_id ?? 0 : Auth::user()->cabang_id;

            // Simpan file bukti ke direktori yang diinginkan (misalnya: uploads/bukti_pengeluaran)
            $bukti = $request->file('bukti');
            $namaFile = time() . '.webp';
            $manager = ImageManager::imagick();

            $uploadPath = public_path('uploads/bukti_pengeluaran/');

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, TRUE);
            }

            $image = $manager->read($bukti);
            $image = $image->toWebp()->save($uploadPath . $namaFile);

            // Simpan nama file bukti ke dalam database
            $pengeluaran->bukti = $namaFile;

            $pengeluaran->save();

            DB::commit();

            return response()->json(['message' => 'Data pengeluaran berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $pengeluaran = Pengeluaran::when(!$this->isSuperadmin(), function ($q) {
            return $q->where('cabang_id', Auth::user()->cabang_id);
        })
            ->where('id', $id)
            ->first(); // Ganti "Pengeluaran" dengan model yang sesuai

        if (!$pengeluaran) {
            return response(['message' => 'Pengeluaran tidak ditemukan'], 404);
        }

        $pengeluaran->nama_cabang = $pengeluaran->cabang?->nama_cabang;
        return response()->json($pengeluaran);
    }

    public function update(Request $request, $id)
    {
        // Ambil data pengeluaran yang akan diperbarui
        $pengeluaran = Pengeluaran::when(!$this->isSuperadmin(), function ($q) {
            return $q->where('cabang_id', Auth::user()->cabang_id);
        })
            ->where('id', $id)
            ->first();

        if (!$pengeluaran) {
            return response(['message' => 'Pengeluaran tidak ditemukan'], 404);
        }

        $request->merge([
            'jumlah_pengeluaran' => str_replace(',', '', $request->jumlah_pengeluaran)
        ]);

        // Validasi request
        $request->validate([
            'tanggal_pengeluaran' => 'required',
            'nama_pengeluaran' => 'required',
            'jumlah_pengeluaran' => 'required|numeric',
            'pic' => 'required',
            'bukti' => 'image|mimes:jpeg,png,jpg,gif|max:6000', // Validasi file bukti
        ]);

        // Update data pengeluaran
        $pengeluaran->fill($request->except('bukti')); // Isi data kecuali bukti
        $pengeluaran->bukti = $pengeluaran->bukti; // Tetap gunakan bukti lama jika tidak ada bukti baru

        DB::beginTransaction();

        try {
            // Cek apakah ada file bukti yang diunggah
            if ($request->hasFile('bukti')) {
                // Hapus bukti lama jika ada
                if ($pengeluaran->bukti) {
                    // Hapus bukti dari penyimpanan (misalnya folder uploads)
                    $buktiPath = public_path('uploads/bukti_pengeluaran/' . $pengeluaran->bukti);
                    if (file_exists($buktiPath)) {
                        unlink($buktiPath);
                    }
                }

                // Simpan bukti baru
                $buktiFile = $request->file('bukti');
                $namaFile = time() . '.webp';
                $manager = ImageManager::imagick();

                $uploadPath = public_path('uploads/bukti_pengeluaran/');

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, TRUE);
                }

                $image = $manager->read($buktiFile);
                $image = $image->toWebp()->save($uploadPath . $namaFile);

                // Update atribut bukti pada pengeluaran
                $pengeluaran->bukti = $namaFile;
            }

            // Update data pengeluaran berdasarkan request
            $pengeluaran->tanggal_pengeluaran = $request->tanggal_pengeluaran;
            $pengeluaran->kode_pengeluaran = $request->kode_pengeluaran;
            $pengeluaran->nama_pengeluaran = $request->nama_pengeluaran;
            $pengeluaran->jumlah_pengeluaran = $request->jumlah_pengeluaran;
            $pengeluaran->keterangan = $request->keterangan;
            $pengeluaran->pic = $request->pic;

            // Simpan perubahan
            $pengeluaran->save();

            DB::commit();

            return response()->json(['message' => 'Data pengeluaran berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::when(!$this->isSuperadmin(), function ($q) {
            return $q->where('cabang_id', Auth::user()->cabang_id);
        })
            ->where('id', $id)
            ->first();

        if (!$pengeluaran) {
            return response()->json(['message' => 'Data pengeluaran tidak ditemukan'], 404);
        }

        $pengeluaran->delete();

        return response()->json(['message' => 'Data pengeluaran berhasil dihapus']);
    }

    public function getLatestCodePengeluaran()
    {
        $lastPengeluaran = Pengeluaran::latest('kode_pengeluaran')->first(); // Ambil data terakhir berdasarkan kode_pengeluaran

        if ($lastPengeluaran) {
            $lastCode = $lastPengeluaran->kode_pengeluaran;
            // Ambil bagian numerik dari kode terakhir dan tambahkan 1
            $lastNumber = (int)substr($lastCode, 3) + 1;
            $nextCode = substr($lastCode, 0, 3) . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);
            return response()->json(['latestCode' => $nextCode]);
        }

        // Jika tidak ada data sebelumnya, kembalikan kode awal sebagai default
        return response()->json(['latestCode' => 'EXP0001']);
    }
}