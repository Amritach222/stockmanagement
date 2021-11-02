<template>
    <div class="flex-row align-items-center">
        <CContainer>
            <CRow class="justify-content-center">
                <CCol sm="12">
                    <CCardGroup>
                        <CCard class="p-4">
                            <CCardHeader>
                                <strong>Edit</strong> Mail Template
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
                                            v-model="title"
                                            type="text"
                                            name="title"
                                            description="Please enter mail title."
                                            prepend-inner-icon="mdi-email-edit"
                                            autocomplete=""
                                            label="Mail Title"
                                            placeholder="Enter mail title..."
                                            required
                                            @keyup="clearError('title')"
                                            @keyup.enter="edit"
                                            :rules="rules.title"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="content"
                                            type="textarea"
                                            name="content"
                                            description="Please enter mail content."
                                            prepend-inner-icon="mdi-content-save"
                                            autocomplete=""
                                            label="Mail Content"
                                            placeholder="Enter mail content..."
                                            required
                                            @keyup="clearError('content')"
                                            @keyup.enter="edit"
                                            :rules="rules.content"
                                            solo
                                        />
                                        <v-text-field
                                            v-model="view_page"
                                            type="text"
                                            name="view_page"
                                            description="Please enter mail view page."
                                            prepend-inner-icon="mdi-content-paste"
                                            autocomplete=""
                                            label="Mail View Page"
                                            placeholder="Enter mail view page..."
                                            required
                                            @keyup="clearError('view_page')"
                                            @keyup.enter="edit"
                                            :rules="rules.view_page"
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
    name: "MailTemplateEdit",

    props: {
        source: String,
    },
    data: () => ({
        title: '',
        content: '',
        view_page: '',
        changeProgress: false,
        error: {
            title: '',
            content: '',
            view_page: '',
        },
        rules: {
            title: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            content: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            view_page: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'title') {
                this.error.title = '';
            }
            if (name === 'content') {
                this.error.content = '';
            }
            if (name === 'view_page') {
                this.error.view_page = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            store.state.settings.title = this.title;
            store.state.settings.content = this.content;
            store.state.settings.view_page = this.view_page;
            store.state.settings.id = this.$route.params.id;
            let res = await store.dispatch('settings/mailTemplateEdit');
            this.changeProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
