<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Settings
                                <v-progress-circular
                                    v-if="changeProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-form ref="form">
                                        <v-text-field
                                            v-model="editedItem.title"
                                            type="text"
                                            name="title"
                                            description="Please enter site title."
                                            prepend-inner-icon="mdi-alpha-c-circle"
                                            autocomplete=""
                                            label="Title"
                                            placeholder="Enter title..."
                                            required
                                            @keyup="clearError('title')"
                                            @keyup.enter="edit"
                                            :rules="rules.title"
                                            solo
                                        />
                                        <v-col v-if="typeof(editedItem.link) === 'string'">
                                            <v-card width="200"
                                                    v-on:click="openImage(editedItem.link)">
                                                <v-img
                                                    :src="cdnURL+editedItem.link"
                                                    height="125"
                                                    class="grey darken-4"
                                                ></v-img>
                                                <v-card-title class="title">
                                                    Logo
                                                </v-card-title>
                                            </v-card>
                                            <v-file-input
                                                v-model="editedItem.image"
                                                label="Logo"
                                                filled
                                                outlined
                                                prepend-icon="mdi-camera"
                                                accept="image/png,image/jpeg,image/jpg"
                                            ></v-file-input>
                                        </v-col>
                                        <v-col v-else>
                                            <v-file-input
                                                v-model="editedItem.image"
                                                label="Logo"
                                                filled
                                                outlined
                                                prepend-icon="mdi-camera"
                                                accept="image/png,image/jpeg,image/jpg"
                                            ></v-file-input>
                                        </v-col>
                                        <v-select
                                            v-model="editedItem.fiscal_year_id"
                                            type="text"
                                            name="fiscal_year_id"
                                            :items="options"
                                            :item-text="option => option.from +' || '+ option.to"
                                            item-value="id"
                                            description="Please select system current fiscal year."
                                            prepend-inner-icon="mdi-calendar-month"
                                            autocomplete=""
                                            label="Fiscal Year"
                                            placeholder="Select current fiscal year..."
                                            @keyup="clearError('fiscal_year_id')"
                                            @keyup.enter="edit"
                                            :rules="rules.fiscal_year_id"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.currency"
                                            type="text"
                                            name="currency"
                                            description="Please enter site currency."
                                            prepend-inner-icon="mdi-currency-usd"
                                            autocomplete=""
                                            label="Currency"
                                            placeholder="Enter currency..."
                                            @keyup="clearError('currency')"
                                            @keyup.enter="edit"
                                            :rules="rules.currency"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.time_zone"
                                            :items="timezones"
                                            item-text="label"
                                            name="time_zone"
                                            description="Please enter site time zone."
                                            prepend-inner-icon="mdi-clock"
                                            autocomplete=""
                                            label="Time Zone"
                                            placeholder="Enter time zone..."
                                            @keyup="clearError('time_zone')"
                                            @keyup.enter="edit"
                                            :rules="rules.time_zone"
                                            solo
                                        />
                                        <v-select
                                            v-model="editedItem.date_format"
                                            type="text"
                                            prepend-inner-icon="mdi-calendar-month"
                                            :items="['y-m-d','y/m/d','d-m-y','d/m/y','m-d-y']"
                                            autocomplete=""
                                            label="Date Format"
                                            placeholder="Select date format..."
                                            :rules="rules.date_format"
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
                                    </CCardFooter>
                                </CForm>
                            </CCardBody>
                        </CCard>
                    </CCardGroup>
                </CCol>
            </CRow>
        </CContainer>
    </div>
</template>

<script>
    import store from "../../../store";
    import route from "../../../router";
    import i18n from "../../../i18n";
    import ApiServices from "../../../services/ApiServices";
    import config from "../../../config";
    import timezoneList from "../../../services/lib/timezone.json";
    import countryList from "../../../services/lib/country.json";

    export default {
        name: "SettingIndex",

        data: () => ({
            cdnURL: config.cdnURL,
            options: [],
            timezones: [],
            changeProgress: false,
            editedItem: {
                id: null,
                title: '',
                currency: '',
                time_zone: '',
                date_format: '',
                fiscal_year_id: '',
                image: [],
            },
            error: {
                title: '',
                logo: '',
                currency: '',
                time_zone: '',
                date_format: '',
                fiscal_year_id: '',
            },
            rules: {
                title: [
                    val => (val || '').length > 0 || i18n.t('validation.required'),
                ],
                // currency: [
                //     val => (val || '').length > 0 || i18n.t('validation.required'),
                // ],
                // time_zone: [
                //     val => (val || '').length > 0 || i18n.t('validation.required'),
                // ],
                // date_format: [
                //     val => (val || '').length > 0 || i18n.t('validation.required'),
                // ],
            },
        }),

        async created() {
            this.loadData();
            this.fiscalYear();
            this.timezones = timezoneList;
        },

        methods: {
            openImage(data) {
                window.open(config.cdnURL + data, `_blank`);
            },
            async loadData() {
                let res = await ApiServices.settingShow(1);
                if (res.success === true) {
                    this.editedItem = res.data;
                }
            },
            async fiscalYear() {
                let res = await ApiServices.selectList('fiscalYear');
                if (res.success === true) {
                    this.options = res.data;
                }
            },
            clearError(name) {
                if (name === 'title') {
                    this.error.title = '';
                }
                if (name === 'currency') {
                    this.error.currency = '';
                }
                if (name === 'time_zone') {
                    this.error.time_zone = '';
                }
                if (name === 'date_format') {
                    this.error.date_format = '';
                }
                if (name === 'fiscal_year_id') {
                    this.error.fiscal_year_id = '';
                }
                if (name === 'image') {
                    this.error.image = '';
                }
            },
            async edit() {
                this.validateData();
                if (this.validated === true) {
                    this.changeProgress = true;
                    const data = new FormData();

                    data.append('title', this.editedItem.title);
                    data.append('currency', this.editedItem.currency);
                    data.append('time_zone', this.editedItem.time_zone);
                    data.append('date_format', this.editedItem.date_format);
                    if (this.editedItem.fiscal_year_id !== null) {
                        data.append('fiscal_year_id', this.editedItem.fiscal_year_id);
                    }

                    if ('image' in this.editedItem) {
                        if (typeof this.editedItem.image.name == 'string') {
                            data.append('image', this.editedItem.image);
                        }
                    }

                    let res = await ApiServices.settingEdit(this.editedItem.id, data);
                    if (res.success === true) {
                        this.loadData()
                        this.$root.$emit('sidebarComponent')
                    }
                    this.changeProgress = false;
                }

            },
            validateData() {
                this.$refs.form.validate();
                if (this.editedItem.title === '') {
                    this.validated = false
                } else {
                    this.validated = true
                }
            }
        }
    }
</script>
