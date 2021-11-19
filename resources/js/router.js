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
import ItemAttributeGroupIndex from './components/products/items/itemAttributeGroup/Index'

import ItemAttributeGroupCreate from './components/products/items/itemAttributeGroup/Create'
import ItemAttributeGroupShow from './components/products/items/itemAttributeGroup/Show'
import ItemAttributeGroupEdit from './components/products/items/itemAttributeGroup/Edit'
import ItemAttributeIndex from './components/products/items/itemAttribute/Index'

import ItemAttributeCreate from './components/products/items/itemAttribute/Create'
import ItemAttributeShow from './components/products/items/itemAttribute/Show'
import ItemAttributeEdit from './components/products/items/itemAttribute/Edit'
import ItemIndex from './components/products/items/item/Index'

import ItemCreate from './components/products/items/item/Create'
import ItemShow from './components/products/items/item/Show'
import ItemEdit from './components/products/items/item/Edit'
import ItemVariantIndex from './components/products/items/itemVariant/Index'

import ItemVariantCreate from './components/products/items/itemVariant/Create'
import ItemVariantShow from './components/products/items/itemVariant/Show'
import ItemVariantEdit from './components/products/items/itemVariant/Edit'
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
            name: 'home',
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
            name: 'register',
            component: Register,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/forgot-password',
            name: 'forgot-password',
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
            path: '/products',
            name: 'Products',
            component: ProductIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/products/create',
            name: 'Create Product',
            component: ProductCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/products/edit/:id',
            name: 'Edit Product',
            component: ProductEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/products/:id',
            name: 'Show Product',
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
                    name: 'Create Product',
                    component: ProductCreate,
                    beforeEnter: async (to, from, next) => {
                        await logMe(to, from);
                        next();
                    }
                },
                {
                    path: '/edit/:id',
                    name: 'Edit Product',
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
            name: 'Category',
            component: CategoryIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/categories/create',
            name: 'categories-create',
            component: CategoryCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/categories/edit/:id',
            name: 'categories-edit',
            component: CategoryEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/categories/:id',
            name: 'categories-show',
            component: CategoryShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/brands',
            name: 'Brands',
            component: BrandIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/brands/create',
            name: 'brands-create',
            component: BrandCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/brands/edit/:id',
            name: 'brands-edit',
            component: BrandEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/brands/:id',
            name: 'brands-show',
            component: BrandShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/units',
            name: 'Units',
            component: UnitIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/units/create',
            name: 'units-create',
            component: UnitCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/units/edit/:id',
            name: 'units-edit',
            component: UnitEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/units/:id',
            name: 'units-show',
            component: UnitShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemAttributeGroups',
            name: 'Item Attributes Groups',
            component: ItemAttributeGroupIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemAttributeGroups/create',
            name: 'itemAttributeGroups-create',
            component: ItemAttributeGroupCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemAttributeGroups/edit/:id',
            name: 'itemAttributeGroups-edit',
            component: ItemAttributeGroupEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemAttributeGroups/:id',
            name: 'itemAttributeGroups-show',
            component: ItemAttributeGroupShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemAttributes',
            name: 'Item Attributes',
            component: ItemAttributeIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemAttributes/create',
            name: 'itemAttributes-create',
            component: ItemAttributeCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemAttributes/edit/:id',
            name: 'itemAttributes-edit',
            component: ItemAttributeEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemAttributes/:id',
            name: 'itemAttributes-show',
            component: ItemAttributeShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/items',
            name: 'Items',
            component: ItemIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/items/create',
            name: 'items-create',
            component: ItemCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/items/edit/:id',
            name: 'items-edit',
            component: ItemEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/items/:id',
            name: 'items-show',
            component: ItemShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemVariants',
            name: 'Item Variants',
            component: ItemVariantIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemVariants/create',
            name: 'itemVariants-create',
            component: ItemVariantCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemVariants/edit/:id',
            name: 'itemVariants-edit',
            component: ItemVariantEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/itemVariants/:id',
            name: 'itemVariants-show',
            component: ItemVariantShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/settings',
            name: 'Settings',
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
            name: 'Mail Settings',
            component: MailSettingIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/mailSettings/:id',
            name: 'mailSettings-show',
            component: MailSettingShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/smsSettings',
            name: 'Sms Settings',
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
            name: 'Taxes',
            component: TaxIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/taxes/create',
            name: 'Tax Create',
            component: TaxCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/taxes/edit/:id',
            name: 'Tax Edit',
            component: TaxEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/taxes/:id',
            name: 'Tax Show',
            component: TaxShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/departments',
            name: 'Departments',
            component: DepartmentIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/departments/create',
            name: 'Create Department',
            component: DepartmentCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/departments/edit/:id',
            name: 'Edit Department',
            component: DepartmentEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/departments/:id',
            name: 'Department Show',
            component: DepartmentShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/designations',
            name: 'Designations Index',
            component: DesignationIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/designations/create',
            name: 'Designations Create',
            component: DesignationCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/designations/edit/:id',
            name: 'Designations Edit',
            component: DesignationEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/designations/:id',
            name: 'Designation Show',
            component: DesignationShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/fiscalYears',
            name: 'Fiscal Years',
            component: FiscalYearIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/fiscalYears/create',
            name: 'Fiscal Years Create',
            component: FiscalYearCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/fiscalYears/edit/:id',
            name: 'Fiscal Years Edit',
            component: FiscalYearEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/fiscalYears/:id',
            name: 'Fiscal Years Show',
            component: FiscalYearShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/mailTemplates',
            name: 'Mail Templates',
            component: MailTemplateIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/mailTemplates/edit/:id',
            name: 'Mail Template Edit',
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
            name: 'signatures-index',
            component: SignatureIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatures/create',
            name: 'signatures-create',
            component: SignatureCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatures/edit/:id',
            name: 'signatures-edit',
            component: SignatureEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatures/:id',
            name: 'signatures-show',
            component: SignatureShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/signatureUseDepartments',
            name: 'signatureUseDepartments-index',
            component: SignatureUseDepartmentIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatureUseDepartments/create',
            name: 'signatureUseDepartments-create',
            component: SignatureUseDepartmentCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatureUseDepartments/edit/:id',
            name: 'signatureUseDepartments-edit',
            component: SignatureUseDepartmentEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/signatureUseDepartments/:id',
            name: 'signatureUseDepartments-show',
            component: SignatureUseDepartmentShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/vendors',
            name: 'Vendors',
            component: VendorIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/vendors/create',
            name: 'vendors-create',
            component: VendorCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/vendors/edit/:id',
            name: 'vendors-edit',
            component: VendorEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/vendors/:id',
            name: 'vendors-show',
            component: VendorShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/budgets',
            name: 'Budget',
            component: BudgetIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgets/create',
            name: 'budgets-create',
            component: BudgetCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgets/edit/:id',
            name: 'budgets-edit',
            component: BudgetEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgets/:id',
            name: 'budgets-show',
            component: BudgetShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/budgetLimits',
            name: 'Budget Limit',
            component: BudgetLimitIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetLimits/create',
            name: 'budgetLimits-create',
            component: BudgetLimitCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetLimits/edit/:id',
            name: 'budgetLimits-edit',
            component: BudgetLimitEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetLimits/:id',
            name: 'budgetLimits-show',
            component: BudgetLimitShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/budgetRequests',
            name: 'Budget Requests',
            component: BudgetRequestIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetRequests/create',
            name: 'Budget Requests Create',
            component: BudgetRequestCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetRequests/edit/:id',
            name: 'Budget Request Edit',
            component: BudgetRequestEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/budgetRequests/:id',
            name: 'Budget Request Show',
            component: BudgetRequestShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/freezeBudgets',
            name: 'Freeze Budgets',
            component: FreezeBudgetIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/freezeBudgets/create',
            name: 'Freeze Budget Create',
            component: FreezeBudgetCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/freezeBudgets/edit/:id',
            name: 'Freeze Budget Edit',
            component: FreezeBudgetEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/freezeBudgets/:id',
            name: 'Freeze Budget Show',
            component: FreezeBudgetShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/bankAccounts',
            name: 'Bank Accounts',
            component: BankAccountIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccounts/create',
            name: 'Bank Account Create',
            component: BankAccountCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccounts/edit/:id',
            name: 'Bank Account Edit',
            component: BankAccountEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccounts/:id',
            name: 'Bank Account Show',
            component: BankAccountShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/bankAccountTransactions',
            name: 'Bank Account Transactions',
            component: BankAccountTransactionIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/bankAccountTransactions/create',
            name: 'Bank Account Transaction Create',
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
            name: 'Bank Account Transaction Show',
            component: BankAccountTransactionShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/expenses',
            name: 'Expenses',
            component: ExpenseIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/expenses/create',
            name: 'Expense Create',
            component: ExpenseCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/expenses/edit/:id',
            name: 'Expense Edit',
            component: ExpenseEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/expenses/:id',
            name: 'Expense Show',
            component: ExpenseShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/expenseCategories',
            name: 'Expense Categories',
            component: ExpenseCategoryIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/expenseCategories/:id',
            name: 'Expense Category Show',
            component: ExpenseCategoryShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/profile-setting/',
            name: 'Profile Setting',
            component: ProfileSetting,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },

        {
            path: '/quotations',
            name: 'Quotations',
            component: QuotationIndex,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/quotations/create',
            name: 'Quotation Create',
            component: QuotationCreate,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/quotations/edit/:id',
            name: 'Quotation Edit',
            component: QuotationEdit,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
        {
            path: '/quotations/:id',
            name: 'Quotation Show',
            component: QuotationShow,
            beforeEnter: async (to, from, next) => {
                await logMe(to, from);
                next();
            }
        },
    ]
})

export function logMe(to, from) {
    console.log('******************************************************');
    console.log('from :', from.name);
    console.log('to :', to.name);
    // console.log('loggedIn value is ', store.state.auth.isLoggedIn, 'and in', typeof (store.state.auth.isLoggedIn));
    console.log('------------------------------------------------------');
}
