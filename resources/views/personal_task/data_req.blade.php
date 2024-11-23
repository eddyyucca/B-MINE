@extends('layouts.main')


<style>
    .modal-body {
        display: flex;
    }

    .pdf-viewer,
    .id-card {
        flex: 1;
        padding: 10px;
    }

    .id-card {
        position: relative;
        /* Posisi relatif untuk penempatan konten */
        width: 100%;
        /* Memenuhi lebar maksimum */
        height: 420px;
        /* Atur tinggi ID Card */
        background-image: url('adminlte/img/depan.jpg');
        /* Latar belakang */
        background-size: cover;
        /* Mengisi seluruh area */
        background-position: center;
        /* Memposisikan gambar di tengah */
        background-repeat: no-repeat;
        /* Mencegah pengulangan gambar */
        color: black;
        /* Warna teks */
        border: 1px solid #ccc;
        /* Border jika perlu */
        border-radius: 10px;
        /* Sudut membulat */
        padding: 10px;
        /* Jarak dalam */
        display: flex;
        /* Menggunakan flexbox */
        flex-direction: column;
        /* Kolom */
        align-items: center;
        /* Menempatkan konten di tengah horizontal */
        justify-content: center;
        /* Menempatkan konten di tengah vertikal */
        /* Menambahkan bayangan */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        /* Atur bayangan sesuai kebutuhan */
    }

    .profile-info {
        text-align: center;
        /* Menyusun teks di tengah */
        margin-top: 0px;
        /* Jarak atas untuk menyesuaikan posisi lebih tinggi */
        /* Atau bisa mengatur padding-top */
    }

    .profile-photo {
        width: 80px;
        /* Atur ukuran foto profil */
        height: 80px;
        /* Atur ukuran foto profil */
        border-radius: 5px;
        /* Sudut tidak lancip */
        margin-bottom: 10px;
        /* Jarak antara foto dan teks */
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
                            <h3 class="card-title">Personal Task</h3>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataReqs as $index => $dataReq)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $dataReq->nik }}</td>
                                            <td>{{ $dataReq->nama }}</td>
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
                                                    data-photo="{{ $dataReq->foto_path ? asset(str_replace('public', 'storage/app/public', $dataReq->foto_path)) : '' }}"
                                                    data-medical="{{ $dataReq->medical_path ? asset(str_replace('public', 'storage/app/public', $dataReq->medical_path)) : '' }}"
                                                    data-license="{{ $dataReq->drivers_license_path ? asset(str_replace('public', 'storage/app/public', $dataReq->drivers_license_path)) : '' }}"
                                                    data-attachment="{{ $dataReq->attachment_path ? asset(str_replace('public', 'storage/app/public', $dataReq->attachment_path)) : '' }}"
                                                    data-name="{{ $dataReq->nama }}" data-nik="{{ $dataReq->nik }}"
                                                    data-jabatan="{{ $dataReq->jab }}"
                                                    data-departement="{{ $dataReq->dept }}">
                                                    Lihat Berkas Pengajuan <i class="fas fa-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
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
                <div class="modal-body">
                    <!-- Kolom PDF Viewer -->
                    <div class="modal-body">
                        <div class="pdf-viewer">
                            <h5 class="text-center">Medical Certificate</h5>
                            <iframe id="attachment1" src="" style="width: 70%; height: 500px;"
                                frameborder="0"></iframe>
                            <h5 class="text-center">Driver's License</h5>
                            <iframe id="attachment2" src="" style="width: 70%; height: 500px;"
                                frameborder="0"></iframe>
                            <h5 class="text-center">Attachment</h5>
                            <iframe id="attachment3" src="" style="width: 70%; height: 500px;"
                                frameborder="0"></iframe>
                            <h5 class="text-center">SIO Attachment</h5>
                            <iframe id="attachment3" src="" style="width: 70%; height: 500px;"
                                frameborder="0"></iframe>
                        </div>
                    </div>
                    <!-- Kolom ID Card -->
                    <div class="id-card text-center" style="max-width: 242px;">
                        <div id="idCardFront" class="id-card">
                            <div class="profile-info">
                                <h6>SIMPER & MINE PERMIT</h6>
                                <img id="profilePhoto" src="" alt="Profile Photo" class="profile-photo">
                                <h6 id="profileName"></h6>
                                <p id="profileJabatan"></p>
                            </div>
                            <div class="container">
                                <div class="data-container">
                                    <div class="data-box">
                                        <h5>Data Status A</h5>
                                        <p>CHR BT: <span id="chrBT1"></span></p>
                                        <p>CHR FSB: <span id="chrFSB1"></span></p>
                                        <p>PIT BT: <span id="pitBT1"></span></p>
                                        <p>PIT TA: <span id="pitTA1"></span></p>
                                    </div>
                                    <div class="data-box">
                                        <div id="qrcode"></div> <!-- Tempat untuk menampilkan QR Code -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div id="idCardBack" style="display: none;">
                            <h6>Back Side</h6>
                            <img src="{{ asset('adminlte/img/belakang.jpg') }}" alt="Back ID Card" class="img-fluid mb-3"
                                style="width: 100%; height: auto;">
                        </div> --}}
                    </div>
                    <!-- Button to Toggle Front/Back -->
                </div>
            </div>
            <button class="btn btn-secondary" onclick="toggleCard()">Flip Card</button>
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
            $('#popupModal').modal('show'); // Menampilkan modal
            // Ambil data dari tombol
            const photoPath = button.getAttribute('data-photo');
            const medicalUrl = button.getAttribute('data-medical');
            const licenseUrl = button.getAttribute('data-license');
            const attachmentUrl = button.getAttribute('data-attachment');
            const name = button.getAttribute('data-name');
            const nik = button.getAttribute('data-nik');
            const jabatan = button.getAttribute('data-jabatan');
            const departement = button.getAttribute('data-departement');

            // Debugging: Log setiap variabel untuk memeriksa nilainya
            console.log('Photo Path:', photoPath);
            console.log('Medical URL:', medicalUrl);
            console.log('License URL:', licenseUrl);
            console.log('Attachment URL:', attachmentUrl);
            console.log('Name:', name);
            console.log('NIK:', nik);
            console.log('Jabatan:', jabatan);
            console.log('Departement:', departement);

            // Set foto profil ID Card
            document.getElementById('profilePhoto').src = photoPath; // Set foto ke elemen gambar

            // Set nama, NIK, jabatan, dan departemen
            document.getElementById('profileName').textContent = name;
            document.getElementById('profileJabatan').textContent = jabatan;

            // Set PDF URLs di iframe jika diperlukan
            if (medicalUrl) {
                document.getElementById('attachment1').src = medicalUrl;
            }

            if (licenseUrl) {
                document.getElementById('attachment2').src = licenseUrl;
            }

            if (attachmentUrl) {
                document.getElementById('attachment3').src = attachmentUrl;
            }
        }

        // access
        // Data JSON untuk dua data box
        const dataA = {
            "CHR BT": "yes",
            "CHR FSB": "no",
            "PIT BT": "yes",
            "PIT TA": "no"
        };

        const dataB = {
            "code": "BUMA-20241123-X6LYyg" // Data code
        };
        $('#qrcode').qrcode({
            text: dataB.code, // Data yang akan digunakan untuk QR Code
            width: 100, // Lebar QR Code
            height: 100 // Tinggi QR Code
        });
        // Menempatkan data ke dalam elemen HTML untuk Data Box A
        document.getElementById('chrBT1').textContent = dataA["CHR BT"];
        document.getElementById('chrFSB1').textContent = dataA["CHR FSB"];
        document.getElementById('pitBT1').textContent = dataA["PIT BT"];
        document.getElementById('pitTA1').textContent = dataA["PIT TA"];

        // Menempatkan data ke dalam elemen HTML untuk Data Box B
        document.getElementById('chrBT2').textContent = dataB["CHR BT"];
        document.getElementById('chrFSB2').textContent = dataB["CHR FSB"];
        document.getElementById('pitBT2').textContent = dataB["PIT BT"];
        document.getElementById('pitTA2').textContent = dataB["PIT TA"];
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
    </script>
@endsection
