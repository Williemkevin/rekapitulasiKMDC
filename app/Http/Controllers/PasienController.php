<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasien = Pasien::all();
        return view('pasien.index', ['pasien' => $pasien]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pasien.formcreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pasien = new Pasien();
        $pasien->username = $request->get('username');
        $pasien->nama_lengkap = $request->get('nama_lengkap');
        $pasien->tanggal_lahir = $request->get('tanggal_lahir');
        $pasien->jenis_kelamin = $request->get('jenis_kelamin');
        $pasien->email = $request->get('email');
        $pasien->password = $request->get('password');
        $pasien->salt = $request->get('salt');
        $pasien->phone_number = $request->get('phone_number');

        $pasien->created_at = now("Asia/Bangkok");
        $pasien->updated_at = now("Asia/Bangkok");

        $pasien->save();
        return redirect()->route('pasien.index')->with('status', 'New pasien is already inserted');

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
    public function edit(pasien $pasien)
    {
        $pasien = Pasien::find($pasien->id_pasien);
        return view('pasien.formcreate', ['pasien' => $pasien]);
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
        $pasien = new Pasien();
        $pasien->username = $request->get('username');
        $pasien->nama_lengkap = $request->get('nama_lengkap');
        $pasien->tanggal_lahir = $request->get('tanggal_lahir');
        $pasien->jenis_kelamin = $request->get('jenis_kelamin');
        $pasien->email = $request->get('email');
        $pasien->password = $request->get('password');
        $pasien->salt = $request->get('salt');
        $pasien->phone_number = $request->get('phone_number');

        $pasien->updated_at = now("Asia/Bangkok");

        $pasien->save();
        return redirect()->route('pasien.index')->with('status', 'Pasien is already updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(pasien $pasien)
    {
        $pasien = Pasien::find($pasien->id_pasien);
        $pasien->delete();
        return redirect()->route('pasien.index')->with('success', 'Pasien is already deleted');
    }
}
