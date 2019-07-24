<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessagesRequest;
use App\Message;

use Illuminate\Support\Facades\DB;
class DatabaseController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
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
}
