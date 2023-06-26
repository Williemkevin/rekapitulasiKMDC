@extends('layout.sneat')

@section('menu')
<div class="portlet-title">
    <div style="display: inline-block; margin: 15px; font-size: 25px; font-weight: bold;">
        List Rekapan Fee RSIA
    </div>
    <div style="float: right; margin: 15px;">
        <a href="{{url('dokter/create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add</a>
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

    <div style="float: right; margin-top: 7px; margin-right: 7px;">
        <form action="{{url('print/feersia')}}">
            <input type="hidden" value="{{$total[0]->totalRSIAFee}}" name="rekapFeeRSIA">
            <button class="btn btn-info btn-sm"><i class="bx bx-printer"></i>Cetak</button>
        </form>
    </div>
</div>

<div class="table-responsive">
    <table class="table w-auto text-start">
        <tbody class="table-border-bottom-0">
            <tr style="white-space: nowrap;">
                <th>No</th>
                {{-- <th>Bulan</th>
                <th>Tahun</th> --}}
                <th>Tanggal</th>
                <th>Dokter</th>
                <th>Pasien</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Jumlah Tindakan</th>
                <th>Tarif</th>
                <th>Bahan Habis Pakai (BHP)</th>
                <th>Sharing</th>
                <th>RSIA Fee</th>
                <th>THP Dokter</th>
            </tr>
            @if (count($rekapFeeRSIA) == 0)
            <tr>
                <td class="text-center" colspan="8">Tidak ada yang terdata</td>
            </tr>
            @else
            @php
                $no = 1;
            @endphp
            @foreach ($rekapFeeRSIA as $rekapFee)
            <tr  style="white-space: nowrap;">

                <td>{{ $no++}}</td>
                {{-- <td>{{ $rekapFee->bulan }}</td>
                <td>{{ $rekapFee->tahun }}</td> --}}
                <td>{{ $rekapFee->tanggal }}</td>
                <td>{{ $rekapFee->dokter}}</td>
                <td>{{ $rekapFee->pasien}}</td>
                <td>{{ $rekapFee->diagnosa}}</td>
                <td>{{ $rekapFee->tindakan}}</td>
                <td>{{ $rekapFee->jumlahTindakan}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->tarif)}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->BHP)}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->sharing)}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->RSIAFee)}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->THPDRG)}}</td>
            </tr>
            @endforeach
            @foreach ($total as $t)
            <tr  style="white-space: nowrap;">
                @for ($i = 0; $i <= 5; $i++)
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
    </table>
</div>

@endsection

@section('script')
<script>
    $("#bulan").on('change', function() {
        var bulanSelected = $("#bulan").val().split('-');
        window.location.href = '/rekapfeersia/' + bulanSelected[0] + '/' + bulanSelected[1] ;
    });
</script>

@endsection

