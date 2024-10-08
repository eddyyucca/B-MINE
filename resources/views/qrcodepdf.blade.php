<html>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        /* Menyesuaikan ukuran ID card menjadi ukuran standar */
        .id-card {
            width: 85.6mm;
            height: 54mm;
            border: 1px solid black;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10mm;
            background-color: white;
        }
    </style>
</head>

<body class="bg-gray-100 p-4">
    <div class="id-card mx-auto bg-white">
        <div class="p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm font-bold">
                        PT. FAJAR SAKTI PRIMA
                    </p>
                    <p class="text-sm font-bold">
                        PT. BARA TABANG
                    </p>
                    <p class="text-sm font-bold">
                        PT. TIWA ABADI
                    </p>
                </div>
                <img alt="BUMA logo" class="h-12" height="50"
                    src="{{ asset('adminlte/img/logo_buma_tabang.png') }}" width="100" />
            </div>
            <p class="text-xs italic text-center mt-2">
                Member of Bayan Group
            </p>
            <h1 class="text-center text-xl font-bold mt-2">
                SIMPER &amp; MINE PERMIT
            </h1>
            <div class="flex justify-center mt-4">
                <img alt="Photo of Abdul Kadir Zaelani" class="border border-gray-300" height="120"
                    src="https://storage.googleapis.com/a1aa/image/CB1nTd9r7AK4DVeyfqv8GgvtUBpfoDln0df3oWxmLp3YGNSOB.jpg"
                    width="100" />
            </div>
            <div class="mt-4">
                <p class="text-center font-bold">
                    Eddy Adha Saputra
                </p>
                <div class="grid grid-cols-2 gap-2 mt-2">
                    <p class="text-sm">
                        NIK :
                    </p>
                    <p class="text-sm">
                        10034026
                    </p>
                    <p class="text-sm">
                        Perusahaan :
                    </p>
                    <p class="text-sm">
                        BUMA
                    </p>
                    <p class="text-sm">
                        Departemen :
                    </p>
                    <p class="text-sm">
                        IT
                    </p>
                    <p class="text-sm">
                        Jabatan :
                    </p>
                    <p class="text-sm">
                        Foreman
                    </p>
                    <p class="text-sm">
                        Tgl. Berakhir :
                    </p>
                    <p class="text-sm">
                        15-Jun-25
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <h2 class="text-center font-bold">
                    ACCESS
                </h2>
                <div class="grid grid-cols-5 gap-2 mt-2 text-center">
                    <p class="text-sm">
                        CHR BT
                    </p>
                    <p class="text-sm">
                        CHR FS
                    </p>
                    <p class="text-sm">
                        PIT BT
                    </p>
                    <p class="text-sm">
                        PIT TA
                    </p>
                    <p class="text-sm">
                        -
                    </p>
                    <p class="text-sm">
                        <i class="fas fa-check">
                        </i>
                    </p>
                    <p class="text-sm">
                        <i class="fas fa-check">
                        </i>
                    </p>
                    <p class="text-sm">
                        <i class="fas fa-check">
                        </i>
                    </p>
                    <p class="text-sm">
                        <i class="fas fa-check">
                        </i>
                    </p>
                    <p class="text-sm">
                        -
                    </p>
                </div>
            </div>
            <div class="mx-auto mt-4">
                <h2 class="text-center font-bold bg-blue-600 text-white py-1">
                    Disahkan Oleh,
                </h2>
                <div class="grid grid-cols-3 gap-2 mt-2 text-center">
                    {!! DNS1D::getBarcodeHTML('1234567890', 'C128') !!}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
