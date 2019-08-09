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

// git push -u origin 作成したブランチ名
// git clone -b ブランチ名 https://リポジトリのアドレス

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
Route::get('/users/{user}/posts', 'UserController@user_posts');
Route::get('/users/{user}/likes', 'UserController@user_like_posts');
Route::put('/users/{user}/details', 'UserController@update2');
Route::post('/users/{user}/image', 'UserController@image_upload');


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
Route::get('/categorys', 'CategoryController@index');


// データベース検索機能
Route::get('/db/{id}', 'DatabaseController@getDatabase');

// メッセージ機能の作成
Route::get('/messages', 'DatabaseController@getmessages');
Route::post('/messages', 'DatabaseController@addmessages');
Route::delete('/messages/{message}', 'DatabaseController@deletemessages');

// postFormアコーディオンは現状態でいい

// 通報機能（Report）
// php artisan make:model Report --all
// php artisan make:request ReportRequest
Route::resource('reports', 'ReportController');


// laravel-test-app.mlドメインの作成

// s3に画像アップロード()

// テスト
//  composer require league/flysystem-aws-s3-v3
Route::post('/test/image', 'DatabaseController@send_image_s3');



// サムネイルの作成

// php のメモリ開放
// php.init/ memory_limit= 128M -> 1024M 
// ec2 再起動


// 8/9 サムネイルの作成に成功した画像をEC2で起動するか確かめてみる。
// php.initのメモリを拡張しなくてはならないかもしれない

// AWS　ESE　申請
// 成功したら全体のView修正
// getScrollButtom　の位置を <div id="posts" の最下部に設定する