<template>
  <v-container fluid>
    <material-card color="green" title="プロフィール更新">
      <v-form>
        <v-container class="py-0">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field v-model="lastName" label="姓" />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field v-model="firstName" label="名" />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field v-model="lastNameKana" label="姓(カナ)" />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field v-model="firstNameKana" label="名(カナ)" />
            </v-col>

            <v-col cols="12" md="4">
              <v-select
                label="役職"
                v-model="jobTitleId"
                :items="jobTitles"
                item-text="name"
                item-value="id"
              ></v-select>
            </v-col>

            <v-col cols="12" md="4">
              <v-menu
                v-model="isShowDatePicker.hire"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field v-model="hiredAt" label="入社日" readonly v-on="on"></v-text-field>
                </template>
                <v-date-picker v-model="hiredAt" @input="isShowDatePicker.hire = false"></v-date-picker>
              </v-menu>
            </v-col>

            <v-col cols="12" md="4">
              <v-menu
                v-model="isShowDatePicker.birth"
                :close-on-content-click="false"
                :nudge-right="40"
                transition="scale-transition"
                min-width="290px"
              >
                <template v-slot:activator="{ on }">
                  <v-text-field v-model="birthAt" label="誕生日" readonly v-on="on"></v-text-field>
                </template>
                <v-date-picker v-model="birthAt" @input="isShowDatePicker.birth = false"></v-date-picker>
              </v-menu>
            </v-col>

            <v-col cols="12">
              <v-textarea v-model="remarks" label="備考" />
            </v-col>

            <v-col cols="12" class="text-right">
              <v-btn @click="updateProfile" color="green" dark>更新確定</v-btn>
            </v-col>
          </v-row>
        </v-container>
      </v-form>
    </material-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";

@Component({})
export default class YourProfileUpdate extends Vue {
  private lastName: string = "";
  private firstName: string = "";
  private lastNameKana: string = "";
  private firstNameKana: string = "";
  private jobTitleId: string = "0";
  private hiredAt: string = new Date().toISOString().substr(0, 10);
  private birthAt: string = new Date().toISOString().substr(0, 10);
  jobTitles: { id: string; name: string }[] = [
    {
      id: "1",
      name: "フロントエンドエンジニア"
    },
    {
      id: "2",
      name: "サーバーサイドエンジニア"
    }
  ];
  private isShowDatePicker: { hire: boolean; birth: boolean } = {
    hire: false,
    birth: false
  };
  private remarks: string = "";

  mounted() {
    this.initEmployee(this.$route.params.id);
  }

  initEmployee(id: string) {
    window.axios.get(`/api/employees/${id}`).then(res => {
      const employee = res.data;
      this.lastName = employee.last_name;
      this.firstName = employee.first_name;
      this.lastNameKana = employee.last_name_kana;
      this.firstNameKana = employee.first_name_kana;
      this.jobTitleId = "" + employee.job_title.id;
      this.remarks = employee.remarks;
      this.hiredAt = employee.hired_at;
      this.birthAt = employee.birth_at;
    });
  }

  private updateProfile() {
    const params = new URLSearchParams();
    params.append("last_name", this.lastName);
    params.append("first_name", this.firstName);
    params.append("last_name_kana", this.lastNameKana);
    params.append("first_name_kana", this.firstNameKana);
    params.append("job_title_id", this.jobTitleId);
    params.append("remarks", this.remarks);
    params.append("hired_at", this.hiredAt);
    params.append("birth_at", this.birthAt);
    window.axios
      .put(`/api/employees/${this.$route.params.id}`, params)
      .then(res => {
        this.$router.push({ name: "Employee Profile" });
      });
  }
}
</script>
