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

        .info{
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
        .float-right{
            float: right;
        }

    </style>
</head>
<body>
    <div class="header">
        <div class="title">
            <h1>PEMESANAN BAHAN BAKU</h1>
        </div>
        <div class="logo">
            <img src="{{ asset('assets/images/wamin.png') }}" alt="logo-wamin">
        </div>
    </div>
    <table class="info">
        <tr>
            <td style="widtd:50%">Tanggal Pesanan</td>
            <td> : {{ $pesanan->created_at }}</td>
        </tr>
        <tr>
            <td style="widtd:50%">Nomor Pesanan</td>
            <td> : {{ $pesanan->nomor_pesanan }}</td>
        </tr>
        <tr>
            <td>Nama Supplier</td>
            <td> : {{ $pesanan->supplier->name }}</td>
        </tr>
        @if ($pesanan->status == 'final')

        <tr>
            <td>Nomor Kendaraan</td>
            <td> : {{ $pesanan->penerimaanPesanan->nomor_kendaraan ?? '-' }}</td>
        </tr>
        <tr>
            <td>Nama Pengemudi</td>
            <td> : {{ $pesanan->penerimaanPesanan->nama_pengemudi ?? '-' }}</td>
        </tr>
        @endif
        <tr>
            <td>Status</td>
            <td> : <span class="badge">{{ $pesanan->status }}</span></td>
        </tr>
    </table>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Bahan Baku</th>
                <th>Nama Bahan Baku</th>
                <th>Spesifikasi</th>
                <th>Kuantitas</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
            $no = 0;
            $g_total = 0;
            @endphp
            @foreach ($pesanan->material as $item)
            <tr>
                <td style="text-align: center">{{ ++$no }}</td>
                <td>{{ $item->rawMaterial->nomor_bahan_baku }}</td>
                <td>{{ $item->rawMaterial->nama_bahan_baku }}</td>
                <td>{{ $item->rawMaterial->spesifikasi }}</td>
                <td>{{ $item->kuantitas }}</td>
                <td>{{ $item->rawMaterial->satuan->satuan }}</td>
                <?php $_harga = $item->rawMaterial->harga->first(); ?>
                <?php $harga = $_harga ? $_harga->harga_jual : 0; ?>
                <?php $total = $harga * $item->kuantitas; ?>
                <td>{{ $_harga ?'Rp. ' . number_format($_harga->harga_jual, 0, ',', '.') : '' }}</td>
                <td>Rp. {{ number_format($total, 0, ',', '.') }}</td>

            </tr>
            @php
            $g_total = $g_total + ($total);
            @endphp
            @endforeach
            <tr>
                <th colspan="7">GRAND TOTAL</th>
                <th>Rp. {{ number_format($g_total, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>
    <div class="footer">
        Supply Chain Management System - Purchase Order <span class="float-right">Hal. <span class="pagenum"></span></span>
    </div>
</body>
</html>
