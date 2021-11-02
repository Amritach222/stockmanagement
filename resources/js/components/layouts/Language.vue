<template>
    <v-select
        v-model=selectedLanguage
        :items="langs"
        label="Language"
        dense
        solo
        prepend-icon="mdi-web"
        item-text="Language"
        item-value="val"
    ></v-select>
</template>

<script>
import store from "../../store";

export default {
    name: "Language",
    data: () => ({
            langs: [
                {Language: 'English', val: 'en'},
                {Language: 'नेपाली', val: 'np'}
            ],
            selectedLanguage: 'en'
        }
    ),

    watch: {
        selectedLanguage: function (val) {
            this.$i18n.locale = val;
            localStorage.setItem('lang',val);
            store.state.home.lang = val
            store.state.home.snackbar = true;
            store.state.home.snackbarText = this.$i18n.t('languageChangedTo');
            store.state.home.snackbarColor = 'green';
        }
    },
    created() {
        this.selectedLanguage = localStorage.getItem('lang');
        store.state.home.lang = this.selectedLanguage;
    },
}
</script>

<style scoped>

</style>
