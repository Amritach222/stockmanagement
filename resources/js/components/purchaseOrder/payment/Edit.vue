<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Bill
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
                                        <v-row>
                                            <v-col md="9">
                                                <v-row>
                                                    <v-col md="4">
                                                        <v-text-field
                                                            v-model="editedItem.due_date"
                                                            description="Please due date."
                                                            autocomplete=""
                                                            label="Due Date"
                                                            prepend-inner-icon="mdi-calender"
                                                            placeholder="Enter due date..."
                                                            type="date"
                                                            required
                                                            solo
                                                        >
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>
                                            </v-col>
                                        </v-row>
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" @click="edit" color="primary">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger"
                                                 :to="'/purchaseOrders/payment/'+editedItem.id">
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
    import config from "../../../config";
    import ApiServices from "../../../services/ApiServices";
    import countryList from "../../../services/lib/country.json";
    import stateList from "../../../services/lib/state.json";
    import cityList from "../../../services/lib/city.json";

    export default {
        name: "PurchaseOrderBillEdit",

        props: {
            source: String,
        },
        data() {
            return {
                cdnURL: config.cdnURL,
                baseURL: config.baseURL,
                users: [],
                categories: [],
                editedItem: {
                    id: null,
                    due_date: '',
                },
                show1: false,
                show2: false,
                countries: [],
                states: [],
                cities: [],
                emailValidation: false,
                usernameValidation: false,
                status: [
                    {name: 'Active', value: 1},
                    {name: 'Inactive', value: 0}
                ],
                createProgress: false,
            };
        },
        async created() {
            this.loadData();
            this.countries = countryList;
        },
        methods: {
            openImage(data) {
                window.open(config.cdnURL + data, `_blank`);
            },

            async loadData() {
                let res = await ApiServices.paymentShow(this.$route.params.id);
                if (res.success === true) {
                    this.editedItem = res.data;
                }
            },

            async edit() {
                this.createProgress = true;
                const data = new FormData();
                if (this.editedItem.due_date !== null && this.editedItem.due_date !== '') {
                    data.append('due_date', this.editedItem.due_date);
                }

                let res = await ApiServices.paymentEdit(this.editedItem.id, data);
                this.createProgress = false;
                if (res.success === true) {
                    route.replace('/purchaseOrders/payment/' + this.editedItem.id);
                }
            },
        }
    }
</script>
<style scoped>
    .notify-validation {
        color: #f65050;
    }
</style>
