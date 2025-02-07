<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        User::create([
            'name' => 'user_visitor',
            'email' => 'user_visitor@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 1,
        ]);
        User::create([
            'name' => 'user_author',
            'email' => 'user_author@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 2,
        ]);
        User::create([
            'name' => 'user_admin',
            'email' => 'user_admin@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 3,
        ]);

        for ($i = 0; $i < 17; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('password'),
                'role_id' => rand(1, 2),
            ]);
        }
    }
}
