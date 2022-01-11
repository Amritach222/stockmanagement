<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
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

//        $values[]

        $user = new User([
            'name' => 'Vendor',
            'username' => 'vendor',
            'email' => 'vendor@rkdholdings.com',
            'password' => bcrypt('Vendor@123'),
            'is_active' => 1
        ]);
        $user->save();

        $item = new Vendor([
            'name' => 'Joshep Ruth',
            'company_name' => 'JH Company',
            'vat_no' => '1234567890',
            'email' => 'joshep@gmail.com',
            'landline' => '061516277',
            'mobile' => '9800000000',
            'category_id' => 1,
            'user_id' => $user->id
        ]);
        $item->save();
        $user->assignRole('Vendor');
    }
}
