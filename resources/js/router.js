/**
 * Created by Samundra.
 * Date: 15/09/2021
 */
import Vue from 'vue'
import Router from 'vue-router'
import Login from './components/auth/Logins'
import ForgotPassword from './components/auth/ForgotPasswords'
import ForgotPasswordSet from './components/auth/ForgotPasswordSets'
import ResetPassword from './components/auth/ResetPasswords'
import Register from './components/auth/Registers'
import Home from './components/home/Home'

import ProductIndex from './components/products/product/Index'
import ProductCreate from './components/products/product/Create'
import ProductShow from './components/products/product/Show'
import ProductEdit from './components/products/product/Edit'

import CategoryIndex from './components/products/category/Index'
import CategoryCreate from './components/products/category/Create'
import CategoryShow from './components/products/category/Show'
import CategoryEdit from './components/products/category/Edit'

import BrandIndex from './components/settings/brand/Index'
import BrandCreate from './components/settings/brand/Create'
import BrandShow from './components/settings/brand/Show'
import BrandEdit from './components/settings/brand/Edit'

import UnitCategoryIndex from './components/settings/unitCategory/Index'

import UnitIndex from './components/settings/unit/Index'
import UnitCreate from './components/settings/unit/Create'
import UnitShow from './components/settings/unit/Show'
import UnitEdit from './components/settings/unit/Edit'

import TaxIndex from './components/settings/tax/Index'
import TaxCreate from './components/settings/tax/Create'
import TaxShow from './components/settings/tax/Show'
import TaxEdit from './components/settings/tax/Edit'

import DepartmentIndex from './components/settings/department/Index'
import DepartmentCreate from './components/settings/department/Create'
import DepartmentShow from './components/settings/department/Show'
import DepartmentEdit from './components/settings/department/Edit'

import DesignationIndex from './components/settings/designation/Index'
import DesignationCreate from './components/settings/designation/Create'
import DesignationShow from './components/settings/designation/Show'
import DesignationEdit from './components/settings/designation/Edit'

import FiscalYearIndex from './components/settings/fiscalYear/Index'
import FiscalYearCreate from './components/settings/fiscalYear/Create'
import FiscalYearShow from './components/settings/fiscalYear/Show'
import FiscalYearEdit from './components/settings/fiscalYear/Edit'

import SettingIndex from './components/settings/setting/Index'
import SettingShow from './components/settings/setting/Show'
import MailSettingShow from './components/settings/mailSetting/Show'

import MailSettingIndex from './components/settings/mailSetting/Index'
import SmsSettingShow from './components/settings/smsSetting/Show'

import SmsSettingIndex from './components/settings/smsSetting/Index'
import MailTemplateIndex from './components/settings/mailTemplate/Index'

import MailTemplateShow from './components/settings/mailTemplate/Show'
import MailTemplateEdit from './components/settings/mailTemplate/Edit'

import ProductAttributeGroupIndex from './components/Products/ProductAttributeGroup/Index'
import ProductAttributeGroupCreate from './components/Products/ProductAttributeGroup/Create'
import ProductAttributeGroupShow from './components/Products/ProductAttributeGroup/Show'
import ProductAttributeGroupEdit from './components/Products/ProductAttributeGroup/Edit'

import ProductAttributeIndex from './components/Products/ProductAttribute/Index'
import ProductAttributeCreate from './components/Products/ProductAttribute/Create'
import ProductAttributeShow from './components/Products/ProductAttribute/Show'
import ProductAttributeEdit from './components/Products/ProductAttribute/Edit'

import ItemIndex from './components/products/items/item/Index'
import ItemCreate from './components/products/items/item/Create'
import ItemShow from './components/products/items/item/Show'
import ItemEdit from './components/products/items/item/Edit'

import ProductVariantIndex from './components/Products/ProductVariant/Index'
import ProductVariantCreate from './components/Products/ProductVariant/Create'
import ProductVariantShow from './components/Products/ProductVariant/Show'
import ProductVariantEdit from './components/Products/ProductVariant/Edit'

import SignatureIndex from './components/settings/signatures/signature/Index'
import SignatureCreate from './components/settings/signatures/signature/Create'
import SignatureShow from './components/settings/signatures/signature/Show'
import SignatureEdit from './components/settings/signatures/signature/Edit'
import SignatureUseDepartmentIndex from './components/settings/signatures/signatureUseDepartment/Index'

