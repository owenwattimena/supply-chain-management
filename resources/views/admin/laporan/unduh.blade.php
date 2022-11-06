<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pemesanan Bahan Baku</title>
    <style>
        .header {
            position: relative;
            width: 100%;
            border: 2px solid orange;
            height: 55px;
            margin-bottom: 55px;
        }

        .header .title {
            position: absolute;
            width: 59.5%;
            background: orange;
            display: inline-block;
            height: 55px;
        }

        .header .logo {
            position: absolute;
            left: 59.5%;
            height: 55px;
            width: 38.5%;
            display: inline-block;
            text-align: center;
        }

        .header h1 {
            font-size: 16pt;
            text-align: center;
        }

        .logo img {
            margin-top: 8px;
            height: 40px;
        }

        .info {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            font-size: 10pt;
        }

        .table tr,
        .table th,
        .table td {
            border: 1px solid black;

        }

        .footer {
            width: 100%;
            /* text-align: center; */
            position: fixed;
            bottom: 0px;
            font-size: 10pt;
        }

        .pagenum:before {
            content: counter(page);
        }

        .float-right {
            float: right;
        }
        .text-right{
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">
            <h1>LAPORAN PRODUKSI</h1>
        </div>
        <div class="logo">
            <img src="{{ asset('assets/images/wamin.png') }}" alt="logo-wamin">
        </div>
    </div>
    <table class="info">
        <tr>
            <td style="widtd:50%">Tanggal</td>
            <td> : {{ $from }} s/d {{ $to }}</td>
    </tr>
    </table>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Nomor Bahan Baku</th>
                <th>Nama Bahan Baku</th>
                <th>Spesefikasi</th>
                <th>Masuk</th>
                <th>Keluar</th>
                {{-- <th>Total</th> --}}
            </tr>
        </thead>
        <tbody>
            @php
            $no = 0;
            @endphp
            @foreach ($stock as $key => $item)
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $item->first()->rawMaterial->nomor_bahan_baku }}</td>
                <td>{{ $item->first()->rawMaterial->nama_bahan_baku }}</td>
                <td>{{ $item->first()->rawMaterial->spesifikasi }}</td>
                <td class="text-right">{{ $item->sum('kuantitas') }}</td>
                <td class="text-right">{{ 0 }}</td>
                {{-- <td>{{ $item->sum('kuantitas') }}</td> --}}
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
        Supply Chain Management System - Production Report <span class="float-right">Hal. <span class="pagenum"></span></span>
    </div>
</body>
</html>
