<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//Product Routes
Route::get('products', [ProductController::class,'getAllProduct']);
Route::get('getProductDetails/{id}', [ProductController::class,'getProductDetails']);
Route::post('addProduct', [ProductController::class,'addProduct']);
Route::get('getProductCartDetails/{id}', [CartController::class,'getProductCartDetails']);
Route::post('deleteProduct', [ProductController::class,'deleteProduct']);
//carts Routes
Route::get('getAllCart', [CartController::class,'getAllCart']);
Route::post('addProductToCart', [CartController::class,'addProductToCart']);


