<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Http\Resources\Brand as BrandResource;
use App\Http\Resources\BankAccount as BankAccountResource;
use App\Http\Resources\BankAccountTransaction as BankAccountTransactionResource;
use App\Http\Resources\Budget as BudgetResource;
use App\Http\Resources\BudgetLimit as BudgetLimitResource;
use App\Http\Resources\BudgetRequest as BudgetRequestResource;
use App\Http\Resources\BudgetRequestCategory as BudgetRequestCategoryResource;
use App\Http\Resources\BudgetDispatch as BudgetDispatchResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Department as DepartmentResource;
use App\Http\Resources\Designation as DesignationResource;
use App\Http\Resources\Expense as ExpenseResource;
use App\Http\Resources\ExpenseCategory as ExpenseCategoryResource;
use App\Http\Resources\FiscalYear as FiscalYearResource;
use App\Http\Resources\Item as ItemResource;
use App\Http\Resources\ItemUser as ItemUserResource;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductAttribute as ProductAttributeResource;
use App\Http\Resources\ProductAttributeGroup as ProductAttributeGroupResource;
use App\Http\Resources\ProductVariant as ProductVariantResource;
use App\Http\Resources\Purchase as PurchaseResource;
use App\Http\Resources\PurchaseProduct as PurchaseProductResource;
use App\Http\Resources\Quotation as QuotationResource;
use App\Http\Resources\QuotationProduct as QuotationProductResource;
use App\Http\Resources\Signature as SignatureResource;
use App\Http\Resources\SignatureUseDepartment as SignatureUseDepartmentResource;
use App\Http\Resources\Tax as TaxResource;
use App\Http\Resources\Unit as UnitResource;
use App\Http\Resources\UnitCategory as UnitCategoryResource;
use App\Http\Resources\Vendor as VendorResource;
use App\Models\BankAccount;
use App\Models\BankAccountTransaction;
use App\Models\Brand;
use App\Models\Budget;
use App\Models\BudgetDispatch;
use App\Models\BudgetLimit;
use App\Models\BudgetRequest;
use App\Models\BudgetRequestCategory;
use App\Models\Category;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\FiscalYear;
use App\Models\Item;
use App\Models\ItemUser;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeGroup;
use App\Models\ProductVariant;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use App\Models\Quotation;
use App\Models\QuotationProduct;
use App\Models\Signature;
use App\Models\SignatureUseDepartment;
use App\Models\Tax;
use App\Models\Unit;
use App\Models\UnitCategory;
use App\Models\User;
use App\Models\Vendor;

class ListController extends Controller
{
    public function brandList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = BrandResource::collection(Brand::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function bankAccountList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = BankAccountResource::collection(BankAccount::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function bankAccountTransactionList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = BankAccountTransactionResource::collection(BankAccountTransaction::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function budgetList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = BudgetResource::collection(Budget::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function budgetLimitList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = BudgetLimitResource::collection(BudgetLimit::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function budgetRequestList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = BudgetRequestResource::collection(BudgetRequest::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function budgetRequestCategoryList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = BudgetRequestCategoryResource::collection(BudgetRequestCategory::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function budgetDispatchList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = BudgetDispatchResource::collection(BudgetDispatch::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function categoryList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = CategoryResource::collection(Category::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function departmentList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = DepartmentResource::collection(Department::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function designationList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = DesignationResource::collection(Designation::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function expenseList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = ExpenseResource::collection(Expense::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function expenseCategoryList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = ExpenseCategoryResource::collection(ExpenseCategory::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function fiscalYearList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = FiscalYearResource::collection(FiscalYear::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function itemList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = ItemResource::collection(Item::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function itemUserList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = ItemUserResource::collection(ItemUser::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function productList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = ProductResource::collection(Product::where('is_active', 1)->get());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function productAttributeList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = ProductAttributeResource::collection(ProductAttribute::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function productAttributeGroupList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = ProductAttributeGroupResource::collection(ProductAttributeGroup::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function productVariantList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = ProductVariantResource::collection(ProductVariant::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function purchaseList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = PurchaseResource::collection(Purchase::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function purchaseProductList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = PurchaseProductResource::collection(PurchaseProduct::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function quotationList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = QuotationResource::collection(Quotation::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function quotationProductList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = QuotationProductResource::collection(QuotationProduct::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function signatureList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = SignatureResource::collection(Signature::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function signatureUseDepartmentList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = SignatureUseDepartmentResource::collection(SignatureUseDepartment::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function taxList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = TaxResource::collection(Tax::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function unitList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = UnitResource::collection(Unit::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function unitCategoryList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = UnitCategoryResource::collection(UnitCategory::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function userList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = AuthResource::collection(User::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }

    public function vendorList()
    {
        $data['success'] = true;
        $data['message'] = '';
        $data['data'] = [];
        try {
            $data['data'] = VendorResource::collection(Vendor::all());
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['message'] = 'Error occurred.';
        }
        return $data;
    }
}
