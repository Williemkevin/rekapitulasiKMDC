<?php

namespace App\Http\Controllers;

use App\Models\Dokter as ModelsDokter;
use App\Models\JenisTindakanPasien;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use Illuminate\Support\Str;
use App\Models\Dokter;

class RekapPendapatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($bulan = null, $tahun = null, $dokterSelected = 0)
    {
        if ($bulan == null && $tahun == null) {
            $bulan = Carbon::now()->month;
            $tahun = Carbon::now()->year;
        }

        $dokter = ModelsDokter::select('id', 'nama_lengkap', 'kode_nama_dokter')->where('status', "1")->get();
        $dataTindakan = DB::table('jenis_tindakan_pasiens AS jtp')
            ->selectRaw("YEAR(jtp.tanggal_kunjungan) AS tahun, DATE_FORMAT(jtp.tanggal_kunjungan, '%d %M %Y') as 'tanggal_kunjungan', d.kode_nama_dokter AS 'namaDokter', 
            p.nama_lengkap, dg.kode_diagnosa, jt.nama_tindakan, jtp.jumlah_tindakan as jumlahTindakan, jtp.biaya_tindakan AS total, jtp.biaya_bahan, CEILING(jtp.biaya_tindakan - jtp.biaya_bahan) AS Sharing, CEILING((jtp.biaya_tindakan - jtp.biaya_bahan) * (SELECT (feersia/100) FROM fees ORDER BY id DESC LIMIT 1)) AS FeeRSIA, CEILING((jtp.biaya_tindakan - jtp.biaya_bahan) * (SELECT (feedokter/100) FROM fees ORDER BY id DESC LIMIT 1)) AS FeeDokter")
            ->join('dokters AS d', 'd.id', '=', 'jtp.dokter_id')
            ->join('pasiens AS p', 'p.id', '=', 'jtp.pasien_id')
            ->join('diagnosas AS dg', 'dg.id', '=', 'jtp.diagnosa_id')
            ->join('jenis_tindakans AS jt', 'jt.id', '=', 'jtp.jenis_tindakan_id')
            ->where(function ($query) use ($dokterSelected) {
                if ($dokterSelected != 0) {
                    $query->where('jtp.dokter_id', $dokterSelected);
                }
            })
            ->whereRaw("MONTH(jtp.tanggal_kunjungan) = $bulan")
            ->whereRaw("YEAR(jtp.tanggal_kunjungan) = $tahun")
            ->get();
        $total = JenisTindakanPasien::join('jenis_tindakans as jt', 'jt.id', '=', 'jenis_tindakan_pasiens.jenis_tindakan_id')
            ->select(
                DB::raw("SUM(jt.biaya_tindakan + jt.biaya_bahan) as totaltarif"),
                DB::raw("SUM(jt.biaya_bahan) as totalBHP"),
                DB::raw("SUM(jt.biaya_tindakan) as totalSharing"),
                DB::raw("SUM(0.3 * jt.biaya_tindakan) as totalRSIAFee"),
                DB::raw("SUM(0.7 * jt.biaya_tindakan + jt.biaya_bahan) as totalTHPDokter")
            )
            ->where(function ($query) use ($dokterSelected) {
                if ($dokterSelected != 0) {
                    $query->where('dokter_id', $dokterSelected);
                }
            })
            ->whereRaw("MONTH(tanggal_kunjungan) = $bulan")
            ->whereRaw("YEAR(tanggal_kunjungan) = $tahun")
            ->get();
        return view('rekappendapatan.index', compact('dataTindakan', 'dokter', 'total'));
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
    public function printPdf(Request $request)
    {
        $totalFee = $request->totalFeeDokter;
        $dokterSelect = DB::table('dokters')->where('id', $request->idDokter)->first();
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $terbilang = $this->terbilang($totalFee);

        $mpdf = new Mpdf();
        $html = view('rekapPendapatan.pdf', compact('totalFee', 'terbilang', 'dokterSelect', 'bulan', 'tahun'))->render();
        $mpdf->WriteHTML($html);
        $tanggal = date("dmY");
        $mpdf->Output($tanggal . 'kwitansi' . Str::upper($dokterSelect->kode_nama_dokter) . '.pdf', 'D');
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
