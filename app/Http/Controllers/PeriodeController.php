<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $periode = Periode::all();
        return view('periode.index', ['periode' => $periode]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('periode.formcreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $periode = new Periode();
        $periode->bulan = $request->get('bulan');
        $periode->tahun = $request->get('tahun');

        $periode->created_at = now("Asia/Bangkok");
        $periode->updated_at = now("Asia/Bangkok");

        $periode->save();
        return redirect()->route('periode.index')->with('status', 'New periode is already inserted');

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
    public function edit(periode $periode)
    {
        $periode = Periode::find($periode->idperiode);
        return view('periode.formcreate', ['periode' => $periode]);
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
        $periode = new Periode();
        $periode->bulan = $request->get('bulan');
        $periode->tahun = $request->get('tahun');

        $periode->updated_at = now("Asia/Bangkok");

        $periode->save();
        return redirect()->route('periode.index')->with('status', 'Periode is already update');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(periode $periode)
    {
        $periode = Periode::find($periode->idperiode);
        $periode->delete();
        return redirect()->route('periode.index')->with('success', 'Periode is already deleted');

    }
}
