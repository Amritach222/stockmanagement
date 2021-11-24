<template>
    <CRow>
        <CCol sm="12">
            <CCard>
                <CCardHeader>
                    <strong>Add</strong> Item Attribute
                    <v-progress-circular
                        v-if="createProgress"
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
                            :label="$t('name')"
                            placeholder="Enter attribute name..."
                            required
                            @keyup="clearError('name')"
                            @keyup.enter="create"
                            :rules="rules.name"
                        />
                        <CSelect
                            v-model="attribute_group_id"
                            name="attribute_group_id"
                            description="Please select attribute group."
                            autocomplete=""
                            :label="$t('attribute_group')"
                            placeholder="Select attribute group..."
                            required
                            @keyup="clearError('attribute_group_id')"
                            @keyup.enter="create"
                            :rules="rules.attribute_group_id"
                        />
                    </CCardBody>
                    <CCardFooter>
                        <CButton type="submit" size="sm" color="primary" @click="create">
                            <CIcon name="cil-check-circle"/>
                            {{ $t('button.submit') }}
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
    name: "ItemAttributeCreate",

    props: {
        source: String,
    },
    data: () => ({
        name: '',
        attribute_group_id: '',
        createProgress: false,
        error: {
            name: '',
        },
        rules: {
            name: [
                val => (val || '').length > 0 || i18n.t('validation.required'),
            ],
            attribute_group_id: [
                val => i18n.t('validation.required'),
            ],
        },
    }),
    methods: {
        clearError(name) {
            if (name === 'name') {
                this.error.name = '';
            }
        },
        async create() {
            this.createProgress = true;
            store.state.products.name = this.name;
            store.state.products.attribute_group_id = this.attribute_group_id;
            let res = await store.dispatch('products/itemAttributeCreate');
            this.createProgress = false;
            if (res === true) {
                route.replace('/index');
            }
        },
    }
}
</script>
