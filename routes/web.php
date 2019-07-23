<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');

//$ cd laravel-app
//$ php artisan serve --port=8080
//$ npm run watch    常時起動

//$ npm install  インストール
//$ npm run dev  起動
//$ npm run prod

// git :username s-nobol
// Username for 'https://github.com':  s-nobol
// Password for 'https://s-nobol@github.com':  kiyo1301

// README.ファイル作成
// .env追加

// git add -A
// git commit -m ".env追加"
// git push origin master

// Laravel .env はGitにアップロードできないので
// .env.exampleのファイルに本番用のコードを書きデプロイ後コピーする 
// vue.js にボタン追加

