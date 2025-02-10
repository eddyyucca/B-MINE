<!DOCTYPE html>
<html>

<head>
    <title>Data Karyawan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .profile-photo {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
            margin: 0 auto;
            display: block;
        }

        .info-section {
            margin-top: 20px;
        }

        .info-row {
            display: flex;
            margin: 10px 0;
        }

        .info-label {
            width: 150px;
            font-weight: bold;
        }

        .info-kode {
            width: 250px;
            font-weight: bold;
            margin-top: 50px;
            border-radius: 5px;
            margin: 2% auto;
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
    </style>
</head>

<body>
    <div class="profile-container">
        <img src="{{ $dataReq->foto_path }}" alt="Profile Photo" class="profile-photo">
        <div class="info-kode">
            <div>Code : {{ $dataReq->kode }}</div>
        </div>
        <div class="info-kode">
            <?php
            $date_req = $dataReq->date_req;
            $date = new DateTime($date_req);
            $date->modify('+1 year');
            $expired_date = $date->format('Y-m-d');
            
            // atau
            $date->modify('+12 months');
            $expired_date = $date->format('Y-m-d'); ?>
            <div>expired : {{ $expired_date }}</div>
        </div>
        <div class="info-section">
            <div class="info-row">
                <div class="info-label">Nama</div>
                <div>: {{ $dataReq->nama }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NIK</div>
                <div>: {{ $dataReq->nik }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Depertement</div>
                <div>: {{ $dataReq->dept }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jabatan</div>
                <div>: {{ $dataReq->jab }}</div>
            </div>
        </div>

        <div class="access-container">
            <div class="access-table">
                <h4>ACCESS</h4>
                <table>
                    <tr>
                        <td>CHR BT</td>
                        <td>: {{ $access['CHR BT'] === 'yes' ? '✓' : 'X' }}</td>
                    </tr>
                    <tr>
                        <td>CHR FSB</td>
                        <td>: {{ $access['CHR FSB'] === 'yes' ? '✓' : 'X' }}</td>
                    </tr>
                    <tr>
                        <td>PIT BT</td>
                        <td>: {{ $access['PIT BT'] === 'yes' ? '✓' : 'X' }}</td>
                    </tr>
                    <tr>
                        <td>PIT TA</td>
                        <td>: {{ $access['PIT TA'] === 'yes' ? '✓' : 'X' }}</td>
                    </tr>
                </table>
            </div>

            <div class="access-table">
                <h4>DOCUMENTS</h4>
                <table>
                    <tr>
                        <td>Medical Certificate</td>
                        <td>: {{ !empty($dataReq->medical_path) ? '✓' : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Driver's License</td>
                        <td>: {{ !empty($dataReq->drivers_license_path) ? '✓' : '' }}</td>
                    </tr>
                    <tr>
                        <td>Attachment</td>
                        <td>: {{ !empty($dataReq->attachment_path) ? '✓' : '' }}</td>
                    </tr>
                    <tr>
                        <td>SIO</td>
                        <td>: {{ !empty($dataReq->sio_path) ? '✓' : '' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
