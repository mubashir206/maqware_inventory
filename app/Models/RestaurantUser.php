<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantUser extends Model
{
   use HasFactory;

   protected $fillable = ['restaurant_id', 'user_id', 'is_manager'];

   
   public function user()
   {
       return $this->belongsTo(User::class);
   }
   
   public function restaurant()
   {
       return $this->belongsTo(Restaurant::class);
   }
}

