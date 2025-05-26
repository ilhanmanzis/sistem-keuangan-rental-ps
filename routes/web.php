<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Devices;
use App\Http\Controllers\Laporan;
use App\Http\Controllers\Makanans;
use App\Http\Controllers\ManajemenUser;
use App\Http\Controllers\Members;
use App\Http\Controllers\Minumans;
use App\Http\Controllers\Pengeluarans;
use App\Http\Controllers\Profile;
use App\Http\Controllers\Shifts;
use App\Http\Controllers\Transaksi;
use Illuminate\Support\Facades\Route;

//admin
Route::middleware(['auth', 'role:admin'])->group(function () {

    //manajemen user
    Route::get('/users', [ManajemenUser::class, 'index'])->name('users');
    Route::get('/users/create', [ManajemenUser::class, 'create'])->name('users.create');
    Route::post('/users', [ManajemenUser::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [ManajemenUser::class, 'show'])->name('users.show');
    Route::put('/users/{id}', [ManajemenUser::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [ManajemenUser::class, 'destroy'])->name('users.delete');

    //setting
    Route::get('/setting', [Profile::class, 'index'])->name('setting');
    Route::put('/setting', [Profile::class, 'update'])->name('setting.update');
});


//admin & karyawam
Route::middleware(['auth', 'role:admin,karyawan'])->group(function () {

    //dashboard
    Route::get('/', [Dashboard::class, 'index'])->name('dashboard');

    //device
    Route::get('/device', [Devices::class, 'index'])->name('device.index');
    Route::get('/device/create', [Devices::class, 'create'])->name('device.create');
    Route::post('/device/store', [Devices::class, 'store'])->name('device.store');
    Route::get('/device/{id}', [Devices::class, 'show'])->name('device.show');
    Route::put('/device/update/{id}', [Devices::class, 'update'])->name('device.update');
    Route::delete('/device/store/{id}', [Devices::class, 'destroy'])->name('device.delete');


    //member
    Route::get('/member', [Members::class, 'index'])->name('member.index');
    Route::get('/member/create', [Members::class, 'create'])->name('member.create');
    Route::post('/member/store', [Members::class, 'store'])->name('member.store');
    Route::get('/member/{id}', [Members::class, 'show'])->name('member.show');
    Route::get('/member/print/{id}', [Members::class, 'print'])->name('member.print');
    Route::put('/member/update/{id}', [Members::class, 'update'])->name('member.update');
    Route::delete('/member/store/{id}', [Members::class, 'destroy'])->name('member.delete');


    //makanan
    Route::get('/makanan', [Makanans::class, 'index'])->name('makanan.index');
    Route::get('/makanan/create', [Makanans::class, 'create'])->name('makanan.create');
    Route::post('/makanan/store', [Makanans::class, 'store'])->name('makanan.store');
    Route::get('/makanan/{id}', [Makanans::class, 'show'])->name('makanan.show');
    Route::put('/makanan/update/{id}', [Makanans::class, 'update'])->name('makanan.update');
    Route::delete('/makanan/store/{id}', [Makanans::class, 'destroy'])->name('makanan.delete');


    //minuman
    Route::get('/minuman', [Minumans::class, 'index'])->name('minuman.index');
    Route::get('/minuman/create', [Minumans::class, 'create'])->name('minuman.create');
    Route::post('/minuman/store', [Minumans::class, 'store'])->name('minuman.store');
    Route::get('/minuman/{id}', [Minumans::class, 'show'])->name('minuman.show');
    Route::put('/minuman/update/{id}', [Minumans::class, 'update'])->name('minuman.update');
    Route::delete('/minuman/store/{id}', [Minumans::class, 'destroy'])->name('minuman.delete');


    //shift
    Route::get('/shift', [Shifts::class, 'index'])->name('shift.index');
    Route::get('/shift/create', [Shifts::class, 'create'])->name('shift.create');
    Route::post('/shift/store', [Shifts::class, 'store'])->name('shift.store');
    Route::get('/shift/{id}', [Shifts::class, 'show'])->name('shift.show');
    Route::put('/shift/update/{id}', [Shifts::class, 'update'])->name('shift.update');
    Route::delete('/shift/store/{id}', [Shifts::class, 'destroy'])->name('shift.delete');

    //edit akun
    Route::get('/users/edit/{id}', [ManajemenUser::class, 'edit'])->name('users.edit');
    Route::put('/users/edit/{id}', [ManajemenUser::class, 'updateProfile'])->name('users.update.profile');


    //pengeluaran
    Route::get('/pengeluaran', [Pengeluarans::class, 'index'])->name('pengeluaran.index');
    Route::get('/pengeluaran/create', [Pengeluarans::class, 'create'])->name('pengeluaran.create');
    Route::post('/pengeluaran/store', [Pengeluarans::class, 'store'])->name('pengeluaran.store');
    Route::get('/pengeluaran/{id}', [Pengeluarans::class, 'show'])->name('pengeluaran.show');
    Route::put('/pengeluaran/update/{id}', [Pengeluarans::class, 'update'])->name('pengeluaran.update');
    Route::delete('/pengeluaran/store/{id}', [Pengeluarans::class, 'destroy'])->name('pengeluaran.delete');

    //pemasukan
    Route::get('/pemasukan', [Transaksi::class, 'index'])->name('pemasukan.index');
    Route::get('/pemasukan/create', [Transaksi::class, 'create'])->name('pemasukan.create');
    Route::post('/pemasukan/store', [Transaksi::class, 'store'])->name('pemasukan.store');
    Route::get('/pemasukan/{id}', [Transaksi::class, 'show'])->name('pemasukan.show');
    Route::get('/pemasukan/print/{id}', [Transaksi::class, 'print'])->name('pemasukan.print');
    Route::put('/pemasukan/update/{id}', [Transaksi::class, 'update'])->name('pemasukan.update');
    Route::delete('/pemasukan/store/{id}', [Transaksi::class, 'destroy'])->name('pemasukan.delete');

    //set shift
    Route::post('/set-shift', [Dashboard::class, 'setShift'])->name('set.shift');

    //search member
    Route::get('/member/search/{id}', [Transaksi::class, 'member']);

    Route::get('/laporan', [Laporan::class, 'index'])->name('laporan.index');
    Route::get('/laporan/print', [Laporan::class, 'print'])->name('laporan.print');
});

Route::get('/login', [Auth::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [Auth::class, 'store'])->name('auth.login');
Route::get('/logout', [Auth::class, 'destroy'])->name('logout');
