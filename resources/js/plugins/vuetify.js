/**
 * Created by Samundra.
 * Date: 15/09/2021
 */
import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import Vuetify from 'vuetify'

Vue.use(Vuetify)

export default new Vuetify({
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },
})
