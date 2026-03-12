@extends('layouts.admin')

@section('title', 'Work Order - 26MP')

@section('content')

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Work Order</h1>
        <p class="text-sm text-gray-500 mt-1">Antrean Kendaraan Siap Diproses</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Card Tabel --}}
    <div class="bg-white rounded-xl border border-gray-200">

        {{-- Toolbar --}}
        <div class="px-6 py-4 flex items-center gap-3 border-b border-gray-100">
            <div class="relative flex-1 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" placeholder="Cari No Polisi atau Customer..."
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <input type="date" class="text-sm text-gray-500 focus:outline-none">
                <span class="text-gray-300">-</span>
                <input type="date" class="text-sm text-gray-500 focus:outline-none">
            </div>
        </div>

        {{-- Tabel --}}
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No Gate Pass</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No Polisi</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Nama Customer</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Vehicle Brand</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Vehicle Type</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Tanggal Masuk</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($records as $record)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="bg-blue-50 text-blue-600 text-xs font-semibold px-2.5 py-1 rounded-md">
                                {{ $record->gate_pass_no }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $record->vehicle->plate_number }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $record->customer->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $record->vehicle->brand ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $record->vehicle->type ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs">
                            {{ $record->gate_in_at->format('d M Y') }}<br>
                            {{ $record->gate_in_at->format('H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($record->status === 'Menunggu WO')
                                <span class="inline-flex items-center gap-1.5 bg-yellow-50 text-yellow-700 text-xs font-medium px-3 py-1.5 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                                    Menunggu WO
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-700 text-xs font-medium px-3 py-1.5 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span>
                                    Menunggu Estimasi
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($record->status === 'Menunggu WO')
                                <button
                                    data-id="{{ $record->id }}"
                                    data-gate-pass="{{ $record->gate_pass_no }}"
                                    data-plate="{{ $record->vehicle->plate_number }}"
                                    data-brand="{{ $record->vehicle->brand ?? '-' }}"
                                    data-type="{{ $record->vehicle->type ?? '-' }}"
                                    data-customer="{{ $record->customer->name }}"
                                    data-time="{{ $record->gate_in_at->format('d M Y, H:i') }}"
                                    onclick="openWOModal(this)"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition">
                                    Proses WO
                                </button>
                            @else
                                <div class="flex items-center gap-2">
                                    <button class="inline-flex items-center gap-1.5 border border-gray-200 text-gray-600 text-xs font-medium px-3 py-1.5 rounded-lg hover:bg-gray-50 transition">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                        </svg>
                                        Print
                                    </button>
                                    <button
                                        onclick="openDetailModal(
                                            '{{ $record->gate_pass_no }}',
                                            '{{ $record->vehicle->plate_number }}',
                                            '{{ $record->vehicle->brand ?? '-' }}',
                                            '{{ $record->vehicle->type ?? '-' }}',
                                            '{{ $record->customer->name }}',
                                            '{{ $record->gate_in_at->format('d M Y, H:i') }}',
                                            '{{ $record->wo_number ?? '-' }}',
                                            '{{ $record->mechanic ?? '-' }}',
                                            '{{ $record->km_in ?? '-' }}',
                                            '{{ $record->complaint ?? '-' }}',
                                            '{{ $record->status }}'
                                        )"
                                        class="inline-flex items-center justify-center w-7 h-7 border border-gray-200 text-gray-500 rounded-lg hover:bg-gray-50 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-sm">Belum ada kendaraan yang menunggu Work Order.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer Tabel --}}
        <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                <span class="inline-block w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                Showing <span class="font-semibold text-gray-700">{{ $records->count() }}</span> of <span class="font-semibold text-gray-700">{{ $records->count() }}</span> kendaraan
            </p>
            <div class="flex items-center gap-1">
                <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="w-7 h-7 flex items-center justify-center rounded border border-gray-200 text-gray-400 hover:bg-gray-50">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>

    </div>

    {{-- MODAL: Proses Work Order --}}
    <div id="modal-wo" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
                <h3 class="text-lg font-semibold text-gray-900">Proses Work Order</h3>
                <button onclick="document.getElementById('modal-wo').classList.add('hidden')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="px-6 py-5">

                {{-- Ringkasan Data Masuk --}}
                <div class="bg-blue-50 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Ringkasan Data Masuk</p>
                    </div>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-blue-400 text-xs">Gate Pass</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="wo-gate-pass"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">Tanggal Masuk</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="wo-time"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">Nama Customer</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="wo-customer"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">No Polisi</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="wo-plate"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">Vehicle Brand</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="wo-brand"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">Vehicle Type</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="wo-type"></p>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-blue-600 rounded-full"></div>
                    <p class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Detail Work Order</p>
                </div>

                <form id="form-wo" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">No. Work Order</label>
                            <input type="text" id="wo-number-display" disabled
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-400"
                                placeholder="WO/0302/001">
                            <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Dibuat otomatis oleh sistem
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal WO</label>
                            <input type="text" disabled
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 text-gray-500"
                                value="{{ now()->format('d/m/Y') }}">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                Mekanik <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="mechanic" required
                                class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                                placeholder="Nama mekanik">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">
                                KM Masuk <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="km_in" required
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 pr-12 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                                    placeholder="Contoh: 54.000">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium">KM</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Keluhan Pelanggan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="complaint" rows="3" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition"
                            placeholder="Tuliskan keluhan pelanggan secara detail..."></textarea>
                    </div>

                    {{-- Footer --}}
                    <div class="flex gap-3 pt-2">
                        <button type="button"
                            onclick="document.getElementById('modal-wo').classList.add('hidden')"
                            class="px-5 border border-gray-200 text-gray-600 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan & Proses
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- MODAL: Detail Work Order (View) --}}
    <div id="modal-wo-detail" class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">

            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl">
                <h3 class="text-lg font-semibold text-gray-900">Detail Work Order</h3>
                <div class="flex items-center gap-3">
                    <span id="detail-status-badge"></span>
                    <button onclick="document.getElementById('modal-wo-detail').classList.add('hidden')"
                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="px-6 py-5">

                {{-- Ringkasan --}}
                <div class="bg-blue-50 rounded-xl p-4 mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide">Ringkasan Data Masuk</p>
                    </div>
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-blue-400 text-xs">Gate Pass</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="detail-gate-pass"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">Tanggal Masuk</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="detail-time"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">Nama Customer</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="detail-customer"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">No Polisi</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="detail-plate"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">Vehicle Brand</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="detail-brand"></p>
                        </div>
                        <div>
                            <p class="text-blue-400 text-xs">Vehicle Type</p>
                            <p class="font-semibold text-blue-700 mt-0.5" id="detail-type"></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1 h-5 bg-blue-600 rounded-full"></div>
                    <p class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Detail Work Order</p>
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <p class="text-gray-500 text-xs mb-1">No. Work Order</p>
                        <div class="border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-700 font-medium" id="detail-wo-number"></div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Mekanik</p>
                        <div class="border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-700" id="detail-mechanic"></div>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">KM Masuk</p>
                        <div class="border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-700" id="detail-km"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-gray-500 text-xs mb-1">Keluhan Pelanggan</p>
                    <div class="border border-gray-200 rounded-lg px-4 py-2.5 bg-gray-50 text-gray-700 min-h-16" id="detail-complaint"></div>
                </div>

                <div class="flex justify-end pt-2">
                    <button onclick="document.getElementById('modal-wo-detail').classList.add('hidden')"
                        class="px-5 border border-gray-200 text-gray-600 text-sm font-medium py-2.5 rounded-lg hover:bg-gray-50 transition">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        function openWOModal(btn) {
            const id       = btn.dataset.id;
            const gatePass = btn.dataset.gatePass;
            const plate    = btn.dataset.plate;
            const brand    = btn.dataset.brand;
            const type     = btn.dataset.type;
            const customer = btn.dataset.customer;
            const time     = btn.dataset.time;

            document.getElementById('wo-gate-pass').textContent = '#' + gatePass;
            document.getElementById('wo-plate').textContent     = plate;
            document.getElementById('wo-brand').textContent     = brand;
            document.getElementById('wo-type').textContent      = type;
            document.getElementById('wo-customer').textContent  = customer;
            document.getElementById('wo-time').textContent      = time;
            document.getElementById('wo-number-display').value  = 'WO/' + new Date().toLocaleDateString('id-ID', {day:'2-digit', month:'2-digit'}).replace('/','') + '/' + String(id).padStart(3,'0');
            document.getElementById('form-wo').action           = window.location.origin + '/admin/work-order/' + id;

            document.getElementById('modal-wo').classList.remove('hidden');
        }

        function openDetailModal(gatePass, plate, brand, type, customer, time, woNumber, mechanic, km, complaint, status) {
            document.getElementById('detail-gate-pass').textContent = '#' + gatePass;
            document.getElementById('detail-plate').textContent = plate;
            document.getElementById('detail-brand').textContent = brand;
            document.getElementById('detail-type').textContent = type;
            document.getElementById('detail-customer').textContent = customer;
            document.getElementById('detail-time').textContent = time;
            document.getElementById('detail-wo-number').textContent = woNumber;
            document.getElementById('detail-mechanic').textContent = mechanic;
            document.getElementById('detail-km').textContent = km + ' KM';
            document.getElementById('detail-complaint').textContent = complaint;

            const badge = document.getElementById('detail-status-badge');
            badge.innerHTML = `<span class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-700 text-xs font-medium px-3 py-1.5 rounded-full"><span class="w-1.5 h-1.5 bg-orange-500 rounded-full"></span>${status}</span>`;

            document.getElementById('modal-wo-detail').classList.remove('hidden');
        }
    </script>

@endsection