<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
        }

        .card {
            border: 1px solid #000;
            padding: 10px;
            width: 100%;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            width: 60px;
            height: auto;
        }

        .kode-member {
            margin-left: 10px;
        }

        .info-wrapper {
            margin-top: 10px;
            font-size: 12px;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
        }

        .line {
            border-top: 1px solid #000;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="card">
        <table>
            <tr>
                <td>
                    <img src="{{ $logo }}" alt="Logo" class="logo">
                </td>
                <td>
                    <div class="kode-member">
                        <h2>{{ $member['kode_member'] }}</h2>
                    </div>
                </td>
            </tr>
        </table>
        <!-- Info di bawahnya -->
        <div class="info-wrapper line">

            <table>
                <tr>
                    <td><span class="label">Nama</span></td>
                    <td>:</td>
                    <td>{{ $member['name'] }}</td>
                </tr>
                <tr>
                    <td><span class="label">Telp:</span></td>
                    <td>:</td>
                    <td>{{ $member['nomor_telpon'] }}</td>
                </tr>
            </table>

        </div>
    </div>
</body>

</html>
