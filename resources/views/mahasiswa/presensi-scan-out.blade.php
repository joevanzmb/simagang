<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check-Out | SI-Magang</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(25px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseYellow {
      0%, 100% { box-shadow: 0 0 0 0 rgba(250,204,21,0.4); }
      50% { box-shadow: 0 0 0 20px rgba(250,204,21,0); }
    }
    @keyframes pulseGreen {
      0%, 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.4); }
      50% { box-shadow: 0 0 0 20px rgba(34,197,94,0); }
    }
    @keyframes glow {
      0% { text-shadow: 0 0 10px rgba(255,255,255,0.7); }
      100% { text-shadow: 0 0 0 rgba(255,255,255,0); }
    }
    body {
      font-family: 'Inter', sans-serif;
      min-height: 100vh;
      overflow-x: hidden;
    }
    .animate-fadeUp { animation: fadeUp 0.8s ease-out forwards; }
    .animate-pulseYellow { animation: pulseYellow 2s infinite; }
    .animate-pulseGreen { animation: pulseGreen 2s infinite; }
    .animate-glow { animation: glow 2s ease-in-out infinite alternate; }
  </style>
</head>

@php
  $status = request()->query('status');
@endphp

<body class="flex flex-col min-h-screen items-center justify-start px-5 py-6 space-y-4 pb-10 
{{ $status === 'success' ? 'bg-[#22C55E] text-green-900' : 'bg-[#FACC15] text-yellow-900' }}">

@if ($status === 'success')
  <!-- ✅ CHECK-OUT BERHASIL -->
  <div class="bg-white rounded-3xl shadow-xl py-12 px-6 w-full max-w-lg text-center animate-fadeUp border border-green-300">
    <div class="flex flex-col items-center gap-4">
      <div class="w-32 h-32 rounded-full bg-green-500 flex items-center justify-center animate-pulseGreen shadow-lg">
        <i class="fas fa-door-closed text-white text-6xl"></i>
      </div>

      <h2 class="text-green-700 font-extrabold leading-[1.1]">
        <span class="block text-4xl sm:text-5xl">Check-Out</span>
        <span class="block text-4xl sm:text-5xl mt-1 animate-glow">Berhasil!</span>
      </h2>

      <p class="text-green-700/90 text-base sm:text-lg max-w-md leading-relaxed mt-2">
        Presensi Anda telah diselesaikan hari ini 🎉  
        Terima kasih atas dedikasinya!
      </p>
    </div>
  </div>

  <!-- Detail Presensi -->
  <div class="bg-white rounded-3xl shadow-xl p-5 w-full max-w-lg text-sm text-green-900 animate-fadeUp border border-green-200">
    <div class="space-y-3">
      <div class="flex justify-between border-b border-green-100 pb-1">
        <span class="font-medium">Nama</span>
        <span>Joevanz Mikail</span>
      </div>
      <div class="flex justify-between border-b border-green-100 pb-1">
        <span class="font-medium">Tanggal</span>
        <span>{{ now()->format('d M Y') }}</span>
      </div>
      <div class="flex justify-between border-b border-green-100 pb-1">
        <span class="font-medium">Check-In</span>
        <span>08:05 WIB</span>
      </div>
      <div class="flex justify-between border-b border-green-100 pb-1">
        <span class="font-medium">Check-Out</span>
        <span>{{ now()->format('H:i') }} WIB</span>
      </div>
      <div class="flex justify-between items-center pb-1">
        <span class="font-medium">Status Kehadiran</span>
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-200 text-green-800">
          Hadir
        </span>
      </div>
    </div>
  </div>

@else
  <!-- 🚪 KONFIRMASI CHECK-OUT -->
  <div class="bg-white rounded-3xl py-10 px-6 w-full max-w-lg text-center animate-fadeUp border border-yellow-300">
    <div class="flex flex-col items-center gap-3">
      <div class="w-32 h-32 rounded-full bg-yellow-400 flex items-center justify-center animate-pulseYellow shadow-lg">
        <i class="fas fa-door-open text-white text-6xl"></i>
      </div>

      <h2 class="text-yellow-700 font-extrabold leading-[1.1]">
        <span class="block text-4xl sm:text-5xl">Konfirmasi</span>
        <span class="block text-4xl sm:text-5xl mt-2">Check-Out</span>
      </h2>

      <p class="text-yellow-700/90 text-[13px] max-w-md leading-relaxed mt-3">
        Apakah Anda yakin ingin melakukan <span class="font-semibold">Check-Out</span>?
      </p>
    </div>
    
    <div class="flex w-full max-w-lg justify-between gap-3 mt-6 animate-fadeUp">
      <a href="/mahasiswa/presensi-scan"
         class="flex-1 py-3 rounded-xl bg-red-400 text-white font-semibold hover:bg-red-500 transition-all duration-300 hover:scale-[1.03] active:scale-95 text-center">
        <i class="fas fa-times mr-1"></i> Batal
      </a>
      <a href="/mahasiswa/presensi-scan-out?status=success"
         class="flex-1 py-3 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600 transition-all duration-300 hover:scale-[1.03] active:scale-95 text-center">
        <i class="fas fa-check mr-1"></i> Check-Out
      </a>
    </div>

    <p class="text-yellow-700/80 text-[13px] leading-relaxed mt-5 italic">
      Setelah konfirmasi, presensi hari ini akan ditandai sebagai <span class="font-semibold text-green-600">Hadir</span>.
    </p>
  </div>

  <!-- Detail Presensi -->
  <div class="bg-white rounded-3xl p-5 w-full max-w-lg text-sm text-yellow-900 animate-fadeUp border border-yellow-200">
    <div class="space-y-3">
      <div class="flex justify-between border-b border-yellow-100 pb-1">
        <span class="font-medium">Nama</span>
        <span>Joevanz Mikail</span>
      </div>
      <div class="flex justify-between border-b border-yellow-100 pb-1">
        <span class="font-medium">Tanggal</span>
        <span>{{ now()->format('d M Y') }}</span>
      </div>
      <div class="flex justify-between border-b border-yellow-100 pb-1">
        <span class="font-medium">Check-In</span>
        <span>08:05 WIB</span>
      </div>
      <div class="flex justify-between border-b border-yellow-100 pb-1">
        <span class="font-medium">Lokasi</span>
        <span>Surabaya</span>
      </div>
      <div class="flex justify-between items-center pb-1">
        <span class="font-medium">Status Kehadiran</span>
        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-200 text-yellow-800">
          Belum Check-Out
        </span>
      </div>
    </div>
  </div>
@endif

  <!-- Footer -->
  <div class="flex-grow"></div>
  <p class="text-xs {{ $status === 'success' ? 'text-green-50/90' : 'text-yellow-900/70' }} tracking-wide mb-1">
    © 2025 SI-Magang — <span class="font-semibold">Websiterz.id</span>. All rights reserved.
  </p>

</body>
</html>
