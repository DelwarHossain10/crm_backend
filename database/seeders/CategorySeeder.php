<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'category_name' => 'Cattle Product',
            'category_type_id' => 1,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'category_name' => 'Poultry Diseases',
            'category_type_id' => 2,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
