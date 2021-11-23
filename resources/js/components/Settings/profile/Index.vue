<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardBody>
                                <CForm>
                                    <v-form ref="form">
                                        <v-text-field
                                            v-model="editedItem.name"
                                            type="text"
                                            name="Name"
                                            description="Enter Name"
                                            :label="$t('name_of_user')"
                                            placeholder="Enter Name"
                                            :error-messages="error.name"
                                            @change="changeDetected('name')"
                                            @keyup="clearError('name')"
                                            @keyup.enter="edit"
                                            :rules="rules.name"
                                            solo
                                        />
                                        <v-col
                                            v-if="typeof(editedItem.link) !== '' && typeof(editedItem.link) !== null && typeof(editedItem.link) !== undefined">
                                            <v-card width="200"
                                                    v-on:click="openImage(editedItem.link)">
                                                <v-img
                                                    :src="cdnURL+editedItem.link"
                                                    height="125"
                                                    class="grey darken-4"
                                                ></v-img>
                                                <v-card-title class="title">
                                                    {{ $t('profile_picture') }}
                                                </v-card-title>
                                            </v-card>
                                            <v-file-input
                                                v-model="editedItem.image"
                                                :label="$t('profile_picture')"
                                                filled
                                                outlined
                                                :error-messages="error.image"
                                                prepend-icon="mdi-camera"
                                                accept="image/png,image/jpeg,image/jpg"
                                            ></v-file-input>
                                        </v-col>
                                        <v-col v-else>
                                            <v-file-input
                                                v-model="editedItem.image"
                                                :label="$t('profile_picture')"
                                                filled
                                                outlined
                                                :error-messages="error.image"
                                                prepend-icon="mdi-camera"
                                                accept="image/png,image/jpeg,image/jpg"
                                            ></v-file-input>
                                        </v-col>
                                        <v-text-field
                                            v-model="editedItem.address"
                                            type="text"
                                            name="address"
                                            description="Please enter address."
                                            autocomplete=""
                                            :label="$t('address')"
                                            placeholder="Enter address"
                                            :error-messages="error.address"
                                            @change="changeDetected('address')"
                                            @keyup="clearError('address')"
                                            @keyup.enter="edit"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.mobile_no"
                                            type="number"
                                            name="Mobile Number"
                                            description="Please enter mobile number"
                                            autocomplete=""
                                            :label="$t('mobile') +' '+ $t('number')"
                                            placeholder="Enter Mobile Number"
                                            :error-messages="error.mobile_no"
                                            @change="changeDetected('mobile_no')"
                                            @keyup="clearError('mobile_no')"
                                            @keyup.enter="edit"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="editedItem.password"
                                            :label="$t('password')"
                                            name="password"
                                            :rules="rules.password"
                                            prepend-inner-icon="mdi-lock"
                                            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                            :type="show1 ? 'text' : 'password'"
                                            @click:append="show1 = !show1"
                                            :error-messages="error.password"
                                            @change="changeDetected('password')"
                                            @keyup="clearError('password')"
                                            @keyup.enter="edit"
                                            solo
                                        ></v-text-field>
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
import config from "../../../config";

export default {
    name: "SettingIndex",

    data: () => ({
        cdnURL: config.cdnURL,
        options: [],
        show1: false,
        editedItem: {
            name: '',
            address: '',
            mobile_no: '',
            password: '',
            image: [],
            link: '',
        },
        error: {
            name: '',
            address: '',
            mobile_no: '',
            password: '',
            image: '',
        },
        rules: {
            password: [
                v => (v && v.length >= 8) || i18n.t('validation.morethan'),
                v => /(?=.*[A-Z])/.test(v) || i18n.t('validation.uppercase'),
                v => /(?=.*\d)/.test(v) || i18n.t('validation.numeric'),
                v => /([!@$%:])/.test(v) || i18n.t('validation.special')
            ],
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
        hasChanged: {
            name: false,
            address: false,
            mobile_no: false,
            password: false,
            image: false,
        },
    }),

    async created() {
        this.loadData();
    },

    methods: {
        openImage(data) {
            window.open(config.cdnURL + data, `_blank`);
        },
        async loadData() {
            let res = await ApiServices.getUserInformation();
            let profilePic = await ApiServices.getUserProfilePic();
            if (res.success === true) {
                this.editedItem = res.data;
                this.editedItem.link = profilePic.data;
            }
        },

        changeDetected(name) {
            if (name === 'name') {
                this.hasChanged.name = true;
            }
            if (name === 'address') {
                this.hasChanged.address = true;
            }
            if (name === 'mobile_no') {
                this.hasChanged.mobile_no = true;
            }
            if (name === 'password') {
                this.hasChanged.password = true;
            }
        },

        clearError(name) {
            if (name === 'name') {
                this.error.name = '';
            }
            if (name === 'address') {
                this.error.address = '';
            }
            if (name === 'mobile_no') {
                this.error.mobile_no = '';
            }
            if (name === 'password') {
                this.error.password = '';
            }
            if (name === 'image') {
                this.error.image = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            const data = new FormData();
            if (this.hasChanged.name) {
                data.append('name', this.editedItem.name);
            }
            if (this.hasChanged.address) {
                data.append('address', this.editedItem.address);
            }
            if (this.hasChanged.mobile_no) {
                data.append('mobile_no', this.editedItem.mobile_no);
            }
            if (this.hasChanged.password) {
                data.append('password', this.editedItem.password);
            }

            if ('image' in this.editedItem) {
                if (typeof this.editedItem.image.name == 'string') {
                    data.append('image', this.editedItem.image);
                }
            }
            let res = await ApiServices.editProfile(data);
            if (res.success === true) {
                this.loadData();
            }
            if (res.success === false) {
                if (res.data.password !== undefined) {
                    this.error.password = res.data.password[0]
                }
                if (res.data.name !== undefined) {
                    this.error.name = res.data.name[0]
                }
                if (res.data.image !== undefined) {
                    this.error.image = res.data.image[0]
                }
            }
        },
    }
}
</script>
