<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $dataReq->nama }} - {{ $dataReq->nik }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminlte/img/logo-bmine.ico') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #f3f4f6;
            --text-color: #333;
            --border-color: #e5e7eb;
            --success-color: #10b981;
            --danger-color: #ef4444;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            color: var(--text-color);
            line-height: 1.6;
            padding: 20px;
        }

        .card {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .card-content {
            padding: 25px;
        }

        .profile-info {
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            margin-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 8px;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            width: 120px;
            flex-shrink: 0;
        }

        .info-value {
            flex: 1;
        }

        .section-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }

        .section {
            flex: 1;
            min-width: 250px;
            background-color: var(--secondary-color);
            border-radius: 8px;
            padding: 15px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 15px;
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
            padding-bottom: 8px;
        }

        .section-content table {
            width: 100%;
        }

        .section-content td {
            padding: 8px 4px;
        }

        .section-content tr:nth-child(even) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        .check-icon {
            color: var(--success-color);
            font-weight: bold;
        }

        .cross-icon {
            color: var(--danger-color);
        }

        .code-badge {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-family: monospace;
            letter-spacing: 1px;
        }

        .expiry-date {
            font-weight: 500;
        }

        .expiry-date.default {
            color: var(--text-color);
        }

        .expiry-date.near-expiry {
            color: #f39c12;
            /* Yellow/Orange */
        }

        .expiry-date.warning {
            color: #f39c12;
            /* Yellow/Orange, same as near-expiry */
            font-weight: bold;
        }

        .expiry-date.expired {
            color: var(--text-color);
            opacity: 0.5;
        }

        .verification-badge {
            background-color: var(--success-color);
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            margin-top: 20px;
            font-weight: 600;
        }

        .verification-badge i {
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .section-container {
                flex-direction: column;
            }

            .section {
                width: 100%;
            }

            .info-item {
                flex-direction: column;
            }

            .info-label {
                width: 100%;
                margin-bottom: 4px;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h2>Employee Profile</h2>
        </div>

        <!-- Added permit type indicator based on validation value -->
        @if (isset($dataReq->validasi_in))
            <div
                style="text-align: center; padding: 5px 10px; background-color: #f0f8ff; font-weight: bold; border-bottom: 1px solid #e1e1e1;">
                @if ($dataReq->validasi_in == 1)
                    <span style="color: #2563eb;">MinePermit</span>
                @elseif($dataReq->validasi_in == 2)
                    <span style="color: #2563eb;">Simper & MinePermit</span>
                @endif
            </div>
        @endif

        <!-- Mining Technical Head verification badge moved to top -->
        <div
            style="text-align: center; padding: 10px; background-color: var(--success-color); color: white; font-weight: 600; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-shield-alt" style="margin-right: 8px;"></i> Verified by all Mining Technical Heads
        </div>

        <div class="card-content">
            <div class="profile-info">
                <div class="info-item">
                    <div class="info-label">Name</div>
                    <div class="info-value">{{ $dataReq->nama }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Employee ID</div>
                    <div class="info-value">{{ $dataReq->nik }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Department</div>
                    <div class="info-value">{{ $dataReq->dept }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Position</div>
                    <div class="info-value">{{ $dataReq->jab }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Code</div>
                    <div class="info-value"><span class="code-badge">{{ $dataReq->kode }}</span></div>
                </div>
                <?php
                // Ensure expiry date data is available
                $expired_date = isset($dataReq->expiry_date) ? $dataReq->expiry_date : '';
                
                function determineExpiryStatus($expired_date)
                {
                    if (empty($expired_date)) {
                        return [
                            'date' => '-',
                            'status' => 'default',
                        ];
                    }
                
                    $expiry = new DateTime($expired_date);
                    $now = new DateTime();
                    $interval = $now->diff($expiry);
                
                    $status = 'default';
                    if ($interval->invert) {
                        // Date has already passed
                        $status = 'expired';
                    } elseif ($interval->days <= 90) {
                        // Within 3 months of expiry
                        $status = $interval->days <= 30 ? 'warning' : 'near-expiry';
                    }
                
                    $months = [
                        1 => 'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December',
                    ];
                
                    $formatted_date = $expiry->format('d') . ' ' . $months[(int) $expiry->format('m')] . ' ' . $expiry->format('Y');
                
                    return [
                        'date' => $formatted_date,
                        'status' => $status,
                    ];
                }
                ?>
                <?php
                $expiry_info = determineExpiryStatus($expired_date);
                ?>
                <div class="info-item">
                    <div class="info-label">Expiry</div>
                    <div class="info-value expiry-date {{ $expiry_info['status'] }}">
                        {{ $expiry_info['date'] }}
                    </div>
                </div>
            </div>

            <div class="section-container">
                <div class="section">
                    <div class="section-title">
                        <i class="fas fa-key"></i> ACCESS
                    </div>
                    <div class="section-content">
                        <table>
                            <tr>
                                <td>CHR BT</td>
                                <td>{!! $access['CHR-BT'] === 'yes'
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon"><i class="fas fa-times-circle"></i></span>' !!}</td>
                            </tr>
                            <tr>
                                <td>CHR FSP</td>
                                <td>{!! $access['CHR-FSP'] === 'yes'
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon"><i class="fas fa-times-circle"></i></span>' !!}</td>
                            </tr>
                            <tr>
                                <td>CP FSP</td>
                                <td>{!! $access['CP-FSP'] === 'yes'
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon"><i class="fas fa-times-circle"></i></span>' !!}</td>
                            </tr>
                            <tr>
                                <td>CP BT</td>
                                <td>{!! $access['CP-BT'] === 'yes'
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon"><i class="fas fa-times-circle"></i></span>' !!}</td>
                            </tr>
                            <tr>
                                <td>CP TA</td>
                                <td>{!! $access['CP-TA'] === 'yes'
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon"><i class="fas fa-times-circle"></i></span>' !!}</td>
                            </tr>
                            <tr>
                                <td>CP TJ</td>
                                <td>{!! $access['CP-TJ'] === 'yes'
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon"><i class="fas fa-times-circle"></i></span>' !!}</td>
                            </tr>
                            <tr>
                                <td>PIT BT</td>
                                <td>{!! $access['PIT-BT'] === 'yes'
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon"><i class="fas fa-times-circle"></i></span>' !!}</td>
                            </tr>
                            <tr>
                                <td>PIT TA</td>
                                <td>{!! $access['PIT-TA'] === 'yes'
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon"><i class="fas fa-times-circle"></i></span>' !!}</td>
                            </tr>
                            <tr>
                                <td>PIT TJ</td>
                                <td>{!! $access['PIT-TJ'] === 'yes'
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon"><i class="fas fa-times-circle"></i></span>' !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="section">
                    <div class="section-title">
                        <i class="fas fa-file-alt"></i> DOCUMENTS
                    </div>
                    <div class="section-content">
                        <table>
                            <tr>
                                <td>Medical Certificate</td>
                                <td>{!! !empty($dataReq->medical_path)
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon">-</span>' !!}</td>
                            </tr>
                            <tr>
                                <td>Driver's License</td>
                                <td>{!! !empty($dataReq->drivers_license_path)
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon">-</span>' !!}</td>
                            </tr>
                            <tr>
                                <td>Attachment</td>
                                <td>{!! !empty($dataReq->attachment_path)
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon">-</span>' !!}</td>
                            </tr>
                            <tr>
                                <td>SIO</td>
                                <td>{!! !empty($dataReq->sio_path)
                                    ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>'
                                    : '<span class="cross-icon">-</span>' !!}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Units Information section -->
            <div class="section" style="width: 100%; margin-top: 20px;">
                <div class="section-title">
                    <i class="fas fa-truck"></i> UNITS INFORMATION
                </div>
                <div class="section-content">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr>
                                <th
                                    style="width: 10%; background-color: var(--secondary-color); padding: 10px; text-align: center; border: 1px solid var(--border-color);">
                                    No</th>
                                <th
                                    style="width: 50%; background-color: var(--secondary-color); padding: 10px; text-align: left; border: 1px solid var(--border-color);">
                                    Unit Type</th>
                                <th
                                    style="background-color: #4CAF50; color: white; padding: 10px; text-align: center; border: 1px solid var(--border-color);">
                                    P</th>
                                <th
                                    style="background-color: #F44336; color: white; padding: 10px; text-align: center; border: 1px solid var(--border-color);">
                                    R</th>
                                <th
                                    style="background-color: #FFC107; color: white; padding: 10px; text-align: center; border: 1px solid var(--border-color);">
                                    T</th>
                                <th
                                    style="background-color: #2196F3; color: white; padding: 10px; text-align: center; border: 1px solid var(--border-color);">
                                    I</th>
                                <th
                                    style="background-color: #333333; color: white; padding: 10px; text-align: center; border: 1px solid var(--border-color);">
                                    O</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Check all possible data structures
                                $displayUnits = null;

                                // If units provided as a collection
                                if (isset($units) && !empty($units)) {
                                    if (method_exists($units, 'isEmpty') && !$units->isEmpty()) {
                                        $displayUnits = $units;
                                    }
                                }

                                // If chunk directly provided
                                if (isset($chunk) && !empty($chunk)) {
                                    if (method_exists($chunk, 'count') && $chunk->count() > 0) {
                                        $displayUnits = $chunk;
                                    }
                                }
                            @endphp

                            @if ($displayUnits)
                                @foreach ($displayUnits as $index => $unit)
                                    <tr>
                                        <td
                                            style="padding: 8px; text-align: center; border: 1px solid var(--border-color);">
                                            {{ $index + 1 }}</td>
                                        <td
                                            style="padding: 8px; text-align: left; border: 1px solid var(--border-color);">
                                            {{ $unit->unitData->nama_unit ?? 'No Data' }}</td>
                                        @php
                                            // Get type_unit value
                                            $typeUnitRaw = $unit->type_unit;

                                            // If typeUnitRaw is an array (maybe from Laravel casting)
                                            if (is_array($typeUnitRaw)) {
                                                // Process each array element to clean additional characters
                                                $typeUnit = [];
                                                foreach ($typeUnitRaw as $item) {
                                                    // Clean unwanted characters
                                                    $clean = trim($item, '"[]');
                                                    if (!empty($clean)) {
                                                        $typeUnit[] = $clean;
                                                    }
                                                }
                                            }
                                            // If typeUnitRaw is a JSON string
                                            elseif (is_string($typeUnitRaw) && strpos($typeUnitRaw, '[') === 0) {
                                                // Use regex to extract values in quotes
                                                preg_match_all('/"([^"]+)"/', $typeUnitRaw, $matches);
                                                $typeUnit = $matches[1] ?? [];
                                            }
                                            // If regular string (comma separated)
                                            elseif (is_string($typeUnitRaw)) {
                                                $typeUnit = explode(',', $typeUnitRaw);
                                            }
                                            // Default empty array
                                            else {
                                                $typeUnit = [];
                                            }
                                        @endphp

                                        <td
                                            style="padding: 8px; text-align: center; border: 1px solid var(--border-color);">
                                            {!! in_array('P', $typeUnit) ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>' : '-' !!}</td>
                                        <td
                                            style="padding: 8px; text-align: center; border: 1px solid var(--border-color);">
                                            {!! in_array('R', $typeUnit) ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>' : '-' !!}</td>
                                        <td
                                            style="padding: 8px; text-align: center; border: 1px solid var(--border-color);">
                                            {!! in_array('T', $typeUnit) ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>' : '-' !!}</td>
                                        <td
                                            style="padding: 8px; text-align: center; border: 1px solid var(--border-color);">
                                            {!! in_array('I', $typeUnit) ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>' : '-' !!}</td>
                                        <td
                                            style="padding: 8px; text-align: center; border: 1px solid var(--border-color);">
                                            {!! in_array('O', $typeUnit) ? '<span class="check-icon"><i class="fas fa-check-circle"></i></span>' : '-' !!}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7"
                                        style="padding: 15px; text-align: center; border: 1px solid var(--border-color);">
                                        No Data Available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer with hidden link -->
    <div
        style="text-align: center; margin-top: 20px; padding: 10px; font-size: 12px; color: #666; border-top: 1px solid #eee;">
        <p><strong>Copyright © 2025 <a href="https://www.linkedin.com/in/eddyyucca/"
                    style="color: inherit; text-decoration: none;">B'MINE</a></strong> All rights reserved.</p>
        <p><strong>Version 1.0.4</strong></p>
    </div>
</body>

</html>
