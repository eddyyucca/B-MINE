<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>

    <style>
        * {
            margin: 00px;
            padding: 00px;

        }

        .container {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
            box-sizing: border-box;
            flex-direction: row;



        }

        .font {

            height: 375px;
            width: 225px;
            position: relative;
            border-radius: 10px;
            background-image: url('{{ base64_encode(file_get_contents($bg)) }}');
            background-size: 225px 375px;
            background-repeat: no-repeat;
        }

        .companyname {
            color: White;
            padding: 10px;
            font-size: 25px;
        }

        .tab {
            padding-right: 30px;
        }

        .top img {
            height: 90px;
            width: 90px;
            background-color: #e6ebe0;
            border-radius: 57px;
            position: absolute;
            top: 60px;
            left: 102px;
            object-fit: content;
            border: 3px solid rgba(255, 255, 255, .2);

        }

        .ename {
            position: absolute;
            top: 160px;
            left: 90px;
            color: rgb(0, 0, 0);
            font-size: 16px;
        }

        .edetails {
            position: absolute;
            top: 212px;
            text-transform: capitalize;
            font-size: 11px;
            text-emphasis: spacing;
            margin-left: 5px;
        }

        .signature {
            position: absolute;
            top: 75%;
            height: 80px;
            width: 160px;
        }

        .signature img {

            height: 40px;
            width: 100px;
            margin: 15px 00px 00px 5px;
            border-radius: 7px;

        }


        .barcode img {
            height: 65px;
            width: 65px;
            text-align: center;
            margin: 5px;

        }

        .barcode {
            text-align: center;
            position: absolute;
            top: 62.5%;
            left: 135px;
        }


        .qr img {
            position: absolute;
            top: 85%;
            left: 32%;
            height: 30px;
            width: 120px;
            margin: 20px;
            background-color: white;

        }

        .edetails .Address {

            width: 60%;
            text-align: justify;
        }

        .page-break {
            page-break-after: always;
            /* Memastikan konten setelahnya dimulai di halaman baru */
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="padding">
            <div class="font">
                <div class="companyname">Planics<br><span class="tab">Solution</span></div>
                <div class="top">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents($fotoBase64)) }}">
                </div>
                <div class="">
                    <div class="ename">
                        <p class="p1"><b>{{ $karyawan->nama }}</b></p>
                        <p>{{ $karyawan->jab }}</p>
                    </div>
                    <div class="edetails">
                        <P><b>Mobile No :</b> 8460304196</P>
                        <p><b>DOB :</b> 02/11/2020</p>
                        <div class="Address"><b>Address : </b>223 par-1 hari soc, near main road ,L.H road surat ,L.H
                            road </div>
                    </div>
                    <div class="barcode">
                        <img src="{{ asset('adminlte/idcard/qr sample.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>
