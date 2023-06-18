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
        <input type="text" name="namaPasien" class="form-control" id="namaPasien" aria-describedby="nameHelp">
        <label for="exampleInputEmaill">Dokter</label>

        <div>
            <select class="form-select" aria-label="Default select example" name="namaDokter" id="namaDokter">
                <option>-- Pilih Dokter --</option>
                @foreach ($dokters as $dokter)
                <option value="{{ $dokter->id }}">{{$dokter->nama_lengkap}}</option>
                @endforeach
            </select>
        </div>

        <label for="exampleInputEmaill">Diagnosa</label>
        <div>
            <select class="form-select" aria-label="Default select example" name="diagnosa" id="diagnosa">
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
            <input type="number" name="totalBiaya" class="form-control" id="totalBiaya" aria-describedby="nameHelp"
                step="1000">
        </div>
        <button onclick="submit()" type="submit" class="btn btn-primary" style="margin-top: 20px;" id="submitt">Submit</button>
</form>
@endsection

@section('script')
<script type="text/javascript">
    var count = 0;
    $("#btnAddTindakan").click(function () {
        count++;
        $("#tindakan").append(
            '<div id="addTindakan" class=' + count +
            '><label>Jenis Tindakan</label><div><select class="form-select" aria-label="Default select example" name="jenisTindakan[]" id="jenisTindakan">' +
            '<option value="-">-- Pilih Jenis Tindakan --</option>@foreach ($jenisTindakans as $jenisTindakan)<option value="{{ $jenisTindakan->id }}">{{ $jenisTindakan->nama_tindakan }}</option>' +
            '@endforeach </select> </div><label for="exampleInputEmaill">Jumlah Tindakan</label><input type="number" name="jumlah[]" value="1" class="form-control" id="singkatan" aria-describedby="nameHelp">' +
            '<button type="submit" class="btn btn-danger" onclick="deletetindakan(' + count +
            ')">X</button></div>');
    });

    $("#submitt").click(function () {
        var selectElements = document.querySelectorAll('[name="jenisTindakan[]"]');
        var selectedOptions = [];

        selectElements.forEach(function (selectElement) {
            var selectedOption = Array.from(selectElement.selectedOptions).map(option => option.value);
            selectedOptions = selectedOptions.concat(selectedOption);
        });

        alert(selectedOptions);
    });

    function submit(id) {
        var selectElements = document.querySelectorAll('[name="jenisTindakan[]"]');
        var selectedOptions = [];

        selectElements.forEach(function (selectElement) {
            var selectedOption = Array.from(selectElement.selectedOptions).map(option => option.value);
            selectedOptions = selectedOptions.concat(selectedOption);
        });

        alert(selectedOptions);
    }

    function deletetindakan(id) {
        $("." + id).remove();
    }

</script>
@endsection
