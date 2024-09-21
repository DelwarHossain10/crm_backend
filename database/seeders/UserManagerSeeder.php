<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_manager')->insert([
            'user_id' => '123456',
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => Hash::make('123456'),
            'designation' => 'Executives',
            'mobile' => '017112233445',
            'user_type_id' => '1',
            'active' => 'Y',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
