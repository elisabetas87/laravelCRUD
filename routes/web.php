<?php

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

Route::get('/category/list','CategoryController@listAll')->name('catlist');
Route::view('/category/create','category.create')->name('catcreate');
Route::post('/category/create','CategoryController@create');
Route::view('/category/find','category.find')->name('catfind');
Route::post('/category/find','CategoryController@find');
Route::get('/category/edit/{id}','CategoryController@edit');
Route::post('/category/modify','CategoryController@modify');

Route::get('/product/list','ProductController@listAll')->name('prodlist');
Route::view('/product/create','product.create')->name('prodcreate');
Route::post('/product/create','ProductController@create');
Route::view('/product/find','product.find')->name('prodfind');
Route::post('/product/find','ProductController@find');
Route::get('/product/edit/{id}','ProductController@edit');
Route::post('/product/modify','ProductController@modify');

Route::view('/home','home');