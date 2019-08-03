<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $fillable = [
        'title', 'description', 
    ];
    //  /** JSONに含める属性 */
    protected $visible = [
        'name', 'id',
    ];
    
    
    public function comments(){
        return $this->hasMany('App\Comment')->orderBy('id', 'desc');
    }
}
