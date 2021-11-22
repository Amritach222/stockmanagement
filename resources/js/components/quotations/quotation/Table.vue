<template>
    <v-card>
        <v-card-title>
            {{ $t('quotations') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="quotations"
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
                                :to="'/quotations/create'"
                            >
                                {{ $t('button.add_new_quotation') }}
                            </v-btn>
                        </template>
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
            <template v-slot:item.link="{ item }">
                <CButton size="sm" color="primary" class="file-link" v-if="item.link"
                       v-on:click="openImage(item.link)"> Open
                    File
                </CButton>
                <p v-else>
                    No files added.
                </p>
            </template>
            <template v-slot:item.department_id="{ item }">
                {{ item.department.name }}
            </template>
                        <template v-slot:item.status="{ item }">
                            <CButton size="sm" color="secondary" v-if="item.status == 'Pending'">
                                {{ item.status }}
                            </CButton>
                            <CButton size="sm" color="warning" v-else-if="item.status == 'Reviewed'">
                                {{ item.status }}
                            </CButton>
                            <CButton size="sm" color="success" v-else-if="item.status == 'Approved'">
                                {{ item.status }}
                            </CButton>
                            <CButton size="sm" color="danger" v-else-if="item.status == 'Rejected'">
                                {{ item.status }}
                            </CButton>
                        </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/quotations/edit/'+item.id"
                >
                    <v-icon
                        small
                    >
                        mdi-pencil
                    </v-icon>
                </router-link>
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
import config from "../../../config";
import store from "../../../store";
import ApiServices from "../../../services/ApiServices";

export default {
    name: "TableWrapper",
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        search: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Id', align: 'start', sortable: true, value: 'id'},
            {text: 'Reference No.', value: 'reference_no'},
            {text: 'Department', value: 'department_id'},
            // {text: 'File', value: 'link', sortable: false},
            {text: 'Status', value: 'status', sortable: false},
            // {text: 'Brand', value: 'brand', sortable: false},
            // {text: 'Category', value: 'category', sortable: false},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        quotations: [],
        tableLoad: false
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Quotation' : 'Edit Quotation'
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
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.quotationIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.quotations = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.quotations.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.quotations.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.quotationDelete(this.editedItem.id);
            if (res.success === true) {
                this.quotations.splice(this.editedIndex, 1)
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
    },
}
</script>

<style scoped>
.file-link {
    cursor: pointer;
    text-decoration: underline;
    margin-top: 6px;
    font-size: 14px;
    font-weight: 400;
}
</style>
