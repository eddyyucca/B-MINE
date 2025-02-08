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
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
    </style>
</head>
<body>
    <div class="profile-container">
        <img src="{{ $dataReq->foto_path }}" alt="Profile Photo" class="profile-photo">

        <div class="info-section">
            <div class="info-row">
                <div class="info-label">Nama:</div>
                <div>{{ $dataReq->nama }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Jabatan:</div>
                <div>{{ $dataReq->jab }}</div>
            </div>
            <!-- Tambahkan informasi lainnya sesuai kebutuhan -->
        </div>

        <div class="info-section">
            <h3>Access Area:</h3>
            @foreach($access as $area => $status)
                <div class="info-row">
                    <div class="info-label">{{ $area }}:</div>
                    <div>{{ $status === 'yes' ? '✓' : '✗' }}</div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
