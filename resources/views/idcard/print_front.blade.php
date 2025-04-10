<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card CR-80 Vertical</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin-top: 20%;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f0f0f0;
        }

        .id-card {
            width: 54mm;
            height: 85.6mm;
            background: white;
            padding: 2mm;
            border: 0.2mm solid #ccc;
            border-radius: 2mm;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .card-header {
            font-size: 7pt;
            font-weight: bold;
            margin-bottom: 1mm;
            text-align: center;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .profile-photo {
            width: 20mm;
            height: 25mm;
            object-fit: cover;
            border: 0.2mm solid #ddd;
            border-radius: 1mm;
            margin: 1mm 0;
        }

        .name {
            font-size: 8pt;
            font-weight: bold;
            margin-top: 1mm;
            text-align: center;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .position {
            font-size: 7pt;
            margin-top: 0.5mm;
            text-align: center;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 1mm;
        }

        /* Layout untuk access dan QR code berdampingan */
        .access-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-top: 1mm;
            gap: 1mm;
        }

        .access-table {
            width: 48%;
        }

        .access-table h4,
        .qrcode h4 {
            font-size: 6pt;
            margin-bottom: 0.5mm;
            text-align: center;
            font-weight: bold;
        }

        .access-table table {
            width: 100%;
            font-size: 6pt;
            border-collapse: collapse;
        }

        .access-table td {
            padding: 0.3mm 0.5mm;
            line-height: 1.2;
            white-space: nowrap;
        }

        .qrcode {
            width: 17mm;
            height: 17mm;
            margin-top: 1mm;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qrcode svg {
            width: 17mm;
            height: 17mm;
            margin-top: 1mm;
        }

        .access-table td:last-child {
            text-align: center;
        }

        @media print {
            @page {
                size: 54mm 85.6mm;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                background: none;
            }

            .id-card {
                border: none;
                box-shadow: none;
                margin: 0;
                padding: 2mm;
                page-break-after: always;
            }

            * {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .qrcode svg {
                width: 17mm;
                height: 17mm;
            }
        }
    </style>
</head>

<body>
    <div class="id-card">
        <br>
        <br>

        <div class="card-header">
            @if ($dataReq->validasi_in == 1)
                Simper & MinePermit
            @elseif ($dataReq->validasi_in == 2)
                MinePermit
            @else
                -
            @endif
        </div>

        <img src="{{ str_replace('/storage/app/public', '/storage', $dataReq->foto_path) }}" alt="Profile Photo"
            class="profile-photo">
        <div class="name">{{ $dataReq->nama }}</div>
        <div class="position">{{ $dataReq->jab }}</div>

        <div class="access-container">
            <div class="access-table">
                <h4>ACCESS</h4>
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%; vertical-align: top;">
                            <table style="width: 100%;">
                                <tr>
                                    <td>CHR BT</td>
                                    <td>: {{ $access['CHR-BT'] === 'yes' ? '✔' : '✘' }}</td>
                                </tr>
                                <tr>
                                    <td>CHR FSP</td>
                                    <td>: {{ $access['CHR-FSP'] === 'yes' ? '✔' : '✘' }}</td>
                                </tr>
                                <tr>
                                    <td>CP BT</td>
                                    <td>: {{ $access['CP-BT'] === 'yes' ? '✔' : '✘' }}</td>
                                </tr>
                                <tr>
                                    <td>CP FSP</td>
                                    <td>: {{ $access['CP-FSP'] === 'yes' ? '✔' : '✘' }}</td>
                                </tr>
                                <tr>
                                    <td>CP TA</td>
                                    <td>: {{ $access['CP-TA'] === 'yes' ? '✔' : '✘' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 50%; vertical-align: top;">
                            <table style="width: 100%;">
                                <tr>
                                    <td>CP TJ</td>
                                    <td>: {{ $access['CP-TJ'] === 'yes' ? '✔' : '✘' }}</td>
                                </tr>
                                <tr>
                                    <td>PIT BT</td>
                                    <td>: {{ $access['PIT-BT'] === 'yes' ? '✔' : '✘' }}</td>
                                </tr>
                                <tr>
                                    <td>PIT TA</td>
                                    <td>: {{ $access['PIT-TA'] === 'yes' ? '✔' : '✘' }}</td>
                                </tr>
                                <tr>
                                    <td>PIT TJ</td>
                                    <td>: {{ $access['PIT-TJ'] === 'yes' ? '✔' : '✘' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="qrcode">
                <h4>SCAN ME</h4>
                {!! $qrcode !!}
            </div>
        </div>
    </div>

    <script>
        window.print();
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>
