<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Diagnosa;
use App\Models\Dokter;
use App\Models\Fee;
use App\Models\JenisTindakan;
use App\Models\JenisTindakanPasien;
use App\Models\Pasien;
use App\Models\TindakanPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class TindakanPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bulan = null, $tahun = null)
    {
        if ($bulan == null && $tahun == null) {
            $bulan = Carbon::now()->month;
            $tahun = Carbon::now()->year;
        }

        $dataTindakan = DB::table('jenis_tindakan_pasiens AS jtp')
            ->selectRaw("YEAR(jtp.tanggal_kunjungan) AS tahun, Date(jtp.tanggal_kunjungan) as 'tanggal_kunjungan', d.kode_nama_dokter AS 'namaDokter', 
                        p.nama_lengkap, dg.kode_diagnosa, jt.nama_tindakan,jtp.jumlah_tindakan as jumlahTindakan, jtp.biaya_tindakan AS total, jtp.biaya_bahan, CEILING(jtp.biaya_tindakan - jtp.biaya_bahan) AS Sharing, CEILING((jtp.biaya_tindakan - jtp.biaya_bahan) * (SELECT (feersia/100) FROM fees ORDER BY id DESC LIMIT 1)) AS FeeRSIA, CEILING((jtp.biaya_tindakan - jtp.biaya_bahan) * (SELECT (feedokter/100) FROM fees ORDER BY id DESC LIMIT 1)) AS FeeDokter")
            ->join('dokters AS d', 'd.id', '=', 'jtp.dokter_id')
            ->join('pasiens AS p', 'p.id', '=', 'jtp.pasien_id')
            ->join('diagnosas AS dg', 'dg.id', '=', 'jtp.diagnosa_id')
            ->join('jenis_tindakans AS jt', 'jt.id', '=', 'jtp.jenis_tindakan_id')
            ->join('fees AS f', 'f.id', '=', 'jtp.fees_id')
            ->whereRaw("MONTH(jtp.tanggal_kunjungan) = $bulan")
            ->whereRaw("YEAR(jtp.tanggal_kunjungan) = $tahun")
            ->orderBy('jtp.id')
            ->get();
        return view('tindakanPasien.index', compact('dataTindakan'));
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
        $idFee = Fee::orderBy('id', 'desc')->value('id');

        if (empty($tindakan)) {
            return Redirect::back();
        } else {
            $i = 0;
            foreach ($tindakan as $t) {
                if ($t != '-') {
                    $jenisTindakan = app(JenisTindakanController::class);

                    $tindakan = new JenisTindakanPasien();
                    $tindakan->pasien_id = $pasien->id;
                    $tindakan->jenis_tindakan_id = $t;
                    $tindakan->dokter_id = $request->get('namaDokter');
                    $tindakan->admin_id = 1;
                    $tindakan->tanggal_kunjungan = $request->get('tanggalKunjungan');
                    $tindakan->diagnosa_id = $request->get('diagnosa');
                    $tindakan->jumlah_tindakan = $jumlah[$i];
                    $tindakan->total_biaya = $request->get('totalBiaya');
                    $tindakan->fees_id = $idFee;

                    $biaya = $jenisTindakan->getBiaya($t);
                    $tindakan->biaya_tindakan = ($biaya->biaya_tindakan) * $jumlah[$i];
                    $tindakan->biaya_bahan = $biaya->biaya_bahan  * $jumlah[$i];

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
