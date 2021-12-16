<template>
    <v-card>
        <v-card-title>
            {{ $t('logs') }}
            <v-spacer></v-spacer>
        </v-card-title>
        <v-data-table
            :headers="headers"
            :items="logs"
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
            <template v-slot:no-data>
                <div>No Data</div>
            </template>
        </v-data-table>
    </v-card>
</template>

<script>
import store from "../../../store";
import ApiServices from "../../../services/ApiServices";
import i18n from "../../../i18n";

export default {
    name: "TableWrapper",
    data: () => ({
        search: '',
        progressL: false,
        headers: [
            {text: i18n.t('id'), align: 'start', sortable: false, value: 'id'},
            {text: i18n.t('activity') +' '+ i18n.t('name'), value: 'activity_name'},
            {text: i18n.t('ip'), value: 'ip'},
            {text: i18n.t('date'), value: 'date_time'},
        ],
        logs: [],
        tableLoad: true
    }),

    async created() {
        this.loadItems();
    },

    methods: {
        async loadItems() {
            let res = await ApiServices.logIndex();
            if (res.success === true) {
                this.tableLoad = false;
                this.logs = res.data;
            }
        },
    },
}
</script>


<style scoped>

</style>
