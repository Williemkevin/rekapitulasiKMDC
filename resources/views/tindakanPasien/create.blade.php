<style>
    label {
        margin-top: 15px;
        margin-bottom: 10px;
        color: black;
    }

    #addTindakan {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        align-content: center;
        gap: 1em;
        white-space: nowrap;
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
                <option value="{{ $diagnosa->id }}">{{ $diagnosa->kode_diagnosa }} - {{ $diagnosa->nama_diagnosa }}
                </option>
                @endforeach
            </select>
        </div>

        <label for="exampleInputEmaill">Tanggal Kunjungan</label>
        <input type="date" name="tanggalKunjungan" class="form-control" id="tanggalKunjungan"
            aria-describedby="nameHelp">
        <label>Tindakan</label>
        <div id="tindakan"></div>
        <input type="button" id="btnAddTindakan" value="Tambah Tindakan" style="width: 100%;" class="btn btn-primary">
        <div>
            <label for="exampleInputEmaill">Total Biaya</label>
            <input type="number" name="singkatan" class="form-control" id="singkatan" aria-describedby="nameHelp"
                step="1000">
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Submit</button>
</form>

@endsection

@section('script')
<script type="text/javascript">
    var count = 0;
    $("#btnAddTindakan").click(function () {
        count++;
        $("#tindakan").append(
            '<div id="addTindakan" class=' + count +
            '><label>Jenis Tindakan</label><div><select class="form-select" aria-label="Default select example" name="jenisTindakan" id="jenisTindakan">' +
            '<option>-- Pilih Jenis Tindakan --</option>@foreach ($jenisTindakans as $jenisTindakan)<option value="{{ $jenisTindakan->id }}">{{ $jenisTindakan->nama_tindakan }}</option>' +
            '@endforeach </select> </div><label for="exampleInputEmaill">Jumlah Tindakan</label><input type="number" name="singkatan" class="form-control" id="singkatan" aria-describedby="nameHelp">' +
            '<button type="submit" class="btn btn-danger" onclick="deletetindakan(' + count + ')">X</button></div>');
    });

    function deletetindakan(id) {
        $("." + id).remove();
    }

</script>
@endsection
