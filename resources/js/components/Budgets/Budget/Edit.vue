<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Budget
                                <v-progress-circular
                                    v-if="changeProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-form>
                                        <v-text-field
                                            v-model="editedItem.title"
                                            :label="$t('title')"
                                            placeholder="Enter title..."
                                            prepend-icon="mdi-alpha-t-circle"
                                            required
                                            :rules="rules.title"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.department_id"
                                            :items="departments"
                                            item-text="name"
                                            item-value="id"
                                            :label="$t('department')"
                                            placeholder="Select a department..."
                                            prepend-icon="mdi-alpha-d-circle"
                                            required
                                            :rules="rules.department_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.fiscal_year_id"
                                            :items="fiscalYears"
                                            item-text="name"
                                            item-value="id"
                                            :label="$t('fiscal_year')"
                                            placeholder="Select a fiscal year..."
                                            prepend-icon="mdi-calendar-clock"
                                            required
                                            :rules="rules.fiscal_year_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.type"
                                            :items="['Annual','Extra']"
                                            :label="$t('type')"
                                            placeholder="Select a budget type..."
                                            prepend-icon="mdi-shape"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.allocated_budget_amount"
                                            type="number"
                                            :label="$t('allocated_budget') +' '+ $t('amount')"
                                            placeholder="Enter the allocate budget amount..."
                                            prepend-icon="mdi-cash-check"
                                            required
                                            :rules="rules.allocated_budget_amount"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.initial_dispatched_amount"
                                            type="number"
                                            :label="$t('initial_dispatched') +' '+ $t('amount')"
                                            placeholder="Enter the initial dispatched amount..."
                                            prepend-icon="mdi-cash-marker"
                                            required
                                            disabled
                                            :rules="rules.initial_dispatched_amount"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.total_dispatched_amount"
                                            type="number"
                                            :label="$t('total_dispatched') +' '+ $t('amount')"
                                            placeholder="Total dispatched amount..."
                                            prepend-icon="mdi-currency-usd"
                                            disabled
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.date_first_received"
                                            type="date"
                                            :label="$t('date_first_received')"
                                            placeholder="Enter the first amount received date..."
                                            prepend-icon="mdi-calendar-month"
                                            :rules="rules.date_first_received"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.remarks"
                                            type="text"
                                            :label="$t('remarks')"
                                            placeholder="Enter remarks..."
                                            prepend-icon="mdi-pen"
                                            solo
                                        />
                                        <v-row>
                                            <v-col v-if="typeof(editedItem.link) === 'string'">
                                                <v-file-input
                                                    v-model="editedItem.file"
                                                    label="File"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="*/application"
                                                ></v-file-input>
                                                <v-col width="200" class="ml-3 file-link"
                                                       v-on:click="openImage(editedItem.link)">
                                                    <h5> {{ $t('open_file') }} </h5>
                                                </v-col>
                                            </v-col>
                                            <v-col v-else>
                                                <v-file-input
                                                    v-model="editedItem.file"
                                                    :label="$t('file')"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="*/application"
                                                ></v-file-input>
                                            </v-col>
                                        </v-row>
                                    </v-form>

                                    <hr>
                                    <v-card>
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
                                                                label="Search"
                                                                solo
                                                                hide-details
                                                                max-width="100px"
                                                            ></v-text-field>
                                                        </v-col>
                                                    </v-row>
                                                    <v-dialog
                                                        v-model="dialog"
                                                        max-width="600px"
                                                    >
                                                        <template v-slot:activator="{ on, attrs }">
                                                            <v-btn
                                                                color="green"
                                                                dark
                                                                class="mb-2"
                                                                v-bind="attrs"
                                                                v-on="on"
                                                            >
                                                                Add New Dispatched Amount
                                                            </v-btn>
                                                        </template>
                                                        <v-card>
                                                            <v-form ref="form">
                                                                <v-card-title>
                                                                    <span class="headline">{{ formTitle }}</span>
                                                                </v-card-title>

                                                                <v-card-text>
                                                                    <v-container>
                                                                        <v-row>
                                                                            <v-col>
                                                                                <v-text-field
                                                                                    v-model="dispatch.amount"
                                                                                    :label="$t('amount')"
                                                                                    type="number"
                                                                                    required
                                                                                    outlined
                                                                                ></v-text-field>
                                                                                <v-text-field
                                                                                    v-model="dispatch.dispatched_date"
                                                                                    :label="$t('date')"
                                                                                    type="date"
                                                                                    required
                                                                                    outlined
                                                                                ></v-text-field>
                                                                            </v-col>
                                                                        </v-row>
                                                                    </v-container>
                                                                </v-card-text>

                                                                <v-card-actions>
                                                                    <v-progress-linear
                                                                        v-if="progressL"
                                                                        indeterminate
                                                                        color="green"
                                                                    ></v-progress-linear>
                                                                    <v-spacer></v-spacer>
                                                                    <v-btn
                                                                        color="blue darken-1"
                                                                        text
                                                                        @click="close"
                                                                    >
                                                                        {{ $t('button.cancel') }}
                                                                    </v-btn>
                                                                    <v-btn
                                                                        color="blue darken-1"
                                                                        text
                                                                        @click="addCategory"
                                                                    >
                                                                        {{ $t('button.submit') }}
                                                                    </v-btn>
                                                                </v-card-actions>
                                                            </v-form>
                                                        </v-card>
                                                    </v-dialog>
                                                    <v-dialog v-model="dialogDelete" max-width="500px">
                                                        <v-card>
                                                            <v-card-title class="text-h6">
                                                                {{ $t('message.delete') }}
                                                            </v-card-title>
                                                            <v-card-actions>
                                                                <v-spacer></v-spacer>
                                                                <v-btn color="blue darken-1" text @click="closeDelete">
                                                                    {{ $t('button.cancel') }}
                                                                </v-btn>
                                                                <v-btn color="blue darken-1" text
                                                                       @click="deleteItemConfirm">
                                                                    {{ $t('button.confirm') }}
                                                                </v-btn>
                                                                <v-spacer></v-spacer>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                </v-toolbar>
                                            </template>
                                            <template v-slot:item.actions="{ item }">
                                                <v-icon
                                                    small
                                                    class="mr-2"
                                                    @click="editItem(item)"
                                                >
                                                    mdi-pencil
                                                </v-icon>
                                                <v-icon
                                                    small
                                                    @click="deleteItem(item)"
                                                >
                                                    mdi-delete
                                                </v-icon>
                                            </template>
                                            <template v-slot:no-data>
                                                <div>No Data</div>
                                            </template>
                                        </v-data-table>
                                    </v-card>

                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/budgets/'">
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
import ApiServices from "../../../services/ApiServices";
import config from "../../../config";

