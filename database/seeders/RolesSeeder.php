<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $guards = ['api', 'web'];

        foreach ($guards as $guard) {
            $superAdmin = Role::create([
                'name' => 'Super Admin',
                'guard_name' => $guard
            ]);
            $permissions = Permission::where('guard_name', $guard)->get();
            $superAdmin->givePermissionTo($permissions);

            $admin = Role::create([
                'name' => 'Admin',
                'guard_name' => $guard
            ]);
            $permissions = Permission::where('guard_name', $guard)->where('name', '!=', 'roles')->where('name', '!=', 'permissions')->get();
            $admin->givePermissionTo($permissions);

            $director = Role::create([
                'name' => 'Director',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($director, 'bankAccounts');
            $this->giveAutoAllPermissions($director, 'bankAccountTransactions');
            $this->giveAutoAllPermissions($director, 'budgets');
            $this->giveAutoAllPermissions($director, 'budgetLimits');
            $this->giveAutoAllPermissions($director, 'budgetExtends');
            $this->giveAutoAllPermissions($director, 'freezeBudgets');
            $this->giveAutoAllPermissions($director, 'expenses');
            $this->giveAutoAllPermissions($director, 'consumes');
            $this->giveAutoAllPermissions($director, 'returnProducts');
            $this->giveAutoAllPermissions($director, 'purchases');
            $this->giveAutoAllPermissions($director, 'purchaseProducts');
            $this->giveAutoAllPermissions($director, 'purchaseOrders');
            $this->giveAutoAllPermissions($director, 'purchaseOrderProducts');
            $this->giveAutoAllPermissions($director, 'purchaseProductsApprovalAdmin');
            $this->giveAutoAllPermissions($director, 'purchaseProductsApprovalDepartmentHead');
            $this->giveAutoAllPermissions($director, 'quotations');
            $this->giveAutoAllPermissions($director, 'quotationProducts');
            $this->giveAutoAllPermissions($director, 'transfers');
            $this->giveAutoAllPermissions($director, 'users');
            $this->giveAutoAllPermissions($director, 'unusedProducts');
            $this->giveAutoAllPermissions($director, 'payments');
            $this->giveAutoAllPermissions($director, 'invoices');
            $director->givePermissionTo('settings');

            $financeDirector = Role::create([
                'name' => 'Finance Director',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($financeDirector, 'bankAccounts');
            $this->giveAutoAllPermissions($financeDirector, 'bankAccountTransactions');
            $this->giveAutoAllPermissions($financeDirector, 'budgets');
            $this->giveAutoAllPermissions($financeDirector, 'budgetLimits');
            $this->giveAutoAllPermissions($financeDirector, 'budgetExtends');
            $this->giveAutoAllPermissions($financeDirector, 'freezeBudgets');
            $this->giveAutoAllPermissions($financeDirector, 'expenseCategories');
            $this->giveAutoAllPermissions($financeDirector, 'expenses');
            $this->giveAutoAllPermissions($director, 'purchaseOrders');
            $this->giveAutoAllPermissions($director, 'purchaseOrderProducts');
            $this->giveAutoAllPermissions($director, 'payments');
            $this->giveAutoAllPermissions($director, 'invoices');
            $financeDirector->givePermissionTo('budgetRequests.edit');
            $financeDirector->givePermissionTo('budgetRequests');
            $financeDirector->givePermissionTo('settings');

            $departmentHead = Role::create([
                'name' => 'Department Head',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($departmentHead, 'purchaseProductsApproval');
            $this->giveAutoAllPermissions($departmentHead, 'purchaseProductsApprovalDepartmentHead');
            $this->giveAutoAllPermissions($departmentHead, 'consumes');
            $this->giveAutoAllPermissions($departmentHead, 'returnProducts');
            $this->giveAutoAllPermissions($departmentHead, 'purchases');
            $this->giveAutoAllPermissions($departmentHead, 'purchaseProducts');
            $this->giveAutoAllPermissions($director, 'purchaseOrders');
            $this->giveAutoAllPermissions($director, 'purchaseOrderProducts');
            $this->giveAutoAllPermissions($departmentHead, 'quotations');
            $this->giveAutoAllPermissions($departmentHead, 'quotationProducts');
            $this->giveAutoAllPermissions($departmentHead, 'expenses');
            $this->giveAutoAllPermissions($departmentHead, 'transfers');
            $this->giveAutoAllPermissions($departmentHead, 'users');
            $this->giveAutoAllPermissions($departmentHead, 'budgets');
            $this->giveAutoAllPermissions($departmentHead, 'budgetRequests');
            $this->giveAutoAllPermissions($departmentHead, 'budgetExtends');
            $this->giveAutoAllPermissions($departmentHead, 'unusedProducts');
            $this->giveAutoAllPermissions($departmentHead, 'payments');
            $this->giveAutoAllPermissions($departmentHead, 'invoices');
            $departmentHead->givePermissionTo('freezeBudgets');
            $departmentHead->givePermissionTo('settings');
            $departmentHead->givePermissionTo('units');
            $departmentHead->givePermissionTo('products');
            $departmentHead->givePermissionTo('products.show');
            $departmentHead->givePermissionTo('productVariants');

            $staff = Role::create([
                'name' => 'Staff',
                'guard_name' => $guard
            ]);
            $permissions = Permission::where('guard_name', $guard)->where('name', '!=', 'roles')->where('name', '!=', 'permissions')->get();
            $staff->givePermissionTo($permissions);
//            $this->giveAutoAllPermissions($staff, 'categories');
//            $this->giveAutoAllPermissions($staff, 'items');
//            $this->giveAutoAllPermissions($staff, 'productVariants');
//            $this->giveAutoAllPermissions($staff, 'productVariantAttributes');
//            $this->giveAutoAllPermissions($staff, 'quotations');
//            $this->giveAutoAllPermissions($staff, 'quotationProducts');
//            $this->giveAutoAllPermissions($staff, 'unusedProducts');
//            $staff->givePermissionTo('units');
//            $staff->givePermissionTo('brands');
//            $staff->givePermissionTo('taxes');
//            $staff->givePermissionTo('products');
            $this->giveAutoAllPermissions($staff, 'categories');
            $this->giveAutoAllPermissions($staff, 'products');
            $this->giveAutoAllPermissions($staff, 'items');
            $staff->givePermissionTo('units');
            $this->giveAutoAllPermissions($staff, 'purchaseHistory');
            $this->giveAutoAllPermissions($staff, 'purchases');
            $this->giveAutoAllPermissions($staff, 'purchaseProducts');
            $this->giveAutoAllPermissions($staff, 'productVariants');
            $this->giveAutoAllPermissions($staff, 'productVariantAttributes');
            $this->giveAutoAllPermissions($staff, 'quotations');
            $this->giveAutoAllPermissions($staff, 'quotationProducts');
            $this->giveAutoAllPermissions($staff, 'unusedProducts');

            $storeKeeper = Role::create([
                'name' => 'Store Keeper',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($storeKeeper, 'brands');
            $this->giveAutoAllPermissions($storeKeeper, 'units');
            $this->giveAutoAllPermissions($storeKeeper, 'taxes');
            $this->giveAutoAllPermissions($storeKeeper, 'categories');
            $this->giveAutoAllPermissions($storeKeeper, 'attributeGroups');
            $this->giveAutoAllPermissions($storeKeeper, 'attributes');
            $this->giveAutoAllPermissions($storeKeeper, 'products');
            $this->giveAutoAllPermissions($storeKeeper, 'items');
            $this->giveAutoAllPermissions($storeKeeper, 'productVariants');
            $this->giveAutoAllPermissions($storeKeeper, 'productVariantAttributes');
            $this->giveAutoAllPermissions($storeKeeper, 'purchases');
            $this->giveAutoAllPermissions($storeKeeper, 'purchaseProducts');
            $this->giveAutoAllPermissions($director, 'purchaseOrders');
            $this->giveAutoAllPermissions($director, 'purchaseOrderProducts');
            $this->giveAutoAllPermissions($storeKeeper, 'quotations');
            $this->giveAutoAllPermissions($storeKeeper, 'quotationProducts');
            $this->giveAutoAllPermissions($storeKeeper, 'unusedProducts');
            $this->giveAutoAllPermissions($storeKeeper, 'transfers');
            $this->giveAutoAllPermissions($storeKeeper, 'returnProducts');
            $this->giveAutoAllPermissions($storeKeeper, 'payments');
            $this->giveAutoAllPermissions($storeKeeper, 'invoices');
            $this->giveAutoAllPermissions($storeKeeper, 'purchaseProductsApprovalStoreAdmin');
            $storeKeeper->givePermissionTo('vendors');
            $storeKeeper->givePermissionTo('vendors.show');
            $storeKeeper->givePermissionTo('settings');

            $storeManager = Role::create([
                'name' => 'Store Manager',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($storeManager, 'purchaseProductsApproval');
            $this->giveAutoAllPermissions($storeManager, 'purchaseProductsApprovalStoreAdmin');
            $this->giveAutoAllPermissions($storeManager, 'products');
            $this->giveAutoAllPermissions($storeManager, 'attributes');
            $this->giveAutoAllPermissions($storeManager, 'attributeGroups');
            $this->giveAutoAllPermissions($storeManager, 'productVariants');
            $this->giveAutoAllPermissions($storeManager, 'quotations');
            $this->giveAutoAllPermissions($storeManager, 'quotationProducts');
            $this->giveAutoAllPermissions($storeManager, 'purchases');
            $this->giveAutoAllPermissions($storeManager, 'purchaseProducts');
            $this->giveAutoAllPermissions($director, 'purchaseOrders');
            $this->giveAutoAllPermissions($director, 'purchaseOrderProducts');
            $this->giveAutoAllPermissions($storeManager, 'consumes');
            $this->giveAutoAllPermissions($storeManager, 'payments');
            $this->giveAutoAllPermissions($storeManager, 'invoices');
            $storeManager->givePermissionTo('settings');
            $this->giveAutoAllPermissions($storeManager, 'purchaseProductsApprovalAdmin');
            $storeManager->givePermissionTo('units');
            $storeManager->givePermissionTo('products');
            $storeManager->givePermissionTo('productVariants');

            $financeStaff = Role::create([
                'name' => 'Finance Staff',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($financeStaff, 'expenses');
            $this->giveAutoAllPermissions($financeStaff, 'purchaseOrders');
            $this->giveAutoAllPermissions($financeStaff, 'purchaseOrderProducts');
            $this->giveAutoAllPermissions($financeStaff, 'payments');
            $this->giveAutoAllPermissions($financeStaff, 'invoices');
            $financeStaff->givePermissionTo('settings');
        }
        $user = new User([
            'name' => 'Super Admin',
            'username' => 'superAdmin',
            'email' => 'superadmin@rkdholdings.com',
            'is_active' => 1,
            'password' => bcrypt('Secret@123'),
        ]);
        $user->save();
        $user->assignRole('Super Admin');

        $user = new User([
            'name' => 'Admin',
            'username' => 'admin1234',
            'email' => 'admin@rkdholdings.com',
            'is_active' => 1,
            'password' => bcrypt('Secret@123'),
        ]);
        $user->save();
        $user->assignRole('Admin');

        $user = new User([
            'name' => 'Store Keeper',
            'username' => 'storeKeeper',
            'email' => 'store.keeper@rkdholdings.com',
            'is_active' => 1,
            'password' => bcrypt('Secret@123'),
        ]);
        $user->save();
        $user->assignRole('Store Keeper');

        $user = new User([
            'name' => 'Store Manager',
            'username' => 'storeManager',
            'email' => 'store.manager@rkdholdings.com',
            'is_active' => 1,
            'password' => bcrypt('Secret@123'),
        ]);
        $user->save();
        $user->assignRole('Store Manager');

        $user = new User([
            'name' => 'Director',
            'username' => 'director',
            'email' => 'director@rkdholdings.com',
            'is_active' => 1,
            'password' => bcrypt('Secret@123'),
        ]);
        $user->save();
        $user->assignRole('Director');

        $user = new User([
            'name' => 'Finance Director',
            'username' => 'financeDirector',
            'email' => 'finance.director@rkdholdings.com',
            'is_active' => 1,
            'password' => bcrypt('Secret@123'),
        ]);
        $user->save();
        $user->assignRole('Finance Director');

        $user = new User([
            'name' => 'Staff one',
            'username' => 'staff1234',
            'email' => 'staff@rkdholdings.com',
            'is_active' => 1,
            'password' => bcrypt('Secret@123'),
            'department_id' => 1,
        ]);
        $user->save();
        $user->assignRole('Staff');

        $user = new User([
            'name' => 'Staff',
            'username' => 'staff5678',
            'email' => 'staff1@rkdholdings.com',
            'password' => bcrypt('Secret@123'),
            'department_id' => 2,
        ]);
        $user->save();
        $user->assignRole('Staff');

        $user = new User([
            'name' => 'Department Head',
            'username' => 'dhead1234',
            'email' => 'departmenthead@rkdholdings.com',
            'password' => bcrypt('Secret@123'),
            'department_id' => 1,
        ]);
        $user->save();
        $user->assignRole('Department Head');
    }

    public function giveAutoAllPermissions($role, $permissionName)
    {
        $role->givePermissionTo($permissionName);
        $role->givePermissionTo($permissionName . '.show');
        $role->givePermissionTo($permissionName . '.create');
        $role->givePermissionTo($permissionName . '.edit');
        $role->givePermissionTo($permissionName . '.delete');
    }
}
