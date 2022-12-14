/**
 * Created by Samundra.
 * Date: 15/09/2021
 */
import 'core-js/stable'
import Vue from 'vue'
import Vuex from 'vuex'
import auth from './components/auth'
import home from './components/home'
import sidebar from './components/sidebar'
import products from './components/products'
import settings from './components/settings'
import vendors from './components/vendors'
import budgets from './components/budgets'
import bankAccounts from './components/bankAccounts'
import expenses from './components/expenses'
import purchase from './components/purchase'
import {iconsSet as icons} from '../assets/icons/icons.js'

Vue.use(Vuex)

const store = new Vuex.Store({

    namespaced: true,

    modules: {
        auth: auth,
        home: home,
        sidebar: sidebar,
        products: products,
        settings: settings,
        vendors: vendors,
        budgets: budgets,
        bankAccounts: bankAccounts,
        expenses: expenses,
        purchase: purchase,
        icons,
    },
})

export default store
