<?php

use App\Http\Controllers\CartControllerWeb;

use App\Http\Controllers\ProductControllerWeb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Product Routes
Route::get('/', [ProductControllerWeb::class,'getAllProduct'])->name('home');
Route::get('getProductDetails/{id}', [ProductControllerWeb::class,'getProductDetails']);
Route::post('addProduct', [ProductControllerWeb::class,'addProduct']);
Route::post('deleteProduct', [ProductControllerWeb::class,'deleteProduct']);
Route::get('getProductCartDetails/{id}', [CartControllerWeb::class,'getProductCartDetails']);


//carts Routes
Route::get('getAllCart', [CartControllerWeb::class,'getAllCart']);
Route::post('addProductToCart', [CartControllerWeb::class,'addProductToCart']);