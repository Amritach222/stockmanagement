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
                                        <v-btn color="blue darken-1" text @click="closeDelete">{{
                                                $t('button.cancel')
                                            }}
                                        </v-btn>
                                        <v-btn color="blue darken-1" text @click="deleteItemConfirm">
                                            {{ $t('button.confirm') }}
                                        </v-btn>
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
                        <CRow>
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
                                @click="deleteItem(item,'director')"
                                v-if="$can('users.delete')"
                            >
                                mdi-delete
                            </v-icon>

                            <div class="text-center">
                                <v-menu offset-y>
                                    <template v-slot:activator="{ on, attrs }">
                                        <!--                            <v-btn-->
                                        <!--                                color="primary"-->
                                        <!--                                dark-->
                                        <!--                                class="btn btn-sm"-->
                                        <!--                                -->
                                        <!--                            >-->
                                        <v-icon
                                            small
                                            v-bind="attrs"
                                            v-on="on"
                                        >
                                            mdi-chevron-double-down
                                        </v-icon>
                                        <!--                            </v-btn>-->
                                    </template>
                                    <v-list>
                                        <v-list-item
                                        >
                                            <v-list-item-title
                                                @click="changePassword(item)"
                                                class="password-btn">Change Password
                                            </v-list-item-title>
                                        </v-list-item>
                                    </v-list>
                                </v-menu>
                            </div>
                        </CRow>
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
                                        <v-btn color="blue darken-1" text @click="closeDelete">{{
                                                $t('button.cancel')
                                            }}
                                        </v-btn>
                                        <v-btn color="blue darken-1" text @click="deleteItemConfirm">
                                            {{ $t('button.confirm') }}
                                        </v-btn>
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
                            @click="deleteItem(item,'store')"
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
                                        <v-btn color="blue darken-1" text @click="closeDelete">{{
                                                $t('button.cancel')
                                            }}
                                        </v-btn>
                                        <v-btn color="blue darken-1" text @click="deleteItemConfirm">
                                            {{ $t('button.confirm') }}
                                        </v-btn>
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
                            @click="deleteItem(item,'staff')"
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

        <v-dialog v-model="dialogPassword" max-width="500px" height="300px">
            <v-card>
                <v-form ref="form">
                    <v-card-title>
                        <span class="headline">{{ $t('change_password') }}</span>
                        <v-progress-circular
                            v-if="progressL"
                            indeterminate
                            color="white"
                            size="30"
                        ></v-progress-circular>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row style="padding: 3px">
                                <v-col md="9">
                                    <!--                                    <v-text-field-->
                                    <!--                                        v-model="editedItem.password"-->
                                    <!--                                        type="password"-->
                                    <!--                                        description="Please enter password."-->
                                    <!--                                        :label="$t('password')"-->
                                    <!--                                        placeholder="**********"-->
                                    <!--                                        prepend-icon="mdi-lock"-->
                                    <!--                                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"-->
                                    <!--                                        :type="show1 ? 'text' : 'password'"-->
                                    <!--                                        @click:append="show1 = !show1"-->
                                    <!--                                        :error-messages="error.password"-->
                                    <!--                                        required-->
                                    <!--                                        @keyup="clearError('password')"-->
                                    <!--                                        :rules="rules.password"-->
                                    <!--                                        solo-->
                                    <!--                                    />-->
                                    <v-text-field
                                        v-model="passwords"
                                        type="password"
                                        description="Please enter password."
                                        :label="$t('password')"
                                        placeholder="**********"
                                        prepend-icon="mdi-lock"
                                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                        :type="show1 ? 'text' : 'password'"
                                        @click:append="show1 = !show1"
                                        :error-messages="error.password"
                                        required
                                        @keyup="clearError('password')"
                                        :rules="rules.password"
                                        solo
                                    />
                                </v-col>
                                <v-col md="2" class="mr-1 mt-1">
                                    <CButton type="submit" size="lg" color="primary" @click="autoGenerate">
                                        <!--                                    <CIcon name="cil-check-circle"/>-->
                                        {{ $t('button.auto') }}
                                    </CButton>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="closePassword">{{
                                $t('button.cancel')
                            }}
                        </v-btn>
                        <v-btn color="blue darken-1" text @click="passwordChangeConfirm">
                            {{ $t('button.confirm') }}
                        </v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<script>
import config from "../../../config";
import store from "../../../store";
import i18n from "../../../i18n";
import ApiServices from "../../../services/ApiServices";
import route from "../../../router";

export default {
    name: "TableWrapper",
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        search: '',
        search1: '',
        search2: '',
        tabs: null,
        passwords: '',
        show1: false,
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        userType: null,
        dialogPassword: false,
        editedItem: {
            id: null,
            password: '',
        },
        editedIndex: -1,
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
        error: {
            password: '',
        },
        admins: [],
        directors: [],
        storeUsers: [],
        staffs: [],
        tableLoad: true,
        rules: {
            password: [
                v => !!v || i18n.t('validation.required'),
                v => (v && v.length >= 8) || i18n.t('validation.morethan'),
                v => /(?=.*[A-Z])/.test(v) || i18n.t('validation.uppercase'),
                v => /(?=.*\d)/.test(v) || i18n.t('validation.numeric'),
                v => /([!@$%:])/.test(v) || i18n.t('validation.special')
            ],
        },
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

        async changePassword(item) {
            this.editedItem = Object.assign({}, item)
            this.dialogPassword = true
        },

        deleteItem(item, type) {
            this.userType = type;
            if (type === 'director') {
                this.editedIndex = this.directors.indexOf(item)
            } else if (type === 'store') {
                this.editedIndex = this.storeUsers.indexOf(item)
            } else if (type === 'staff') {
                this.editedIndex = this.staffs.indexOf(item)
            }
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.userDelete(this.editedItem.id);
            if (res.success === true) {
                if (this.type === 'director') {
                    this.directors.splice(this.editedIndex, 1)
                } else if (this.type === 'store') {
                    this.storeUsers.splice(this.editedIndex, 1)
                } else if (this.type === 'staff') {
                    this.staffs.splice(this.editedIndex, 1)
                }
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

        closePassword() {
            this.dialogPassword = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
                this.passwords = '';
            })
        },

        clearError(name) {
            if (name === 'password') {
                this.error.password = '';
            }
        },

        async autoGenerate() {
            let res = await ApiServices.autoGeneratePassword();
            if (res.success === true) {
                this.editedItem.password = res.data;
                this.passwords = this.editedItem.password;
            }
        },

        async passwordChangeConfirm() {
            this.progressL = true;
            const data = new FormData();
            if (this.editedItem.password !== null && this.editedItem.password !== '') {
                data.append('password', this.passwords);
            }

            if (this.editedItem.id !== null && this.editedItem.id !== '') {
                data.append('id', this.editedItem.id);
            }

            let res = await ApiServices.passwordReset(data);
            if (res.success === true) {
                this.progressL = false;
                this.dialogPassword = false;
                this.passwords = '';
            }
        }
    },
}
</script>


<style scoped>
.add-btn {
    color: #fff !important;
}

.password-btn {
    cursor: pointer;
}
</style>
