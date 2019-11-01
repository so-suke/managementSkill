<template>
  <div>
    <core-toolbar></core-toolbar>
    <core-drawer />
    <v-fade-transition mode="out-in">
      <router-view></router-view>
    </v-fade-transition>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";
import CoreToolbar from "@core/Toolbar.vue";
import CoreDrawer from "@core/Drawer.vue";
import CoreView from "@core/View.vue";

@Component({
  components: {
    CoreToolbar,
    CoreDrawer,
    CoreView
  }
})
export default class AdminWrapper extends Vue {
  private mounted(): void {
    this.fetchData();
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
