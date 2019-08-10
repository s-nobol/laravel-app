<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessagesRequest;
use App\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Storage;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
class DatabaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        // $this->authorizeResource(Comment::class, 'comment');   
    }

    
    // データベースを取得するコントローラー
    public function getColumn(string $id){
        // DB::table('information_schema.columns')
        return "データベースにアクセス";
    }
    
    // データベースを取得するコントローラー
    public function getDatabase(string $id){
        
        
        $database =  DB::table($id)->limit(40)->get();
        return $database;
    }
      
    //メッセージの作成
    public function addmessages(MessagesRequest $request){
        
        Message::create($request->all());
        return $request;
    }
    //メッセージの取得
    public function getmessages(){
        return Message::all();
    }
    //メッセージの削除
    public function deletemessages(Message $message){
        $message->delete();
        return "削除しました";
    }
    
    
    public function send_image_s3(Request $request){
        
        // 投稿写真の拡張子を取得する
        // $extension = $request->image->extension();
        
        
            // s3のディレクトリごと削除
            // Storage::cloud()->delete('/posts/2');
            $directory = "/posts/2";
            Storage::cloud()->deleteDirectory($directory);
            
        // return $request->image;

        return "画像の516165送信";

    }
    
    // メール送信テスト
    public function send_email(){
        Mail::to('ka1301@outlook.jp')->send(new TestMail());
        return "メールの送信完了";
    }
}