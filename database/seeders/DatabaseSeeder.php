<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\User::create([
             'name' => 'Jeremi Herodian Abednigo',
             'email' => 'jeremi@email.com',
             'password' => Hash::make('mimin123'),
         ]);

         Product::factory(5)->create();
    }
}
