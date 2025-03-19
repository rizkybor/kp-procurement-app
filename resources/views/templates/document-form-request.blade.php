<!DOCTYPE html>
<html lang="id">

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
            margin-top: 100px;
            text-align: center;
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
                    <h2>PEKERJAAN ...............</h2>
                </td>
            </tr>
        </table>

        <table width="100%" border="0" style="border-collapse: collapse;">
            <tr>
                <td style="border: none;">Bagian/Divisi</td>
                <td style="border: none;">: {{ $bagian ?? '...' }}</td>
                <td style="border: none;">Nomor</td>
                <td style="border: none;">: {{ $nomor ?? '...' }}</td>
            </tr>
            <tr>
                <td style="border: none;">Judul Proyek</td>
                <td style="border: none;">: {{ $judul_proyek ?? '...' }}</td>
                <td style="border: none;">Tanggal</td>
                <td style="border: none;">: {{ $tanggal ?? '...' }}</td>
            </tr>
            <tr>
                <td style="border: none;">Pemilik Proyek</td>
                <td style="border: none;">: {{ $pemilik_proyek ?? '...' }}</td>
                <td style="border: none;">Tenggat</td>
                <td style="border: none;">: {{ $tenggat ?? '...' }}</td>
            </tr>
            <tr>
                <td style="border: none;">No. Kontrak</td>
                <td style="border: none;">: {{ $no_kontrak ?? '...' }}</td>
                <td style="border: none;">PIC</td>
                <td style="border: none;">: {{ $pic ?? '...' }}</td>
            </tr>
            <tr>
                <td style="border: none;">Jenis Pengadaan</td>
                <td style="border: none;">: Barang/Jasa*</td>
                <td style="border: none;">Aanwijzing</td>
                <td style="border: none;">: Ya/Tidak*</td>
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
                @if (!empty($items) && count($items) > 0)
                    @foreach ($items as $index => $item)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td>{{ $item['deskripsi'] }}</td>
                            <td style="text-align: center;">{{ $item['jumlah'] }}</td>
                            <td style="text-align: center;">{{ $item['satuan'] }}</td>
                            <td>{{ $item['keterangan'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data tersedia.</td>
                    </tr>
                @endif
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

        <p>* Coret salah satu</p>
    </div>
</body>

</html>
