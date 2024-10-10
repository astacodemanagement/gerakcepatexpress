<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengguna = Auth::user()->hasRole('superadmin') ? User::all() : User::where('cabang_id', '!=', 0)->get();
        $roles = Role::all();

        return view('pengguna.index', compact('pengguna', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi request
        if (Auth::user()->hasRole('superadminn')) {
            $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|numeric',
                'cabang_id' => 'required|numeric',
                'password' => 'required|confirmed|min:6'
            ]);
        } else {
            $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|numeric',
                'password' => 'required|confirmed|min:6'
            ]);
        }

        // Cari role
        $role = Role::find($request->role);

        if (!$role) {
            return response(['success' => false, 'message' => 'Role tidak ditemukan'], 404);
        }

        // Simpan data pengguna ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cabang_id' => $request->cabang_id,
            'password' => Hash::make($request->password),
        ]);

        // Assign pengguna ke role
        $user->assignRole($role->name);

        return response()->json(['message' => 'Data pengguna berhasil disimpan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pengguna = User::find($id);

        if (!$pengguna) {
            return response(['success' => false, 'message' => 'Pengguna tidak ditemukan'], 404);
        }

        // $cabang = Cabang::where('id', $pengguna->cabang_id)->first();
        $pengguna->role = $pengguna->roles[0]->id;
        $pengguna->cabang_title = $pengguna->cabang?->nama_cabang;

        return response($pengguna);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pengguna = User::find($id);

        if (!$pengguna) {
            return response(['success' => false, 'message' => 'Pengguna tidak ditemukan'], 404);
        }

        // Validasi request
        if (Auth::user()->hasRole('superadminn')) {
            $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,' . $id,
                'role' => 'required|numeric',
                'cabang_id' => 'required|numeric',
                'password' => 'nullable|confirmed|min:6'
            ]);
        } else {
            $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email,' . $id,
                'role' => 'required|numeric',
                'password' => 'nullable|confirmed|min:6'
            ]);
        }

        // Cari role
        $role = Role::find($request->role);

        if (!$role) {
            return response(['success' => false, 'message' => 'Role tidak ditemukan'], 404);
        }

        // Simpan data pengguna ke database

        $pengguna->name = $request->name;
        $pengguna->email = $request->email;
        $pengguna->cabang_id = $request->cabang_id;

        if ($request->password) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        // Assign pengguna ke role
        $pengguna->syncRoles($role->name);

        return response()->json(['message' => 'Data pengguna berhasil disimpan']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengguna = User::find($id);

        if (!$pengguna) {
            return response()->json(['message' => 'Data pengguna tidak ditemukan'], 404);
        }

        $pengguna->delete();

        return response()->json(['message' => 'Data pengguna berhasil dihapus']);
    }
}
