<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
    {{-- TODO PDF : 4 --}}
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            font: 10pt "Tahoma";
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 5mm 10mm 10mm 5mm;
            margin: 3px 3px 3px 3px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .subpage {
            height: 257mm;
        }

        .table1 {
            font-family: sans-serif;
            font-size: 10px;
            color: #232323;
            border-collapse: collapse;
            width: 100%;
            vertical-align: top;
        }

        .table1,
        .table1 th,
        .table1 td {
            /* border: 1px solid #999; */
            padding: 3px 10px;
        }

        p {
            margin: 0;
        }

        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            html,
            body {
                width: 210mm;
                height: 297mm;
            }

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>
</head>

<body>
    <div class="book">
        <div class="page">
            <div class="subpage">
                <div class="header" style="text-align: center">
                    <table>
                        <tr>
                            <td width="180px" class="px-3">
                                <center><img src="{{ public_path('assets/img/logo_gemah_ripah_repeh_rapih.jpg') }}" alt="logo" width="100" style="margin-left: 20px;"></center>
                            </td>
                            <td style="text-align: center;">
                                PEMERINTAH DAERAH PROVINSI JAWA BARAT<br />
                                DINAS PENDIDIKAN<br />
                                CABANG DINAS PENDIDIKAN WILAYAH VII<br />
                                <span style="font-size: 18px; font-weight: bold;">SMK NEGERI 11 KOTA BANDUNG</span><br />
                                Bisnis dan Manajemen - Teknologi Inforamsi dan Komunikasi - Seni dan Ekonomi Kreatif<br />
                                Jl. Budhi Cilember 🖊️ (022) 6652442 Fax. (022) 6613508 Bandung 🖊️ 40175<br />
                                NPSN : 20219175 http://smkn11bdg.sch.id E-mail: smkn11bdg@gmail.com
                            </td>
                        </tr>
                    </table>
                </div>
                <center>
                    <hr width="90%">
                </center>
                <br>
                <table style="width: 100%; margin: 0 30px 0 30px;">
                    <tr>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>{{ $nomor_surat }}</td>
                        <!-- <td style="text-align: right; width: 200px;">{{ $tanggal }}</td> -->
                        <td></td>
                    </tr>
                    <tr>
                        <td>Lampiran</td>
                        <td>:</td>
                        <td>{{ $lampiran }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Perihal</td>
                        <td>:</td>
                        <td>{{ $perihal }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="padding-top: 30px; width: 200px;">Kepada : </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            @foreach ($nama as $id)
                            {{ $users[$id-1]->name}} <br />
                            @endforeach
                        </td>
                    </tr>
                </table>
                <div class="content" style="margin: 20px 30px 20px 30px; text-align: justify; padding-right: 30px;">{!! $isi !!}</div>
                <br>
                <table style="width: 100%; margin: 20px 30px 0 30px;">
                    <tr>
                        <td style="width: 10%;"></td>
                        <td style="width: 10%;"></td>
                        <td style="width: 10%;"></td>
                        <td style="width: 25%; padding-top: 50px; text-align: center;">Bandung, {{ $tanggal }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="width: 25%; padding-top: 20px; text-align: center;"><img src="data:image/png;base64, {!! base64_encode(QrCode::size(100)->generate($qr_code)) !!} "></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="width: 25%; padding-top: 20px; text-align: center;">{{ $nama_penandatangan }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="width: 25%; text-align: center;">NIP : {{ $nip }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>

</html>