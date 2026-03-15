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
                        <button type="submit" name="action" value="approve"
                            class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Customer ACC
                        </button>

                        <button type="submit" name="action" value="reject"
                            onclick="return confirm('Yakin customer menolak estimasi ini?')"
                            class="w-full flex items-center justify-center gap-2 border border-red-200 text-red-600 hover:bg-red-50 text-sm font-medium px-4 py-2.5 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Customer Tolak
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </form>

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
    </script>

@endsection