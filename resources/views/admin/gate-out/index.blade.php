@extends('layouts.admin')

@section('title', 'Gate Out - 26MP')

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gate Out</h1>
        <p class="text-sm text-gray-500 mt-1">Kendaraan Siap Meninggalkan Bengkel</p>
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
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No Gate Pass</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">No Polisi</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Nama Customer</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Vehicle</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wide">Waktu Masuk</th>
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
                                {{ $record->gate_pass_no }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $record->vehicle->plate_number }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $record->customer->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $record->vehicle->brand ?? '-' }} {{ $record->vehicle->type ?? '' }}</td>
                        <td class="px-6 py-4 text-gray-400 text-xs">
                            {{ $record->gate_in_at->format('d M Y') }}<br>
                            {{ $record->gate_in_at->format('H:i') }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-700">
                            @if($record->status === 'Lunas')
                                Rp {{ number_format($record->invoice->total ?? 0, 0, ',', '.') }}
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($record->status === 'Lunas')
                                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 text-xs font-medium px-3 py-1.5 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Lunas
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 text-xs font-medium px-3 py-1.5 rounded-full">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                    Batal Servis
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('admin.gate-out.process', $record->id) }}" method="POST"
                                onsubmit="return confirm('Konfirmasi Gate Out untuk {{ $record->vehicle->plate_number }}?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="flex items-center gap-1.5 bg-gray-900 hover:bg-gray-700 text-white text-xs font-medium px-4 py-1.5 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    🏁 Gate Out
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <p class="text-sm">Belum ada kendaraan yang siap Gate Out.</p>
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