<template>
    <v-card>
        <v-card-title>
            {{ $t('units') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="units"
            sort-by="id"
            :loading=tableLoad
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
                                v-if="$can('units.create')"
                            >
                                {{ $t('button.add_new_unit') }}
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
                                                    v-model="editedItem.name"
                                                    :label="$t('unit') +' '+ $t('name')"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                    v-on:keyup="clearValidation()"
                                                ></v-text-field>
                                                <p v-if="nameValidation" class="notify-validation">{{
                                                    $t('validation.unitName') }}</p>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.short_code"
                                                    :label="$t('unit') +' '+ $t('short_code')"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-text-field>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-select
                                                    v-model="editedItem.category_id"
                                                    :label="$t('unit') +' '+ $t('category')"
                                                    :items="categories"
                                                    item-text="name"
                                                    item-value="id"
                                                    outlined
                                                    required
                                                    :rules="rules"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-select
                                                    v-model="editedItem.type"
                                                    :label="$t('type')"
                                                    :items="types"
                                                    item-value="value"
                                                    item-text="name"
                                                    outlined
                                                    required
                                                    :rules="rules"
                                                    v-on:change="valueCheck(editedItem.type)"
                                                ></v-select>
                                                <p v-if="typeValidation" class="notify-validation">{{
                                                    $t('validation.unitType') }}</p>
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="needsValue">
                                            <v-col>
                                                <v-text-field
                                                    v-model="editedItem.value"
                                                    :label="$t('ratio')"
                                                    type="number"
                                                    outlined
                                                    v-on:keyup="clearValidation()"
                                                ></v-text-field>
                                                <p v-if="ratioValidation" class="notify-validation">{{
                                                    $t('validation.unitRatio') }}</p>
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
                                        @click="checkValidation"
                                    >
                                        {{ $t('button.submit') }}
                                    </v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-card>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h6"> {{ $t('message.delete') }}</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete"> {{
                                    $t('button.cancel')
                                    }}
                                </v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm"> {{
                                    $t('button.confirm')
                                    }}
                                </v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.category_id="{ item }">
                <p v-if="item.category_id">{{ item.category.name }}</p>
                <p v-else>---</p>
            </template>
            <template v-slot:item.type="{ item }">
                <p v-if="item.type === 'smaller'">Smaller than base unit</p>
                <p v-else-if="item.type === 'equal'">Base unit</p>
                <p v-else-if="item.type === 'bigger'">Bigger than base unit</p>
                <p v-else>---</p>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    v-if="$can('units.edit')"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    v-if="$can('units.delete')"
                >
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
    import store from "../../../store";
    import ApiServices from "../../../services/ApiServices";
    import i18n from "../../../i18n";

    export default {
        name: "TableWrapper",
        data: () => ({
            search: '',
            validated: false,
            progressL: false,
            dialog: false,
            dialogDelete: false,
            headers: [
                {text: i18n.t('id'), align: 'start', sortable: false, value: 'id'},
                {text: i18n.t('name'), value: 'name'},
                {text: i18n.t('short_code'), value: 'short_code'},
                {text: i18n.t('category'), value: 'category_id'},
                {text: i18n.t('type'), value: 'type'},
                {text: i18n.t('ratio'), value: 'value'},
                {text: i18n.t('actions'), value: 'actions', sortable: false},
            ],
            units: [],
            editedIndex: -1,
            needsValue: false,
            typeValidation: false,
            nameValidation: false,
            ratioValidation: false,
            categories: [],
            types: [
                {name: 'Smaller than base unit', value: 'smaller'},
                {name: 'Base unit', value: 'equal'},
                {name: 'Bigger than base unit', value: 'bigger'},
            ],
            editedItem: {
                id: null,
                name: '',
                short_code: '',
                category_id: '',
                type: '',
                value: '',
            },
            defaultItem: {
                id: null,
                name: '',
                short_code: '',
                category_id: '',
                type: '',
                value: '',
            },
            rules: [
                value => !!value || 'Required.',
            ],
            tableLoad: true
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? i18n.t('card_title.add_unit') : i18n.t('card_title.edit_unit')
            },
        },

        watch: {
            dialog(val) {
                val || this.close()
            },
            dialogDelete(val) {
                val || this.closeDelete()
            },
        },

        async created() {
            this.loadItems();
            this.loadCategories();
        },

        methods: {
            async loadItems() {
                let res = await ApiServices.unitIndex();
                if (res.success === true) {
                    this.tableLoad = false;
                    this.units = res.data;
                }
            },
            async loadCategories() {
                let res = await ApiServices.unitCategoryIndex();
                if (res.success === true) {
                    this.tableLoad = false;
                    this.categories = res.data;
                }
            },
            async valueCheck(type) {
                this.typeValidation = false;
                if (type !== 'equal') {
                    this.needsValue = true;
                } else {
                    this.needsValue = false;
                }
            },
            editItem(item) {
                this.editedIndex = this.units.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.valueCheck(this.editedItem.type);
                this.dialog = true
            },

            deleteItem(item) {
                this.editedIndex = this.units.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
            },

            async deleteItemConfirm() {
                let res = await ApiServices.unitDelete(this.editedItem.id);
                if (res.success === true) {
                    this.units.splice(this.editedIndex, 1)
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = res.message;
                    store.state.home.snackbarColor = 'green';
                } else {
                    store.state.home.snackbar = true;
                    store.state.home.snackbarText = res.message;
                    store.state.home.snackbarColor = 'red';
                }
                this.closeDelete()
            },

            close() {
                this.progressL = false;
                this.dialog = false;
                this.typeValidation = false;
                this.nameValidation = false;
                this.ratioValidation = false;
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                });
                this.loadItems();
            },

            closeDelete() {
                this.dialogDelete = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
            },

            async clearValidation() {
                this.typeValidation = false;
                this.nameValidation = false;
                this.ratioValidation = false;
            },

            async checkValidation() {
                let type = 0;
                let name = 0;
                let ratio = 0;
                let unique = 0;
                for (var i = 0; i < this.units.length; i++) {
                    if (this.editedIndex > -1) {
                        if ((this.editedItem.id !== this.units[i].id) && (this.editedItem.name.toLowerCase() === this.units[i].name.toLowerCase())) {
                            name = 1;
                        } else if (((this.editedItem.type !== 'equal') && (this.editedItem.id !== this.units[i].id)) && ((this.editedItem.category_id === this.units[i].category_id) && ((this.editedItem.type === this.units[i].type) && (parseInt(this.editedItem.value) === parseInt(this.units[i].value))))) {
                            ratio = 1;
                        } else if (((this.editedItem.type === 'equal') && (this.editedItem.type === this.units[i].type)) && ((this.editedItem.category_id === this.units[i].category_id) && (this.editedItem.id !== this.units[i].id))) {
                            type = 1;
                        } else {
                            unique = 1;
                        }
                    } else {
                        if (this.editedItem.name.toLowerCase() === this.units[i].name.toLowerCase()) {
                            name = 1;
                        } else if (((this.editedItem.type === 'equal') && (this.editedItem.category_id === this.units[i].category_id)) && (this.editedItem.type === this.units[i].type)) {
                            type = 1;
                        } else if (((this.editedItem.type !== 'equal') && (this.editedItem.category_id === this.units[i].category_id)) && ((this.editedItem.type === this.units[i].type) && (parseInt(this.editedItem.value) === parseInt(this.units[i].value)))) {
                            ratio = 1;
                        }
                    }
                }
                if (((type === 0) && (ratio === 0)) && (name === 0)) {
                    this.typeValidation = false;
                    this.nameValidation = false;
                    this.ratioValidation = false;
                    let res = await this.save();
                } else if (name === 1) {
                    this.nameValidation = true;
                } else if (ratio === 1) {
                    this.ratioValidation = true;
                } else if (type === 1) {
                    this.typeValidation = true;
                }
            },

            async save() {
                if (this.editedIndex > -1) {
                    //edit goes here
                    this.progressL = true;
                    const data = new FormData();
                    data.append('name', this.editedItem.name);
                    data.append('short_code', this.editedItem.short_code);
                    if (this.editedItem.category_id !== null && this.editedItem.category_id !== '') {
                        data.append('category_id', this.editedItem.category_id);
                    }
                    if (this.editedItem.type !== null && this.editedItem.type !== '') {
                        data.append('type', this.editedItem.type);
                    }
                    if (this.editedItem.type === 'equal') {
                        data.append('value', 1);
                    } else if (this.editedItem.value !== null && this.editedItem.value !== '') {
                        data.append('value', this.editedItem.value);
                    }
                    let res = await ApiServices.unitEdit(this.editedItem.id, data);
                    if (res.success === true) {
                        Object.assign(this.units[this.editedIndex], this.editedItem)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    //add new
                    this.validateData();
                    if (this.validated) {
                        this.progressL = true;
                        const data = new FormData();
                        data.append('name', this.editedItem.name);
                        data.append('short_code', this.editedItem.short_code);
                        if (this.editedItem.category_id !== null && this.editedItem.category_id !== '') {
                            data.append('category_id', this.editedItem.category_id);
                        }
                        if (this.editedItem.type !== null && this.editedItem.type !== '') {
                            data.append('type', this.editedItem.type);
                        }
                        if (this.editedItem.type === 'equal') {
                            data.append('value', 1);
                        } else if (this.editedItem.value !== null && this.editedItem.value !== '') {
                            data.append('value', this.editedItem.value);
                        }
                        let res = await ApiServices.unitCreate(data);
                        if (res.success === true) {
                            this.units.push(this.editedItem);
                            this.$refs.form.reset();
                            this.close()
                        }
                    }
                }
            },
            validateData() {
                this.$refs.form.validate();
                if (this.editedItem.name === null) {
                    this.validated = false
                } else if (this.editedItem.base_unit === null) {
                    this.validated = false;
                } else {
                    this.validated = true
                }
            }
        },
    }
</script>


<style scoped>
    .notify-validation {
        color: #f65050;
    }
</style>
