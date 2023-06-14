<style>
    label{
        margin-top: 15px;
        margin-bottom: 10px;
        color: black;
    }
</style>
@extends('layout.sneat')

@section('menu')
<div class="portlet-title">
    <div style="display: inline-block; margin: 15px; font-size: 25px; font-weight: bold;">
        Add New Jenis Tindakan
    </div>
</div>
@endsection
@section('content')
<form method="POST" action="{{route('jenistindakan.store')}}">
    @csrf
    <div class="form-group">
        <label>Nama Tindakan</label>
        <input type="text" name="nama_tindakan" class="form-control" id="nama_tindakan" aria-describedby="nameHelp">

        <label>Biaya Tindakan</label>   
        <input type="number" name="biaya_tindakan" class="form-control" id="biaya_tindakan" aria-describedby="nameHelp" step="1000">
        
        <label>Biaya Bahan</label>
        <input type="number" name="biaya_bahan" class="form-control" id="biaya_bahan" aria-describedby="nameHelp" step="1000">
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Submit</button>
</form>

@endsection
