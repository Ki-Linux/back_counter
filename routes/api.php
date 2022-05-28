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

use Illuminate\Support\Facades\Storage;
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

Route::group(['middleware' => ['api', 'cors']], function(){
    Route::options('articles', function() {
        return response()->json();
    });
    Route::resource('articles', 'Api\ArticlesController');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [LoginController::class,'login']);
Route::post('saving', [LoginController::class, 'store']);
Route::post('check_change_password', [LoginController::class,'only_check_password']);
Route::put('check_change_password/{id}', [LoginController::class,'update']);
Route::get('get_information', [LoginController::class,'get_user_info']);
Route::get('get_id', [LoginController::class,'index']);
Route::get('confirm_token', [LoginController::class,'confirm_token']);
Route::put('post_reminder_update/{id}', [LoginController::class,'post_reminder_update']);
Route::delete('logout/{id}', [LoginController::class,'delete']);


Route::post('mail', [MailSendController::class, 'send']);//メール送る
Route::post('comment_report', [MailSendController::class, 'report']);//通報する
Route::post('sendContactMail', [MailSendController::class, 'contact']);//お問い合わせ


Route::post('reminder_send', [ReminderController::class, 'store']);
Route::get('reminder', [ReminderController::class, 'index']);//usernameデータを送る
Route::delete('delete_reminder/{id}', [ReminderController::class, 'delete']);//リマインダーの削除
Route::put('update_reminder/{id}', [ReminderController::class, 'update']);//リマインダーの既読


Route::post('edit', [EditController::class, 'store']);//自分のデータを入れる
Route::get('edit_show', [EditController::class, 'index']);//自分のデータ一覧
Route::delete('edit_del/{id}', [EditController::class, 'delete']);//自分のデータの削除
Route::put('edit_update/{id}', [EditController::class, 'update']);//自分のデータのアップデート
Route::get('pull_all', [EditController::class, 'allData']);//自分のデータ一覧
Route::get('only_top', [EditController::class, 'onlyTop']);//トップに表示するデータ


Route::get('account', [AccountController::class, 'index']);//img, id pull
Route::put('account_update/{id}', [AccountController::class, 'update']);//データを更新
Route::post('img_account_post', [AccountController::class, 'img_post']);


Route::post('album_data', [AlbumController::class, 'store']);//アルバムにデータを入れる
Route::get('my_album_data_get', [AlbumController::class, 'index']);//アルバムからデータを持ってくる
Route::delete('delete_album_data/{id}', [AlbumController::class, 'delete']);//アルバムのデータを消す


Route::get('get_comment', [EveryoneController::class, 'index']);//自分のプロフィールのコメントを表示


Route::get('get_img_good_comment', [DetailController::class, 'index']);//投稿データのコメントを表示
Route::put('details_good_more/{id}', [DetailController::class, 'update']);//投稿データのいいねが更新される


Route::post('add_comment_data', [CommentController::class, 'store']);
Route::get('get_comment_data', [CommentController::class, 'index']);
Route::delete('comment_delete/{id}', [CommentController::class, 'delete']);//削除する


Route::post('counter_image', function() {//カウンター画像

    $length = request()->data_length;

    for($key=0; $key < $length; $key++) {

        $file_name = request()->$key->getClientOriginalName();
        request()->$key->storeAs('public/counter/', $file_name);

    }

    return true;
    
});

Route::post('album_post_image', function() {//アルバム画像

    $default_or_selected = request()->default_or_selected;
    $album_or_post = request()->album_or_post;

    if($default_or_selected == 'true') {

        $file_name = request()->file->getClientOriginalName();
        request()->file->storeAs('public'.$album_or_post, $file_name);

    } else {

        $move_file_name = request()->file;
        
        Storage::copy('public/counter/'.$move_file_name, 'public'.$album_or_post.$move_file_name);
    }
    
    return true;
    
});

Route::post('storage_counter_delete', function() {//カウンター画像を削除

    $delete_image = request()->delete_image;

    $array_image_delete = explode(',', $delete_image);

    for($i=0; $i < count($array_image_delete); $i++) {
        Storage::delete('public/counter/'.$array_image_delete[$i]);
    }

    return true;


});
