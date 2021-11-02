<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Fiscal Year
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
                                            v-model="from"
                                            type="date"
                                            name="from"
                                            description="Please enter fiscal year start date."
                                            prepend-inner-icon="mdi-calender"
                                            autocomplete=""
                                            label="From"
                                            placeholder="Enter fiscal year start date..."
                                            required
                                            @keyup="clearError('from')"
                                            @keyup.enter="edit"
                                            :rules="rules.from"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="to"
                                            type="date"
                                            name="to"
                                            description="Please enter fiscal year end date."
                                            prepend-inner-icon="mdi-calender"
                                            autocomplete=""
                                            label="To"
                                            placeholder="Enter fiscal year end date..."
                                            @keyup="clearError('to')"
                                            @keyup.enter="edit"
                                            :rules="rules.to"
                                            solo
                                        />
                                    </v-form>
                                    <CCardFooter>
                                        <CButton type="submit" size="sm" color="primary" @click="edit">
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
    name: "FiscalYearEdit",

    props: {
        source: String,
    },
    data: () => ({
        from: '',
        to: '',
        changeProgress: false,
        error: {
            from: '',
            to: '',
        },
        rules: {
            from: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            to: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'from') {
                this.error.from = '';
            }
            if (name === 'to') {
                this.error.to = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            store.state.settings.from = this.from;
            store.state.settings.to = this.to;
            store.state.settings.id = this.$route.params.id;
            let res = await store.dispatch('settings/fiscalYearEdit');
            this.changeProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
