<template>
  <v-app id="app">
    <v-snackbar v-model="snackbar" top>
      hello
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
  // private snackbar: boolean = AppModule.isShowSnackbar;
  private mounted(): void {
    this.fetchData();
  }
  get snackbar() {
    return AppModule.isShowSnackbar;
  }
  set snackbar(snackbar: boolean) {
    console.log(snackbar);
    AppModule.setIsShowSnackbar(snackbar);
  }
  private fetchData() {
    // window.axios
    //   .get(`/api/employees`)
    //   .then(res => {
    //     console.log(res.data);
    //   })
    //   .catch(err => {
    //     console.log(err);
    //   });
  }
}
</script>
