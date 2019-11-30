<template>
  <div>
    <v-dialog v-model="logoutDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">ログアウトしますか?</v-card-title>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="green darken-1" text @click="logoutDialog = false">キャンセル</v-btn>
          <v-btn color="green darken-1" text @click="logout">OK</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-navigation-drawer
      id="app-drawer"
      v-model="inputValue"
      :src="image"
      app
      color="grey darken-2"
      dark
      floating
      mobile-break-point="991"
      persistent
      width="260"
    >
      <template v-slot:img="attrs">
        <v-img v-bind="attrs" gradient="to top, rgba(0, 0, 0, .7), rgba(0, 0, 0, .7)" />
      </template>

      <v-list-item two-line>
        <v-list-item-avatar color="white">
          <v-img src="https://cdn.vuetifyjs.com/images/logos/v.png" height="34" contain />
        </v-list-item-avatar>

        <v-list-item-title class="title">VUETIFY MD</v-list-item-title>
      </v-list-item>

      <v-divider class="mx-3 mb-3" />

      <v-list nav>
        <!-- Bug in Vuetify for first child of v-list not receiving proper border-radius -->
        <div />

        <v-list-item
          v-for="(link, i) in links"
          :key="i"
          :to="link.to"
          active-class="primary white--text"
        >
          <v-list-item-action>
            <v-icon>{{ link.icon }}</v-icon>
          </v-list-item-action>

          <v-list-item-title v-text="link.text" />
        </v-list-item>
        <v-list-item @click="logoutDialog = true" active-class="primary white--text">
          <v-list-item-action>
            <v-icon>mdi-logout</v-icon>
          </v-list-item-action>

          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";
import { AppModule } from "@modules/app";
import { DrawerLinksModule } from "@modules/drawerLinks";

@Component({})
export default class CoreDrawer extends Vue {
  private logoutDialog: boolean = false;

  get image() {
    return AppModule.image;
  }

  get inputValue() {
    return AppModule.drawer;
  }
  set inputValue(val) {
    AppModule.setDrawer(val);
  }

  get links() {
    return DrawerLinksModule.drawerLinks;
  }

  private logout() {
    this.$store.commit("authenticationModule/setUser", {});
    this.$store.commit("authenticationModule/setIsLogin", false);
    this.$router.push({ name: "Login" });
  }
}
</script>
