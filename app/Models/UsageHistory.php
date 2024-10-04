<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageHistory extends Model
{
    use HasFactory;
    protected $table = 'usage_history';
    
    protected $fillable = [
        'user_id',
        'item_id',
        'restaurant_id',
        'quantity_used',
        'stock_before',
        'stock_after',
    ];
    public function user()
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
