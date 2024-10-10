<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kota = Kota::all();
        return view('kota.index',compact('kota'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kota.create');
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
   // Metode untuk menyimpan data kota
   public function store(Request $request)
   {
       // Validasi request
       $request->validate([
           'nama_kota' => 'required',
           'kode_kota' => 'required',
       ]);
 
       // Simpan data kota ke database
       $kota = new Kota();
       $kota->kode_kota = $request->kode_kota;
       $kota->nama_kota = $request->nama_kota;
       
 
       $kota->save();
 
       return response()->json(['message' => 'Data kota berhasil disimpan']);
   }

    
   public function edit($id)
{
    $kota = Kota::findOrFail($id); // Ganti "Kota" dengan model yang sesuai
    return response()->json($kota);
}

public function update(Request $request, $id)
{
    // Ambil data kota yang akan diperbarui
    $kota = Kota::findOrFail($id);
    
    // Validasi request
    $request->validate([
        'kode_kota' => 'required',
        'nama_kota' => 'required',
    ]);

    // Update data kota berdasarkan request
    $kota->kode_kota = $request->kode_kota;
    $kota->nama_kota = $request->nama_kota;


   

    // Simpan perubahan
    $kota->save();

    return response()->json(['message' => 'Data kota berhasil diperbarui']);
}

public function destroy($id)
{
    $kota = Kota::find($id);

    if (!$kota) {
        return response()->json(['message' => 'Data kota tidak ditemukan'], 404);
    }

    $kota->delete();

    return response()->json(['message' => 'Data kota berhasil dihapus']);
}


}
