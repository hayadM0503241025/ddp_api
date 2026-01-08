<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, UserController, CapaianController, 
    BeritaartikelController, MonografiController, InfografisController, 
    GaleriController, BukuController, JurnalController, 
    MitraController, TestimoniController, DownloadController, ContactController
};

/* --- 1. JALUR PUBLIK (Website Depan) --- */
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);

// Capaian & Mitra
Route::get('/public/capaian', [CapaianController::class, 'index']);
Route::get('/public/mitra', [MitraController::class, 'index']);

// Berita & Artikel
Route::get('/public/berita', [BeritaartikelController::class, 'getLatest']); // 3 Terbaru
Route::get('/public/berita/all', [BeritaartikelController::class, 'index']); // Semua
Route::get('/public/berita/count', function() { return response()->json(['total' => \App\Models\Beritaartikel::count()]); });

// Galeri
Route::get('/public/galeri', [GaleriController::class, 'getLatest']); // 11 Terbaru
Route::get('/public/galeri/all', [GaleriController::class, 'index']); // Semua

// Testimoni & Kontak
Route::get('/public/testimoni/featured', function() { return \App\Models\Testimoni::where('is_tampil', 1)->latest()->take(3)->get(); });
Route::get('/public/testimoni/count', function() { return response()->json(['total' => \App\Models\Testimoni::count()]); });
Route::post('/public/contact', [ContactController::class, 'store']);

// Infografis
Route::get('/public/infografis', [InfografisController::class, 'index']);
Route::get('/public/infografis/featured', [InfografisController::class, 'featured']);
Route::post('/public/infografis/{id}/download', [InfografisController::class, 'downloadZip']);

// Monografi
Route::get('/public/monografi/featured', function() { return \App\Models\Monografi::where('is_featured', 1)->take(5)->get(); });
Route::get('/public/monografi/all', [MonografiController::class, 'index']);
Route::post('/public/monografi/download', [DownloadController::class, 'store']);

// Pustaka (Buku & Jurnal)
Route::get('/public/buku/all', [BukuController::class, 'index']);
Route::get('/public/jurnal/all', [JurnalController::class, 'index']);

/* --- 2. JALUR PRIVATE (Admin Dashboard) --- */
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users/{id}/toggle-approve', [UserController::class, 'toggleApprove']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    Route::apiResource('capaian', CapaianController::class);
    Route::apiResource('beritaartikel', BeritaartikelController::class);
    Route::apiResource('monografi', MonografiController::class);
    Route::apiResource('infografis', InfografisController::class);
    Route::apiResource('galeri', GaleriController::class);
    Route::apiResource('buku', BukuController::class);
    Route::apiResource('jurnal', JurnalController::class);
    Route::apiResource('mitra', MitraController::class);
    Route::apiResource('testimoni', TestimoniController::class);

    Route::post('/monografi/{id}/toggle-featured', [MonografiController::class, 'toggleFeatured']);
    Route::post('/infografis/{id}/toggle-home', [InfografisController::class, 'toggleHome']);
    Route::post('/testimoni/{id}/toggle-tampil', [TestimoniController::class, 'toggleTampil']);
});