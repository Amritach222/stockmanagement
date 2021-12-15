<template>
    <CSidebarNav>
        <v-list>
            <v-list-item>
                <v-list-item-icon class="mr-2">
                    <v-icon>mdi-home</v-icon>
                </v-list-item-icon>

                <v-list-item-title>
                    <router-link
                        :to="'/home/'">
                        {{ $t('dashboard') }}
                    </router-link>
                </v-list-item-title>
            </v-list-item>

            <v-list-item>
                <v-list-item-title class="component-title">
                    {{ $t('components') }}
                </v-list-item-title>
            </v-list-item>

            <v-list-item v-if="$can('vendors')">
                <v-list-item-icon class="mr-2">
                    <v-icon>mdi-account-voice</v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    <router-link
                        :to="'/vendors/'">
                        {{ $t('vendor') }}
                    </router-link>
                </v-list-item-title>
            </v-list-item>

            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-currency-usd</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="item-color">{{ $t('budgets') }}</v-list-item-title>
                </template>

                <v-list-item class="ml-3" v-if="$can('budgets')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-cash</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/budgets/'">
                            {{ $t('budget') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('budgetRequests')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-cash-plus</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/budgetRequests/'">
                            {{ $t('budget_request') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('budgetLimits')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-cash-lock</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/budgetLimits/'">
                            {{ $t('budget_limit') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('freezeBudgets')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-cash-remove</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/freezeBudgets/'">
                            {{ $t('freeze_budget') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>
            </v-list-group>

            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-bank</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="item-color">{{ $t('bank') + ' ' + $t('accounts') }}</v-list-item-title>
                </template>

                <v-list-item class="ml-3" v-if="$can('bankAccounts')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-badge-account-horizontal</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/bankAccounts/'">
                            {{ $t('bank') + ' ' + $t('account') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('bankAccountTransactions')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-swap-horizontal</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/bankAccountTransactions/'">
                            {{ $t('bank') + ' ' + $t('account') + ' ' + $t('transaction') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>
            </v-list-group>

            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-chart-areaspline</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="item-color">{{ $t('expenses') }}</v-list-item-title>
                </template>

                <v-list-item class="ml-3" v-if="$can('expenseCategories')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-graph</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/expenseCategories/'">
                            {{ $t('expense') + ' ' + $t('category') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('expenses')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-chart-bell-curve-cumulative</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/expenses/'">
                            {{ $t('expense') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>
            </v-list-group>

            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-inbox-multiple</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="ml-2 item-color">{{ $t('products') }}</v-list-item-title>
                </template>

                <v-list-item class="ml-3" v-if="$can('categories')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-shape</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/categories/'">
                            {{ $t('category') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('attributeGroups')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-select-group</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/productAttributeGroups/'">
                            {{ $t('product_attribute_group') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('attributes')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-rhombus-split</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/productAttributes/'">
                            {{ $t('product_attribute') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('products')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-alpha-p-box</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/products/'">
                            {{ $t('product') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('items')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-toolbox</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/items/'">
                            {{ $t('item') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>
            </v-list-group>

            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-account-cash</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="ml-2 item-color">{{ $t('purchases') }}</v-list-item-title>
                </template>

                <v-list-item class="ml-3" v-if="$can('purchases')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-shield-plus</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/purchase/new-purchase-request/'">
                            {{ $t('new') +' '+ $t('purchase') +' '+ $t('request') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-shield-refresh</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/purchase/purchase-request-history/'">
                            {{ $t('purchase') +' '+ $t('request') +' '+ $t('history') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>
            </v-list-group>

            <v-list-group>
                <template v-slot:activator>
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-clipboard-text</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="item-color">{{ $t('quotations') }}</v-list-item-title>
                </template>

                <v-list-item class="ml-3" v-if="$can('quotations')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-alpha-q-circle</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/quotations/'">
                            {{ $t('quotation') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>
            </v-list-group>

            <v-list-group
            >
                <template v-slot:activator>
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-cogs</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title class="item-color">{{ $t('settings') }}</v-list-item-title>
                </template>

                <v-list-item class="ml-3" v-if="$can('brands')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-alpha-b-circle</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/brands/'">
                            {{ $t('brand') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('departments')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-vector-square</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/departments/'">
                            {{ $t('department') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('designations')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-account-network</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/designations/'">
                            {{ $t('designation') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('fiscalYears')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-calendar</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/fiscalYears/'">
                            {{ $t('fiscal_year') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('mailTemplates')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-email-newsletter</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/mailTemplates/'">
                            {{ $t('mail') + ' ' + $t('template') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('signatures')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-draw</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/signatures/'">
                            {{ $t('signature') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('signatureUseDepartments')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-account-edit</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/signatureUseDepartments/'">
                            {{ $t('signature') + ' ' + $t('use') + ' ' + $t('department') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('taxes')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-sack-percent</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/taxes/'">
                            {{ $t('tax') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('unitCategories')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-scale</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/unitCategories/'">
                            {{ $t('unit') +' '+ $t('category') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('units')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-scale-balance</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/units/'">
                            {{ $t('unit') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('settings.edit')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-cog</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/settings/'">
                            {{ $t('general_setting') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('mailSettings.edit')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-message-cog</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/mailSettings/'">
                            {{ $t('mail') + ' ' + $t('settings') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3" v-if="$can('smsSettings.edit')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-cellphone-cog</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/smsSettings/'">
                            {{ $t('sms') + ' ' + $t('settings') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>

                <v-list-item class="ml-3">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-account-cog</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        <router-link
                            :to="'/profile-setting/'">
                            {{ $t('profile') + ' ' + $t('settings') }}
                        </router-link>
                    </v-list-item-title>
                </v-list-item>
            </v-list-group>
        </v-list>
    </CSidebarNav>
</template>
<script>
export default {
    name: 'SidebarNavItem',
}
</script>
<style scoped>
.theme--light.v-list {
    background: #3c4b64 !important;
    color: rgb(251 248 248) !important;
}

.theme--light.v-list-item:not(.v-list-item--active):not(.v-list-item--disabled) {
    color: rgb(251 248 248) !important;
}

a {
    color: rgb(251 248 248) !important;
}

.v-list-group {
    color: rgb(251 248 248) !important;
}

.component-title {
    font-weight: 600;
}

.theme--light.v-icon {
    color: rgb(251 248 248) !important;
}

.item-color {
    color: rgb(251 248 248) !important;
}
</style>
