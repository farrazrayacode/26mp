<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estimasi {{ $record->wo_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; font-size: 12px; }
        body { background: white; }

        .print-btn {
            position: fixed; top: 20px; right: 20px;
            background: #2563EB; color: white; border: none;
            padding: 10px 20px; border-radius: 8px; cursor: pointer;
            font-size: 13px; font-weight: bold;
        }
        @media print { .print-btn { display: none; } }

        .page { max-width: 800px; margin: 0 auto; padding: 0; }

        /* Header */
        .header {
            background: #2563EB;
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            margin-bottom: 0;
        }
        .header-logo {
            background: white;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            min-width: 200px;
        }
        .logo-text { font-size: 24px; font-weight: 900; color: #2563EB; letter-spacing: 1px; }
        .logo-sub { font-size: 11px; color: #666; letter-spacing: 3px; }
        .header-info {
            padding: 15px 20px;
            text-align: right;
            color: white;
        }
        .header-info .company-name { font-size: 14px; font-weight: bold; margin-bottom: 4px; }
        .header-info .company-detail { font-size: 10px; line-height: 1.6; opacity: 0.9; }
        .header-info a { color: #93c5fd; text-decoration: none; }

        /* Title Bar */
        .title-bar {
            background: #2563EB;
            padding: 12px 20px 15px;
        }
        .title-bar h1 { font-size: 32px; font-weight: 900; color: white; letter-spacing: 2px; }

        /* Info Section */
        .info-section {
            display: flex;
            padding: 20px;
            gap: 20px;
            border-bottom: 2px solid #e5e7eb;
            margin-bottom: 20px;
        }
        .info-left { flex: 1; }
        .info-right { flex: 1; }
        .info-row { display: flex; margin-bottom: 5px; }
        .info-label { width: 120px; color: #666; }
        .info-colon { width: 15px; color: #666; }
        .info-value { font-weight: bold; flex: 1; }
        .divider-vertical { width: 1px; background: #e5e7eb; margin: 0 10px; }

        /* Table */
        .items-table { width: 100%; border-collapse: collapse; margin: 0 20px; width: calc(100% - 40px); }
        .items-table th {
            background: #f9fafb;
            border-top: 2px solid #2563EB;
            border-bottom: 2px solid #2563EB;
            padding: 8px 12px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .items-table td { padding: 8px 12px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        .items-table .no-col { width: 40px; text-align: center; }
        .items-table .qty-col { width: 50px; text-align: center; }
        .items-table .uom-col { width: 60px; }
        .items-table .disc-col { width: 80px; text-align: right; }
        .items-table .price-col { width: 110px; text-align: right; }
        .items-table .amount-col { width: 110px; text-align: right; }
        .items-table .bold-row td { font-weight: bold; }

        /* Summary */
        .summary-section { display: flex; padding: 20px; gap: 20px; margin-top: 20px; }
        .summary-left { flex: 1; }
        .summary-right { width: 280px; }
        .inwords { font-style: italic; margin-bottom: 10px; }
        .remark-label { color: #666; margin-bottom: 4px; }
        .remark-value { font-style: italic; }

        .summary-table { width: 100%; border-collapse: collapse; }
        .summary-table td { padding: 5px 8px; }
        .summary-table .label-col { color: #555; font-weight: bold; }
        .summary-table .value-col { text-align: right; }
        .summary-table .total-row td { border-top: 2px solid #2563EB; font-weight: bold; padding-top: 8px; }
        .summary-table .total-row .value-col { color: #2563EB; font-size: 14px; }

        /* Footer */
        .footer {
            background: #2563EB;
            text-align: center;
            padding: 18px;
            margin-top: 30px;
        }
        .footer p { color: white; font-size: 15px; font-style: italic; font-weight: bold; }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">🖨️ Print / Save PDF</button>

    <div class="page">

        {{-- Header --}}
        <div class="header">
            <div class="header-logo">
                <div>
                    <div class="logo-text">26 MOTOR</div>
                    <div class="logo-sub">PREMIUM</div>
                </div>
            </div>
            <div class="header-info">
                <div class="company-name">26 Motor Premium Bandung</div>
                <div class="company-detail">
                    Jl. Babakan Jeruk III No.44, Sukagalih, Kec. Sukajadi, Kota<br>
                    Bandung, Jawa Barat 40163<br>
                    62 812-3980-9108<br>
                    26motorpremiumbandung@gmail.com<br>
                    <a href="#">premium.26motor.com</a>
                </div>
            </div>
        </div>

        {{-- Title Bar --}}
        <div class="title-bar">
            <h1>ESTIMATION</h1>
        </div>

        {{-- Info Section --}}
        <div class="info-section">
            <div class="info-left">
                <div class="info-row">
                    <span class="info-label">Customer ID</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $record->customer->id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Estimation Date</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ now()->format('n/j/Y') }}</span>
                </div>
            </div>
            <div class="divider-vertical"></div>
            <div class="info-right">
                <div class="info-row">
                    <span class="info-label">CUSTOMER NAME</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $record->customer->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Police Number</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $record->vehicle->plate_number }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Vehicle Type</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $record->vehicle->type ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Vehicle Brand</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $record->vehicle->brand ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">VIN</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $record->vehicle->vin ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">KM</span>
                    <span class="info-colon">:</span>
                    <span class="info-value">{{ $record->km_in ? number_format($record->km_in, 0, ',', '.') : '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Tabel Item --}}
        <table class="items-table">
            <thead>
                <tr>
                    <th class="no-col">NO</th>
                    <th>PRODUCT/SERVICE DESCRIPTION</th>
                    <th class="qty-col">QTY</th>
                    <th class="uom-col">UOM</th>
                    <th class="disc-col">DISC</th>
                    <th class="price-col">PRICE</th>
                    <th class="amount-col">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach($record->estimationItems as $item)
                <tr class="{{ $loop->first || $item->qty > 0 ? 'bold-row' : '' }}">
                    <td class="no-col">{{ $item->qty > 0 ? $no++ : '' }}</td>
                    <td>{{ $item->description }}</td>
                    <td class="qty-col">{{ $item->qty > 0 ? $item->qty : '' }}</td>
                    <td class="uom-col">{{ $item->uom }}</td>
                    <td class="disc-col">{{ $item->discount > 0 ? 'Rp' . number_format($item->discount, 0, ',', '.') : '' }}</td>
                    <td class="price-col">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="amount-col">Rp{{ number_format($item->amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Summary --}}
        @php
            $subtotal = $record->estimationItems->sum('amount');
            $discountGlobal = $record->invoice->discount_global ?? 0;
            $downPayment = $record->invoice->down_payment ?? 0;
            $total = $subtotal - $discountGlobal - $downPayment;
            $inwords = \App\Helpers\Terbilang::convert($total);
        @endphp

        <div class="summary-section">
            <div class="summary-left">
                <div class="inwords">Inwords : "{{ $inwords }} Rupiah"</div>
                <div class="remark-label">Remark :</div>
                <div class="remark-value">{{ $record->invoice->remark ?? '' }}</div>
            </div>
            <div class="summary-right">
                <table class="summary-table">
                    <tr>
                        <td class="label-col">Subtotal</td>
                        <td class="value-col">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="label-col">Discount</td>
                        <td class="value-col">
                            {{ $subtotal > 0 ? number_format(($discountGlobal / $subtotal) * 100, 2) : '0,00' }}%
                        </td>
                    </tr>
                    <tr>
                        <td class="label-col">Down Payment</td>
                        <td class="value-col">{{ $downPayment > 0 ? 'Rp' . number_format($downPayment, 0, ',', '.') : '' }}</td>
                    </tr>
                    <tr class="total-row">
                        <td class="label-col">TOTAL</td>
                        <td class="value-col">Rp{{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>"Committed to Quality, Dedicated to Trust."</p>
        </div>

    </div>

</body>
</html>