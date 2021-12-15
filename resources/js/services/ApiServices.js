/**
 * Created by Samundra.
 * Date: 15/09/2021
 */
import Api from './Api'

const POST = 'post'
const GET = 'get'
const PUT = 'put'
const DELETE = 'delete'

async function apiCall(method, route, parameter = null, config = null) {
    let res
    try {
        if (parameter !== null) {
            if (config !== null) {

                // both parameter and config are not null
                res = await Api()[method](route, parameter, config)
                return res.data
            }

            // parameter is not null
            res = await Api()[method](route, parameter)
            return res.data
        }

        // both parameter and config are null

        res = await Api()[method](route)
        return res.data

    } catch (error) {
        return error
    }
}

export default {
    async login(data) {
        return await apiCall(POST, `api/login`, data)
    },

    async reset(data) {
        return await apiCall(POST, `api/reset-password`, data)
    },

    async forgotPassword(data) {
        return await apiCall(POST, `api/forgot-password`, data)
    },
    async resetForgotPassword(data) {
        return await apiCall(POST, `api/forgot-password-set`, data)
    },
    async verifyCode(data) {
        return await apiCall(GET, `api/forgot-password/${data}`)
    },

    async register(data) {
        return await apiCall(POST, `api/register`, data)
    },
    async editProfile(data) {
        const config = {
            headers: {
                'enctype': 'multipart/form-data'
            }
        };
        return await apiCall(POST, `api/user/edit`, data, config)
    },

    async getUserInformation() {
        return await apiCall(GET, `api/user/`)
    },
    async getUserProfilePic() {
        return await apiCall(GET, `api/user/profile-picture`)
    },
    async getUserPermissions() {
        return await apiCall(GET, `api/get-permissions`)
    },
    async logout() {
        return await apiCall(GET, `api/user/logout`)
    },

    async editVendor(data, id) {
        const config = {
            headers: {
                'enctype': 'multipart/form-data'
            }
        };
        return await apiCall(POST, `api/vendor/edit/${id}`, data, config)
    },

    async getReports(to, from) {
        return await apiCall(GET, `po-generate-report`, {params: {from: from, to: to}})
    },
    async addPurchaseType(data) {
        return await apiCall(POST, `api/add-purchase-type`, data)
    },
    async deletePurchaseType(id) {
        return await apiCall(POST, `api/delete-purchase-type/${id}`)
    },

    async allSettingInfo() {
        return await apiCall(GET, `api/setting/all-setting-info`)
    },

    async userIndex() {
        return await apiCall(GET, `api/users/`)
    },

    async productIndex() {
        return await apiCall(GET, `api/product/products`)
    },
    async productCreate(data) {
        return await apiCall(POST, `api/product/products`, data)
    },
    async productShow(id) {
        return await apiCall(GET, `api/product/products/${id}`)
    },
    async productEdit(id, data) {
        return await apiCall(POST, `api/product/products/${id}`, data)
    },
    async productDelete(id) {
        return await apiCall(DELETE, `api/product/products/${id}`)
    },

    async brandIndex() {
        return await apiCall(GET, `api/setting/brands`)
    },
    async brandCreate(data) {
        const config = {
            headers: {
                'enctype': 'multipart/form-data'
            }
        };
        return await apiCall(POST, `api/setting/brands`, data, config)
    },
    async brandShow(id) {
        return await apiCall(GET, `api/setting/brands/${id}`)
    },
    async brandEdit(id, data) {
        const config = {
            headers: {
                'enctype': 'multipart/form-data'
            }
        };
        return await apiCall(POST, `api/setting/brands/${id}`, data, config)
    },
    async brandDelete(id) {
        return await apiCall(DELETE, `api/setting/brands/${id}`)
    },

    async unitIndex() {
        return await apiCall(GET, `api/setting/units`)
    },
    async unitCreate(data) {
        return await apiCall(POST, `api/setting/units`, data)
    },
    async unitShow(id) {
        return await apiCall(GET, `api/setting/units/${id}`)
    },
    async unitEdit(id, data) {
        return await apiCall(POST, `api/setting/units/${id}`, data)
    },
    async unitDelete(id) {
        return await apiCall(DELETE, `api/setting/units/${id}`)
    },

    async unitCategoryIndex() {
        return await apiCall(GET, `api/setting/unitCategories`)
    },
    async unitCategoryCreate(data) {
        return await apiCall(POST, `api/setting/unitCategories`, data)
    },
    async unitCategoryShow(id) {
        return await apiCall(GET, `api/setting/unitCategories/${id}`)
    },
    async unitCategoryEdit(id, data) {
        return await apiCall(POST, `api/setting/unitCategories/${id}`, data)
    },
    async unitCategoryDelete(id) {
        return await apiCall(DELETE, `api/setting/unitCategories/${id}`)
    },

    async categoryIndex() {
        return await apiCall(GET, `api/product/categories`)
    },
    async categoryCreate(data) {
        return await apiCall(POST, `api/product/categories`, data)
    },
    async categoryShow(id) {
        return await apiCall(GET, `api/product/categories/${id}`)
    },
    async categoryEdit(id, data) {
        return await apiCall(POST, `api/product/categories/${id}`, data)
    },
    async categoryDelete(id) {
        return await apiCall(DELETE, `api/product/categories/${id}`)
    },

    async itemIndex() {
        return await apiCall(GET, `api/product/item/items`)
    },
    async itemCreate(data) {
        return await apiCall(POST, `api/product/item/items`, data)
    },
    async itemShow(id) {
        return await apiCall(GET, `api/product/item/items/${id}`)
    },
    async itemEdit(id, data) {
        return await apiCall(POST, `api/product/item/items/${id}`, data)
    },
    async itemDelete(id) {
        return await apiCall(DELETE, `api/product/item/items/${id}`)
    },

    async itemUserIndex() {
        return await apiCall(GET, `api/product/item/itemUsers`)
    },
    async itemUserCreate(data) {
        return await apiCall(POST, `api/product/item/itemUsers`, data)
    },
    async itemUserShow(id) {
        return await apiCall(GET, `api/product/item/itemUsers/${id}`)
    },
    async itemUserEdit(id, data) {
        return await apiCall(POST, `api/product/item/itemUnits/${id}`, data)
    },
    async itemUserDelete(id) {
        return await apiCall(DELETE, `api/product/item/itemUsers/${id}`)
    },
    async itemUsers(id) {
        return await apiCall(GET, `api/product/item/getItemUsers/${id}`)
    },

    async productAttributeGroupIndex() {
        return await apiCall(GET, `api/product/productAttributeGroups`)
    },
    async productAttributeGroupCreate(data) {
        return await apiCall(POST, `api/product/productAttributeGroups`, data)
    },
    async productAttributeGroupShow(id) {
        return await apiCall(GET, `api/product/productAttributeGroups/${id}`)
    },
    async productAttributeGroupEdit(id, data) {
        return await apiCall(POST, `api/product/productAttributeGroups/${id}`, data)
    },
    async productAttributeGroupDelete(id) {
        return await apiCall(DELETE, `api/product/productAttributeGroups/${id}`)
    },

    async productAttributeIndex() {
        return await apiCall(GET, `api/product/productAttributes`)
    },
    async productAttributeCreate(data) {
        return await apiCall(POST, `api/product/productAttributes`, data)
    },
    async productAttributeShow(id) {
        return await apiCall(GET, `api/product/productAttributes/${id}`)
    },
    async productAttributeEdit(id, data) {
        return await apiCall(POST, `api/product/productAttributes/${id}`, data)
    },
    async productAttributeDelete(id) {
        return await apiCall(DELETE, `api/product/productAttributes/${id}`)
    },

    async productVariantIndex() {
        return await apiCall(GET, `api/product/productVariants`)
    },
    async productVariantCreate(data) {
        return await apiCall(POST, `api/product/productVariants`, data)
    },
    async productVariantShow(id) {
        return await apiCall(GET, `api/product/productVariants/${id}`)
    },
    async productVariantEdit(id, data) {
        return await apiCall(POST, `api/product/productVariants/${id}`, data)
    },
    async productVariantDelete(id) {
        return await apiCall(DELETE, `api/product/productVariants/${id}`)
    },

    async taxIndex() {
        return await apiCall(GET, `api/setting/taxes`)
    },
    async taxCreate(data) {
        return await apiCall(POST, `api/setting/taxes`, data)
    },
    async taxShow(id) {
        return await apiCall(GET, `api/setting/taxes/${id}`)
    },
    async taxEdit(id, data) {
        return await apiCall(POST, `api/setting/taxes/${id}`, data)
    },
    async taxDelete(id) {
        return await apiCall(DELETE, `api/setting/taxes/${id}`)
    },


    async settingIndex() {
        return await apiCall(GET, `api/setting/settings`)
    },
    async settingShow(id) {
        return await apiCall(GET, `api/setting/settings/${id}`)
    },
    async settingEdit(id, data) {
        return await apiCall(POST, `api/setting/settings/${id}`, data)
    },

    async smsSettingIndex() {
        return await apiCall(GET, `api/setting/smsSettings`)
    },
    async smsSettingShow(id) {
        return await apiCall(GET, `api/setting/smsSettings/${id}`)
    },
    async smsSettingEdit(id, data) {
        return await apiCall(POST, `api/setting/smsSettings/${id}`, data)
    },

    async mailSettingIndex() {
        return await apiCall(GET, `api/setting/mailSettings`)
    },
    async mailSettingShow(id) {
        return await apiCall(GET, `api/setting/mailSettings/${id}`)
    },
    async mailSettingEdit(id, data) {
        return await apiCall(POST, `api/setting/mailSettings/${id}`, data)
    },

    async mailTemplateIndex() {
        return await apiCall(GET, `api/setting/mailTemplates`)
    },
    async mailTemplateShow(id) {
        return await apiCall(GET, `api/setting/mailTemplates/${id}`)
    },
    async mailTemplateEdit(id, data) {
        return await apiCall(POST, `api/setting/mailTemplates/${id}`, data)
    },

    async departmentIndex() {
        return await apiCall(GET, `api/setting/departments`)
    },
    async departmentCreate(data) {
        return await apiCall(POST, `api/setting/departments`, data)
    },
    async departmentShow(id) {
        return await apiCall(GET, `api/setting/departments/${id}`)
    },
    async departmentEdit(id, data) {
        return await apiCall(POST, `api/setting/departments/${id}`, data)
    },
    async departmentDelete(id) {
        return await apiCall(DELETE, `api/setting/departments/${id}`)
    },

    async designationIndex() {
        return await apiCall(GET, `api/setting/designations`)
    },
    async designationCreate(data) {
        return await apiCall(POST, `api/setting/designations`, data)
    },
    async designationShow(id) {
        return await apiCall(GET, `api/setting/designations/${id}`)
    },
    async designationEdit(id, data) {
        return await apiCall(POST, `api/setting/designations/${id}`, data)
    },
    async designationDelete(id) {
        return await apiCall(DELETE, `api/setting/designations/${id}`)
    },

    async fiscalYearIndex() {
        return await apiCall(GET, `api/setting/fiscalYears`)
    },
    async fiscalYearCreate(data) {
        return await apiCall(POST, `api/setting/fiscalYears`, data)
    },
    async fiscalYearShow(id) {
        return await apiCall(GET, `api/setting/fiscalYears/${id}`)
    },
    async fiscalYearEdit(id, data) {
        return await apiCall(POST, `api/setting/fiscalYears/${id}`, data)
    },
    async fiscalYearDelete(id) {
        return await apiCall(DELETE, `api/setting/fiscalYears/${id}`)
    },

    async signatureIndex() {
        return await apiCall(GET, `api/setting/signature/signatures`)
    },
    async signatureCreate(data) {
        return await apiCall(POST, `api/setting/signature/signatures`, data)
    },
    async signatureShow(id) {
        return await apiCall(GET, `api/setting/signature/signatures/${id}`)
    },
    async signatureEdit(id, data) {
        return await apiCall(POST, `api/setting/signature/signatures/${id}`, data)
    },
    async signatureDelete(id) {
        return await apiCall(DELETE, `api/setting/signature/signatures/${id}`)
    },

    async signatureUseDepartmentIndex() {
        return await apiCall(GET, `api/setting/signature/signatureUseDepartments`)
    },
    async signatureUseDepartmentCreate(data) {
        return await apiCall(POST, `api/setting/signature/signatureUseDepartments`, data)
    },
    async signatureUseDepartmentShow(id) {
        return await apiCall(GET, `api/setting/signature/signatureUseDepartments/${id}`)
    },
    async signatureUseDepartmentEdit(id, data) {
        return await apiCall(POST, `api/setting/signature/signatureUseDepartments/${id}`, data)
    },
    async signatureUseDepartmentDelete(id) {
        return await apiCall(DELETE, `api/setting/signature/signatureUseDepartments/${id}`)
    },

    async vendorIndex() {
        return await apiCall(GET, `api/vendors`)
    },
    async vendorCreate(data) {
        return await apiCall(POST, `api/vendors`, data)
    },
    async vendorShow(id) {
        return await apiCall(GET, `api/vendors/${id}`)
    },
    async vendorEdit(id, data) {
        return await apiCall(POST, `api/vendors/${id}`, data)
    },
    async vendorDelete(id) {
        return await apiCall(DELETE, `api/vendors/${id}`)
    },

    async vendorProductIds(type, id) {
        return await apiCall(GET, `api/vendorProductIds/${type}/${id}`)
    },
    async vendorProductCreate(data) {
        return await apiCall(POST, `api/vendorProducts`, data)
    },
    async vendorProductShow(id) {
        return await apiCall(GET, `api/vendorProducts/${id}`)
    },
    async vendorProductEdit(id, data) {
        return await apiCall(POST, `api/vendorProducts/${id}`, data)
    },
    async vendorProductDelete(id) {
        return await apiCall(DELETE, `api/vendorProducts/${id}`)
    },

    async budgetIndex() {
        return await apiCall(GET, `api/budget/budgets`)
    },
    async budgetCreate(data) {
        return await apiCall(POST, `api/budget/budgets`, data)
    },
    async budgetShow(id) {
        return await apiCall(GET, `api/budget/budgets/${id}`)
    },
    async budgetEdit(id, data) {
        return await apiCall(POST, `api/budget/budgets/${id}`, data)
    },
    async budgetDelete(id) {
        return await apiCall(DELETE, `api/budget/budgets/${id}`)
    },

    async budgetRequestIndex() {
        return await apiCall(GET, `api/budget/budgetRequests`)
    },
    async budgetRequestCreate(data) {
        return await apiCall(POST, `api/budget/budgetRequests`, data)
    },
    async budgetRequestShow(id) {
        return await apiCall(GET, `api/budget/budgetRequests/${id}`)
    },
    async budgetRequestEdit(id, data) {
        return await apiCall(POST, `api/budget/budgetRequests/${id}`, data)
    },
    async budgetRequestDelete(id) {
        return await apiCall(DELETE, `api/budget/budgetRequests/${id}`)
    },

    async budgetLimitIndex() {
        return await apiCall(GET, `api/budget/budgetLimits`)
    },
    async budgetLimitCreate(data) {
        return await apiCall(POST, `api/budget/budgetLimits`, data)
    },
    async budgetLimitShow(id) {
        return await apiCall(GET, `api/budget/budgetLimits/${id}`)
    },
    async budgetLimitEdit(id, data) {
        return await apiCall(POST, `api/budget/budgetLimits/${id}`, data)
    },
    async budgetLimitDelete(id) {
        return await apiCall(DELETE, `api/budget/budgetLimits/${id}`)
    },

    async budgetExtendIndex() {
        return await apiCall(GET, `api/budget/budgetExtends`)
    },
    async budgetExtendCreate(data) {
        return await apiCall(POST, `api/budget/budgetExtends`, data)
    },
    async budgetExtendShow(id) {
        return await apiCall(GET, `api/budget/budgetExtends/${id}`)
    },
    async budgetExtendEdit(id, data) {
        return await apiCall(POST, `api/budget/budgetExtends/${id}`, data)
    },
    async budgetExtendDelete(id) {
        return await apiCall(DELETE, `api/budget/budgetExtends/${id}`)
    },

    async freezeBudgetIndex() {
        return await apiCall(GET, `api/budget/freezeBudgets`)
    },
    async freezeBudgetCreate(data) {
        return await apiCall(POST, `api/budget/freezeBudgets`, data)
    },
    async freezeBudgetShow(id) {
        return await apiCall(GET, `api/budget/freezeBudgets/${id}`)
    },
    async freezeBudgetEdit(id, data) {
        return await apiCall(POST, `api/budget/freezeBudgets/${id}`, data)
    },
    async freezeBudgetDelete(id) {
        return await apiCall(DELETE, `api/budget/freezeBudgets/${id}`)
    },

    async bankAccountIndex() {
        return await apiCall(GET, `api/bankAccount/bankAccounts`)
    },
    async bankAccountCreate(data) {
        return await apiCall(POST, `api/bankAccount/bankAccounts`, data)
    },
    async bankAccountShow(id) {
        return await apiCall(GET, `api/bankAccount/bankAccounts/${id}`)
    },
    async bankAccountEdit(id, data) {
        return await apiCall(POST, `api/bankAccount/bankAccounts/${id}`, data)
    },
    async bankAccountDelete(id) {
        return await apiCall(DELETE, `api/bankAccount/bankAccounts/${id}`)
    },

    async bankAccountTransactionIndex() {
        return await apiCall(GET, `api/bankAccount/bankAccountTransactions`)
    },
    async bankAccountTransactionCreate(data) {
        return await apiCall(POST, `api/bankAccount/bankAccountTransactions`, data)
    },
    async bankAccountTransactionShow(id) {
        return await apiCall(GET, `api/bankAccount/bankAccountTransactions/${id}`)
    },
    async bankAccountTransactionEdit(id, data) {
        return await apiCall(POST, `api/bankAccount/bankAccountTransactions/${id}`, data)
    },
    async bankAccountTransactionDelete(id) {
        return await apiCall(DELETE, `api/bankAccount/bankAccountTransactions/${id}`)
    },

    async expenseCategoryIndex() {
        return await apiCall(GET, `api/expense/expenseCategories`)
    },
    async expenseCategoryCreate(data) {
        return await apiCall(POST, `api/expense/expenseCategories`, data)
    },
    async expenseCategoryShow(id) {
        return await apiCall(GET, `api/expense/expenseCategories/${id}`)
    },
    async expenseCategoryEdit(id, data) {
        return await apiCall(POST, `api/expense/expenseCategories/${id}`, data)
    },
    async expenseCategoryDelete(id) {
        return await apiCall(DELETE, `api/expense/expenseCategories/${id}`)
    },

    async expenseIndex() {
        return await apiCall(GET, `api/expense/expenses`)
    },
    async expenseCreate(data) {
        return await apiCall(POST, `api/expense/expenses`, data)
    },
    async expenseShow(id) {
        return await apiCall(GET, `api/expense/expenses/${id}`)
    },
    async expenseEdit(id, data) {
        return await apiCall(POST, `api/expense/expenses/${id}`, data)
    },
    async expenseDelete(id) {
        return await apiCall(DELETE, `api/expense/expenses/${id}`)
    },

    async quotationIndex() {
        return await apiCall(GET, `api/quotation/quotations`)
    },
    async quotationCreate(data) {
        return await apiCall(POST, `api/quotation/quotations`, data)
    },
    async quotationShow(id) {
        return await apiCall(GET, `api/quotation/quotations/${id}`)
    },
    async quotationEdit(id, data) {
        return await apiCall(POST, `api/quotation/quotations/${id}`, data)
    },
    async quotationDelete(id) {
        return await apiCall(DELETE, `api/quotation/quotations/${id}`)
    },

    async quotationProductIndex() {
        return await apiCall(GET, `api/quotation/quotationProducts`)
    },
    async quotationProductCreate(data) {
        return await apiCall(POST, `api/quotation/quotationProducts`, data)
    },
    async quotationProductShow(id) {
        return await apiCall(GET, `api/quotation/quotationProducts/${id}`)
    },
    async quotationProductEdit(id, data) {
        return await apiCall(POST, `api/quotation/quotationProducts/${id}`, data)
    },
    async quotationProductDelete(id) {
        return await apiCall(DELETE, `api/quotation/quotationProducts/${id}`)
    },

    async createVariant(data) {
        return await apiCall(POST, `api/create-variants`, data)
    },

    async addPurchaseRequest(data) {
        const config = {
            headers: {
                'enctype': 'multipart/form-data'
            }
        };
        return await apiCall(POST, `api/purchase/purchases`, data, config)
    },
    async addPurchaseProductRequest(data) {
        return await apiCall(POST, `api/purchase/purchaseProducts`, data)
    },
    async getUserPurchaseProductRequestHistory() {
        return await apiCall(GET, `api/purchase/user-history`)
    },
}
