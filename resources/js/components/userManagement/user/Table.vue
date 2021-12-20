<template>
    <v-card>
        <v-toolbar flat style="height: 110px">
            <template v-slot:extension>
                <v-tabs
                    v-model="tabs"
                    fixed-tabs
                >
                    <v-tabs-slider></v-tabs-slider>

                    <v-tab
                        href="#director"
                        class="primary--text"
                    >
                        {{ $t('directors') }}
                    </v-tab>

                    <v-tab
                        href="#store"
                        class="primary--text"
                    >
                        {{ $t('store') }}
                    </v-tab>

                    <v-tab
                        href="#staff"
                        class="primary--text"
                    >
                        {{ $t('staffs') }}
                    </v-tab>

                    <v-tab
                        class="primary--text"
                    >
                        <v-btn
                            color="green"
                            dark
                            class="mb-2 add-btn"
                            :to="'/users/create'"
                            v-if="$can('users.create')"
                        >
                            {{ $t('button.add_new_user') }}
                        </v-btn>
                    </v-tab>
                </v-tabs>
            </template>
        </v-toolbar>

        <v-tabs-items v-model="tabs">

            <v-tab-item
                :value="'director'"
            >
        <v-data-table
            :headers="headers"
            :items="directors"
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
                <img :src=cdnURL+item.link
                     v-if="item.link"
                     style="width: 50px; height: 50px; object-fit: cover;"
                     v-on:click="openImage(item.link)"/>

                <img :src="baseURL+'images/placeholder.jpg'"
                     v-else
                     style="width: 50px; height: 50px; object-fit: cover"
                />
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/users/'+item.id"
                    v-if="$can('users.show')"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <router-link
                    :to="'/users/edit/'+item.id"
                    v-if="$can('users.edit')"
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
                    v-if="$can('users.delete')"
                >
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
            </v-tab-item>

            <v-tab-item
                :value="'store'"
            >
        <v-data-table
            :headers="headers"
            :items="storeUsers"
            sort-by="id"
            :loading=tableLoad
            loading-text="Loading... Please wait..."
            :search="search1"
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
                                v-model="search1"
                                append-icon="mdi-magnify"
                                :label="$t('search')"
                                solo
                                hide-details
                                max-width="100px"
                            ></v-text-field>
                        </v-col>
                    </v-row>
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
                <img :src=cdnURL+item.link
                     v-if="item.link"
                     style="width: 50px; height: 50px; object-fit: cover;"
                     v-on:click="openImage(item.link)"/>

                <img :src="baseURL+'images/placeholder.jpg'"
                     v-else
                     style="width: 50px; height: 50px; object-fit: cover"
                />
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/users/'+item.id"
                    v-if="$can('users.show')"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <router-link
                    :to="'/users/edit/'+item.id"
                    v-if="$can('users.edit')"
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
                    v-if="$can('users.delete')"
                >
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
            </v-tab-item>

            <v-tab-item
                :value="'staff'"
            >
        <v-data-table
            :headers="staffHeaders"
            :items="staffs"
            sort-by="id"
            :loading=tableLoad
            loading-text="Loading... Please wait..."
            :search="search2"
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
                                v-model="search2"
                                append-icon="mdi-magnify"
                                :label="$t('search')"
                                solo
                                hide-details
                                max-width="100px"
                            ></v-text-field>
                        </v-col>
                    </v-row>
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
                <img :src=cdnURL+item.link
                     v-if="item.link"
                     style="width: 50px; height: 50px; object-fit: cover;"
                     v-on:click="openImage(item.link)"/>

                <img :src="baseURL+'images/placeholder.jpg'"
                     v-else
                     style="width: 50px; height: 50px; object-fit: cover"
                />
            </template>
            <template v-slot:item.designation_id="{ item }">
                <p v-if="item.designation_id">{{ item.designation }}</p>
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/users/'+item.id"
                    v-if="$can('users.show')"
                >
                    <v-icon
                        small
                    >
                        mdi-eye
                    </v-icon>
                </router-link>
                <router-link
                    :to="'/users/edit/'+item.id"
                    v-if="$can('users.edit')"
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
                    v-if="$can('users.delete')"
                >
                    mdi-delete
                </v-icon>
            </template>
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
            </v-tab-item>
        </v-tabs-items>
    </v-card>
</template>

<script>
import config from "../../../config";
import store from "../../../store";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";

export default {
    name: "TableWrapper",
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        search: '',
        search1: '',
        search2: '',
        tabs: null,
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: i18n.t('id'), align: 'start', sortable: true, value: 'id'},
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('image'), value: 'link', sortable: false},
            {text: i18n.t('username'), value: 'username', sortable: false},
            {text: i18n.t('email'), value: 'email', sortable: false},
            {text: i18n.t('mobile'), value: 'mobile_no'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        staffHeaders: [
            {text: i18n.t('id'), align: 'start', sortable: true, value: 'id'},
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('image'), value: 'link', sortable: false},
            {text: i18n.t('username'), value: 'username', sortable: false},
            {text: i18n.t('email'), value: 'email', sortable: false},
            {text: i18n.t('mobile'), value: 'mobile_no'},
            {text: i18n.t('designation'), value: 'designation_id'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        admins: [],
        directors: [],
        storeUsers: [],
        staffs: [],
        tableLoad: true
    }),

    async created() {
        this.loadItems();
    },

    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let admin = await ApiServices.getUsers('Admin');
            if (admin.success === true) {
                this.tableLoad = false;
                this.admins = admin.data;
            }
            let director = await ApiServices.getUsers('Director');
            if (director.success === true) {
                this.tableLoad = false;
                this.directors = director.data;
            }
            let store = await ApiServices.getUsers('Store');
            if (store.success === true) {
                this.tableLoad = false;
                this.storeUsers = store.data;
            }
            let staff = await ApiServices.getUsers('Staff');
            if (staff.success === true) {
                this.tableLoad = false;
                this.staffs = staff.data;
            }
        },

        deleteItem(item) {
            this.editedIndex = this.products.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.productDelete(this.editedItem.id);
            if (res.success === true) {
                this.products.splice(this.editedIndex, 1)
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
.add-btn{
    color: #fff !important;
}
</style>
