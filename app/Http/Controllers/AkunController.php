<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\checkOwnPassword;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        return view('akun.index');
    }

    public function updateAkun(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:100'
        ]);

        $user = User::find(Auth::user()->id);

        if (!$user) {
            return response()->json(['message' => 'Akun tidak ditemukan'], 404);
        }

        $user->name = $request->name;
        $user->save();

        return response()->json(['message' => 'Akun berhasil diperbarui']);
    }

    public function ubahPassword(Request $request)
    {
        $request->validate([
            'old_password' => ['required', new checkOwnPassword],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $user = User::find(Auth::user()->id);

        if (!$user) {
            return response()->json(['message' => 'Akun tidak ditemukan'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password berhasil diperbarui']);
    }
}