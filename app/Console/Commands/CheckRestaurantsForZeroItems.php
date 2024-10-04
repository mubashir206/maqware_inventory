<?php

namespace App\Console\Commands;

use App\Mail\ZeroItems;
use App\Models\Item;
use Illuminate\Console\Command;
use App\Models\Restaurant;
use App\Models\ResturantItem;
use Illuminate\Support\Facades\Mail;

class CheckRestaurantsForZeroItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zeroitem:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email to restaurants that have zero items in their inventory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $restaurants = Restaurant::all();

        foreach ($restaurants as $restaurant) {
            $totalQuantity = Item::where('restaurant_id', $restaurant->id)
                ->sum('quantity') ?? 0;
            
            $intTotalQuantity = intval($totalQuantity);
        
            if ($intTotalQuantity === 0) {
                Mail::to($restaurant->email)->send(new ZeroItems($restaurant));
                $this->info('Email sent to: ' . $restaurant->email);
            } else {
                $this->info('Restaurant ' . $restaurant->name . ' has a total quantity of ' . $intTotalQuantity . ' items.');
            }
        
        }
    }
}
