@extends('layout.sneat')

@section('nama_menu')
<strong> List Doctor </strong>
@endsection

@section('content')
<div>
    <div>
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
    <div>
        <table class="table w-auto text-start">
<tr>
    <strong> List Doctor Nonaktif </strong>
</tr>
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
</div>
@endsection


@section('script')
    <script>
        function nonaktifkan(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('dokter.nonaktifkan') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                },
                success: function(data) {
                    if (data['status'] == 'success') {
                        window.location.reload(true);
                    }
                }
            });
        }

        function aktifkan(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('dokter.aktifkan') }}',
                data: {
                    '_token': '<?php echo csrf_token(); ?>',
                    'id': id,
                },
                success: function(data) {
                    if (data['status'] == 'success') {
                        window.location.reload(true);
                    }
                }
            });
        }
    </script>
@endsection





