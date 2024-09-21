<?php

namespace Database\Seeders;

use App\Models\CategoryType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryType::create([
            'category_type_name' => 'Product',
            'business_id' => 1,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        CategoryType::create([
            'category_type_name' => 'Diseases',
            'business_id' => 1,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
