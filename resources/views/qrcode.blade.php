<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card - Front and Back Side by Side</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* Wrapper untuk mengatur card menjadi sejajar */
        .id-card-wrapper {
            display: flex;
            justify-content: center;
            gap: 20px;
            /* Jarak antar kartu */
            margin-top: 50px;
            /* Margin top untuk jarak di bagian atas */
        }

        .id-card {
            width: 5.4cm;
            /* Lebar 8.5 cm */
            height: 8.5cm;
            /* Tinggi 5.5 cm */
            border: 1px solid #000;
            padding: 10px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
        }

        .id-card .logo-left {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
        }

        .id-card .logo-right {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 50px;
            height: 50px;
        }

        .id-card .info {
            margin-top: 20px;
            flex-grow: 1;
        }

        .id-card .info h2,
        .id-card .info p {
            margin: 5px 0;
            font-size: 12px;
            /* Ukuran huruf lebih kecil untuk heading */
        }

        .id-card .barcode {
            margin-top: 10px;
            text-align: center;
        }

        /* Style untuk bagian belakang */
        /* Style untuk bagian belakang */
        .id-card-back {
            background-color: #f0f0f0;
            /* Warna background untuk membedakan sisi belakang */
        }

        /* Tabel keahlian */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            /* Ukuran huruf lebih kecil untuk heading */
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #dddddd;
        }
    </style>
</head>

<body>

    <!-- Wrapper untuk ID card depan dan belakang -->
    <div class="id-card-wrapper">
        <!-- Sisi Depan -->
        <div class="id-card">
            <!-- Logo kiri -->
            <img src="{{ asset('adminlte/img/logo_buma_tabang.png') }}" alt="Logo Kiri" class="logo-left">
            <!-- Logo kanan -->
            <img src="{{ asset('adminlte/img/logo_buma_tabang.png') }}" alt="Logo Kanan" class="logo-right">

            <!-- Informasi pengguna ID Card -->
            <div class="info">
                <h2>Nama Pengguna</h2>
                <p>NIK: 1234567890</p>
                <p>Jabatan: Manager</p>
                <p>Departemen: IT</p>
            </div>

            <!-- Barcode -->
            <div class="barcode">
                <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG(
                    'https://bmine.id/databases/jdkahdjsadksadsadasdhskadhasdkjasdhsadhsadaskdjksahdsakdhaduweqiywiqueiwqerbkjwedsahfhejEDGSXYUJQBWDASXYKFEWSDBJCBZXJHCBywehjbdsh',
                    'QRCODE',
                ) !!}" alt="qrcode"
                    style="width: 100px; height: 100px;" />
            </div>
        </div>

        <!-- Sisi Belakang -->
        <div class="id-card id-card-back">
            <!-- Informasi tambahan di sisi belakang -->
            <div class="info">
                <p><strong>Nama:</strong> Nama Pengguna</p>
                <p><strong>NIK:</strong> 1234567890</p>
                <p><strong>Kontak Darurat:</strong> +62 812-3456-7890</p>
                <p><strong>Alamat:</strong> Jl. Kebon Jeruk, Jakarta</p>
            </div>

            <!-- Logo atau informasi tambahan lainnya -->
            <div class="logo">
                <img src="{{ asset('adminlte/img/logo_buma_tabang.png') }}" alt="Logo Perusahaan" width="100px">
            </div>
        </div>
    </div>
    <div class="id-card-wrapper">
        <!-- Sisi Depan -->
        <div class="id-card">
            <!-- Logo kiri -->
            <img src="{{ asset('adminlte/img/logo_buma_tabang.png') }}" alt="Logo Kiri" class="logo-left">
            <!-- Logo kanan -->
            <img src="{{ asset('adminlte/img/logo_buma_tabang.png') }}" alt="Logo Kanan" class="logo-right">

            <!-- Informasi pengguna ID Card -->
            <div class="info">
                <h2>Nama Pengguna</h2>
                <p>NIK: 1234567890</p>
                <p>Jabatan: Manager</p>
                <p>Departemen: IT</p>
            </div>

            <!-- Barcode -->
            <div class="barcode">
                <img src="data:image/png;base64,{!! DNS2D::getBarcodePNG(
                    'https://bmine.id/databases/jdkahdjsadksadsadasdhskadhasdkjasdhsadhsadaskdjksahdsakdhaduweqiywiqueiwqerbkjwedsahfhejEDGSXYUJQBWDASXYKFEWSDBJCBZXJHCBywehjbdsh',
                    'QRCODE',
                ) !!}" alt="qrcode"
                    style="width: 100px; height: 100px;" />

            </div>
        </div>

        <!-- Sisi Belakang -->
        <div class="id-card id-card-back">
            <!-- Informasi tambahan di sisi belakang -->
            <div class="info">
                <p><strong>Nama:</strong> Nama Pengguna</p>
                <p><strong>NIK:</strong> 1234567890</p>
                <p><strong>Kontak Darurat:</strong> +62 812-3456-7890</p>
                <p><strong>Alamat:</strong> Jl. Kebon Jeruk, Jakarta</p>
            </div>

            <!-- Tabel Keahlian -->
            <div class="skills" border=1>
                <h3>Keahlian</h3>
                <table>
                    <tr>
                        <th>Keahlian</th>
                        <th>Level</th>
                    </tr>
                    <tr>
                        <td>Programming</td>
                        <td>Expert</td>
                    </tr>
                    <tr>
                        <td>Database Management</td>
                        <td>Advanced</td>
                    </tr>
                    <tr>
                        <td>Networking</td>
                        <td>Intermediate</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
