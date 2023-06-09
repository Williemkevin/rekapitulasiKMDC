@extends('layout.sneat')

@section('nama_menu')
<strong>List Diagnosa</strong>
@endsection

@section('content')
<tr>
    <td><strong>Id</strong></td>
    <td><strong>Kode Diagnosa</strong></td>
    <td><strong>Keterangan</strong></td>
    <td><strong>Action</strong></td>
</tr>
@foreach ($diagnosa as $d)
<tr>
    <td>{{ $d->id }}</td>
    <td>{{ $d->kode_diagnosa }}</td>
    <td>{{ $d->nama_diagnosa }}</td>
    {{-- <td><span class="badge bg-label-primary me-1">Active</span></td> --}}
    <td>
        <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="bx bx-dots-vertical-rounded"></i>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a>
            </div>
        </div>
    </td>
</tr>
@endforeach

@endsection
