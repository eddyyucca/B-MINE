<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <style>
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
            box-shadow: 0 0 10px rgba(191, 34, 34, 0.1);
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

        .company-info {
            text-align: center;
            margin: 10px 0;
        }

        .details-table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .details-table td:first-child {
            width: 40%;
            /* background-color: #f5f5f5; */
        }

        .unit-info {
            width: 100%;
            margin-top: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }

        .unit-info h4 {
            margin: 0 0 10px 0;
            text-align: center;
            font-size: 16px;
        }

        .details-table {
            width: 100%;
            font-size: 12px;
            border-collapse: collapse;
        }

        .details-table th,
        .details-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .details-table th {
            /* background-color: #f5f5f5; */
            font-weight: bold;
            text-align: center;
        }

        .details-table thead th:first-child,
        .details-table thead th:nth-child(2) {
            background-color: white;
            /* atau hapus background-color sama sekali */
        }

        .text-center {
            text-align: center;
        }

        .text-success {
            color: #28a745;
        }

        .fas.fa-check {
            font-size: 14px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        .details-table td:first-child {
            width: 40%;
            /* background-color: #f5f5f5; */
        }

        .checkbox-container {
            display: flex;
            gap: 20px;
            /* Menambah jarak antar item */
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .circle-checkbox {
            width: 16px;
            height: 16px;
            border: 1px solid #000;
            border-radius: 50%;
            /* Membuat lingkaran */
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            margin: 0 5px;
            /* Spacing kiri kanan */
        }

        .details-table th,
        .details-table td {
            padding: 6px;
            /* Mengurangi padding */
            border: 1px solid #ddd;
            font-size: 12px;
        }

        .details-table td {
            vertical-align: middle;
        }

        /* Style untuk tanda centang */
        .text-center {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
        }

        .ref-text {
            margin-right: 2px;
            /* Jarak antara teks dan checkbox */
        }

        @media print {

            /* Pastikan warna tetap ada saat print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            /* Specific colors for table headers */
            .details-table th[style*="background-color: #28a745"] {
                background-color: #28a745 !important;
                color: white !important;
            }

            .details-table th[style*="background-color: #f7f70e"] {
                background-color: #f7f70e !important;
                color: white !important;
            }

            .details-table th[style*="background-color: #dc3545"] {
                background-color: #dc3545 !important;
                color: white !important;
            }

            .details-table th[style*="background-color: #007bff"] {
                background-color: #007bff !important;
                color: white !important;
            }

            .details-table th[style*="background-color: #343a40"] {
                background-color: #343a40 !important;
                color: white !important;
            }

            body {
                margin: 0;
                padding: 0;
                display: block;
                /* Ubah dari flex ke block */
                height: auto;
                /* Hapus fixed height */
            }

            .page {
                display: block;
                page-break-after: always;
                margin-bottom: 0;
            }

            /* Halaman terakhir tidak perlu page break */
            .page:last-child {
                page-break-after: auto;
            }

            .id-card {
                width: 350px;
                margin: 0 auto;
                page-break-inside: avoid;
            }

            /* Pastikan konten tidak terpotong antar halaman */
            .unit-info {
                page-break-inside: avoid;
            }

            .details-table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    @php
        // Even if units is empty, we'll create one chunk to display the empty table
        $chunkedUnits = $units->isEmpty() ? [collect([])] : $units->chunk(10);
    @endphp
    <div class="print-container">
        @foreach ($chunkedUnits as $index => $chunk)
            <div class="page">
                <div class="id-card">
                    {{-- This section will always show, regardless of units data --}}
                    <table class="details-table">
                        <tr>
                            <td>PERUSAHAAN</td>
                            <td>BUMA</td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>{{ $dataReq->nik ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>NO SIMPER / MINE PERMIT</td>
                            <td>{{ $dataReq->kode ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td>REFERENSI</td>
                            <td>
                                <div class="checkbox-container">
                                    <div class="checkbox-item">
                                        <span class="ref-text">SIMPOL</span>
                                        <span
                                            class="circle-checkbox">{{ !empty($dataReq->medical_path) ? '✓' : '' }}</span>
                                    </div>
                                    <div class="checkbox-item">
                                        <span class="ref-text">SIO</span>
                                        <span class="circle-checkbox">{{ !empty($dataReq->sio_path) ? '✓' : '' }}</span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="unit-info">
                        <h4>UNITS INFORMATION</h4>
                        <table class="details-table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 30px;">No</th>
                                    <th style="width: 40%;">UNIT Type</th>
                                    <th class="text-center" style="width: 8%; background-color: #28a745; color: white;">
                                        P</th>
                                    <th class="text-center" style="width: 8%; background-color: #dc3545; color: white;">
                                        R</th>
                                    <th class="text-center" style="width: 8%; background-color: #f7f70e; color: white;">
                                        T</th>
                                    <th class="text-center" style="width: 8%; background-color: #007bff; color: white;">
                                        I</th>
                                    <th class="text-center" style="width: 8%; background-color: #343a40; color: white;">
                                        O</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($chunk->count() > 0)
                                    @foreach ($chunk as $unit)
                                        <tr>
                                            <td class="text-center" style="width: 10px;">
                                                {{ ($loop->parent->iteration - 1) * 10 + $loop->iteration }}
                                            </td>
                                            <td style="width: 55%;">{{ $unit->unitData->nama_unit ?? 'Data Kosong' }}
                                            </td>
                                            <td class="text-center" style="background-color: white !important;">
                                                @php
                                                    $typeUnit = !empty($unit->type_unit)
                                                        ? (is_array($unit->type_unit)
                                                            ? $unit->type_unit
                                                            : explode(',', $unit->type_unit))
                                                        : [];
                                                @endphp
                                                {!! in_array('P', $typeUnit) ? '✓' : '-' !!}
                                            </td>
                                            <td class="text-center" style="background-color: white !important;">
                                                {!! in_array('R', $typeUnit) ? '✓' : '-' !!}
                                            </td>
                                            <td class="text-center" style="background-color: white !important;">
                                                {!! in_array('T', $typeUnit) ? '✓' : '-' !!}
                                            </td>
                                            <td class="text-center" style="background-color: white !important;">
                                                {!! in_array('I', $typeUnit) ? '✓' : '-' !!}
                                            </td>
                                            <td class="text-center" style="background-color: white !important;">
                                                {!! in_array('O', $typeUnit) ? '✓' : '-' !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center"
                                            style="background-color: white !important;">Data Kosong</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        window.onload = function() {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        };
    </script>
</body>

</html>
