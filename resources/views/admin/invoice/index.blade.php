@extends('layouts.admin')

@section('title', 'Invoice - 26MP')

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Invoice & Pembayaran</h1>
        <p class="text-sm text-gray-500 mt-1">Kendaraan Selesai Servis — Menunggu Pembayaran</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl border border-gray-200">

        <table class="w-full text-sm text-left">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No Invoice</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No Polisi</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Nama Customer</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Vehicle</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No WO</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Total</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($records as $record)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <span class="bg-blue-50 text-blue-600 text-xs font-semibold px-2.5 py-1 rounded-md">
                                {{ $record->invoice->invoice_no ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $record->vehicle->plate_number }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $record->customer->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $record->vehicle->brand ?? '-' }} {{ $record->vehicle->type ?? '' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $record->wo_number ?? '-' }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-700">
                            Rp {{ number_format($record->invoice->total ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 text-xs font-medium px-3 py-1.5 rounded-full">
                                <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                {{ $record->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.invoice.show', $record->id) }}"
                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition">
                                Terbitkan Invoice
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-sm">Belum ada kendaraan yang siap ditagih.</p>
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