import SignatureUseDepartmentCreate from './components/settings/signatures/signatureUseDepartment/Create'
import SignatureUseDepartmentShow from './components/settings/signatures/signatureUseDepartment/Show'
import SignatureUseDepartmentEdit from './components/settings/signatures/signatureUseDepartment/Edit'

import VendorIndex from './components/vendor/Index'
import VendorCreate from './components/vendor/Create'
import VendorShow from './components/vendor/Show'
import VendorEdit from './components/vendor/Edit'

import VendorProductShow from './components/vendor/vendorProduct/ShowProduct'
import VendorProductAdd from './components/vendor/vendorProduct/AddProduct'

import BudgetIndex from './components/budgets/budget/Index'
import BudgetCreate from './components/budgets/budget/Create'
import BudgetShow from './components/budgets/budget/Show'
import BudgetEdit from './components/budgets/budget/Edit'

import BudgetRequestIndex from './components/budgets/budgetRequest/Index'
import BudgetRequestCreate from './components/budgets/budgetRequest/Create'
import BudgetRequestShow from './components/budgets/budgetRequest/Show'
import BudgetRequestEdit from './components/budgets/budgetRequest/Edit'

import BudgetLimitIndex from './components/budgets/budgetLimit/Index'
import BudgetLimitCreate from './components/budgets/budgetLimit/Create'
import BudgetLimitShow from './components/budgets/budgetLimit/Show'
import BudgetLimitEdit from './components/budgets/budgetLimit/Edit'

import BudgetExtendIndex from './components/budgets/budgetExtend/Index'
import BudgetExtendCreate from './components/budgets/budgetExtend/Create'
import BudgetExtendShow from './components/budgets/budgetExtend/Show'
import BudgetExtendEdit from './components/budgets/budgetExtend/Edit'

import FreezeBudgetIndex from './components/budgets/freezeBudget/Index'
import FreezeBudgetCreate from './components/budgets/freezeBudget/Create'
import FreezeBudgetShow from './components/budgets/freezeBudget/Show'
import FreezeBudgetEdit from './components/budgets/freezeBudget/Edit'

import BankAccountIndex from './components/bankAccounts/bankAccount/Index'
import BankAccountCreate from './components/bankAccounts/bankAccount/Create'
import BankAccountShow from './components/bankAccounts/bankAccount/Show'
import BankAccountEdit from './components/bankAccounts/bankAccount/Edit'

import BankAccountTransactionIndex from './components/bankAccounts/bankAccountTransaction/Index'
import BankAccountTransactionCreate from './components/bankAccounts/bankAccountTransaction/Create'
import BankAccountTransactionShow from './components/bankAccounts/bankAccountTransaction/Show'
import BankAccountTransactionEdit from './components/bankAccounts/bankAccountTransaction/Edit'

import QuotationIndex from './components/quotations/quotation/Index'
import QuotationCreate from './components/quotations/quotation/Create'
import QuotationEdit from './components/quotations/quotation/Edit'
import QuotationShow from './components/quotations/quotation/Show'

import ExpenseIndex from './components/expenses/Expense/Index'
import ExpenseCreate from './components/expenses/Expense/Create'
import ExpenseShow from './components/expenses/Expense/Show'
import ExpenseEdit from './components/expenses/Expense/Edit'

import ExpenseCategoryIndex from './components/expenses/ExpenseCategory/Index'
import ExpenseCategoryShow from './components/expenses/ExpenseCategory/Show'

import ProfileSetting from './components/Settings/profile/Index'

import i18n from './i18n'

import NewPurchaseRequest from './components/purchaseRequest/NewPurchaseRequest'
import PurchaseRequestHistory from './components/purchaseRequest/PurchaseRequestHistory'

import NotFound from './components/errorPage/NotFound'

Vue.use(Router)

