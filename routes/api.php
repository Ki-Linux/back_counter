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
use App\Http\Controllers\EveryoneController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CommentController;
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
Route::post('saving', [LoginController::class, 'store']);
Route::post('check_change_password', [LoginController::class,'only_check_password']);
Route::put('check_change_password/{id}', [LoginController::class,'update']);
Route::get('get_information', [LoginController::class,'get_user_info']);
Route::get('get_id', [LoginController::class,'index']);
Route::put('post_reminder_update/{id}', [LoginController::class,'post_reminder_update']);


//Route::post('login', [LoginController::class,'test']);

//Route::middleware(['cors'])->group(function(){

    //Route::get('mail', [MailSendController::class, 'upload']);
Route::post('mail', [MailSendController::class, 'send']);//メール送る
Route::post('comment_report', [MailSendController::class, 'report']);//通報する
Route::post('sendContactMail', [MailSendController::class, 'contact']);//お問い合わせ

//});


Route::post('reminder_send', [ReminderController::class, 'store']);
Route::post('reminder', [ReminderController::class, 'index']);//username data send
Route::delete('delete_reminder/{id}', [ReminderController::class, 'delete']);//リマインダーの削除
Route::put('update_reminder/{id}', [ReminderController::class, 'update']);//リマインダーの既読

Route::post('edit', [EditController::class, 'store']);//自分のデータを入れる
Route::get('edit_show', [EditController::class, 'index']);//自分のデータ一覧
Route::delete('edit_del/{id}', [EditController::class, 'delete']);//自分のデータの削除
Route::put('edit_update/{id}', [EditController::class, 'update']);//自分のデータのアップデート
Route::get('pull_all', [EditController::class, 'allData']);//自分のデータ一覧

Route::get('only_top', [EditController::class, 'onlyTop']);

Route::get('account', [AccountController::class, 'index']);//img, id pull
Route::put('account_update/{id}', [AccountController::class, 'update']);//データを更新

Route::post('album_data', [AlbumController::class, 'store']);//アルバムにデータを入れる
Route::get('my_album_data_get', [AlbumController::class, 'index']);//アルバムからデータを持ってくる
Route::delete('delete_album_data/{id}', [AlbumController::class, 'delete']);//アルバムのデータを消す


Route::get('get_comment', [EveryoneController::class, 'index']);//自分のプロフィールのコメントを表示

Route::get('get_img_good_comment', [DetailController::class, 'index']);//投稿データのコメントを表示
Route::put('details_good_more/{id}', [DetailController::class, 'update']);//投稿データのいいねが更新される


Route::post('add_comment_data', [CommentController::class, 'store']);
Route::get('get_comment_data', [CommentController::class, 'index']);
Route::delete('comment_delete/{id}', [CommentController::class, 'delete']);//削除する

//Route::get('account', [AccountController::class, 'store']);
//Route::group(['middleware' => 'auth:sanctum'], function(){
//Route::get('user', [LoginController::class, 'index']);
//});
//Route::get('/logins', [LoginController::class,'index']);
