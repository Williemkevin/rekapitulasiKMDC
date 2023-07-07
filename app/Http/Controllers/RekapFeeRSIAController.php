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
            "jenis_tindakan_pasiens.jumlah_tindakan as jumlahTindakan",
            "jenis_tindakan_pasiens.nomor_rekam_medis as nomorRekamMedis",
            DB::raw("jenis_tindakan_pasiens.biaya_tindakan as tarif"),
            "jenis_tindakan_pasiens.biaya_bahan as BHP",
            DB::raw("CEILING(jenis_tindakan_pasiens.biaya_tindakan - jenis_tindakan_pasiens.biaya_bahan) AS sharing",),
            DB::raw("(0.3 * (jenis_tindakan_pasiens.biaya_tindakan - jenis_tindakan_pasiens.biaya_bahan)) as RSIAFee"),
            DB::raw("(0.7 * (jenis_tindakan_pasiens.biaya_tindakan - jenis_tindakan_pasiens.biaya_bahan)) as THPDRG")
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
                DB::raw('SUM(jenis_tindakan_pasiens.biaya_tindakan) AS total'),
                DB::raw('SUM(jenis_tindakan_pasiens.biaya_bahan) AS biaya_bahan'),
                DB::raw('SUM(jenis_tindakan_pasiens.biaya_tindakan - jenis_tindakan_pasiens.biaya_bahan) AS sharing'),
                DB::raw('SUM(0.3 * (jenis_tindakan_pasiens.biaya_tindakan - jenis_tindakan_pasiens.biaya_bahan)) AS rsia_fee'),
                DB::raw('SUM(0.7 * (jenis_tindakan_pasiens.biaya_tindakan - jenis_tindakan_pasiens.biaya_bahan)) AS dokter_fee')
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
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $namaPemimpin = DB::table('settings')->where('name', 'Nama pemimpin')->value('value');
        $namaPenerima = DB::table('settings')->where('name', 'Nama penerima Fee Rumah Sakit')->value('value');


        $mpdf = new Mpdf();
        $html = view('rekapFeeRSIA.pdf', compact('totalFee', 'terbilang', 'bulan', 'tahun', 'namaPemimpin', 'namaPenerima'))->render();
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
