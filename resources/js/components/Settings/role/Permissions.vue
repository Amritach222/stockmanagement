<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.edit_role_permission') }}</strong>
                                <v-progress-circular
                                    v-if="createProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-form>
                                        <v-simple-table>
                                            <template v-slot:default>
                                                <thead>
                                                <tr>
                                                    <th class="text-left">
                                                        Permissions / Actions
                                                    </th>
                                                    <th class="text-left">
                                                        List
                                                    </th>
                                                    <th class="text-left">
                                                        Create
                                                    </th>
                                                    <th class="text-left">
                                                        Edit
                                                    </th>
                                                    <th class="text-left">
                                                        Show
                                                    </th>
                                                    <th class="text-left">
                                                        Delete
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr
                                                    v-for="item in items"
                                                    :key="item.name"
                                                >
                                                    <td>{{ item.name }}</td>
                                                    <td>
                                                        <div v-if="permissions.indexOf(item.value) !== -1">
                                                            <v-checkbox
                                                                :input-value="rolePermissions.indexOf(item.value) !== -1"
                                                                type="checkbox"
                                                                autocomplete=""
                                                                v-on:click="updatePermission(item.value)"
                                                                solo
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div v-if="permissions.indexOf(item.value + '.create') !== -1">
                                                            <v-checkbox
                                                                :input-value="rolePermissions.indexOf(item.value + '.create') !== -1"
                                                                type="checkbox"
                                                                autocomplete=""
                                                                v-on:click="updatePermission(item.value+'.create')"
                                                                solo
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div v-if="permissions.indexOf(item.value + '.edit') !== -1">
                                                            <v-checkbox
                                                                :input-value="rolePermissions.indexOf(item.value+'.edit') !== -1"
                                                                type="checkbox"
                                                                autocomplete=""
                                                                solo
                                                                v-on:click="updatePermission(item.value+'.edit')"
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div v-if="permissions.indexOf(item.value + '.show') !== -1">
                                                            <v-checkbox
                                                                :input-value="rolePermissions.indexOf(item.value+'.show') !== -1"
                                                                type="checkbox"
                                                                autocomplete=""
                                                                v-on:click="updatePermission(item.value+'.show')"
                                                                solo
                                                            />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div v-if="permissions.indexOf(item.value + '.delete') !== -1">
                                                            <v-checkbox
                                                                :input-value="rolePermissions.indexOf(item.value+'.delete') !== -1"
                                                                type="checkbox"
                                                                autocomplete=""
                                                                v-on:click="updatePermission(item.value+'.delete')"
                                                                solo
                                                            />
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </template>
                                        </v-simple-table>
                                    </v-form>

                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/users'">
                                            <CIcon name="cil-ban"/>
                                            {{ $t('button.cancel') }}
                                        </CButton>
                                    </CCardFooter>
                                </CForm>
                            </CCardBody>
                        </CCard>
                    </CCardGroup>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>

<script>
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";
import config from "../../../config";

export default {
    name: "UserPermission",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        permissions: [],
        rolePermissions: [],
        role: {
            id: null,
        },
        items: [
            {name: 'Attribute', value: 'attributes'},
            {name: 'Attribute Group', value: 'attributeGroups'},
            {name: 'Bank Account', value: 'bankAccounts'},
            {name: 'Bank Account Transaction', value: 'bankAccountTransactions'},
            {name: 'Brand', value: 'brands'},
            {name: 'Budget', value: 'budgets'},
            {name: 'Budget Dispatch', value: 'budgetDispatches'},
            {name: 'Budget Limit', value: 'budgetLimits'},
            {name: 'Budget Request', value: 'budgetRequests'},
            {name: 'Budget Request Category', value: 'budgetRequestCategories'},
            {name: 'Category', value: 'categories'},
            {name: 'Consume Product', value: 'consumes'},
            {name: 'Department', value: 'departments'},
            {name: 'Designation', value: 'designations'},
            {name: 'Expense', value: 'expenses'},
            {name: 'Expense Category', value: 'expenseCategories'},
            {name: 'Fiscal Year', value: 'fiscalYears'},
            {name: 'Freeze Budget', value: 'freezeBudgets'},
            {name: 'General Settings', value: 'settings'},
            {name: 'Item', value: 'items'},
            {name: 'Log', value: 'logs'},
            {name: 'Mail Setting', value: 'mailSettings'},
            {name: 'Mail Template', value: 'mailTemplates'},
            {name: 'Product', value: 'products'},
            {name: 'Product Variant', value: 'productVariants'},
            {name: 'Product Variant Attribute', value: 'productVariantAttributes'},
            {name: 'Purchase', value: 'purchases'},
            {name: 'Purchase Product', value: 'purchaseProducts'},
            {name: 'Quotation', value: 'quotations'},
            {name: 'Quotation Product', value: 'quotationProducts'},
            {name: 'Return Product', value: 'returnProducts'},
            {name: 'Signature', value: 'signatures'},
            {name: 'Signature Use Department', value: 'signatureUseDepartments'},
            {name: 'SMS Settings', value: 'smsSettings'},
            {name: 'Tax', value: 'taxes'},
            {name: 'Transfer', value: 'transfers'},
            {name: 'Unit', value: 'units'},
            {name: 'Unit Category', value: 'unitCategories'},
            {name: 'Unused Product', value: 'unusedProducts'},
            {name: 'User', value: 'users'},
            {name: 'Vendor', value: 'vendors'},
        ],
        createProgress: false,
        search: '',
        progressL: false,
        validated: false,
        rules: {},
    }),

    async created() {
        this.loadItems();
        this.loadPermissions();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.getRolePermissions(this.$route.params.name);
            if (res.success === true) {
                this.role = res.data;
                this.rolePermissions = res.data.permissions;
            }
        },
        async loadPermissions() {
            let res = await ApiServices.getAllPermissions();
            if (res.success === true) {
                this.permissions = res.data;
            }
        },

        async updatePermission(permissionName) {
            var index = this.rolePermissions.indexOf(permissionName);
            if (index >= 0) {
                this.rolePermissions.splice(index, 1)
            } else {
                this.rolePermissions.push(permissionName)
            }
        },

        async edit() {
            this.createProgress = true;
            const data = new FormData();
            data.append('permissions', JSON.stringify(this.rolePermissions));
            data.append('id', this.role.id);

            let res = await ApiServices.permissionRoleUpdate(data);
            this.createProgress = false;
            if (res.success === true) {
                route.replace('/roles/');
            }
        },
    }
}
</script>
