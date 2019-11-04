<template>
  <v-container fluid>
    <v-col cols="12">
      <material-card class="v-card-profile">
        <v-avatar slot="offset" class="mx-auto d-block elevation-6" size="200">
          <img src="https://cdn.vuetifyjs.com/images/cards/halcyon.png" />
        </v-avatar>
        <v-card-text>
          <v-text-field
            class="pr-sm-2"
            md="5"
            :value="`${employee.last_name} ${employee.first_name}`"
            label="名前"
            readonly
          ></v-text-field>
          <v-text-field
            md="5"
            :value="`${employee.last_name_kana} ${employee.first_name_kana}`"
            label="名前(カナ)"
            readonly
          ></v-text-field>
          <v-text-field md="5" :value="employee.job_title.name" label="役職" readonly></v-text-field>
          <v-text-field class="pr-sm-2" :value="employee.hired_at" label="入社日" readonly></v-text-field>
          <v-text-field md="5" :value="employee.birth_at" label="誕生日" readonly></v-text-field>
          <v-textarea :value="employee.remarks" label="備考" placeholder="未記載" readonly></v-textarea>
        </v-card-text>
        <v-col cols="12" class="text-right" v-if="isLoginEmployeeProfileEmployee() || isAdminer()">
          <v-btn
            :to="{ name: 'Employee Profile Update'}"
            class="justify-self-end"
            color="success"
          >プロフィール更新</v-btn>
        </v-col>
      </material-card>
    </v-col>
  </v-container>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";

@Component({})
export default class YourProfile extends Vue {
  private employee: any = {
    job_title: {}
  };

  mounted() {
    this.initEmployee(this.$route.params.id);
  }

  initEmployee(id: string) {
    window.axios.get(`/api/employees/${id}`).then(res => {
      this.employee = res.data;
    });
  }

  // プロフィール社員がログイン社員かどうか
  isLoginEmployeeProfileEmployee(): boolean {
    return (
      parseInt(this.$route.params.id) ===
      parseInt(this.$store.state.authenticationModule.user.id)
    );
  }

  // ログイン社員が管理者かどうか
  isAdminer(): boolean {
    return this.$store.state.authenticationModule.user.is_admin === 1;
  }

  @Watch("$route.params.id", { immediate: true, deep: true })
  onUrlChange(id: string) {
    this.initEmployee(id);
  }
}
</script>
