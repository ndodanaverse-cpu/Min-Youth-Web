<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        foreach (UserRole::cases() as $role) {
            Role::firstOrCreate(['name' => $role->value]);
        }

        $users = [
            [
                'name' => 'Portal Administrator',
                'email' => 'admin@youth.gov.zw',
                'password' => 'Admin@2026!',
                'role' => UserRole::Admin,
            ],
            [
                'name' => 'Content Editor',
                'email' => 'editor@youth.gov.zw',
                'password' => 'Editor@2026!',
                'role' => UserRole::ContentEditor,
            ],
            [
                'name' => 'Talent Moyo',
                'email' => 'youth@youth.gov.zw',
                'phone' => '+263 712 345 678',
                'password' => 'Youth@2026!',
                'role' => null,
            ],
        ];

        foreach ($users as $data) {
            $role = $data['role'];
            unset($data['role']);

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'is_active' => true,
                    'activated_at' => now(),
                    'email_verified_at' => now(),
                ])
            );

            if ($role) {
                $user->syncRoles($role);
            }
        }
    }
}
