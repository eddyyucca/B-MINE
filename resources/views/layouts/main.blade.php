<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $name_page }}</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/chart.js/Chart.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/sweetalert/sweetalert2.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('adminlte/img/logo-bmine.ico') }}">
    <style>
        /* CSS untuk loading screen modern */
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loading-screen {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #ffffff;
            z-index: 9999;
        }

        .loading-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            background-color: white;
            width: 90%;
            max-width: 400px;
            animation: fadeInUp 0.8s ease-out;
        }

        /* Logo styling */
        .logo {
            width: 150px;
            margin-bottom: 30px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.1));
            animation: pulse 2s infinite ease-in-out;
        }

        .company-title {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
            background: linear-gradient(90deg, #303030, #505050);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .loading-subtitle {
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #666;
            margin-bottom: 25px;
            font-size: 1rem;
        }

        /* Progress indicator */
        .progress-container {
            width: 100%;
            margin-bottom: 15px;
        }

        .progress-text {
            display: flex;
            justify-content: space-between;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin-bottom: 10px;
            color: #333;
        }

        .progress-label {
            font-weight: 500;
            font-size: 1rem;
        }

        .progress-percentage {
            font-weight: bold;
            font-size: 1rem;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background-color: #f0f0f0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .progress-bar-fill {
            height: 100%;
            border-radius: 20px;
            background: linear-gradient(90deg, #3498db, #2980b9);
            background-size: 200% 100%;
            animation: shimmer 2s infinite linear;
            width: 0;
            transition: width 0.3s ease;
        }

        /* Loading icon */
        .loading-icon {
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #3498db;
            font-size: 1.2rem;
        }

        .loading-icon i {
            margin-right: 10px;
            animation: spin 1.5s infinite linear;
        }

        /* Hide main content until loaded */
        #content {
            visibility: hidden;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    {{-- loading screen --}}
    <div class="loading-screen" id="loading-screen">
        <div class="loading-container">
            <img src="{{ asset('adminlte/img/logo-bmine.png') }}" alt="Logo" class="logo">
            <div class="loading-subtitle">Mining Identity Number Electronic</div>

            <div class="progress-container">
                <div class="progress-text">
                    <span class="progress-label">Loading System</span>
                    <span class="progress-percentage" id="progress-text">0%</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-bar-fill" id="progress-bar-fill"></div>
                </div>
            </div>

            <div class="loading-icon">
                <i class="fas fa-cog"></i>
                <span id="loading-message">Initializing components...</span>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navbar')

        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('layouts.footer')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.js') }}"></script>
    <!-- sweetalert -->
    <script>
        document.querySelectorAll('.confirmButton').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const href = this.getAttribute('href');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, do it!',
                    cancelButtonText: 'Cancel',
                    background: '#f0f0f0',
                    backdrop: `rgba(0,0,0,0.4)`
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('adminlte/sweetalert/sweetalert2.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('adminlte/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/flot/plugins/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/flot/plugins/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/chart.js/chart.js') }}"></script>

    {{-- cetak pdf --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    {{-- qrcode --}}
    <script src="{{ asset('adminlte/js/qrcode/jscode.js') }}"></script>
    <script src="{{ asset('adminlte/js/qrcode/JsBarcode.all.min.js') }}"></script>
    <script src="{{ asset('adminlte/js/qrcode/jquery.qrcode.min.js') }}"></script>

    {{-- loading script modern --}}
    <script>
        document.onreadystatechange = function() {
            if (document.readyState === "interactive") {
                let progress = 0;
                const progressText = document.getElementById('progress-text');
                const progressBarFill = document.getElementById('progress-bar-fill');
                const loadingMessage = document.getElementById('loading-message');

                const messages = [
                    "Loading...",
                    "Please wait...",
                    "Almost ready..."
                ];

                const loadingInterval = setInterval(() => {
                    // Naikkan progress dengan kecepatan yang bervariasi
                    progress += Math.floor(Math.random() * 8) + 3;

                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(loadingInterval);

                        progressText.textContent = progress + '%';
                        progressBarFill.style.width = progress + '%';
                        loadingMessage.textContent = "System ready!";

                        // Delay sedikit sebelum menghilangkan loading screen
                        setTimeout(() => {
                            document.getElementById('loading-screen').style.display = 'none';
                            document.getElementById('content').style.visibility = 'visible';
                        }, 500);
                    } else {
                        progressText.textContent = progress + '%';
                        progressBarFill.style.width = progress + '%';

                        // Ganti pesan berdasarkan progress
                        const messageIndex = Math.floor(progress / (100 / messages.length));
                        loadingMessage.textContent = messages[Math.min(messageIndex, messages.length - 1)];
                    }
                }, 120);
            }
        };
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "buttons": [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible:not(.no-export)' // Mengecualikan kolom yang disembunyikan
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: ':visible:not(.no-export)'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible:not(.no-export)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible:not(.no-export)'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible:not(.no-export)'
                        }
                    },
                    'colvis'
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                            'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                        'MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

        })
        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End
    </script>
    @yield('scripts')
</body>

</html>
