<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            text-align: center;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            /* Ini membuat tulisan di tengah */
            vertical-align: middle;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .total-row {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
            align-content: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <img src="{{ $logo }}" class="logo" alt="Logo">
        <h2>{{ $profile['name'] }}</h2>
        <h4>Laporan Pemasukan & Pengeluaran</h4>
        <h4>{{ $mulai }} sampai {{ $selesai }}</h4>
    </div>

    <h3>Pemasukan</h3>
    <table class="table">
        <thead>

            <tr>
                <th class="text-center" rowspan="2">No</th>
                <th class="text-center" rowspan="2">Tanggal</th>
                <th rowspan="2">Kode Member</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Device</th>
                <th colspan="3">Total</th>
                <th rowspan="2">Total</th>
                <th rowspan="2">Karyawan</th>
                <th rowspan="2">Shift</th>
            </tr>
            <tr>
                <th>Device</th>
                <th>Makanan</th>
                <th>Minuman</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPemasukan = 0;
                $totalMakanan = 0;
                $totalMinuman = 0;
                $totalDevice = 0;
                $no = 1;

            @endphp
            @foreach ($pemasukans as $item)
                @php

                    $totalPemasukan += $item->total;
                    $totalMakanan += $item->total_makanan;
                    $totalMinuman += $item->total_minuman;
                    $totalDevice += $item->total_device;
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->kode_member }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->device->name }}</td>
                    <td>Rp {{ number_format($item->total_device, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_makanan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total_minuman, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->shift->name }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="8" style="text-align:right">Total Pemasukan:</td>
                <td colspan="1">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <h3>Pengeluaran</h3>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Harga</th>
                <th>Karyawan</th>
                <th>Shift</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPengeluaran = 0;
                $no = 1;
            @endphp
            @foreach ($pengeluarans as $item)
                @php $totalPengeluaran += $item->harga; @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->shift->name }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="3" style="text-align:right">Total Pengeluaran:</td>
                <td colspan="1">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

</body>

</html>
