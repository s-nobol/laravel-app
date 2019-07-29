<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Vou-router　login,作成
// php artisan serve --port=8080
// npm run watch 
// php artisan migrate:rollback

Route::get('/user', function () {
    return Auth::user();
});

// トークンリフレッシュ
Route::get('/reflesh-tiken', function(Request $request){
    $request->session()->regenerateToken();
    return response()->json();
});

Auth::routes();



// ユーザーページ作成?
Route::resource('users', 'UserController');
Route::get('/users/{id}/view', 'UserController@view');



// 記事作成編集
Route::resource('posts', 'PostController');
Route::get('/posts/{id}/view', 'PostController@view');

// コメント機能
Route::get('/posts/{post}/comments', 'CommentController@view');
Route::post('/posts/{post}/comments', 'CommentController@store');
Route::delete('/posts/{comment}/comments', 'CommentController@destroy');

// いいね機能
Route::put('/posts/{post}/like', 'LikeController@store');
Route::delete('/posts/{post}/like', 'LikeController@destroy');

// カテゴリ機能


// データベース検索機能
Route::get('/db/{id}', 'DatabaseController@getDatabase');

// メッセージ機能の作成
Route::get('/messages', 'DatabaseController@getmessages');
Route::post('/messages', 'DatabaseController@addmessages');
Route::delete('/messages/{message}', 'DatabaseController@deletemessages');

// postFormアコーディオンは現状態でいい

// ブラんち作成
// コメント通報機能（Report）
// ユーザーロール及びプロフィール情報ついか　

// ページネーションは最後

