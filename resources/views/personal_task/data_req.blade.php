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

    .id-card img {
        width: 150px;
        /* Ukuran yang diinginkan */
        height: auto;
        /* Atur tinggi otomatis untuk mempertahankan rasio */
    }

    .pdf-viewer {
        border-right: 1px solid #ccc;
    }

    /* search options */
    .select2-container--default .select2-selection--single {
        height: 38px;
        /* Tinggi yang sesuai dengan input lainnya di Admin LTE */
        border-radius: .25rem;
        /* Sesuaikan radius border */
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
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#profileModal"
                                                    data-photo="{{ $dataReq->foto_path ? asset(str_replace('public', 'storage/app/public', $dataReq->foto_path)) : '' }}"
                                                    data-medical="{{ $dataReq->medical_path ? asset(str_replace('public', 'storage/app/public', $dataReq->medical_path)) : '' }}"
                                                    data-license="{{ $dataReq->drivers_license_path ? asset(str_replace('public', 'storage/app/public', $dataReq->drivers_license_path)) : '' }}"
                                                    data-attachment="{{ $dataReq->attachment_path ? asset(str_replace('public', 'storage/app/public', $dataReq->attachment_path)) : '' }}"
                                                    data-name="{{ $dataReq->nama }}" data-nik="{{ $dataReq->nik }}"
                                                    data-jabatan="{{ $dataReq->jab }}"
                                                    data-departement="{{ $dataReq->dept }}">
                                                    Lihat Berkas Pengajuan <i class="fas fa-eye"></i>
                                                </button>
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
    <!-- Modal for displaying the attachment -->
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
                            <h5 class="text-center">PDF Viewer</h5>
                            <iframe id="attachment1" src="" style="width: 70%; height: 500px;"
                                frameborder="0"></iframe>
                            <iframe id="attachment2" src="" style="width: 70%; height: 500px;"
                                frameborder="0"></iframe>
                            <iframe id="attachment3" src="" style="width: 70%; height: 500px;"
                                frameborder="0"></iframe>
                        </div>
                    </div>
                    <!-- Kolom ID Card -->
                    <div class="id-card text-center" style="max-width: 200px;">
                        <!-- Atur lebar maksimum sesuai kebutuhan -->
                        <h5>ID Card</h5>
                        <!-- Front Side -->
                        <div id="idCardFront">
                            <h6>Front Side</h6>
                            <img src="https://via.placeholder.com/300x200?text=Front+ID+Card" alt="Front ID Card"
                                class="img-fluid mb-3" style="width: 100%; height: auto;"> <!-- pas ukuran -->
                        </div>
                        <!-- Back Side -->
                        <div id="idCardBack" style="display: none;">
                            <h6>Back Side</h6>
                            <img src="https://via.placeholder.com/300x200?text=Back+ID+Card" alt="Back ID Card"
                                class="img-fluid mb-3" style="width: 100%; height: auto;"> <!-- pas ukuran -->
                        </div>
                        <!-- Button to Toggle Front/Back -->
                        <button class="btn btn-secondary" onclick="toggleCard()">Flip Card</button>
                    </div>
                </div>
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
        // search options
        $(document).ready(function() {
            $('#unit_type').select2({
                placeholder: "Select...",
                allowClear: true,
                width: '100%' // Untuk menjadikan dropdown responsif
            });
        });


        $(document).ready(function() {
            $('#profileModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var photoPath = button.data('photo');
                var medicalPath = button.data('medical');
                var licensePath = button.data('license');
                var attachmentPath = button.data('attachment');
                var name = button.data('name');
                var nik = button.data('nik');
                var jabatan = button.data('jabatan');
                var departement = button.data('departement');
                var modal = $(this);
                modal.find('#profileName').text(name || 'Tidak Diketahui');
                modal.find('#profileNik').text(nik || 'Tidak Diketahui');
                modal.find('#profileJabatan').text(jabatan || 'Tidak Diketahui');
                modal.find('#profileDepartement').text(departement || 'Tidak Diketahui');
                // Set foto di dalam modal
                if (photoPath) {
                    modal.find('#employeePhoto').attr('src', photoPath).show();
                    modal.find('#photoNotAvailable').hide(); // Sembunyikan pesan jika foto ada
                } else {
                    modal.find('#employeePhoto').hide(); // Sembunyikan gambar jika foto tidak ada
                    modal.find('#photoNotAvailable').show(); // Tampilkan pesan jika foto tidak ada
                }

                // Cek Medical Certificate
                if (medicalPath) {
                    modal.find('#medicalBtn').show().attr('onclick', "window.open('" + medicalPath +
                        "', '_blank')");
                    modal.find('#medicalNotAvailable').hide(); // Sembunyikan pesan jika file ada
                } else {
                    modal.find('#medicalBtn').hide(); // Sembunyikan tombol jika file tidak ada
                    modal.find('#medicalNotAvailable').show(); // Tampilkan pesan jika file tidak ada
                }

                // Cek Driver's License
                if (licensePath) {
                    modal.find('#licenseBtn').show().attr('onclick', "window.open('" + licensePath +
                        "', '_blank')");
                    modal.find('#licenseNotAvailable').hide();
                } else {
                    modal.find('#licenseBtn').hide();
                    modal.find('#licenseNotAvailable').show();
                }

                // Cek Attachment
                if (attachmentPath) {
                    modal.find('#attachmentBtn').show().attr('onclick', "window.open('" + attachmentPath +
                        "', '_blank')");
                    modal.find('#attachmentNotAvailable').hide();
                } else {
                    modal.find('#attachmentBtn').hide();
                    modal.find('#attachmentNotAvailable').show();
                }
            });
        });


        function viewDocument(doc) {
            window.open(doc, '_blank');
        }

        // Menampilkan modal popup
        function showPopup(button) {
            $('#popupModal').modal('show'); // Menampilkan modal

            // Ambil data dari tombol
            const medicalUrl = button.getAttribute('data-medical');
            const licenseUrl = button.getAttribute('data-license');
            const attachmentUrl = button.getAttribute('data-attachment');

            // Set PDF URLs di iframe
            if (medicalUrl) {
                document.getElementById('attachment1').src = medicalUrl; // untuk tampilan medical
            }

            if (licenseUrl) {
                document.getElementById('attachment2').src = licenseUrl; // untuk tampilan license
            }

            if (attachmentUrl) {
                document.getElementById('attachment3').src = attachmentUrl; // untuk tampilan attachment
            }
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
    </script>
@endsection
