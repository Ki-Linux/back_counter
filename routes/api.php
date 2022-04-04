<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//追加
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MailSendController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\EditController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AlbumController;
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

//Route::post('logins', [LoginController::class,'store']);
Route::post('login', [LoginController::class,'login']);

//Route::post('login', [LoginController::class,'test']);

//Route::middleware(['cors'])->group(function(){

    //Route::get('mail', [MailSendController::class, 'upload']);
    Route::post('mail', [MailSendController::class, 'send']);

//});
Route::post('saving', [LoginController::class, 'store']);

Route::post('reminder_send', [ReminderController::class, 'store']);
Route::post('reminder', [ReminderController::class, 'index']);//username data send
Route::delete('delete_reminder/{id}', [ReminderController::class, 'delete']);//リマインダーの削除
Route::put('update_reminder/{id}', [ReminderController::class, 'update']);//リマインダーの既読

Route::post('edit', [EditController::class, 'store']);//自分のデータを入れる
Route::post('edit_show', [EditController::class, 'index']);//自分のデータ一覧
Route::delete('edit_del/{id}', [EditController::class, 'delete']);//自分のデータの削除
Route::put('edit_update/{id}', [EditController::class, 'update']);//自分のデータのアップデート
Route::get('pull_all', [EditController::class, 'allData']);//自分のデータ一覧

Route::get('only_top', [EditController::class, 'onlyTop']);

Route::post('account', [AccountController::class, 'index']);//img, id pull
Route::put('account_update/{id}', [AccountController::class, 'update']);//データを更新

Route::get('album_data', [AlbumController::class, 'index']);//自分のデータ一覧
//Route::get('account', [AccountController::class, 'store']);
//Route::group(['middleware' => 'auth:sanctum'], function(){
//Route::get('user', [LoginController::class, 'index']);
//});
//Route::get('/logins', [LoginController::class,'index']);
