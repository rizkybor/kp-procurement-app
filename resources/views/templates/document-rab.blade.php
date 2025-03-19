<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENCANA ANGGARAN BIAYA (RAB)</title>
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
            margin-top: 20px;
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
                    <h2>RENCANA ANGGARAN BIAYA (RAB)</h2>
                    <h2>PEKERJAAN ...............</h2>
                </td>
            </tr>
        </table>

        <table width="100%" border="0" style="border-collapse: collapse; margin: auto;">
            <tr>
                <td style="width: 30%; border: none;">Bagian/Divisi</td>
                <td style="width: 70%; border: none;">: {{ $bagian ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Judul Proyek</td>
                <td style="width: 70%; border: none;">: {{ $judul_proyek ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Pemilik Proyek</td>
                <td style="width: 70%; border: none;">: {{ $pemilik_proyek ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">No. Kontrak</td>
                <td style="width: 70%; border: none;">: {{ $no_kontrak ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Jenis Pengadaan</td>
                <td style="width: 70%; border: none;">: Barang/Jasa*</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Nomor Permintaan</td>
                <td style="width: 70%; border: none;">: {{ $nomor ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Tanggal</td>
                <td style="width: 70%; border: none;">: {{ $tanggal ?? '...' }}</td>
            </tr>
        </table>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
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
                            <td style="text-align: center;">{{ $item['harga'] }}</td>
                            <td style="text-align: center;">{{ $item['total_harga'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada data tersedia.</td>
                    </tr>
                @endif
            </tbody>
            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                <tr>
                    <td class="p-2 whitespace-nowrap border-none" colspan="4" style="text-align: right;"><strong>Sub
                            Total :</strong>
                    </td>
                    <td class="p-2 whitespace-nowrap text-center" colspan="2"><strong>Rp. </strong></td>
                </tr>


            </tbody>
        </table>


        <p><em>Keterangan: Telah sesuai dengan RKAP/Project Charter dan penyesuaiannya</em></p>


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
    </div>
</body>

</html>
