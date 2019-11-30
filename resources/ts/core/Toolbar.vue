<template>
  <v-app-bar app style="background: #fff;">
    <div class="v-toolbar-title">
      <v-toolbar-title class="tertiary--text font-weight-light">
        <v-btn v-if="responsive" class="default v-btn--simple" dark icon @click.stop="onClickBtn">
          <v-icon>mdi-view-list</v-icon>
        </v-btn>
        {{ title }}
      </v-toolbar-title>
    </div>

    <v-spacer />
    <v-toolbar-items>
      <v-flex align-center layout py-2>
        <router-link v-ripple class="toolbar-items" :to="{ name: 'Your Profile'}">
          <v-avatar size="50px">
            <img :src="this.$store.state.authenticationModule.user.profile_image_path" alt />
            <!-- <img src="https://cdn.vuetifyjs.com/images/cards/halcyon.png" alt /> -->
          </v-avatar>
        </router-link>
      </v-flex>
    </v-toolbar-items>
  </v-app-bar>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";
import { AppModule } from "@modules/app";

@Component({})
export default class Toolbar extends Vue {
  private title: string = "";
  private responsive: boolean = false;

  private mounted() {
    this.onResponsiveInverted();
    window.addEventListener("resize", this.onResponsiveInverted);
  }

  private beforeDestroy() {
    window.removeEventListener("resize", this.onResponsiveInverted);
  }

  private onResponsiveInverted() {
    if (window.innerWidth < 991) {
      this.responsive = true;
    } else {
      this.responsive = false;
    }
  }

  private onClickBtn() {
    AppModule.setDrawer(!AppModule.drawer);
  }
  private onClick() {
    //
  }
}
</script>
