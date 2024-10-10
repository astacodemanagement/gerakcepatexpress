<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;

class LapPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterStartDate = $request->start_date ?? today()->format('Y-m-d');
        $filterEndDate = $request->end_date ?? today()->format('Y-m-d');

        $pengeluaran = Pengeluaran::when($filterStartDate && $filterEndDate, function ($q) use ($filterStartDate, $filterEndDate) {
                                        return $q->whereDate('tanggal_pengeluaran', '>=', $filterStartDate) // Menambahkan kondisi untuk filter tanggal mulai
                                                ->whereDate('tanggal_pengeluaran', '<=', $filterEndDate); // Menambahkan kondisi untuk filter tanggal akhir
                                    })
                                    ->get();
                                    
        return view('laporan.pengeluaran.index',compact('pengeluaran', 'filterStartDate', 'filterEndDate'));
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

}



   public function edit($id)
{

}
public function update(Request $request, $id)
{

}


public function destroy($id)
{

}

public function getLatestCodePengeluaran()
{

}



}
