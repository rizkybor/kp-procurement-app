<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permohonan Pembayaran</title>
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
            margin-bottom: 8px;
            margin-top: 10px;
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
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 10%; border: none;">Sifat</td>
                        <td style="width: 90%; border: none;">: </td>
                    </tr>
                    <tr>
                        <td style="width: 10%; border: none;">Lampiran</td>
                        <td style="width: 90%; border: none;">:</td>
                    </tr>
                    <tr>
                        <td style="width: 10%; border: none; vertical-align: top;">Perihal</td>
                        <td style="width: 90%; border: none; vertical-align: top;">
                            <div style="display: inline-block; vertical-align: top;">:</div>
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
                    </td>
                </tr>
            </table>

            {{-- Kepada yth --}}
            <table border="0">
                <tr>
                    <td style="width: 100%; border: none;">Kepada Yth.</td>
                </tr>
                <tr>
                    <td style="width: 100%; border: none;"><strong></strong></td>
                </tr>
                <tr>
                    <td style="width: 100%; border: none;"></td>
                </tr>
            </table>

            <!-- Isi Surat -->
            <div class="mt-4 text-smaller justify-text leading-relaxed">
                Dengan Hormat,
            </div>
            <div class="mt-4 text-smaller justify-text leading-relaxed">
                Sehubungan dengan adanya "". Kami memberikan kesempatan kepada "", agar dapat menyampaikan Surat
                Penawaran
                Harga (SPH), berkaitan dengan hal tersebut, kami memerlukan hal sebagai berikut :
            </div>

            <!-- Detail Pembayaran -->
            <table class="w-full mt-4 text-smaller" style="border-collapse: collapse; width:100%;">
                <tr>
                    <td style="width:5%;">1.</td>
                    <td style="width:30%;">Rincian Harga</td>
                    <td style="width:65%;"></td>
                </tr>
                <tr>
                    <td>2.</td>
                    <td>Metode Pekerjaan</td>
                    <td></td>
                </tr>
                <tr>
                    <td>3.</td>
                    <td>Metode Pembayaran</td>
                    <td></td>
                </tr>
            </table>

            <!-- Informasi Pembayaran -->
            <div class="mt-2 text-smaller">
                <div>
                    Penyampaian dokumen penawaran:
                </div>
                <table class="w-full mt-2 text-smaller" style="border-collapse: collapse; width:100%;">
                    <tr>
                        <td style="width:5%;">1.</td>
                        <td style="width:20%;">Hari / Tanggal</td>
                        <td style="width:75%; text-align:left;">: 10 Februari 2025 Sampai dengan tanggal 14 Februari
                            2025</td>
                    </tr>
                    <tr>
                        <td>2.</td>
                        <td>Waktu</td>
                        <td>: Selambat-lambatnya sampai dengan pukul 14:00 WIB</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Tempat</td>
                        <td>: PT. Karya Prima Usahatama</td>
                    </tr>
                </table>
            </div>

            <div class="alamat text-justify">
                <p>
                    PT. Karya Prima Usahatama
                </p>
                <p>
                    Ruko Ketapang Indah Blok A2/8
                </p>
                <p>
                    Jl. KH. Zainul Arifin No.1
                </p>
                <p>
                    Jakarta Barat – 11140
                </p>
                <p>
                    Tel : 021 6343 558
                </p>
            </div>

            <div class="contact text-smaller">
                <div>
                    Apabila diperlukan informasi lebih lanjut, dapat menghubungi contact person kami :
                </div>
                <table class="w-full mt-2 text-smaller" style="border-collapse: collapse; width:100%;">
                    <tr>
                        <td style="width:25%;">Bapak Perdi Maulana</td>
                        <td style="width:75%; text-align:left;"></td>
                    </tr>
                    <tr>
                        <td style="width:10%;">Telp</td>
                        <td style="width:90%; text-align:left;">: 021 6343 558</td>
                    </tr>
                    <tr>
                        <td style="width:10%;">Email</td>
                        <td style="width:90%; text-align:left;">: procurement@pt-kpusahatama,com</td>
                    </tr>
                </table>
                <div>
                    Demikian kami sampaikan atas perhatian dan kerjasama yang baik diucapkan terima kasih.
                </div>
            </div>
        </div>

        <!-- Footer dengan tanda tangan -->
        <div class="footer no-break signature">
            <p>Hormat Kami</p>
            <br><br>
            <p><strong>Perdi Maulana</strong></p>
            <p>Manager SDM dan Umum</p>
        </div>
    </div>
</body>

</html>
