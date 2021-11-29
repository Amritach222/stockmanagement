import i18n from "../../i18n";
import permissions from "../../permissions";
export default {
    mounted() {
        this.$root.$on('navData', () => {
            this.$forceUpdate();
        })
    },
    data:[{
        _name: 'CSidebarNav',
        _children: [
            {
                _name: 'CSidebarNavItem',
                name: i18n.t('dashboard'),
                to: '/home',
                icon: 'cil-speedometer',
                badge: {
                    color: 'primary',
                    text: i18n.t('new')
                }
            },
            {
                _name: 'CSidebarNavTitle',
                _children: [i18n.t('components')]
            },
            {
                _name: 'CSidebarNavItem',
                name: i18n.t('vendor'),
                to: '/vendors',
                icon: 'cil-cursor',
                // badge: {
                //     color: 'primary',
                //     text: 'NEW'
                // }
            },
            {
                _name: 'CSidebarNavDropdown',
                name: i18n.t('products'),
                icon: 'cil-star',
                items: [
                    {
                        name: i18n.t('category'),
                        to: '/categories'
                    },
                    {
                        name: i18n.t('product'),
                        to: '/products'
                    },
                    {
                        name: i18n.t('item_attribute_group'),
                        to: '/itemAttributeGroups'
                    },
                    {
                        name: i18n.t('item_attribute'),
                        to: '/itemAttributes'
                    },
                    {
                        name: i18n.t('item'),
                        to: '/items'
                    }
                ]
            },
            {
                _name: 'CSidebarNavDropdown',
                name: i18n.t('budgets'),
                icon: 'cil-calculator',
                items: [
                    {
                        show: false,
                        name: i18n.t('budget'),
                        to: '/budgets'
                    },
                    {
                        name: i18n.t('budget_request'),
                        to: '/budgetRequests'
                    },
                    {
                        name: i18n.t('budget_limit'),
                        to: '/budgetLimits'
                    },
                    {
                        name: i18n.t('freeze_budget'),
                        to: '/freezeBudgets'
                    },
                ]
            },
            {
                _name: 'CSidebarNavDropdown',
                name: i18n.t('bank') + ' ' + i18n.t('accounts'),
                icon: 'cil-calculator',
                items: [
                    {
                        name: i18n.t('bank') + ' ' + i18n.t('account'),
                        to: '/bankAccounts'
                    },
                    {
                        name: i18n.t('bank') + ' ' + i18n.t('account') + ' ' + i18n.t('transaction'),
                        to: '/bankAccountTransactions'
                    },
                ]
            },
            {
                _name: 'CSidebarNavDropdown',
                name: i18n.t('expenses'),
                icon: 'cil-calculator',
                items: [
                    {
                        name: i18n.t('expense') + ' ' + i18n.t('category'),
                        to: '/expenseCategories'
                    },
                    {
                        name: i18n.t('expense'),
                        to: '/expenses'
                    },
                ]
            },
            {
                _name: 'CSidebarNavDropdown',
                name: i18n.t('quotations'),
                icon: 'cil-star',
                items: [
                    {
                        name: i18n.t('quotation'),
                        to: '/quotations'
                    },
                    // {
                    //     name: 'Quotation',
                    //     to: '/expenses'
                    // },
                ]
            },
            {
                _name: 'CSidebarNavDropdown',
                name: i18n.t('settings'),
                icon: 'cil-bell',
                items: [
                    {
                        name: i18n.t('brand'),
                        to: '/brands'
                    },
                    {
                        name: i18n.t('unit'),
                        to: '/units'
                    },
                    {
                        name: i18n.t('tax'),
                        to: '/taxes'
                    },
                    {
                        name: i18n.t('general_setting'),
                        to: '/settings/'
                    },
                    {
                        name: i18n.t('mail') + ' ' + i18n.t('settings'),
                        to: '/mailSettings/'
                    },
                    {
                        name: i18n.t('sms') + ' ' + i18n.t('settings'),
                        to: '/smsSettings/'
                    },
                    {
                        name: i18n.t('mail') + ' ' + i18n.t('template'),
                        to: '/mailTemplates/'
                    },
                    {
                        name: i18n.t('department'),
                        to: '/departments/'
                    },
                    {
                        name: i18n.t('designation'),
                        to: '/designations/'
                    },
                    {
                        name: i18n.t('fiscal_year'),
                        to: '/fiscalYears/'
                    },
                    {
                        name: i18n.t('signature'),
                        to: '/signatures/'
                    },
                    {
                        name: i18n.t('signature') + ' ' + i18n.t('use') + ' ' + i18n.t('department'),
                        to: '/signatureUseDepartments/'
                    },
                    {
                        name: i18n.t('profile') + ' ' + i18n.t('settings'),
                        to: '/profile-setting/'
                    },
                ]
            },
        ]
    }],
}
