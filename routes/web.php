<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController as ControllersWelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileRenameController;

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
    return view('welcome');
});

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}',[UserController::class,'ubah_simpan']);
Route::get('user/hapus/{id}',[UserController::class,'hapus']);
Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/create',[KategoriController::class, 'create']);
Route::post('/kategori', [KategoriController::class, 'store']);
Route::get('/kategori/create',[KategoriController::class, 'create'])->name('TambahKategori');
Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('EditKategori');
Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('UpdateKategori');
Route::get('/kategori/delete/{id}', [KategoriController::class, 'delete'])->name('DeleteKategori');

Route::get('/m_user/create', function () {return view('m_user.create'); });

Route::get('/kategori/create', [KategoriController::class,'create']);
Route::post('/kategori', [KategoriController::class, 'store']);

Route::resource('m_user', POSController::class);

Route::get('/', [WelcomeController::class,'index']);

Route::group(['prefix' => 'user'], function () {
    // Menampilkan halaman awal user
    Route::get('/', [UserController::class, 'index']);
    // Menampilkan data user dalam bentuk json untuk datatables
    Route::post('/list', [UserController::class, 'list']);
    // Menampilkan halaman form tambah user
    Route::get('/create', [UserController::class, 'create']);
    // Menyimpan data user baru
    Route::post('/', [UserController::class, 'store']);
    // Menampilkan detail user
    Route::get('/{id}', [UserController::class, 'show']);
    // Menampilkan halaman form edit user
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    // Menyimpan perubahan data user
    Route::put('/{id}', [UserController::class, 'update']);
    // Menghapus data user
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

Route::group(['prefix' => 'kategori'], function () {
    // Menampilkan halaman awal kategori
    Route::get('/', [KategoriController::class, 'index']);
    // Menampilkan data kategori dalam bentuk json untuk datatables
    Route::post('/list', [KategoriController::class, 'list']);
    // Menampilkan halaman form tambah kategori
    Route::get('/create', [KategoriController::class, 'create']);
    // Menyimpan data kategori baru
    Route::post('/', [KategoriController::class, 'store']);
    // Menampilkan detail kategori
    Route::get('/{id}', [KategoriController::class, 'show']);
    // Menampilkan halaman form edit kategori
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    // Menyimpan perubahan data kategori
    Route::put('/{id}', [KategoriController::class, 'update']);
    // Menghapus data kategori
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

Route::group(['prefix' => 'barang'], function () {
    // Menampilkan halaman awal barang
    Route::get('/', [BarangController::class, 'index']);
    // Menampilkan data barang dalam bentuk json untuk datatables
    Route::post('/list', [BarangController::class, 'list']);
    // Menampilkan halaman form tambah barang
    Route::get('/create', [BarangController::class, 'create']);
    // Menyimpan data barang baru
    Route::post('/', [BarangController::class, 'store']);
    // Menampilkan detail barang
    Route::get('/{id}', [BarangController::class, 'show']);
    // Menampilkan halaman form edit barang
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    // Menyimpan perubahan data barang
    Route::put('/{id}', [BarangController::class, 'update']);
    // Menghapus data barang
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

Route::group(['prefix' => 'stok'], function () {
    // Menampilkan halaman awal stok
    Route::get('/', [StokController::class, 'index']);
    // Menampilkan data stok dalam bentuk json untuk datatables
    Route::post('/list', [StokController::class, 'list']);
    // Menampilkan halaman form tambah stok
    Route::get('/create', [StokController::class, 'create']);
    // Menyimpan data stok baru
    Route::post('/', [StokController::class, 'store']);
    // Menampilkan detail stok
    Route::get('/{id}', [StokController::class, 'show']);
    // Menampilkan halaman form edit stok
    Route::get('/{id}/edit', [StokController::class, 'edit']);
    // Menyimpan perubahan data stok
    Route::put('/{id}', [StokController::class, 'update']);
    // Menghapus data stok
    Route::delete('/{id}', [StokController::class, 'destroy']);
});

Route::group(['prefix' => 'penjualan'], function () {
    // Menampilkan halaman awal penjualan
    Route::get('/', [PenjualanController::class, 'index']);
    // Menampilkan data penjualan dalam bentuk json untuk datatables
    Route::post('/list', [PenjualanController::class, 'list']);
    // Menampilkan halaman form tambah penjualan
    Route::get('/create', [PenjualanController::class, 'create']);
    // Menyimpan data penjualan baru
    Route::post('/', [PenjualanController::class, 'store']);
    // Menampilkan detail penjualan
    Route::get('/{id}', [PenjualanController::class, 'show']);
    // Menampilkan halaman form edit penjualan
    Route::get('/{id}/edit', [PenjualanController::class, 'edit']);
    // Menyimpan perubahan data penjualan
    Route::put('/{id}', [PenjualanController::class, 'update']);
    // Menghapus data penjualan
    Route::delete('/{id}', [PenjualanController::class, 'destroy']);
});

Route::group(['prefix' => 'level'], function () {
    // Menampilkan halaman awal level
    Route::get('/', [LevelController::class, 'index']);
    // Menampilkan data Level dalam bentuk json untuk datatables
    Route::post('/list', [LevelController::class, 'list']);
    // Menampilkan halaman form tambah Level
    Route::get('/create', [LevelController::class, 'create']);
    // Menyimpan data Level baru
    Route::post('/', [LevelController::class, 'store']);
    // Menampilkan detail Level
    Route::get('/{id}', [LevelController::class, 'show']);
    // Menampilkan halaman form edit Level
    Route::get('/{id}/edit', [LevelController::class, 'edit']);
    // Menyimpan perubahan data Level
    Route::put('/{id}', [LevelController::class, 'update']);
    // Menghapus data Level
    Route::delete('/{id}', [LevelController::class, 'destroy']);
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('proses_login', [AuthController::class, 'proses_login'])->name('proses_login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('proses_register', [AuthController::class, 'proses_register'])->name('proses_register');

/**
 * use Authentication class using middleware aliases in http/kernel
 * to redirect users when they are not authenticate
 */
Route::group(['middleware' => ['auth']], function () {

    /**
     * if user is admin
     */
    Route::group(['middleware' => ['cek_login:1']], function () {
        Route::resource('admin', AdminController::class);
    });
    /**
     * if user is manager
     */
    Route::group(['middleware' => ['cek_login:2']], function () {
        Route::resource('manager', ManagerController::class);
    });
});

Route::get('/', function(){
    return view('welcome');
});
Route::get('/file-upload', [FileUploadController::class, 'fileUpload'])->name('file-upload');
Route::post('/file-upload', [FileUploadController::class, 'prosesfileUpload']);

Route::get('/file-upload-rename', [FileRenameController::class, 'fileUploadRename']);
Route::post('/file-upload-rename', [FileRenameController::class, 'prosesfileUploadRename']);