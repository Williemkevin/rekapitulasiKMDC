<style>
    tr{
        white-space: nowrap;
    }
</style>
@extends('layout.sneat')

@section('menu') 
<div class="portlet-title">
    <div style="display: inline-block; margin: 15px; font-size: 25px; font-weight: bold;">
        List Tindakan Pasien 
    </div>
    @if (str_contains(Auth::user()->role, 'superadmin') || str_contains(Auth::user()->role, 'admin'))
    <div style="float: right; margin: 15px;">
        <a href="{{url('tindakanPasien/create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add</a>
    </div>
    @endif
</div>
@endsection

@section('content')
 
@if (session('status'))
<div class="alert alert-success">{{session('status')}}</div>
@endif

<div style="margin: 15px; font-size: 20px;">
    <strong>List Tindakan Pasien</strong>
</div>

<div>
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
</div>
</select>

<div class="table-responsive">
    <table id="tindakanPasien" class="table table-striped" style="width:100%">
        <thead class="table-border-bottom-0">
            <tr>
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

    $("#bulan").on('change', function() {
        var bulanSelected = $("#bulan").val().split('-');
        window.location.href = '/tindakanPasien/' + bulanSelected[0] + '/' + bulanSelected[1] ;
    });
</script>

@endsection



