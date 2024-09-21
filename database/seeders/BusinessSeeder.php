<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Business::create([
            'business_name' => 'Animal Health',
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
