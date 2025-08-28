<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat undangan klarifikasi dan negoisasi harga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            min-height: 100vh;
            padding: 32px;
            background-color: white;
        }

        .text-smaller {
            font-size: 14px;
        }

        .alamat p {
            margin: 2px 0;
            line-height: 1.3;
        }

        .contact {
            margin-top: 20px;
        }

        .border-table td,
        .border-table th {
            border: 1px solid #ddd;
            padding: 4px 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            margin-top: 15px;
        }

        td {
            padding-bottom: 5px;
        }

        .justify-text {
            text-align: justify;
            width: 100%;
            margin: auto;
        }

        .footer {
            width: 100%;
            margin-top: 30px;
            /* Mengurangi jarak dari konten di atasnya */
        }

        .content-wrap {
            padding-bottom: 20px;
        }

        .no-break {
            page-break-inside: avoid;
        }

        /* Container utama untuk mengatur tata letak */
        .container {
            max-width: 100%;
            margin: 0 auto;
            position: relative;
        }

        /* Untuk bagian tanda tangan */
        .signature {
            margin-top: 20px;
            /* Mengurangi jarak atas */
        }

        .signature p {
            margin: 4px 0;
            /* Mengurangi margin pada paragraf */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content-wrap">
            <!-- Header -->

            <!-- Surat Detail -->
            <div class="text-smaller">
                <table border="0">
                    <tr>
                        <td style="width: 10%; border: none;">Nomor</td>
                        <td style="width: 90%; border: none;">:
                            {{ $workRequest->orderCommunications->first()->no_negotiationletter ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%; border: none;">Sifat</td>
                        <td style="width: 90%; border: none;">: Segera</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; border: none;">Lampiran</td>
                        <td style="width: 90%; border: none;">: 1 ( satu ) set</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; border: none; vertical-align: top;">Lamp</td>
                        <td style="width: 90%; border: none; vertical-align: top;">
                            <div style="display: inline-block; vertical-align: top;">: Surat Permohonan Penawaran Harga
                                (SPPH) {{ $workRequest->project_title ?? '-' }}</div>
                            <div style="display: inline-block; width: calc(100% - 10px);">
                                <strong></strong>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- Tanggal --}}
            <table border="0">
                <tr>
                    <td style="width: 100%; border: none;">
                        Jakarta,
                        {{ $workRequest->orderCommunications->first()->date_negotiationletter
                            ? \Carbon\Carbon::parse($workRequest->orderCommunications->first()->date_negotiationletter)->translatedFormat(
                                'd F Y',
                            )
                            : '-' }}
                    </td>
                </tr>
            </table>

            {{-- Kepada yth --}}
            <table border="0">
                <tr>
                    <td style="width: 100%; border: none;">Kepada Yth.</td>
                </tr>
                <tr>
                    <td style="width: 100%; border: none;"><strong>Bapak Rizky Ajie Kurniawan</strong></td>
                </tr>
                <tr>
                    <td style="width: 100%; border: none;">Jl. Pd. Cabe Raya, Kec. Pamulang, Kota
                        Tangerang Selatan,
                        Banten 15418
                    </td>
                </tr>
            </table>

            <!-- Isi Surat -->
            <div class="mt-4 text-smaller justify-text leading-relaxed">
                Berdasarkan surat Saudara nomor {{ $workRequest->orderCommunications->first()->no_offerletter }} perihal
                Penawaran Teknis dan Harga {{ $workRequest->project_title }}, bersama ini kami
                mengundang Saudara untuk dapat hadir pada :
            </div>
            <!-- Informasi Pembayaran -->
            <div class="mt-2 text-smaller">
                <table class="w-full mt-2 text-smaller" style="border-collapse: collapse; width:100%;">
                    <tr>
                        <td style="width:25%;">Hari</td>
                        <td style="width:75%; text-align:left;">:
                            {{ $workRequest->orderCommunications->first()->date_negotiationletter
                                ? \Carbon\Carbon::parse($workRequest->orderCommunications->first()->date_negotiationletter)->addDays(2)->translatedFormat('l')
                                : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>:
                            {{ $workRequest->orderCommunications->first()->date_negotiationletter
                                ? \Carbon\Carbon::parse($workRequest->orderCommunications->first()->date_negotiationletter)->addDays(2)->translatedFormat('d F Y')
                                : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Pukul</td>
                        <td>: 10.00 WIB Sd. Selesai</td>
                    </tr>
                    <tr>
                        <td>Tempat</td>
                        <td>: PT. Karya Prima Usahatama</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp; Ruko Ketapang Indah Blok A2 No. 8</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>&nbsp; Jl. KH. Zainul Arifin</td>
                    </tr>
                </table>
            </div>
            <div class="contact text-smaller">
                <div>
                    Mengingat pentingnya pembahasan tersebut di atas, kami mengharapkan kehadiran Saudara tepat pada
                    waktunya.
                </div>
            </div>
            <div class="contact text-smaller">
                <div>
                    Demikian, atas perhatiannya disampaikan terima kasih.
                </div>
            </div>
        </div>

        <!-- Footer dengan tanda tangan -->
        <div class="footer no-break signature">
            <p>PT Karya Prima Usahatama</p>
            <br><br>
            <br><br>
            <p>Manager SDM dan Umum</p>
        </div>
    </div>
</body>

</html>
