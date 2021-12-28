<template>
    <v-card>
        <v-card-title>
            {{ $t('roles') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="roles"
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
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
                <router-link
                    :to="'/roles/permission/'+item.name"
                    v-if="$can('permissions')"
                >
                <v-icon
                    small
                    class="mr-2"
                >
                    mdi-account-check
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
import config from "../../../config";
import store from "../../../store";
import ApiServices from "../../../services/ApiServices";
import i18n from "../../../i18n";

export default {
    name: "TableWrapper",
    data: () => ({
        cdnURL: config.cdnURL,
        search: '',
        validated: false,
        progressL: false,
        dialog: false,
        dialogDelete: false,
        headers: [
            {text: i18n.t('id'), align: 'start', sortable: false, value: 'id'},
            {text: i18n.t('name'), value: 'name'},
            {text: i18n.t('actions'), value: 'actions', sortable: false},
        ],
        roles: [],
        tableLoad: true
    }),

    async created() {
        this.loadItems();
    },

    methods: {
        async loadItems() {
            let res = await ApiServices.roleIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.roles = res.data;
            }
        },
    },
}
</script>


<style scoped>

</style>
