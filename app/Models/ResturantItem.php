<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResturantItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'restaurant_id',
        'item_id'
    ];

    public function restaurnat(){
        return $this->belongsTo(Restaurant::class);
    }

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
