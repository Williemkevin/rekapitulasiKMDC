<?php
use App\Models\Dokter;
?>
<style>
    tr{
        white-space: nowrap;
    }
</style>
@extends('layout.sneat')
@section('menu')
<div class="portlet-title">
    <div style="display: inline-block; margin: 15px; font-size: 25px; font-weight: bold;">
        List Rekap Pendapatan
    </div>
</div> 
@endsection

@section('content')
 
@if (session('status'))
<div class="alert alert-success">{{session('status')}}</div>
@endif
<div>
    <div style="float: left;">
        <label for="bulanan" style="float: left; margin-top: 7px; margin-right: 7px;">Bulanan:</label>
        <select class="form-select" aria-label="Default select example" name="bulan" id="bulan" style="width: 150px; margin-bottom: 10px;">
        <?php
        $selected = false;
        for ($year = 2023; $year <= date('Y'); $year++) {
            $endMonth = ($year == date('Y')) ? date('m') : 12;
            for ($month = 1; $month <= $endMonth; $month++) {
                $optionValue = sprintf('%02d-%04d', $month, $year);
                if (($month == request()->segment(2) && $year == request()->segment(3)) || ($month == date('m') && !$selected)) {
                    echo "<option value=\"$optionValue\" selected>" . date('F Y', strtotime("$year-$month-01")). "</option>";
                    $selected = true;
                } else {
                    echo "<option value=\"$optionValue\">" . date('F Y', strtotime("$year-$month-01")). "</option>";
                }
            }
          }
        ?>
        </select>
    </div>

    @if (str_contains(Auth::user()->role, 'superadmin') || str_contains(Auth::user()->role, 'admin'))
        <div style="float: left; margin-left: 10px;">
            <label for="bulanan" style="float: left; margin-top: 7px; margin-right: 7px;">Dokter:</label>
            <select class="form-select" aria-label="Default select example" name="dokter" id="dokter" style="width: 150px; margin-bottom: 10px;">
            <?php
                echo (request()->segment(4) == 0) ? '<option value="0" selected>All</option>' : '<option value="0">All</option>';
                foreach ($dokter as $d) {
                    if($d->id == request()->segment(4)) {
                        echo "<option value=\"$d->id\" selected>$d->nama_lengkap</option>";
                    }else{
                        echo "<option value=\"$d->id\">$d->nama_lengkap</option>";
                    }
                }
            ?> 
            </select>
        </div>
    @else
        @php
            $dokter = Dokter::where('user_id',Auth::user()->id)->first();
        @endphp
        <input type="hidden" value={{$dokter->id}} name="dokter" id="dokter">
    @endif

    <div style="float: right; margin-top: 7px; margin-right: 7px;" id="printContainer">
        <form action="{{url('print/feedokter')}}">
            <input type="hidden" value="{{$total[0]->totalTHPDokter}}" name="totalFeeDokter">
            <input type="hidden" value={{request()->segment(4)}}  name="idDokter">
            <input type="hidden" value={{request()->segment(2)}} name="bulan">
            <input type="hidden" value={{request()->segment(3)}} name="tahun">
            <button class="btn btn-info btn-sm"><i class="bx bx-printer"></i>Cetak</button>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table w-auto text-start">
        <tbody class="table-border-bottom-0">
            <tr style="white-space: nowrap;">
                <th>No</th>
                <th>Tahun</th>
                <th>Tanggal</th>
                <th>Dokter Gigi</th>
                <th>Nama Pasien</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Total</th>
                <th>BHP</th>
                <th>Sharing</th>
                <th>RSIA FEE</th>
                <th>Dokter FEE</th>
            </tr>
        </thead>
        <tbody>
            @if (count($dataTindakan) == 0)
            <tr>
                <td class="text-center" colspan="8">Tidak ada data tindakan yang terdata</td>
            </tr>
            @else
            @php
                $no = 1;
            @endphp
            @foreach ($dataTindakan as $dt)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $dt->tahun }}</td>
                <td>{{ $dt->tanggal_kunjungan }}</td>
                <td>{{ $dt->namaDokter }}</td>
                <td>{{ $dt->nama_lengkap }}</td>
                <td>{{ $dt->kode_diagnosa }}</td>
                <td>{{ $dt->nama_tindakan }}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($dt->total_biaya) }}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($dt->biaya_bahan) }}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($dt->Sharing) }}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($dt->FeeRSIA) }}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($dt->FeeDokter) }}</td>
            </tr> 
            @endforeach
            
            @foreach ($total as $t)
            <tr style="white-space: nowrap;">
                @for ($i = 0; $i < 7; $i++)
                    <td></td>
                @endfor
                <td><strong>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->totaltarif)}}</strong></td>
                <td><strong>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->totalBHP)}}</strong></td>
                <td><strong>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->totalSharing)}}</strong></td>
                <td><strong>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->totalRSIAFee)}}</strong></td>
                <td><strong>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->totalTHPDokter)}}</strong></td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('#tindakanPasien').DataTable();
    });
    $("#bulan, #dokter").on('change', function() {
        var bulanSelected = $("#bulan").val().split('-');
        var dokter = $("#dokter").val();
        window.location.href = '/rekapPendapatan/' + bulanSelected[0] + '/' + bulanSelected[1] + '/' + dokter;
    });
</script>
@endsection



