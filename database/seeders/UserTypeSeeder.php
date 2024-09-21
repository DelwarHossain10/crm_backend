<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserType::create([
            // 'id' => '1',
            'type_name' => 'VSO',
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        UserType::create([
            // 'id' => '2',
            'type_name' => 'Officer',
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        UserType::create([
            // 'id' => '3',
            'type_name' => 'Manager',
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
