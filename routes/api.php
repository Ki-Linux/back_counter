<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//追加
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailSendController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('logins', [LoginController::class,'store']);
Route::post('login', [LoginController::class,'login']);

//Route::post('login', [LoginController::class,'test']);

//Route::middleware(['cors'])->group(function(){

    //Route::get('mail', [MailSendController::class, 'upload']);
    Route::post('mail', [MailSendController::class, 'send']);

//});


//Route::group(['middleware' => 'auth:sanctum'], function(){
//Route::get('user', [LoginController::class, 'index']);
//});
//Route::get('/logins', [LoginController::class,'index']);
