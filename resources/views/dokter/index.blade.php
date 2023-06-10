@extends('layout.sneat')

@section('menu')
<div class="portlet-title">
    <div style="display: inline-block; margin: 15px; font-size: 25px; font-weight: bold;">
        List Dokter
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

<div style="margin: 15px; font-size: 20px;">
    <strong>List Dokter Aktif</strong>
</div>
<div class="table-responsive text-nowrap">
    <table class="table">
        <tbody class="table-border-bottom-0">
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Singkatan</th>
                <th>Status</th>
                <th>Email</th>
                <th>Username</th>
                <th>Last Login</th>
                <th>Edit</th>
                <th>Non Aktifkan</th>
            </tr>
            @if (count($dokterAktif) == 0)
            <tr>
                <td class="text-center" colspan="8">Tidak ada Dokter yang terdata</td>
            </tr>
            @else
            @foreach ($dokterAktif as $dokterAktif)
            <tr>
                <td>{{ $dokterAktif->id }}</td>
                <td>{{ $dokterAktif->nama_lengkap }}</td>
                <td>{{ $dokterAktif->kode_nama_dokter }}</td>
                <td>{{ $dokterAktif->status }}</td>
                <td>{{ $dokterAktif->email }}</td>
                <td>{{ $dokterAktif->username }}</td>
                <td>{{ $dokterAktif->last_login }}</td>
                <td class="text-center"><a href="{{ route('dokter.edit', $dokterAktif->id) }}"
                        class="btn btn-sm btn-primary"><i class='bx bx-edit-alt'></i></a>
                </td>
                <td class="text-center"><button onclick="nonaktifkan({{ $dokterAktif->id }})"
                        class="btn btn-sm btn-danger"><i class='bx bx-power-off'></i></button>
                </td>
            </tr>
            @endforeach
            @endif
    </table>
</div>
<br><br>
<div>
    <div style="margin: 15px; font-size: 20px;">
        <strong>List Dokter Nonaktif</strong>
    </div>
    <table class="table w-auto text-start">
        <tr>
            <th>ID</th>
            <th>Nama Lengkap</th>
            <th>Singkatan</th>
            <th>Status</th>
            <th>Email</th>
            <th>Username</th>
            <th>Last Login</th>
            <th>Edit</th>
            <th>Aktifkan</th>
        </tr>
        @if (count($dokterNonaktif) == 0)
        <tr>
            <td class="text-center" colspan="8">Tidak ada Dokter yang terdata</td>
        </tr>
        @else
        @foreach ($dokterNonaktif as $dokterNonAktif)
        <tr>
            <td>{{ $dokterNonAktif->id }}</td>
            <td>{{ $dokterNonAktif->nama_lengkap }}</td>
            <td>{{ $dokterNonAktif->kode_nama_dokter }}</td>
            <td>{{ $dokterNonAktif->status }}</td>
            <td>{{ $dokterNonAktif->email }}</td>
            <td>{{ $dokterNonAktif->username }}</td>
            <td>{{ $dokterNonAktif->last_login }}</td>
            <td class="text-center"><a href="{{ route('dokter.edit', $dokterNonAktif->id) }}"
                    class="btn btn-sm btn-primary"><i class='bx bx-edit-alt'></i></a>
            </td>
            <td class="text-center"><button onclick="aktifkan({{ $dokterNonAktif->id }})"
                    class="btn btn-sm btn-success"><i class='bx bx-power-off'></i></button>
            </td>
        </tr>
        @endforeach
        @endif
    </table>
</div>
@endsection


@section('script')
<script>
    function nonaktifkan(id) {
        $.ajax({
            type: 'POST',
            url: "{{ route('dokter.nonaktifkan') }}",
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
            url: "{{ route('dokter.aktifkan')}}",
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
