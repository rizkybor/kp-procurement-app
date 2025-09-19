<!DOCTYPE html>
<html lang="id">

@php
    \Carbon\Carbon::setLocale('id');
@endphp

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
                    <h2>RENCANA ANGGARAN BIAYA (RAB)</h2>
                    <h2>PEKERJAAN {{ strtoupper($workRequest->work_name_request) }}</h2>
                </td>
            </tr>
        </table>

        <table width="100%" border="0" style="border-collapse: collapse; margin: auto;">
            <tr>
                <td style="width: 30%; border: none;">Bagian/Divisi</td>
                <td style="width: 70%; border: none;">: {{ $workRequest->department ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Judul Proyek</td>
                <td style="width: 70%; border: none;">: {{ $workRequest->project_title ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Pemilik Proyek</td>
                <td style="width: 70%; border: none;">: {{ $workRequest->project_owner ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">No. Kontrak</td>
                <td style="width: 70%; border: none;">: {{ $workRequest->contract_number ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Jenis Pengadaan</td>
                <td style="width: 70%; border: none;">: {{ $workRequest->procurement_type ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Nomor Permintaan</td>
                <td style="width: 70%; border: none;">: {{ $workRequest->request_number ?? '...' }}</td>
            </tr>
            <tr>
                <td style="width: 30%; border: none;">Tanggal</td>
                <td style="width: 70%; border: none;">:
                    {{ \Carbon\Carbon::parse($workRequest->request_date)->translatedFormat('l, d F Y') ?? '...' }}</td>
            </tr>
        </table>

        @php
            $subTotal = $workRequest->workRequestItems->sum('total_harga');
        @endphp

        <table class="table-auto w-full">
            <!-- Table header -->
            <thead
                class="text-xs font-semibold uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700 dark:bg-opacity-50">
                <tr>
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-center">No</div>
                    </th>
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-left">Deskripsi</div>
                    </th>
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-center">Jumlah</div>
                    </th>
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-center">Satuan</div>
                    </th>
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-center">Harga</div>
                    </th>
                    <th class="p-2 whitespace-nowrap">
                        <div class="font-semibold text-center">Total Harga</div>
                    </th>
                </tr>
            </thead>

            <!-- Table body -->
            <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                @forelse ($workRequest->workRequestItems as $index => $item)
                    <tr>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">{{ $index + 1 }}</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-left">{{ $item->description }}</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">{{ $item->quantity }}</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">{{ $item->unit }}</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">Rp. {{ number_format($item->harga, 0, ',', '.') }}</div>
                        </td>
                        <td class="p-2 whitespace-nowrap">
                            <div class="text-center">Rp. {{ number_format($item->total_harga, 0, ',', '.') }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-2" style="text-align: center;">Tidak ada data tersedia.</td>
                    </tr>
                @endforelse
            </tbody>

            <!-- Subtotal -->
            @if ($workRequest->workRequestItems->count())
                <tbody class="text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                    <tr>
                        <td colspan="4" class="p-2 whitespace-nowrap text-right">

                        </td>
                        <td colspan="1" class="p-2 whitespace-nowrap">
                            <div class="text-center"><strong>Sub Total :</strong></div>
                        </td>
                        <td colspan="1" class="p-2 whitespace-nowrap text-center">
                            <strong>Rp. {{ number_format($subTotal, 0, ',', '.') }}</strong>
                        </td>
                    </tr>
                </tbody>
            @endif
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
