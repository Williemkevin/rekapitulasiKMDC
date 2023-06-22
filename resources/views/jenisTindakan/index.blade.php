<style>
    #feeCalculator {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
        align-items: center;
        align-content: center;
        gap: 1em;
    }

</style>
@extends('layout.sneat')

@section('menu')
<div class="portlet-title">
    <div style="display: inline-block; margin: 15px; font-size: 25px; font-weight: bold;">
        List Tindakan
    </div>
    <div style="float: right; margin: 15px;">
        <a href="{{url('jenistindakan/create')}}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add</a>
    </div>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('jenistindakan.ubahpersentase') }}">
    @csrf
    <div id="feeCalculator">
        <div>
            <strong> Persentasi Pembagian Fee : </strong>
        </div>
        <div>
            Fee RSIA : <input type="number" style="width: 50px;" name="feersia" value={{$persentaseFee->feersia}}> %
        </div>
        <div>
            Fee Dokter : <input type="number" style="width: 50px;" name="feedokter" value={{$persentaseFee->feedokter}}> %
        </div>
        <div>
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </div>
</form>

@if (session('status'))
<div class="alert alert-success">{{session('status')}}</div>    
@elseif(session('failed'))
<div class="alert alert-danger">{{session('failed')}}</div>
@endif


<div style="margin: 20px; font-size: 20px;">
    <strong>List Jenis Tindakan Aktif</strong>
</div>
<table id="jenisTindakanAktif" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <td>Id</td>
            <td>Nama Tindakan</td>
            <td>Biaya Tindakan</td>
            <td>Biaya Bahan</td>
            @if(str_contains(Auth::user()->role, 'superadmin'))
                <td>Edit</td>
                <td>Action</td>
            @endif

        </tr>
    </thead>
    <tbody>
        @if (count($jenisTindakanAktif) == 0)
        <tr>
            <td class="text-center" colspan="8">Tidak ada Dokter yang terdata</td>
        </tr>
        @else
        @foreach ($jenisTindakanAktif as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->nama_tindakan }}</td>
            <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->biaya_tindakan) }}</td>
            <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->biaya_bahan)}}</td>
            @if(str_contains(Auth::user()->role, 'superadmin'))
                <td class="text-center"><a href="{{ route('jenistindakan.edit', $t->id) }}"
                        class="btn btn-sm btn-primary"><i class='bx bx-edit-alt'></i></a>
                </td>
                <td class="text-center"><button onclick="nonaktifkan({{ $t->id }})" class="btn btn-sm btn-danger"><i
                            class='bx bx-power-off'></i></button>
                </td>
            @endif
        </tr>
        @endforeach
        @endif
    </tbody>
</table>


<div style="margin: 20px; font-size: 20px;">
    <strong>List Jenis Tindakan Nonaktif</strong>
</div>
<table id="jenisTindakanNonaktif" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <td>Id</td>
            <td>Nama Tindakan</td>
            <td class="no-wrap">Biaya Tindakan</td>
            <td class="no-wrap">Biaya Bahan</td>
            @if(str_contains(Auth::user()->role, 'superadmin'))
                <td>Edit</td>
                <td>Action</td>
            @endif

        </tr>
    </thead>
    <tbody>
        @if (count($jenisTindakanNonAktif) == 0)
        <tr>
            <td class="text-center" colspan="8">Tidak ada Dokter yang terdata</td>
        </tr>
        @else
        @foreach ($jenisTindakanNonAktif as $t)
        <tr>
            <td>{{ $t->id }}</td>
            <td>{{ $t->nama_tindakan }}</td>
            <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->biaya_tindakan) }}</td>
            <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->biaya_bahan)}}</td>
            @if(str_contains(Auth::user()->role, 'superadmin'))
                <td class="text-center"><a href="{{ route('jenistindakan.edit', $t->id) }}"
                        class="btn btn-sm btn-primary"><i class='bx bx-edit-alt'></i></a>
                </td>
                <td class="text-center"><button onclick="aktifkan({{ $t->id }})" class="btn btn-sm btn-success"><i
                            class='bx bx-power-off'></i></button>
                </td>
            @endif
        </tr>
        @endforeach
        @endif
    </thead>
</table>
@endsection


@section('script')
<script>
    $(document).ready(function () {
        $('#jenisTindakanAktif').DataTable({
            "scrollX": true
        });
        $('#jenisTindakanNonaktif').DataTable({
            "scrollX": true
        });
    });

    function nonaktifkan(id) {
        $.ajax({
            type: 'POST',
            url: "{{ route('jenistindakan.nonaktifkan') }}",
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
            },
            success: function (data) {
                if (data['status'] == 'success') {
                    window.location.reload(true);
                }
            }
        });
    }

    function aktifkan(id) {
        $.ajax({
            type: 'POST',
            url: "{{ route('jenistindakan.aktifkan')}}",
            data: {
                '_token': '<?php echo csrf_token(); ?>',
                'id': id,
            },
            success: function (data) {
                if (data['status'] == 'success') {
                    window.location.reload(true);
                }
            }
        });
    }

</script>
@endsection
