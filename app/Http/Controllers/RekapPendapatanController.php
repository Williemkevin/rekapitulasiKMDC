<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapPendapatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bulanSekarang = Carbon::now()->month;
        $dataTindakan = DB::table('jenis_tindakan_pasiens AS jtp')
            ->selectRaw("YEAR(jtp.tanggal_kunjungan) AS tahun, Date(jtp.tanggal_kunjungan) as 'tanggal_kunjungan', d.kode_nama_dokter AS 'namaDokter', p.nama_lengkap, dg.kode_diagnosa, jt.nama_tindakan, jtp.total_biaya, jtp.biaya_bahan, CEILING(jtp.biaya_tindakan - jtp.biaya_bahan) AS Sharing, CEILING((jtp.biaya_tindakan - jtp.biaya_bahan) * (SELECT (feersia/100) FROM fees ORDER BY id DESC LIMIT 1)) AS FeeRSIA, CEILING((jtp.biaya_tindakan - jtp.biaya_bahan) * (SELECT (feedokter/100) FROM fees ORDER BY id DESC LIMIT 1)) AS FeeDokter")
            ->join('dokters AS d', 'd.id', '=', 'jtp.dokter_id')
            ->join('pasiens AS p', 'p.id', '=', 'jtp.pasien_id')
            ->join('diagnosas AS dg', 'dg.id', '=', 'jtp.diagnosa_id')
            ->join('jenis_tindakans AS jt', 'jt.id', '=', 'jtp.jenis_tindakan_id')
            ->join('fees AS f', 'f.id', '=', 'jtp.fees_id')
            ->whereRaw("MONTH(jtp.tanggal_kunjungan) = $bulanSekarang")
            ->orderBy('jtp.id')
            ->get();
        return view('rekappendapatan.index', compact('dataTindakan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

    public static function getRekapPendapatan(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $dataTindakan = DB::table('jenis_tindakan_pasiens AS jtp')
            ->selectRaw("YEAR(jtp.tanggal_kunjungan) AS tahun, Date(jtp.tanggal_kunjungan) as 'tanggal_kunjungan', d.kode_nama_dokter AS 'namaDokter', p.nama_lengkap, dg.kode_diagnosa, jt.nama_tindakan, jtp.total_biaya, jtp.biaya_bahan, CEILING(jtp.biaya_tindakan - jtp.biaya_bahan) AS Sharing, CEILING((jtp.biaya_tindakan - jtp.biaya_bahan) * (SELECT (feersia/100) FROM fees ORDER BY id DESC LIMIT 1)) AS FeeRSIA, CEILING((jtp.biaya_tindakan - jtp.biaya_bahan) * (SELECT (feedokter/100) FROM fees ORDER BY id DESC LIMIT 1)) AS FeeDokter")
            ->join('dokters AS d', 'd.id', '=', 'jtp.dokter_id')
            ->join('pasiens AS p', 'p.id', '=', 'jtp.pasien_id')
            ->join('diagnosas AS dg', 'dg.id', '=', 'jtp.diagnosa_id')
            ->join('jenis_tindakans AS jt', 'jt.id', '=', 'jtp.jenis_tindakan_id')
            ->join('fees AS f', 'f.id', '=', 'jtp.fees_id')
            ->whereBetween('jtp.tanggal_kunjungan', [$start, $end])
            ->orderBy('jtp.id')
            ->get();
        return view('rekappendapatan.index', compact('dataTindakan'));
    }
}
