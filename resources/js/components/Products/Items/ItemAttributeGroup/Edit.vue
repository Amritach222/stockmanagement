<template>
    <CRow>
        <CCol sm="12">
            <CCard>
                <CCardHeader>
                    <strong>Edit</strong> Item Attribute Group
                    <v-progress-circular
                        v-if="changeProgress"
                        indeterminate
                        color="white"
                        size="30"
                    ></v-progress-circular>
                </CCardHeader>
                <CForm>
                    <CCardBody>
                        <CInput
                            v-model="name"
                            type="text"
                            name="name"
                            description="Please enter attribute group name."
                            autocomplete=""
                            label="Name"
                            placeholder="Enter attribute group name..."
                            required
                            @keyup="clearError('name')"
                            @keyup.enter="edit"
                            :rules="rules.name"
                        />
                    </CCardBody>
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
            </CCard>
        </CCol>
    </CRow>
</template>

<script>
import store from "../../../../store";
import route from "../../../../router";
import i18n from "../../../../i18n";

export default {
    name: "ItemAttributeGroupEdit",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        changeProgress: false,
        error: {
            name: '',
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'name') {
                this.error.name = '';
            }
        },
        async edit() {
            this.changeProgress = true;
            store.state.products.name = this.name;
            let res = await store.dispatch('products/itemAttributeGroupEdit');
            this.changeProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
