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
import { JobTitlesModule } from "@modules/jobTitles";
import { SkillModule } from "@modules/skill";
import { EmailModule } from "@modules/email";
import { DrawerLinksModule } from "@modules/drawerLinks";

@Component({
  components: {
    CoreToolbar,
    CoreDrawer,
    CoreView
  }
})
export default class AdminWrapper extends Vue {
  drawerLinks: any = {
    admin: [
      {
        to: {
          name: "Employee Profile",
          params: { id: this.$store.state.authenticationModule.user.id }
        },
        icon: "mdi-format-font",
        text: "Your Profile"
      },
      {
        to: { name: "Employee List" },
        icon: "mdi-view-dashboard",
        text: "Employee List"
      },
      {
        to: { name: "Append Employee" },
        icon: "mdi-account",
        text: "Append Employee"
      },
      {
        to: { name: "Skill List" },
        icon: "mdi-clipboard-outline",
        text: "Skill List"
      }
    ],
    noAdmin: [
      {
        to: {
          name: "Employee Profile",
          params: { id: this.$store.state.authenticationModule.user.id }
        },
        icon: "mdi-format-font",
        text: "Your Profile"
      },
      {
        to: { name: "Employee List" },
        icon: "mdi-view-dashboard",
        text: "Employee List"
      }
    ]
  };

  private created(): void {
    this.initDrawer();
    this.fetchData();
  }
  private initDrawer() {
    const user = this.$store.state.authenticationModule.user;
    if (user.is_admin === 1) {
      DrawerLinksModule.setDrawerLinks(this.drawerLinks.admin);
    } else if (user.is_admin === 0) {
      DrawerLinksModule.setDrawerLinks(this.drawerLinks.noAdmin);
    } else {
      DrawerLinksModule.setDrawerLinks(this.drawerLinks.noAdmin);
    }
  }
  private fetchData() {
    window.axios
      .get(`/api/getSkills`)
      .then(res => {
        SkillModule.setExperiencePeriods(res.data.experiencePeriods);
        SkillModule.setLanguages(res.data.languages);
        SkillModule.setFrameworks(res.data.frameworks);
        SkillModule.setOtherTools(res.data.otherTools);
      })
      .catch(err => {
        console.log(err);
      });

    window.axios
      .get(`/api/getEmails`)
      .then(res => {
        EmailModule.setEmails(res.data);
      })
      .catch(err => {
        console.log(err);
      });
  }
}
</script>
