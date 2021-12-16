<template>
    <v-card>
        <v-card-title>
            {{ $t('budgets') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="budgets"
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
                                :to="'/budgets/create'"
                                v-if="$can('budgets.create')"
                            >
                                {{ $t('button.add_new_budget') }}
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
            <!--            <template v-slot:item.link="{ item }">-->
            <!--                <img :src=cdnURL+item.link-->
            <!--                     v-if="item.link"-->
            <!--                     style="width: 50px; height: 50px; object-fit: cover;"-->
            <!--                     v-on:click="openImage(item.link)"/>-->

            <!--                <img :src="baseURL+'images/placeholder.jpg'"-->
            <!--                     v-else-->
            <!--                     style="width: 50px; height: 50px; object-fit: cover"-->
            <!--                />-->
            <!--            </template>-->
            <template v-slot:item.department_id="{ item }">
                {{ item.department.name }}
            </template>
            <template v-slot:item.fiscal_year_id="{ item }">
                {{ item.fiscal_year.name}}
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/budgets/'+item.id"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <router-link
                    :to="'/budgets/edit/'+item.id"
                    v-if="$can('budgets.edit')"
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
                    v-if="$can('budgets.delete')"
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
import i18n from "../../../i18n";

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
            {text: i18n.t('id'), align: 'start', sortable: true, value: 'id'},
            {text: i18n.t('title'), value: 'title'},
            {text: i18n.t('department'), value: 'department_id'},
            {text: i18n.t('fiscal_year'), value: 'fiscal_year_id', sortable: false},
            {text: i18n.t('allocated_budget') +' '+ i18n.t('amount'), value: 'allocated_budget_amount'},
            {text: i18n.t('initial_dispatch') +' '+ i18n.t('amount'), value: 'initial_dispatched_amount'},
            {text: i18n.t('total_dispatch') +' '+ i18n.t('amount'), value: 'total_dispatched_amount'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        budgets: [],
        editedItem: {
            id: null,
        },
        tableLoad: true
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
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.budgetIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.budgets = res.data;
            }
        },

        deleteItem(item) {
            this.editedIndex = this.budgets.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.budgetDelete(this.editedItem.id);
            if (res.success === true) {
                this.budgets.splice(this.editedIndex, 1)
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
