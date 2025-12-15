<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   protected $guarded = [];

   public function images(){
    return $this->morphMany(image::class,'imageable');
   }
}
