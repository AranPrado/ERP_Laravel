<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = new User();
        $user->name = 'Aran Prado';
        $user->email = 'aran@gmail.com';
        $user->password = Hash::make('123456789');
        $user->is_admin = true;
        
        $user->save();

    }
}
