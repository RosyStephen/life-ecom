<?php

namespace Database\Seeders;

use App\Models\Master\Category;
use App\Models\Products\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        $categories = Category::all();

        Product::factory(10)->create()->each(function ($product) use ($categories) {
            // Attach random categories to each product
            $product->categories()->attach($categories->random(rand(1, 3))->pluck('id'));
        });
    }
}
