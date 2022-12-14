<template>
    <v-card>
        <v-card-title>
            {{ $t('unit') +' '+ $t('categories') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="categories"
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
                                v-if="$can('unitCategories.create')"
                            >
                                {{ $t('button.add_new_unit_category') }}
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
                                                    :label="$t('name')"
                                                    required
                                                    outlined
                                                    :rules="rules"
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
                                        @click="save"
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
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    v-if="$can('unitCategories.edit')"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    v-if="$can('unitCategories.delete')"
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
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        editedIndex: -1,
        categories: [],
        editedItem: {
            id: null,
            name: '',
        },
        defaultItem: {
            id: null,
            name: '',
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: true
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? i18n.t('card_title.add_unit_category') : i18n.t('card_title.edit_unit_category')
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
    },

    methods: {
        async loadItems() {
            let res = await ApiServices.unitCategoryIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.categories = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.categories.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.categories.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.unitCategoryDelete(this.editedItem.id);
            if (res.success === true) {
                this.categories.splice(this.editedIndex, 1)
            }
            this.closeDelete()
        },

        close() {
            this.progressL = false;
            this.dialog = false;
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

        async save() {
            if (this.editedIndex > -1) {
                //edit goes here
                this.progressL = true;
                const data = new FormData();
                data.append('name', this.editedItem.name);
                let res = await ApiServices.unitCategoryEdit(this.editedItem.id, data);
                if (res.success === true) {
                    Object.assign(this.categories[this.editedIndex], this.editedItem)
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
                    let res = await ApiServices.unitCategoryCreate(data);
                    if (res.success === true) {
                        this.categories.push(this.editedItem);
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
            } else {
                this.validated = true
            }
        }
    },
}
</script>


<style scoped>

</style>
