<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $users = [
            [
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'nama'     => 'Administrator',
                'role'     => 'admin',
            ],
            [
                'username' => 'user',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'nama'     => 'User Biasa',
                'role'     => 'user',
            ],
        ];

        foreach ($users as $user) {
            // Skip if username already exists
            if (!$userModel->where('username', $user['username'])->first()) {
                $userModel->insert($user);
            }
        }
    }
}
