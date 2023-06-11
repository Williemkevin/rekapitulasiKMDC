<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Diagnosa;
use App\Models\Dokter;
use App\Models\JenisTindakan;
use App\Models\Pasien;
use Illuminate\Http\Request;

class TindakanPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tindakanPasien.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pasiens = Pasien::all();
        $jenisTindakans = JenisTindakan::all()->where('status', '1');
        $dokters = Dokter::all()->where('status', '1');
        $admins = Admin::all();
        $diagnosas = Diagnosa::all()->where('status', '1');
        return view('tindakanPasien.create', compact('pasiens', 'jenisTindakans', 'dokters', 'admins', 'diagnosas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
