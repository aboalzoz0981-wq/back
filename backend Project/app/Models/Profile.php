<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];
    function user(){
        return $this->belongsTo(User::class);
    }
    public function images(){
    return $this->morphMany(image::class,'imageable');
   }
}
