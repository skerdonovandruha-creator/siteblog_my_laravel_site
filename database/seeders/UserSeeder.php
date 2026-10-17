<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@newshub.local'],
            [
                'name' => 'admin',
                'password' => 'admin', // хэшируется через cast 'hashed'
                'is_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'journalist@newshub.local'],
            [
                'name' => 'journalist',
                'password' => '123',
                'role' => 'journalist',
                'is_admin' => false,
            ]
        );


        User::updateOrCreate(
            ['email' => 'admin@newshub.local'],
            [
                'name' => 'admin',
                'password' => 'admin',
                'role' => 'admin',
                'is_admin' => true,
            ]
        );
    }
}
