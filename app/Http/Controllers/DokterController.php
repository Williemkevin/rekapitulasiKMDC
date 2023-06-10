<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokterAktif = Dokter::join('users', 'dokters.user_id', '=', 'users.id')
            ->select('dokters.*', 'users.*')
            ->where('status', '1')->get();
        $dokterNonaktif = Dokter::join('users', 'dokters.user_id', '=', 'users.id')
            ->select('dokters.*', 'users.*')
            ->where('status', '0')->get();

        return view('dokter.index', compact('dokterAktif', 'dokterNonaktif'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dokter.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->get('namaDokter');
        $user->email = $request->get('emailDokter');
        $user->username = $request->get('usernameDokter');
        $user->password = "MASIH DEFAULT";
        $user->role = "dokter";
        $user->last_login = now("Asia/Bangkok");
        $user->created_at = now("Asia/Bangkok");
        $user->updated_at = now("Asia/Bangkok");
        $user->save();

        $dokter = new Dokter();
        $dokter->kode_nama_dokter = $request->get('singkatan');
        $dokter->nama_lengkap = $request->get('namaDokter');
        $dokter->status = "1";
        $dokter->user_id = $user->id;
        $dokter->created_at = now("Asia/Bangkok");
        $dokter->updated_at = now("Asia/Bangkok");
        $user->dokter()->save($dokter);

        return redirect()->route('dokter.index')->with('status', 'New Dokter  ' .  $dokter->nama_lengkap . ' is already inserted');
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
        $dokter = Dokter::find($id);
        $user = User::find($dokter->user_id);
        return view('dokter.edit', compact('dokter', 'user'));
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
        $dokter = Dokter::find($id);
        $user = User::find($dokter->user_id);

        $user->name = $request->get('namaDokter');
        $user->email = $request->get('emailDokter');
        $user->username = $request->get('usernameDokter');
        $user->updated_at = now("Asia/Bangkok");
        $user->save();

        $dokter->kode_nama_dokter = $request->get('singkatan');
        $dokter->nama_lengkap = $request->get('namaDokter');
        $dokter->created_at = now("Asia/Bangkok");
        $dokter->updated_at = now("Asia/Bangkok");
        $user->dokter()->save($dokter);

        return redirect()->route('dokter.index')->with('status', 'Dokter ' .  $dokter->nama_lengkap . ' is already updated');
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
        $data = Dokter::find($request->get('id'));
        $data->status = '0';
        $data->save();
        return response()->json(array('status' => 'success'), 200);
    }

    public function aktifkan(Request $request)
    {
        $data = Dokter::find($request->get('id'));
        $data->status = '1';
        $data->save();
        return response()->json(array('status' => 'success'), 200);
    }
}
