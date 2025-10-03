<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Order Management</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 1.5cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 16pt;
        }

        .header p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .no {
            width: 5%;
        }

        .tanggal {
            width: 10%;
        }

        .document {
            width: 20%;
        }

        .uraian {
            width: 25%;
        }

        .dari {
            width: 15%;
        }

        .kepada {
            width: 15%;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
        }

        .instructions {
            font-size: 9pt;
            font-style: italic;
            margin-top: 5px;
        }

        .logo-container {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="file://{{ public_path('images/logo-kpu-ls.png') }}" alt="Logo KPU" style="height: 50px; width: auto;">
    </div>
    <div class="header">
        <h1>DOKUMEN ORDER MANAGEMENT</h1>
        <!-- Check if orderCommunications exists and has at least one record -->
        @if ($workRequest->orderCommunications && $workRequest->orderCommunications->count() > 0)
            <!-- Use the first orderCommunication record -->
            @php $orderCom = $workRequest->orderCommunications->first() @endphp
            <p>{{ $orderCom->vendor->name ?? '-' }}</p>
            <p>{{ $orderCom->vendor->company_address ?? '-' }}</p>
            <p>{{ $orderCom->vendor->business_type ?? '-' }}</p>
        @else
            <p>-</p>
            <p>-</p>
            <p>-</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th class="no">No</th>
                <th class="tanggal">Tanggal</th>
                <th class="document">No Document</th>
                <th class="uraian">Uraian</th>
                <th class="dari">Dari</th>
                <th class="kepada">Kepada</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ \Carbon\Carbon::parse($workRequest->created_at)->format('m/d/Y') }}</td>
                <td>{{ $workRequest->request_number }}</td>
                <td>Formulir Permintaan Pengadaan Barang Jasa</td>
                <td>{{ $workRequest->request_number }}</td>
                <td>Fungsi Pengadaan</td>
            </tr>

            <!-- Check if orderCommunications exists and has at least one record -->
            @if ($workRequest->orderCommunications && $workRequest->orderCommunications->count() > 0)
                @php $orderCom = $workRequest->orderCommunications->first() @endphp
                <tr>
                    <td>2</td>
                    <td>{{ $orderCom->date_applicationletter ?? '-' }}</td>
                    <td>{{ $orderCom->no_applicationletter ?? '-' }}</td>
                    <td>Surat Permohonan Permintaan Harga</td>
                    <td>Fungsi Pengadaan</td>
                    <td>{{ $orderCom->company_name ?? ($orderCom->vendor->name ?? 'Vendor') }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>{{ $orderCom->date_offerletter ?? '-' }}</td>
                    <td>{{ $orderCom->no_offerletter ?? '-' }}</td>
                    <td>Surat Penawaran Harga</td>
                    <td>{{ $orderCom->company_name ?? ($orderCom->vendor->name ?? 'Vendor') }}</td>
                    <td>Fungsi Pengadaan</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>{{ $orderCom->date_evaluationletter ?? '-' }}</td>
                    <td>{{ $orderCom->no_evaluationletter ?? '-' }}</td>
                    <td>Evaluasi Teknis Penawaran Mitra</td>
                    <td>Fungsi Pengadaan</td>
                    <td>{{ $workRequest->user->department ?? '-' }}</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>{{ $orderCom->date_negotiationletter ?? '-' }}</td>
                    <td>{{ $orderCom->no_negotiationletter ?? '-' }}</td>
                    <td>Surat undangan klarifikasi dan negoisasi harga</td>
                    <td>Fungsi Pengadaan</td>
                    <td>{{ $orderCom->company_name ?? ($orderCom->vendor->name ?? 'Vendor') }}</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>{{ $orderCom->date_beritaacaraklarifikasi ?? '-' }}</td>
                    <td>{{ $orderCom->no_beritaacaraklarifikasi ?? '-' }}</td>
                    <td>Berita Acara Klarifikasi & Negoisasi Harga</td>
                    <td>Fungsi Pengadaan</td>
                    <td>{{ $orderCom->company_name ?? ($orderCom->vendor->name ?? 'Vendor') }}</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>{{ $orderCom->date_beritaacaraklarifikasi ?? '-' }}</td>
                    <td>{{ $orderCom->no_beritaacaraklarifikasi ?? '-' }}</td>
                    <td>Lampiran Berita Acara Klarifikasi & Negoisasi Harga</td>
                    <td>Fungsi Pengadaan</td>
                    <td>{{ $orderCom->company_name ?? ($orderCom->vendor->name ?? 'Vendor') }}</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>{{ $orderCom->date_suratpenunjukan ?? '-' }}</td>
                    <td>{{ $orderCom->no_suratpenunjukan ?? '-' }}</td>
                    <td>Surat Penunjukkan Penyedia Barang/Jasa</td>
                    <td>Fungsi Pengadaan</td>
                    <td>{{ $orderCom->company_name ?? ($orderCom->vendor->name ?? 'Vendor') }}</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>{{ $orderCom->date_bentukperikatan ?? '-' }}</td>
                    <td>{{ $orderCom->no_bentukperikatan ?? '-' }}</td>
                    <td>Bentuk Perikatan Perjanjian/SPK/PO</td>
                    <td>Fungsi Pengadaan</td>
                    <td>{{ $orderCom->company_name ?? ($orderCom->vendor->name ?? 'Vendor') }}</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>{{ $orderCom->date_bap ?? '-' }}</td>
                    <td>{{ $orderCom->no_bap ?? '-' }}</td>
                    <td>Berita Acara Pemeriksaan Pekerjaan (BAP)</td>
                    <td>Fungsi Pengadaan</td>
                    <td>{{ $orderCom->company_name ?? ($orderCom->vendor->name ?? 'Vendor') }}</td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>{{ $orderCom->date_bast ?? '-' }}</td>
                    <td>{{ $orderCom->no_bast ?? '-' }}</td>
                    <td>Berita Acara Serah Terima Pekerjaan (BAST)</td>
                    <td>Fungsi Pengadaan</td>
                    <td>{{ $orderCom->company_name ?? ($orderCom->vendor->name ?? 'Vendor') }}</td>
                </tr>
            @else
                <!-- Display empty rows if no orderCommunications exist -->
                @for ($i = 2; $i <= 11; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endfor
            @endif
        </tbody>
    </table>
</body>

</html>
