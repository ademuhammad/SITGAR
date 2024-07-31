<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// Seeder untuk menambahkan role dan izin baru
class CreatePaymentValidatorRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat peran Payment Validator
        $paymentValidatorRole = Role::create(['name' => 'Payment Validator']);

        // Tambahkan izin untuk memvalidasi pembayaran
        $permissions = [
            'validate-payment', // Izin untuk memvalidasi pembayaran
            'user-edit',
            'show-lhp',

        ];

        foreach ($permissions as $permission) {
            $permission = Permission::firstOrCreate(['name' => $permission]);
            $paymentValidatorRole->givePermissionTo($permission);
        }

        // Buat pengguna baru dengan peran Payment Validator (Opsional)
        $paymentValidator = User::create([
            'name' => 'Payment Validator',
            'email' => 'validator@mail.com',
            'password' => bcrypt('validator123'),
        ]);

        $paymentValidator->assignRole($paymentValidatorRole);
    }
}
