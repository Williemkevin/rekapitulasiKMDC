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
        return view('jenistindakan.index', ['jenisTindakan' => $jenisTindakan]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jenistindakan.create');
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
        $jenisTindakan->nama_tindakan = $request->get('nama_tindakan');
        $jenisTindakan->biaya_tindakan = $request->get('biaya_tindakan');
        $jenisTindakan->biaya_bahan = $request->get('biaya_bahan');

        $jenisTindakan->created_at = now("Asia/Bangkok");
        $jenisTindakan->updated_at = now("Asia/Bangkok");

        $jenisTindakan->save();
        return redirect()->route('jenistindakan.index')->with('status', 'New Jenis Tindakan ' .  $jenisTindakan->nama_tindakan . ' is already inserted');
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
        $jenisTindakan = JenisTindakan::find($id);
        return view('jenistindakan.edit', compact('jenisTindakan'));
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
        $jenisTindakan = jenisTindakan::find($id);

        $jenisTindakan->nama_tindakan = $request->get('nama_tindakan');
        $jenisTindakan->biaya_tindakan = $request->get('biaya_tindakan');
        $jenisTindakan->biaya_bahan = $request->get('biaya_bahan');

        $jenisTindakan->updated_at = now("Asia/Bangkok");

        $jenisTindakan->save();
        return redirect()->route('jenistindakan.index')->with('status', 'Jenis Tindakan ' .  $jenisTindakan->nama_tindakan . ' is already updated');
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
        return redirect()->route('jenistindakan.index')->with('success', 'Jenis tindakan ' .  $jenisTindakan->nama_tindakan . ' is already deleted');
    }

    public static function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
        return $hasil_rupiah;
    }
}
