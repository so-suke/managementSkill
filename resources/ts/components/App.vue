<template>
  <v-app id="app">
    <v-snackbar v-model="snackbar" top>
      <span>こんちには！{{ this.fullName }}さん</span>
      <v-btn color="pink" text @click="snackbar = false">Close</v-btn>
    </v-snackbar>
    <core-view />
  </v-app>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";
import CoreView from "../core/View.vue";
import { AppModule } from "@modules/app";
@Component({
  components: {
    CoreView
  }
})
export default class App extends Vue {
  get fullName() {
    return `${this.$store.state.authenticationModule.user.last_name} ${
      this.$store.state.authenticationModule.user.first_name
    }`;
  }

  get snackbar() {
    return AppModule.isShowSnackbar;
  }
  set snackbar(snackbar: boolean) {
    AppModule.setIsShowSnackbar(snackbar);
  }
}
</script>
