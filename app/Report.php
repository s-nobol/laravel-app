<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    
    //
    protected $fillable = [
       'post_id', 'category','title', 'description', 
    ];
    
    
    // /** JSONに含める属性 */
    // protected $visible = [
    //     'user', 'content','id','created_at',
    // ];

    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\post', 'post_id', 'id', 'posts');
    }
}
