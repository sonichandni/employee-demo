<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'is_admin' => 1,
                'password' => Hash::make('Admin@123'),
            ],
            [
                'name' => 'User',
                'email' => 'user@user.com',
                'is_admin' => 0,
                'password' => Hash::make('User@123'),
            ],
        ];

        User::insert($users);

    }
}
