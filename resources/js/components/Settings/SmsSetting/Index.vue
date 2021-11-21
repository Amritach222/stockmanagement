<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Sms Setting
                                <v-progress-circular
                                    v-if="changeProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-form>
                                        <v-text-field
                                            v-model="edited.gateway"
                                            type="text"
                                            name="gateway"
                                            description="Please enter sms gateway."
                                            prepend-inner-icon="mdi-door-open"
                                            autocomplete=""
                                            :label="$t('gateway')"
                                            placeholder="Enter gateway..."
                                            required
                                            @keyup="clearError('gateway')"
                                            @keyup.enter="edit"
                                            :rules="rules.gateway"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="edited.api_key"
                                            type="text"
                                            name="api_key"
                                            description="Please enter sms api key."
                                            prepend-inner-icon="mdi-key-variant"
                                            autocomplete=""
                                            :label="$t('api_key')"
                                            placeholder="Enter api key..."
                                            required
                                            @keyup="clearError('api_key')"
                                            @keyup.enter="edit"
                                            :rules="rules.api_key"
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
                                            <CIcon name="cil-check-circle"/>
                                            {{ $t('button.submit') }}
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

export default {
    name: "SmsSettingIndex",

    props: {
        source: String,
    },
    data: () => ({
        edited: {
            gateway: '',
            api_key: '',
        },
        changeProgress: false,
        error: {
            gateway: '',
            api_key: '',
        },
        rules: {
            gateway: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            api_key: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    async created() {
        this.loadData();
    },
    methods: {
        async loadData() {
            let res = await ApiServices.smsSettingShow(1);
            if (res.success === true) {
                this.edited = res.data;
            }
        },
        clearError(name) {
            if (name === 'gateway') {
                this.error.gateway = '';
            }
            if (name === 'api_key') {
                this.error.api_key = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            store.state.settings.gateway = this.edited.gateway;
            store.state.settings.api_key = this.edited.api_key;
            store.state.settings.id = this.edited.id;
            let res = await store.dispatch('settings/smsSettingEdit');
            this.changeProgress = false;
            // if (res === true) {
            //     route.replace('/');
            // }
        },
    }
}
</script>
