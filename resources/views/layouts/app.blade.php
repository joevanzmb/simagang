<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SI-Magang — Admin')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    * { font-family: 'Inter', sans-serif; }

    /* === Animasi masuk sidebar === */
    @keyframes fadeSlide {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }
    .animate-fadeSlide { animation: fadeSlide 0.5s ease forwards; }

    /* === Sidebar link === */
    .sidebar-link {
      display: flex; align-items: center; gap: .75rem;
      padding: .8rem 1rem; color: #374151;
      font-weight: 400; border-radius: .6rem;
      transition: all .25s ease; position: relative;
    }

    /* Hover efek non-aktif */
    .sidebar-link:not(.sidebar-active):hover {
      background: linear-gradient(90deg, rgba(99,102,241,0.08), rgba(118,75,162,0.10));
      color: #4F46E5; transform: translateX(5px);
      font-weight: 600;
    }
    .sidebar-link:not(.sidebar-active):hover::before {
      content: ""; position: absolute; left: 0; top: 0;
      height: 100%; width: 5px; border-radius: 0 4px 4px 0;
      background: linear-gradient(180deg, #818cf8, #7c3aed);
    }

    .sidebar-active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff !important; font-weight: 700;
      box-shadow: 0 6px 15px rgba(91,72,255,0.25);
    }
    .sidebar-active i { color: #fff !important; }

    .sidebar-active:hover {
      transform: scale(1.05); filter: brightness(1.08);
      transition: transform .25s ease, filter .25s ease;
    }

    @keyframes pulseGlow {
      0%, 100% {
        box-shadow: 0 0 20px rgba(102,126,234,0.25),
                    0 0 40px rgba(118,75,162,0.25);
      }
      50% {
        box-shadow: 0 0 35px rgba(102,126,234,0.4),
                    0 0 55px rgba(118,75,162,0.4);
      }
    }
    .logo-animate { animation: pulseGlow 3s ease-in-out infinite; }

    .gradient-text {
      background: linear-gradient(135deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    #toggleIcon {
      transition: transform .25s ease, opacity .25s ease, color .25s ease;
    }
    #toggleIcon.fa-chevron-left {
      transform: translateX(-2px);
    }
    @supports(padding: env(safe-area-inset-bottom)) {
      #sidebar {
        padding-bottom: calc(env(safe-area-inset-bottom) + 70px);
      }
    }
    /* Tampilkan scrollbar jelas pada mobile */
    #sidebar nav {
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #c4c7f5 #eef0ff;
    }
    
    /* Styling scrollbar Chrome/Edge/Safari */
    #sidebar nav::-webkit-scrollbar {
      width: 6px;
    }
    #sidebar nav::-webkit-scrollbar-track {
      background: #eef0ff;
      border-radius: 5px;
    }
    #sidebar nav::-webkit-scrollbar-thumb {
      background: #c4c7f5;
      border-radius: 5px;
    }
    #sidebar nav::-webkit-scrollbar-thumb:hover {
      background: #a4a8f0;
    }

  </style>

</head>

