<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Kota;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Models\Transaksi;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Backup\Backup;
use Illuminate\Support\Facades\File;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cabang = Cabang::all();
        return view('cabang.index',compact('cabang'));
    }

    public function updateClosing(Request $request, Cabang $cabang)
    {
        DB::beginTransaction();
        try {
            // Artisan::call('backup:run', [
            //     '--only-db' => true, // Backup hanya database
            //     '--disable-notifications' => true, // Nonaktifkan notifikasi,
            //     '--only-to-disk' => 'backup_closing'
            // ]);

            // return Artisan::output();

            $transaksi = Transaksi::where('cabang_id', Auth::user()->cabang_id)->whereNull('tanggal_kirim')->first();

            if ($transaksi) {
                return response()->json(['message' => 'Closing tidak dapat dilakukan, silahkan periksa resi yg belum dikirim', 'success' => false], 400);
            }

            $db_name = env('DB_DATABASE');
            $db_user = env('DB_USERNAME');
            $db_password = env('DB_PASSWORD');
            $today = date('Y-m-d_His');
            $path = public_path('backup/' . Auth::user()->cabang_id);

            if (!is_dir($path)) {
                mkdir($path, 0777, TRUE);
            }

            $filename = "backup-{$today}.sql";
            $command = "mysqldump --user={$db_user} --password={$db_password} {$db_name} > {$path}/{$filename}";
            exec($command);

            if (!File::exists($path . '/' . $filename)) {
                return throw new Exception('Failed to backup file');
            }

            $cabang->status = 'Nonaktif';
            $cabang->kasir = Auth::user()->name;
            $cabang->tanggal_closing = now();
            $cabang->save();
            DB::commit();
            return response()->json(['message' => 'Closing updated successfully', 'file' => $filename]);
        } catch (\Exception $e) {
            // Handle the error
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function downloadBackup(Request $request)
    {
        return response()->download(public_path('backup/' . Auth::user()->cabang_id . '/' . $request->file))->deleteFileAfterSend(true);
    }

    public function bukaClosing(Request $request)
    {
        // Dapatkan ID cabang yang sedang login
        $cabangId = Auth::user()->cabang_id;

        // Dapatkan tanggal closing dari tabel cabang berdasarkan ID cabang yang sedang login
        $cabang = Cabang::find($cabangId);

        if (!$cabang) {
            return response(['message' => 'Cabang tidak ditemukan'], 404);
        }

        // Periksa apakah tanggal hari ini melewati tanggal closing
        if ($cabang->status == 'Nonaktif' && Carbon::today()->greaterThan(Carbon::parse($cabang->tanggal_closing)->format('Y-m-d'))) {
            // Lakukan update status menjadi null pada tabel cabang
            $cabang->status = null;
            $cabang->tanggal_closing = null;
            $cabang->save();

            return response()->json(['success' => true, 'message' => 'Closingan berhasil dibuka!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Belum saatnya untuk membuka closingan.'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cabang.create');
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
    // Metode untuk menyimpan data cabang

    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'kode_cabang' => 'required',
            'nama_cabang' => 'required',
            'alamat_cabang' => 'required',
            'id_kota' => 'required', // Sesuaikan dengan nama input pada form
        ]);

        // Simpan data cabang ke database
        $cabang = new Cabang();
        $cabang->kode_cabang = $request->kode_cabang;
        $cabang->nama_cabang = $request->nama_cabang;
        $cabang->alamat_cabang = $request->alamat_cabang;
        $cabang->id_kota = $request->id_kota; // Ambil nilai id_kota dari form

        // Anda bisa mengambil nama_kota dari model Kota jika diperlukan
        $kota = Kota::find($request->id_kota);
        $cabang->nama_kota = $kota->nama_kota; // Ambil nama_kota dari model Kota

        $cabang->save();

        return response()->json(['message' => 'Data cabang berhasil disimpan']);
    }

    public function edit($id)
    {
        $cabang = Cabang::findOrFail($id); // Ganti "Cabang" dengan model yang sesuai
        return response()->json($cabang);
    }

    public function update(Request $request, $id)
    {
        // Ambil data cabang yang akan diperbarui
        $cabang = Cabang::findOrFail($id);

        // Validasi request
        $request->validate([
            'kode_cabang' => 'required',
            'nama_cabang' => 'required',
            'alamat_cabang' => 'required',
            'id_kota' => 'required',
        ]);

        // Update data cabang berdasarkan request
        $cabang->kode_cabang = $request->kode_cabang;
        $cabang->nama_cabang = $request->nama_cabang;
        $cabang->alamat_cabang = $request->alamat_cabang;
        $cabang->id_kota = $request->id_kota;

        // Mengambil nama_kota dari model Kota berdasarkan ID kota yang dipilih
        $kota = Kota::find($request->id_kota);
        if ($kota) {
            $cabang->nama_kota = $kota->nama_kota;
        } else {
            // Jika ID kota tidak ditemukan, Anda bisa menentukan aksi yang sesuai
            // Misalnya, memberikan nilai default atau melakukan penanganan khusus
            $cabang->nama_kota = 'Kota Tidak Diketahui';
        }

        // Simpan perubahan
        $cabang->save();

        return response()->json(['message' => 'Data cabang berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $cabang = Cabang::find($id);

        if (!$cabang) {
            return response()->json(['message' => 'Data cabang tidak ditemukan'], 404);
        }

        $cabang->delete();

        return response()->json(['message' => 'Data cabang berhasil dihapus']);
    }

    public function getKotaData(Request $request)
    {
        $term = $request->term;
        $data = Kota::where('nama_kota', 'LIKE', '%' . $term . '%')->get(); // Ganti "Kota" dengan model yang sesuai

        return response()->json($data);
    }

}