<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::create([
            'name' => 'Coca-Cola',
            'description' => 'Chilled soft drink',
            'quantity' => 10,
            'image' => 'path/2.jpg',
            'item_type_id' => 1,
            'restaurant_id' => 1, 
            'user_id' => 1, 
        ]);
        Item::create([
            'name' => 'French Fries',
            'description' => 'Crispy potato fries',
            'quantity' => 30,
            'image' => 'path/3.jpg',
            'item_type_id' => 2, 
            'restaurant_id' => 1, 
            'user_id' => 1, 
        ]);
    }
}
