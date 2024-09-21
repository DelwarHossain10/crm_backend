<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'product_name' => 'Acicef 3 Injection',
            'category_id' => 1,
            'sub_category_id' => 1,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Product::create([
            'product_name' => 'Uni-Flo 30 Injection',
            'category_id' => 1,
            'sub_category_id' => 1,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
