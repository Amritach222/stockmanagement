<template>
    <CRow v-if="!$is('Vendor')">
        <CCol sm="6" lg="3">
            <CWidgetDropdown color="primary" :header=JSON.stringify(settData.product_count) text="Total Number of Products">
                <template #default>
                    <CDropdown
                        color="transparent p-0"
                        placement="bottom-end"
                    >
                        <template #toggler-content>
                            <CIcon name="cil-settings"/>
                        </template>
                        <CDropdownItem>Action</CDropdownItem>
                    </CDropdown>
                </template>
                <template #footer>
                    <CChartLineSimple
                        pointed
                        class="mt-3 mx-3"
                        style="height:70px"
                        :data-points="[65, 59, 84, 84, 51, 55, 40]"
                        point-hover-background-color="primary"
                        label="Products"
                        labels="months"
                    />
                </template>
            </CWidgetDropdown>
        </CCol>
        <CCol sm="6" lg="3">
            <CWidgetDropdown color="info" :header=JSON.stringify(settData.category_count) text="Total Number of Category">
                <template #default>
                    <CDropdown
                        color="transparent p-0"
                        placement="bottom-end"
                        :caret="false"
                    >
                        <template #toggler-content>
                            <CIcon name="cil-location-pin"/>
                        </template>
                        <CDropdownItem>Action</CDropdownItem>
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
                        label="Categories"
                        labels="months"
                    />
                </template>
            </CWidgetDropdown>
        </CCol>
        <CCol sm="6" lg="3">
            <CWidgetDropdown
                color="warning"
                :header=JSON.stringify(settData.brand_count)
                text="Total Number of Brands"
            >
                <template #default>
                    <CDropdown
                        color="transparent p-0"
                        placement="bottom-end"
                    >
                        <template #toggler-content>
                            <CIcon name="cil-settings"/>
                        </template>
                        <CDropdownItem>Action</CDropdownItem>
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
                        label="Brands"
                        labels="months"
                    />
                </template>
            </CWidgetDropdown>
        </CCol>
        <CCol sm="6" lg="3">
            <CWidgetDropdown
                color="danger"
                :header=JSON.stringify(settData.item_count)
                text="Total Number of Items"
            >
                <template #default>
                    <CDropdown
                        color="transparent p-0"
                        placement="bottom-end"
                    >
                        <template #toggler-content>
                            <CIcon name="cil-settings"/>
                        </template>
                        <CDropdownItem>Action</CDropdownItem>
                    </CDropdown>
                </template>
                <template #footer>
                    <CChartBarSimple
                        class="mt-3 mx-3"
                        style="height:70px"
                        background-color="rgb(250, 152, 152)"
                        label="Items"
                        labels="months"
                    />
                </template>
            </CWidgetDropdown>
        </CCol>
    </CRow>
</template>

<script>
import {CChartLineSimple, CChartBarSimple} from './charts/index.js'

export default {
    name: 'WidgetsDropdown',
    props: ['settData'],
    components: {CChartLineSimple, CChartBarSimple}
}
</script>
