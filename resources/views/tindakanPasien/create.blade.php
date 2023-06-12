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
<form method="POST" action="{{route('tindakanPasien.store')}}">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmaill">Nama Pasien</label>
        <input type="text" name="namaDokter" class="form-control" id="namaDokter" aria-describedby="nameHelp">

        <label for="exampleInputEmaill">Jenis Tindakan</label>
        <input type="text" name="emailDokter" class="form-control" id="emailDokter" aria-describedby="nameHelp">

        <label for="exampleInputEmaill">Dokter</label>
        <div>
            <select class="form-select" aria-label="Default select example" name="categoryProduk" id="catProduk">
                <option>-- Pilih Dokter --</option>
                @foreach ($dokters as $dokter)
                <option value="{{ $dokter->id }}">{{$dokter->nama_lengkap}}</option>
                @endforeach
            </select>
        </div>


        <label for="exampleInputEmaill">Diagnosa</label>
        <div>
            <select class="form-select" aria-label="Default select example" name="categoryProduk" id="catProduk">
                <option>-- Pilih Diagnosa --</option>
                @foreach ($diagnosas as $diagnosa)
                <option value="{{ $diagnosa->id }}">{{ $diagnosa->kode_diagnosa }} - {{ $diagnosa->nama_diagnosa }}</option>
                @endforeach
            </select>
        </div>
        
        <label for="exampleInputEmaill">Tanggal Kunjungan</label>
        <input type="datetime-local" name="singkatan" class="form-control" id="singkatan" aria-describedby="nameHelp">

        <label for="exampleInputEmaill">Jumlah Tindakan</label>
        <input type="number" name="singkatan" class="form-control" id="singkatan" aria-describedby="nameHelp">

        <label for="exampleInputEmaill">Total Biaya</label>
        <input type="number" name="singkatan" class="form-control" id="singkatan" aria-describedby="nameHelp" step="1000">
    </div>
    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Submit</button>


</form>

@endsection

@section('script')
<script type="text/javascript">

 </script>
@endsection
