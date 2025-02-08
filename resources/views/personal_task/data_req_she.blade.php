@extends('layouts.main')
<script>
    function openPdf(nik) {
        const url = '{{ url('karyawan') }}/' + nik + '/idcard-pdf';
        const popup = window.open(url, 'ID Card', 'width=600,height=400'); // Buka popup
        popup.focus(); // Fokus pada popup
    }
</script>

<style>
    .modal-body {
        display: flex;
    }

    .pdf-viewer,
    .id-card {
        flex: 1;
        /* padding: 10px; */
    }

    .id-card {}

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

    .data-container {
        display: flex;
        /* Menggunakan Flexbox untuk membuat box sejajar */
        flex-wrap: wrap;
        /* Allow wrapping if necessary */
        justify-content: space-between;
        /* Memberikan jarak antara box */
    }

    .data-box {
        width: 48%;
        /* Atur lebar box agar sejajar dan memberi jarak */
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        /* Jarak atas */
        text-align: left;
    }

    .data-box h5 {
        font-size: 14px;
    }

    .data-box p {
        font-size: 12px;
    }

    .pdf-viewer {
        border-right: 1px solid #ccc;
        /* Border antara viewer dan ID Card */
    }

    #qrcode {
        margin-top: 10px;
        /* Jarak atas untuk QR Code */
    }

    /* Style untuk iframe */
    iframe {
        width: 100%;
        /* Menyesuaikan dengan lebar kontainer */
        height: 500px;
        /* Tentukan tinggi */
        border: none;
        /* Hapus border default */
    }

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
        /* Menambah jarak antar card */
    }

    .card {
        border: 7px solid #d1d3e2;
        /* Border lebih tebal */
        box-shadow: 0 1.15rem 2.75rem 0 rgba(58, 59, 69, 0.15);
        /* Menambah shadow */
    }


    .card-header {
        border-bottom: 2px solid #d1d3e2;
        /* Border bawah header lebih tebal */
        padding: 1rem;
        /* Padding header lebih besar */
    }

    .pdf-embed {
        background: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 0 auto;
        display: block;
    }

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

    /* Checkmark */
    /* .custom-control-label::after {
        content: '';
        position: absolute;
        left: 9px;
        top: 5px;
        width: 7px;
        height: 13px;
        border: solid white;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
        display: none;
    } */

    .custom-checkbox input:checked+.custom-control-label::after {
        display: block;
    }

    /* Label colors */
    #acceptCheck:checked+.custom-control-label {
        color: #28a745;
    }

    #rejectCheck:checked+.custom-control-label {
        color: #dc3545;
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
                            <h3 class="card-title">Personal Task SHE</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Name</th>
                                        <th>Request</th>
                                        <th class="no-export">Actions</th>
                                        <th class="no-export">Cetak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($dataReqs->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">Tidak ada data yang tersedia</td>
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
                                                    @if ($dataReq->validasi_in == 1)
                                                        Simper & MinePermit
                                                    @elseif ($dataReq->validasi_in == 2)
                                                        MinePermit
                                                    @else
                                                        {{-- Jika ada nilai lain atau untuk penanganan default --}}
                                                        -
                                                    @endif
                                                </td>
                                                <td align="center" class="no-export">
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-primary" onclick="showPopup(this)"
                                                        data-photo="{{ $dataReq->foto_path }}"
                                                        data-medical="{{ $dataReq->medical_path }}"
                                                        data-license="{{ $dataReq->drivers_license_path }}"
                                                        data-sio="http://localhost:8088/bmine/storage/app/{{ $dataReq->sio_path }}"
                                                        data-attachment="{{ $dataReq->attachment_path }}"
                                                        data-name="{{ $dataReq->nama }}" data-nik="{{ $dataReq->nik }}"
                                                        data-jabatan="{{ $dataReq->jab }}"
                                                        data-departement="{{ $dataReq->dept }}"
                                                        data-kode="{{ $dataReq->kode }}"
                                                        data-units="{{ json_encode($dataReq->unitUsers) }}"
                                                        data-access="{{ json_encode($dataReq->access) }}">
                                                        Lihat Berkas Pengajuan <i class="fas fa-eye"></i>
                                                    </button>

                                                </td>
                                                <td>
                                                    <button class="btn btn-success text-white">Depan</button>
                                                    <button class="btn btn-success text-white">Belakang</button>
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
                <!-- Kolom ID Card -->
                <div style="display: flex; gap: 5px;">
                    <!-- Profile, Access, dan Unit Card -->
                    <div class="id-card text-center" style="max-width: 242px;">
                        <div id="idCardFront" class="id-card">
                            <div class="profile-info">
                                <h6>SIMPER & MINE PERMIT</h6>
                                <div class="photo-container">
                                    <img id="profilePhoto" src="" alt="Profile Photo" class="profile-photo">
                                </div>
                                <h6 id="profileName"></h6>
                                <p id="profileJabatan"></p>
                            </div>
                        </div>
                    </div>

                    <div class="id-card text-center mt-3" style="max-width: 242px;">
                        <div class="container">
                            <div class="data-container">
                                <h5>Access</h5><br>
                                <table class="table table-bordered table-hover"
                                    style="width: 100%; font-size: 12px; border-collapse: collapse;">
                                    <tr>
                                        <td>CHR BT:</td>
                                        <td style="text-align: center;"><span id="chrBT1"></span></td>
                                    </tr>
                                    <tr>
                                        <td>CHR FSB:</td>
                                        <td style="text-align: center;"><span id="chrFSB1"></span></td>
                                    </tr>
                                    <tr>
                                        <td>PIT BT:</td>
                                        <td style="text-align: center;"><span id="pitBT1"></span></td>
                                    </tr>
                                    <tr>
                                        <td>PIT TA:</td>
                                        <td style="text-align: center;"><span id="pitTA1"></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="id-card text-center mt-3" style="max-width: 600px;">
                        <div class="container">
                            <div class="data-container">
                                <!-- Tambahkan data attribute ke button untuk kode -->
                                <h5>Units</h5><br>
                                <table class="table table-bordered table-hover"
                                    style="width: 100%; font-size: 12px; border-collapse: collapse;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%">No</th>
                                            <th>UNIT Type</th>
                                            <th class="text-center" style="width: 10%">P</th>
                                            <th class="text-center" style="width: 10%">R</th>
                                            <th class="text-center" style="width: 10%">T</th>
                                            <th class="text-center" style="width: 10%">I</th>
                                            <th class="text-center" style="width: 10%">O</th>
                                        </tr>
                                    </thead>
                                    <tbody id="unitTableBody">
                                        <!-- Data will be populated dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom PDF Viewer -->
                <div class="modal-body">
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
                                    <h5 class="text-center mb-0">Driver's License</h5>
                                </div>
                                <div class="card-body p-0">
                                    <embed id="attachment2" src="" type="application/pdf"
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
                                    <div style="display: flex; gap: 20px;">
                                        <button type="button" class="btn btn-success"
                                            onclick="approveRequest('accept')">
                                            <i class="fas fa-check"></i> Accept
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="approveRequest('reject')">
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
        function viewDocument(doc) {
            window.open(doc, '_blank');
        }

        // Menampilkan modal popup
        function showPopup(button) {
            $('#popupModal').modal('show');
            const photoPath = button.getAttribute('data-photo');
            const medicalUrl = button.getAttribute('data-medical');
            const licenseUrl = button.getAttribute('data-license');
            const attachmentUrl = button.getAttribute('data-attachment');
            const sioUrl = button.getAttribute('data-sio');
            const name = button.getAttribute('data-name');
            const nik = button.getAttribute('data-nik');
            const jabatan = button.getAttribute('data-jabatan');
            const departement = button.getAttribute('data-departement');
            const access = JSON.parse(button.getAttribute('data-access'));
            const kode = button.getAttribute('data-kode'); // Tambahkan ini
            const units = JSON.parse(button.getAttribute('data-units')); // Tambahkan ini

            // Tambahkan kode aktif ke modal
            $('#popupModal').attr('data-active-kode', kode);

            // Update unit table
            const unitTableBody = document.getElementById('unitTableBody');
            unitTableBody.innerHTML = ''; // Clear existing content


            if (units && units.length > 0) {
                units.forEach((unit, index) => {
                    if (unit.id_uur === kode) { // Filter hanya unit yang sesuai dengan kode
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td class="text-center">${index + 1}</td>
                    <td>${unit.unit_data ? unit.unit_data.nama_unit : 'N/A'}</td>
                    <td class="text-center">${unit.type_unit && unit.type_unit.includes('P') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                    <td class="text-center">${unit.type_unit && unit.type_unit.includes('R') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                    <td class="text-center">${unit.type_unit && unit.type_unit.includes('T') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                    <td class="text-center">${unit.type_unit && unit.type_unit.includes('I') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                    <td class="text-center">${unit.type_unit && unit.type_unit.includes('O') ? '<i class="fas fa-check text-success"></i>' : '-'}</td>
                `;
                        unitTableBody.appendChild(row);
                    }
                });
            }

            if (unitTableBody.children.length === 0) {
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="6" class="text-center">No units found for this user</td>';
                unitTableBody.appendChild(row);
            }

            // Set foto profil dengan error handling
            const profilePhoto = document.getElementById('profilePhoto');
            if (photoPath) {
                profilePhoto.onload = function() {
                    console.log('Photo loaded successfully');
                    this.style.display = 'block';
                };
                profilePhoto.onerror = function() {
                    console.error('Error loading photo:', photoPath);
                    this.style.display = 'none';
                };
                profilePhoto.src = photoPath;
            } else {
                profilePhoto.style.display = 'none';
            }

            // Set informasi
            document.getElementById('profileName').textContent = name || '';
            document.getElementById('profileJabatan').textContent = jabatan || '';

            // Set PDFs dengan error handling
            function setPDF(elementId, url) {
                const element = document.getElementById(elementId);
                const container = element.parentElement;

                if (url) {
                    // Cek file terlebih dahulu
                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('File not found');
                            }
                            // Jika file ada, tampilkan PDF
                            element.style.display = 'block';
                            element.src = url;

                            // Hapus pesan error jika ada
                            const existingMessage = container.querySelector('.no-file-message');
                            if (existingMessage) {
                                existingMessage.remove();
                            }
                        })
                        .catch(error => {
                            // Jika file tidak ada atau error, tampilkan pesan
                            element.style.display = 'none';
                            let message = container.querySelector('.no-file-message');
                            if (!message) {
                                message = document.createElement('div');
                                message.className = 'no-file-message';
                                message.innerHTML =
                                    '<p class="text-danger text-center fw-bold" style="margin: 20px 0; font-size: 16px;">File kosong Harap Di Masukan</p>';
                                container.appendChild(message);
                            }
                        });
                } else {
                    // Jika url kosong, tampilkan pesan
                    element.style.display = 'none';
                    let message = container.querySelector('.no-file-message');
                    if (!message) {
                        message = document.createElement('div');
                        message.className = 'no-file-message';
                        message.innerHTML =
                            '<p class="text-danger text-center fw-bold" style="margin: 20px 0; font-size: 16px;">File Kosong Harap Di Masukan </p>';
                        container.appendChild(message);
                    }
                }
            }

            setPDF('attachment1', medicalUrl);
            setPDF('attachment2', licenseUrl);
            setPDF('attachment3', attachmentUrl);
            setPDF('attachment4', sioUrl);

            // Set nilai access
            document.getElementById('chrBT1').textContent = access['CHR BT'] || 'no';
            document.getElementById('chrFSB1').textContent = access['CHR FSB'] || 'no';
            document.getElementById('pitBT1').textContent = access['PIT BT'] || 'no';
            document.getElementById('pitTA1').textContent = access['PIT TA'] || 'no';
        }

        // Fungsi untuk membalik ID Card
        function toggleCard() {
            const front = document.getElementById('idCardFront');
            const back = document.getElementById('idCardBack');
            if (front.style.display === 'none') {
                front.style.display = 'block';
                back.style.display = 'none';
            } else {
                front.style.display = 'none';
                back.style.display = 'block';
            }
        }

        // app
        document.querySelectorAll('[id^="approveButton"]').forEach(button => {
            button.addEventListener('click', function() {
                const nik = this.getAttribute('data-nik'); // Mengambil nilai data-nik
                const routeType = this.getAttribute('data-route'); // Mengambil jenis rute

                let url;
                switch (routeType) {
                    case 'she':
                        url = `{{ route('approveDataShe', ['kode' => ':kode']) }}`.replace(':kode', nik);
                        break;
                    case 'pjo':
                        url = `{{ route('approveDataPjo', ['kode' => ':kode']) }}`.replace(':kode', nik);
                        break;
                    case 'bec':
                        url = `{{ route('approveDataBec', ['kode' => ':kode']) }}`.replace(':kode', nik);
                        break;
                    case 'ktt':
                        url = `{{ route('approveDataKtt', ['kode' => ':kode']) }}`.replace(':kode', nik);
                        break;
                    default:
                        console.error('Invalid route type.');
                        return;
                }
                window.location.href = url; // Arahkan ke URL yang dibentuk
            });
        });


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
    </script>
@endsection
