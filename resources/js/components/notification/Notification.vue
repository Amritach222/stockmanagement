<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t(name) }}</strong>
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
                                                <!--                                                <thead>-->
                                                <!--                                                <tr>-->
                                                <!--                                                    <th class="text-left">-->
                                                <!--                                                        Permissions / Actions-->
                                                <!--                                                    </th>-->
                                                <!--                                                    <th class="text-left">-->
                                                <!--                                                        List-->
                                                <!--                                                    </th>-->
                                                <!--                                                    <th class="text-left">-->
                                                <!--                                                        Create-->
                                                <!--                                                    </th>-->
                                                <!--                                                    <th class="text-left">-->
                                                <!--                                                        Edit-->
                                                <!--                                                    </th>-->
                                                <!--                                                    <th class="text-left">-->
                                                <!--                                                        Show-->
                                                <!--                                                    </th>-->
                                                <!--                                                    <th class="text-left">-->
                                                <!--                                                        Delete-->
                                                <!--                                                    </th>-->
                                                <!--                                                </tr>-->
                                                <!--                                                </thead>-->
                                                <tbody>
                                                <tr
                                                    v-for="item in items"
                                                    :key="item.name"
                                                >
                                                    <td v-on:click="redirectNotification(item.notification.id)">{{
                                                        item.title }}
                                                    </td>
                                                    <!--                                                    <td>-->
                                                    <!--                                                        <div v-if="permissions.indexOf(item.value) !== -1">-->
                                                    <!--                                                            <v-checkbox-->
                                                    <!--                                                                :input-value="rolePermissions.indexOf(item.value) !== -1"-->
                                                    <!--                                                                type="checkbox"-->
                                                    <!--                                                                autocomplete=""-->
                                                    <!--                                                                v-on:click="updatePermission(item.value)"-->
                                                    <!--                                                                solo-->
                                                    <!--                                                            />-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </td>-->
                                                    <!--                                                    <td>-->
                                                    <!--                                                        <div v-if="permissions.indexOf(item.value + '.create') !== -1">-->
                                                    <!--                                                            <v-checkbox-->
                                                    <!--                                                                :input-value="rolePermissions.indexOf(item.value + '.create') !== -1"-->
                                                    <!--                                                                type="checkbox"-->
                                                    <!--                                                                autocomplete=""-->
                                                    <!--                                                                v-on:click="updatePermission(item.value+'.create')"-->
                                                    <!--                                                                solo-->
                                                    <!--                                                            />-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </td>-->
                                                    <!--                                                    <td>-->
                                                    <!--                                                        <div v-if="permissions.indexOf(item.value + '.edit') !== -1">-->
                                                    <!--                                                            <v-checkbox-->
                                                    <!--                                                                :input-value="rolePermissions.indexOf(item.value+'.edit') !== -1"-->
                                                    <!--                                                                type="checkbox"-->
                                                    <!--                                                                autocomplete=""-->
                                                    <!--                                                                solo-->
                                                    <!--                                                                v-on:click="updatePermission(item.value+'.edit')"-->
                                                    <!--                                                            />-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </td>-->
                                                    <!--                                                    <td>-->
                                                    <!--                                                        <div v-if="permissions.indexOf(item.value + '.show') !== -1">-->
                                                    <!--                                                            <v-checkbox-->
                                                    <!--                                                                :input-value="rolePermissions.indexOf(item.value+'.show') !== -1"-->
                                                    <!--                                                                type="checkbox"-->
                                                    <!--                                                                autocomplete=""-->
                                                    <!--                                                                v-on:click="updatePermission(item.value+'.show')"-->
                                                    <!--                                                                solo-->
                                                    <!--                                                            />-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </td>-->
                                                    <!--                                                    <td>-->
                                                    <!--                                                        <div v-if="permissions.indexOf(item.value + '.delete') !== -1">-->
                                                    <!--                                                            <v-checkbox-->
                                                    <!--                                                                :input-value="rolePermissions.indexOf(item.value+'.delete') !== -1"-->
                                                    <!--                                                                type="checkbox"-->
                                                    <!--                                                                autocomplete=""-->
                                                    <!--                                                                v-on:click="updatePermission(item.value+'.delete')"-->
                                                    <!--                                                                solo-->
                                                    <!--                                                            />-->
                                                    <!--                                                        </div>-->
                                                    <!--                                                    </td>-->
                                                </tr>
                                                </tbody>
                                            </template>
                                        </v-simple-table>
                                    </v-form>

                                    <!--                                    <CCardFooter>-->
                                    <!--                                        <CButton type="submit" size="sm" color="primary" @click="edit">-->
                                    <!--                                            <CIcon name="cil-check-circle"/>-->
                                    <!--                                            {{ $t('button.submit') }}-->
                                    <!--                                        </CButton>-->
                                    <!--                                        <CButton size="sm" color="danger" :to="'/users'">-->
                                    <!--                                            <CIcon name="cil-ban"/>-->
                                    <!--                                            {{ $t('button.cancel') }}-->
                                    <!--                                        </CButton>-->
                                    <!--                                    </CCardFooter>-->
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
    import store from "../../store";
    import route from "../../router";
    import i18n from "../../i18n";
    import ApiServices from "../../services/ApiServices";
    import config from "../../config";

    export default {
        name: "Notification",

        props: {
            source: String,
        },
        data: () => ({
            cdnURL: config.cdnURL,
            baseURL: config.baseURL,
            name: '',
            items: [],
            createProgress: false,
            search: '',
            progressL: false,
            validated: false,
            rules: {},
        }),

        async created() {
            this.loadItems();
            this.name = this.$route.params.type;
        },
        methods: {
            async loadItems() {
                var type = '';
                if (this.$route.params.type === 'quotation') {
                    type = 'Quotation';
                } else {
                    type = 'Purchase';
                }
                let res = await ApiServices.getNotifications(type);
                if (res.success === true) {
                    this.items = res.data;
                }
            },

            async redirectNotification(id) {
                let res = await ApiServices.redirectNotification(id);
                if (res.success === true) {
                    route.replace(res.data);
                }
            }
        }
    }
</script>
