<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('bank') }} </strong> {{ show.bank_name }}
                            </CCardHeader>
                            <CCardBody>
                                <CRow>
                                    <CCol md="4">
                                        <h6>{{ $t('bank') +' '+ $t('name') }}: </h6>
                                        <p>{{ show.bank_name }}</p>
                                        <h6>{{ $t('branch') }}: </h6>
                                        <p v-if="show.branch">{{ show.branch }}</p>
                                        <p v-else>----</p>
                                    </CCol>
                                    <CCol md="4">
                                        <h6>{{ $t('account') +' '+ $t('number') }}: </h6>
                                        <p>{{ show.account_no }}</p>
                                        <h6>{{ $t('account') +' '+ $t('name') }}: </h6>
                                        <p>{{ show.account_name }}</p>
                                    </CCol>
                                    <CCol md="4">
                                        <h6>{{ $t('total_balance') }}: </h6>
                                        <p>{{ show.total_balance }}</p>
                                        <h6>{{ $t('current_balance') }}: </h6>
                                        <p>{{ show.current_balance }}</p>
                                    </CCol>
                                </CRow>
                                <hr>
                                <!--                                <v-card>-->
                                <v-card-title>
                                    {{ $t('bank') +' '+ $t('transactions') }}
                                    <v-spacer></v-spacer>
                                </v-card-title>
                                <v-data-table
                                    :headers="headers"
                                    :items="transactions"
                                    sort-by="id"
                                    loading
                                    loading-text="Loading... Please wait..."
                                    :search="search"
                                >
                                    <template v-slot:top>
                                        <v-toolbar
                                            flat
                                        >
                                            <v-row>
                                                <v-col
                                                    cols="12"
                                                    sm="4"
                                                    md="6"
                                                    lg="8"
                                                >
                                                    <v-text-field
                                                        v-model="search"
                                                        append-icon="mdi-magnify"
                                                        :label="$t('search')"
                                                        solo
                                                        hide-details
                                                        max-width="100px"
                                                    ></v-text-field>
                                                </v-col>
                                            </v-row>
                                        </v-toolbar>
                                    </template>
                                    <template v-slot:no-data>
                                        <div>No Data</div>
                                    </template>
                                </v-data-table>
                                <!--                                </v-card>-->
                                <CForm>
                                    <CCardFooter>
                                        <CButton size="sm" color="primary" :to="'/bankAccounts/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.edit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/bankAccounts'">
                                            <CIcon name="cil-ban"/>
                                            {{ $t('button.back') }}
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
        name: "BankAccountShow",

        props: {
            source: String,
        },
        data: () => ({
            cdnURL: config.cdnURL,
            baseURL: config.baseURL,
            show: {
                id: null,
                bank_name: '',
                branch: '',
                account_name: '',
                account_no: '',
                total_balance: '',
                current_balance: '',
            },
            transactions: [],
            search: '',
            headers: [
                {text: i18n.t('id'), value: 'id'},
                {text: i18n.t('amount'), value: 'transaction_amount'},
                {text: i18n.t('type'), value: 'transaction_type'},
            ],
            tableLoad: false,
        }),
        async created() {
            this.loadItems();
        },
        methods: {
            openLink(data) {
                window.open(config.cdnURL + data, `_blank`);
            },
            async loadItems() {
                let res = await ApiServices.bankAccountShow(this.$route.params.id);
                if (res.success === true) {
                    this.show = res.data;
                    this.transactions = res.data.transactions;
                }
            },
        }
    }
</script>
