<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SI-Magang Mentor')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    * { font-family: 'Inter', sans-serif; }

    /* Fade animation */
    @keyframes fadeSlide {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }
    .animate-fadeSlide { animation: fadeSlide 0.5s ease forwards; }

    /* Sidebar link */
    .sidebar-link {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 0.8rem 1rem;
      color: #374151;
      font-weight: 400;
      border-radius: 0.6rem;
      transition: all 0.25s ease;
      position: relative;
    }

    /* Hover (non-active) */
    .sidebar-link:not(.sidebar-active):hover {
      background: linear-gradient(90deg, rgba(99,102,241,0.08), rgba(118,75,162,0.10));
      color: #4F46E5;
      transform: translateX(5px);
      font-weight: 600;
    }

    .sidebar-link:not(.sidebar-active):hover::before {
      content: "";
      position: absolute;
      left: 0; top: 0; height: 100%; width: 5px;
      border-radius: 0 4px 4px 0;
      background: linear-gradient(180deg, #818cf8, #7c3aed);
    }

    .sidebar-link:not(.sidebar-active):hover i {
      color: #4F46E5;
    }

    /* Active Gradient */
    .sidebar-active {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff !important;
      font-weight: 700;
      box-shadow: 0 6px 15px rgba(91, 72, 255, 0.25);
    }

    .sidebar-active i { color: #fff !important; }

    /* Hover efek aktif */
    .sidebar-active:hover {
      transform: scale(1.05);
      transition: transform 0.25s ease, filter 0.25s ease;
      filter: brightness(1.08);
    }

    .sidebar-active::before { content: none !important; }

    /* Logo Glow */
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

    /* Gradient Text */
    .gradient-text {
      background: linear-gradient(135deg, #667eea, #764ba2);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    @supports(padding: env(safe-area-inset-bottom)) {
      #sidebar {
        padding-bottom: calc(env(safe-area-inset-bottom) + 70px);
      }
    }

  </style>
</head>

<body class="bg-gray-50">
  <div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside id="sidebar"
      class="w-64 bg-white/90 backdrop-blur-xl border-r border-gray-200 fixed h-screen ml-0
            rounded-r-3xl z-50 shadow-[4px_4px_25px_rgba(0,0,0,0.08)]
            transform -translate-x-full lg:translate-x-0 transition-transform duration-300
            flex flex-col overflow-y-auto">


      <!-- Header Logo -->
      <div class="p-6 border-b border-gray-200/70 flex items-center gap-3 justify-center">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center logo-animate
                    bg-gradient-to-br from-[#667eea] to-[#764ba2] shadow-[0_4px_15px_rgba(102,126,234,0.3)]">
          <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
        </div>
        <h1 class="text-xl font-extrabold gradient-text leading-tight">SI-Magang</h1>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-5 pb-20">
        <a href="{{ route('mentor.dashboard') }}"
          class="sidebar-link {{ request()->routeIs('mentor.dashboard') ? 'sidebar-active' : 'text-gray-700 hover:text-indigo-600' }}">
          <i class="fas fa-home w-6"></i><span>Dashboard</span>
        </a>

        <a href="{{ route('mentor.profil') }}"
          class="sidebar-link {{ request()->routeIs('mentor.profil') ? 'sidebar-active' : 'text-gray-700 hover:text-indigo-600' }}">
          <i class="fas fa-user w-6"></i><span>Profil</span>
        </a>

        <a href="{{ route('mentor.mahasiswa') }}"
          class="sidebar-link {{ request()->routeIs('mentor.mahasiswa') ? 'sidebar-active' : 'text-gray-700 hover:text-indigo-600' }}">
          <i class="fas fa-users w-6"></i><span>Data Bimbingan</span>
        </a>

        <a href="{{ route('mentor.presensi') }}"
          class="sidebar-link {{ request()->routeIs('mentor.presensi') ? 'sidebar-active' : 'text-gray-700 hover:text-indigo-600' }}">
          <i class="fas fa-clipboard-check w-6"></i><span>Presensi</span>
        </a>

        <a href="{{ route('mentor.penilaian') }}"
          class="sidebar-link {{ request()->routeIs('mentor.penilaian') ? 'sidebar-active' : 'text-gray-700 hover:text-indigo-600' }}">
          <i class="fas fa-star w-6"></i><span>Penilaian</span>
        </a>

        <a href="{{ route('mentor.laporan') }}"
          class="sidebar-link {{ request()->routeIs('mentor.laporan') ? 'sidebar-active' : 'text-gray-700 hover:text-indigo-600' }}">
          <i class="fas fa-file-alt w-6"></i><span>Laporan</span>
        </a>
      </nav>

      <!-- User Information + Logout -->
      <div class="mt-auto px-5 pb-6">
        <a href="{{ route('mentor.profil') }}"
          class="flex flex-col items-center gap-2 p-4 rounded-2xl 
                 bg-gradient-to-br from-white via-indigo-50/40 to-white border border-gray-200 
                 shadow-[0_10px_25px_rgba(102,126,234,0.08)]
                 transition-all duration-500 ease-out cursor-pointer hover:brightness-95">


          <img src="https://ui-avatars.com/api/?name=Mentor&background=667eea&color=ffffff"
              class="w-12 h-12 rounded-full ring-2 ring-indigo-300">

          <h4 class="text-sm font-semibold text-gray-800 leading-tight">Mentor</h4>
          <p class="text-xs text-gray-500 tracking-wide">mentor@simagang.id</p>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="w-full mt-3">
          @csrf
          <button type="submit"
            class="w-full flex items-center justify-center gap-2 px-3 py-2
                  bg-gradient-to-r from-rose-500 to-red-500 hover:brightness-105
                  text-white rounded-xl shadow-md transition-all">
            <i class="fas fa-sign-out-alt"></i><span>Logout</span>
          </button>
        </form>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col lg:ml-64">

      <!-- Sidebar Toggle Button (Mobile) -->
      <!-- Sidebar Toggle Button -->
      <button id="sidebarToggle"
        class="fixed top-4 z-50 p-2 bg-white shadow-md rounded-lg text-gray-700 
               hover:bg-gray-100 transition-transform duration-300 lg:hidden">
        <i id="toggleIcon" class="fas fa-bars text-xl transition-all duration-300"></i>
      </button>


      @if (!isset($noHeader) || $noHeader === false)
      <header class="bg-white/80 backdrop-blur-md border-b border-gray-200/70 shadow-sm z-20">
        <div class="px-6 py-4 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-800">@yield('pageTitle', 'Dashboard')</h1>
            <p class="text-gray-500 text-sm">@yield('pageSubtitle', '')</p>
          </div>

          <!-- Toggle on Desktop -->
          <button id="sidebarToggleDesktop"
            class="hidden lg:flex p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
            <i class="fas fa-bars text-xl"></i>
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
const toggleIcon = document.getElementById("toggleIcon");

function updateToggleState() {
  const sidebarWidth = 256;

  if (sidebar.classList.contains("-translate-x-full")) {
    toggle.style.left = "1rem";
    toggleIcon.classList.remove("fa-chevron-left", "text-indigo-600");
    toggleIcon.classList.add("fa-bars");
  } else {
    toggle.style.left = `${sidebarWidth + 16}px`;
    toggleIcon.classList.remove("fa-bars");
    toggleIcon.classList.add("fa-chevron-left", "text-indigo-600");
  }
}

toggle.addEventListener("click", () => {
  sidebar.classList.toggle("-translate-x-full");
  updateToggleState();
});

// Set posisi awal saat halaman diload
updateToggleState();
</script>



</body>

</html>
