<?php

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

Route::get('/install', function () {
    return view('install');
});

Route::get('/show', function () {
    return view('show');
});

Route::get('/create', function () {
    return view('create');
});

Route::get('/update', function () {
    return view('update');
});

Route::get('/store', function () {
    return view('store');
});

Route::get('/delete', function () {
    return view('delete');
});

Route::get('/index','App\Http\Controllers\ProductController@index');
Route::post('/inventFile','App\Http\Controllers\SupplierController@inventFile');
Route::post('/create','App\Http\Controllers\ProductController@create');
Route::post('/show','App\Http\Controllers\ProductController@show');
Route::post('/update','App\Http\Controllers\ProductController@update');
Route::post('/store','App\Http\Controllers\ProductController@store');
Route::post('/delete','App\Http\Controllers\ProductController@delete');
    
