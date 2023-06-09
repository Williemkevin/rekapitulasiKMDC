<?php

namespace App\Http\Controllers;

use App\Models\KategoriTindakan;
use Illuminate\Http\Request;

class KategoriTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = KategoriTindakan::all();
        return view('kategori.index', ['kategori' => $kategori]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategori.formcreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kategori = new KategoriTindakan();
        $kategori->nama_tindakan = $request->get('nama_tindakan');
        $kategori->deskripsi = $request->get('deskripsi');
        $kategori->status = $request->get('status');

        $kategori->created_at = now("Asia/Bangkok");
        $kategori->updated_at = now("Asia/Bangkok");

        $kategori->save();
        return redirect()->route('kategori.index')->with('status', 'New kategori tindakan is already inserted');
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
    public function edit(kategoriTindakan $kategoriTindakan)
    {
        $kategori = KategoriTindakan::find($kategoriTindakan->idkategori);
        return view('kategori.formcreate', ['kategori' => $kategori]);//
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
        $kategori = new KategoriTindakan();
        $kategori->nama_tindakan = $request->get('nama_tindakan');
        $kategori->deskripsi = $request->get('deskripsi');
        $kategori->status = $request->get('status');

        $kategori->updated_at = now("Asia/Bangkok");

        $kategori->save();
        return redirect()->route('kategori.index')->with('status', 'Kategori tindakan is already updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(kategoriTindakan $kategoriTindakan)
    {
        $kategori = KategoriTindakan::find($kategoriTindakan->idkategori);
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori tindakan is already deleted');
    }
}
