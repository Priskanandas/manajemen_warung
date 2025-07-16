<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Warung;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\{
    DashboardController, UserController, RoleController,
    WarungController, PembelianController, HargaController, BarangController,
    PembayaranController, PenjualanController, KategoriController, SelectWarungController
};

// Halaman awal
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('welcome');
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ======================
// 🔒 Untuk user login → akses pilih warung
Route::middleware('auth')->group(function () {
    Route::get('/pilih-warung', [SelectWarungController::class, 'index'])->name('warung.select');
    Route::post('/pilih-warung', [SelectWarungController::class, 'pilih'])->name('auth.pilih-warung.post');
	// ✅ Tambahkan ini untuk logout
});

// 🔐 Untuk user biasa → sudah pilih warung
Route::middleware(['auth', 'check.warung'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');
    Route::get('/harga', [HargaController::class, 'index'])->name('harga');

    Route::get('/logs', [DashboardController::class, 'activity_logs'])->name('logs');
    Route::post('/logs/delete', [DashboardController::class, 'delete_logs'])->name('logs.delete');
	
	// Settings menu
	Route::view('/settings', 'admin.settings')->name('settings');
	Route::post('/settings', [DashboardController::class, 'settings_store'])->name('settings');
	
	// Profile menu
	Route::view('/profile', 'admin.profile')->name('profile');
	Route::post('/profile', [DashboardController::class, 'profile_update'])->name('profile');
	Route::post('/profile/upload', [DashboardController::class, 'upload_avatar'])
		->name('profile.upload');

	// Member menu
	Route::get('/member', [UserController::class, 'index'])->name('member');
	Route::get('/member/create', [UserController::class, 'create'])->name('member.create');
	Route::post('/member/create', [UserController::class, 'store'])->name('member.create');
	Route::get('/member/{id}/edit', [UserController::class, 'edit'])->name('member.edit');
	Route::post('/member/{id}/update', [UserController::class, 'update'])->name('member.update');
	Route::post('/member/{id}/delete', [UserController::class, 'destroy'])->name('member.delete');

	// Roles menu
	Route::get('/roles', [RoleController::class, 'index'])->name('roles');
	Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
	Route::post('/roles/create', [RoleController::class, 'store'])->name('roles.create');
	Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name('roles.edit');
	Route::post('/roles/{id}/update', [RoleController::class, 'update'])->name('roles.update');
	Route::post('/roles/{id}/delete', [RoleController::class, 'destroy'])->name('roles.delete');
	//warung 
	Route::get('/warung', [WarungController::class, 'index'])->name('warung');
    Route::get('/warung/tambah', [WarungController::class, 'tambah'])->name('warung.tambah');
    Route::post('/warung/store', [WarungController::class, 'store'])->name('warung.store');
    Route::post('/warung/update/{id}', [WarungController::class, 'update'])->name('warung.update');
    Route::get('/warung/edit/{id}', [WarungController::class, 'edit'])->name('warung.edit');
    Route::get('/warung/delete/{id}', [WarungController::class, 'delete'])->name('warung.delete');
	Route::get('/warung/ajax/{id}', [WarungController::class, 'ajax'])->name('warung.ajax');

	//pembelian
	Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian');
    Route::get('/pembelian/tambah', [PembelianController::class, 'tambah'])->name('pembelian.tambah');
    Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::post('/pembelian/update/{id}', [PembelianController::class, 'update'])->name('pembelian.update');
    Route::get('/pembelian/edit/{id}', [PembelianController::class, 'edit'])->name('pembelian.edit');
    Route::get('/pembelian/delete/{id}', [PembelianController::class, 'delete'])->name('pembelian.delete');
	Route::get('/pembelian/ajax/{id}', [PembelianController::class, 'ajax'])->name('pembelian.ajax');
	
	//harga
	Route::get('/harga', [HargaController::class, 'index'])->name('harga');
   Route::get('/harga/create', [HargaController::class, 'create'])->name('harga.create');
    Route::post('/harga/store', [HargaController::class, 'store'])->name('harga.store');
    Route::post('/harga/update/{id}', [HargaController::class, 'update'])->name('harga.update');
    Route::get('/harga/edit/{id}', [HargaController::class, 'edit'])->name('harga.edit');
    Route::get('/harga/delete/{id}', [HargaController::class, 'delete'])->name('harga.delete');
	Route::get('/harga/ajax/{id}', [HargaController::class, 'ajax'])->name('harga.ajax');
	
	 //Barang
	 Route::get('/barang', [BarangController::class, 'index'])->name('barang');
	 Route::get('/barang/tambah', [BarangController::class, 'create'])->name('barang.tambah');
	 Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
	 Route::post('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
	 Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
	 Route::get('/barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.delete');
	 Route::get('/barang/cari', [BarangController::class, 'show'])->name('barang.cari');
 
	 //Kategori
	 Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
	 Route::get('/kategori/tambah', [KategoriController::class, 'create'])->name('kategori.tambah');
	 Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
	 Route::post('/kategori/update/{id}', [KategoriController::class, 'update'])->name('kategori.update');
	 Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('kategori.edit');
	 Route::get('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');
	 Route::get('/kategori/cari', [KategoriController::class, 'show'])->name('kategori.cari');

	//penjualan
	Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan');
    Route::get('/penjualan/create', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::post('/penjualan/update/{id}', [PenjualanController::class, 'update'])->name('penjualan.update');
    Route::get('/penjualan/edit/{id}', [PenjualanController::class, 'edit'])->name('penjualan.edit');
    Route::get('/penjualan/delete/{id}', [PenjualanController::class, 'delete'])->name('penjualan.delete');
	Route::get('/penjualan/rekap', [PenjualanController::class, 'rekap'])->name('penjualan.rekap');

	 //Pembayaran
	 //Route::resource('pembayaran', PembayaranController::class);
	 Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran');
	 Route::post('/pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');
	 Route::get('/pembayaran/cari-barang', [PembayaranController::class, 'cariBarang'])->name('pembayaran.cari-barang');
	 Route::get('/pembayaran/nota/{id}', [PembayaranController::class, 'nota'])->name('pembayaran.nota');

	 // Route::resource('pembayaran', PembayaranController::class)->names([
	//	'index' => 'pembayaran.baru',
	//	'store' => 'pembayaran.store'
	// ]);
	 Route::get('/pembayaran/list-barang/{id}', [PembayaranController::class, 'listBarang'])->name('pembayaran.list-barang');
 
	});

require __DIR__.'/auth.php';
