<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    protected $perPage = 15; 
    protected $fillable = [
        'title', 'description', 
    ];
    
    protected $appends = [ 'user_by_create','user_by_liked','likes_count', 'comments_count' ,'url'];
    protected $visible = [
        'id', 'token','title', 'description', 'image', 'created_at',
        'user','category', 'user_by_create',
        'user_by_liked','likes_count', 'comments_count','url',
    ];

    /** プライマリキーの型 */
    protected $keyType = 'string';

    /** IDの桁数 */
    const ID_LENGTH = 12;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (! array_get($this->attributes, 'token')) {
            $this->setId();
        }
    }

    /** ランダムなID値をid属性に代入する */
    private function setId()
    {
        $this->attributes['token'] = $this->getRandomId();
    }

    /**ランダムなID値を生成する @return string*/
    private function getRandomId()
    {
        $characters = array_merge(
            range(0, 9), range('a', 'z'),
            range('A', 'Z'), ['-', '_']
        );

        $length = count($characters);

        $id = "";

        for ($i = 0; $i < self::ID_LENGTH; $i++) {
            $id .= $characters[random_int(0, $length - 1)];
        }

        return $id;
    }
    
    // owner もし作生者ならTure
    public function getUserByCreateAttribute(){
        if (Auth::guest()) {
            return false;
        }
        return $this->user_id == Auth::user()->id;

    }
    
    public function getUserByLikedAttribute(){
        if (Auth::guest()) {
            return false;
        }
    
        return $this->likes->contains(function ($user) {
            return $user->id === Auth::user()->id;
        });
    }
    public function getLikesCountAttribute() {
        return $this->likes->count();
    }
    public function getCommentsCountAttribute() {
        return $this->comments->count();
    }
    
    public function getUrlAttribute()
    {
        // return "https://ka1301-laravel-test.s3.ap-northeast-1.amazonaws.com/posts/".$this->id.'/'.$this->image;
        return "https://ka1301-laravel-test.s3.ap-northeast-1.amazonaws.com/posts/".$this->id.'/';
    } 
    public function getThumAttribute()
    {
        return "https://ka1301-laravel-test.s3.ap-northeast-1.amazonaws.com/posts/".$this->id.'/'.$this->image;
    }
    /**
    * リレーションシップ - usersテーブル
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function user(){
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }
    
    public function category(){
        return $this->belongsTo('App\Category', 'category_id', 'id', 'categories');
    }
    
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }
    
    public function likes(){
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }
    
}
