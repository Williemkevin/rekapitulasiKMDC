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
<div class="table-responsive">
    <table class="table w-auto text-start">
        <tbody class="table-border-bottom-0">
            <tr style="white-space: nowrap;">
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Tanggal</th>
                <th>Dokter</th>
                <th>Pasien</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
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
                <td>{{ $rekapFee->bulan }}</td>
                <td>{{ $rekapFee->tahun }}</td>
                <td>{{ $rekapFee->tanggal }}</td>
                <td>{{ $rekapFee->dokter}}</td>
                <td>{{ $rekapFee->pasien}}</td>
                <td>{{ $rekapFee->diagnosa}}</td>
                <td>{{ $rekapFee->tindakan}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->tarif)}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->BHP)}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->sharing)}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->RSIAFee)}}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($rekapFee->THPDRG)}}</td>
            </tr>
            @endforeach
            @foreach ($total as $t)
            <tr  style="white-space: nowrap;">
                @for ($i = 0; $i <= 7; $i++)
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