import i18n from "../../i18n";
export default [
    {
        _name: 'CSidebarNav',
        _children: [
            {
                _name: 'CSidebarNavItem',
                name: i18n.t('dashboard'),
                to: '/home',
                icon: 'cil-speedometer',
                badge: {
                    color: 'primary',
                    text: 'NEW'
                }
            },
            {
                _name: 'CSidebarNavTitle',
                _children: ['Components']
            },
            {
                _name: 'CSidebarNavItem',
                name: 'Vendor',
                to: '/vendors',
                icon: 'cil-cursor',
                // badge: {
                //     color: 'primary',
                //     text: 'NEW'
                // }
            },
            {
                _name: 'CSidebarNavDropdown',
                name: 'Products',
                icon: 'cil-star',
                items: [
                    {
                        name: 'Category',
                        to: '/categories'
                    },
                    {
                        name: 'Product',
                        to: '/products'
                    },
                    {
                        name: 'Item Attribute Group',
                        to: '/itemAttributeGroups'
                    },
                    {
                        name: 'Item Attribute',
                        to: '/itemAttributes'
                    },
                    {
                        name: 'Item',
                        to: '/items'
                    }
                ]
            },
            {
                _name: 'CSidebarNavDropdown',
                name: 'Budgets',
                icon: 'cil-calculator',
                items: [
                    {
                        name: 'Budget',
                        to: '/budgets'
                    },
                    {
                        name: 'Budget Request',
                        to: '/budgetRequests'
                    },
                    {
                        name: 'Budget Limit',
                        to: '/budgetLimits'
                    },
                    {
                        name: 'Budget Extend',
                        to: '/budgetExtends'
                    },
                    {
                        name: 'Freeze Budget',
                        to: '/freezeBudgets'
                    },
                ]
            },
            {
                _name: 'CSidebarNavDropdown',
                name: 'Bank Accounts',
                icon: 'cil-calculator',
                items: [
                    {
                        name: 'Bank Account',
                        to: '/bankAccounts'
                    },
                    {
                        name: 'Bank Account Transaction',
                        to: '/bankAccountTransactions'
                    },
                ]
            },
            {
                _name: 'CSidebarNavDropdown',
                name: 'Expenses',
                icon: 'cil-calculator',
                items: [
                    {
                        name: 'Expense Category',
                        to: '/expenseCategories'
                    },
                    {
                        name: 'Expense',
                        to: '/expenses'
                    },
                ]
            },
            {
                _name: 'CSidebarNavDropdown',
                name: 'Quotations',
                icon: 'cil-star',
                items: [
                    {
                        name: 'Quotation',
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
                name: 'Settings',
                icon: 'cil-bell',
                items: [
                    {
                        name: 'Brand',
                        to: '/brands'
                    },
                    {
                        name: 'Unit',
                        to: '/units'
                    },
                    {
                        name: 'Tax',
                        to: '/taxes'
                    },
                    {
                        name: 'General Setting',
                        to: '/settings/'
                    },
                    {
                        name: 'Mail Setting',
                        to: '/mailSettings/'
                    },
                    {
                        name: 'Sms Setting',
                        to: '/smsSettings/'
                    },
                    {
                        name: 'Mail Template',
                        to: '/mailTemplates/'
                    },
                    {
                        name: 'Department',
                        to: '/departments/'
                    },
                    {
                        name: 'Designation',
                        to: '/designations/'
                    },
                    {
                        name: 'Fiscal Year',
                        to: '/fiscalYears/'
                    },
                    {
                        name: 'Signature',
                        to: '/signatures/'
                    },
                    {
                        name: 'Signature Use Department',
                        to: '/signatureUseDepartments/'
                    },
                    {
                        name: 'Profile Setting',
                        to: '/profile-setting/'
                    },
                ]
            },
        ]
    }
]
