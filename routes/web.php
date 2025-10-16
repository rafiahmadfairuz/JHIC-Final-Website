<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KwuController;
use App\Http\Controllers\JobfairController;
use App\Http\Controllers\LandingPage\AlumniController;
use App\Http\Controllers\LandingPage\GuruController;
use App\Http\Controllers\LandingPage\MaskotController;
use App\Http\Controllers\LandingPage\PertanyaanController;
use App\Http\Controllers\LandingPage\ProfileSekolahController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\LMS\NilaiController;
use App\Http\Controllers\LMS\KursusController;
use App\Http\Controllers\LMS\ProfileController;
use App\Http\Controllers\LMS\DashboardController;
use App\Http\Controllers\LMS\Dashboard\BadgeController;
use App\Http\Controllers\LMS\Dashboard\KelasController;
use App\Http\Controllers\LMS\Dashboard\MapelController;
use App\Http\Controllers\LMS\Dashboard\TugasController;
use App\Http\Controllers\LMS\Dashboard\JurusanController;
use App\Http\Controllers\LMS\Dashboard\TrackRecordController;
use App\Http\Controllers\LMS\Dashboard\KursusDashboardController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
});
Route::get('/', [LandingPageController::class, 'index']);
Route::middleware('auth')->group(function () {

    Route::prefix('dashboardLanding')->group(function () {
        Route::resource('guru', GuruController::class);
        Route::resource('pertanyaan', PertanyaanController::class);
        Route::resource('alumni', AlumniController::class);
        Route::resource('maskot', MaskotController::class);
        Route::resource('profileSekolah', ProfileSekolahController::class);
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('lms')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('lms.dashboard');
        Route::get('kursus', [KursusController::class, 'index'])->name('lms.kursus');
        Route::get('kursus/{id}', [KursusController::class, 'show'])->name('lms.kursus.show');
        Route::get('kursus/tugas/{id}', [KursusController::class, 'showTugas'])->name('lms.tugas.show');
        Route::post('tugas/{id}/submit', [KursusController::class, 'submit'])->name('lms.tugas.submit');
        Route::get('nilai', [NilaiController::class, 'index'])->name('lms.nilai');
        Route::get('profile', [ProfileController::class, 'index'])->name('lms.profile');
        Route::get('user', [ProfileController::class, 'cariUser'])->name('lms.profile.cari');
        Route::get('user/{id}', [ProfileController::class, 'detailUser'])->name('lms.profile.cari.detail');

        Route::prefix('dashboard')->group(function () {
            Route::resource('jurusan', JurusanController::class);
            Route::resource('badge', BadgeController::class);
            Route::resource('kelas', KelasController::class);
            Route::resource('mapel', MapelController::class);
            Route::resource('kursus', KursusDashboardController::class);
            Route::resource('tugas', TugasController::class);
            Route::resource('trackRecord', TrackRecordController::class);
            Route::get('user', [TrackRecordController::class, 'cariUser'])->name('lms.dashboard.profile.cari');
            Route::get('user/{id}', [TrackRecordController::class, 'detailUser'])->name('lms.dashboard.profile.cari.detail');
        });
    });

    Route::prefix('jobfair')->group(function () {
        Route::get('/', [JobfairController::class, 'index'])->name('jobfair.landing');
        Route::get('/detail/{id}', [JobfairController::class, 'showJobfair'])->name('jobfair.detail');
        Route::get('/melamar/{id}', [JobfairController::class, 'showMelamar'])->name('jobfair.melamar');
        Route::post('/melamar/{id}', [JobfairController::class, 'storeMelamar'])->name('jobfair.storemelamar');
        Route::get('/lamaran/berhasil', [JobfairController::class, 'lamaranBerhasil'])->name('jobfair.lamaran.berhasil');
        Route::get('/profil', [JobfairController::class, 'showProfil'])->name('landing.jobfair.profil');
    });

    Route::prefix('dashboard/jobfair')->group(function () {
        Route::get('/', [JobfairController::class, 'showDashboard'])->name('dashboard.jobfair.index');
        Route::get('/perusahaan', [JobfairController::class, 'showPerusahaan'])->name('dashboard.jobfair.perusahaan');
        Route::get('/pekerjaan', [JobfairController::class, 'showPekerjaan'])->name('dashboard.jobfair.pekerjaan');
        Route::get('/lamaran', [JobfairController::class, 'showLamaran'])->name('dashboard.jobfair.lamaran');
    });

    Route::prefix('kwu')->group(function () {
        Route::get('/', [KwuController::class, 'showBeranda'])->name('landing.kwu.index');
        Route::get('/detailtoko/{id}', [KwuController::class, 'showDetailtoko'])->name('landing.kwu.detailtoko');
        Route::get('/detailproduk/{id}', [KwuController::class, 'showDetailproduk'])->name('landing.kwu.detailproduk');
        Route::get('/profil', [KwuController::class, 'showProfil'])->name('landing.kwu.profil');
        Route::post('/checkout/{produk}', [KwuController::class, 'checkout'])->name('checkout');
        Route::get('/transaksi/{id}', [KwuController::class, 'showTransaksi'])->name('landing.kwu.transaksi');
    });

    Route::prefix('dashboard/kwu')->group(function () {
        Route::get('/', [KwuController::class, 'showDashboard'])->name('dashboard.kwu.index');
        Route::get('/toko', [KwuController::class, 'showToko'])->name('dashboard.kwu.toko');
        Route::get('/kategoriproduk', [KwuController::class, 'showKategoriproduk'])->name('dashboard.kwu.kategori');
        Route::get('/orderproduk', [KwuController::class, 'showOrderproduk'])->name('dashboard.kwu.order');
    });

    Route::prefix('dashboard/kwu/penjual')->group(function () {
        Route::get('/', [PenjualController::class, 'index'])->name('dashboard.penjual.index');
        Route::get('/produk', [PenjualController::class, 'showProduk'])->name('dashboard.penjual.produk');
        Route::get('/orders', [PenjualController::class, 'showOrder'])->name('dashboard.penjual.orders');
    });
});
