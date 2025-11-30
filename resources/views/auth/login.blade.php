@extends('layouts.guest')

@section('title', 'Login — SI-Magang')

@section('content')
<div class="relative z-10 fade-up">
  <h2 class="text-3xl font-bold mb-2">Selamat Datang 👋</h2>
  <p class="mb-8">Masuk ke akun SI-Magang untuk melanjutkan.</p>

  @if(session('error'))
    <div class="mb-4 p-3 bg-red-100/20 border border-red-300/30 text-red-400 rounded-lg text-sm">
      <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="space-y-6" id="loginForm">
    @csrf

    <!-- Email -->
    <div>
      <label class="block text-sm font-medium mb-2">Email</label>
      <div class="relative">
        <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
        <input id="email" name="email" type="email" placeholder="mentor@example.com" required
          class="w-full pl-10 pr-3 py-3 rounded-xl bg-white/10 border border-gray-600 placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500 transition-all duration-300">
      </div>
    </div>

    <!-- Password -->
    <div>
      <label class="block text-sm font-medium mb-2">Password</label>
      <div class="relative">
        <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
        <input id="password" name="password" type="password" placeholder="••••••••" required
          class="w-full pl-10 pr-10 py-3 rounded-xl bg-white/10 border border-gray-600 placeholder-gray-400 focus:border-cyan-400 focus:ring-2 focus:ring-cyan-400 transition-all duration-300">
        <button type="button" onclick="togglePassword()" class="absolute right-3 top-3 text-gray-400 hover:text-white">
          <i class="fas fa-eye" id="toggleIcon"></i>
        </button>
      </div>
    </div>

    <!-- Remember Me -->
    <div class="flex justify-between items-center text-sm">
      <label class="flex items-center gap-2">
        <input type="checkbox" name="remember" class="rounded bg-gray-700 border-gray-500">
        Ingat saya
      </label>
      <a href="#" class="text-indigo-400 hover:underline">Lupa password?</a>
    </div>

    <!-- Submit Button -->
    <button id="loginBtn" type="submit" class="relative w-full py-3 rounded-xl font-semibold text-white bg-gradient-to-r from-indigo-500 via-purple-500 to-cyan-400 bg-size-200 bg-pos-0 hover:bg-pos-100 transition-all duration-500 shadow-lg hover:shadow-indigo-800/40">
      <span id="btnText">Masuk Sekarang</span>
      <span id="btnLoader" class="hidden absolute inset-0 flex items-center justify-center"><i class="fas fa-spinner fa-spin"></i></span>
    </button>
  </form>

  <div class="mt-8 text-center text-gray-400 text-sm">
    Belum punya akun? <a href="#" class="text-purple-400 hover:text-purple-300">Hubungi HR</a>
  </div>

  <p class="text-center text-xs text-gray-500 mt-8">
    © 2025 SI-Magang — <span class="text-indigo-400 font-semibold">Websiterz.id</span>. All rights reserved.
  </p>
</div>

<script>
function togglePassword() {
  const input = document.getElementById('password');
  const icon = document.getElementById('toggleIcon');
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  icon.classList.toggle('fa-eye');
  icon.classList.toggle('fa-eye-slash');
  input.animate([{ transform: 'scale(1.02)' }, { transform: 'scale(1)' }], { duration: 200 });
}

// Button loading animation
const loginBtn = document.getElementById('loginBtn');
const loginForm = document.getElementById('loginForm');
loginForm.addEventListener('submit', () => {
  document.getElementById('btnText').classList.add('opacity-0');
  document.getElementById('btnLoader').classList.remove('hidden');
});
</script>
@endsection
