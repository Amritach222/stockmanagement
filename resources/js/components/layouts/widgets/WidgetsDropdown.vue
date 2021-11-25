<template>
    <CRow>
        <CCol sm="6" lg="3">
            <CWidgetDropdown color="primary" :header=JSON.stringify(settData.product_count)
                             :text="$t('dashboardText.total_number_of_products')">
                <template #default>
                    <CDropdown
                        color="transparent p-0"
                        placement="bottom-end"
                    >
                        <template #toggler-content>
                            <CIcon name="cil-settings"/>
                        </template>
                        <CDropdownItem>{{ $t('action') }}</CDropdownItem>
                    </CDropdown>
                </template>
                <template #footer>
                    <CChartLineSimple
                        pointed
                        class="mt-3 mx-3"
                        style="height:70px"
                        :data-points="[65, 59, 84, 84, 51, 55, 40]"
                        point-hover-background-color="primary"
                        :label="$t('products')"
                        labels="months"
                    />
                </template>
            </CWidgetDropdown>
        </CCol>
        <CCol sm="6" lg="3">
            <CWidgetDropdown color="info" :header=JSON.stringify(settData.category_count)
                             :text="$t('dashboardText.total_number_of_categories')">
                <template #default>
                    <CDropdown
                        color="transparent p-0"
                        placement="bottom-end"
                        :caret="false"
                    >
                        <template #toggler-content>
                            <CIcon name="cil-location-pin"/>
                        </template>
                        <CDropdownItem>{{ $t('action') }}</CDropdownItem>
                    </CDropdown>
                </template>
                <template #footer>
                    <CChartLineSimple
                        pointed
                        class="mt-3 mx-3"
                        style="height:70px"
                        :data-points="[1, 18, 9, 17, 34, 22, 11]"
                        point-hover-background-color="info"
                        :options="{ elements: { line: { tension: 0.00001 }}}"
                        :label="$t('categories')"
                        labels="months"
                    />
                </template>
            </CWidgetDropdown>
        </CCol>
        <CCol sm="6" lg="3">
            <CWidgetDropdown
                color="warning"
                :header=JSON.stringify(settData.brand_count)
                :text="$t('dashboardText.total_number_of_brands')"
            >
                <template #default>
                    <CDropdown
                        color="transparent p-0"
                        placement="bottom-end"
                    >
                        <template #toggler-content>
                            <CIcon name="cil-settings"/>
                        </template>
                        <CDropdownItem>{{ $t('action') }}</CDropdownItem>
                    </CDropdown>
                </template>
                <template #footer>
                    <CChartLineSimple
                        class="mt-3"
                        style="height:70px"
                        background-color="rgba(255,255,255,.2)"
                        :data-points="[78, 81, 80, 45, 34, 12, 40]"
                        :options="{ elements: { line: { borderWidth: 2.5 }}}"
                        point-hover-background-color="warning"
                        :label="$t('brands')"
                        labels="months"
                    />
                </template>
            </CWidgetDropdown>
        </CCol>
        <v-container v-if="can('items')">
            hello
            </v-container>
            <CCol sm="6" lg="3">
                <CWidgetDropdown
                    color="danger"
                    :header=JSON.stringify(settData.item_count)
                    :text="$t('dashboardText.total_number_of_items')"
                >
                    <template #default>
                        <CDropdown
                            color="transparent p-0"
                            placement="bottom-end"
                        >
                            <template #toggler-content>
                                <CIcon name="cil-settings"/>
                            </template>
                            <CDropdownItem>{{ $t('action') }}</CDropdownItem>
                        </CDropdown>
                    </template>
                    <template #footer>
                        <CChartBarSimple
                            class="mt-3 mx-3"
                            style="height:70px"
                            background-color="rgb(250, 152, 152)"
                            :label="$t('items')"
                            labels="months"
                        />
                    </template>
                </CWidgetDropdown>
            </CCol>
<!--        </div>-->
    </CRow>
</template>

<script>
import {CChartLineSimple, CChartBarSimple} from './charts/index.js'
import permissions from '../../../permissions'
import Vue from "vue";
import ApiServices from "../../../services/ApiServices";

export default {
    name: 'WidgetsDropdown',
    props: ['settData'],
    components: {CChartLineSimple, CChartBarSimple},
    methods:{
        async can(permission){
            if(Vue.prototype.$permissions !== []) {
                let isLoggedIn = localStorage.getItem('isLoggedIn');
                if (isLoggedIn === 'true') {
                    let res = await ApiServices.getUserPermissions();
                    if (res.success === true) {
                        Vue.prototype.$permissions = res.data;
                    } else {
                        Vue.prototype.$permissions = [];
                    }
                } else {
                    Vue.prototype.$permissions = [];
                }
            }
            let status = Vue.prototype.$permissions.indexOf(permission) !== -1;
            console.log(status)
            return status;
        }
    }
}
</script>
