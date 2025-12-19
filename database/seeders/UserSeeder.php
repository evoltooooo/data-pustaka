<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create(['name' => 'admin', 'email' => 'admin@mail.com', 'status' => 'active', 'role' => 'admin', 'photo' => 'profile.png','password' => 'admin']);
        User::factory()->create(['name' => 'user1', 'email' => 'user1@mail.com', 'status' => 'active', 'role' => 'user', 'photo' => 'profile.png','password' => 'user1']);
    }
}
