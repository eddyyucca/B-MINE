@extends('layouts.main')
<style>
    /* Gaya dasar untuk modal */
    .modal-xl {
        max-width: 95%;
    }

    /* Gaya untuk layout modal */
    .modal-body {
        display: flex;
        flex-direction: column;
    }

    /* Gaya untuk kartu ID */
    .id-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        height: 100%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
    }

    /* Gaya untuk informasi profil */
    .profile-info {
        text-align: center;
        padding: 15px;
        width: 100%;
    }

    .photo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin: 10px 0;
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

    /* Gaya untuk kontainer data */
    .data-container {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    /* Gaya untuk box data */
    .data-box {
        width: 100%;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        text-align: left;
    }

    .data-box h5 {
        font-size: 14px;
    }

    .data-box p {
        font-size: 12px;
    }

    /* Gaya untuk QR Code */
    #qrcode {
        margin-top: 10px;
    }

    /* Gaya untuk tabel */
    .table-responsive {
        overflow-x: auto;
    }

    .table-sm {
        font-size: 12px;
    }

    .table-sm th,
    .table-sm td {
        padding: 0.3rem;
    }

    /* Gaya untuk PDF viewer */
    .pdf-viewer {
        max-height: 90vh;
        overflow-y: auto;
        padding: 20px;
    }

    .document-section {
        margin-bottom: 20px;
    }

    .document-section h5 {
        margin-bottom: 10px;
    }

    .document-section.mb-4 {
        margin-bottom: 5rem !important;
    }

    .card {
        border: 7px solid #d1d3e2;
        box-shadow: 0 1.15rem 2.75rem 0 rgba(58, 59, 69, 0.15);
    }

    .card-header {
        border-bottom: 2px solid #d1d3e2;
        padding: 1rem;
    }

    .pdf-embed {
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 0 auto;
        display: block;
        width: 100%;
        height: 1000px;
        /* Ketinggian untuk desktop */
    }

    /* Gaya untuk checkbox kustom */
    .custom-checkbox {
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        font-size: 16px;
        user-select: none;
    }

    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .custom-control-label::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 25px;
        height: 25px;
        border: 2px solid #ddd;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    /* Style untuk Accept */
    #acceptCheck+.custom-control-label::before {
        border-color: #28a745;
    }

    #acceptCheck:checked+.custom-control-label::before {
        background-color: #28a745;
    }

    /* Style untuk Reject */
    #rejectCheck+.custom-control-label::before {
        border-color: #dc3545;
    }

    #rejectCheck:checked+.custom-control-label::before {
        background-color: #dc3545;
    }

    /* Label colors */
    #acceptCheck:checked+.custom-control-label {
        color: #28a745;
    }

    #rejectCheck:checked+.custom-control-label {
        color: #dc3545;
    }

    /* Responsif untuk perangkat kecil */
    @media (min-width: 768px) {
        .modal-body {
            flex-direction: row;
        }

        .id-cards-container {
            display: flex;
            flex-wrap: wrap;
        }

        .data-container {
            flex-direction: row;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .data-box {
            width: 48%;
        }
    }

    @media (max-width: 767px) {
        .modal-xl {
            max-width: 100%;
            margin: 0.5rem;
        }

        .pdf-viewer {
            padding: 10px;
        }

        .pdf-embed {
            height: 500px !important;
            /* Hanya ubah ketinggian pada layar kecil */
        }

        .profile-photo {
            width: 120px;
            height: 120px;
        }
    }

    /* Responsif untuk perangkat sangat kecil */
    @media (max-width: 575px) {
        .table-sm {
            font-size: 10px;
        }

        .pdf-embed {
            height: 300px !important;
        }

        .card {
            border-width: 4px;
        }

        .profile-photo {
            width: 100px;
            height: 100px;
        }

        .data-box {
            padding: 10px;
        }

        .custom-checkbox {
            font-size: 14px;
            padding-left: 30px;
        }

        .custom-control-label::before {
            width: 20px;
            height: 20px;
        }
    }
</style>
@section('content')
    {{-- content --}}
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Personal Task</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Personal Task</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Personal Task PJO</h3>
                        </div>
                        {{-- Success Alert --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- Error Alert --}}
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="card-body">
                            @if (!$dataReqs->isEmpty())
                                <div class="button-group">
                                    <button type="button" class="btn btn-success mb-2" id="allApprovalBtn">
                                        <i class="fas fa-check-double"></i> Approve All PJO
                                    </button>
                                </div>
                            @endif
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Request</th>
                                        <th class="no-export">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dataReqs->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">No data available</td>
                                        </tr>
                                    @else
                                        @foreach ($dataReqs as $index => $dataReq)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $dataReq->nik }}</td>
                                                <td
                                                    class="{{ !empty($dataReq->reject_history) ? 'bg-danger text-white' : '' }}">
                                                    {{ $dataReq->nama }}</td>
                                                <td>
                                                    @if ($dataReq->validasi_in == 2)
                                                        Simper & MinePermit
                                                    @elseif ($dataReq->validasi_in == 1)
                                                        MinePermit
                                                    @else
                                                        {{-- If there are other values or for default handling --}}
                                                        -
                                                    @endif
                                                </td>
                                                <td align="center" class="no-export">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" onclick="showPopup(this)"
                                                        data-photo="{{ $dataReq->foto_path }}"
                                                        data-medical="{{ $dataReq->medical_path }}"
                                                        data-license="{{ $dataReq->drivers_license_path }}"
                                                        data-sio="{{ $dataReq->sio_path }}"
                                                        data-attachment="{{ $dataReq->attachment_path }}"
                                                        data-name="{{ $dataReq->nama }}" data-nik="{{ $dataReq->nik }}"
                                                        data-jabatan="{{ $dataReq->jab }}"
                                                        data-departement="{{ $dataReq->dept }}"
                                                        data-kode="{{ $dataReq->kode }}"
                                                        data-units="{{ json_encode($dataReq->unitUsers) }}"
                                                        data-validasi_in="{{ $dataReq->validasi_in }}"
                                                        data-expiry_date="{{ $dataReq->expiry_date }}"
                                                        data-no_simpol="{{ $dataReq->no_simpol }}"
                                                        data-sim="{{ $dataReq->sim }}"
                                                        data-access="{{ json_encode($dataReq->access) }}">
                                                        View Submission Files <i class="fas fa-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->
    <div class="modal fade" id="popupModal" tabindex="-1" role="dialog" aria-labelledby="popupModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popupModalLabel">PDF Viewer & ID Card</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Kolom ID Card yang responsif - 4 kolom -->
                <div class="container-fluid">
                    <div class="row id-cards-container">
                        <!-- Profile Card -->
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                            <div class="id-card text-center">
                                <div id="idCardFront" class="id-card">
                                    <div class="profile-info">
                                        <h6 id="cardTitle">SIMPER & MINE PERMIT</h6>
                                        <div class="photo-container">
                                            <img id="profilePhoto" src="" alt="Profile Photo" class="profile-photo">
                                        </div>
                                        <h6 id="profileName"></h6>
                                        <p id="profileJabatan"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Access Card -->
                        <div class="col-lg-3 col-md-6 col-sm-6 mb-3">
                            <div class="id-card text-center">
                                <div class="container">
                                    <div class="data-container">
                                        <h5>Access</h5><br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-sm">
                                                <tr>
                                                    <td>CHR BT:</td>
                                                    <td style="text-align: center;"><span id="chrBT1"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>CHR FSP:</td>
                                                    <td style="text-align: center;"><span id="chrFSP1"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>CP FSP:</td>
                                                    <td style="text-align: center;"><span id="pitCPFSP1"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>CP BT:</td>
                                                    <td style="text-align: center;"><span id="pitCPBT1"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>CP TA:</td>
                                                    <td style="text-align: center;"><span id="pitCPTA1"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>CP TJ:</td>
                                                    <td style="text-align: center;"><span id="pitCPTJ1"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>PIT BT:</td>
                                                    <td style="text-align: center;"><span id="pitBT1"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>PIT TA:</td>
                                                    <td style="text-align: center;"><span id="pitTA1"></span></td>
                                                </tr>
                                                <tr>
                                                    <td>PIT TJ:</td>
                                                    <td style="text-align: center;"><span id="pitPITTJ1"></span></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Units Card -->
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                            <div class="id-card text-center">
                                <div class="container">
                                    <div class="data-container">
                                        <h5>Units</h5><br>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th>UNIT Type</th>
                                                        <th class="text-center">P</th>
                                                        <th class="text-center">R</th>
                                                        <th class="text-center">T</th>
                                                        <th class="text-center">I</th>
                                                        <th class="text-center">O</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="unitTableBody">
                                                    <!-- Data akan diisi secara dinamis -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Fourth Card (Empty or for additional info) -->
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                            <div class="id-card">
                                <div class="container">
                                    <div class="data-container text-left">
                                        <h5 class="mb-3">Additional Info</h5>
                                        <div class="sim-info">
                                            <p class="mb-2">SIM: <span id="profilesim"></span></p>
                                            <p class="mb-2">No SIM: <span id="profilesimpol"></span></p>
                                            <p class="mb-2">Expired Date: <span id="profileexpiry_date"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom PDF Viewer dengan 12 kolom penuh -->
                <div class="container-fluid mt-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="pdf-viewer">
                                <div class="document-section mb-4">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="text-center mb-0">Medical Certificate</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <embed id="attachment1" src="" type="application/pdf"
                                                style="width: 100%; height: 1000px;" class="pdf-embed">
                                        </div>
                                    </div>
                                </div>

                                <div class="document-section mb-4">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="text-center mb-0">Attachment</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <embed id="attachment3" src="" type="application/pdf"
                                                style="width: 100%; height: 1000px;" class="pdf-embed">
                                        </div>
                                    </div>
                                </div>

                                <div class="document-section mb-4">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="text-center mb-0">Driver's License</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <embed id="attachment2" src="" type="application/pdf"
                                                style="width: 100%; height: 1000px;" class="pdf-embed">
                                        </div>
                                    </div>
                                </div>

                                <div class="document-section mb-2">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="text-center mb-0">SIO Attachment</h5>
                                        </div>
                                        <div class="card-body p-0">
                                            <embed id="attachment4" src="" type="application/pdf"
                                                style="width: 100%; height: 1000px;" class="pdf-embed">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                @if (!$dataReqs->isEmpty())
                                    <div class="container">
                                        <div class="text-start">
                                            <h5 class="mb-3 mt-2">Approval</h5>
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-success"
                                                    onclick="approveRequest('accept')">
                                                    <i class="fas fa-check"></i> Accept
                                                </button>
                                                <button type="button" class="btn btn-danger"
                                                    onclick="approveRequest('reject')">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Reject Reason -->
    <div class="modal fade" id="rejectReasonModal" tabindex="-1" role="dialog"
        aria-labelledby="rejectReasonModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectReasonModalLabel">Alasan Penolakan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    <input type="hidden" name="kode" id="rejectKode">
                    <div class="form-group">
                        <textarea class="form-control" id="rejectReason" name="reason" rows="10" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-times"></i> Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- CSS Animasi -->
    <style>
        .not-found-animate {
            animation: fadeInAndOut 3s ease-in-out infinite;
        }

        @keyframes fadeInAndOut {

            0%,
            100% {
                opacity: 0;
                transform: scale(0.9);
            }

            50% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
    <script>
        // Function untuk memperbaiki path agar bisa diakses
        function fixStoragePath(path) {
            if (!path) return '';

            console.log("Path asli:", path);

            // Perbaiki path yang mengandung /storage/app/public/
            if (path.includes('/storage/app/public/')) {
                path = path.replace('/storage/app/public/', '/storage/');
            }

            // Perbaiki path yang mengandung storage/app/public/
            if (path.includes('storage/app/public/')) {
                path = path.replace('storage/app/public/', '/storage/');
            }

            // Jika path tidak dimulai dengan / atau http, tambahkan /
            if (!path.startsWith('/') && !path.startsWith('http')) {
                path = '/' + path;
            }

            console.log("Path hasil:", path);
            return path;
        }

        // Function untuk melihat dokumen di tab baru
        function viewDocument(doc) {
            const fixedPath = fixStoragePath(doc);
            window.open(fixedPath, '_blank');
        }

        // Function untuk membuka PDF dalam popup
        function openPdf(nik) {
            const url = '{{ url('karyawan') }}/' + nik + '/idcard-pdf';
            const popup = window.open(url, 'ID Card', 'width=600,height=400');
            popup.focus();
        }

        // Function untuk menampilkan modal popup dengan data
        function showPopup(button) {
            $('#popupModal').modal('show');

            // Ambil data dari atribut
            let photoPath = button.getAttribute('data-photo');
            let medicalUrl = button.getAttribute('data-medical');
            let licenseUrl = button.getAttribute('data-license');
            let attachmentUrl = button.getAttribute('data-attachment');
            let sioUrl = button.getAttribute('data-sio');
            const name = button.getAttribute('data-name');
            const nik = button.getAttribute('data-nik');
            const jabatan = button.getAttribute('data-jabatan');
            const departement = button.getAttribute('data-departement');
            const kode = button.getAttribute('data-kode');
            const validasi_in = button.getAttribute('data-validasi_in');

            // tambahan
            const no_simpol = button.getAttribute('data-no_simpol');
            const expiry_date = button.getAttribute('data-expiry_date');
            const simData = JSON.parse(button.getAttribute('data-sim'));

            // Set informasi profil
            document.getElementById('profileName').textContent = name || '';
            document.getElementById('profileJabatan').textContent = jabatan || '';

            // Tambahan
            document.getElementById("profilesim").textContent = simData.join(' - ') || "-";
            document.getElementById("profilesimpol").textContent = no_simpol || "-";
            document.getElementById("profileexpiry_date").textContent = expiry_date || "-";
            // Parse JSON untuk access dan units
            let access = {};
            try {
                access = JSON.parse(button.getAttribute('data-access') || '{}');
            } catch (e) {
                console.error('Error parsing access JSON:', e);
            }

            let units = [];
            try {
                units = JSON.parse(button.getAttribute('data-units') || '[]');
            } catch (e) {
                console.error('Error parsing units JSON:', e);
            }

            // Perbaiki semua path yang diterima
            photoPath = fixStoragePath(photoPath);
            medicalUrl = fixStoragePath(medicalUrl);
            licenseUrl = fixStoragePath(licenseUrl);
            attachmentUrl = fixStoragePath(attachmentUrl);
            sioUrl = fixStoragePath(sioUrl);

            // Log path setelah diperbaiki
            console.log("Paths setelah diperbaiki:");
            console.log("Photo:", photoPath);
            console.log("Medical:", medicalUrl);
            console.log("License:", licenseUrl);
            console.log("Attachment:", attachmentUrl);
            console.log("SIO:", sioUrl);

            // Tambahkan kode aktif ke modal
            $('#popupModal').attr('data-active-kode', kode);

            // Atur judul kartu berdasarkan nilai validasi_in
            const cardTitle = document.getElementById('cardTitle');
            console.log('Elemen cardTitle:', cardTitle); // Debugging - cek elemen ditemukan atau tidak

            if (cardTitle) { // Pastikan elemen ditemukan
                if (validasi_in == 1) {
                    cardTitle.textContent = "MINE PERMIT";
                } else if (validasi_in == 2) {
                    cardTitle.textContent = "SIMPER & MINE PERMIT";
                } else {
                    cardTitle.textContent = "ID CARD"; // Default jika nilai tidak dikenali
                }
            } else {
                console.error('Elemen dengan ID "cardTitle" tidak ditemukan');
            }

            // Update unit table
            const unitTableBody = document.getElementById('unitTableBody');
            unitTableBody.innerHTML = '';

            if (units && units.length > 0) {
                units.forEach((unit, index) => {
                    if (unit.id_uur === kode) {
                        const row = document.createElement('tr');

                        // Parse type_unit jika dalam format JSON string
                        let typeUnit = unit.type_unit;
                        try {
                            if (typeof typeUnit === 'string') {
                                typeUnit = JSON.parse(typeUnit.replace(/\\/g, ''));
                            }
                        } catch (e) {
                            console.error("Error parsing type_unit:", e);
                            typeUnit = [];
                        }

                        // Buat array jika tidak ada
                        if (!Array.isArray(typeUnit)) {
                            typeUnit = [];
                        }

                        row.innerHTML = `
                    <td class="text-center">${index + 1}</td>
                    <td>${unit.unit_data ? unit.unit_data.nama_unit : 'N/A'}</td>
                    <td class="text-center">${typeUnit.includes('P') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                    <td class="text-center">${typeUnit.includes('R') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                    <td class="text-center">${typeUnit.includes('T') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                    <td class="text-center">${typeUnit.includes('I') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                    <td class="text-center">${typeUnit.includes('O') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                `;
                        unitTableBody.appendChild(row);
                    }
                });
            }

            if (unitTableBody.children.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="7" class="text-center">No units found for this user</td>';
                unitTableBody.appendChild(row);
            }

            // Set foto profil
            const profilePhoto = document.getElementById('profilePhoto');
            if (photoPath) {
                profilePhoto.onload = function() {
                    console.log('Foto berhasil dimuat:', this.src);
                    this.style.display = 'block';
                };
                profilePhoto.onerror = function() {
                    console.error('Error memuat foto:', this.src);
                    // Tampilkan gambar default jika gagal
                    this.src = '/img/default-user.png';
                    this.style.display = 'block';
                };
                profilePhoto.src = photoPath;
            } else {
                profilePhoto.src = '/img/default-user.png';
                profilePhoto.style.display = 'block';
            }

            // Set informasi profil
            document.getElementById('profileName').textContent = name || '';
            document.getElementById('profileJabatan').textContent = jabatan || '';

            // Function untuk menampilkan PDF
            function setPDF(elementId, url) {
                const element = document.getElementById(elementId);
                const container = element.parentElement.parentElement;

                // Bersihkan pesan error jika ada
                const existingMessage = container.querySelector('.no-file-message');
                if (existingMessage) {
                    existingMessage.remove();
                }

                if (url) {
                    console.log(`Setting PDF ${elementId}:`, url);
                    element.style.display = 'block';
                    element.src = url;

                    element.onerror = function() {
                        console.error(`Error memuat PDF ${elementId}:`, url);
                        element.style.display = 'none';

                        // Tampilkan pesan error
                        const message = document.createElement('div');
                        message.className = 'no-file-message';
                        message.innerHTML =
                            '<p class="text-danger text-center fw-bold" style="margin: 20px 0; font-size: 16px;">File tidak ditemukan</p>';
                        container.querySelector('.card-body').appendChild(message);
                    };
                } else {
                    // Jika url kosong, tampilkan pesan
                    element.style.display = 'none';
                    const message = document.createElement('div');
                    message.className = 'no-file-message';
                    message.innerHTML =
                        '<p class="text-danger text-center fw-bold" style="margin: 20px 0; font-size: 16px;">File Kosong</p>';
                    container.querySelector('.card-body').appendChild(message);
                }
            }

            // Set PDFs
            setPDF('attachment1', medicalUrl);
            setPDF('attachment2', licenseUrl);
            setPDF('attachment3', attachmentUrl);
            setPDF('attachment4', sioUrl);

            // Set nilai access
            document.getElementById('chrBT1').textContent = access['CHR-BT'] || 'no';
            document.getElementById('chrFSP1').textContent = access['CHR-FSP'] || 'no';
            document.getElementById('pitCPFSP1').textContent = access['CP-FSP'] || 'no';
            document.getElementById('pitCPBT1').textContent = access['CP-BT'] || 'no';
            document.getElementById('pitCPTA1').textContent = access['CP-TA'] || 'no'; // Tambahan untuk CP-TA
            document.getElementById('pitCPTJ1').textContent = access['CP-TJ'] || 'no'; // Tambahan untuk CP-TJ
            document.getElementById('pitBT1').textContent = access['PIT-BT'] || 'no';
            document.getElementById('pitTA1').textContent = access['PIT-TA'] || 'no';
            document.getElementById('pitPITTJ1').textContent = access['PIT-TJ'] || 'no';
        }

        // Function untuk menangani approve/reject request
        function approveRequest(action) {
            const activeKode = $('#popupModal').attr('data-active-kode');

            if (!activeKode) {
                console.error('No active kode found');
                return;
            }

            if (action === 'reject') {
                $('#rejectKode').val(activeKode);

                // Set action berdasarkan halaman saat ini
                const currentPage = window.location.pathname;
                let rejectUrl = `{{ route('reject.request', '') }}/${activeKode}`;

                if (currentPage.includes('she')) {
                    rejectUrl = `{{ route('reject.request', '') }}/2/${activeKode}`;
                } else if (currentPage.includes('pjo')) {
                    rejectUrl = `{{ route('reject.request', '') }}/3/${activeKode}`;
                } else if (currentPage.includes('bec')) {
                    rejectUrl = `{{ route('reject.request', '') }}/4/${activeKode}`;
                }

                // Set form action dan tampilkan modal
                $('#rejectForm').attr('action', rejectUrl);
                $('#rejectReasonModal').modal('show');
            } else {
                // Handle approval based on current page
                let route;
                const currentPage = window.location.pathname;
                if (currentPage.includes('she')) {
                    route = "{{ route('approveDataShe', '') }}";
                } else if (currentPage.includes('pjo')) {
                    route = "{{ route('approveDataPjo', '') }}";
                } else if (currentPage.includes('bec')) {
                    route = "{{ route('approveDataBec', '') }}";
                }
                window.location.href = route + "/" + activeKode;
            }
        }

        // Inisialisasi setelah DOM selesai dimuat
        $(document).ready(function() {
            // Tambahkan event listener untuk tombol lihat data
            $('#example1').on('click', 'button.btn-primary', function() {
                showPopup(this);
            });

            // Inisialisasi DataTable
            if ($.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable().destroy();
            }

            $('#example1').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });


        $(document).ready(function() {
            // Handle click on Approve All button
            $('#allApprovalBtn').on('click', function() {
                Swal.fire({
                    title: 'Approval Confirmation',
                    text: "Are you sure you want to approve all requests?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Approve All!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading status
                        Swal.fire({
                            title: 'Processing...',
                            text: 'Please wait while we process all requests',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Redirect to approval route
                        window.location.href = "{{ route('approve.all.pjo') }}";
                    }
                });
            });
        });
    </script>
@endsection
