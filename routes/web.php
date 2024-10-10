
<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LapPengeluaranController;
use App\Http\Controllers\LapTransaksiController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('pengaturan-akun', [AkunController::class, 'index'])->name('pengaturan-akun');
    Route::post('pengaturan-akun/update-akun', [AkunController::class, 'updateAkun'])->name('pengaturan-akun.update-akun');
    Route::post('pengaturan-akun/ubah-password', [AkunController::class, 'ubahPassword'])->name('pengaturan-akun.ubah-password');

    Route::middleware('role:superadmin')->group(function () {
        Route::resource('/kota', KotaController::class);
        Route::get('/grafik-total-bayar', 'DashboardController@grafikTotalBayar')->name('grafik.total_bayar');

        // Route::resource('/pengambilan', PengambilanController::class);
        Route::resource('/cabang', CabangController::class);
        Route::resource('/pengguna', PenggunaController::class);

        Route::resource('/konsumen',
            KonsumenController::class
        );
        // Route untuk menyimpan data konsumen
        // perintah edit
        Route::get('/konsumen/{id}/edit', [KonsumenController::class, 'edit']);
        Route::put('/konsumen/update/{id}', [KonsumenController::class, 'update']);
        Route::delete('/konsumen/{id}', [KonsumenController::class, 'destroy']);

        // Halaman Profil
        Route::resource('/profil', ProfilController::class);
        // Route untuk menyimpan data profil
        Route::post('/simpan-profil', [ProfilController::class, 'store'])->name('simpan.profil');
        // perintah edit
        Route::get('/profil/{id}/edit', [ProfilController::class, 'edit']);
        Route::put('/profil/update/{id}', [ProfilController::class, 'update']);


        Route::resource('/kota', KotaController::class);
        // Route untuk menyimpan data kota
        Route::post('/simpan-kota', [KotaController::class, 'store'])->name('simpan.kota');
        // perintah edit
        Route::get('/kota/{id}/edit', [KotaController::class, 'edit']);
        Route::put('/kota/update/{id}', [KotaController::class, 'update']);
        Route::delete('/kota/{id}', [KotaController::class, 'destroy']);



        Route::resource('/cabang', CabangController::class);
        // Route untuk menyimpan data cabang
        Route::post('/simpan-cabang', [CabangController::class, 'store'])->name('simpan.cabang');
        // perintah edit
        Route::get('/cabang/{id}/edit', [CabangController::class, 'edit']);
        Route::put('/cabang/update/{id}', [CabangController::class, 'update']);
        Route::delete('/cabang/{id}', [CabangController::class, 'destroy']);
        Route::get('/getKotaData', [CabangController::class, 'getKotaData'])->name('getKotaData');

       
        // Halaman Laporan Pendapatan
        Route::get('/lap_pendapatan', [LapTransaksiController::class, 'index_pendapatan'])->name('lap_pendapatan.index_pendapatan');
        Route::get('/lap_pengiriman', [LapTransaksiController::class, 'index_pengiriman'])->name('lap_pengiriman.index_pengiriman');
        Route::get('/lap_pembayaran', [LapTransaksiController::class, 'index_pembayaran'])->name('lap_pembayaran.index_pembayaran');
       
      
        
      
        Route::get('/lap_all_summary', [LapTransaksiController::class, 'index_all_summary'])->name('lap_all_summary.index_all_summary');

        Route::get('development/replace-comma', [TransaksiController::class, 'replaceComma']);

        Route::get('/ubah_pengiriman', [TransaksiController::class, 'ubah_pengiriman'])->name('ubah_pengiriman.index');
        // Menampilkan data untuk edit
        Route::get('/ubah_pengiriman/{id}/edit', [TransaksiController::class, 'edit'])->name('ubah_pengiriman.edit');

        // Memperbarui data
        Route::put('/ubah_pengiriman/{id}', [TransaksiController::class, 'update'])->name('ubah_pengiriman.update');

    });

    Route::middleware('role:superadmin|gudang')->group(function () {
        // Booking
        Route::get('/booking', [TransaksiController::class, 'index_booking'])->name('booking.index');
        Route::post('/booking/store', [TransaksiController::class, 'store_booking'])->name('booking.store_booking');
        // Route untuk tampil/edit data booking
        Route::get('/booking/{id}/edit_booking', [TransaksiController::class, 'edit_booking'])->name('booking.edit_booking');
        // Route untuk update/perbaharui data booking
        Route::put('/booking/update_booking/{id}', [TransaksiController::class, 'update_booking'])->name('booking.update_booking');
        Route::get('/getLatestCode', [TransaksiController::class, 'getLatestCode'])->name('getLatestCode');
        Route::get('/getKodeCabangKota/{cabang_id}/{user_id}', [TransaksiController::class, 'getKodeCabangKota']);
        Route::delete('/booking/{id}', [TransaksiController::class, 'destroy_booking']);

        Route::put('/booking/update_booking/{id}', [TransaksiController::class, 'update_booking'])->name('booking.update_booking');
        Route::get('/booking/filter', [TransaksiController::class, 'filterByDate'])->name('booking.filter');



        // Pengambilan
        Route::get('/pengambilan', [TransaksiController::class, 'index_pengambilan'])->name('pengambilan.index');
        Route::get('/barang_turun', [TransaksiController::class, 'index_barang_turun'])->name('barang_turun.index');
        // cari kode resi
        Route::get('/getResiDataPengambilan', [TransaksiController::class, 'getResiDataPengambilan'])->name('getResiDataPengambilan');
        Route::get('/getDetailResiDataPengambilan', [TransaksiController::class, 'getDetailResiDataPengambilan'])->name('getDetailResiDataPengambilan');
        //Simpan
        Route::post('/simpan-pengambilan/{kode_resi}', [TransaksiController::class, 'simpanPengambilan']);


        // Pembatalan
        Route::get('/ambil_pembatalan', [TransaksiController::class, 'index_ambil_pembatalan'])->name('ambil-pembatalan.index');
        // cari kode resi
        Route::get('/getResiDataAmbilPembatalan', [TransaksiController::class, 'getResiDataAmbilPembatalan'])->name('getResiDataAmbilPembatalan');
        Route::get('/getDetailResiDataAmbilPembatalan', [TransaksiController::class, 'getDetailResiDataAmbilPembatalan'])->name('getDetailResiDataAmbilPembatalan');
        //Simpan
        Route::post('/simpan-ambil-pembatalan/{kode_resi}', [TransaksiController::class, 'simpanAmbilPembatalan']);
    });

    Route::middleware('role:superadmin|kasir')->group(function () {

        // Index Pengiriman
        Route::get('/pengiriman', [TransaksiController::class, 'index_pengiriman'])->name('pengiriman.index');

        Route::get('/pembatalan', [TransaksiController::class, 'index_pembatalan'])->name('pembatalan.index');
        // generate kode resi
        Route::get('/data_pengiriman', [TransaksiController::class, 'data_pengiriman'])->name('data_pengiriman');
      


        // cari kode resi
        Route::get('/getResiData', [TransaksiController::class, 'getResiData'])->name('getResiData');
        Route::get('/getResiDataBatal', [TransaksiController::class, 'getResiDataBatal'])->name('getResiDataBatal');
        Route::get('/getDetailResiData', [TransaksiController::class, 'getDetailResiData'])->name('getDetailResiData');
        Route::get('/getDetailResiDataPembatalan', [TransaksiController::class, 'getDetailResiDataPembatalan'])->name('getDetailResiDataPembatalan');
        Route::post('/simpan-konsumen', [KonsumenController::class, 'store'])->name('simpan.konsumen');

        Route::get('/getKonsumenPenerimaData', [TransaksiController::class, 'getKonsumenPenerimaData'])->name('getKonsumenPenerimaData');
        Route::get('/getBillTo', [TransaksiController::class, 'getBillTo'])->name('getBillTo');

        // ambil biaya admin
        Route::get('/getBiayaAdmin', [TransaksiController::class, 'getBiayaAdmin']);
        // ambil biaya pembatalan
        Route::get('/getBiayaPembatalan', [TransaksiController::class, 'getBiayaPembatalan']);
        // perintah edit
        Route::get('/pengiriman/{id}/edit', [TransaksiController::class, 'edit_pengiriman']);
        // Route untuk update/perbaharui data pengiriman
        Route::match(['put', 'patch'],'/pengiriman/update_pengiriman/{kode_resi}', [TransaksiController::class, 'update_pengiriman']);
        //
        Route::match(['put', 'patch'],'/pengiriman/pembatalan_pengiriman/{kode_resi}', [TransaksiController::class, 'pembatalan_pengiriman']);

        Route::post('/simpan-konsumen', [KonsumenController::class, 'store'])->name('simpan.konsumen');

        // Penerimaan
        Route::get('/penerimaan', [TransaksiController::class, 'index_penerimaan'])->name('penerimaan.index');
        // perintah edit
        Route::get('/penerimaan/{id}/edit', [TransaksiController::class, 'edit_penerimaan']);
        // Route untuk update/perbaharui data penerimaan
        Route::match(['put', 'patch'],'/penerimaan/update_penerimaan/{id}', [TransaksiController::class, 'update_penerimaan']);
        Route::get('/getResiDataPenerimaan', [TransaksiController::class, 'getResiDataPenerimaan'])->name('getResiDataPenerimaan');
        Route::get('/getDetailResiDataPenerimaan', [TransaksiController::class, 'getDetailResiDataPenerimaan'])->name('getDetailResiDataPenerimaan');
        Route::get('/data_penerimaan', [TransaksiController::class, 'data_penerimaan'])->name('data_penerimaan');



        // Halaman Pengeluaran
        Route::resource('/pengeluaran', PengeluaranController::class);
        // Route generate kode pengeluaran otomatis
        Route::get('/getLatestCodePengeluaran', [PengeluaranController::class, 'getLatestCodePengeluaran'])->name('getLatestCodePengeluaran');
        // Route untuk menyimpan data pengeluaran
        Route::post('/simpan-pengeluaran', [PengeluaranController::class, 'store'])->name('simpan.pengeluaran');
        // perintah edit
        Route::get('/pengeluaran/{id}/edit', [PengeluaranController::class, 'edit']);
        Route::put('/pengeluaran/update/{id}', [PengeluaranController::class, 'update']);


        Route::get('/penerimaan/filter', [TransaksiController::class, 'filterByDatePenerimaan'])->name('penerimaan.filter');

        Route::get('/lap_kasir_detail', [LapTransaksiController::class, 'index_kasir_detail'])->name('lap_kasir_detail.index_kasir_detail');
        Route::get('/lap_kasir_summary', [LapTransaksiController::class, 'index_kasir_summary'])->name('lap_kasir_summary.index_kasir_summary');
        // Route::get('/lap_kasir_summary2', [LapTransaksiController::class, 'index_kasir_summary2'])->name('lap_kasir_summary.index_kasir_summary2');


        // Route::get('/resi/{id}/detail/{module?}', [TransaksiController::class, 'detailResi']);
    });

    Route::middleware('role:superadmin|manager')->group(function () {
        // Index Verifikasi
        Route::get('/verifikasi_pembatalan', [TransaksiController::class, 'index_verifikasi_pembatalan'])->name('verifikasi-pembatalan.index');
        // generate kode pembatalan
        Route::get('/generateKodePembatalan', [TransaksiController::class, 'generateKodePembatalan']);
        // simpan/update
        Route::post('/verifikasi_pembatalan/update_verifikasi/{id}', [TransaksiController::class, 'update_verifikasi']);
        // Route untuk tampil/edit data verifikasi_pembatalan
        Route::get('/verifikasi_pembatalan/{id}/edit_verifikasi_pembatalan', [TransaksiController::class, 'edit_verifikasi_pembatalan'])->name('verifikasi_pembatalan.edit_verifikasi_pembatalan');
        
        Route::get('/lap_daftar_muat_detail', [LapTransaksiController::class, 'index_daftar_muat_detail'])->name('lap_daftar_muat_detail.index_daftar_muat_detail');
        Route::get('/lap_daftar_muat_summary', [LapTransaksiController::class, 'index_daftar_muat_summary'])->name('lap_daftar_muat_summary.index_daftar_muat_summary');
        Route::get('/lap_bongkar_detail', [LapTransaksiController::class, 'index_bongkar_detail'])->name('lap_bongkar_detail.index_bongkar_detail');
        Route::get('/lap_bongkar_summary', [LapTransaksiController::class, 'index_bongkar_summary'])->name('lap_bongkar_summary.index_bongkar_summary');
        Route::get('/data_belum_ambil', [TransaksiController::class, 'data_belum_ambil'])->name('data_belum_ambil');

        // Route::get('/resi/{id}/detail/{module?}', [TransaksiController::class, 'detailResi']);
    });

    Route::middleware('role:superadmin|finance')->group(function () {
        // INVOICE
        Route::get('/invoice/generate', [InvoiceController::class, 'generate'])->name('invoice.generate');
        Route::put('/invoice/generate', [InvoiceController::class, 'updateGenerate'])->name('invoice.update-generate');
        Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('/invoice/{id}/detail', [InvoiceController::class, 'detail']);
       
        Route::get('/invoice/{id}/export/pdf', [InvoiceController::class, 'exportPDF'])->name('invoice.export.pdf');
        Route::get('/invoice/{id}/detail/iframe', [InvoiceController::class, 'iFrame'])->name('invoice.show.iframe');
        Route::delete('/invoice/{id}/delete', [InvoiceController::class, 'destroy'])->name('invoice.delete');
        Route::put('/invoice/{id}/update-status', [InvoiceController::class, 'updateStatus'])->name('invoice.updateStatus');
        Route::post('/invoice/{id}/upload-foto', [InvoiceController::class, 'uploadFoto'])->name('invoice.uploadFoto');
        // Halaman Laporan Pengeluaran
        Route::resource('/lap_pengeluaran', LapPengeluaranController::class);
        Route::get('/lap_transferan', [LapTransaksiController::class, 'index_transferan'])->name('lap_transferan.index_transferan');

    });

    Route::middleware('role:superadmin|finance|kasir')->group(function () {
        // cari kode konsumen
        Route::get('/getKonsumenData', [TransaksiController::class, 'getKonsumenData'])->name('getKonsumenData');

        Route::get('/data-transaksi', [TransaksiController::class, 'getDataTransaksi'])->name('data.transaksi');
        Route::get('/data-transaksi2', [TransaksiController::class, 'getDataTransaksi2'])->name('data.transaksi2');

        // cari cabang
        Route::get('/getCabangData', [TransaksiController::class, 'getCabangData'])->name('getCabangData');

        Route::get('dashboard/grafik-dashboard', [DashboardController::class, 'grafikTransaksi'])->name('dashboard.grafik-transaksi');
        Route::get('dashboard/table-dashboard', [DashboardController::class, 'tableTransaksi'])->name('dashboard.table-transaksi');
        Route::get('dashboard/profit-cabang', [DashboardController::class, 'tableProfit'])->name('dashboard.table-profit');
        Route::get('dashboard/profit-all', [DashboardController::class, 'tableProfitAll'])->name('dashboard.table-profit-all');




        
        // Halaman Pengeluaran
        Route::resource('/pengeluaran', PengeluaranController::class);
        // Route generate kode pengeluaran otomatis
        Route::get('/getLatestCodePengeluaran', [PengeluaranController::class, 'getLatestCodePengeluaran'])->name('getLatestCodePengeluaran');
        // Route untuk menyimpan data pengeluaran
        Route::post('/simpan-pengeluaran', [PengeluaranController::class, 'store'])->name('simpan.pengeluaran');
        // perintah edit
        Route::get('/pengeluaran/{id}/edit', [PengeluaranController::class, 'edit']);
        Route::put('/pengeluaran/update/{id}', [PengeluaranController::class, 'update']);
    });

    Route::middleware('role:superadmin|gudang|kasir')->group(function () {
        Route::post('/update-closing/{cabang}', [CabangController::class, 'updateClosing'])->name('update.closing');
        Route::put('/buka-closing', [CabangController::class, 'bukaClosing'])->name('buka.closing');
        Route::post('/backup-database', [CabangController::class, 'backupDatabase']);
        Route::get('/download-backup', [CabangController::class, 'downloadBackup'])->name('cabang.download-backup');

    });
    Route::middleware('role:superadmin|manager|kasir')->group(function () {
        Route::get('/resi/{id}/detail/{module?}', [TransaksiController::class, 'detailResi']);
    });
    Route::get('update-tanggal-otomatis', function() {
        \App\Models\Transaksi::whereNull('tanggal_terima_otomatis')->each(function ($query) {
            $tanggalTerimaOtomatis = \Carbon\Carbon::parse($query->tanggal_kirim)->addDays(1)->format('Y-m-d');
            // dd($query->tanggal_kirim, $tanggalTerimaOtomatis);
            $query->update(['tanggal_terima_otomatis' => $tanggalTerimaOtomatis, 'updated_at' => now()]);
        });
    });
});
