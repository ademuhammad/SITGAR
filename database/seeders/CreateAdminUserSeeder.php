<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Buat pengguna dengan detail Kepala Dinas (Super Admin)
        $superAdmin = User::create([
            'name' => 'Kepala Dinas',
            'email' => 'kepaladinas@mail.com',
            'password' => bcrypt('kepdinas123'),

        ]);

        // Buat peran Super Admin
        $superAdminRole = Role::create(['name' => 'Super Admin']);

        // Ambil semua izin yang ada
        $permissions = Permission::all();

        // Tetapkan semua izin ke peran Super Admin
        $superAdminRole->syncPermissions($permissions);

        // Tetapkan peran Super Admin ke pengguna Kepala Dinas
        $superAdmin->assignRole($superAdminRole);

        // Buat pengguna baru dengan peran OPD Admin
        $opdAdmin = User::create([
            'name' => 'OPD Admin',
            'email' => 'opdadmin@mail.com',
            'password' => bcrypt('opdadmin123'),
            'opd_id' => 1 // Sesuaikan dengan ID OPD yang terkait
        ]);

        // Buat peran OPD Admin
        $opdAdminRole = Role::create(['name' => 'OPD Admin']);

        // Tetapkan izin yang sesuai untuk OPD Admin
        $opdPermissions = [
            'dashboard-list',
            'opd-list',
            'opd-create',
            'opd-edit',
            'opd-delete',

            'pembayaran-list',
            'pembayaran-create',
            'pembayaran-edit',
            'pembayaran-delete',
            'pembayaran-download',

            'temuan-list',
            'temuan-create',
            'temuan-edit',
            'temuan-delete',

            'data-list',
            'data-create',
            'data-edit',
            'data-delete',

            'user-edit',

            // Tambahkan izin lain yang diperlukan
        ];

        foreach ($opdPermissions as $permission) {
            $permission = Permission::firstOrCreate(['name' => $permission]);
            $opdAdminRole->givePermissionTo($permission);
        }

        // Tetapkan peran OPD Admin ke pengguna OPD Admin
        $opdAdmin->assignRole($opdAdminRole);
    }
}
