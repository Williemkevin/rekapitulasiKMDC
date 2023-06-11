<?php

namespace App\Http\Controllers;

use App\Models\JenisTindakan;
use App\Models\JenisTindakanPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekapFeeRSIAController extends Controller
{
    public function index()
    {
        $rekapFeeRSIA = JenisTindakanPasien::select(
            DB::raw("MONTHNAME(tanggal_kunjungan) as bulan"),
            DB::raw("YEAR(tanggal_kunjungan) as tahun"),
            DB::raw("DATE_FORMAT(tanggal_kunjungan, '%d %M %Y') as tanggal"),
            "d.kode_nama_dokter as dokter",
            "p.nama_lengkap as pasien",
            "dig.kode_diagnosa as diagnosa",
            "jt.nama_tindakan as tindakan",
            DB::raw("(jt.biaya_tindakan + jt.biaya_bahan) as tarif"),
            "jt.biaya_bahan as BHP",
            "jt.biaya_tindakan as sharing",
            DB::raw("(0.3 * jt.biaya_tindakan) as RSIAFee"),
            DB::raw("(0.7 * jt.biaya_tindakan) + jt.biaya_bahan as THPDRG")
        )
            ->join('jenis_tindakans as jt', 'jt.id', '=', 'jenis_tindakan_pasiens.jenis_tindakan_id')
            ->join('dokters as d', 'd.id', '=', 'jenis_tindakan_pasiens.dokter_id')
            ->join('diagnosas as dig', 'dig.id', '=', 'jenis_tindakan_pasiens.diagnosa_id')
            ->join('pasiens as p', 'p.id', '=', 'jenis_tindakan_pasiens.pasien_id')
            ->get();

        $total = JenisTindakanPasien::join('jenis_tindakans as jt', 'jt.id', '=', 'jenis_tindakan_pasiens.jenis_tindakan_id')
            ->select(
                DB::raw("SUM(jt.biaya_tindakan + jt.biaya_bahan) as totaltarif"),
                DB::raw("SUM(jt.biaya_bahan) as totalBHP"),
                DB::raw("SUM(jt.biaya_tindakan) as totalSharing"),
                DB::raw("SUM(0.3 * jt.biaya_tindakan) as totalRSIAFee"),
                DB::raw("SUM(0.7 * jt.biaya_tindakan + jt.biaya_bahan) as totalTHPDokter")
            )
            ->get();

        return view('rekapFeeRSIA.index', compact('rekapFeeRSIA', 'total'));
    }
}
