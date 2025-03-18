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
            margin-top: 10px;
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
            margin-top: 30px;
            text-align: center;
        }

        .signature div {
            display: inline-block;
            width: 45%;
        }
    </style>
</head>

<body>
    <div class="container">
        <table width="100%">
            <tr>
                <td><img src="{{ asset('logo.png') }}" alt="Logo" width="100"></td>
                <td class="header">
                    <h2>FORMULIR PERMINTAAN PEKERJAAN</h2>
                </td>
            </tr>
        </table>

        <table width="100%">
            <tr>
                <td>Bagian/Divisi</td>
                <td>: {{ $bagian ?? '...' }}</td>
                <td>Nomor</td>
                <td>: {{ $nomor ?? '...' }}</td>
            </tr>
            <tr>
                <td>Judul Proyek</td>
                <td>: {{ $judul_proyek ?? '...' }}</td>
                <td>Tanggal</td>
                <td>: {{ $tanggal ?? '...' }}</td>
            </tr>
            <tr>
                <td>Pemilik Proyek</td>
                <td>: {{ $pemilik_proyek ?? '...' }}</td>
                <td>Tenggat</td>
                <td>: {{ $tenggat ?? '...' }}</td>
            </tr>
            <tr>
                <td>No. Kontrak</td>
                <td>: {{ $no_kontrak ?? '...' }}</td>
                <td>PIC</td>
                <td>: {{ $pic ?? '...' }}</td>
            </tr>
            <tr>
                <td>Jenis Pengadaan</td>
                <td>: Barang/Jasa*</td>
                <td>Aanwijzing</td>
                <td>: Ya/Tidak*</td>
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

        <p><b>Lampiran:</b></p>
        <ol>
            <li>Rencana Anggaran Biaya (RAB)</li>
            <li>Bukti Ketersediaan Anggaran (RKAP/Project Charter)</li>
            <li>KAK / Spesifikasi Teknis</li>
            <li>Bill of Quantity (BQ)</li>
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
