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
use App\Models\ProductAttribute;
use App\Models\ProductAttributeGroup;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\UnitCategory;
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

        $itemUC1 = new UnitCategory([
            'name' => 'Weight',
        ]);
        $itemUC1->save();

        $itemUC2 = new UnitCategory([
            'name' => 'Length',
        ]);
        $itemUC2->save();
        $itemUC3 = new UnitCategory([
            'name' => 'Count',
        ]);
        $itemUC3->save();

        $itemU = new Unit([
            'name' => 'Kilogram',
            'short_code' => 'Kg',
            'category_id' => $itemUC1->id,
            'type' => 'equal',
            'value' => '1',
        ]);
        $itemU->save();

        $itemU = new Unit([
            'name' => 'Kilometer',
            'short_code' => 'Km',
            'category_id' => $itemUC2->id,
            'type' => 'equal',
            'value' => '1',
        ]);
        $itemU->save();

        $itemU = new Unit([
            'name' => 'Pices',
            'short_code' => 'Pcs',
            'category_id' => $itemUC3->id,
            'type' => 'equal',
            'value' => '1',
        ]);
        $itemU->save();

        $itemT = new Tax([
            'name' => 'Service',
            'value' => 10
        ]);
        $itemT->save();

        $itemAG1 = new ProductAttributeGroup([
            'name' => 'Size'
        ]);
        $itemAG1->save();

        $itemAG2 = new ProductAttributeGroup([
            'name' => 'Color'
        ]);
        $itemAG2->save();

        $item = new ProductAttribute([
            'name' => 'S',
            'attribute_group_id' => $itemAG1->id
        ]);
        $item->save();

        $item = new ProductAttribute([
            'name' => 'M',
            'attribute_group_id' => $itemAG1->id
        ]);
        $item->save();

        $item = new ProductAttribute([
            'name' => 'L',
            'attribute_group_id' => $itemAG1->id
        ]);
        $item->save();

        $item = new ProductAttribute([
            'name' => 'Red',
            'attribute_group_id' => $itemAG2->id
        ]);
        $item->save();

        $item = new ProductAttribute([
            'name' => 'Black',
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
            'name' => '77/78',
            'from' => '2020-7-14',
            'to' => '2021-7-13'
        ]);
        $item->save();

        $itemP = new Product([
            'name' => 'Sofa',
            'brand_id' => $itemB->id,
            'category_id' => $itemC->id,
            'cost_price' => 1500,
            'stock' => 5,
            'type' => 'Serviceable'
        ]);
        $itemP->code = CodeGenerator::code();
        $itemP->save();

        $itemP = new Product([
            'name' => 'TV',
            'brand_id' => $itemB->id,
            'category_id' => $itemC->id,

            'cost_price' => 1500,
            'stock' => 5,
            'type' => 'Serviceable'
        ]);
        $itemP->code = CodeGenerator::code();
        $itemP->save();

        $item = new ExpenseCategory([
            'name' => 'Maintenance'
        ]);
        $item->save();

        $item = new ExpenseCategory([
            'name' => 'Service'
        ]);
        $item->save();

        $item = new BankAccount([
            'bank_name' => 'Nepal SBI Bank Ltd.',
            'account_no' => '102293009490',
            'account_name' => 'RKD Holding',
            'total_balance' => 3500000,
            'current_balance' => 3300000,
            'branch' => 'New Road',
        ]);
        $item->save();
    }
}
