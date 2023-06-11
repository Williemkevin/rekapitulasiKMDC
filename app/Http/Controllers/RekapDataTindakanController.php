<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapDataTindakanController extends Controller
{
    public function GetDataTindakan(Request $request)
    {
        // select *
        // from jenis_tindakan_pasien jtp inner join dokters d on d.id = jtp.dokter_id inner join pasiens p on p.id = jtp.pasien_id
        // inner join diagnosas dg on dg.id = jtp.diagnosa_id inner join jenis_tindakans jt on jt.id=jtp.jenis_tindakan_id
    }
}
