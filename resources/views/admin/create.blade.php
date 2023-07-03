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
        Add New Admin
    </div>
</div>
@endsection
@section('content')
<form method="POST" action="{{route('admin.store')}}">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmaill">Nama Lengkap</label>
        <input type="text" name="namaAdmin" class="form-control" id="namaAdmin" aria-describedby="nameHelp" required>

        <label for="exampleInputEmaill">Email</label>
        <input type="text" name="emailAdmin" class="form-control" id="emailAdmin" aria-describedby="nameHelp" required>

        <label for="exampleInputEmaill">username</label>
        <input type="text" name="usernameAdmin" class="form-control" id="usernameAdmin" aria-describedby="nameHelp" required>

        <label for="exampleInputEmaill">Password</label>
        <input type="text" name="password" class="form-control" id="password" aria-describedby="nameHelp" required>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Submit</button>
</form>

@endsection
