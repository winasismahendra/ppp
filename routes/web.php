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

Route::get('/', 'MasterController@index');
Route::get('/jurusan/tkj', 'MasterController@tkj');
Route::get('/jurusan/perbankan', 'MasterController@perbankan');
Route::get('/jurusan/multimedia', 'MasterController@multimedia');
Route::get('/galeri', 'MasterController@galeri');




/*admin*/

Route::get('/admin', 'AdminController@coba');

Route::get('/admin/halaman-depan/slidebar', 'AdminController@slidebar');
Route::get('/admin/slider/del/{id}', 'AdminController@slider_del')->name('del_slider');
Route::post('/admin/slider/proses', 'AdminController@slider_up')->name('up_slider');


Route::post('/admin/kata-depan/proses', 'AdminController@kata_up')->name('up_kata');
Route::post('/admin/keunggulan/proses', 'AdminController@keunggulan_up')->name('up_keunggulan');

Route::get('/admin/galeri/add', 'AdminController@galeri_add')->name('galeri_add');
Route::post('/admin/galeri/store', 'AdminController@galeri_store')->name('galeri_store');

Route::get('/ppdb', 'AdminController@ppdb');

Route::get('/admin/berita/add', 'AdminController@berita_add')->name('berita_add');
Route::post('/admin/berita/store', 'AdminController@berita_store')->name('berita_store');
Route::get('/admin/berita/controller', 'AdminController@berita_controller')->name('berita_controller');
Route::post('/admin/berita/del', 'AdminController@berita_del')->name('berita_del');
Route::get('/admin/berita/edit/{id}', 'AdminController@berita_edit')->name('berita_edit');
Route::post('/admin/berita/update', 'AdminController@berita_update')->name('berita_update');
Route::get('/admin/berita/search', 'AdminController@berita_search')->name('berita_search');

//cke
Route::post('upload_image','AdminController@berita_upimage')->name('berita_upimage');