<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'SI-Magang')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    * { font-family: 'Inter', sans-serif; transition: all 0.3s ease; }

    body {
      margin: 0;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      background: radial-gradient(circle at 30% 30%, #e0f2fe, #f8fafc);
      color: #111827;
      transition: background 0.8s ease, color 0.5s ease;
    }

    body.dark {
      background: radial-gradient(circle at 25% 25%, #1e1b4b, #0f172a);
      color: white;
    }

    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(120px);
      opacity: 0.25;
      animation: float 8s ease-in-out infinite alternate;
    }

    .blob-1 { width: 400px; height: 400px; background: #7c3aed; top: -100px; left: -100px; }
    .blob-2 { width: 350px; height: 350px; background: #06b6d4; bottom: -100px; right: -120px; animation-delay: 2s; }

    @keyframes float {
      from { transform: translateY(0) scale(1); }
      to { transform: translateY(30px) scale(1.05); }
    }

    .glass {
      position: relative;
      background: rgba(255, 255, 255, 0.4);
      backdrop-filter: blur(20px);
      border-radius: 2rem;
      border: 1px solid rgba(255, 255, 255, 0.6);
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
      overflow: hidden;
      z-index: 5;
      transition: 0.5s ease;
      animation: fadeIn 1s ease forwards;
    }

    body.dark .glass {
      background: rgba(255, 255, 255, 0.05);
      border-color: rgba(255, 255, 255, 0.08);
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
    }

    .glass:hover {
      transform: translateY(-4px);
      box-shadow: 0 35px 80px rgba(0, 0, 0, 0.3);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .logo-animate { animation: floatLogo 3s ease-in-out infinite; }
    @keyframes floatLogo {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-8px); }
    }

    /* iPhone-style switch */
    .switch {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 60px;
      height: 32px;
      border-radius: 9999px;
      background: #e5e7eb;
      border: 1px solid #cbd5e1;
      cursor: pointer;
      display: flex;
      align-items: center;
      padding: 3px;
      transition: background 0.3s ease;
      z-index: 50;
    }

    .switch.dark {
      background: #334155;
      border-color: #475569;
    }

    .switch-ball {
      width: 26px;
      height: 26px;
      border-radius: 50%;
      background: white;
      transition: transform 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .switch.dark .switch-ball {
      transform: translateX(28px);
      background: #fbbf24;
    }
  </style>
</head>

<body class="light">
  <!-- Theme Switch -->
  <div id="themeSwitch" class="switch">
    <div class="switch-ball"><i class="fas fa-moon text-xs text-gray-600"></i></div>
  </div>

  <!-- Floating blobs -->
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>

  <!-- Aurora background -->
  <div class="absolute inset-0 overflow-hidden">
    <div class="absolute -top-32 -left-32 w-[600px] h-[600px] bg-gradient-to-br from-purple-600/30 via-pink-400/30 to-cyan-400/30 blur-[120px] animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-gradient-to-tr from-blue-400/20 via-purple-500/30 to-pink-400/20 blur-[100px] animate-[spin_40s_linear_infinite]"></div>
  </div>

  <!-- Main layout -->
  <main class="glass w-[92%] max-w-5xl flex flex-col md:flex-row overflow-hidden relative z-10">
    <!-- Left branding -->
    <section class="hidden md:flex flex-col justify-center items-center w-1/2 bg-gradient-to-br from-indigo-600 via-violet-500 to-purple-700 text-white p-12 text-center relative">
      <div class="z-10">
        <div class="w-24 h-24 mx-auto mb-6 rounded-2xl flex items-center justify-center bg-white/10 logo-animate">
          <i class="fas fa-graduation-cap text-4xl text-white"></i>
        </div>
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-100 drop-shadow-md">SI-Magang</h1>
        <p class="text-white/80 mt-3 leading-relaxed text-lg">Sistem Informasi Magang modern dengan manajemen terpusat dan keamanan terpercaya.</p>
      </div>
    </section>

    <!-- Right content -->
    <section class="w-full md:w-1/2 p-10 bg-white/10 backdrop-blur-xl flex flex-col justify-center relative">
      @yield('content')
    </section>
  </main>

  <script>
  // Theme toggle slider
  const switchBtn = document.getElementById('themeSwitch');
  switchBtn.addEventListener('click', () => {
    const body = document.body;
    body.classList.toggle('dark');
    switchBtn.classList.toggle('dark');

    const icon = switchBtn.querySelector('i');
    if (body.classList.contains('dark')) {
      icon.classList.replace('fa-moon', 'fa-sun');
      icon.classList.add('text-white');
    } else {
      icon.classList.replace('fa-sun', 'fa-moon');
      icon.classList.remove('text-white');
    }
  });

  // Parallax effect
  const card = document.querySelector('.glass');
  document.addEventListener('mousemove', e => {
    const x = (window.innerWidth / 2 - e.pageX) / 40;
    const y = (window.innerHeight / 2 - e.pageY) / 40;
    card.style.transform = `rotateY(${x}deg) rotateX(${y}deg)`;
  });
  document.addEventListener('mouseleave', () => {
    card.style.transform = 'rotateY(0deg) rotateX(0deg)';
  });
  </script>
</body>
</html>
