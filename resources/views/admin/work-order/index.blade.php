@extends('layouts.admin')

@section('title', 'Work Order - 26MP')
@section('page-title', '📝 Work Order')

@section('content')

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">No Gate Pass</th>
                    <th class="px-6 py-4">No Polisi</th>
                    <th class="px-6 py-4">Vehicle Brand</th>
                    <th class="px-6 py-4">Vehicle Model</th>
                    <th class="px-6 py-4">Nama Customer</th>
                    <th class="px-6 py-4">Waktu Masuk</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($records as $record)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium">{{ $record->gate_pass_no }}</td>
                        <td class="px-6 py-4 font-bold text-blue-600">{{ $record->vehicle->plate_number }}</td>
                        <td class="px-6 py-4">{{ $record->vehicle->brand ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $record->vehicle->type ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $record->customer->name }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $record->gate_in_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <button
                                onclick="openWOModal(
                                    '{{ $record->id }}',
                                    '{{ $record->gate_pass_no }}',
                                    '{{ $record->vehicle->plate_number }}',
                                    '{{ $record->vehicle->brand ?? '-' }}',
                                    '{{ $record->vehicle->type ?? '-' }}',
                                    '{{ $record->customer->name }}',
                                    '{{ $record->gate_in_at->format('d/m/Y H:i') }}'
                                )"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded-lg transition">
                                📝 Proses WO
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                            <p class="text-3xl mb-2">📋</p>
                            <p>Belum ada kendaraan yang menunggu Work Order.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL: Form Proses WO --}}
    <div id="modal-wo" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg p-6">

            <h3 class="text-lg font-semibold text-gray-800 mb-5">📝 Proses Work Order</h3>

            {{-- Info Kendaraan (read-only) --}}
            <div class="grid grid-cols-2 gap-3 text-sm mb-5 bg-gray-50 rounded-lg p-4">
                <div>
                    <p class="text-gray-500 text-xs">No Gate Pass</p>
                    <p class="font-semibold mt-0.5" id="wo-gate-pass"></p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">No Polisi</p>
                    <p class="font-semibold mt-0.5 text-blue-600" id="wo-plate"></p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Vehicle Brand</p>
                    <p class="font-semibold mt-0.5" id="wo-brand"></p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Vehicle Model</p>
                    <p class="font-semibold mt-0.5" id="wo-type"></p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Nama Customer</p>
                    <p class="font-semibold mt-0.5" id="wo-customer"></p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs">Waktu Masuk</p>
                    <p class="font-semibold mt-0.5" id="wo-time"></p>
                </div>
            </div>

            {{-- Form --}}
            <form id="form-wo" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">KM Masuk</label>
                    <input type="number" name="km_in" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: 15000">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan Customer</label>
                    <textarea name="complaint" rows="3" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Deskripsikan keluhan customer..."></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mekanik</label>
                    <input type="text" name="mechanic" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Nama mekanik yang bertanggung jawab">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="button"
                        onclick="document.getElementById('modal-wo').classList.add('hidden')"
                        class="flex-1 border border-gray-300 text-gray-600 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-gray-50 transition">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                        💾 Simpan & Buat WO
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- Script Modal --}}
    <script>
        function openWOModal(id, gatePass, plate, brand, type, customer, time) {
            // Isi info kendaraan
            document.getElementById('wo-gate-pass').textContent = gatePass;
            document.getElementById('wo-plate').textContent = plate;
            document.getElementById('wo-brand').textContent = brand;
            document.getElementById('wo-type').textContent = type;
            document.getElementById('wo-customer').textContent = customer;
            document.getElementById('wo-time').textContent = time;

            // Set action form sesuai id record
            document.getElementById('form-wo').action = '/admin/work-order/' + id;

            // Tampilkan modal
            document.getElementById('modal-wo').classList.remove('hidden');
        }
    </script>

@endsection