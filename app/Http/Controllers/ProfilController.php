<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profil = Profil::all();
        return view('profil.index',compact('profil'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profil.create');
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
   // Metode untuk menyimpan data profil
   public function store(Request $request)
   {
        
   }

    
   public function edit($id)
{
    $profil = Profil::findOrFail($id); // Ganti "Profil" dengan model yang sesuai
    return response()->json($profil);
}

public function update(Request $request, $id)
{
    // Ambil data profil yang akan diperbarui
    $profil = Profil::findOrFail($id);
    
    // Validasi request
    $request->validate([
        'nama_profil' => 'required',
        'alias' => 'required',
        'no_telp' => 'required',
        'email' => 'required|email',
        'alamat' => 'required',
        'biaya_admin' => 'required|numeric',
        'biaya_pembatalan' => 'required|numeric',
        'no_rekening' => 'required',
        'bank' => 'required',
        'atas_nama' => 'required',
        'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar,
        'link' => 'required'
    ]);

    // Update data profil
    $profil->fill($request->except('gambar')); // Isi data kecuali gambar
    $profil->gambar = $profil->gambar; // Tetap gunakan gambar lama jika tidak ada gambar baru

    // Cek apakah ada file gambar yang diunggah
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($profil->gambar) {
            // Hapus gambar dari penyimpanan (misalnya folder uploads)
            $gambarPath = public_path('uploads/gambar_profil/' . $profil->gambar);
            if (file_exists($gambarPath)) {
                unlink($gambarPath);
            }
        }

        // Simpan gambar baru
        $gambarFile = $request->file('gambar');
        $namaFile = time() . '.' . $gambarFile->getClientOriginalExtension();
        $gambarFile->move(public_path('uploads/gambar_profil'), $namaFile);

        // Update atribut gambar pada profil
        $profil->gambar = $namaFile;
    }

    // Simpan perubahan
    $profil->save();

    return response()->json(['message' => 'Data profil berhasil diperbarui']);
}




}
