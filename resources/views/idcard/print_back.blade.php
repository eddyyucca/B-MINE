<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card Units CR-80</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
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
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1mm;
            font-size: 5pt;
        }

        .details-table td {
            padding: 0.8mm;
            border: 0.2mm solid #ddd;
            line-height: 1.2;
        }

        .details-table td:first-child {
            width: 35%;
            font-weight: bold;
        }

        .checkbox-container {
            display: flex;
            gap: 2mm;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 1mm;
        }

        .circle-checkbox {
            width: 2.5mm;
            height: 2.5mm;
            border: 0.2mm solid #000;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            font-size: 4pt;
        }

        .unit-info {
            flex: 1;
            width: 100%;
            border: 0.2mm solid #ddd;
            border-radius: 1mm;
            padding: 1mm;
        }

        .unit-info h4 {
            margin: 0 0 1mm 0;
            text-align: center;
            font-size: 6pt;
        }

        .units-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 4.5pt;
        }

        .units-table th,
        .units-table td {
            padding: 0.5mm;
            border: 0.2mm solid #ddd;
            text-align: center;
        }

        .units-table th {
            font-weight: bold;
            color: black;
            /* Ubah ke warna hitam */
            background-color: #f5f5f5;
            /* Background default light gray */
        }

        /* Styling khusus untuk header PRTIO */
        .units-table th.colored-header {
            color: white !important;
        }

        .units-table td {
            vertical-align: middle;
        }

        .text-center {
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
            }

            .id-card {
                border: none;
                box-shadow: none;
                page-break-after: always;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .units-table th[data-color="green"] {
                background-color: #28a745 !important;
            }

            .units-table th[data-color="red"] {
                background-color: #dc3545 !important;
            }

            .units-table th[data-color="yellow"] {
                background-color: #f7f70e !important;
            }

            .units-table th[data-color="blue"] {
                background-color: #007bff !important;
            }

            .units-table th[data-color="dark"] {
                background-color: #343a40 !important;
            }
        }
    </style>
</head>

<body>
    <div class="print-container">
        @php
            $chunkedUnits = $units->isEmpty() ? [collect([])] : $units->chunk(8);
        @endphp

        @foreach ($chunkedUnits as $index => $chunk)
            <div class="id-card">
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
                        <td>NO SIMPER/MP</td>
                        <td>{{ $dataReq->kode ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>REFERENSI</td>
                        <td>
                            <div class="checkbox-container">
                                <div class="checkbox-item">
                                    <span>SIMPOL</span>
                                    <span class="circle-checkbox">{{ !empty($dataReq->medical_path) ? '✓' : '' }}</span>
                                </div>
                                <div class="checkbox-item">
                                    <span>SIO</span>
                                    <span class="circle-checkbox">{{ !empty($dataReq->sio_path) ? '✓' : '' }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="unit-info">
                    <h4>UNITS INFORMATION</h4>
                    <table class="units-table">
                        <thead>
                            <tr>
                                <th style="width: 12%; background-color: #f5f5f5;">No</th>
                                <th style="width: 40%; background-color: #f5f5f5;">Unit Type</th>
                                <th data-color="green" class="colored-header">P</th>
                                <th data-color="red">R</th>
                                <th data-color="yellow">T</th>
                                <th data-color="blue">I</th>
                                <th data-color="dark">O</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($chunk->count() > 0)
                                @foreach ($chunk as $unit)
                                    <tr>
                                        <td>{{ ($loop->parent->iteration - 1) * 8 + $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $unit->unitData->nama_unit ?? 'Data Kosong' }}
                                        </td>
                                        @php
                                            $typeUnit = !empty($unit->type_unit)
                                                ? (is_array($unit->type_unit)
                                                    ? $unit->type_unit
                                                    : explode(',', $unit->type_unit))
                                                : [];
                                        @endphp
                                        <td>{!! in_array('P', $typeUnit) ? '✓' : '-' !!}</td>
                                        <td>{!! in_array('R', $typeUnit) ? '✓' : '-' !!}</td>
                                        <td>{!! in_array('T', $typeUnit) ? '✓' : '-' !!}</td>
                                        <td>{!! in_array('I', $typeUnit) ? '✓' : '-' !!}</td>
                                        <td>{!! in_array('O', $typeUnit) ? '✓' : '-' !!}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">Data Kosong</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
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
