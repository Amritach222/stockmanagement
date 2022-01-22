<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//User Auth
Route::post('register', [AuthController::class, 'registerUser']);
Route::post('login', [AuthController::class, 'loginUser']);

Route::post('vendor-login', [AuthController::class, 'loginVendor']);

Route::post('reset-password', [AuthController::class, 'resetUserPassword']);

Route::post('forgot-password', [AuthController::class, 'forgotUserPassword']);
Route::get('forgot-password/{code}', [AuthController::class, 'forgotUserPasswordCreate']);
Route::post('forgot-password-set', [AuthController::class, 'setForgotNewPassword']);

Route::group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
    Route::get('/', [AuthController::class, 'getUser']);
    Route::post('edit', [\App\Http\Controllers\UserController::class, 'editProfile']);
    Route::get('profile-picture', [\App\Http\Controllers\UserController::class, 'getProfilePic']);
    Route::get('logout', [AuthController::class, 'logoutUser']);
});

Route::group(['middleware' => 'auth:api'], function () {

    Route::apiResource('users', \App\Http\Controllers\Api\UserController::class);
    Route::post('create-variants', [\App\Http\Controllers\Api\ProductController::class, 'createVariants']);
    Route::get('logs', [\App\Http\Controllers\Api\logController::class, 'index']);
    Route::get('get-permissions', [\App\Http\Controllers\Api\PermissionController::class, 'getPermissions']);
    Route::post('assign-role/{id}', [\App\Http\Controllers\Api\PermissionController::class, 'assignRole']);

    Route::group(['prefix' => '/setting'], function () {
        Route::apiResource('brands', \App\Http\Controllers\Api\BrandController::class);
        Route::post('brands/{id}', [\App\Http\Controllers\Api\BrandController::class, 'update']);
        Route::apiResource('units', \App\Http\Controllers\Api\UnitController::class);
        Route::post('units/{id}', [\App\Http\Controllers\Api\UnitController::class, 'update']);
        Route::apiResource('unitCategories', \App\Http\Controllers\Api\UnitCategoryController::class);
        Route::post('unitCategories/{id}', [\App\Http\Controllers\Api\UnitCategoryController::class, 'update']);
        Route::apiResource('taxes', \App\Http\Controllers\Api\TaxController::class);
        Route::post('taxes/{id}', [\App\Http\Controllers\Api\TaxController::class, 'update']);


        Route::apiResource('settings', \App\Http\Controllers\Api\SettingController::class);
        Route::post('settings/{id}', [\App\Http\Controllers\Api\SettingController::class, 'update']);

        Route::get('all-setting-info', [\App\Http\Controllers\DashboardController::class, 'allSettingInfo']);


        Route::apiResource('mailSettings', \App\Http\Controllers\Api\MailSettingController::class);
        Route::post('mailSettings/{id}', [\App\Http\Controllers\Api\MailSettingController::class, 'update']);
        Route::apiResource('smsSettings', \App\Http\Controllers\Api\SmsSettingController::class);
        Route::post('smsSettings/{id}', [\App\Http\Controllers\Api\SmsSettingController::class, 'update']);
        Route::apiResource('mailTemplates', \App\Http\Controllers\Api\MailTemplateController::class);
        Route::post('mailTemplates/{id}', [\App\Http\Controllers\Api\MailTemplateController::class, 'update']);
        Route::apiResource('logs', \App\Http\Controllers\Api\LogController::class);
        Route::apiResource('departments', \App\Http\Controllers\Api\DepartmentController::class);
        Route::post('departments/{id}', [\App\Http\Controllers\Api\DepartmentController::class, 'update']);
        Route::apiResource('designations', \App\Http\Controllers\Api\DesignationController::class);
        Route::post('designations/{id}', [\App\Http\Controllers\Api\DesignationController::class, 'update']);
        Route::apiResource('fiscalYears', \App\Http\Controllers\Api\FiscalYearController::class);
        Route::post('fiscalYears/{id}', [\App\Http\Controllers\Api\FiscalYearController::class, 'update']);
        Route::get('select-fiscal-year', [\App\Http\Controllers\Api\FiscalYearController::class, 'selectFiscalYear']);

        Route::group(['prefix' => '/signature'], function () {
            Route::apiResource('signatures', \App\Http\Controllers\Api\SignatureController::class);
            Route::post('signatures/{id}', [\App\Http\Controllers\Api\SignatureController::class, 'update']);
            Route::apiResource('signatureUseDepartments', \App\Http\Controllers\Api\SignatureUseDepartmentController::class);
            Route::post('signatureUseDepartments/{id}', [\App\Http\Controllers\Api\SignatureUseDepartmentController::class, 'update']);
        });
    });


    Route::group(['prefix' => '/product'], function () {
        Route::apiResource('products', \App\Http\Controllers\Api\ProductController::class);
        Route::post('products/{id}', [\App\Http\Controllers\Api\ProductController::class, 'update']);
        Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class);
        Route::post('categories/{id}', [\App\Http\Controllers\Api\CategoryController::class, 'update']);
        Route::apiResource('productVariants', \App\Http\Controllers\Api\ProductVariantController::class);
        Route::post('productVariants/{id}', [\App\Http\Controllers\Api\ProductVariantController::class, 'update']);
        Route::apiResource('productAttributeGroups', \App\Http\Controllers\Api\ProductAttributeGroupController::class);
        Route::post('productAttributeGroups/{id}', [\App\Http\Controllers\Api\ProductAttributeGroupController::class, 'update']);
        Route::apiResource('productAttributes', \App\Http\Controllers\Api\ProductAttributeController::class);
        Route::post('productAttributes/{id}', [\App\Http\Controllers\Api\ProductAttributeController::class, 'update']);

        Route::group(['prefix' => '/item'], function () {
            Route::apiResource('items', \App\Http\Controllers\Api\ItemController::class);
            Route::post('items/{id}', [\App\Http\Controllers\Api\ItemController::class, 'update']);
            Route::apiResource('itemUsers', \App\Http\Controllers\Api\ItemUserController::class);
            Route::post('itemUsers/{id}', [\App\Http\Controllers\Api\ItemUserController::class, 'update']);
            Route::get('getItemUsers/{id}', [\App\Http\Controllers\Api\ItemUserController::class, 'getItemUsers']);
        });
    });


    Route::group(['prefix' => '/bankAccount'], function () {
        Route::apiResource('bankAccounts', \App\Http\Controllers\Api\BankAccountController::class);
        Route::post('bankAccounts/{id}', [\App\Http\Controllers\Api\BankAccountController::class, 'update']);
        Route::apiResource('bankAccountTransactions', \App\Http\Controllers\Api\BankAccountTransactionController::class);
        Route::post('bankAccountTransactions/{id}', [\App\Http\Controllers\Api\BankAccountTransactionController::class, 'update']);
    });

    Route::group(['prefix' => '/expense'], function () {
        Route::apiResource('expenseCategories', \App\Http\Controllers\Api\ExpenseCategoryController::class);
        Route::post('expenseCategories/{id}', [\App\Http\Controllers\Api\ExpenseCategoryController::class, 'update']);
        Route::apiResource('expenses', \App\Http\Controllers\Api\ExpenseController::class);
        Route::post('expenses/{id}', [\App\Http\Controllers\Api\ExpenseController::class, 'update']);
    });

    Route::group(['prefix' => '/quotation'], function () {
        Route::apiResource('quotations', \App\Http\Controllers\Api\QuotationController::class);
        Route::post('quotations/{id}', [\App\Http\Controllers\Api\QuotationController::class, 'update']);
        Route::apiResource('quotationProducts', \App\Http\Controllers\Api\QuotationProductController::class);
        Route::post('quotationProducts/{id}', [\App\Http\Controllers\Api\QuotationProductController::class, 'update']);
    });

    Route::group(['prefix' => '/purchase', 'middleware' => 'auth:api'], function () {
        Route::apiResource('purchases', \App\Http\Controllers\Api\PurchaseController::class);
        Route::post('purchases/{id}', [\App\Http\Controllers\Api\PurchaseController::class, 'update']);
        Route::apiResource('purchaseProducts', \App\Http\Controllers\Api\PurchaseProductController::class);
        Route::post('purchaseProducts/{id}', [\App\Http\Controllers\Api\PurchaseProductController::class, 'update']);
        Route::get('user-history', [\App\Http\Controllers\Api\PurchaseController::class, 'userPurchaseHistory']);
        Route::get('purchase-list', [\App\Http\Controllers\Api\PurchaseController::class, 'adminPurchaseLists']);
        Route::get('dh-purchase-list', [\App\Http\Controllers\Api\PurchaseController::class, 'departmentHeadPurchaseLists']);
        Route::post('purchaseProducts/change-status/{id}', [\App\Http\Controllers\Api\PurchaseController::class, 'changeStatusOfPurchaseListsProducts']);
    });

    Route::apiResource('transfers', \App\Http\Controllers\Api\TransferController::class);
    Route::post('transfers/{id}', [\App\Http\Controllers\Api\TransferController::class, 'update']);
    Route::apiResource('returnProducts', \App\Http\Controllers\Api\ReturnProductController::class);
    Route::post('returnProducts/{id}', [\App\Http\Controllers\Api\ReturnProductController::class, 'update']);
    Route::apiResource('consumes', \App\Http\Controllers\Api\ConsumeController::class);
    Route::post('consumes/{id}', [\App\Http\Controllers\Api\ConsumeController::class, 'update']);
    Route::apiResource('unusedProducts', \App\Http\Controllers\Api\UnusedProductController::class);
    Route::post('unusedProducts/{id}', [\App\Http\Controllers\Api\UnusedProductController::class, 'update']);
    Route::apiResource('vendors', \App\Http\Controllers\Api\VendorController::class);
    Route::post('vendors/{id}', [\App\Http\Controllers\Api\VendorController::class, 'update']);
    Route::apiResource('vendorProducts', \App\Http\Controllers\Api\VendorProductController::class);
    Route::get('vendorProductIds/{type}/{id}', [\App\Http\Controllers\Api\VendorProductController::class, 'index']);
    Route::post('vendorProducts/{id}', [\App\Http\Controllers\Api\VendorProductController::class, 'update']);

    Route::group(['prefix' => '/budget'], function () {
        Route::apiResource('budgets', \App\Http\Controllers\Api\BudgetController::class);
        Route::post('budgets/{id}', [\App\Http\Controllers\Api\BudgetController::class, 'update']);
        Route::apiResource('budgetDispatches', \App\Http\Controllers\Api\BudgetDispatchController::class);
        Route::post('budgetDispatches/{id}', [\App\Http\Controllers\Api\BudgetDispatchController::class, 'update']);


        Route::apiResource('budgetRequests', \App\Http\Controllers\Api\BudgetRequestController::class);
        Route::post('budgetRequests/{id}', [\App\Http\Controllers\Api\BudgetRequestController::class, 'update']);
        Route::group(['prefix' => '/budgetRequest'], function () {
            Route::apiResource('budgetRequestCategories', \App\Http\Controllers\Api\BudgetRequestCategoryController::class);
            Route::post('budgetRequestCategories/{id}', [\App\Http\Controllers\Api\BudgetRequestCategoryController::class, 'update']);
        });

        Route::apiResource('budgetLimits', \App\Http\Controllers\Api\BudgetLimitController::class);
        Route::post('budgetLimits/{id}', [\App\Http\Controllers\Api\BudgetLimitController::class, 'update']);
        Route::apiResource('budgetExtends', \App\Http\Controllers\Api\BudgetExtendController::class);
        Route::post('budgetExtends/{id}', [\App\Http\Controllers\Api\BudgetExtendController::class, 'update']);
        Route::apiResource('freezeBudgets', \App\Http\Controllers\Api\FreezeBudgetController::class);
        Route::post('freezeBudgets/{id}', [\App\Http\Controllers\Api\FreezeBudgetController::class, 'update']);
    });
});

