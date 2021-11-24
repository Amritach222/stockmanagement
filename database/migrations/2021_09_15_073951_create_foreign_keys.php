<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration
{

    public function up()
    {
        Schema::table('bank_account_transactions', function (Blueprint $table) {
            $table->foreign('account_id')->references('id')->on('bank_accounts')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('expense_category_id')->references('id')->on('expense_categories')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('profile_picture_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('head_of_department')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('logs', function (Blueprint $table) {
            $table->foreign('activity_id')->references('id')->on('activities')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('item_attributes', function (Blueprint $table) {
            $table->foreign('attribute_group_id')->references('id')->on('item_attribute_groups')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('brand_id')->references('id')->on('brands')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('tax_id')->references('id')->on('taxes')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('item_variants', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('item_variants', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('item_variant_attributes', function (Blueprint $table) {
            $table->foreign('item_variant_id')->references('id')->on('item_variants')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('item_variant_attributes', function (Blueprint $table) {
            $table->foreign('attribute_id')->references('id')->on('item_attributes')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('vendors', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('vendors', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreign('reviewed_by')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->foreign('quotation_id')->references('id')->on('quotations')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->foreign('item_variant_id')->references('id')->on('item_variants')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->foreign('tax_id')->references('id')->on('taxes')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->foreign('purchase_id')->references('id')->on('purchases')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->foreign('item_variant_id')->references('id')->on('item_variants')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->foreign('vendor_id')->references('id')->on('vendors')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->foreign('tax_id')->references('id')->on('taxes')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->foreign('item_variant_id')->references('id')->on('item_variants')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('return_products', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('return_products', function (Blueprint $table) {
            $table->foreign('purchase_id')->references('id')->on('purchases')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('return_products', function (Blueprint $table) {
            $table->foreign('purchase_product_id')->references('id')->on('purchase_products')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('return_products', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->foreign('item_variant_id')->references('id')->on('item_variants')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->foreign('image_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->foreign('from')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->foreign('to')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->foreign('item_id')->references('id')->on('items')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->foreign('item_variant_id')->references('id')->on('item_variants')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('reset_password_requests', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('reset_password_requests', function (Blueprint $table) {
            $table->foreign('reset_by')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('signatures', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('signatures', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('signatures', function (Blueprint $table) {
            $table->foreign('designation_id')->references('id')->on('designations')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('signature_use_departments', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('signature_use_departments', function (Blueprint $table) {
            $table->foreign('signature_id')->references('id')->on('signatures')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('budgets', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('budgets', function (Blueprint $table) {
            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->foreign('approved_by')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('budget_limits', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('freeze_budgets', function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('freeze_budgets', function (Blueprint $table) {
            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_years')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->foreign('logo_id')->references('id')->on('files')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::table('bank_account_transactions', function (Blueprint $table) {
            $table->dropForeign('bank_account_transactions_account_id_foreign');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('expenses_user_id_foreign');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('expenses_department_id_foreign');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('expenses_expense_category_id_foreign');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('expenses_bank_account_id_foreign');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropForeign('expenses_file_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_profile_picture_id_foreign');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_department_id_foreign');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_brand_id_foreign');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_category_id_foreign');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_image_id_foreign');
        });
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign('departments_head_of_department_foreign');
        });
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign('brands_image_id_foreign');
        });
        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign('logs_user_id_foreign');
        });
        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign('logs_activity_id_foreign');
        });
        Schema::table('item_attributes', function (Blueprint $table) {
            $table->dropForeign('item_attributes_attribute_group_id_foreign');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_product_id_foreign');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_brand_id_foreign');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_unit_id_foreign');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_tax_id_foreign');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_image_id_foreign');
        });
        Schema::table('item_variants', function (Blueprint $table) {
            $table->dropForeign('item_variants_item_id_foreign');
        });
        Schema::table('item_variants', function (Blueprint $table) {
            $table->dropForeign('item_variants_image_id_foreign');
        });
        Schema::table('item_variant_attributes', function (Blueprint $table) {
            $table->dropForeign('item_variant_attributes_item_variant_id_foreign');
        });
        Schema::table('item_variant_attributes', function (Blueprint $table) {
            $table->dropForeign('item_variant_attributes_attribute_id_foreign');
        });
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropForeign('vendors_image_id_foreign');
        });
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropForeign('vendors_category_id_foreign');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign('quotations_user_id_foreign');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign('quotations_department_id_foreign');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign('quotations_file_id_foreign');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign('quotations_reviewed_by_foreign');
        });
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropForeign('quotations_approved_by_foreign');
        });
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->dropForeign('quotation_products_quotation_id_foreign');
        });
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->dropForeign('quotation_products_item_id_foreign');
        });
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->dropForeign('quotation_products_item_variant_id_foreign');
        });
        Schema::table('quotation_products', function (Blueprint $table) {
            $table->dropForeign('quotation_products_tax_id_foreign');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign('purchases_user_id_foreign');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign('purchases_department_id_foreign');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign('purchases_file_id_foreign');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign('purchases_approved_by_foreign');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->dropForeign('purchase_products_purchase_id_foreign');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->dropForeign('purchase_products_product_id_foreign');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->dropForeign('purchase_products_item_id_foreign');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->dropForeign('purchase_products_item_variant_id_foreign');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->dropForeign('purchase_products_vendor_id_foreign');
        });
        Schema::table('purchase_products', function (Blueprint $table) {
            $table->dropForeign('purchase_products_tax_id_foreign');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->dropForeign('consumes_item_id_foreign');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->dropForeign('consumes_item_variant_id_foreign');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->dropForeign('consumes_department_id_foreign');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->dropForeign('consumes_user_id_foreign');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->dropForeign('consumes_approved_by_foreign');
        });
        Schema::table('consumes', function (Blueprint $table) {
            $table->dropForeign('consumes_image_id_foreign');
        });
        Schema::table('return_products', function (Blueprint $table) {
            $table->dropForeign('return_products_user_id_foreign');
        });
        Schema::table('return_products', function (Blueprint $table) {
            $table->dropForeign('return_products_purchase_id_foreign');
        });
        Schema::table('return_products', function (Blueprint $table) {
            $table->dropForeign('return_products_purchase_product_id_foreign');
        });
        Schema::table('return_products', function (Blueprint $table) {
            $table->dropForeign('return_products_file_id_foreign');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->dropForeign('unused_products_item_id_foreign');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->dropForeign('unused_products_item_variant_id_foreign');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->dropForeign('unused_products_department_id_foreign');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->dropForeign('unused_products_user_id_foreign');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->dropForeign('unused_products_approved_by_foreign');
        });
        Schema::table('unused_products', function (Blueprint $table) {
            $table->dropForeign('unused_products_image_id_foreign');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_user_id_foreign');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_from_foreign');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_to_foreign');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_item_id_foreign');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_item_variant_id_foreign');
        });
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropForeign('transfers_file_id_foreign');
        });
        Schema::table('reset_password_requests', function (Blueprint $table) {
            $table->dropForeign('reset_password_requests_user_id_foreign');
        });
        Schema::table('reset_password_requests', function (Blueprint $table) {
            $table->dropForeign('reset_password_requests_reset_by_foreign');
        });
        Schema::table('signatures', function (Blueprint $table) {
            $table->dropForeign('signatures_file_id_foreign');
        });
        Schema::table('signatures', function (Blueprint $table) {
            $table->dropForeign('signatures_user_id_foreign');
        });
        Schema::table('signatures', function (Blueprint $table) {
            $table->dropForeign('signatures_designation_id_foreign');
        });
        Schema::table('signature_use_departments', function (Blueprint $table) {
            $table->dropForeign('signature_use_departments_department_id_foreign');
        });
        Schema::table('signature_use_departments', function (Blueprint $table) {
            $table->dropForeign('signature_use_departments_signature_id_foreign');
        });
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign('budgets_department_id_foreign');
        });
        Schema::table('budgets', function (Blueprint $table) {
            $table->dropForeign('budgets_fiscal_year_id_foreign');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->dropForeign('budget_requests_department_id_foreign');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->dropForeign('budget_requests_approved_by_foreign');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->dropForeign('budget_requests_user_id_foreign');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->dropForeign('budget_requests_fiscal_year_id_foreign');
        });
        Schema::table('budget_requests', function (Blueprint $table) {
            $table->dropForeign('budget_requests_file_id_foreign');
        });
        Schema::table('budget_limits', function (Blueprint $table) {
            $table->dropForeign('budget_limits_category_id_foreign');
        });
        Schema::table('freeze_budgets', function (Blueprint $table) {
            $table->dropForeign('freeze_budgets_department_id_foreign');
        });
        Schema::table('freeze_budgets', function (Blueprint $table) {
            $table->dropForeign('freeze_budgets_fiscal_year_id_foreign');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign('settings_logo_id_foreign');
        });
    }
}
