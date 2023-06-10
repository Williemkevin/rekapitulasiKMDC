<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use Illuminate\Http\Request;

class DiagnosaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diagnosa = Diagnosa::all();
        return view('diagnosa.index', ['diagnosa' => $diagnosa]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('diagnosa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $diagnosa = new Diagnosa();
        $diagnosa->kode_diagnosa = $request->get('kodeDiagnosa');
        $diagnosa->nama_diagnosa = $request->get('namaDiagnosa');
        $diagnosa->created_at = now("Asia/Bangkok");
        $diagnosa->updated_at = now("Asia/Bangkok");
        $diagnosa->save();

        return redirect()->route('diagnosa.index')->with('status', 'New Diagnosa ' .  $diagnosa->nama_diagnosa . ' is already inserted');
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
        $diagnosa = Diagnosa::find($id);
        return view('diagnosa.edit', compact('diagnosa'));
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
        $diagnosa = Diagnosa::find($id);
        $diagnosa->kode_diagnosa = $request->get('kodeDiagnosa');
        $diagnosa->nama_diagnosa = $request->get('namaDiagnosa');
        $diagnosa->updated_at = now("Asia/Bangkok");
        $diagnosa->save();

        return redirect()->route('diagnosa.index')->with('status', 'Diagnosa ' .  $diagnosa->nama_diagnosa . ' is already updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
