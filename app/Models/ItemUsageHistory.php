<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemUsageHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_user_id', 
        'item_id',
        'restaurant_id',
        'quantity',
        'buyer_user_id',
    ];

    public function sellerUser()
    {
        return $this->belongsTo(User::class);
    }

    public function buyerUser()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
