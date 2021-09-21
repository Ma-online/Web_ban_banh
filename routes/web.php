<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
 Route::get('index', [PageController::class,'getIndex'])->name('trang-chu');
 
 Route::get('loai-san-pham/{type}',[PageController::class,'getLoaiSp'])->name('loaisanpham');

 Route::get('chi-tiet-san-pham/{id}',[PageController::class,'getChiTietSp'])->name('chitietsanpham');

 Route::get('lien-he',[PageController::class,'getLienHe'])->name('lien-he');

 Route::get('gioi-thieu',[PageController::class,'getGioiThieu'])->name('gioi-thieu');
 
 Route::get('add-to-cart/{id}',[PageController::class,'getAddToCart'])->name('themgiohang');

 Route::get('del-cart/{id}',[PageController::class,'getDelItemCart'])->name('xoagiohang');

 Route::post('dat-hang',[PageController::class,'postCheckout'])->name('dathang');

 Route::get('dat-hang',[PageController::class,'getCheckout'])->name('dathang');

 Route::get('dang-nhap',[PageController::class,'getLogin'])->name('dangnhap');
 Route::post('dang-nhap',[PageController::class,'postLogin'])->name('dangnhap');

 Route::get('dang-ky',[PageController::class,'getSignin'])->name('dangky');
 Route::post('dang-ky',[PageController::class,'postSignin'])->name('dangky');

Route::get('dang-xuat',[PageController::class,'getLogout'])->name('dangxuat');

Route::get('search',[PageController::class,'getSearch'])->name('timkiem');

Route::get('phu-kien/{id}',[PageController::class,'getDecoration'])->name('phukien');