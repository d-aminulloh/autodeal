<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\ApiAuthController;

use App\Http\Controllers\API\ApiAdsController;

use App\Http\Controllers\API\ApiCategoryController;
use App\Http\Controllers\API\ApiLocationController;
// use App\Http\Controllers\API\ApiReferenceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [ApiAuthController::class, 'register']);
Route::post('/auth/login_api', [ApiAuthController::class, 'login']);
Route::post('/auth/login', [ApiAuthController::class, 'login']);
Route::post('/auth/forgotpassword-request', [ApiAuthController::class, 'forgotPasswordRequest']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// ternyata sudah otomatis bawaan lv
// Route::get('/unauthorized', function(){
//     return ResponseService::unauthorized();
// })->name('unauthorized');


Route::get('/profile/my-profile', function () {
    // return Auth::guard('web')->user();
    return Auth::user();
})->middleware('web');


//ads
Route::get('/item/get-item-landing',[ ApiAdsController::class, 'getItemLanding'] );
// Route::get('/item/get-my-item-landing',[ ApiAdsController::class, 'getMyItemLanding'])->middleware('auth:sanctum'); // ga jadi dipakai di template baru
// Route::get('/item/get-item',[ ApiAdsController::class, 'getItem'] );
Route::get('/item/get-item',[ ApiAdsController::class, 'getItem2'] );
Route::post('/item/add-my-favorite',[ ApiAdsController::class, 'addMyFavorite'])->middleware('auth:sanctum');
Route::post('/item/remove-my-favorite',[ ApiAdsController::class, 'removeMyFavorite'])->middleware('auth:sanctum');
Route::get('/item/get-my-favorite',[ ApiAdsController::class, 'getMyFavorite'] );
Route::post('/item/create',[ ApiAdsController::class, 'create'])->middleware('auth:sanctum');
Route::post('/item/upload',[ ApiAdsController::class, 'imageUpload'])->middleware('auth:sanctum');
Route::get('/item/create/{cat_id}',[ ApiAdsController::class, 'getCreateContent'])->middleware('auth:sanctum');


//category
Route::get('/category/get-category',[ ApiCategoryController::class, 'getCategory'] );
Route::get('/category/get-category-filter',[ ApiCategoryController::class, 'getCategoryFilter'] );

//location
Route::get('/location/get-location',[ ApiLocationController::class, 'getLocation'] );
Route::get('/location/get-location-by-coordinate',[ ApiLocationController::class, 'getLocationByCoordinate'] );
Route::get('/location/get-location-reference',[ ApiLocationController::class, 'getLocationReference'] );

//reference
// router.get("/get-my-ads-status",
// authJwt.verifyToken,
// mainController.getReference('my_ads_status')
// );
Route::get('/reference/get-my-ads-status', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'my_ads_status']); });


Route::get('/reference/get-ads-type', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_ads_type']); });
Route::get('/reference/get-duration', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_duration']); });
Route::get('/reference/get-condition', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_condition']); });

Route::get('/reference/get-brand-car', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_brand_car']); });
Route::get('/reference/get-brand-model', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_brand_model']); });
Route::get('/reference/get-bathroom-property', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_bathroom']); });
Route::get('/reference/get-bedroom-property', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_bedroom']); });
Route::get('/reference/get-certification-property', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_certification']); });
Route::get('/reference/get-floor-property', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_floor']); });
Route::get('/reference/get-seller-property', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getReference', ['code' => 'cmb_seller_property']); });

Route::get('/reference/get-filter-atype', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_atype']); });
Route::get('/reference/get-filter-acond', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_acond']); });
Route::get('/reference/get-filter-adur', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_adur']); });

Route::get('/reference/get-filter-brandc', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_brandc']); });
Route::get('/reference/get-filter-modc', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_modc']); });
Route::get('/reference/get-filter-transc', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_transc']); });
Route::get('/reference/get-filter-fuelc', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_fuelc']); });
Route::get('/reference/get-filter-engc', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_engc']); });
Route::get('/reference/get-filter-bodyc', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_bodyc']); });
Route::get('/reference/get-filter-passec', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_passec']); });
Route::get('/reference/get-filter-colv', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_colv']); });
Route::get('/reference/get-filter-sellv', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_sellv']); });

Route::get('/reference/get-filter-brandm', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_brandm']); });
Route::get('/reference/get-filter-modm', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_modm']); });
Route::get('/reference/get-filter-transm', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_transm']); });
Route::get('/reference/get-filter-engm', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_engm']); });
Route::get('/reference/get-filter-bodym', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_bodym']); });

Route::get('/reference/get-filter-bedr', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_bedr']); });
Route::get('/reference/get-filter-bath', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_bath']); });
Route::get('/reference/get-filter-floor', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_floor']); });
Route::get('/reference/get-filter-cert', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_cert']); });
Route::get('/reference/get-filter-sellp', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_sellp']); });

Route::get('/reference/get-filter-brandg', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_brandg']); });
Route::get('/reference/get-filter-os', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_os']); });
Route::get('/reference/get-filter-ram', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_ram']); });
Route::get('/reference/get-filter-stor', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_stor']); });

Route::get('/reference/get-filter-gen', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_gen']); });
Route::get('/reference/get-filter-genp', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_genp']); });
Route::get('/reference/get-filter-jobt', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getFilterReference', ['code' => 'get_filter_jobt']); });

Route::get('/reference/get-notification', function () { return App::call('\App\Http\Controllers\API\ApiReferenceController@getNotification', []); })->middleware('auth:sanctum');



// Route::resource('anggota', AnggotaController::class);
// Route::get('/anggota2',[ AnggotaController::class, 'index'] );
