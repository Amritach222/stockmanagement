<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>{{ $t('card_title.edit_budget_request') }}</strong>
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
                                        <v-select
                                            v-model="editedItem.department_id"
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
                                            v-model="editedItem.type"
                                            :items="['Annual Request','Extend Request']"
                                            :label="$t('type')"
                                            placeholder="Select a request type..."
                                            prepend-icon="mdi-shape"
                                            required
                                            :rules="rules.type"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.fiscal_year_id"
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
                                            v-model="editedItem.request_amount"
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
                                                    :label="$t('file')"
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
                                            {{ $t('categories') }}
                                            <v-spacer></v-spacer>
                                        </v-card-title>
                                        <v-data-table
                                            :headers="headers"
                                            :items="requestCategories"
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
                                            <template v-slot:item.category_id="{ item }">
                                                <p v-if="item.category_id" class="mt-3">{{ item.category.name }}</p>
                                                <p v-else class="mt-3">---</p>
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
import config from "../../../config";

export default {
    name: "BudgetRequestEdit",

    props: {
        source: String,
    },
    data: () => ({
        cdnURL: config.cdnURL,
        editedItem: {
            department_id: '',
            fiscal_year_id: '',
            type: '',
            request_amount: '',
            remarks: '',
            file: [],
        },
        departments: [],
        fiscalYears: [],
        changeProgress: false,
        search: '',
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: i18n.t('id'), value: 'id'},
            {text: i18n.t('category'), value: 'category_id'},
            {text: i18n.t('amount'), value: 'amount'},
            {text: i18n.t('note'), value: 'note'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
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
        this.loadItem();
        this.loadCategories();
    },
    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
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
        async loadItem() {
            let res = await ApiServices.budgetRequestShow(this.$route.params.id);
            if (res.success === true) {
                this.editedItem = res.data;
                this.requestCategories = res.data.budget_request_categories;
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
            let res = await ApiServices.budgetRequestCategoryDelete(this.reqCategory.id)
            if (res.success === true) {
                this.requestCategories.splice(this.editedIndex, 1)
                this.calculateTotalAmount();
            }
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
                if (this.editedIndex > -1) {
                    const data = new FormData();
                    if (this.reqCategory.category_id != null) {
                        data.append('category_id', this.reqCategory.category_id);
                    }
                    data.append('amount', parseInt(this.reqCategory.amount));
                    if (this.reqCategory.note !== null) {
                        data.append('note', this.reqCategory.note);
                    }
                    let res = await ApiServices.budgetRequestCategoryEdit(this.reqCategory.id, data)
                    if (res.success === true) {
                        Object.assign(this.requestCategories[this.editedIndex], res.data)
                    }
                } else {
                    console.log(this.reqCategory.note)
                    const data = new FormData();
                    if (this.reqCategory.category_id != null) {
                        data.append('category_id', this.reqCategory.category_id);
                    }
                    data.append('amount', parseInt(this.reqCategory.amount));
                    data.append('budget_request_id', parseInt(this.editedItem.id));
                    if (this.reqCategory.note !== null && this.reqCategory.note !== undefined) {
                        data.append('note', this.reqCategory.note);
                    }
                    let res = await ApiServices.budgetRequestCategoryCreate(data)
                    if (res.success === true) {
                        this.requestCategories.push(res.data);
                    }
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
            this.editedItem.request_amount = total;
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
        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            data.append('department_id', this.editedItem.department_id);
            data.append('fiscal_year_id', this.editedItem.fiscal_year_id);
            data.append('type', this.editedItem.type);
            data.append('request_amount', this.editedItem.request_amount);
            data.append('remarks', this.editedItem.remarks);
            if ('file' in this.editedItem) {
                if (typeof this.editedItem.file.name == 'string') {
                    data.append('file', this.editedItem.file);
                }
            }
            let res = await ApiServices.budgetRequestEdit(this.editedItem.id, data);
            this.changeProgress = false;
            if (res.success === true) {
                route.replace('/budgetRequests');
            }
        },

        validate() {
            if (this.reqCategory.amount === '') {
                this.validated = false;
            } else if (this.reqCategory.category_id === '') {
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
