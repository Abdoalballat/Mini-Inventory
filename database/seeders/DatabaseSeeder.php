<?php

namespace Database\Seeders;

use App\Models\login;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        login::firstOrCreate(
            ['email' => 'Guestlikeadmin@gmail.com'],
            [
                'username' => 'Guest',
                'password' => Hash::make('Guest'),
                
            ]
        );
    }
    }

