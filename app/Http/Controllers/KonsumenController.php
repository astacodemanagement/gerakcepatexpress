<?php

namespace App\Http\Controllers;

use App\Models\Konsumen;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KonsumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $konsumen = Konsumen::when(!$this->isSuperadmin(), function($q){
                        return $q->where('cabang_id', Auth::user()->cabang_id);
                    })->get();

        return view('konsumen.index',compact('konsumen'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('konsumen.create');
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

   // Metode untuk menyimpan data konsumen
   public function store(Request $request)
   {
       $request->merge(['no_telp' => str_replace(['+', ' '], '', $request->no_telp)]);
   
       $validatorRules = [
        'nama_konsumen' => 'required',
        'status_cad' => 'required',
        'no_telp' => [
            'required',
            'numeric',
            Rule::unique('konsumen')->where(function ($query) use ($request) {
                $query->where('cabang_id', $this->isSuperadmin() ? $request->cabang_id : Auth::user()->cabang_id);
            }),
        ],
        'email' => 'required|email',
        'alamat' => 'required',
    ];
   
       // Jika superadmin, tambahkan aturan validasi untuk cabang_id
       if ($this->isSuperadmin()) {
           $validatorRules['cabang_id'] = 'required';
       }
   
       $validator = Validator::make($request->all(), $validatorRules, [
           'no_telp.unique' => 'Ooops.......!!!',
       ]);
   
       if ($validator->fails()) {
           $errors = $validator->errors();
   
           // Tambahkan informasi nama konsumen jika nomor telepon sudah terdaftar
           if ($errors->has('no_telp')) {
               $existingKonsumen = Konsumen::where('no_telp', $request->no_telp)->first();
   
               if ($existingKonsumen) {
                   $errors->add('no_telp', 'Nomor telepon sudah terdaftar untuk ' . $existingKonsumen->nama_konsumen);
               } else {
                   $errors->add('no_telp', 'Nomor telepon sudah terdaftar.');
               }
           }
   
           return response()->json(['errors' => $errors], 422);
       }
   
       // Simpan data konsumen ke database
       $konsumen = new Konsumen();
       $konsumen->cabang_id = $this->isSuperadmin() ? $request->cabang_id : Auth::user()->cabang_id;
       $konsumen->nama_konsumen = $request->nama_konsumen;
       $konsumen->nama_perusahaan = $request->nama_perusahaan;
       $konsumen->no_telp = $request->no_telp;
       $konsumen->email = $request->email;
       $konsumen->alamat = $request->alamat;
       $konsumen->status_cad = $request->status_cad;
       $konsumen->no_kontrak = $request->no_kontrak;
       $konsumen->jatuh_tempo = $request->jatuh_tempo;
   
       $konsumen->save();
   
       return response()->json(['message' => 'Data konsumen berhasil disimpan']);
   }
   
   

    public function edit($id)
    {
        $konsumen = Konsumen::when(!$this->isSuperadmin(), function ($q) {
                        return $q->where('cabang_id', Auth::user()->cabang_id);
                    })
                    ->where('id', $id)
                    ->first();

        if (!$konsumen) {
            return response(['success' => false, 'message'=> 'Konsumen tidak ditemukan'], 404);
        }

        $konsumen->nama_cabang = $konsumen->cabang?->nama_cabang;
        return response()->json($konsumen);
    }

    public function update(Request $request, $id)
    {
        // Ambil data konsumen yang akan diperbarui
        $konsumen = Konsumen::when(!$this->isSuperadmin(), function ($q) {
                        return $q->where('cabang_id', Auth::user()->cabang_id);
                    })
                    ->where('id', $id)
                    ->first();

        if (!$konsumen) {
            return response(['success' => false, 'message' => 'Konsumen tidak ditemukan'], 404);
        }

        $request->merge(['no_telp' => str_replace(['+', ' '], '', $request->no_telp)]);

        // Validasi request
        $request->validate([
            'nama_konsumen' => 'required',
            'no_telp' => 'required|numeric',
            'email' => 'required|email',
            'alamat' => 'required',
            'status_cad' => 'required',
            'cabang_id' => $this->isSuperadmin() ? 'required' : 'nullable'
        ]);

        // Update data konsumen berdasarkan request
        $konsumen->nama_konsumen = $request->nama_konsumen;
        $konsumen->nama_perusahaan = $request->nama_perusahaan;
        $konsumen->no_telp = $request->no_telp;
        $konsumen->email = $request->email;
        $konsumen->alamat = $request->alamat;
        $konsumen->status_cad = $request->status_cad;
        $konsumen->no_kontrak = $request->no_kontrak;
        $konsumen->jatuh_tempo = $request->jatuh_tempo;
        $konsumen->cabang_id = $this->isSuperadmin() ? $request->cabang_id : Auth::user()->cabang_id;

        // Simpan perubahan
        $konsumen->save();

        return response()->json(['message' => 'Data konsumen berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $konsumen = Konsumen::when(!$this->isSuperadmin(), function ($q) {
                        return $q->where('cabang_id', Auth::user()->cabang_id);
                    })
                    ->where('id', $id)
                    ->first();

        if (!$konsumen) {
            return response()->json(['message' => 'Data konsumen tidak ditemukan'], 404);
        }

        // Check relasi dengan tabel transaksi
        $relasiTransaksi = Transaksi::where('konsumen_id', $id)->exists();
        if ($relasiTransaksi) {
            return response()->json(['message' => 'Data konsumen tidak bisa dihapus karena masih berelasi dengan transaksi'], 422);
        }

        $konsumen->delete();

        return response()->json(['message' => 'Data konsumen berhasil dihapus']);
    }

}