<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemHistory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    } 
    
    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
