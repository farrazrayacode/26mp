<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Order {{ $record->wo_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        body {
            padding: 20px;
            background: white;
        }

        .header {
            text-align: center;
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 0;
        }

        .logo-text {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .logo-text span {
            font-size: 32px;
            font-weight: 900;
        }

        .address {
            font-size: 11px;
            margin-top: 5px;
            color: #333;
        }

        .title-section {
            border: 1px solid #000;
            border-top: none;
            text-align: center;
            padding: 8px;
            margin-bottom: 0;
        }

        .title-section h1 {
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 3px;
        }

        .info-section {
            border: 1px solid #000;
            border-top: none;
            width: 100%;
        }

        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-section td {
            padding: 5px 8px;
            vertical-align: top;
            border: none;
        }

        .info-section .label {
            width: 90px;
            font-weight: normal;
        }

        .info-section .colon {
            width: 10px;
        }

        .info-section .divider {
            border-left: 1px solid #000;
        }

        .service-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            border-top: none;
        }

        .service-table th,
        .service-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
        }

        .service-table th {
            background: #f5f5f5;
            font-weight: bold;
            text-align: center;
            font-size: 11px;
            letter-spacing: 1px;
        }

        .service-table .no-col { width: 40px; text-align: center; }
        .service-table .time-col { width: 80px; text-align: center; }
        .service-table .price-col { width: 100px; text-align: center; }

        .empty-row td {
            height: 30px;
        }

        .signature-section {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            border-top: none;
        }

        .signature-section td {
            padding: 8px;
            vertical-align: top;
        }

        .signature-box {
            text-align: center;
            border-left: 1px solid #000;
        }

        .signature-box .name {
            font-weight: bold;
            font-size: 14px;
            margin-top: 40px;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #2563EB;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .print-btn:hover {
            background: #1d4ed8;
        }

        @media print {
            .print-btn { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    {{-- Tombol Print --}}
    <button class="print-btn" onclick="window.print()">
        🖨️ Print / Save PDF
    </button>

    {{-- Header Logo --}}
    <div class="header">
        <div class="logo-text"><span>26</span> MOTOR PREMIUM</div>
        <div class="address">Jl. Babakan Jeruk III No.44, Sukagalih, Kec. Sukajadi, Kota Bandung, Jawa Barat 40163</div>
    </div>

    {{-- Judul --}}
    <div class="title-section">
        <h1>WORK ORDER</h1>
    </div>

    {{-- Info Kendaraan --}}
    <div class="info-section">
        <table>
            <tr>
                <td class="label">Nomor Polisi</td>
                <td class="colon">:</td>
                <td><strong>{{ $record->vehicle->plate_number }}</strong></td>
                <td class="divider label">Nomor WO</td>
                <td class="colon">:</td>
                <td>{{ $record->wo_number }}</td>
            </tr>
            <tr>
                <td class="label">Customer</td>
                <td class="colon">:</td>
                <td>{{ $record->customer->name }}</td>
                <td class="divider label">Tanggal</td>
                <td class="colon">:</td>
                <td>{{ $record->created_at->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td class="label">No Telp</td>
                <td class="colon">:</td>
                <td>{{ $record->customer->phone ?? '-' }}</td>
                <td class="divider label">Jam Masuk</td>
                <td class="colon">:</td>
                <td>{{ $record->gate_in_at->format('H:i:s') }}</td>
            </tr>
            <tr>
                <td class="label">Vehicle Brand</td>
                <td class="colon">:</td>
                <td>{{ ($record->vehicle->brand ?? '') . ' ' . ($record->vehicle->type ?? '') }}</td>
                <td class="divider label">KM Masuk</td>
                <td class="colon">:</td>
                <td>{{ $record->km_in ? number_format($record->km_in, 0, ',', '.') . ' KM' : '-' }}</td>
            </tr>
            <tr>
                <td class="label">VIN</td>
                <td class="colon">:</td>
                <td>{{ $record->vehicle->vin ?? '-' }}</td>
                <td class="divider label">Mekanik</td>
                <td class="colon">:</td>
                <td>{{ $record->mechanic ?? '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- Tabel Service Description --}}
    <table class="service-table">
        <thead>
            <tr>
                <th class="no-col" rowspan="2">NO</th>
                <th rowspan="2">SERVICE DESCRIPTION</th>
                <th colspan="2">ESTIMATION</th>
            </tr>
            <tr>
                <th class="time-col">TIME</th>
                <th class="price-col">PRICE</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="no-col"></td>
                <td style="height: 25px; font-family: monospace;">
                    @if($record->complaint)
                        {{ $record->complaint }}
                    @endif
                </td>
                <td class="time-col"></td>
                <td class="price-col"></td>
            </tr>
            {{-- Empty rows untuk mekanik isi --}}
            @for($i = 0; $i < 8; $i++)
            <tr class="empty-row">
                <td class="no-col"></td>
                <td></td>
                <td class="time-col"></td>
                <td class="price-col"></td>
            </tr>
            @endfor
        </tbody>
    </table>

    {{-- Tabel Part Description --}}
    <table class="service-table">
        <thead>
            <tr>
                <th class="no-col">NO</th>
                <th>PART DESCRIPTION</th>
                <th style="width: 120px;">NUMBER PART</th>
                <th style="width: 60px;">QTY</th>
                <th class="price-col">PRICE</th>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < 5; $i++)
            <tr class="empty-row">
                <td class="no-col"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @endfor
        </tbody>
    </table>

    {{-- Tanda Tangan --}}
    <table class="signature-section">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <strong>Remarks,</strong>
            </td>
            <td class="signature-box" style="width: 25%;">
                <div>Administrator</div>
                <div class="name">{{ auth()->user()->name }}</div>
            </td>
            <td class="signature-box" style="width: 25%;">
                <div>CUSTOMER</div>
                <div class="name">{{ $record->customer->name }}</div>
            </td>
        </tr>
    </table>

</body>
</html>