<template>
    <v-snackbar
        v-model="snackbar"
        :color="snackbarColor"
        bottom
        :timeout="snackbarTimeout"
    >{{ snackbarText }}
    </v-snackbar>
</template>

<script>
import store from "../../store";

export default {
    name: "Snackbar",
    data() {
        return {
            snackbarTimeout: 2000,
            snackbar: false,
            snackbarText: '',
            snackbarColor: '',
            toasts: []
        }
    },
    created() {
        store.watch(state => state.home.snackbarText, () => {
            if (store.state.home.snackbar) {
                this.snackbar = true;
                this.snackbarText = store.state.home.snackbarText;
                this.snackbarColor = store.state.home.snackbarColor;
                store.commit('home/resetState');
            }
        });
    }
}
</script>

<style scoped>

</style>
