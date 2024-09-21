<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubCategory::create([
            'sub_category_name' => 'Antibiotic',
            'category_id' => 1,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SubCategory::create([
            'sub_category_name' => 'Anthelmintic',
            'category_id' => 1,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SubCategory::create([
            'sub_category_name' => 'Antihistaminic',
            'category_id' => 1,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        SubCategory::create([
            'sub_category_name' => 'Bacterial',
            'category_id' => 2,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SubCategory::create([
            'sub_category_name' => 'Viral',
            'category_id' => 2,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        SubCategory::create([
            'sub_category_name' => 'Fungal',
            'category_id' => 2,
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
