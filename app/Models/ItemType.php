<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    public function item()
    {
        return $this->hasMany(Item::class);
    }

    public function itemHistory()
    {
        return $this->hasMany(ItemHistory::class);
    }
}
