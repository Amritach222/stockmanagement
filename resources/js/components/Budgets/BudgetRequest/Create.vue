<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.add_budget_request') }}</strong>
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
                                        <v-select
                                            v-model="department_id"
                                            :items="departments"
                                            item-value="id"
                                            item-text="name"
                                            :label="$t('department')"
                                            placeholder="Select a department..."
                                            prepend-icon="mdi-alpha-d-circle"
                                            required
                                            :rules="rules.department_id"
                                            solo
                                        />
                                        <v-select
                                            v-model="type"
                                            :items="['Annual Request','Extend Request']"
                                            :label="$t('type')"
                                            placeholder="Select a request type..."
                                            prepend-icon="mdi-shape"
                                            required
                                            :rules="rules.type"
                                            solo
                                        />
                                        <v-select
                                            v-model="fiscal_year_id"
                                            :items="fiscalYears"
                                            item-value="id"
                                            item-text="name"
                                            :label="$t('fiscal_year')"
                                            placeholder="Select a fiscal year..."
                                            prepend-icon="mdi-calendar-month"
                                            required
                                            :rules="rules.fiscal_year_id"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="request_amount"
                                            type="number"
                                            :label="$t('amount')"
                                            placeholder="Enter the amount..."
                                            prepend-icon="mdi-cash-check"
                                            required
                                            disabled
                                            :rules="rules.request_amount"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="remarks"
                                            type="text"
                                            :label="$t('remarks')"
                                            placeholder="Enter remarks..."
                                            prepend-icon="mdi-pen"
                                            solo
                                        />
                                        <v-file-input
                                            v-model="file"
                                            :label="$t('file')"
                                            filled
                                            outlined
                                            prepend-icon="mdi-camera"
                                            accept="*/application"
                                        ></v-file-input>
                                    </v-form>

                                    <hr>
                                    <v-card>
                                        <v-card-title>
                                            {{ $t('categories') }}
                                            <v-spacer></v-spacer>
                                        </v-card-title>
                                        <v-data-table
                                            :headers="headers"
                                            :items="requestCategories"
                                            sort-by="category"
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
                                                                {{ $t('button.add_new_request_category') }}
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
                                                                                <v-select
                                                                                    v-model="reqCategory.category_id"
                                                                                    :label="$t('category')"
                                                                                    :items="categories"
                                                                                    item-text="name"
                                                                                    item-value="id"
                                                                                    required
                                                                                    outlined
                                                                                ></v-select>

                                                                                <v-text-field
                                                                                    v-model="reqCategory.amount"
                                                                                    :label="$t('amount')"
                                                                                    type="number"
                                                                                    required
                                                                                    outlined
                                                                                    :rules="rules.amount"
                                                                                ></v-text-field>
                                                                                <v-text-field
                                                                                    v-model="reqCategory.note"
                                                                                    :label="$t('note')"
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
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
                                        </CButton>
                                        <CButton size="sm" color="danger" :to="'/budgetRequests/'">
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

export default {
    name: "BudgetRequestCreate",

    props: {
        source: String,
    },
    data: () => ({
        department_id: '',
        fiscal_year_id: '',
        type: '',
        request_amount: '',
        remarks: '',
        file: [],
        departments: [],
        fiscalYears: [],
        createProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Category', value: 'category'},
            {text: 'Amount', value: 'amount'},
            {text: 'Note', value: 'note'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        requestCategories: [],
        reqCategory: {
            category_id: '',
            amount: '',
            note: '',
        },
        categories: [],
        validated: false,
        tableLoad: false,
        editedIndex: -1,
        error: {
            department_id: '',
            fiscal_year_id: '',
            type: '',
            request_amount: '',
            remarks: '',
            file: [],
        },
        rules: {
            department_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            fiscal_year_id: [
                val => val > 0 || i18n.t('validation.required'),
            ],
            type: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            request_amount: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
            amount: [
                val => val >= 0 || i18n.t('validation.required'),
            ],
        },
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? i18n.t('card_title.add_request_category') : i18n.t('card_title.edit_request_category')
        },
    },

    async created() {
        this.loadDepartments();
        this.loadFiscalYears();
        this.loadCategories();
    },
    methods: {
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
        async loadCategories() {
            let res = await ApiServices.categoryIndex();
            if (res.success === true) {
                this.categories = res.data;
            }
        },

        editItem(item) {
            this.editedIndex = this.requestCategories.indexOf(item)
            this.reqCategory = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.requestCategories.indexOf(item)
            this.reqCategory = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            this.requestCategories.splice(this.editedIndex, 1)
            this.closeDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.reqCategory = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            });
        },

        closeDelete() {
            this.dialogDelete = false
            this.$nextTick(() => {
                this.reqCategory = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
        },

        async addCategory() {
            this.validate();
            if (this.validated) {
                var catName = '---';
                let res = await ApiServices.categoryShow(this.reqCategory.category_id);
                catName = res.data.name;
                if (this.editedIndex > -1) {
                    Object.assign(this.requestCategories[this.editedIndex], {
                        'category_id': this.reqCategory.category_id,
                        'category': catName,
                        'note': this.reqCategory.note,
                        'amount': this.reqCategory.amount,
                    })
                } else {
                    this.requestCategories.push({
                        'category_id': this.reqCategory.category_id,
                        'category': catName,
                        'note': this.reqCategory.note,
                        'amount': this.reqCategory.amount,
                    });
                }
                this.calculateTotalAmount();
                this.$refs.form.reset();
                this.close()
            }
        },

        async calculateTotalAmount() {
            var total = 0;
            for (var i = 0; i < this.requestCategories.length; i++) {
                total = parseInt(total) + parseInt(this.requestCategories[i].amount);
            }
            this.request_amount = total;
        },

        clearError(name) {
            if (name === 'department_id') {
                this.error.department_id = '';
            }
            if (name === 'fiscal_year_id') {
                this.error.fiscal_year_id = '';
            }
            if (name === 'type') {
                this.error.type = '';
            }
            if (name === 'request_amount') {
                this.error.request_amount = '';
            }
            if (name === 'remarks') {
                this.error.remarks = '';
            }
        },
        async create() {
            this.createProgress = true;
            const data = new FormData();
            data.append('department_id', this.department_id);
            data.append('fiscal_year_id', this.fiscal_year_id);
            data.append('type', this.type);
            data.append('request_amount', this.request_amount);
            data.append('remarks', this.remarks);
            if (typeof this.file.name == 'string') {
                data.append('file', this.file);
            }
            let res = await ApiServices.budgetRequestCreate(data);
            this.createProgress = false;
            if (res.success === true) {
                if (this.requestCategories.length > 0) {
                    this.createCategories(res.data.id);
                } else {
                    route.replace('/budgetRequests');
                }
            }
        },

        async createCategories(id) {
            for (var i = 0; i < this.requestCategories.length; i++) {
                const data = new FormData();
                if (this.requestCategories[i].category_id != null) {
                    data.append('category_id', this.requestCategories[i].category_id);
                }
                data.append('amount', parseInt(this.requestCategories[i].amount));
                data.append('budget_request_id', parseInt(id));
                data.append('note', this.requestCategories[i].note);
                let res = await ApiServices.budgetRequestCategoryCreate(data);
            }
            route.replace('/budgetRequests')
        },

        validate() {
            if (this.reqCategory.amount === '') {
                this.validated = false;
            } else {
                this.validated = true;
            }
        }
    }
}
</script>
