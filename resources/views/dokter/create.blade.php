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
        Add New Dokter
    </div>
</div>
@endsection
@section('content')
<form method="POST" action="{{route('dokter.store')}}">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmaill">Nama Lengkap</label>
        <input type="text" name="namaDokter" class="form-control" id="namaDokter" aria-describedby="nameHelp">

        <label for="exampleInputEmaill">Email</label>
        <input type="text" name="emailDokter" class="form-control" id="emailDokter" aria-describedby="nameHelp">

        <label for="exampleInputEmaill">username</label>
        <input type="text" name="usernameDokter" class="form-control" id="usernameDokter" aria-describedby="nameHelp">

        <label for="exampleInputEmaill">Password</label>
        <input type="password" name="password" class="form-control" id="password" aria-describedby="nameHelp">

        <label for="exampleInputEmaill">Singkatan</label>
        <input type="text" name="singkatan" class="form-control" id="singkatan" aria-describedby="nameHelp">
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Submit</button>
</form>
@endsection
