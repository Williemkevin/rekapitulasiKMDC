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


@if (session('status'))
<div class="alert alert-success">{{session('status')}}</div>
@endif

<div style="margin: 15px; font-size: 20px;">
    <strong>List Jenis Tindakan Aktif</strong>
</div>
    <table class="table w-auto text-start">
        <tbody class="table-border-bottom-0">
            <tr>
                <td>Id</td>
                <td>Nama Tindakan</td>
                <td>Biaya Tindakan</td>
                <td>Biaya Bahan</td>
                <td>Edit</td>
                <td>Action</td>

            </tr>
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
                <td class="text-center"><a href="{{ route('jenistindakan.edit', $t->id) }}"
                    class="btn btn-sm btn-primary"><i class='bx bx-edit-alt'></i></a>
            </td>
            <td class="text-center"><button onclick="nonaktifkan({{ $t->id }})"
                    class="btn btn-sm btn-danger"><i class='bx bx-power-off'></i></button>
            </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    
<div style="margin: 15px; font-size: 20px;">
    <strong>List Jenis Tindakan Nonaktif</strong>
</div>
    <table class="table w-auto text-start">
        <tbody class="table-border-bottom-0">
            <tr>
                <td>Id</td>
                <td>Nama Tindakan</td>
                <td class="no-wrap">Biaya Tindakan</td>
                <td class="no-wrap">Biaya Bahan</td>
                <td>Edit</td>
                <td>Action</td>
            </tr>
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
                <td class="text-center"><a href="{{ route('jenistindakan.edit', $t->id) }}"
                    class="btn btn-sm btn-primary"><i class='bx bx-edit-alt'></i></a>
            </td>
            <td class="text-center"><button onclick="aktifkan({{ $t->id }})"
                class="btn btn-sm btn-success"><i class='bx bx-power-off'></i></button>
            </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
@endsection


@section('script')
<script>
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