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
use \Illuminate\Support\Facades\Route;

Route::prefix('')->middleware('auth')->group(function() {

    Route::resource('GalleryCategory', 'GalleryCategoryController');
    Route::post('GalleryCategory-sort', 'GalleryCategoryController@sort_item')->name('GalleryCategory-sort');

    Route::resource('gallery', 'GalleryController');
    Route::get('gallery-photo-destroy/{id}', 'GalleryController@photo_delete')->name('gallery-photo-destroy');
});
