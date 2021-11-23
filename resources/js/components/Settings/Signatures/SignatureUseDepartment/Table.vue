<template>
    <v-card>
        <v-card-title>
            {{ $t('signature') +' '+ $t('use') +' '+ $t('departments') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="signatureUseDepartments"
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
                            >
                                {{ $t('button.add_new_signature_use_department') }}
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
                                                <v-select
                                                    v-model="editedItem.department_id"
                                                    :label="$t('department')"
                                                    :items="departments"
                                                    item-text="name"
                                                    item-value="id"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-select>
                                            </v-col>
                                        </v-row>
                                        <v-row>
                                            <v-col>
                                                <v-select
                                                    v-model="editedItem.signature_id"
                                                    :label="$t('signature')"
                                                    :items="signatures"
                                                    :item-text="signature => signature.user_name +' - '+ signature.designation_name"
                                                    item-value="id"
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
            <template v-slot:item.department_id="{ item }">
                <p v-if="item.department_id">{{ item.department_name }}</p>
            </template>
            <template v-slot:item.signature_id="{ item }">
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
import config from "../../../../config";
import store from "../../../../store";
import ApiServices from "../../../../services/ApiServices";
import i18n from "../../../../i18n";

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
            {text: i18n.t('id'), align: 'start', sortable: false, value: 'id'},
            {text: i18n.t('department'), value: 'department_id'},
            {text: i18n.t('signature'), value: 'signature_id'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        signatures: [],
        signatureUseDepartments: [],
        departments: [],
        editedIndex: -1,
        editedItem: {
            id: null,
            signature_id: '',
            department_id: '',
        },
        defaultItem: {
            id: null,
            signature_id: '',
            department_id: '',
        },
        rules: [
            value => !!value || 'Required.',
        ],
        tableLoad: false
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? i18n.t('card_title.add_signature_use_department') : i18n.t('card_title.edit_signature_use_department')
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
        this.loadDepartments();
        this.loadSignatures();
    },

    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadItems() {
            let res = await ApiServices.signatureUseDepartmentIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.signatureUseDepartments = res.data;
            }
        },
        async loadDepartments() {
            let res = await ApiServices.departmentIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.departments = res.data;
            }
        },
        async loadSignatures() {
            let res = await ApiServices.signatureIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.signatures = res.data;
            }
        },
        editItem(item) {
            this.editedIndex = this.signatureUseDepartments.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true
        },

        deleteItem(item) {
            this.editedIndex = this.signatureUseDepartments.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialogDelete = true
        },

        async deleteItemConfirm() {
            let res = await ApiServices.signatureUseDepartmentDelete(this.editedItem.id);
            if (res.success === true) {
                this.signatureUseDepartments.splice(this.editedIndex, 1)
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
                    data.append('signature_id', this.editedItem.signature_id);
                    data.append('department_id', this.editedItem.department_id);
                    let res = await ApiServices.signatureUseDepartmentEdit(this.editedItem.id, data);
                    if (res.success === true) {
                        Object.assign(this.signatureUseDepartments[this.editedIndex], this.editedItem)
                        this.$refs.form.reset();
                        this.close();
                    }
                } else {
                    //add new

                    this.progressL = true;
                    const data = new FormData();
                    data.append('signature_id', this.editedItem.signature_id);
                    data.append('department_id', this.editedItem.department_id);
                    let res = await ApiServices.signatureUseDepartmentCreate(data);
                    if (res.success === true) {
                        this.signatureUseDepartments.push(this.editedItem);
                        this.$refs.form.reset();
                        this.close()
                    }
                }
            }
        },
        validateData() {
            this.$refs.form.validate();
            if (this.editedItem.signature_id === '') {
                this.validated1 = false
            } else {
                this.validated1 = true
            }
            if (this.editedItem.department_id === '') {
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
