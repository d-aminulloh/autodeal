<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ApiAuthController;
// use ResponseService;

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

// Route::post('/api/auth/login', [ApiAuthController::class, 'login']);
Route::get('/login', function () { return redirect('/?r=login'); })->name('login');
Route::get('/logout', function(){ auth()->logout(); return redirect('/');})->name('logout');

// Route::get('/refresh-csrf', function() {
//     return response()->json(csrf_token(), 200);
// });

// Route::post('/api/auth/login', [AuthController::class, 'login']);

Route::get('/', function () {
    return view('item.landing');
})->name('landing');

Route::prefix('item')->group(function () {
    Route::get('/search/q-', function () { return App::call('\App\Http\Controllers\AdsController@adsSearch', ['category_slug' => "", 'search' => '']); })->name('search_allcategory');
    Route::get('/search/q-{search}', function ($search) { return App::call('\App\Http\Controllers\AdsController@adsSearch', ['category_slug' => "", 'search' => $search]); })->name('search_allcategory2');
    Route::get('/search/c-{category_slug}', function ($category_slug) { return App::call('\App\Http\Controllers\AdsController@adsSearch', ['category_slug' => $category_slug, 'search' => ""]); });    
    /* handle search kosong */
    Route::get('/search/c-{category_slug}/q-', function ($category_slug) { return App::call('\App\Http\Controllers\AdsController@adsSearch', ['category_slug' => $category_slug, 'search' => ""]); });
    Route::get('/search/c-{category_slug}/q-{search}', function ($category_slug, $search) { return App::call('\App\Http\Controllers\AdsController@adsSearch', ['category_slug' => $category_slug, 'search' => $search]); });
    Route::get('/i-{id}', function ($id) { return App::call('\App\Http\Controllers\AdsController@adsDetail', ['id' => $id]); });    
    Route::get('/buat-iklan', function () { return view('item.create'); })->middleware('auth')->name('item.create');
});



// Route::get('/favorite', function () {
//     return view('item.detail');
// });

// Route::get('/item/category', function () {
//     return view('item.catogry');
// });

// middleware('web')->group(function () {
// });

Route::prefix('profil')->group(function () {
    Route::get('/iklan-favorit', function () { return view('profile.myfavorite'); })->middleware('auth')->name('myfavorite');
    Route::get('/profil-saya', function () { return App::call('\App\Http\Controllers\ProfileController@myProfile', []); })->middleware('auth')->name('myprofile');
    Route::get('/profil-saya-edit', function () { return App::call('\App\Http\Controllers\ProfileController@myProfileEdit', []); })->middleware('auth')->name('myprofileedit');
    Route::get('/iklan-saya', function () { return view('profile.myitem'); })->middleware('auth')->name('myitem');

    Route::get('/seller-{seller_id}', function ($seller_id) {
        return "seller page";
    })->name('profil.seller');;

    Route::get('/setting', function () {
        return "setting page";
    })->middleware('auth')->name('profile.setting');
    
    Route::get('/message', function () {
        return "message page";
    })->middleware('auth')->name('profile.message');
    

    Route::get('/notification', function () {
        return "notification page";
    })->middleware('auth')->name('profile.notification');

});


Route::get('/help', function () {
    return "help page";
})->name('help');


// Route::resource('anggota', AnggotaController::class);

// Route::get('/html', function () {
//     return view('anggota.anggota');
// });

// Route::get('/anggota2', function () {
//     return view('anggota.anggota2');
// });

