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


Route::prefix('admin')->group(function(){
    Auth::routes();
    
    Route::group(['middleware' => 'auth'], function(){
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('/users/admins', 'AdminsController');
        Route::resource('/users/vendors', 'VendorsController');
        Route::resource('/pages', 'PagesController');
        Route::resource('/tags', 'TagsController');
        Route::resource('/posts', 'PostsController');
        Route::resource('/products', 'ProductsController');
        Route::resource('/categories', 'CategoriesController');
        Route::resource('/attributes', 'AttributesController');

        Route::prefix('json')->group(function(){
            Route::get('categories', 'CategoriesController@getCategoriesJSON')->name('json.getcategories');
        });
    });
});