@extends('layouts.app')

@section('pageTitle', 'Presensi Mahasiswa')
@section('pageSubtitle', 'Scan QR Code untuk melakukan check-in')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Scan QR Code</h2>

    <div class="flex justify-center mb-4">
        {!! $qrCode !!}
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-100 text-green-700 rounded mb-3">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="p-3 bg-red-100 text-red-700 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    <p class="text-sm text-gray-600 text-center">Silakan scan QR Code di atas menggunakan aplikasi presensi mahasiswa.</p>
</div>
@endsection
