<?php

namespace Database\Seeders;

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
            $admin = Role::create([
                'name' => 'Admin',
                'guard_name' => $guard
            ]);
            $permissions = Permission::where('guard_name', $guard)->get();
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
            $this->giveAutoAllPermissions($director, 'quotations');
            $this->giveAutoAllPermissions($director, 'quotationProducts');
            $this->giveAutoAllPermissions($director, 'transfers');
            $this->giveAutoAllPermissions($director, 'users');
            $this->giveAutoAllPermissions($director, 'unusedProducts');

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
            $financeDirector->givePermissionTo('budgetRequests.edit');
            $financeDirector->givePermissionTo('budgetRequests');

            $departmentHead = Role::create([
                'name' => 'Department Head',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($departmentHead, 'consumes');
            $this->giveAutoAllPermissions($departmentHead, 'returnProducts');
            $this->giveAutoAllPermissions($departmentHead, 'purchases');
            $this->giveAutoAllPermissions($departmentHead, 'purchaseProducts');
            $this->giveAutoAllPermissions($departmentHead, 'quotations');
            $this->giveAutoAllPermissions($departmentHead, 'quotationProducts');
            $this->giveAutoAllPermissions($departmentHead, 'expenses');
            $this->giveAutoAllPermissions($departmentHead, 'transfers');
            $this->giveAutoAllPermissions($departmentHead, 'users');
            $this->giveAutoAllPermissions($departmentHead, 'budgets');
            $this->giveAutoAllPermissions($departmentHead, 'budgetRequests');
            $this->giveAutoAllPermissions($departmentHead, 'budgetExtends');
            $this->giveAutoAllPermissions($departmentHead, 'unusedProducts');
            $departmentHead->givePermissionTo('freezeBudgets');

            $staff = Role::create([
                'name' => 'Staff',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($staff, 'categories');
            $this->giveAutoAllPermissions($staff, 'products');
            $this->giveAutoAllPermissions($staff, 'items');
            $this->giveAutoAllPermissions($staff, 'itemVariants');
            $this->giveAutoAllPermissions($staff, 'itemVariantAttributes');
            $this->giveAutoAllPermissions($staff, 'quotations', $guard);
            $this->giveAutoAllPermissions($staff, 'quotationProducts');
            $this->giveAutoAllPermissions($staff, 'unusedProducts');

            $storeKeeper = Role::create([
                'name' => 'Store Keeper',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($storeKeeper, 'brands');
            $this->giveAutoAllPermissions($storeKeeper, 'categories');
            $this->giveAutoAllPermissions($storeKeeper, 'attributeGroups');
            $this->giveAutoAllPermissions($storeKeeper, 'attributes');
            $this->giveAutoAllPermissions($storeKeeper, 'products');
            $this->giveAutoAllPermissions($storeKeeper, 'items');
            $this->giveAutoAllPermissions($storeKeeper, 'itemVariants');
            $this->giveAutoAllPermissions($storeKeeper, 'itemVariantAttributes');
            $this->giveAutoAllPermissions($storeKeeper, 'unusedProducts');
            $this->giveAutoAllPermissions($storeKeeper, 'transfers');
            $this->giveAutoAllPermissions($storeKeeper, 'returnProducts');
            $storeKeeper->givePermissionTo('quotations');

            $storeManager = Role::create([
                'name' => 'Store Manager',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($storeManager, 'products');
            $this->giveAutoAllPermissions($storeManager, 'consumes');
            $storeManager->givePermissionTo('quotations');

            $financeStaff = Role::create([
                'name' => 'Finance Staff',
                'guard_name' => $guard
            ]);
            $this->giveAutoAllPermissions($financeStaff, 'expenses');
        }
    }

    public function giveAutoAllPermissions($role, $permissionName)
    {
        $role->givePermissionTo($permissionName);
        $role->givePermissionTo($permissionName . '.create');
        $role->givePermissionTo($permissionName . '.edit');
        $role->givePermissionTo($permissionName . '.delete');
    }
}
