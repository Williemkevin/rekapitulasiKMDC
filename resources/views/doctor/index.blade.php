@extends('layout.sneat')

@section('nama_menu')
List Doctor
@endsection

@section('content')

<div class="portlet">
    <div class="portlet-body">
        <div class="scroller" style="height:200px" data-rail-visible="1" data-rail-color="yellow"
            data-handle-color="#a1b2bd">
            <table border="1" class="table table-bordered table-striped table-hoverd" >
                <tr>
                    <th>Nomor Pokok</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Tanggal Lahir</th>
                    <th>Agama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Nomor HP</th>
                    <th>Riwayat Pendidikan</th>
                    <th>Mulai bekerja</th>
                    <th>Last Login</th>
                    <th>Spesialis</th>
                </tr>
                @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->nomor_pokok_pegawai }}</td>
                    <td>{{ $employee->username }}</td>
                    <td>{{ $employee->nama_lengkap }}</td>
                    <td>{{ $employee->tanggal_lahir }}</td>
                    <td>{{ $employee->agama }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->alamat }}</td>
                    <td>{{ $employee->phone_number }}</td>
                    <td>{{ $employee->riwayat_pendidikan }}</td>
                    <td>{{ $employee->mulai_kerja }}</td>
                    <td>{{ $employee->last_login }}</td>
                    <td>{{ $employee->spesialis }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>

@endsection


