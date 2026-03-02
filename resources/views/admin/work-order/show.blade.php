@extends('layouts.admin')

@section('title', 'Proses Work Order - 26MP')
@section('page-title', '📝 Proses Work Order')

@section('content')

    <div class="max-w-2xl">

        {{-- Info Kendaraan (read-only) --}}
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Info Kendaraan</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">No Gate Pass</p>
                    <p class="font-semibold mt-1">{{ $record->gate_pass_no }}</p>
                </div>
                <div>
                    <p class="text-gray-500">No Polisi</p>
                    <p class="font-semibold mt-1 text-blue-600">{{ $record->vehicle->plate_number }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Vehicle Brand</p>
                    <p class="font-semibold mt-1">{{ $record->vehicle->brand ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Vehicle Model</p>
                    <p class="font-semibold mt-1">{{ $record->vehicle->type ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Nama Customer</p>
                    <p class="font-semibold mt-1">{{ $record->customer->name }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Waktu Masuk</p>
                    <p class="font-semibold mt-1">{{ $record->gate_in_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        {{-- Form WO --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Detail Work Order</h3>

            <form action="{{ route('admin.work-order.update', $record->id) }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">KM Masuk</label>
                    <input type="number" name="km_in" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Contoh: 15000">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan Customer</label>
                    <textarea name="complaint" rows="4" required
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
                    <a href="{{ route('admin.work-order.index') }}"
                        class="flex-1 text-center border border-gray-300 text-gray-600 text-sm font-medium px-4 py-2.5 rounded-lg hover:bg-gray-50 transition">
                        ← Kembali
                    </a>
                    <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg transition">
                        💾 Simpan & Buat WO
                    </button>
                </div>

            </form>
        </div>

    </div>

@endsection