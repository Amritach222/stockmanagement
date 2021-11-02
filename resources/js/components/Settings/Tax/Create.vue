<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Add</strong> Tax
                                <v-progress-circular
                                    v-if="createProgress"
                                    indeterminate
                                    color="white"
                                    size="30"
                                ></v-progress-circular>
                            </CCardHeader>
                            <CCardBody>
                                <CForm>
                                    <v-form>
                                        <v-text-field
                                            v-model="name"
                                            type="text"
                                            name="name"
                                            description="Please enter tax name."
                                            prepend-inner-icon="mdi-credit-card-outline"
                                            autocomplete=""
                                            label="Name"
                                            placeholder="Enter tax name..."
                                            required
                                            @keyup="clearError('name')"
                                            @keyup.enter="create"
                                            :rules="rules.name"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="value"
                                            type="number"
                                            name="value"
                                            description="Please enter tax value."
                                            prepend-inner-icon="mdi-percent"
                                            autocomplete=""
                                            label="Value"
                                            placeholder="Enter tax value..."
                                            required
                                            @keyup="clearError('value')"
                                            @keyup.enter="create"
                                            :rules="rules.value"
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="create">
                                            <CIcon name="cil-check-circle"/>
                                            Submit
                                        </CButton>
                                        <CButton type="reset" size="sm" color="danger">
                                            <CIcon name="cil-ban"/>
                                            Reset
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

export default {
    name: "TaxCreate",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        value: '',
        createProgress: false,
        error: {
            name: '',
            value: '',
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            value: [
                val => val >= 0 || i18n.t('validation.required'),
                val => Number.isInteger(Number(val)) || "The value must be number",
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'name') {
                this.error.name = '';
            }
            if (name === 'value') {
                this.error.value = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.settings.name = this.name;
            store.state.settings.value = this.value;
            let res = await store.dispatch('settings/taxCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
