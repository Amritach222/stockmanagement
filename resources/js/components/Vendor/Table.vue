<template>
    <v-card>
        <v-card-title>
            Vendor
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="vendors"
            sort-by="id"
            :loading="tableLoad"
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
                                :to="'/vendors/create'"
                                v-if="$can('vendors.create')"
                            >
                                Add New Vendor
                            </v-btn>
                        </template>
<!--                        <v-card>-->
<!--                            <v-form ref="form">-->
<!--                                <v-card-title>-->
<!--                                    <span class="headline">{{ formTitle }}</span>-->
<!--                                </v-card-title>-->

<!--                                <v-card-text>-->
<!--                                    <v-container>-->
<!--                                        <v-row>-->
<!--                                            <v-col>-->
<!--                                                <v-text-field-->
<!--                                                    v-model="editedItem.name"-->
<!--                                                    label="Name"-->
<!--                                                    required-->
<!--                                                    outlined-->
<!--                                                    :rules="rules.name"-->
<!--                                                    class="shrink"-->
<!--                                                ></v-text-field>-->
<!--                                            </v-col>-->
<!--                                            <v-col>-->
<!--                                                <v-text-field-->
<!--                                                    v-model="editedItem.company_name"-->
<!--                                                    label="Company Name"-->
<!--                                                    required-->
<!--                                                    outlined-->
<!--                                                    :rules="rules.company_name"-->
<!--                                                ></v-text-field>-->
<!--                                            </v-col>-->
<!--                                            <v-col>-->
<!--                                                <v-text-field-->
<!--                                                    v-model="editedItem.vat_no"-->
<!--                                                    label="Vat/Pan No"-->
<!--                                                    outlined-->
<!--                                                    type="number"-->
<!--                                                    :rules="rules.vat_no"-->
<!--                                                ></v-text-field>-->
<!--                                            </v-col>-->
<!--                                        </v-row>-->
<!--                                        <v-row>-->
<!--                                            <v-col>-->
<!--                                                <v-text-field-->
<!--                                                    v-model="editedItem.email"-->
<!--                                                    label="Email"-->
<!--                                                    required-->
<!--                                                    outlined-->
<!--                                                    :rules="rules.email"-->
<!--                                                ></v-text-field>-->
<!--                                            </v-col>-->
<!--                                            <v-col>-->
<!--                                                <v-text-field-->
<!--                                                    v-model="editedItem.landline"-->
<!--                                                    label="Landline No."-->
<!--                                                    required-->
<!--                                                    outlined-->
<!--                                                    type="number"-->
<!--                                                    :rules="rules.landline"-->
<!--                                                ></v-text-field>-->
<!--                                            </v-col>-->
<!--                                            <v-col>-->
<!--                                                <v-text-field-->
<!--                                                    v-model="editedItem.mobile"-->
<!--                                                    label="Mobile No."-->
<!--                                                    required-->
<!--                                                    outlined-->
<!--                                                    type="number"-->
<!--                                                    :rules="rules.mobile"-->
<!--                                                ></v-text-field>-->
<!--                                            </v-col>-->
<!--                                        </v-row>-->
<!--                                        <v-row>-->
<!--                                            <v-col>-->
<!--                                                <v-select-->
<!--                                                    v-model="editedItem.country"-->
<!--                                                    :items="country"-->
<!--                                                    item-text="name"-->
<!--                                                    item-value="name"-->
<!--                                                    label="Country"-->
<!--                                                    dense-->
<!--                                                    outlined-->
<!--                                                    required-->
<!--                                                    :rules="rules.country"-->
<!--                                                    return-object-->
<!--                                                    v-on:change=getStates(editedItem.country)-->
<!--                                                ></v-select>-->
<!--                                            </v-col>-->
<!--                                            <v-col>-->
<!--                                                <v-select-->
<!--                                                    v-model="editedItem.state"-->
<!--                                                    :items="state"-->
<!--                                                    item-text="name"-->
<!--                                                    item-value="name"-->
<!--                                                    label="State"-->
<!--                                                    dense-->
<!--                                                    outlined-->
<!--                                                    required-->
<!--                                                    :rules="rules.state"-->
<!--                                                    return-object-->
<!--                                                    v-on:change=getCities(editedItem.state)-->
<!--                                                ></v-select>-->
<!--                                            </v-col>-->
<!--                                            <v-col>-->
<!--                                                <v-select-->
<!--                                                    v-model="editedItem.city"-->
<!--                                                    :items="city"-->
<!--                                                    item-text="name"-->
<!--                                                    item-value="name"-->
<!--                                                    label="City"-->
<!--                                                    dense-->
<!--                                                    outlined-->
<!--                                                    required-->
<!--                                                    :rules="rules.city"-->
<!--                                                    return-object-->
<!--                                                ></v-select>-->
<!--                                            </v-col>-->
<!--                                        </v-row>-->
<!--                                        <v-row>-->
<!--                                            <v-col>-->
<!--                                                <v-text-field-->
<!--                                                    v-model="editedItem.postal_code"-->
<!--                                                    label="Postal Code"-->
<!--                                                    required-->
<!--                                                    outlined-->
<!--                                                    type="number"-->
<!--                                                ></v-text-field>-->
<!--                                            </v-col>-->
<!--                                            <v-col>-->
<!--                                                <v-select-->
<!--                                                    v-model="editedItem.category_id"-->
<!--                                                    :items="categories"-->
<!--                                                    item-text="name"-->
<!--                                                    item-value="id"-->
<!--                                                    label="Categories"-->
<!--                                                    dense-->
<!--                                                    outlined-->
<!--                                                    required-->
<!--                                                    :rules="rules.category_id"-->
<!--                                                ></v-select>-->
<!--                                            </v-col>-->
<!--                                            <v-col>-->
<!--                                                <v-select-->
<!--                                                    v-model="editedItem.is_active"-->
<!--                                                    :items="activePassive"-->
<!--                                                    item-text="text"-->
<!--                                                    item-value="value"-->
<!--                                                    label="Active or Inactive"-->
<!--                                                    dense-->
<!--                                                    outlined-->
<!--                                                    required-->
<!--                                                    :rules="rules.is_active"-->
<!--                                                ></v-select>-->
<!--                                            </v-col>-->
<!--                                        </v-row>-->