export default new Router({
    mode: 'hash',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                if (localStorage.getItem('isLoggedIn') === 'true') {
                    next('home');
                } else {
                    next('login');
                }
            }
        },
        {
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/home',
            name: i18n.t('home'),
            component: Home,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                if (localStorage.getItem('isLoggedIn') === 'true') {
                    next();
                } else {
                    next('login');
                }
            }
        },
        {
            path: '/register',
            name: i18n.t('register'),
            component: Register,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/forgot-password',
            name: i18n.t('forgotPassword'),
            component: ForgotPassword,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/reset-password-confirm',
            name: 'forgot-password-set',
            component: ForgotPasswordSet,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/reset-password',
            name: 'reset-password',
            component: ResetPassword,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/new-purchase-request',
            name: i18n.t('new') +' '+ i18n.t('purchase') +' '+ i18n.t('request'),
            component: NewPurchaseRequest,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/purchase-request-history',
            name: i18n.t('purchase') +' '+ i18n.t('request') +' '+ i18n.t('history'),
            component: PurchaseRequestHistory,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/products',
            name: i18n.t('product') + ' / ' + i18n.t('products'),
            component: ProductIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/products/create',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.add_product'),
            component: ProductCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/products/edit/:id',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.edit_product'),
            component: ProductEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/products/:id',
            name: i18n.t('product'),
            component: ProductShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            },
            children: [
                {
                    path: '/products/about/:id',
                    name: 'Product Information',
                    component: ProductShow,
                    beforeEnter: async (to, from, next) => {
                        await logMe(to, from);
                        next();
                    }
                },
                {
                    path: '/products/create',
                    name: i18n.t('card_title.add_product'),
                    component: ProductCreate,
                    beforeEnter: async (to, from, next) => {
                        await logMe(to, from);
                        next();
                    }
                },
                {
                    path: '/edit/:id',
                    name: i18n.t('card_title.edit_product'),
                    component: ProductEdit,
                    beforeEnter: async (to, from, next) => {
                        await logMe(to, from);
                        next();
                    }
                },
            ]
        },
        {
            path: '/categories',
            name: i18n.t('product') + ' / ' + i18n.t('categories'),
            component: CategoryIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/categories/create',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.add_category'),
            component: CategoryCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/categories/edit/:id',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.edit_category'),
            component: CategoryEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/categories/:id',
            name: i18n.t('product') + ' / ' + i18n.t('category'),
            component: CategoryShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/brands',
            name: i18n.t('product') + ' / ' + i18n.t('brands'),
            component: BrandIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/brands/create',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.add_brand'),
            component: BrandCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/brands/edit/:id',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.edit_brand'),
            component: BrandEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/brands/:id',
            name: i18n.t('product') + ' / ' + i18n.t('brand'),
            component: BrandShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/units',
            name: i18n.t('product') + ' / ' + i18n.t('units'),
            component: UnitIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/units/create',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.add_unit'),
            component: UnitCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/units/edit/:id',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.edit_unit'),
            component: UnitEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/units/:id',
            name: i18n.t('product') + ' / ' + i18n.t('unit'),
            component: UnitShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/unitCategories',
            name: i18n.t('product') + ' / ' + i18n.t('unit') + ' ' + i18n.t('categories'),
            component: UnitCategoryIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productAttributeGroups',
            name: i18n.t('product') + ' / ' + i18n.t('product_attribute_groups'),
            component: ProductAttributeGroupIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productAttributeGroups/create',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.add_product_attribute_group'),
            component: ProductAttributeGroupCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productAttributeGroups/edit/:id',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.edit_product_attribute_group'),
            component: ProductAttributeGroupEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productAttributeGroups/:id',
            name: i18n.t('product') + ' / ' + i18n.t('product_attribute_group'),
            component: ProductAttributeGroupShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productAttributes',
            name: i18n.t('product') + ' / ' + i18n.t('product_attributes'),
            component: ProductAttributeIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productAttributes/create',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.add_product_attribute'),
            component: ProductAttributeCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productAttributes/edit/:id',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.edit_product_attribute'),
            component: ProductAttributeEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productAttributes/:id',
            name: i18n.t('product') + ' / ' + i18n.t('product_attribute'),
            component: ProductAttributeShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/items',
            name: i18n.t('product') + ' / ' + i18n.t('items'),
            component: ItemIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/items/create',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.add_item'),
            component: ItemCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/items/edit/:id',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.edit_item'),
            component: ItemEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/items/:id',
            name: i18n.t('product') + ' / ' + i18n.t('item'),
            component: ItemShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productVariants',
            name: i18n.t('product') + ' / ' + i18n.t('product_variants'),
            component: ProductVariantIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productVariants/create',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.add_product_variant'),
            component: ProductVariantCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productVariants/edit/:id',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.edit_product_variant'),
            component: ProductVariantEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/productVariants/:id',
            name: i18n.t('product') + ' / ' + i18n.t('product_variant'),
            component: ProductVariantShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/settings',
            name: i18n.t('settings') + ' / ' + i18n.t('general_settings'),
            component: SettingIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/settings/:id',
            name: 'settings-show',
            component: SettingShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/mailSettings/',
            name: i18n.t('settings') + ' / ' + i18n.t('card_title.edit_mail_setting'),
            component: MailSettingIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/mailSettings/:id',
            name: i18n.t('settings') + ' / ' + 'mailSettings-show',
            component: MailSettingShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/smsSettings',
            name: i18n.t('settings') + ' / ' + i18n.t('card_title.edit_sms_setting'),
            component: SmsSettingIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/smsSettings/:id',
            name: 'smsSettings-show',
            component: SmsSettingShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/taxes',
            name: i18n.t('product') + ' / ' + i18n.t('taxes'),
            component: TaxIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/taxes/create',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.add_tax'),
            component: TaxCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/taxes/edit/:id',
            name: i18n.t('product') + ' / ' + i18n.t('card_title.edit_tax'),
            component: TaxEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/taxes/:id',
            name: i18n.t('product') + ' / ' + i18n.t('tax'),
            component: TaxShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/departments',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('departments'),
            component: DepartmentIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/departments/create',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.add_department'),
            component: DepartmentCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/departments/edit/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.edit_department'),
            component: DepartmentEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/departments/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('department'),
            component: DepartmentShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/designations',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('designations'),
            component: DesignationIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/designations/create',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.add_designation'),
            component: DesignationCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/designations/edit/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.edit_designation'),
            component: DesignationEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/designations/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('designation'),
            component: DesignationShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/fiscalYears',
            name: i18n.t('settings') + ' / ' + i18n.t('web') +' '+ i18n.t('settings') + ' / ' + i18n.t('fiscal_years'),
            component: FiscalYearIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/fiscalYears/create',
            name: i18n.t('settings') + ' / ' + i18n.t('web') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.add_fiscal_year'),
            component: FiscalYearCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/fiscalYears/edit/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('web') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.edit_fiscal_year'),
            component: FiscalYearEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/fiscalYears/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('web') +' '+ i18n.t('settings') + ' / ' + i18n.t('fiscal_year'),
            component: FiscalYearShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/mailTemplates',
            name: i18n.t('settings') + ' / ' + i18n.t('web') +' '+ i18n.t('settings') + ' / ' + i18n.t('mail') +' '+ i18n.t('templates'),
            component: MailTemplateIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/mailTemplates/edit/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('web') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.edit_mail_template'),
            component: MailTemplateEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/mailTemplates/:id',
            name: 'Mail Template Show',
            component: MailTemplateShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/signatures',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('signatures'),
            component: SignatureIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatures/create',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.add_signature'),
            component: SignatureCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatures/edit/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.edit_signature'),
            component: SignatureEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatures/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('signature'),
            component: SignatureShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/signatureUseDepartments',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('signature') +' '+ i18n.t('use') +' '+ i18n.t('departments'),
            component: SignatureUseDepartmentIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatureUseDepartments/create',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.add_signature_use_department'),
            component: SignatureUseDepartmentCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatureUseDepartments/edit/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('card_title.edit_signature_use_department'),
            component: SignatureUseDepartmentEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatureUseDepartments/:id',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+ i18n.t('settings') + ' / ' + i18n.t('signature') +' '+ i18n.t('use') +' '+ i18n.t('department'),
            component: SignatureUseDepartmentShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/vendors',
            name: i18n.t('vendors'),
            component: VendorIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/vendors/create',
            name: i18n.t('card_title.add_vendor'),
            component: VendorCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/vendors/edit/:id',
            name: i18n.t('card_title.edit_vendor'),
            component: VendorEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/vendors/:id',
            name: i18n.t('vendor'),
            component: VendorShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/vendorProducts/add/:id',
            name: i18n.t('card_title.edit_vendor_product'),
            component: VendorProductAdd,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/vendorProducts/:id',
            name: i18n.t('vendor') +' '+ i18n.t('product'),
            component: VendorProductShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/budgets',
            name: i18n.t('budgets'),
            component: BudgetIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgets/create',
            name: i18n.t('card_title.add_budget'),
            component: BudgetCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgets/edit/:id',
            name: i18n.t('card_title.edit_budget'),
            component: BudgetEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgets/:id',
            name: i18n.t('budget'),
            component: BudgetShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/budgetLimits',
            name: i18n.t('budget') + ' / ' + i18n.t('budget_limit'),
            component: BudgetLimitIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetLimits/create',
            name: i18n.t('budget') + ' / ' + i18n.t('card_title.add_budget_limit'),
            component: BudgetLimitCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetLimits/edit/:id',
            name: i18n.t('budget') + ' / ' + i18n.t('card_title.edit_budget_limit'),
            component: BudgetLimitEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetLimits/:id',
            name: i18n.t('budget') + ' / ' + i18n.t('budget_limit'),
            component: BudgetLimitShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/budgetRequests',
            name: i18n.t('budget') + ' / ' + i18n.t('budget_request'),
            component: BudgetRequestIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetRequests/create',
            name: i18n.t('budget') + ' / ' + i18n.t('card_title.add_budget_request'),
            component: BudgetRequestCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetRequests/edit/:id',
            name: i18n.t('budget') + ' / ' + i18n.t('card_title.edit_budget_request'),
            component: BudgetRequestEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetRequests/:id',
            name: i18n.t('budget') + ' / ' + i18n.t('budget_request'),
            component: BudgetRequestShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/freezeBudgets',
            name: i18n.t('budget') + ' / ' + i18n.t('freeze_budgets'),
            component: FreezeBudgetIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/freezeBudgets/create',
            name: i18n.t('budget') + ' / ' + i18n.t('card_title.add_freeze_budget'),
            component: FreezeBudgetCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/freezeBudgets/edit/:id',
            name: i18n.t('budget') + ' / ' + i18n.t('card_title.edit_freeze_budget'),
            component: FreezeBudgetEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/freezeBudgets/:id',
            name: i18n.t('budget') + ' / ' + i18n.t('freeze_budget'),
            component: FreezeBudgetShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/bankAccounts',
            name: i18n.t('bank') +' '+ i18n.t('accounts'),
            component: BankAccountIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccounts/create',
            name: i18n.t('card_title.add_bank_account'),
            component: BankAccountCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccounts/edit/:id',
            name: i18n.t('card_title.edit_bank_account'),
            component: BankAccountEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccounts/:id',
            name: i18n.t('bank') +' '+ i18n.t('account'),
            component: BankAccountShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/bankAccountTransactions',
            name: i18n.t('bank') +' '+ i18n.t('Account') + ' / ' + i18n.t('bank') +' '+ i18n.t('account') +' '+ i18n.t('transactions'),
            component: BankAccountTransactionIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccountTransactions/create',
            name: i18n.t('bank') +' '+ i18n.t('Account') + ' / ' + i18n.t('card_title.add_bank_account_transaction'),
            component: BankAccountTransactionCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccountTransactions/edit/:id',
            name: 'Bank Account Transaction Edit',
            component: BankAccountTransactionEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccountTransactions/:id',
            name: i18n.t('bank') +' '+ i18n.t('Account') + ' / ' + i18n.t('bank') +' '+ i18n.t('account') +' '+ i18n.t('transaction'),
            component: BankAccountTransactionShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/expenses',
            name: i18n.t('expenses'),
            component: ExpenseIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/expenses/create',
            name: i18n.t('card_title.add_expense'),
            component: ExpenseCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/expenses/edit/:id',
            name: i18n.t('card_title.edit_expense'),
            component: ExpenseEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/expenses/:id',
            name: i18n.t('expense'),
            component: ExpenseShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/expenseCategories',
            name: i18n.t('expense') + ' / ' + i18n.t('expense') +' '+ i18n.t('categories'),
            component: ExpenseCategoryIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/expenseCategories/:id',
            name: i18n.t('expense') + ' / ' + i18n.t('expense') +' '+ i18n.t('category'),
            component: ExpenseCategoryShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/profile-setting/',
            name: i18n.t('settings') + ' / ' + i18n.t('user') +' '+i18n.t('settings') + ' / ' + i18n.t('profile') +' '+ i18n.t('settings'),
            component: ProfileSetting,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/quotations',
            name: i18n.t('quotations'),
            component: QuotationIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/quotations/create',
            name: i18n.t('card_title.add_quotation'),
            component: QuotationCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/quotations/edit/:id',
            name: i18n.t('card_title.edit_quotation'),
            component: QuotationEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/quotations/:id',
            name: i18n.t('quotation'),
            component: QuotationShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '*',
            name: 'Not Found',
            component: NotFound
        }
    ]
})

export function logMe(to, from) {
    console.log('******************************************************');
    console.log('from :', from.name);
    console.log('to :', to.name);
    // console.log('loggedIn value is ', store.state.auth.isLoggedIn, 'and in', typeof (store.state.auth.isLoggedIn));
    console.log('------------------------------------------------------');
}
