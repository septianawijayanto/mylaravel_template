<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Route::get('/hapus', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');

    return 'DONE';
});
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('post-login', [LoginController::class, 'postlogin'])->name('post.login');
Route::get('login/cek-username/json', [LoginController::class, 'cekusername']);
Route::get('login/cek-password/json', [LoginController::class, 'cekpassword']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::group(['middleware' => ['auth', 'CheckRole:admin']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('users', UsersController::class);
    Route::get('pengaturan/ubah-password', [UsersController::class, 'edit_password'])->name('ubah.password');
    Route::post('pengaturan/simpan-password', [UsersController::class, 'simpan_password'])->name('simpan.password');
});
