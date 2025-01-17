<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\User::factory(10)->create();

         DB::table('users')->insert([
             [
                 'role' => 'manager',
                 'name' => 'admin',
                 'email' => 'admin@admin.com',
                 'password' => bcrypt('12341234'),
             ],
             [
                 'role' => 'user',
                 'name' => 'user1',
                 'email' => 'user1@user.com',
                 'password' => bcrypt('12341234'),
             ],
             [
                 'role' => 'user',
                 'name' => 'user2',
                 'email' => 'user2@user.com',
                 'password' => bcrypt('12341234'),
             ],
         ]);
    }
}
