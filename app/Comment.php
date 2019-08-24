<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    protected $perPage = 5; 
    protected $fillable = [
        'content', 'post_id',
    ];
    
    // protected $appends = [ 'user_by_create', ];
    
    /** JSONに含める属性 */
    protected $visible = [
        'user', 'content','id','created_at',
    ];

    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }
    
      // owner もし作生者ならTure
    public function getUserByCreateAttribute(){
        if (Auth::guest()) {
            return false;
        }
        return $this->user_id == Auth::user()->id;

    }
    
}
