<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Services\AutoNumberService;
use App\Models\Invoice;
use App\Models\Konsumen;
use App\Models\Profil;
use App\Models\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterStartDate = $request->start_date;
        $filterEndDate = $request->end_date;
        $filterKonsumen = $request->konsumen;
        $filterCabang = $this->isSuperadmin() ? $request->cabang : Auth::user()->cabang_id;
        $filterCabangAsal = $request->cabang_asal;
        $filterCabangTujuan = $request->cabang_tujuan;
        $filterBillTo = $request->billto;
        $konsumen = $filterKonsumen ? Konsumen::find($filterKonsumen) : null;
        $billTo = $filterBillTo ? Konsumen::find($filterBillTo) : null;
        $cabang = $filterCabang ? Cabang::find($filterCabang) : null;
        $cabangAsal = $filterCabangAsal ? Cabang::find($filterCabangAsal) : null;
        $cabangTujuan = $filterCabangTujuan ? Cabang::find($filterCabangTujuan) : null;

        $invoice = Transaksi::select('invoice.id', 'transaksi.no_invoice', 'invoice.tanggal_invoice', 'invoice.bill_to', 'konsumen_id', 'invoice.cabang_id', 'cabang_id_tujuan', 'cabang_id_asal', 'cabang.nama_cabang', 'invoice.status_invoice', 'invoice.foto')
            ->join('invoice', 'invoice.no_invoice', '=', 'transaksi.no_invoice')
            ->join('cabang', 'invoice.cabang_id', '=', 'cabang.id')
            ->when($filterStartDate && $request->end_date, function ($q) use ($filterStartDate, $filterEndDate) {
                return $q->whereBetween('invoice.tanggal_invoice', [$filterStartDate, $filterEndDate]);
            })
            ->when($filterKonsumen, function ($q) use ($filterKonsumen) {
                return $q->where('konsumen_id', $filterKonsumen)
                    ->orWhere('konsumen_penerima_id', $filterKonsumen);
            })
            ->when($filterCabang, function ($q) use ($filterCabang) {
                return $q->where('invoice.cabang_id', $filterCabang);
            })
            ->when(!$this->isSuperadmin(), function ($q) {
                return $q->where('invoice.cabang_id', Auth::user()->cabang_id);
            })
            ->when($this->isSuperadmin() && $filterCabangAsal, function ($q) use ($filterCabangAsal) {
                return $q->where('cabang_id_asal', $filterCabangAsal);
            })
            ->when($filterCabangTujuan, function ($q) use ($filterCabangTujuan) {
                return $q->where('cabang_id_tujuan', $filterCabangTujuan);
            })
            ->whereNotNull('transaksi.no_invoice')
            ->groupBy('invoice.no_invoice')
            ->orderBy('cabang.nama_cabang', 'asc')
            ->orderBy('transaksi.no_invoice', 'asc')
            ->get();

        return view('invoice.index', compact('invoice', 'konsumen', 'cabang', 'cabangAsal', 'cabangTujuan', 'billTo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hasil_invoice.create');
    }

    public function show($id)
    {
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    // Metode untuk menyimpan data hasil_invoice
    public function store(Request $request)
    {
    }


    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }


    public function detail($id)
    {
        // Get the invoice and transactions
        $invoice = Invoice::findOrFail($id);
        $transactions = Transaksi::with(['cabangTujuan', 'cabangAsal'])
            ->where('no_invoice', $invoice->no_invoice)
            ->get();

        $profil = Profil::first();
        $konsumen = Konsumen::first();

        // Return the data
        return response()->json([
            'invoice' => $invoice,
            'transactions' => $transactions,
            'profil' => $profil,
            'konsumen' => $konsumen,
        ]);
    }

    public function generate()
    {
        $invoice = Transaksi::join('cabang', 'transaksi.cabang_id', '=', 'cabang.id')
            ->select('transaksi.*', 'cabang.nama_cabang')
            ->where(function ($q) {
                return $q->whereNull('transaksi.no_invoice')
                    ->where('transaksi.jenis_pembayaran', 'CAD')
                    ->where('transaksi.status_bawa', 'Sudah Dibawa')
                    ->when(function ($q) {
                        // Allow users with cabang_id 0 or SuperAdmin
                        if (!$this->isSuperadmin() && Auth::user()->cabang_id !== 0) {
                            $q->where('cabang_id', Auth::user()->cabang_id);
                        }
                    });
            })
            ->orWhere(function ($q) {
                return $q->whereNull('transaksi.no_invoice')
                    ->whereNotNull('tanggal_aju_pembatalan')
                    ->whereNotNull('tanggal_verifikasi_pembatalan')
                    ->whereNotNull('tanggal_ambil_pembatalan')
                    ->where('status_batal', 'Telah Diambil Pembatalan')
                    ->where('transaksi.jenis_pembayaran', 'CAD');
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('invoice.generate', compact('invoice'));
    }




    public function updateGenerate(Request $request)
    {
        $data = $request->all();
    
        try {
            DB::beginTransaction();
    
            // VALIDASI JUMLAH DATA YG AKAN DIGENERATE
            if (count($data) == 0) {
                throw new Exception('Tidak ada resi yg digenerate');
            }
    
            // SAVE INVOICE
            $resiBarisPertama = Transaksi::where('kode_resi', $data[0]['kodeResi'])->first(); //ambil data transaksi dari kode resi yg pertama
            $cabangId = $resiBarisPertama ? $resiBarisPertama->cabang_id : 0;
            $konsumenId = $resiBarisPertama ? $resiBarisPertama->konsumen_id : 0;
            $autoNumber = new AutoNumberService;
            $invoiceNumber = $autoNumber->invoice($cabangId);
    
            $invoice = Invoice::create([
                'no_invoice' => $invoiceNumber,
                'tanggal_invoice' => now(),
                'status_invoice' => 'Telah Dibuat',
                'cabang_id' => $cabangId,
                'bill_to_id' => $resiBarisPertama ? $resiBarisPertama->bill_to : null,
                'bill_to' => $resiBarisPertama ? $resiBarisPertama->nama_bill_to : null,
            ]);
    
            foreach ($data as $item) {
                $transaksi = Transaksi::when(!$this->isSuperadmin(), function ($q) {
                    if (!$this->isAllBranch()) {
                        return $q->where('cabang_id', Auth::user()->cabang_id);
                    }
                })
                    ->where('kode_resi', $item['kodeResi'])->first();
    
                // validasi jika transaksi tidak ditemukan
                if (!$transaksi) {
                    throw new Exception('Kode resi ' . $item['kodeResi'] . ' tidak ditemukan');
                }
    
                // validasi jika cabang tidak sama dengan cabang data pertama
                if ($transaksi->cabang_id != $cabangId) {
                    throw new Exception('Kode resi ' . $item['kodeResi'] . ' tidak sesuai cabang');
                }
    
                $transaksi->no_invoice = $invoiceNumber;
                $transaksi->save();
            }
    
            DB::commit();
            return response(['message' => 'Data invoice berhasil diperbarui dan ditambahkan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['success' => 'false', 'message' => $e->getMessage()], 400);
        }
    }
    

    public function exportPDF(Request $request, $id)
    {
        $profil = Profil::first();
        $invoice = Invoice::findOrFail($id);
        $transaksi = Transaksi::where('no_invoice', $invoice->no_invoice)->get();

        $billTo = Konsumen::find($transaksi[0]->konsumen_id);
        $konsumenId = $transaksi->first()->bill_to;
          // Dapatkan objek Konsumen berdasarkan ID
        $konsumen = Konsumen::find($konsumenId);

        if ($request->has('billto')) {
            if ($request->billto == $transaksi[0]->konsumen_penerima_id) {
                $billTo = Konsumen::find($request->billto);
            }
        }

        $pdf = Pdf::loadView('export.pdf.invoice', ['invoice' => $invoice, 'transaksi' => $transaksi, 'profil' => $profil, 'billto' => $billTo, 'konsumen' => $konsumen, ]);
        return $pdf->download('INVOICE ' . $invoice->no_invoice . '.pdf');
    }

    

    public function iFrame(Request $request, $id)
    {
        $profil = Profil::first();
        $invoice = Invoice::findOrFail($id);
        $transaksi = Transaksi::where('no_invoice', $invoice->no_invoice)->get();
        $billTo = Konsumen::find($invoice->bill_to_id);

        // Ambil ID konsumen dari field bill_to pada transaksi
        $konsumenId = $transaksi->first()->bill_to;

        // Dapatkan objek Konsumen berdasarkan ID
        $konsumen = Konsumen::find($konsumenId);

        return view('export.pdf.invoice', [
            'invoice' => $invoice,
            'transaksi' => $transaksi,
            'profil' => $profil,
            'billto' => $billTo,
            'konsumen' => $konsumen, // Mengganti $billTo dengan $konsumen
        ]);
    }


    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // Temukan invoice berdasarkan ID
            $invoice = Invoice::findOrFail($id);

            // Ambil nomor invoice
            $noInvoice = $invoice->no_invoice;

            // Hapus invoice berdasarkan ID
            $invoice->delete();

            // Perbarui status_bayar menjadi 'Belum Lunas' di tabel Transaksi berdasarkan no_invoice dari invoice yang dihapus
            Transaksi::where('no_invoice', $noInvoice)->update([
                'status_bayar' => 'Belum Lunas',
                'no_invoice' => null // Menghapus no_invoice pada transaksi terkait
            ]);

            DB::commit();

            return response()->json(['message' => 'Invoice berhasil dihapus dan data transaksi diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Terjadi kesalahan saat menghapus invoice: ' . $e->getMessage()], 500);
        }
    }


    public function updateStatus(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            // Temukan invoice berdasarkan ID
            $invoice = Invoice::findOrFail($id);

            // Update status_invoice menjadi Sudah Dibayar
            $invoice->status_invoice = 'Sudah Lunas';
            $invoice->save();

            // Update status_bayar menjadi Sudah Dibayar pada transaksi yang memiliki no_invoice yang sama
            Transaksi::where('no_invoice', $invoice->no_invoice)
                ->update(['status_bayar' => 'Sudah Lunas']);

            DB::commit();

            return response()->json(['message' => 'Status invoice dan pembayaran berhasil diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Terjadi kesalahan saat memperbarui status: ' . $e->getMessage()], 500);
        }
    }

    public function uploadFoto($invoiceId, Request $request)
    {
        $invoice = Invoice::find($invoiceId);

        if (!$invoice) {
            return response()->json(['success' => false, 'message' => 'Invoice not found'], 404);
        }

        $request->validate([
            'upload_foto' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:6000', // Validasi file gambar
        ]);

        $image = $request->file('upload_foto');
        $imageName = $image->hashName() . '.webp';
        $manager = ImageManager::imagick();

        $uploadPath = public_path('uploads/invoice/');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, TRUE);
        }

        $image = $manager->read($image);
        $image = $image->toWebp()->save($uploadPath . $imageName);

        if ($invoice->foto) {
            if (File::exists($uploadPath . $invoice->foto)) {
                File::delete($uploadPath . $invoice->foto);
            }
        }

        $invoice->foto = $imageName;
        $invoice->save();

        return response()->json(['success' => true,'message' => 'Foto invoice berhasil diupload']);
    }
}
