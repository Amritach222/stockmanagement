<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('budget_request') }} </strong> {{ show.fiscal_year.name }}
                            </CCardHeader>
                            <CCardBody>
                                <CRow>
                                    <CCol md="4">
                                        <h6>{{ $t('user') }}: </h6>
                                        <p v-if="show.user_id">{{ show.user.name }}</p>
                                        <p v-else>----</p>
                                        <h6>{{ $t('department') }}: </h6>
                                        <p v-if="show.department_id">{{ show.department.name }}</p>
                                        <p v-else>----</p>
                                        <h6>{{ $t('fiscal_year') }}: </h6>
                                        <p v-if="show.fiscal_year_id">{{ show.fiscal_year.name }}</p>
                                        <p v-else>----</p>
                                    </CCol>
                                    <CCol md="4">
                                        <h6>{{ $t('type') }}: </h6>
                                        <p>{{ show.type }}</p>
                                        <h6>{{ $t('requested') +' '+ $t('amount') }}: </h6>
                                        <p v-if="show.request_amount">{{ show.request_amount }}</p>
                                        <p v-else>----</p>
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
                                        <div v-else>
                                            ---
                                        </div>
                                    </CCol>
                                    <CCol md="4">
                                        <h6>{{ $t('status') }}: </h6>
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
                                        <h6>{{ $t('approver') }}: </h6>
                                        <p v-if="show.approved_by">{{ show.approver.name }}</p>
                                        <p v-else>----</p>
                                        <h6>{{ $t('remarks') }}: </h6>
                                        <p v-if="show.remarks">{{ show.remarks }}</p>
                                        <p v-else>----</p>
                                    </CCol>
                                </CRow>
                                <hr>
                                <!--                                <v-card>-->
                                <v-card-title>
                                    {{ $t('request_category_amount_division') }}
                                    <v-spacer></v-spacer>
                                </v-card-title>
                                <v-data-table
                                    :headers="headers"
                                    :items="categories"
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
                                    <template v-slot:item.category_id="{ item }">
                                        <p v-if="item.category_id" class="mt-3">{{ item.category.name }}</p>
                                        <p v-else>---</p>
                                    </template>
                                    <template v-slot:item.amount="{ item }">
                                        <p v-if="item.amount" class="mt-3">{{ item.amount }}</p>
                                        <p v-else>---</p>
                                    </template>
                                    <template v-slot:item.note="{ item }">
                                        <p v-if="item.note" class="mt-3">{{ item.note }}</p>
                                        <p v-else>---</p>
                                    </template>
                                    <template v-slot:no-data>
                                        <div>No Data</div>
                                    </template>
                                </v-data-table>
                                <!--                                </v-card>-->
                                <CForm>
                                    <CCardFooter>
                                        <CButton size="sm" color="primary" :to="'/budgetRequests/edit/'+show.id">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.edit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/budgetRequests'">
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
    name: "BudgetRequestShow",

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
            fiscal_year_id: '',
            request_amount: '',
            type: '',
            status: '',
            approved_by: '',
            remarks: '',
            file_id: '',
            user:[],
            department:[],
            fiscal_year:[],
            approver:[],
        },
        categories: [],
        search: '',
        headers: [
            {text: 'Id', value: 'id'},
            {text: 'Category', value: 'category_id'},
            {text: 'Amount', value: 'amount'},
            {text: 'Note', value: 'note'},
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
            let res = await ApiServices.budgetRequestShow(this.$route.params.id);
            if (res.success === true) {
                this.show = res.data;
                this.categories = res.data.budget_request_categories;
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
