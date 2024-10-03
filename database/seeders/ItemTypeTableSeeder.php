<?php

namespace Database\Seeders;

use App\Models\ItemType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      ItemType::create(['name' => 'food']); 
      ItemType::create(['name' => 'drinks']); 

    }
}
