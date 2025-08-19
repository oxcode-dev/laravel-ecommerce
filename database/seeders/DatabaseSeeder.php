<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Wishlist;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'ADMIN'
        ]);

        User::factory()->create([
            'name' => 'Test Vendor',
            'email' => 'vendor@example.com',
            'role' => 'VENDOR'
        ])->each(function ($user) {
            Product::factory()->count(10)->create([
                'user_id' => $user->id
            ]);
        });

        User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'role' => 'CUSTOMER'
        ])->each(function ($user) {
            Order::factory()->count(2)->create([ 'user_id' => $user->id, ])->each(function ($order) {
                OrderItem::factory()->count(random_int(1, 3))->create([
                    'order_id' => $order->id,
                ]);
            });
        });

        Category::factory(3)->create();
        Product::factory(10)->create();
        Order::factory(4)->create();
        Review::factory(4)->create();
        Wishlist::factory(4)->create();
        OrderItem::factory(4)->create();
        Address::factory(4)->create();
    }
}
