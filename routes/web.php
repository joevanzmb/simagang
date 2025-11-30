<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PresensiController; 
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VPController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;

// ROOT
Route::get('/', function () {
    if (Auth::check()) {
        switch (Auth::user()->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'mahasiswa':
                return redirect()->route('mahasiswa.dashboard');
            case 'mentor':
                return redirect()->route('mentor.dashboard');
            case 'vp':
                return redirect()->route('vp.dashboard');
            default:
                return redirect('/login');
        }
    }
    return redirect('/login');
});


// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'jumlahAktif' => Mahasiswa::where('status', 'aktif')->count(),
            'jumlahSelesai' => Mahasiswa::where('status', 'selesai')->count(),
            'rekapAbsensi' => '98%',
            'sisaHariMagang' => 32, // TODO: hitung otomatis
        ]);
    })->name('dashboard');

    Route::get('/presensi', [PresensiController::class, 'index'])->name('presensi.index');
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/reminder', [ReminderController::class, 'index'])->name('reminder.index');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/vp', function () {
        return view('vp.index'); // file sama, layout menyesuaikan
    })->name('vp.index');

    // CRUD Mahasiswa (hanya admin)
    Route::resource('mahasiswa', MahasiswaController::class);

    Route::resource('mentor', MentorController::class);
});

// ================= MAHASISWA =================
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/attendance', [MahasiswaController::class, 'attendance'])->name('attendance');
    Route::get('/penilaian', [MahasiswaController::class, 'penilaian'])->name('penilaian');
    Route::get('/laporan', [MahasiswaController::class, 'laporan'])->name('laporan');
    Route::get('/feedback', [MahasiswaController::class, 'feedback'])->name('feedback');
    Route::get('/reminder', [MahasiswaController::class, 'reminder'])->name('reminder');
    Route::get('/profil', [MahasiswaController::class, 'profil'])->name('profil');
    Route::put('/profil/update', [MahasiswaController::class, 'updateProfil'])->name('profil.update');

    // Presensi Mahasiswa
    Route::get('/presensi', [PresensiController::class, 'showForm'])->name('presensi');
    Route::post('/checkin', [PresensiController::class, 'checkIn'])->name('checkin');
});

// ================= MENTOR =================
Route::middleware(['auth', 'role:mentor'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('mentor.dashboard');
    })->name('dashboard');

    Route::get('/presensi', [App\Http\Controllers\PresensiController::class, 'mentorView'])->name('presensi');
    Route::get('/penilaian', [App\Http\Controllers\PenilaianController::class, 'mentorView'])->name('penilaian');
    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'mentorView'])->name('laporan');
    Route::get('/profil', [App\Http\Controllers\ProfileController::class, 'profil'])->name('profil');
    Route::put('/profil/update', [App\Http\Controllers\ProfileController::class, 'updateProfil'])->name('profil.update');
    Route::get('/mahasiswa', [App\Http\Controllers\MahasiswaController::class, 'mentorView'])->name('mahasiswa');
});

//vice president    

Route::middleware(['auth', 'role:vp'])->group(function () {
    Route::get('/vp/dashboard', [VpController::class, 'index'])->name('vp.dashboard');
    Route::get('/vp/approval', [VpController::class, 'approval'])->name('vp.approval');
    Route::get('/vp/history', [VpController::class, 'history'])->name('vp.history');
    Route::get('/vp/statistik', [VpController::class, 'statistik'])->name('vp.statistik');
    Route::get('/vp/profile', [VpController::class, 'profile'])->name('vp.profile');
    Route::put('/vp/profile/update', [VpController::class, 'updateProfil'])->name('vp.profile.update');
});



// ================= PROFILE (semua user login) =================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('mahasiswa/presensi-scan', function () {
    return view('mahasiswa.presensi-scan');
});

Route::get('/mahasiswa/presensi-scan-out', function () {
    return view('mahasiswa.presensi-scan-out');
});

// Authentication routes
require __DIR__.'/auth.php';
