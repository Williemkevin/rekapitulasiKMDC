<?php

namespace App\Http\Controllers;

use App\Models\JenisTindakan;
use App\Models\JenisTindakanPasien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use Mpdf\Mpdf;
use PhpParser\Node\Stmt\Echo_;

class RekapFeeRSIAController extends Controller
{
    public function index($bulan = null, $tahun = null)
    {
        if ($bulan == null && $tahun == null) {
            $bulan = Carbon::now()->month;
            $tahun = Carbon::now()->year;
        }

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
            ->whereRaw("MONTH(tanggal_kunjungan) = $bulan")
            ->whereRaw("YEAR(tanggal_kunjungan) = $tahun")
            ->get();

        $total = JenisTindakanPasien::join('jenis_tindakans as jt', 'jt.id', '=', 'jenis_tindakan_pasiens.jenis_tindakan_id')
            ->select(
                DB::raw("SUM(jt.biaya_tindakan + jt.biaya_bahan) as totaltarif"),
                DB::raw("SUM(jt.biaya_bahan) as totalBHP"),
                DB::raw("SUM(jt.biaya_tindakan) as totalSharing"),
                DB::raw("SUM(0.3 * jt.biaya_tindakan) as totalRSIAFee"),
                DB::raw("SUM(0.7 * jt.biaya_tindakan + jt.biaya_bahan) as totalTHPDokter")
            )
            ->whereRaw("MONTH(tanggal_kunjungan) = $bulan")
            ->whereRaw("YEAR(tanggal_kunjungan) = $tahun")
            ->get();

        return view('rekapFeeRSIA.index', compact('rekapFeeRSIA', 'total'));
    }

    public function printPdf(Request $request)
    {
        $totalFee = $request->rekapFeeRSIA;
        $terbilang = $this->terbilang($totalFee);

        $mpdf = new Mpdf();
        $html = view('rekapFeeRSIA.pdf', compact('totalFee', 'terbilang'))->render();
        $mpdf->WriteHTML($html);
        $tanggal = date("dmY");
        $mpdf->Output($tanggal . 'kwitansiRSIA.pdf', 'D');
    }

    public function terbilang($angka)
    {
        $angka = abs($angka);
        $huruf = [
            "", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS"
        ];
        $terbilang = "";
        if ($angka < 12) {
            $terbilang = " " . $huruf[$angka];
        } elseif ($angka < 20) {
            $terbilang = $this->terbilang($angka - 10) . " BELAS";
        } elseif ($angka < 100) {
            $terbilang = $this->terbilang($angka / 10) . " PULUH" . $this->terbilang($angka % 10);
        } elseif ($angka < 200) {
            $terbilang = " SERATUS" . $this->terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $terbilang = $this->terbilang($angka / 100) . " RATUS" . $this->terbilang($angka % 100);
        } elseif ($angka < 2000) {
            $terbilang = " SERIBU" . $this->terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $terbilang = $this->terbilang($angka / 1000) . " RIBU" . $this->terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            $terbilang = $this->terbilang($angka / 1000000) . " JUTA" . $this->terbilang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            $terbilang = $this->terbilang($angka / 1000000000) . " MILYAR" . $this->terbilang(fmod($angka, 1000000000));
        } elseif ($angka < 1000000000000000) {
            $terbilang = $this->terbilang($angka / 1000000000000) . " TRILIUN" . $this->terbilang(fmod($angka, 1000000000000));
        }
        return $terbilang;
    }
}
