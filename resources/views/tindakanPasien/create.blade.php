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
    #biayaTindakan, #jumlah{
        width: 100px;
    }

</style> 
@extends('layout.sneat')

@section('menu')
<div class="portlet-title">
    <div style="display: inline-block; margin: 15px; font-size: 25px; font-weight: bold;">
        Add New Tindakan
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
                step="1000" readonly>
        </div>
        <button onclick="submit()" type="submit" class="btn btn-primary" style="margin-top: 20px;" id="submitt">Submit</button>
</form>
@endsection

@section('script')
<script type="text/javascript">
    var jenisTindakans = <?php echo json_encode($jenisTindakans); ?>;
    var count = 0;

    var today = new Date();
    var formattedDate = today.toISOString().substr(0, 10);

    $("#tanggalKunjungan").val(formattedDate);

    $("#btnAddTindakan").click(function () {
        count++;
        $("#tindakan").append(
            '<div id="addTindakan" class=' + count +
            '><label>Jenis Tindakan</label><div><select class="form-select jenisTindakan' + count +'" aria-label="Default select example" name="jenisTindakan[]" id="jenisTindakan" onchange="getBiaya(' + count +')">' +
            '<option value="-">-- Pilih Jenis Tindakan --</option>@foreach ($jenisTindakans as $jenisTindakan)<option value="{{ $jenisTindakan->id }}">{{ $jenisTindakan->nama_tindakan }}</option>' +
            '@endforeach </select> </div><label for="exampleInputEmaill">Jumlah Tindakan</label><input type="number" name="jumlah[]" value="1" class="form-control jumlahTindakan' + count +'" id="jumlah" aria-describedby="nameHelp" onchange="getBiaya(' + count +')">' +
            '<label for="exampleInputEmaill">Biaya Tindakan</label><input type="number" name="biaya[]" value="0" class="form-control biayaTindakan' + count +'" id="biayaTindakan" aria-describedby="nameHelp" readonly>' +
            '<button type="submit" class="btn btn-danger" onclick="deletetindakan(' + count +')">X</button></div>');
    });

    $("#submitt").click(function () {
        var selectElements = document.querySelectorAll('[name="jenisTindakan[]"]');
        var selectedOptions = [];

        selectElements.forEach(function (selectElement) {
            var selectedOption = Array.from(selectElement.selectedOptions).map(option => option.value);
            selectedOptions = selectedOptions.concat(selectedOption);
        });
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

    function getBiaya(id) {
        var jenisTindakan = parseInt($(".jenisTindakan" + id).val());
        var jumlahTindakan = $(".jumlahTindakan" + id).val();

        var tindakan = Object.values(jenisTindakans).find(function(item) {
            return item.id === jenisTindakan;
        });
        var biayaTindakan = tindakan ? tindakan.biaya_tindakan : null;

        $(".biayaTindakan" + id).val(biayaTindakan*jumlahTindakan);
     
        var biaya = document.getElementsByName('biaya[]');
        var totalBiaya = 0;
        for (var i = 0; i < biaya.length; i++) {
            totalBiaya += parseInt(biaya[i].value);
        }
        $("#totalBiaya").val(totalBiaya);
    }
</script>
@endsection