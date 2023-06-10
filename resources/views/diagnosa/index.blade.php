@extends('layout.sneat')

@section('menu')
<div class="portlet-title">
    <div style="display: inline-block; margin: 15px; font-size: 25px; font-weight: bold;">
        List Diagnosa
    </div>
    <div style="float: right; margin: 15px;">
        <a href="{{url('diagnosa/create')}}" class="btn btn-success btn-sm">Add</a>
    </div>
</div>
@endsection

@section('content')
@if (session('status'))
<div class="alert alert-success">{{session('status')}}</div>
@endif


<div class="table-responsive text-nowrap">
    <div style="margin: 15px; font-size: 20px;">
        <strong>List Diagnosa Aktif</strong>
    </div>
    <table class="table">
        <tbody class="table-border-bottom-0">
            <tr>
                <td><strong>Id</strong></td>
                <td><strong>Kode Diagnosa</strong></td>
                <td><strong>Keterangan</strong></td>
                <td><strong>Edit</strong></td>
                <td><strong>Action</strong></td>
            </tr>
            @if (count($diagnosaAktif) == 0)
            <tr>
                <td class="text-center" colspan="8">Tidak ada Diagnosa yang terdata</td>
            </tr>
            @else
            @foreach ($diagnosaAktif as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->kode_diagnosa }}</td>
                <td>{{ $d->nama_diagnosa }}</td>
                <td class="text-center"><a href="{{ route('diagnosa.edit', $d->id) }}" class="btn btn-sm btn-primary"><i
                            class='bx bx-edit-alt'></i></a>
                </td>
                <td class="text-center"><button onclick="nonaktifkan({{ $d->id }})" class="btn btn-sm btn-danger"><i
                            class='bx bx-power-off'></i></button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>

<div class="table-responsive text-nowrap">
    <div style="margin: 15px; font-size: 20px;">
        <strong>List Diagnosa Nonaktif</strong>
    </div>
    <table class="table">
        <tbody class="table-border-bottom-0">
            <tr>
                <td><strong>Id</strong></td>
                <td><strong>Kode Diagnosa</strong></td>
                <td><strong>Keterangan</strong></td>
                <td><strong>Action</strong></td>
            </tr>
            @if (count($diagnosaNonAktif) == 0)
            <tr>
                <td class="text-center" colspan="8">Tidak ada Diagnosa yang terdata</td>
            </tr>
            @else
            @foreach ($diagnosaNonAktif as $d)
            <tr>
                <td>{{ $d->id }}</td>
                <td>{{ $d->kode_diagnosa }}</td>
                <td>{{ $d->nama_diagnosa }}</td>
                <td class="text-center"><a href="{{ route('diagnosa.edit', $d->id) }}" class="btn btn-sm btn-primary"><i
                            class='bx bx-edit-alt'></i></a>
                </td>
                <td class="text-center"><button onclick="aktifkan({{ $d->id }})" class="btn btn-sm btn-success"><i class='bx bx-power-off'></i></button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection

@section('script')
<script>
    function nonaktifkan(id) {
        $.ajax({
            type: 'POST',
            url: "{{ route('diagnosa.nonaktifkan') }}",
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
            url: "{{ route('diagnosa.aktifkan')}}",
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
