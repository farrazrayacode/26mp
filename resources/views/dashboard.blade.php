{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.admin')

@section('title', 'Dashboard - 26MP')
@section('page-title', 'Dashboard')

@section('content')

    {{-- Cards Ringkasan --}}
    <div class="grid grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <p class="text-sm text-gray-500">Pengecekan Awal</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500">Proses Servis</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Lunas / Siap Keluar</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">0</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Batal Servis</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">0</p>
        </div>

    </div>

    {{-- Placeholder --}}
    <div class="bg-white rounded-xl shadow-sm p-8 text-center text-gray-400">
        <p class="text-4xl mb-3">🔧</p>
        <p class="text-lg font-medium">Sistem siap digunakan</p>
        <p class="text-sm mt-1">Mulai dari Gate In untuk mencatat kendaraan masuk</p>
    </div>

@endsection

