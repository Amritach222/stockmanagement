<template>
    <CRow>
        <CCol sm="12">
            <CCard>
                <CCardHeader>
                    <strong>Edit</strong> Item Attribute
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
                            description="Please enter attribute name."
                            autocomplete=""
                            label="Name"
                            placeholder="Enter attribute name..."
                            required
                            @keyup="clearError('name')"
                            @keyup.enter="edit"
                            :rules="rules.name"
                        />
                        <CSelect
                            v-model="attribute_group_id"
                            name="attribute_group_id"
                            description="Please select attribute group."
                            autocomplete=""
                            label="Attribute Group"
                            placeholder="Select attribute group..."
                            required
                            @keyup="clearError('attribute_group_id')"
                            @keyup.enter="edit"
                            :rules="rules.attribute_group_id"
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
import store from "../../../store";
import route from "../../../router";
import i18n from "../../../i18n";

export default {
    name: "ItemAttributeEdit",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        attribute_group_id: '',
        changeProgress: false,
        error: {
            name: '',
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            attribute_group_id: [
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
            store.state.products.attribute_group_id = this.attribute_group_id;
            let res = await store.dispatch('products/itemAttributeEdit');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