export default {
    name: "BudgetEdit",

    props: {
        source: String,
    },
    data: () => ({
        editedItem: {
            id: null,
            title: '',
            department_id: '',
            fiscal_year_id: '',
            type: '',
            allocated_budget_amount: '',
            initial_dispatched_amount: '',
            date_first_received: '',
            remarks: '',
            file: [],
        },
        cdnURL: config.cdnURL,
        departments: [],
        fiscalYears: [],
        changeProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Id', value: 'id'},
            {text: 'Amount', value: 'amount'},
            {text: 'Date', value: 'dispatched_date'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        dispatchedAmounts: [],
        dispatch: {
            amount: '',
            dispatched_date: '',
        },
        validated: false,
        tableLoad: false,
        editedIndex: -1,
        error: {
            title: '',
            department_id: '',
            fiscal_year_id: '',
            allocated_budget_amount: '',
            initial_dispatched_amount: '',
            total_dispatched_amount: '',
            date_first_received: '',
            remarks: '',
            file: [],
        },
        rules: {
            title: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            department_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            fiscal_year_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            allocated_budget_amount: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
            initial_dispatched_amount: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
            date_first_received: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Dispatched Amount' : 'Edit Dispatched Amount'
        },
    },

    async created() {
        this.loadData();
        this.loadDepartments();
        this.loadFiscalYears();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadData() {
            let res = await ApiServices.budgetShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
                this.dispatchedAmounts = res.data.dispatched_amounts;
                this.calculateTotalAmount();
            }
        },

        async loadDepartments() {
            let res = await ApiServices.departmentIndex();
            if (res.success === true) {
                this.departments = res.data;
            }
        },

        async loadFiscalYears() {
            let res = await ApiServices.fiscalYearIndex();
            if (res.success === true) {
                this.fiscalYears = res.data;
            }
        },

        editItem(item) {
            this.editedIndex = this.dispatchedAmounts.indexOf(item)
            this.dispatch = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.dispatchedAmounts.indexOf(item)
            this.dispatch = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.budgetDispatchDelete(this.dispatch.id)
            if (res.success === true) {
                this.dispatchedAmounts.splice(this.editedIndex, 1)
                this.calculateTotalAmount();
                const data = new FormData();
                data.append('total_dispatched_amount', this.editedItem.total_dispatched_amount);
                let rtn = await ApiServices.budgetEdit(this.editedItem.id, data);
            }
            this.closeDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.dispatch = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.dispatch = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        async addCategory() {
            this.validate();
            var success = false;
            if (this.validated) {
                if (this.editedIndex > -1) {
                    const data = new FormData();
                    data.append('budget_id', this.editedItem.id);
                    data.append('amount', parseInt(this.dispatch.amount));
                    data.append('dispatched_date', this.dispatch.dispatched_date);
                    let res = await ApiServices.budgetDispatchEdit(this.dispatch.id, data)
                    if (res.success === true) {
                        Object.assign(this.dispatchedAmounts[this.editedIndex], res.data)
                        success = true;
                    }
                } else {
                    const data = new FormData();
                    data.append('budget_id', this.editedItem.id);
                    data.append('amount', parseInt(this.dispatch.amount));
                    data.append('dispatched_date', this.dispatch.dispatched_date);
                    let res = await ApiServices.budgetDispatchCreate(data)
                    if (res.success === true) {
                        this.dispatchedAmounts.push(res.data);
                        success = true;
                    }
                }
                if (success === true) {
                    this.calculateTotalAmount();
                    const data = new FormData();
                    data.append('total_dispatched_amount', this.editedItem.total_dispatched_amount);
                    let rtn = await ApiServices.budgetEdit(this.editedItem.id, data);
                }
                this.$refs.form.reset();
                this.close()
            }
        },

        async calculateTotalAmount() {
            var total = 0;
            for (var i = 0; i < this.dispatchedAmounts.length; i++) {
                total = parseInt(total) + parseInt(this.dispatchedAmounts[i].amount);
            }
            this.editedItem.total_dispatched_amount = total;
        },

        clearError(name) {
            if (name === 'title') {
                this.error.title = '';
            }
            if (name === 'department_id') {
                this.error.department_id = '';
            }
            if (name === 'fiscal_year_id') {
                this.error.fiscal_year_id = '';
            }
            if (name === 'allocated_budget_amount') {
                this.error.allocated_budget_amount = '';
            }
            if (name === 'initial_dispatched_amount') {
                this.error.initial_dispatched_amount = '';
            }
            if (name === 'date_first_received') {
                this.error.date_first_received = '';
            }
            if (name === 'remarks') {
                this.error.remarks = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            data.append('title', this.editedItem.title);
            data.append('department_id', this.editedItem.department_id);
            data.append('fiscal_year_id', this.editedItem.fiscal_year_id);
            data.append('type', this.editedItem.type);
            data.append('allocated_budget_amount', this.editedItem.allocated_budget_amount);
            data.append('initial_dispatched_amount', this.editedItem.initial_dispatched_amount);
            data.append('total_dispatched_amount', this.editedItem.total_dispatched_amount);
            data.append('date_first_received', this.editedItem.date_first_received);
            if(this.editedItem.remarks !== null) {
                data.append('remarks', this.editedItem.remarks);
            }
            if ('file' in this.editedItem) {
                if (typeof this.editedItem.file.name == 'string') {
                    data.append('file', this.editedItem.file);
                }
            }
            let res = await ApiServices.budgetEdit(this.editedItem.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                route.replace('/budgets');
            }
        },

        validate() {
            if (this.dispatch.amount === '') {
                this.validated = false;
            } else if (this.dispatch.date === '') {
                this.validated = false;
            } else {
                this.validated = true;
            }
        }
    }
}
</script>
<style scoped>
.file-link {
    cursor: pointer;
    text-decoration: underline;
}
</style>
