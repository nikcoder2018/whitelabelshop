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
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('users/admins', 'AdminsController', ['except' => ['update', 'destroy']]);
    Route::post('users/admins/update', 'AdminsController@update')->name('admins.update');
    Route::post('users/admins/delete', 'AdminsController@destroy')->name('admins.destroy');

    Route::resource('users/vendors', 'VendorsController', ['except' => ['update', 'destroy']]);
    Route::post('users/vendors/update', 'VendorsController@update')->name('vendors.update');
    Route::post('users/vendors/delete', 'VendorsController@destroy')->name('vendors.destroy');

    Route::resource('pages', 'PagesController', ['except' => ['update', 'destroy']]);
    Route::post('pages/update', 'PagesController@update')->name('pages.update');
    Route::post('pages/delete', 'PagesController@destroy')->name('pages.destroy');

    Route::resource('posts', 'PostsController', ['except' => ['update', 'destroy']]);
    Route::post('posts/update', 'PostsController@update')->name('posts.update');
    Route::post('posts/delete', 'PostsController@destroy')->name('posts.destroy');

    Route::resource('tags', 'TagsController', ['except' => ['update', 'destroy']]);
    Route::post('tags/update', 'TagsController@update')->name('tags.update');
    Route::post('tags/delete', 'TagsController@destroy')->name('tags.destroy');

    Route::resource('products', 'ProductsController', ['except' => ['show','update', 'destroy']]);
    Route::post('products/update', 'ProductsController@update')->name('products.update');
    Route::post('products/delete', 'ProductsController@destroy')->name('products.destroy');
    Route::get('products/all', 'ProductsController@all')->name('products.all');

    Route::resource('categories', 'CategoriesController', ['except' => ['update', 'destroy']]);
    Route::post('categories/update', 'CategoriesController@update')->name('categories.update');
    Route::post('categories/delete', 'CategoriesController@destroy')->name('categories.destroy');
    Route::post('categories/sort', 'CategoriesController@sortCategoryAjax')->name('categories.sort');

    Route::resource('locations', 'LocationsController', ['except' => ['update', 'destroy','show']]);
    Route::post('locations/update', 'LocationsController@update')->name('locations.update');
    Route::post('locations/delete', 'LocationsController@destroy')->name('locations.destroy');
    Route::get('locations/import', 'LocationsController@importView')->name('locations.import');
    Route::post('locations/import', 'LocationsController@import')->name('locations.import');
    Route::get('locations/countries', 'LocationsController@countries')->name('locations.countries');
    Route::get('locations/cities', 'LocationsController@cities')->name('locations.cities');
    
    Route::resource('specialoffers', 'SpecialOffersController', ['except' => ['update', 'destroy']]);
    Route::post('specialoffers/update', 'SpecialOffersController@update')->name('specialoffers.update');
    Route::post('specialoffers/delete', 'SpecialOffersController@destroy')->name('specialoffers.destroy');


    Route::resource('attributes', 'AttributesController');

    Route::get('charts', 'ChartsController@index')->name('charts.index');
    
    Route::get('settings/header', 'SettingsController@header')->name('settings.header');
    Route::get('settings/footer', 'SettingsController@footer')->name('settings.footer');
    Route::get('settings/banner', 'SettingsController@banner')->name('settings.banner');
    Route::post('settings/header', 'SettingsController@header')->name('settings.header');
    Route::post('settings/footer', 'SettingsController@footer')->name('settings.footer');
    Route::post('settings/banner', 'SettingsController@banner')->name('settings.banner');
    
    Route::prefix('json')->group(function(){
        Route::get('all_categories', 'CategoriesController@getCategoriesJSON')->name('json.getcategories');
        Route::post('get_category', 'CategoriesController@getCategoryDataJSON')->name('json.getcategorydata');
        Route::post('get_vendor', 'VendorsController@getVendorDataJSON')->name('json.getvendordata');
        Route::post('get_admin', 'AdminsController@getAdminDataJSON')->name('json.getadmindata');
        Route::post('get_page', 'PagesController@getPageDataJSON')->name('json.getpagedata');
        Route::post('get_post', 'PostsController@getPostDataJSON')->name('json.getpostdata');
        Route::post('get_tag', 'TagsController@getTagDataJSON')->name('json.gettagdata');
        Route::post('get_location', 'LocationsController@getLocationDataJSON')->name('json.getlocationdata');
        Route::post('get_specialoffer', 'SpecialOffersController@getOfferDataJSON')->name('json.getspecialofferdata');
    });

});

Route::post('slugify', function(){
    $text = request()->input('text');
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        $text = 'n-a';
    }

    return $text;
})->name('slugify');