<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeGroupController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\BankAccountTransactionController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\BudgetExtendController;
use App\Http\Controllers\Admin\BudgetLimitController;
use App\Http\Controllers\Admin\BudgetRequestController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConsumeController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DesignationController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\FiscalYearController;
use App\Http\Controllers\Admin\FreezeBudgetController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ItemVariantAttributeController;
use App\Http\Controllers\Admin\ItemVariantController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\MailSettingController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfilePictureController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\PurchaseProductController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\QuotationProductController;
use App\Http\Controllers\Admin\ResetPasswordRequestController;
use App\Http\Controllers\Admin\ReturnProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SignatureController;
use App\Http\Controllers\Admin\SignatureUseDepartmentController;
use App\Http\Controllers\Admin\SmsSettingController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UnusedProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::resource('bankAccounts', BankAccountController::class);
    Route::resource('bankAccountTransactions', BankAccountTransactionController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('users', UserController::class);
    Route::resource('profilePictures', ProfilePictureController::class);
    Route::resource('products', ProductController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('expenseCategories', ExpenseCategoryController::class);
    Route::resource('files', FileController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('images', ImageController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('taxes', TaxController::class);
    Route::resource('designations', DesignationController::class);
    Route::resource('units', UnitController::class);
    Route::resource('activities', ActivityController::class);
    Route::resource('logs', LogController::class);
    Route::resource('attributeGroups', AttributeGroupController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('items', ItemController::class);
    Route::resource('itemVariants', ItemVariantController::class);
    Route::resource('itemVariantAttributes', ItemVariantAttributeController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('quotations', QuotationController::class);
    Route::resource('quotationProducts', QuotationProductController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('purchaseProducts', PurchaseProductController::class);
    Route::resource('consumes', ConsumeController::class);
    Route::resource('returnProducts', ReturnProductController::class);
    Route::resource('unusedProducts', UnusedProductController::class);
    Route::resource('transfers', TransferController::class);
    Route::resource('resetPasswordRequests', ResetPasswordRequestController::class);
    Route::resource('signatures', SignatureController::class);
    Route::resource('signatureUseDepartments', SignatureUseDepartmentController::class);
    Route::resource('fiscalYears', FiscalYearController::class);
    Route::resource('budgets', BudgetController::class);
    Route::resource('budgetRequests', BudgetRequestController::class);
    Route::resource('budgetExtends', BudgetExtendController::class);
    Route::resource('budgetLimits', BudgetLimitController::class);
    Route::resource('freezeBudgets', FreezeBudgetController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('mailSettings', MailSettingController::class);
    Route::resource('smsSettings', SmsSettingController::class);
});
