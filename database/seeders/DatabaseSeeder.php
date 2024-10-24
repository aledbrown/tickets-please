<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        \App\Models\Ticket::class::factory(100)
            ->recycle($users)
            ->create();

        \App\Models\User::create([
            'email' => 'aledb@mac.com',
            'password' => Hash::make('password'),
            'name' => 'The Manager',
            'is_manager' => true
        ]);

        \App\Models\User::create([
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'name' => 'The User',
            'is_manager' => true
        ]);
    }
}
