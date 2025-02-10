<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <style>
        /* Desain ID Card */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .id-card {
            width: 350px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-photo {
            width: 155px;
            height: 155px;
            border-radius: 5px;
            object-fit: cover;
            display: block;
            margin: 0 auto;
            border: 2px solid #ddd;
        }

        .name,
        .position {
            margin-top: 10px;
            font-size: 18px;
            text-align: center;
        }

        .access-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
            margin-top: 20px;
            gap: 15px;
        }

        .access-table,
        .qrcode {
            width: 48%;
            border: 1px solid #ddd;
            /* Menambahkan border tipis */
            padding: 10px;
            /* Menambahkan padding */
            border-radius: 5px;
            /* Optional: membuat sudut border sedikit melengkung */
        }

        .access-table h4,
        .qrcode h4 {
            font-size: 16px;
            margin-bottom: 10px;
            margin-top: 0;
            text-align: center;
            /* Membuat text center */
        }

        .access-table table {
            width: 100%;
            /* Membuat tabel mengisi container */
            margin: 0 auto;
            /* Center tabel */
        }

        .access-table td {
            padding: 5px;
            font-size: 14px;
            text-align: left;
            /* Align text di tabel */
        }

        /* Style khusus untuk QR code */
        .qrcode {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qrcode svg {
            width: 140px;
            height: 159px;
        }

        /* CSS untuk tampilan print */
        @media print {
            body {
                margin: 0;
            }

            .id-card {
                page-break-before: always;
            }

            /* Pastikan tabel tampil dengan baik */
            /* .access-table {
                border: 1px solid #000;
                border-collapse: collapse;
                width: 100%;
            } */

            .access-table td,
            .access-table th {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: center;
            }

            .access-table th {
                background-color: #f2f2f2;
                font-weight: bold;
            }

            .access-table {
                align-items: center;
            }

            .qrcode {
                /* margin-top: 20px; */
                text-align: center;
            }
        }
    </style>
</head>

<body>
    dd($dataReq);
    <div class="id-card">
        <h3 class="mb-3">
            @if ($dataReq->validasi_in == 1)
                Simper & MinePermit
            @elseif ($dataReq->validasi_in == 2)
                MinePermit
            @else
                -
            @endif
        </h3>
        <!-- Foto Profil -->
        <img src="{{ $dataReq->foto_path }}" alt="Profile Photo" class="profile-photo">

        <!-- Nama dan Jabatan -->
        <div class="name">{{ $dataReq->nama }}</div>
        <div class="position">{{ $dataReq->jab }}</div>

        <!-- Akses dan QR Code di samping -->
        {{-- !-- Di bagian HTML, ubah struktur tabel access --> --}}
        <div class="access-container">
            <div class="access-table">
                <h4>ACCESS</h4>
                <table>
                    <tr>
                        <td>CHR BT</td>
                        <td>: {{ $access['CHR BT'] === 'yes' ? '✔' : '✘' }}</td>
                    </tr>
                    <tr>
                        <td>CHR FSB</td>
                        <td>: {{ $access['CHR FSB'] === 'yes' ? '✔' : '✘' }}</td>
                    </tr>
                    <tr>
                        <td>PIT BT</td>
                        <td>: {{ $access['PIT BT'] === 'yes' ? '✔' : '✘' }}</td>
                    </tr>
                    <tr>
                        <td>PIT TA</td>
                        <td>: {{ $access['PIT TA'] === 'yes' ? '✔' : '✘' }}</td>
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
