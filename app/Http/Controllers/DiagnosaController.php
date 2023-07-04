<?php

namespace App\Http\Controllers;

use App\Models\Diagnosa;
use Illuminate\Database\QueryException;
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
        $diagnosaNonAktif = Diagnosa::all()->where('status', '0');;
        $diagnosaAktif = Diagnosa::all()->where('status', '1');;

        return view('diagnosa.index', compact('diagnosaNonAktif', 'diagnosaAktif'));
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
        try {
            $diagnosa = new Diagnosa();
            $diagnosa->kode_diagnosa = $request->get('kodeDiagnosa');
            $diagnosa->nama_diagnosa = $request->get('namaDiagnosa');
            $diagnosa->created_at = now("Asia/Bangkok");
            $diagnosa->updated_at = now("Asia/Bangkok");
            $diagnosa->save();

            return redirect()->route('diagnosa.index')->with('status', 'New Diagnosa ' .  $diagnosa->nama_diagnosa . ' is already inserted');
        }catch (QueryException $e) {
        $errorCode = $e->errorInfo[1];
        if ($errorCode === 1062) {
            echo "Kode diagnosa sudah ada di database.";
        } else {
            echo "Terjadi kesalahan saat menyimpan data diagnosa.";
        }
    }
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

    public function nonaktifkan(Request $request)
    {
        $data = Diagnosa::find($request->get('id'));
        $data->status = '0';
        $data->save();
        return response()->json(array('status' => 'success'), 200);
    }

    public function aktifkan(Request $request)
    {
        $data = Diagnosa::find($request->get('id'));
        $data->status = '1';
        $data->save();
        return response()->json(array('status' => 'success'), 200);
    }

    public function CheckKodeDiagnosa($kode)
    {
        $diagnosa = Diagnosa::where('kode_diagnosa', $kode)->get();
        if($diagnosa != null){
            return true;
        }else{
            return false;
        }
    }

}
