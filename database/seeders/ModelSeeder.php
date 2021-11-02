<?php

namespace Database\Seeders;

use App\Helpers\CodeGenerator;
use App\Models\BankAccount;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\FiscalYear;
use App\Models\Item;
use App\Models\ItemAttribute;
use App\Models\ItemAttributeGroup;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itemC = new Category([
            'name' => 'Stationary'
        ]);
        $itemC->save();

        $itemC = new Category([
            'name' => 'Furniture'
        ]);
        $itemC->save();

        $itemB = new Brand([
            'name' => 'Doms'
        ]);
        $itemB->save();

        $itemB = new Brand([
            'name' => 'IKEA'
        ]);
        $itemB->save();

        $itemU = new Unit([
            'name' => 'Kilogram',
            'short_code' => 'Kg'
        ]);
        $itemU->save();

        $itemU = new Unit([
            'name' => 'Meter',
            'short_code' => 'm'
        ]);
        $itemU->save();

        $itemT = new Tax([
            'name' => 'Service',
            'value' => 10
        ]);
        $itemT->save();

        $itemAG1 = new ItemAttributeGroup([
            'name' => 'Size'
        ]);
        $itemAG1->save();

        $itemAG2 = new ItemAttributeGroup([
            'name' => 'Color'
        ]);
        $itemAG2->save();

        $item = new ItemAttribute([
            'name' => 'S',
            'attribute_group_id' => $itemAG1->id
        ]);
        $item->save();

        $item = new ItemAttribute([
            'name' => 'Red',
            'attribute_group_id' => $itemAG2->id
        ]);
        $item->save();

        $item = new Department([
            'name' => 'Finance'
        ]);
        $item->save();

        $item = new Department([
            'name' => 'IT'
        ]);
        $item->save();

        $item = new Department([
            'name' => 'HR'
        ]);
        $item->save();

        $item = new Designation([
            'name' => 'CEO',
            'level' => 1
        ]);
        $item->save();

        $item = new Designation([
            'name' => 'Director',
            'level' => 2
        ]);
        $item->save();

        $item = new Designation([
            'name' => 'Manager',
            'level' => 3
        ]);
        $item->save();

        $item = new FiscalYear([
            'from' => '2020-7-14',
            'to' => '2021-7-13'
        ]);
        $item->save();

        $itemP = new Product([
            'name' => 'Sofa',
            'brand_id' => $itemB->id,
            'category_id' => $itemC->id,
        ]);
        $itemP->code = CodeGenerator::code();
        $itemP->save();

        $item = new Item([
            'name' => 'Sofa',
            'brand_id' => $itemB->id,
            'stock' => 50,
            'alert_stock' => 5,
            'product_id' => $itemP->id,
        ]);
        $item->code = CodeGenerator::code();
        $item->save();

        $item = new ExpenseCategory([
            'name' => 'Maintenance'
        ]);
        $item->save();

        $item = new ExpenseCategory([
            'name' => 'Service'
        ]);
        $item->save();

        $item = new Vendor([
            'name' => 'Joshep Ruth',
            'company_name' => 'JH Company',
            'vat_no' => '1234567890',
            'email' => 'joshep@gmail.com',
            'landline' => '061516277',
            'mobile' => '9800000000',
            'category_id' => $itemC->id
        ]);
        $item->save();

        $item = new BankAccount([
            'bank_name' => 'Nepal SBI Bank Ltd.',
            'account_no'=>'102293009490',
            'account_name'=>'RKD Holding',
            'total_balance'=>3500000,
            'current_balance'=>3300000,
            'branch'=>'New Road',
        ]);
        $item->save();
    }
}
