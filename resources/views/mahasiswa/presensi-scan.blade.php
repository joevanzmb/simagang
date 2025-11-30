<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check-In Berhasil | SI-Magang</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulse {
      0%, 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.4); }
      50% { box-shadow: 0 0 0 20px rgba(34,197,94,0); }
    }
    @keyframes glow {
      0% { text-shadow: 0 0 10px rgba(255,255,255,0.7); }
      100% { text-shadow: 0 0 0 rgba(255,255,255,0); }
    }
    body {
      background: #22C55E;
      font-family: 'Inter', sans-serif;
      color: #064e3b;
      min-height: 100vh;
      overflow-x: hidden;
    }
    .animate-fadeUp { animation: fadeUp 0.8s ease-out forwards; }
    .animate-pulseGlow { animation: pulse 2s infinite; }
    .animate-glow { animation: glow 2s ease-in-out infinite alternate; }
  </style>
</head>

<body class="flex flex-col min-h-screen items-center justify-start px-5 py-3 space-y-4 pb-10">

  <!-- CARD 1: Check-In Berhasil -->
    <div class="bg-white rounded-3xl shadow-xl py-12 px-6 w-full max-w-lg text-center animate-fadeUp backdrop-blur-sm border border-green-300">
      <div class="flex flex-col items-center gap-4">
        <!-- Ikon -->
        <div class="w-32 h-32 rounded-full bg-green-500 flex items-center justify-center animate-pulseGlow shadow-lg">
          <i class="fas fa-check text-white text-7xl"></i>
        </div>
    
        <!-- Judul dua baris -->
        <h2 class="text-green-700 font-extrabold leading-[1.1]">
          <span class="block text-4xl sm:text-5xl">Check-In</span>
          <span class="block text-4xl sm:text-5xl mt-1 animate-glow">Berhasil!</span>
        </h2>
    
        <!-- Deskripsi -->
        <p class="text-green-700/90 text-base sm:text-lg max-w-md leading-relaxed mt-2">
          Presensi Anda telah tercatat sistem.  
        </p>
      </div>
    </div>


  <!-- CARD 2: Detail Presensi -->
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
        <span>{{ now()->format('H:i') }} WIB</span>
      </div>
      <div class="flex justify-between pb-1">
        <span class="font-medium">Lokasi</span>
        <span>GPS: Surabaya</span>
      </div>
    </div>
  </div>


    <a href="/mahasiswa/presensi-scan-out"
       class="block w-full max-w-lg py-3 bg-amber-400 hover:bg-amber-500 text-white font-semibold rounded-xl shadow-lg transition-all duration-300 hover:scale-[1.03] active:scale-95 text-center">
      <i class="fas fa-door-open mr-2"></i> Lanjut ke Check-Out
    </a>




  <!-- Footer -->
  <div class="flex-grow"></div>
  <p class="text-xs text-green-50/90 tracking-wide mb-1">
    © 2025 SI-Magang — <span class="font-semibold">Websiterz.id</span>. All rights reserved.
  </p>

</body>
</html>
