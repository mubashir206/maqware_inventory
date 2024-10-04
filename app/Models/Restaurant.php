<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address'
    ];

    public function restaurant_user()
    {
        return $this->hasMany(RestaurantUser::class);
    }

    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function restaurantItem()
    {
        return $this->hasMany(ResturantItem::class);
    }

    public function itemHistory()
    {
        return $this->hasMany(ItemHistory::class);
    }
}
