<?php

use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PrayerTimeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Akses Bebas dengan Layout Mobile)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jelajah', [ExploreController::class, 'index'])->name('jelajah');
Route::get('/koleksi', [CollectionController::class, 'index'])->name('koleksi');
Route::post('/koleksi/toggle', [CollectionController::class, 'toggle'])->name('collections.toggle');
Route::get('/waktu-salat', [PrayerTimeController::class, 'index'])->name('waktu-salat');
Route::get('/karya/{slug}', [ArtworkController::class, 'show'])->name('artworks.show');
Route::get('/karya/{slug}/unduh', [ArtworkController::class, 'download'])->name('artworks.download');
Route::post('/donasi', [DonationController::class, 'store'])->name('donations.store');

/*
|--------------------------------------------------------------------------
| Guest Routes (Belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/masuk', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [AuthController::class, 'login'])->name('login.store');

    Route::get('/daftar', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [AuthController::class, 'register'])->name('register.store');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Khusus Pengguna Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/unggah', [ArtworkController::class, 'create'])->name('unggah');
    Route::post('/unggah', [ArtworkController::class, 'store'])->name('artworks.store');
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profil/postingan', [ArtworkController::class, 'myArtworks'])->name('artworks.my');
    Route::delete('/karya/{artwork}', [ArtworkController::class, 'destroy'])->name('artworks.destroy');
    Route::post('/profil/verifikasi', [ProfileController::class, 'submitVerification'])->name('profile.verify');
    Route::post('/profil/rekening', [ProfileController::class, 'storeBankAccount'])->name('profile.bank.store');
    Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Placeholder)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        abort_unless(auth()->user()->isAdmin(), 403);
        return view('admin.dashboard');
    })->name('dashboard');
});
