<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('budget') }} </strong> {{ show.title }}
                            </CCardHeader>
                            <CCardBody>
                                <CRow>
                                    <CCol md="4">
                                        <h6>{{ $t('title') }}: </h6>
                                        <p>{{ show.title }}</p>
                                        <h6>{{ $t('fiscal_year') }}: </h6>
                                        <p v-if="show.fiscal_year_id">{{ show.fiscal_year.name }}</p>
                                        <p v-else>----</p>
                                        <h6>{{ $t('type') }}: </h6>
                                        <p>{{ show.type }}</p>
                                    </CCol>
                                    <CCol md="4">
                                        <h6>{{ $t('allocated_budget') + ' ' + $t('amount') }}: </h6>
                                        <p>{{ show.allocated_budget_amount }}</p>
                                        <h6>{{ $t('initial_dispatched') + ' ' + $t('amount') }}: </h6>
                                        <p>{{ show.initial_dispatched_amount }}</p>
                                        <h6>{{ $t('total_dispatched') + ' ' + $t('amount') }}: </h6>
                                        <p>{{ show.total_dispatched_amount }}</p>
                                    </CCol>
                                    <CCol md="4">
                                        <h6>{{ $t('date_first_received') }}: </h6>
                                        <p>{{ show.date_first_received }}</p>
                                        <h6>{{ $t('remarks') }}: </h6>
                                        <p>{{ show.remarks }}</p>
                                        <h6>{{ $t('file') }}: </h6>
                                        <div v-if="show.link"
                                             v-on:click="openLink(show.link)"
                                             class="file-link"
                                        >
                                            {{ $t('open_file') }}
                                            <v-icon
                                                small
                                            >
                                                mdi-arrow-right
                                            </v-icon>
                                        </div>
                                    </CCol>
                                </CRow>
                                <hr>
                                <!--                                <v-card>-->
                                <v-card-title>
                                    {{ $t('dispatched_amounts') }}
                                    <v-spacer></v-spacer>
                                </v-card-title>
                                <v-data-table
                                    :headers="headers"
                                    :items="dispatchedAmounts"
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
                                        <CButton size="sm" color="primary" :to="'/budgets/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.edit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/budgets'">
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
    name: "BudgetShow",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        show: {
            id: null,
            title: '',
            department_id: '',
            fiscal_year_id: '',
            allocated_budget_amount: '',
            initial_dispatched_amount: '',
            total_dispatched_amount: '',
            date_first_received: '',
            remarks: '',
            file_id: '',
        },
        dispatchedAmounts: [],
        search: '',
        headers: [
            {text: i18n.t('id'), value: 'id'},
            {text: i18n.t('amount'), value: 'amount'},
            {text: i18n.t('date'), value: 'dispatched_date'},
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
            let res = await ApiServices.budgetShow(this.$route.params.id);
            if (res.success === true) {
                this.show = res.data;
                this.dispatchedAmounts = res.data.dispatched_amounts;
            }
        },
    }
}
</script>
<style scoped>
.file-link {
    cursor: pointer;
    font-weight: 600;
    background-color: rgba(222, 204, 3, 0.99);
    width: 50%;
    padding: 4px;
    border-radius: 8px;
}
</style>
