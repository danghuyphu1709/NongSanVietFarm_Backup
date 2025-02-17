<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $users = User::all();
        foreach ($users as $user) {
            for ($i = 0; $i < 30; $i++) {
                $beforeTotalAmount = 0;

                $order = Order::create([
                    'user_id' => $user->id,
                    'voucher_id' => rand(1, 15),
                    'address' => $faker->address,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'payment_method' => rand(0, 1),
                    'note' => $faker->sentence(),
                    'status' => 0,
                    'order_code' => strtoupper($faker->regexify('[A-Z]{4}[0-9]{4}')),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Create 1-5 order details for each order
                $orderDetailsCount = rand(2, 10);
                $products = Product::inRandomOrder()->take($orderDetailsCount)->get();
                foreach ($products as $product) {
                    $quantity = $faker->numberBetween(1, 5);
                    $beforeTotalAmount += $product->price_sale * $quantity;

                    DB::table('order_details')->insert([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->image,
                        'price_regular' => $product->price_regular,
                        'price_sale' => $product->price_sale,
                        'quantity' => $quantity,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                
                $shipping = $faker->randomFloat(4, 10000, 50000);
                $afterTotalAmount = $beforeTotalAmount + $shipping;

                // Update order with calculated amounts
                $order->before_total_amount = $beforeTotalAmount;
                $order->shipping = $shipping;
                $order->after_total_amount = $afterTotalAmount;
                $order->save();

                // Create order history
                DB::table('order_histories')->insert([
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}