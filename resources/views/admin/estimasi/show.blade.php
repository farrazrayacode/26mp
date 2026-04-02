@extends('layouts.admin')

@section('title', 'Buat Estimasi - 26MP')

@section('content')

    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.estimasi.index') }}"
            class="flex items-center justify-center w-8 h-8 rounded-lg border border-gray-200 hover:bg-gray-50 transition">
            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Buat Estimasi</h1>
            <p class="text-sm text-gray-500 mt-0.5">{{ $record->wo_number }} — {{ $record->vehicle->plate_number }}</p>
        </div>
    </div>

    <form action="{{ route('admin.estimasi.store', $record->id) }}" method="POST" id="form-estimasi">
        @csrf

        <div class="grid grid-cols-3 gap-6">

            {{-- Kolom Kiri (2/3) --}}
            <div class="col-span-2 space-y-6">

                {{-- Ringkasan Data --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Ringkasan Data</p>
                    </div>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-400 text-xs">No WO</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $record->wo_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">No Polisi</p>
                            <p class="font-semibold text-blue-600 mt-0.5">{{ $record->vehicle->plate_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Nama Customer</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $record->customer->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Vehicle Brand</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $record->vehicle->brand ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Vehicle Type</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $record->vehicle->type ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400 text-xs">Mekanik</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $record->mechanic ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tabel Item --}}
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-5 bg-blue-600 rounded-full"></div>
                            <p class="text-sm font-semibold text-gray-700">Item Jasa & Sparepart</p>
                        </div>
                        <button type="button" onclick="addRow()"
                            class="flex items-center gap-1.5 text-blue-600 hover:text-blue-700 text-xs font-medium border border-blue-200 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Item
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100">
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase w-8">#</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase">Deskripsi</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase w-20">QTY</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase w-20">UOM</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase w-32">Harga</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase w-32">Diskon</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-400 uppercase w-32">Amount</th>
                                    <th class="px-4 py-3 w-8"></th>
                                </tr>
                            </thead>
                            <tbody id="items-table">
                                {{-- Row pertama --}}
                                <tr class="border-b border-gray-50 item-row">
                                    <td class="px-4 py-3 text-gray-400 text-xs row-number">1</td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="items[0][description]" required
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Nama jasa / sparepart">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" name="items[0][qty]" value="1" min="1" required
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 qty-input"
                                            oninput="calculateRow(this)">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="items[0][uom]"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            placeholder="Pcs">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" name="items[0][price]" value="0" min="0" required
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 price-input"
                                            oninput="calculateRow(this)">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="number" name="items[0][discount]" value="0" min="0"
                                            class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 discount-input"
                                            oninput="calculateRow(this)">
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="amount-display text-sm font-medium text-gray-700">0</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <button type="button" onclick="removeRow(this)"
                                            class="w-6 h-6 flex items-center justify-center text-gray-300 hover:text-red-500 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan / Remark</label>
                    <textarea name="remark" rows="3"
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Catatan tambahan untuk customer..."></textarea>
                </div>

            </div>

            {{-- Kolom Kanan (1/3) --}}
            <div class="space-y-6">

                {{-- Ringkasan Biaya --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1 h-5 bg-blue-600 rounded-full"></div>
                        <p class="text-sm font-semibold text-gray-700">Ringkasan Biaya</p>
                    </div>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Subtotal</span>
                            <span class="font-medium text-gray-700" id="display-subtotal">Rp 0</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Diskon</span>
                            <input type="number" name="discount_global" value="0" min="0"
                                class="w-32 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500"
                                oninput="calculateTotal()">
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Down Payment</span>
                            <input type="number" name="down_payment" value="0" min="0"
                                class="w-32 border border-gray-200 rounded-lg px-3 py-1.5 text-sm text-right focus:outline-none focus:ring-2 focus:ring-blue-500"
                                oninput="calculateTotal()">
                        </div>

                        <div class="border-t border-gray-100 pt-3 flex justify-between">
                            <span class="font-semibold text-gray-700">Total</span>
                            <span class="font-bold text-blue-600 text-base" id="display-total">Rp 0</span>
                        </div>
                    </div>
                </div>

                {{-- Keputusan Customer --}}
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-1 h-5 bg-blue-600 rounded-full"></div>
                        <p class="text-sm font-semibold text-gray-700">Keputusan Customer</p>
                        </div>

                    <div class="space-y-3">

                {{-- Tombol Print --}}
                <button type="button" onclick="printEstimasi()"
                    class="w-full flex items-center justify-center gap-2 border border-blue-200 text-blue-600 hover:bg-blue-50 text-sm font-medium px-4 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    🖨️ Cetak PDF Estimasi
                </button>

                {{-- Tombol Customer ACC → buka modal DP --}}
                <button type="button" onclick="document.getElementById('modal-dp').classList.remove('hidden')"
                    class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    ✅ Customer ACC
                </button>

                {{-- Tombol Customer Tolak --}}
                <button type="submit" name="action" value="reject"
                    onclick="return confirm('Yakin customer menolak estimasi ini?')"
                    class="w-full flex items-center justify-center gap-2 border border-red-200 text-red-600 hover:bg-red-50 text-sm font-medium px-4 py-2.5 rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    ❌ Customer Tolak
                </button>

                    </div>
                </div>

            </div>
        </div>
    </form>

    {{-- MODAL: Down Payment --}}
    <div id="modal-dp" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4">

            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Customer ACC</h3>
                <button onclick="document.getElementById('modal-dp').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-5">
                <p class="text-sm text-gray-500 mb-4">Catat Down Payment jika customer membayar uang muka. Kosongkan jika tidak ada DP.</p>

                <form action="{{ route('admin.estimasi.store', $record->id) }}" method="POST">
                    @csrf

                {{-- Hidden fields untuk kirim semua item --}}
                <div id="hidden-items"></div>
                <input type="hidden" name="action" value="approve">
                <input type="hidden" name="discount_global" id="hidden-discount">
                <input type="hidden" name="remark" id="hidden-remark">

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Down Payment (DP)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">Rp</span>
                        <input type="number" name="down_payment" value="0" min="0"
                            class="w-full border border-gray-200 rounded-lg pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="0">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Isi 0 jika tidak ada DP</p>
                </div>

                <div class="flex gap-3">
                    <button type="button"
                        onclick="document.getElementById('modal-dp').classList.add('hidden')"
                        class="flex-1 border border-gray-200 text-gray-600 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                        Konfirmasi ACC
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script untuk copy item ke modal DP --}}
<script>
    document.getElementById('modal-dp').addEventListener('click', function(e) {
        if (e.target === this) this.classList.add('hidden');
    });

    // Saat modal DP dibuka, copy semua data form ke hidden fields
    document.querySelector('[onclick*="modal-dp"]').addEventListener('click', function() {
        // Copy items
        const hiddenItems = document.getElementById('hidden-items');
        hiddenItems.innerHTML = '';

        document.querySelectorAll('.item-row').forEach((row, i) => {
            const desc     = row.querySelector('[name*="description"]').value;
            const qty      = row.querySelector('.qty-input').value;
            const uom      = row.querySelector('[name*="uom"]').value;
            const price    = row.querySelector('.price-input').value;
            const discount = row.querySelector('.discount-input').value;

            hiddenItems.innerHTML += `
                <input type="hidden" name="items[${i}][description]" value="${desc}">
                <input type="hidden" name="items[${i}][qty]" value="${qty}">
                <input type="hidden" name="items[${i}][uom]" value="${uom}">
                <input type="hidden" name="items[${i}][price]" value="${price}">
                <input type="hidden" name="items[${i}][discount]" value="${discount}">
            `;
        });

        // Copy discount global dan remark
        const discountGlobal = document.querySelector('[name="discount_global"]').value;
        const remark         = document.querySelector('[name="remark"]').value;
        document.getElementById('hidden-discount').value = discountGlobal;
        document.getElementById('hidden-remark').value   = remark;
    });
</script>

    {{-- Script Kalkulasi --}}
    <script>
        let rowCount = 1;

        function formatRupiah(angka) {
            return 'Rp ' + Number(angka).toLocaleString('id-ID');
        }

        function calculateRow(input) {
            const row      = input.closest('tr');
            const qty      = parseFloat(row.querySelector('.qty-input').value) || 0;
            const price    = parseFloat(row.querySelector('.price-input').value) || 0;
            const discount = parseFloat(row.querySelector('.discount-input').value) || 0;
            const amount   = (qty * price) - discount;

            row.querySelector('.amount-display').textContent = formatRupiah(amount);
            calculateTotal();
        }

        function calculateTotal() {
            let subtotal = 0;

            document.querySelectorAll('.item-row').forEach(row => {
                const qty      = parseFloat(row.querySelector('.qty-input').value) || 0;
                const price    = parseFloat(row.querySelector('.price-input').value) || 0;
                const discount = parseFloat(row.querySelector('.discount-input').value) || 0;
                subtotal += (qty * price) - discount;
            });

            const discountGlobal = parseFloat(document.querySelector('[name="discount_global"]').value) || 0;
            const downPayment    = parseFloat(document.querySelector('[name="down_payment"]').value) || 0;
            const total          = subtotal - discountGlobal - downPayment;

            document.getElementById('display-subtotal').textContent = formatRupiah(subtotal);
            document.getElementById('display-total').textContent    = formatRupiah(total);
        }

        function addRow() {
            const tbody    = document.getElementById('items-table');
            const index    = rowCount;
            const newRow   = document.createElement('tr');
            newRow.classList.add('border-b', 'border-gray-50', 'item-row');
            newRow.innerHTML = `
                <td class="px-4 py-3 text-gray-400 text-xs row-number">${index + 1}</td>
                <td class="px-4 py-3">
                    <input type="text" name="items[${index}][description]" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nama jasa / sparepart">
                </td>
                <td class="px-4 py-3">
                    <input type="number" name="items[${index}][qty]" value="1" min="1" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 qty-input"
                        oninput="calculateRow(this)">
                </td>
                <td class="px-4 py-3">
                    <input type="text" name="items[${index}][uom]"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Pcs">
                </td>
                <td class="px-4 py-3">
                    <input type="number" name="items[${index}][price]" value="0" min="0" required
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 price-input"
                        oninput="calculateRow(this)">
                </td>
                <td class="px-4 py-3">
                    <input type="number" name="items[${index}][discount]" value="0" min="0"
                        class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 discount-input"
                        oninput="calculateRow(this)">
                </td>
                <td class="px-4 py-3">
                    <span class="amount-display text-sm font-medium text-gray-700">Rp 0</span>
                </td>
                <td class="px-4 py-3">
                    <button type="button" onclick="removeRow(this)"
                        class="w-6 h-6 flex items-center justify-center text-gray-300 hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </td>
            `;
            tbody.appendChild(newRow);
            rowCount++;
        }

        function removeRow(btn) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length === 1) {
                alert('Minimal harus ada 1 item!');
                return;
            }
            btn.closest('tr').remove();
            calculateTotal();

            // Update nomor urut
            document.querySelectorAll('.item-row').forEach((row, i) => {
                row.querySelector('.row-number').textContent = i + 1;
            });
        }

        function printEstimasi() {
    // Ambil data dari form
    const items = [];
    document.querySelectorAll('.item-row').forEach((row, i) => {
        const desc     = row.querySelector('[name*="description"]').value;
        const qty      = parseFloat(row.querySelector('.qty-input').value) || 0;
        const uom      = row.querySelector('[name*="uom"]').value;
        const price    = parseFloat(row.querySelector('.price-input').value) || 0;
        const discount = parseFloat(row.querySelector('.discount-input').value) || 0;
        const amount   = (qty * price) - discount;
        if (desc) items.push({ desc, qty, uom, price, discount, amount });
    });

    const discountGlobal = parseFloat(document.querySelector('[name="discount_global"]').value) || 0;
    const downPayment    = parseFloat(document.querySelector('[name="down_payment"]').value) || 0;
    const subtotal       = items.reduce((sum, i) => sum + i.amount, 0);
    const total          = subtotal - discountGlobal - downPayment;
    const remark         = document.querySelector('[name="remark"]').value;

    // Data kendaraan dari Blade
    const data = {
        customerId:    '{{ $record->customer->id }}',
        customerName:  '{{ $record->customer->name }}',
        plateNumber:   '{{ $record->vehicle->plate_number }}',
        vehicleType:   '{{ $record->vehicle->type ?? "-" }}',
        vehicleBrand:  '{{ $record->vehicle->brand ?? "-" }}',
        vin:           '{{ $record->vehicle->vin ?? "-" }}',
        kmIn:          '{{ $record->km_in ?? "-" }}',
        woNumber:      '{{ $record->wo_number ?? "-" }}',
        date:          '{{ now()->format("n/j/Y") }}',
        items,
        subtotal,
        discountGlobal,
        downPayment,
        total,
        remark,
    };

    // Fungsi terbilang sederhana
    function terbilang(n) {
        const satuan = ['','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan',
                        'Sepuluh','Sebelas','Dua Belas','Tiga Belas','Empat Belas','Lima Belas',
                        'Enam Belas','Tujuh Belas','Delapan Belas','Sembilan Belas'];
        n = Math.floor(n);
        if (n === 0) return 'Nol';
        if (n < 20) return satuan[n];
        if (n < 100) return satuan[Math.floor(n/10)+8] + ' Puluh' + (n%10 ? ' '+satuan[n%10] : '');
        if (n < 200) return 'Seratus' + (n%100 ? ' '+terbilang(n%100) : '');
        if (n < 1000) return satuan[Math.floor(n/100)] + ' Ratus' + (n%100 ? ' '+terbilang(n%100) : '');
        if (n < 2000) return 'Seribu' + (n%1000 ? ' '+terbilang(n%1000) : '');
        if (n < 1000000) return terbilang(Math.floor(n/1000)) + ' Ribu' + (n%1000 ? ' '+terbilang(n%1000) : '');
        if (n < 1000000000) return terbilang(Math.floor(n/1000000)) + ' Juta' + (n%1000000 ? ' '+terbilang(n%1000000) : '');
        return terbilang(Math.floor(n/1000000000)) + ' Miliar' + (n%1000000000 ? ' '+terbilang(n%1000000000) : '');
    }

    function formatRp(n) {
        return 'Rp' + Number(n).toLocaleString('id-ID');
    }

    // Generate HTML print
    const itemRows = data.items.map((item, i) => `
        <tr>
            <td style="text-align:center;padding:8px 12px;border-bottom:1px solid #f3f4f6;">${i+1}</td>
            <td style="padding:8px 12px;border-bottom:1px solid #f3f4f6;font-weight:bold;">${item.desc}</td>
            <td style="text-align:center;padding:8px 12px;border-bottom:1px solid #f3f4f6;">${item.qty}</td>
            <td style="padding:8px 12px;border-bottom:1px solid #f3f4f6;">${item.uom}</td>
            <td style="text-align:right;padding:8px 12px;border-bottom:1px solid #f3f4f6;">${item.discount > 0 ? formatRp(item.discount) : ''}</td>
            <td style="text-align:right;padding:8px 12px;border-bottom:1px solid #f3f4f6;">${formatRp(item.price)}</td>
            <td style="text-align:right;padding:8px 12px;border-bottom:1px solid #f3f4f6;">${formatRp(item.amount)}</td>
        </tr>
    `).join('');

    const discPct = data.subtotal > 0 ? ((data.discountGlobal / data.subtotal) * 100).toFixed(2) : '0,00';

    const html = `<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Estimasi ${data.woNumber}</title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family:Arial,sans-serif; font-size:12px; }
        body { background:white; }
        .print-btn { position:fixed; top:20px; right:20px; background:#2563EB; color:white; border:none; padding:10px 20px; border-radius:8px; cursor:pointer; font-size:13px; font-weight:bold; }
        @media print { .print-btn { display:none; } }
        .page { max-width:800px; margin:0 auto; }
        .header { background:#2563EB; display:flex; justify-content:space-between; align-items:stretch; }
        .header-logo { background:white; padding:15px 25px; display:flex; align-items:center; min-width:200px; }
        .logo-text { font-size:24px; font-weight:900; color:#2563EB; }
        .logo-sub { font-size:11px; color:#666; letter-spacing:3px; }
        .header-info { padding:15px 20px; text-align:right; color:white; }
        .header-info .cn { font-size:14px; font-weight:bold; margin-bottom:4px; }
        .header-info .cd { font-size:10px; line-height:1.6; opacity:.9; }
        .title-bar { background:#2563EB; padding:12px 20px 15px; }
        .title-bar h1 { font-size:32px; font-weight:900; color:white; letter-spacing:2px; }
        .info-section { display:flex; padding:20px; gap:20px; border-bottom:2px solid #e5e7eb; margin-bottom:20px; }
        .info-left, .info-right { flex:1; }
        .info-row { display:flex; margin-bottom:5px; }
        .lbl { width:120px; color:#666; }
        .col { width:15px; }
        .val { font-weight:bold; flex:1; }
        .divv { width:1px; background:#e5e7eb; margin:0 10px; }
        .items-table { width:calc(100% - 40px); margin:0 20px; border-collapse:collapse; }
        .items-table th { border-top:2px solid #2563EB; border-bottom:2px solid #2563EB; padding:8px 12px; font-size:11px; font-weight:bold; }
        .summary-section { display:flex; padding:20px; gap:20px; margin-top:20px; }
        .summary-left { flex:1; }
        .summary-right { width:280px; }
        .sum-table { width:100%; border-collapse:collapse; }
        .sum-table td { padding:5px 8px; }
        .sum-table .total-row td { border-top:2px solid #2563EB; font-weight:bold; padding-top:8px; color:#2563EB; font-size:14px; }
        .footer { background:#2563EB; text-align:center; padding:18px; margin-top:30px; }
        .footer p { color:white; font-size:15px; font-style:italic; font-weight:bold; }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Print / Save PDF</button>
    <div class="page">
        <div class="header">
            <div class="header-logo">
                <div>
                    <div class="logo-text">26 MOTOR</div>
                    <div class="logo-sub">PREMIUM</div>
                </div>
            </div>
            <div class="header-info">
                <div class="cn">26 Motor Premium Bandung</div>
                <div class="cd">
                    Jl. Babakan Jeruk III No.44, Sukagalih, Kec. Sukajadi, Kota<br>
                    Bandung, Jawa Barat 40163<br>
                    62 812-3980-9108<br>
                    26motorpremiumbandung@gmail.com<br>
                    premium.26motor.com
                </div>
            </div>
        </div>
        <div class="title-bar"><h1>ESTIMATION</h1></div>
        <div class="info-section">
            <div class="info-left">
                <div class="info-row"><span class="lbl">Customer ID</span><span class="col">:</span><span class="val">${data.customerId}</span></div>
                <div class="info-row"><span class="lbl">Estimation Date</span><span class="col">:</span><span class="val">${data.date}</span></div>
            </div>
            <div class="divv"></div>
            <div class="info-right">
                <div class="info-row"><span class="lbl">CUSTOMER NAME</span><span class="col">:</span><span class="val">${data.customerName}</span></div>
                <div class="info-row"><span class="lbl">Police Number</span><span class="col">:</span><span class="val">${data.plateNumber}</span></div>
                <div class="info-row"><span class="lbl">Vehicle Type</span><span class="col">:</span><span class="val">${data.vehicleType}</span></div>
                <div class="info-row"><span class="lbl">Vehicle Brand</span><span class="col">:</span><span class="val">${data.vehicleBrand}</span></div>
                <div class="info-row"><span class="lbl">VIN</span><span class="col">:</span><span class="val">${data.vin}</span></div>
                <div class="info-row"><span class="lbl">KM</span><span class="col">:</span><span class="val">${data.kmIn}</span></div>
            </div>
        </div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:40px;text-align:center;">NO</th>
                    <th>PRODUCT/SERVICE DESCRIPTION</th>
                    <th style="width:50px;text-align:center;">QTY</th>
                    <th style="width:60px;">UOM</th>
                    <th style="width:80px;text-align:right;">DISC</th>
                    <th style="width:110px;text-align:right;">PRICE</th>
                    <th style="width:110px;text-align:right;">AMOUNT</th>
                </tr>
            </thead>
            <tbody>${itemRows}</tbody>
        </table>
        <div class="summary-section">
            <div class="summary-left">
                <div style="font-style:italic;margin-bottom:10px;">Inwords : "${terbilang(data.total)} Rupiah"</div>
                <div style="color:#666;margin-bottom:4px;">Remark :</div>
                <div style="font-style:italic;">${data.remark}</div>
            </div>
            <div class="summary-right">
                <table class="sum-table">
                    <tr><td style="font-weight:bold;">Subtotal</td><td style="text-align:right;">${formatRp(data.subtotal)}</td></tr>
                    <tr><td style="font-weight:bold;">Discount</td><td style="text-align:right;">${discPct}%</td></tr>
                    <tr><td style="font-weight:bold;">Down Payment</td><td style="text-align:right;">${data.downPayment > 0 ? formatRp(data.downPayment) : ''}</td></tr>
                    <tr class="total-row"><td>TOTAL</td><td style="text-align:right;">${formatRp(data.total)}</td></tr>
                </table>
            </div>
        </div>
        <div class="footer"><p>"Committed to Quality, Dedicated to Trust."</p></div>
    </div>
</body>
</html>`;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(html);
    printWindow.document.close();
}
    </script>

@endsection