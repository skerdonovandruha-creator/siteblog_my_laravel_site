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
            ['email' => 'user@newshub.local'],
            [
                'name' => 'user',
                'password' => '123',
                'is_admin' => false,
            ]
        );
    }
}