<!--                                    </v-container>-->
<!--                                </v-card-text>-->

<!--                                <v-card-actions>-->
<!--                                    <v-progress-linear-->
<!--                                        v-if="progressL"-->
<!--                                        indeterminate-->
<!--                                        color="green"-->
<!--                                    ></v-progress-linear>-->
<!--                                    <v-spacer></v-spacer>-->
<!--                                    <v-btn-->
<!--                                        color="blue darken-1"-->
<!--                                        text-->
<!--                                        @click="close"-->
<!--                                    >-->
<!--                                        Cancel-->
<!--                                    </v-btn>-->
<!--                                    <v-btn-->
<!--                                        color="blue darken-1"-->
<!--                                        text-->
<!--                                        @click="save"-->
<!--                                    >-->
<!--                                        Save-->
<!--                                    </v-btn>-->
<!--                                </v-card-actions>-->
<!--                            </v-form>-->
<!--                        </v-card>-->
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
            <template v-slot:item.city="{ item }">
                {{getCityName(item)}}
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/vendors/'+item.id"
                    v-if="$can('vendors.show')"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <router-link
                    :to="'/vendors/edit/'+item.id"
                    v-if="$can('vendors.edit')"
                >
                <v-icon
                    small
                    class="mr-2"
                >
                    mdi-pencil
                </v-icon>
                </router-link>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    v-if="$can('vendors.delete')"
                >
                    mdi-delete
                </v-icon>
                <router-link
                    :to="'/vendorProducts/add/'+item.id"
                    v-if="$is('Store Keeper')"
                >
                    <v-icon
                        small
                    >
                        mdi-chart-box-plus-outline
                    </v-icon>
                </router-link>

            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import store from "../../store";
import ApiServices from "../../services/ApiServices";
import i18n from "../../i18n";


export default {
    name: "TableWrapper",
    data: () => ({
        search: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Id', align: 'start', sortable: false, value: 'id'},
            {text: 'Name', value: 'name'},
            {text: 'Company Name', value: 'company_name'},
            {text: 'Vat/Pan No', value: 'vat_no'},
            {text: 'Email', value: 'email'},
            {text: 'Phone No', value: 'landline'},
            {text: 'City', value: 'city'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        activePassive: [
            {text: 'Active', value: 1},
            {text: 'Inactive', value: 0},
            ],
        categories: [],
        vendors: [],
        tableLoad: true,
    }),

    async created() {
        this.loadItems();
    },

    methods: {
        getCityName(item){
            if(item.city !== null) return JSON.parse(item.city).name;
        },
        async loadItems() {
            let res = await ApiServices.vendorIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.vendors = res.data;
            }
        },

        deleteItem(item) {
            this.editedIndex = this.vendors.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.vendorDelete(this.editedItem.id);
            if (res.success === true) {
                this.vendors.splice(this.editedIndex, 1)
            }
            this.closeDelete()
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
