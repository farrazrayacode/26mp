@extends('layouts.admin')

@section('title', 'Riwayat Transaksi - 26MP')

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Riwayat Transaksi</h1>
        <p class="text-sm text-gray-500 mt-1">Semua transaksi yang telah selesai</p>
    </div>

    {{-- Filter --}}
    <form method="GET" action="{{ route('admin.riwayat.index') }}" class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
        <div class="flex items-center gap-3">

            <div class="relative flex-1 max-w-xs">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari No Polisi atau Customer..."
                    class="w-full pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-center gap-2 border border-gray-200 rounded-lg px-3 py-2">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                    class="text-sm text-gray-500 focus:outline-none">
                <span class="text-gray-300">-</span>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                    class="text-sm text-gray-500 focus:outline-none">
            </div>

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Filter
            </button>

            @if(request('search') || request('date_from') || request('date_to'))
                <a href="{{ route('admin.riwayat.index') }}"
                    class="border border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-50 transition">
                    Reset
                </a>
            @endif

        </div>
    </form>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <table class="w-full text-sm text-left">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No Gate Pass</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No Polisi</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Customer</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Vehicle</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No WO</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Jam Masuk</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Jam Keluar</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Total</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No Invoice</th>
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
                        <td class="px-6 py-4 text-gray-600">{{ $record->vehicle->brand ?? '-' }} {{ $record->vehicle->type ?? '' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $record->wo_number ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs">
                            {{ $record->gate_in_at->format('d M Y') }}<br>
                            {{ $record->gate_in_at->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 text-gray-400 text-xs">
                            @if($record->gate_out_at)
                                {{ $record->gate_out_at->format('d M Y') }}<br>
                                {{ $record->gate_out_at->format('H:i') }}
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-700">
                            @if($record->invoice)
                                Rp {{ number_format($record->invoice->total, 0, ',', '.') }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($record->invoice)
                                <span class="bg-green-50 text-green-600 text-xs font-semibold px-2.5 py-1 rounded-md">
                                    {{ $record->invoice->invoice_no }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-6 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-sm">Belum ada riwayat transaksi.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="px-6 py-3 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500">
                <span class="inline-block w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5"></span>
                Showing <span class="font-semibold text-gray-700">{{ $records->firstItem() ?? 0 }}</span>
                - <span class="font-semibold text-gray-700">{{ $records->lastItem() ?? 0 }}</span>
                of <span class="font-semibold text-gray-700">{{ $records->total() }}</span> transaksi
            </p>
            <div>
                {{ $records->links() }}
            </div>
        </div>

    </div>

@endsection