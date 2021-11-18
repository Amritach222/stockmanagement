<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Expense </strong> {{ show.reference_no }}
                            </CCardHeader>
                            <CCardBody>
                                <CRow>
                                    <CCol md="4">
                                        <h6>User: </h6>
                                        <p v-if="show.user_id">{{ show.user.name }}</p>
                                        <p v-else>---</p>
                                        <h6>Department: </h6>
                                        <p v-if="show.department_id">{{ show.department.name }}</p>
                                        <p v-else>----</p>
                                        <h6>Expense Category: </h6>
                                        <p>{{ show.expense_category.name }}</p>
                                    </CCol>
                                    <CCol md="4">
                                        <h6>Amount: </h6>
                                        <p>{{ show.amount }}</p>
                                        <h6>Transaction Type: </h6>
                                        <p>{{ show.transaction_type }}</p>
                                        <div v-if="show.transaction_type === 'OnlineTransaction' || show.transaction_type=== 'Cheque'">
                                        <h6>Bank Account: </h6>
                                        <p>{{ show.bank_account.bank_name }}</p>
                                        </div>
                                        <div v-if="show.transaction_type === 'Cheque'">
                                            <h6>Cheque No:</h6>
                                            <p>{{ show.cheque_no }}</p>
                                        </div>
                                    </CCol>
                                    <CCol md="4">
                                        <h6>Note: </h6>
                                        <p>{{ show.note }}</p>
                                        <h6>Status: </h6>
                                        <div v-if="show.status === 'Pending'" class="mb-2">
                                            <CButton size="sm" color="secondary">
                                                {{ show.status }}
                                            </CButton>
                                        </div>
                                        <div v-else-if="show.status === 'Approved'" class="mb-2">
                                            <CButton size="sm" color="success">
                                                {{ show.status }}
                                            </CButton>
                                        </div>
                                        <div v-else-if="show.status === 'Rejected'" class="mb-2">
                                            <CButton size="sm" color="danger">
                                                {{ show.status }}
                                            </CButton>
                                        </div>
                                        <h6>File: </h6>
                                        <div v-if="show.link"
                                             v-on:click="openLink(show.link)"
                                             class="file-link"
                                        >
                                            Open File
                                            <v-icon
                                                small
                                            >
                                                mdi-arrow-right
                                            </v-icon>
                                        </div>
                                    </CCol>
                                </CRow>

                                <CForm>
                                    <CCardFooter>
                                        <CButton size="sm" color="primary" :to="'/expenses/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            Edit
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/expenses'">
                                            <CIcon name="cil-ban"/>
                                            Back
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
    import route from "../../../router";
    import i18n from "../../../i18n";
    import ApiServices from "../../../services/ApiServices";
    import config from "../../../config";

    export default {
        name: "ExpenseShow",

        props: {
            source: String,
        },
        data: () => ({
            cdnURL: config.cdnURL,
            baseURL: config.baseURL,
            show: {
                id: null,
                user_id: '',
                department_id: '',
                expense_category_id: '',
                amount: '',
                transaction_type: '',
                bank_account_id: '',
                cheque_no: '',
                reference_no: '',
                status: '',
                note: '',
                file_id: '',
            },
        }),
        async created() {
            this.loadItems();
        },
        methods: {
            openLink(data) {
                window.open(config.cdnURL + data, `_blank`);
            },
            async loadItems() {
                let res = await ApiServices.expenseShow(this.$route.params.id);
                if (res.success === true) {
                    this.show = res.data;
                }
            },
        }
    }
</script>
<style scoped>
    .file-link{
        cursor: pointer;
        font-weight: 600;
        background-color: rgba(222, 204, 3, 0.99);
        width: 50%;
        padding: 4px;
        border-radius: 8px;
    }
</style>
