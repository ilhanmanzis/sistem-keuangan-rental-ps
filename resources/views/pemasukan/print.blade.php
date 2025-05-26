<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Struk {{ $profile['name'] }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 2px;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .mt {
            margin-top: 10px;
        }

        .logo {
            width: 50px;
            height: auto;
            margin-bottom: 5px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .name {
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="center">
        <img src="{{ $logo }}" alt="Logo" class="logo">
        <div class="name">{{ $profile['name'] }}</div>
        <div>{{ $profile['alamat'] ?? '' }}</div>
        <div>{{ $profile['no_telpon'] ?? '' }}</div>
    </div>

    <div class="line"></div>
    <table>
        <thead>
            <tr>
                <td colspan="3"><strong>Pelanggan</strong></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{ $transaksi['name'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Telepon</td>
                <td>:</td>
                <td>{{ $transaksi['no_telpon'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Member</td>
                <td>:</td>
                <td>{{ $transaksi['kode_member'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>{{ $transaksi['tanggal'] ?? '-' }}</td>
            </tr>

            @if (!empty($transaksi->device))
                <tr>
                    <td colspan="3">
                        <div class="line"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Sewa</strong></td>
                </tr>
                <tr>
                    <td>Device</td>
                    <td>:</td>
                    <td>{{ $transaksi->device->name ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Durasi</td>
                    <td>:</td>
                    <td>{{ $transaksi->durasi_jam ?? 0 }} jam</td>
                </tr>
                <tr>
                    <td>Bonus</td>
                    <td>:</td>
                    <td>{{ $transaksi->bonus_jam ?? 0 }} jam</td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td>:</td>
                    <td>Rp {{ number_format($transaksi->total_device, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>



    <table>
        @if (!empty($transaksi->makanans) && count($transaksi->makanans) > 0)
            <tr>
                <td colspan="5">
                    <div class="line"></div>
                </td>
            </tr>
            <div><strong>Makanan</strong></div>
            @foreach ($transaksi->makanans as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item->pivot->jumlah }}</td>
                    <td>x</td>
                    <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->pivot->total, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        @endif

        @if (!empty($transaksi->minumans) && count($transaksi->minumans) > 0)
            <tr>
                <td colspan="5">
                    <div class="line"></div>
                </td>
            </tr>
            <div><strong>Minuman</strong></div>
            @foreach ($transaksi->minumans as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item->pivot->jumlah }}</td>
                    <td>x</td>
                    <td>{{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->pivot->total, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        @endif

        <tr>
            <td colspan="5">
                <div class="line"></div>
            </td>
        </tr>
        <tr>
            <td colspan="3">Total Makanan</td>
            <td style="text-align: right;">:</td>
            <td style="text-align: right;">Rp {{ number_format($transaksi->total_makanan ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="3">Total Minuman</td>
            <td style="text-align: right;">:</td>
            <td style="text-align: right;">Rp {{ number_format($transaksi->total_minuman ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td colspan="5">

                <div class="line"></div>
            </td>
        </tr>
        <tr>
            <td colspan="3">Total</td>
            <td style="text-align: right;">:</td>
            <td style="text-align: right;">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</td>
        </tr>

    </table>



    <div class="bold">


    </div>

    <div class="line"></div>

    <div class="center">Terima kasih telah berkunjung!</div>
</body>

</html>
