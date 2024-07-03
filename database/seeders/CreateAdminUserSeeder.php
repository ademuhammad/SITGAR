<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat pengguna dengan detail Kepala Dinas
        $user = User::create([
            'name' => 'Kepala Dinas',
            'email' => 'kepaladinas@mail.com',
            'password' => bcrypt('kepdinas123')
        ]);

        // Buat peran Super admin
        $role = Role::create(['name' => 'Super admin']);

        // Ambil semua izin yang ada
        $permissions = Permission::all();

        // Tetapkan semua izin ke peran Super admin
        $role->syncPermissions($permissions);

        // Tetapkan peran Super admin ke pengguna Kepala Dinas
        $user->assignRole($role);
    }
}