<body class="bg-gray-50">
  <div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside id="sidebar"
      class="w-64 bg-white/90 backdrop-blur-xl border-r border-gray-200 fixed h-screen
             rounded-r-3xl z-30 shadow-[4px_4px_25px_rgba(0,0,0,0.08)]
             transition-transform duration-300
             lg:translate-x-0 -translate-x-full
             flex flex-col overflow-y-auto">


      <!-- 🔰 Header Logo -->
      <div class="p-6 border-b border-gray-200/70 flex items-center gap-3 justify-center">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center logo-animate
                    bg-gradient-to-br from-[#667eea] to-[#764ba2] shadow-[0_4px_15px_rgba(102,126,234,0.3)]">
          <i class="fas fa-graduation-cap text-white text-2xl"></i>
        </div>
        <h1 class="text-xl font-extrabold gradient-text leading-tight">SI-Magang</h1>
      </div>

      <!-- 🧭 Navigation -->
      <nav class="flex-1 px-4 py-5 pb-32 overflow-y-auto">
        @php
          $menu = [
            ['route'=>'admin.dashboard','icon'=>'fa-home','label'=>'Dashboard'],
            ['route'=>'admin.mahasiswa.*','icon'=>'fa-users','label'=>'Mahasiswa'],
            ['route'=>'admin.mentor.*','icon'=>'fa-user-tie','label'=>'Mentor'],
            ['route'=>'admin.presensi.*','icon'=>'fa-clipboard-check','label'=>'Presensi'],
            ['route'=>'admin.penilaian.*','icon'=>'fa-star','label'=>'Penilaian'],
            ['route'=>'admin.laporan.*','icon'=>'fa-file-alt','label'=>'Laporan'],
            ['route'=>'admin.feedback.*','icon'=>'fa-comments','label'=>'Feedback'],
            ['route'=>'admin.reminder.*','icon'=>'fa-bell','label'=>'Reminder'],
            ['route'=>'admin.user.*','icon'=>'fa-user-cog','label'=>'User Management'],
            ['route'=>'admin.vp.*','icon'=>'fa-certificate','label'=>'Approval Sertifikat'],
          ];
        @endphp

        @foreach ($menu as $item)
          @php $routeName = str_replace('.*', '.index', $item['route']); @endphp
          @if (Route::has($routeName))
            <a href="{{ route($routeName) }}"
              class="sidebar-link {{ request()->routeIs($item['route']) ? 'sidebar-active' : 'text-gray-700 hover:text-indigo-600' }}">
              <i class="fas {{ $item['icon'] }} w-6"></i>
              <span>{{ $item['label'] }}</span>
            </a>
          @endif
        @endforeach
      </nav>

      <!-- 👤 Profile -->
      <div class="mt-auto px-5 pb-6">
        <a href="{{ route('admin.user.index') }}" class="block group">
          <div class="group flex flex-col items-center text-center gap-2 p-4 rounded-2xl 
                      bg-gradient-to-br from-white via-indigo-50/40 to-white border border-gray-200 
                      shadow-[0_10px_25px_rgba(102,126,234,0.08)]
                      hover:shadow-[0_15px_35px_rgba(102,126,234,0.25)]
                      transition-all duration-500 ease-out cursor-pointer">

            <div class="relative">
              <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=667eea&color=ffffff"
                   alt="Profile"
                   class="w-12 h-12 rounded-full ring-2 ring-indigo-300 shadow-sm 
                          transition-all duration-300 group-hover:ring-indigo-400 group-hover:scale-105">
              <span class="absolute bottom-1 right-1 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
            </div>

            <div>
              <h4 class="text-sm font-semibold text-gray-800 group-hover:text-indigo-600 leading-tight">
                {{ Auth::user()->name ?? 'Administrator' }}
              </h4>
              <p class="text-xs text-gray-500 tracking-wide">{{ Auth::user()->email ?? 'admin@simagang.id' }}</p>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="w-full mt-1">
              @csrf
              <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-3 py-2
                      bg-gradient-to-r from-rose-500 to-red-500 hover:brightness-105
                      text-white rounded-xl shadow-md hover:shadow-lg
                      active:scale-[0.97] active:shadow-inner
                      transition-all duration-300 hover:scale-[1.03]">
                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
              </button>
            </form>
          </div>
        </a>
      </div>
    </aside>

    <!-- 🌈 Main Content -->
    <!-- Sidebar Toggle Button (Mobile) -->
    <button id="sidebarToggle"
      class="fixed top-4 z-50 p-2 bg-white shadow-md rounded-lg text-gray-700 
             hover:bg-gray-100 transition-transform duration-300 lg:hidden">
      <i id="toggleIcon" class="fas fa-bars text-xl"></i>
    </button>

    <div class="flex-1 flex flex-col lg:ml-64">
      @if (!isset($noHeader) || $noHeader === false)
      <header class="bg-white/80 backdrop-blur-md border-b border-gray-200/70 shadow-sm z-20">
        <div class="px-6 py-4 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('pageTitle', 'Dashboard')</h1>
            <p class="text-gray-500 text-sm">@yield('pageSubtitle', '')</p>
          </div>
          <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-all">
            <i class="fas fa-bell text-xl"></i>
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
          </button>
        </div>
      </header>
      @endif

      <main class="flex-1 overflow-y-auto p-6 max-h-screen bg-gray-50">
        @yield('content')
      </main>
    </div>
  </div>
<script>
const sidebar = document.getElementById("sidebar");
const toggle = document.getElementById("sidebarToggle");
const toggleIcon = toggle.querySelector("i");

function updateToggleState() {
  const width = 256;
  const isClosed = sidebar.classList.contains("-translate-x-full");

  toggle.style.left = isClosed ? "1rem" : `${width + 16}px`;

  toggleIcon.classList.toggle("fa-bars", isClosed);
  toggleIcon.classList.toggle("fa-chevron-left", !isClosed);
  toggleIcon.classList.toggle("text-indigo-600", !isClosed);
}

toggle.addEventListener("click", () => {
  sidebar.classList.toggle("-translate-x-full");
  updateToggleState();
});

// Desktop toggle (if added later)
const desktopToggle = document.getElementById("sidebarToggleDesktop");
if (desktopToggle) {
  desktopToggle.addEventListener("click", () => {
    sidebar.classList.toggle("-translate-x-full");
    updateToggleState();
  });
}

// Set initial state
updateToggleState();
</script>


</body>
</html>
