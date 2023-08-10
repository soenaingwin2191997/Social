<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'caption',
        'photo',
    ];

    public function likes(){
        return $this->hasMany('App\Models\Like');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
}
