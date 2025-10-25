<!DOCTYPE html>
<html lang="id">

@php
    \Carbon\Carbon::setLocale('id');
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Permintaan Pekerjaan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 90%;
            margin: auto;
        }

        .header {
            text-align: center;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: yellow;
            text-align: center;
        }

        .signature {
            page-break-inside: avoid;
            break-inside: avoid-page;
            /* margin-top: 100px; */
                            margin-top: 40px;
            text-align: center;
        }

        /* Saat dicetak ke PDF, letakkan tanda tangan di bawah halaman terakhir */
        @media print {
            body {
                position: relative;
                min-height: 100vh;
            }

            .signature {
                position: relative;
                bottom: 0;
                margin-top: 40px;
            }
        }

        .signature div {
            display: inline-block;
            width: 45%;
        }

        ol {
            padding-left: 0;
            margin-left: 20px;
            /* Sesuaikan sesuai kebutuhan */
        }

        .footerKpu {
            padding: 32px;
            font-size: 11px;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .footerKpu td {
            vertical-align: top;
        }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%" border="0" style="border-collapse: collapse;">
            <tr>
                <td style="border: none;">
                    <img src="file://{{ public_path('images/logo-kpu-ls.png') }}"
                        alt="Logo KPU"style="height: 50px; width: auto;">
                </td>
            </tr>
            <tr>
                <td class="header" style="border: none;">
                    <h2>FORMULIR PERMINTAAN</h2>
                    <h2>PEKERJAAN {{ strtoupper($workRequest->work_name_request) }}</h2>
                </td>
            </tr>
        </table>

        <table width="100%" border="0" style="border-collapse: collapse;">
            <tr>
                <td style="border: none;">Bagian/Divisi</td>
                <td style="border: none;">: {{ $workRequest->department ?? '...' }}</td>
                <td style="border: none;">Nomor</td>
                <td style="border: none;">: {{ $workRequest->request_number ?? '...' }}</td>
            </tr>
            <tr>
                <td style="border: none;">Judul Proyek</td>
                <td style="border: none;">: {{ $workRequest->project_title ?? '...' }}</td>
                <td style="border: none;">Tanggal</td>
                <td style="border: none;">
                    : {{ \Carbon\Carbon::parse($workRequest->request_date)->translatedFormat('l, d F Y') ?? '...' }}
                </td>

            </tr>
            <tr>
                <td style="border: none;">Pemilik Proyek</td>
                <td style="border: none;">: {{ $workRequest->User->name ?? '...' }}</td>
                <td style="border: none;">Tenggat</td>
                <td style="border: none;">:
                    {{ \Carbon\Carbon::parse($workRequest->deadline)->translatedFormat('l, d F Y') ?? '...' }}</td>
            </tr>
            <tr>
                <td style="border: none;">No. Kontrak</td>
                <td style="border: none;">: {{ $workRequest->request_number ?? '...' }}</td>
                <td style="border: none;">PIC</td>
                <td style="border: none;">: {{ $workRequest->pic ?? '...' }}</td>
            </tr>
            <tr>
                <td style="border: none;">Jenis Pengadaan</td>
                <td style="border: none;">: {{ $workRequest->procurement_type ?? '...' }}</td>
                <td style="border: none;">Aanwijzing</td>
                <td style="border: none;">: {{ $workRequest->aanwijzing ?? '...' }}</td>
            </tr>
        </table>


        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($workRequest->workRequestItems as $index => $item)
                    <tr>
                        <td style="text-align: center;">{{ $index + 1 }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        <td style="text-align: center;">{{ $item->unit }}</td>
                        <td>{{ $item->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        <p><em> Lampiran:</em></p>
        <ol>
            <em>
                <li>Rencana Anggaran Biaya (RAB)</li>
                <li>Bukti Ketersediaan Anggaran (RKAP/Project Charter)</li>
                <li>KAK / Spesifikasi Teknis</li>
                <li>Bill of Quantity (BQ)</li>
            </em>
        </ol>

        <div class="signature">
            <div>
                <p>Pengguna Barang / Jasa,</p>
                <br><br>
                <p>_____________________</p>
                <p>(Pengguna Barang / Jasa)</p>
            </div>
            <div>
                <p>Menyetujui,</p>
                <br><br>
                <p>_____________________</p>
                <p>(Sesuai dengan kewenangan)</p>
            </div>
        </div>

        {{-- <p>* Coret salah satu</p> --}}
    </div>

    {{-- Footer --}}
    <div class="footerKpu mt-2 text-smaller">
        <table border="0">
            <tr>
                <td style="width: 30%; border: none;">
                    <strong>PT. KARYA PRIMA USAHATAMA<br><em>melayani & memahami</em></strong>
                </td>
                <td style="width: 30%; border: none;">
                    RUKO KETAPANG INDAH BLOK A2 NO.8<br>Jl. K.H. Zainul Arifin<br>Jakarta Barat - 11140<br>Indonesia
                </td>
                <td style="width: 30%; border: none;">
                    <strong>T</strong>: +62 21-6343 558 <br> <strong>E</strong>: contact@pt-kpusahatama.com
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
