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

<div class="table-responsive text-nowrap">
    <table class="table">
        <tbody class="table-border-bottom-0">
            <tr>
                <td>Id</td>
                <td>Nama Tindakan</td>
                <td>Biaya Tindakan</td>
                <td>Biaya Bahan</td>
                <td>Action</td>
            </tr>
            @foreach ($jenisTindakan as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->nama_tindakan }}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->biaya_tindakan) }}</td>
                <td>{{ App\Http\Controllers\JenisTindakanController::rupiah($t->biaya_bahan)}}</td>
                {{-- <td><span class="badge bg-label-primary me-1">Active</span></td> --}}
                <td>
                    <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('jenistindakan.edit', $t->id) }}"><i class="bx bx-edit-alt me-1"></i>
                                Edit</a>
                            <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                Delete</a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
