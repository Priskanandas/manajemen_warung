<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    public function run()
    {
        // Buat atau ambil role Admin
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Assign semua permission ke role Admin (jika ada)
        $permissions = Permission::pluck('name')->toArray();
        $adminRole->syncPermissions($permissions);

        // Buat atau ambil user admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('admin123'),
            ]
        );
        $admin->assignRole($adminRole);

        // Buat atau ambil user Nanda
        $nanda = User::firstOrCreate(
            ['email' => 'nanda@gmail.com'],
            [
                'name' => 'nanda',
                'password' => bcrypt('nanda123'),
            ]
        );
        $nanda->assignRole($adminRole); // Jika Nanda memang admin juga
        //$nanda->assignRole($userRole);
    }
}
