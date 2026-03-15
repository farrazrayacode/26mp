@extends('layouts.admin')

@section('title', 'Estimasi Biaya - 26MP')

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Estimasi Biaya</h1>
        <p class="text-sm text-gray-500 mt-1">Antrean Kendaraan Menunggu Estimasi</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

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
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No WO</th>
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
                        <td class="px-6 py-4 text-gray-600 font-medium">{{ $record->wo_number ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 bg-purple-50 text-purple-700 text-xs font-medium px-3 py-1.5 rounded-full">
                                <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.estimasi.show', $record->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition">
                                Buat Estimasi
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm">Belum ada kendaraan yang menunggu estimasi.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-3 border-t border-gray-100">
            <p class="text-xs text-gray-500">
                <span class="inline-block w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                Showing <span class="font-semibold text-gray-700">{{ $records->count() }}</span> kendaraan
            </p>
        </div>

    </div>

@endsection