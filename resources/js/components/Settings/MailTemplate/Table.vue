<template>
    <v-card>
        <v-card-title>
            Mail Templates
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="mailTemplates"
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
                        <!--                        <template v-slot:activator="{ on, attrs }">-->
                        <!--                            <v-btn-->
                        <!--                                color="green"-->
                        <!--                                dark-->
                        <!--                                class="mb-2"-->
                        <!--                                v-bind="attrs"-->
                        <!--                                v-on="on"-->
                        <!--                            >-->
                        <!--                                Add New Mail Template-->
                        <!--                            </v-btn>-->
                        <!--                        </template>-->
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
                                                    v-model="editedItem.title"
                                                    :label="$t('name')"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-text-field>
                                                <v-select
                                                    v-model="editedItem.view_page"
                                                    :label="$t('view_page')"
                                                    :items="['mail.notice','mail.password_change','mail.reset_password','mail.welcome']"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-select>
                                                <v-textarea
                                                    v-model="editedItem.content"
                                                    :label="$t('content')"
                                                    required
                                                    outlined
                                                    :rules="rules"
                                                ></v-textarea>
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
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <v-icon
                    small
                    class="mr-2"
                    @click="editItem(item)"
                >
                    mdi-pencil
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
            validated1: false,
            validated2: false,
            progressL: false,
            dialog: false,
            dialogDelete: false,
            headers: [
                {text: 'Id', align: 'start', sortable: false, value: 'id'},
                {text: 'Title', value: 'title'},
                {text: 'View Page', value: 'view_page'},
                {text: 'Actions', value: 'actions', sortable: false},
            ],
            mailTemplates: [],
            editedIndex: -1,
            editedItem: {
                id: null,
                title: '',
                view_page: '',
                content: '',
            },
            defaultItem: {
                id: null,
                title: '',
                view_page: '',
                content: '',
            },
            rules: [
                value => !!value || 'Required.',
            ],
            tableLoad: false
        }),

        computed: {
            formTitle() {
                return this.editedIndex === -1 ? 'Add Mail Template' : 'Edit Mail Template'
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
                let res = await ApiServices.mailTemplateIndex();
                if (res.success === true) {
                    this.tableLoad = false;
                    this.mailTemplates = res.data;
                }
            },
            editItem(item) {
                this.editedIndex = this.mailTemplates.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
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
                if (this.validated1 === true && this.validated2 === true) {
                    if (this.editedIndex > -1) {
                        //edit goes here
                        this.progressL = true;
                        const data = new FormData();
                        data.append('title', this.editedItem.title);
                        data.append('view_page', this.editedItem.view_page);
                        data.append('content', this.editedItem.content);
                        let res = await ApiServices.mailTemplateEdit(this.editedItem.id, data);
                        if (res.success === true) {
                            Object.assign(this.mailTemplates[this.editedIndex], this.editedItem)
                            this.$refs.form.reset();
                            this.close();
                        }
                    }
                }
            },
            validateData() {
                this.$refs.form.validate();
                if (this.editedItem.title === '') {
                    this.validated1 = false
                } else {
                    this.validated1 = true
                }
                if (this.editedItem.view_page === '') {
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
