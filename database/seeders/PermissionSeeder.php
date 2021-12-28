<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
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
            $this->createAutoAllPermissions('users', $guard);
            $this->createAutoAllPermissions('designations', $guard);
            $this->createAutoAllPermissions('departments', $guard);
            $this->createAutoAllPermissions('expenses', $guard);
            $this->createAutoAllPermissions('expenseCategories', $guard);
            $this->createAutoAllPermissions('bankAccounts', $guard);
            $this->createAutoAllPermissions('bankAccountTransactions', $guard);
            $this->createAutoAllPermissions('transfers', $guard);
            $this->createAutoAllPermissions('attributeGroups', $guard);
            $this->createAutoAllPermissions('attributes', $guard);
            $this->createAutoAllPermissions('products', $guard);
            $this->createAutoAllPermissions('items', $guard);
            $this->createAutoAllPermissions('productVariants', $guard);
            $this->createAutoAllPermissions('productVariantAttributes', $guard);
            $this->createAutoAllPermissions('quotations', $guard);
            $this->createAutoAllPermissions('quotationProducts', $guard);
            $this->createAutoAllPermissions('purchases', $guard);
            $this->createAutoAllPermissions('purchaseProducts', $guard);
            $this->createAutoAllPermissions('vendors', $guard);
            $this->createAutoAllPermissions('returnProducts', $guard);
            $this->createAutoAllPermissions('consumes', $guard);
            $this->createAutoAllPermissions('unusedProducts', $guard);
            $this->createAutoAllPermissions('resetPasswordRequests', $guard);
            $this->createAutoAllPermissions('logs', $guard);
            $this->createAutoAllPermissions('brands', $guard);
            $this->createAutoAllPermissions('categories', $guard);
            $this->createAutoAllPermissions('units', $guard);
            $this->createAutoAllPermissions('unitCategories', $guard);
            $this->createAutoAllPermissions('taxes', $guard);
            $this->createAutoAllPermissions('signatures', $guard);
            $this->createAutoAllPermissions('signatureUseDepartments', $guard);
            $this->createAutoAllPermissions('fiscalYears', $guard);
            $this->createAutoAllPermissions('budgets', $guard);
            $this->createAutoAllPermissions('budgetRequests', $guard);
            $this->createAutoAllPermissions('budgetExtends', $guard);
            $this->createAutoAllPermissions('budgetLimits', $guard);
            $this->createAutoAllPermissions('freezeBudgets', $guard);
            $this->createAutoAllPermissions('settings', $guard);
            $this->createAutoAllPermissions('mailSettings', $guard);
            $this->createAutoAllPermissions('smsSettings', $guard);
            $this->createAutoAllPermissions('mailTemplates', $guard);
            $this->createAutoAllPermissions('budgetDispatches', $guard);
            $this->createAutoAllPermissions('budgetRequestCategories', $guard);
            Permission::create([
                'name' => 'roles',
                'guard_name' => $guard
            ]);
            Permission::create([
                'name' => 'permissions',
                'guard_name' => $guard
            ]);
        }
    }

    function createAutoAllPermissions($permission, $guard)
    {
        Permission::create([
            'name' => $permission,
            'guard_name' => $guard
        ]);
        Permission::create([
            'name' => $permission . '.show',
            'guard_name' => $guard
        ]);
        Permission::create([
            'name' => $permission . '.create',
            'guard_name' => $guard
        ]);
        Permission::create([
            'name' => $permission . '.edit',
            'guard_name' => $guard
        ]);
        Permission::create([
            'name' => $permission . '.delete',
            'guard_name' => $guard
        ]);
    }
}
