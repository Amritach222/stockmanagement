<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class VendorRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'vendors.products',
            'guard_name' => "api"
        ]);

        $vendor = Role::create([
            'name' => 'Vendor',
            'guard_name' => 'api'
        ]);
        $vendor->givePermissionTo('vendors.products');

        $user = new User([
            'name' => 'Vendor',
            'username' => 'vendor',
            'email' => 'vendor@rkdholdings.com',
            'password' => bcrypt('Vendor@123'),
            'is_active'=>1
        ]);
        $user->save();
        $user->assignRole('Vendor');
    }
}
