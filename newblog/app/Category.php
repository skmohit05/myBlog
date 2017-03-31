<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // need to connect model with table
    protected $table = 'categories';

    public function posts(){
      return $this->hasMany('App\Post');   //Category has many post
    }
}
