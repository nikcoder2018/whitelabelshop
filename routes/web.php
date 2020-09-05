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

Auth::routes();



Route::group(['middleware' => 'auth'], function(){
    Route::get('/', 'DashboardController@index');

    Route::prefix('backoffice')->group(function(){
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    
        Route::resource('users/vendors', 'VendorsController', ['except' => ['update', 'destroy']]);
        Route::post('users/vendors/update', 'VendorsController@update')->name('vendors.update');
        Route::post('users/vendors/delete', 'VendorsController@destroy')->name('vendors.destroy');


        Route::resource('pages', 'PagesController', ['except' => ['update', 'destroy']]);
        Route::post('pages/update', 'PagesController@update')->name('pages.update');
        Route::post('pages/delete', 'PagesController@destroy')->name('pages.destroy');


        Route::resource('tags', 'TagsController');
        Route::resource('posts', 'PostsController');

        Route::resource('products', 'ProductsController', ['except' => ['update', 'destroy']]);
        Route::post('products/update', 'ProductsController@update')->name('products.update');
        Route::post('products/delete', 'ProductsController@destroy')->name('products.destroy');


        Route::resource('categories', 'CategoriesController', ['except' => ['update', 'destroy']]);
        Route::post('categories/update', 'CategoriesController@update')->name('categories.update');
        Route::post('categories/delete', 'CategoriesController@destroy')->name('categories.destroy');


        Route::resource('attributes', 'AttributesController');

        
        Route::prefix('json')->group(function(){
            Route::get('all_categories', 'CategoriesController@getCategoriesJSON')->name('json.getcategories');
            Route::post('get_category', 'CategoriesController@getCategoryDataJSON')->name('json.getcategorydata');
            Route::post('get_vendor', 'VendorsController@getVendorDataJSON')->name('json.getvendordata');
            Route::post('get_page', 'PagesController@getPageDataJSON')->name('json.getpagedata');
        });
    });
});