<?php

namespace App\Http\Controllers;

use App\Models\JenisTindakan;
use Illuminate\Http\Request;

class JenisTindakanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenisTindakan = JenisTindakan::all();
        return view('jenisTindakan.index', ['jenisTindakan' => $jenisTindakan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jenisTindakan.formcreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jenisTindakan = new jenisTindakan();
        $jenisTindakan->kategories_tindakan_idkategori = $request->get('kategories_tindakan_idkategori');
        $jenisTindakan->nama_tindakan = $request->get('nama_tindakan');
        $jenisTindakan->biaya = $request->get('biaya');
        $jenisTindakan->deskripsi = $request->get('deskripsi');
        $jenisTindakan->status = $request->get('status');

        $jenisTindakan->created_at = now("Asia/Bangkok");
        $jenisTindakan->updated_at = now("Asia/Bangkok");

        $jenisTindakan->save();
        return redirect()->route('jenisTindakan.index')->with('status', 'New Jenis Tindakan is already inserted');
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
    public function edit(jenisTindakan $jenisTindakan)
    {
        $jenisTindakan = JenisTindakan::find($jenisTindakan->idJenis_tindakan);
        return view('jenisTindakan.formcreate', ['jenisTindakan' => $jenisTindakan]);
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
        $jenisTindakan = new JenisTindakan();
        $jenisTindakan->kategories_tindakan_idkategori = $request->get('kategories_tindakan_idkategori');
        $jenisTindakan->nama_tindakan = $request->get('nama_tindakan');
        $jenisTindakan->biaya = $request->get('biaya');
        $jenisTindakan->deskripsi = $request->get('deskripsi');
        $jenisTindakan->status = $request->get('status');

        $jenisTindakan->updated_at = now("Asia/Bangkok");

        $jenisTindakan->save();
        return redirect()->route('jenisTindakan.index')->with('status', 'Jenis Tindakan is already updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(jenisTindakan $jenisTindakan)
    {
        $jenisTindakan = JenisTindakan::find($jenisTindakan->idJenis_tindakan);
        $jenisTindakan->delete();
        return redirect()->route('jenisTindakan.index')->with('success', 'Jenis tindakan is already deleted');
    }

    public static function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }
}
