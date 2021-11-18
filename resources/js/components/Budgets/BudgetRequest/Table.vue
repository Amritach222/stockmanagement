<template>
    <v-card>
        <v-card-title>
            Budget Request
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="budgetRequests"
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
                                :to="'/budgetRequests/create'"
                            >
                                Add New Budget Request
                            </v-btn>
                        </template>
                    </v-dialog>
                    <v-dialog v-model="dialogDelete" max-width="500px">
                        <v-card>
                            <v-card-title class="text-h6">Are you sure you want to delete this item?</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.department_id="{ item }">
                <p v-if="item.department_id" class="mt-3">{{ item.department.name }}</p>
            </template>
            <template v-slot:item.fiscal_year_id="{ item }">
                <p v-if="item.fiscal_year_id" class="mt-3">{{ item.fiscal_year.name }}</p>
            </template>
            <template v-slot:item.status="{ item }">
                <CButton size="sm" color="secondary" v-if="item.status == 'Pending'">
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
                    :to="'/budgetRequests/'+item.id"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <router-link
                    :to="'/budgetRequests/edit/'+item.id"
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
import store from "../../../store";
import ApiServices from "../../../services/ApiServices";

export default {
    name: "TableWrapper",
    data: () => ({
        search: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Id', align: 'start', sortable: true, value: 'id'},
            {text: 'Department', value: 'department_id'},
            {text: 'Fiscal Year', value: 'fiscal_year_id'},
            {text: 'Type', value: 'type'},
            {text: 'Amount', value: 'request_amount'},
            {text: 'Status', value: 'status'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        budgetRequests: [],
        tableLoad: false
    }),

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
            let res = await ApiServices.budgetRequestIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.budgetRequests = res.data;
            }
        },

        deleteItem(item) {
            this.editedIndex = this.budgetRequests.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.budgetRequestDelete(this.editedItem.id);
            if (res.success === true) {
                this.budgetRequests.splice(this.editedIndex, 1)
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

</style>
