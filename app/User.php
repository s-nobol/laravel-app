<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','sex','address','message','image',
    ];
    
    protected $appends = [ 'user_by_create', 'url',];
    protected $visible = [
        'id', 'name', 'email','message','address', 'sex', 'birthday','image',
        'posts', 'comments', 'user_by_create','likes', 'url'
    ];

    protected $hidden = [ 'password', 'remember_token', ];

    protected $casts = [ 'email_verified_at' => 'datetime', ];
    
    public function getUserByCreateAttribute(){
        if (Auth::guest()) {
            return false;
        }
        return $this->id == Auth::user()->id;
    }
    
    
    public function getUrlAttribute()
    {
        // return Storage::cloud()->url( $this->attributes['image']);
            return "https://ka1301-laravel-test.s3.ap-northeast-1.amazonaws.com/users/".$this->id.'/'.$this->image;
        // }
    }
    
    public function posts()
    {
        return $this->hasMany('App\Post');
    }
    
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function likes(){
        return $this->belongsToMany('App\Post', 'likes')->withTimestamps();
    }
}
