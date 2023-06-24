<!DOCTYPE html>
<html>
<head>
    <title>TANDA TERIMA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 400px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info span {
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 5px;
            text-align: left;
            border-bottom: 1px solid #000;
        }
        .table th {
            width: 40%;
        }
        .table td {
            width: 60%;
        }
        .signature {
            margin-top: 40px;
        }
        .signature div {
            width: 50%;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>KIDDIES & MOMS DENTAL CARE (KMDC)</h1>
            <h2>RSIA KENDANGSARI MERR SURABAYA</h2>
        </div>
        <div class="info">
            <p><span>TANDA TERIMA SHARED FEE RSIA KENDANGSARI MERR</span></p>
            <p>No Kwitansi: KMDC-JUN-001-RSIA</p>
            <p>Tanggal: 03 Juli 2022</p>
            <p>Penerima: PT. MERR MEDIKA MULIA</p>
        </div>
        <table class="table">
            <tr>
                <th>Nominal Total (Rp.)</th>
                <td>{{App\Http\Controllers\JenisTindakanController::rupiah($totalFee)}}</td>
            </tr>
            <tr>
                <th>Terbilang</th>
                <td>{{$terbilang}}</td>

            </tr>
        </table>
        <div class="signature">
            <div>
                <p>Yang Membayarkan,</p>
                <p>(Drg. Muthyah Ardhani, Sp.KGA)</p>
            </div>
            <div>
                <p>Penerima,</p>
                <p>(PT. MERR MEDIKA MULIA)</p>
            </div>
        </div>
    </div>
</body>
</html>
