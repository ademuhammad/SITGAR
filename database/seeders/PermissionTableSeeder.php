<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [

            'dashboard-list', //dashboard-list

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'opd-list',
            'opd-create',
            'opd-edit',
            'opd-delete',

            'status-list',
            'status-create',
            'status-edit',
            'status-delete',

            'tgr-list',
            'tgr-create',
            'tgr-edit',
            'tgr-delete',

            'pembayaran-list',
            'pembayaran-create',
            'pembayaran-edit',
            'pembayaran-delete',
            'pembayaran-download',

            'temuan-list',
            'temuan-create',
            'temuan-edit',
            'temuan-delete',

            'pegawai-list',
            'pegawai-create',
            'pegawai-edit',
            'pegawai-delete',

            'informasi-list',
            'informasi-create',
            'informasi-edit',
            'informasi-delete',

            'data-list',
            'data-create',
            'data-edit',
            'data-delete',

            'penyedia-list',
            'penyedia-create',
            'penyedia-edit',
            'penyedia-delete',
         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
