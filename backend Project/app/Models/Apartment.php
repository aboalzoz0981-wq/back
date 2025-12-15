<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory ;
    protected $guarded = [];

   public function favoriteUsers(){

    return $this->belongsToMany(User::class,'favorites');
   }
    
   public function reserveUser(){

        return $this->hasOne(User::class,'reservations');
}
}
