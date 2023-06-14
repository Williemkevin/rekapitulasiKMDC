<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Diagnosa;
use App\Models\Dokter;
use App\Models\JenisTindakan;
use App\Models\JenisTindakanPasien;
use App\Models\Pasien;
use App\Models\TindakanPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $pasien = new Pasien();
        $pasien->nama_lengkap = $request->get('namaPasien');
        $pasien->save();

        $tindakan = $request->get('jenisTindakan');
        $jumlah = $request->get('jumlah');

        if (empty($tindakan)) {
            return Redirect::back();
        } else {
            $i = 0;
            foreach ($tindakan as $t) {
                if ($t != '-') {
                    $tindakan = new JenisTindakanPasien();
                    $tindakan->pasien_id = $pasien->id;
                    $tindakan->jenis_tindakan_id = $t;
                    $tindakan->dokter_id = $request->get('namaDokter');
                    $tindakan->admin_id = 1;
                    $tindakan->tanggal_kunjungan = $request->get('tanggalKunjungan');
                    $tindakan->diagnosa_id = $request->get('diagnosa');
                    $tindakan->jumlah_tindakan = $jumlah[$i];
                    $tindakan->total_biaya = $request->get('totalBiaya');

                    $tindakan->created_at = now("Asia/Bangkok");
                    $tindakan->updated_at = now("Asia/Bangkok");
                    $tindakan->save();
                    $i++;
                }
            }
        }

        return redirect()->route('tindakanPasien.index')->with('status', 'New Tindakan is already inserted');
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
