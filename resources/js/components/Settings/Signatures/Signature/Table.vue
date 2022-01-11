<template>
    <v-card>
        <v-card-title>
            Signatures
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="signatures"
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
                                v-if="$can('signatures.create')"
                            >
                                Add New Signature
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
                                            <v-col v-if="typeof(editedItem.link) === 'string'">
                                                <v-card width="200"
                                                        v-on:click="openImage(editedItem.link)">
                                                    <v-img
                                                        :src="cdnURL+editedItem.link"
                                                        height="125"
                                                        class="grey darken-4"
                                                    ></v-img>
                                                    <v-card-title class="title">
                                                        Image
                                                    </v-card-title>
                                                </v-card>
                                                <v-file-input
                                                    v-model="editedItem.image"
                                                    label="Image"
                                                    filled
                                                    outlined
                                                    prepend-icon="mdi-camera"
                                                    accept="image/png,image/jpeg,image/jpg"
                                                ></v-file-input>
                                            </v-col>
                                            <v-col v-else>
                                                <v-file-input
                                                    v-model="editedItem.image"
                                                    label="Image"
                                                    filled
                                                    outlined
                                                    required
                                                    prepend-icon="mdi-camera"
                                                    accept="image/png,image/jpeg,image/jpg"
                                                ></v-file-input>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-select
                                                    v-model="editedItem.user_id"
                                                    label="User"
                                                    :items="users"
                                                    item-value="id"
                                                    item-text="name"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-select
                                                    v-model="editedItem.designation_id"
                                                    label="Designation"
                                                    :items="designations"
                                                    item-value="id"
                                                    item-text="name"
                                                    outlined
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
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="save"
                                    >
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-form>
                        </v-card>
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
            <template v-slot:item.user_id="{ item }">
                <p v-if="item.user_id">{{ item.user_name }}</p>
            </template>
            <template v-slot:item.designation_id="{ item }">
                <p v-if="item.designation_id">{{ item.designation_name }}</p>
            </template>
            <template v-slot:item.link="{ item }">
                <img :src=cdnURL+item.link
                     v-if="item.link"
                     style="width: 50px; height: 50px"
                     v-on:click="openImage(item.link)"/>

                <img :src="baseURL+'images/placeholder.jpg'"
                     v-else
                     style="width: 50px; height: 50px; object-fit: cover"
                />
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                    v-if="$can('signatures.edit')"
                >
                    mdi-pencil
                </v-icon>
                <v-icon
                    small
                    @click="deleteItem(item)"
                    v-if="$can('signatures.delete')"
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
import config from "../../../../config";
import store from "../../../../store";
import ApiServices from "../../../../services/ApiServices";

export default {
    name: "TableWrapper",
    data: () => ({
        cdnURL: config.cdnURL,
        baseURL: config.baseURL,
        search: '',
        validated1: false,
        validated2: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: 'Id', align: 'start', sortable: false, value: 'id'},
            {text: 'User', value: 'user_id'},
            {text: 'Logo', value: 'link'},
            {text: 'Designation', value: 'designation_id'},
            {text: 'Actions', value: 'actions', sortable: false},
        ],
        signatures: [],
        designations: [],
        users: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            user_id: '',
            designation_id: '',
            image: [],
        },
        defaultItem: {
            id: null,
            user_id: '',
            designation_id: '',
            image: [],
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: true
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? 'Add Signature' : 'Edit Signature'
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
        this.loadDesignations();
        this.loadUsers();
    },

    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.signatureIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.signatures = res.data;
            }
        },
        async loadDesignations() {
            let res = await ApiServices.designationIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.designations = res.data;
            }
        },
        async loadUsers() {
            let res = await ApiServices.userIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.users = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.signatures.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.signatures.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.signatureDelete(this.editedItem.id);
            if (res.success === true) {
                this.signatures.splice(this.editedIndex, 1)
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
            if (this.validated1 && this.validated2) {
            if (this.editedIndex > -1) {
                //edit goes here
                this.progressL = true;
                const data = new FormData();
                data.append('user_id', this.editedItem.user_id);
                if (this.editedItem.designation_id !== null) {
                    data.append('designation_id', this.editedItem.designation_id);
                }
                if ('image' in this.editedItem) {
                    if (typeof this.editedItem.image.name == 'string') {
                        data.append('image', this.editedItem.image);
                    }
                }
                let res = await ApiServices.signatureEdit(this.editedItem.id, data);
                if (res.success === true) {
                    Object.assign(this.signatures[this.editedIndex], this.editedItem)
                    this.$refs.form.reset();
                    this.close();
                }
            } else {
                //add new

                    this.progressL = true;
                    const data = new FormData();
                    data.append('user_id', this.editedItem.user_id);
                    if (this.editedItem.designation_id !== '') {
                        data.append('designation_id', this.editedItem.designation_id);
                    }
                    if (typeof this.editedItem.image.name == 'string') {
                        data.append('image', this.editedItem.image);
                    }
                    let res = await ApiServices.signatureCreate(data);
                    if (res.success === true) {
                        this.signatures.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.user_id === '') {
                this.validated1 = false
            } else {
                this.validated1 = true
            }
            if (this.editedItem.user === []) {
                this.validated2 = false
            } else {
                this.validated2 = true
            }
        }
    },
}
</script>


<style scoped>

</style>
