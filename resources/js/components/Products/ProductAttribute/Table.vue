<template>
    <v-card>
        <v-card-title>
            {{ $t('product_attributes') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="productAttributes"
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
                            >
                                {{ $t('button.add_new_product_attribute') }}
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
                                                <v-select
                                                    v-model="editedItem.attribute_group_id"
                                                    :items="attributeGroups"
                                                    item-text="name"
                                                    item-value="id"
                                                    :label="$t('product_attribute_group')"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-select>
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
                            <v-card-title class="text-h6">{{ $t('message.delete') }}</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">{{ $t('button.cancel') }}</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">{{ $t('button.confirm') }}</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.attribute_group_id="{ item }">
                <p v-if="item.attribute_group_id">{{ item.attribute_group.name }}</p>
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
            {text: i18n.t('product_attribute_group'), value: 'attribute_group_id'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        productAttributes: [],
        attributeGroups: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            name: '',
            attribute_group_id: '',
        },
        defaultItem: {
            id: null,
            name: '',
            attribute_group_id: '',
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: true
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? i18n.t('card_title.add_product_attribute') : i18n.t('card_title.edit_product_attribute')
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
        this.loadAttributeGroups();
    },

    methods: {
        async loadItems() {
            let res = await ApiServices.productAttributeIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.productAttributes = res.data;
            }
        },
        async loadAttributeGroups() {
            let res = await ApiServices.productAttributeGroupIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.attributeGroups = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.productAttributes.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.productAttributes.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.productAttributeDelete(this.editedItem.id);
            if (res.success === true) {
                this.productAttributes.splice(this.editedIndex, 1)
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
            this.validateData();
            if (this.validated) {
                if (this.editedIndex > -1) {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('name', this.editedItem.name);
                    data.append('attribute_group_id', this.editedItem.attribute_group_id);
                    let res = await ApiServices.productAttributeEdit(this.editedItem.id, data);
                    if (res.success === true) {
                        Object.assign(this.productAttributes[this.editedIndex], res.data)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    this.progressL = true;
                    const data = new FormData();
                    data.append('name', this.editedItem.name);
                    data.append('attribute_group_id', this.editedItem.attribute_group_id);
                    let res = await ApiServices.productAttributeCreate(data);
                    if (res.success === true) {
                        this.productAttributes.push(res.data);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.name === '') {
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
