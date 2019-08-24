<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    
    protected $perPage = 5; 
    protected $fillable = [
       'post_id', 'category','title', 'description', 
    ];
    
    
    // /** JSONに含める属性 */
    protected $visible = [
        'post','id','created_at','title','description','post_id',
    ];

    /**
     * リレーションシップ - usersテーブル
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id', 'id', 'posts');
    }
}
