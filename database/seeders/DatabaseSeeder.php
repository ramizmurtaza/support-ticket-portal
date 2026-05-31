<?php

namespace Database\Seeders;

use App\Models\System;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name'     => 'Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
            ]
        );

        System::updateOrCreate(
            ['system_id' => 'evexia'],
            [
                'name'      => 'Evexia HIS',
                'api_key'   => Str::random(40),
                'is_active' => true,
            ]
        );

        System::updateOrCreate(
            ['system_id' => 'jenan'],
            [
                'name'      => 'Jenan Portal',
                'api_key'   => Str::random(40),
                'is_active' => true,
            ]
        );
    }
}
