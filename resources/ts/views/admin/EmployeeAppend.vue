<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>
      <v-flex class="col-10">
        <ValidationObserver v-slot="{ validate }">
          <material-card color="green" title="新規社員登録フォーム">
            <v-card-text>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-row>
                  <v-col cols="12">
                    <v-checkbox
                      label="管理者にする場合はチェックして下さい"
                      color="success"
                      v-model="isAdminCheck"
                      false-value="0"
                      true-value="1"
                      hide-details
                    ></v-checkbox>
                  </v-col>
                  <v-col cols="12" md="6">
                    <ValidationProvider name="姓" rules="required" v-slot="{ errors }">
                      <v-text-field
                        label="姓"
                        name="lastName"
                        type="text"
                        v-model="lastName"
                        :error-messages="errors[0]"
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12" md="6">
                    <ValidationProvider name="名" rules="required" v-slot="{ errors }">
                      <v-text-field
                        label="名"
                        name="firstName"
                        type="text"
                        v-model="firstName"
                        :error-messages="errors[0]"
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12" md="6">
                    <ValidationProvider name="姓(カナ)" rules="required" v-slot="{ errors }">
                      <v-text-field
                        label="姓(カナ)"
                        name="lastNameKana"
                        type="text"
                        v-model="lastNameKana"
                        :error-messages="errors[0]"
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12" md="6">
                    <ValidationProvider name="名(カナ)" rules="required" v-slot="{ errors }">
                      <v-text-field
                        label="名(カナ)"
                        name="firstNameKana"
                        type="text"
                        v-model="firstNameKana"
                        :error-messages="errors[0]"
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12">
                    <ValidationProvider name="役職" rules="required" v-slot="{ errors }">
                      <v-select
                        label="役職"
                        v-model="jobTitleId"
                        :items="jobTitles"
                        item-text="name"
                        item-value="id"
                        :error-messages="errors[0]"
                      ></v-select>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12">
                    <v-file-input v-model="profileImage" accept="image/png" label="プロフィール画像"></v-file-input>
                  </v-col>
                  <v-col cols="12" md="6">
                    <ValidationProvider
                      name="メールアドレス"
                      rules="required|email|uniqEmail"
                      v-slot="{ errors }"
                    >
                      <v-text-field
                        label="メールアドレス"
                        name="email"
                        type="email"
                        v-model="email"
                        :error-messages="errors[0]"
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12" md="6">
                    <ValidationProvider
                      name="パスワード"
                      rules="required|min:6|max:10"
                      v-slot="{ errors }"
                    >
                      <v-text-field
                        id="password"
                        label="Password"
                        name="password"
                        type="password"
                        v-model="password"
                        :error-messages="errors[0]"
                      ></v-text-field>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12">
                    <ValidationProvider name="性別" rules="required" v-slot="{ errors }">
                      <v-radio-group v-model="gender" row :error-messages="errors[0]">
                        <v-radio label="男性" value="male"></v-radio>
                        <v-radio label="女性" value="female"></v-radio>
                      </v-radio-group>
                    </ValidationProvider>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-menu
                      v-model="isShowDatePicker.hire"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field v-model="date.hire" label="入社日" readonly v-on="on"></v-text-field>
                      </template>
                      <v-date-picker v-model="date.hire" @input="isShowDatePicker.hire = false"></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-menu
                      v-model="isShowDatePicker.birth"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field label="誕生日" v-model="date.birth" readonly v-on="on"></v-text-field>
                      </template>
                      <v-date-picker v-model="date.birth" @input="isShowDatePicker.birth = false"></v-date-picker>
                    </v-menu>
                  </v-col>
                  <v-col cols="12">
                    <ValidationProvider name="備考" rules="required" v-slot="{ errors }">
                      <v-textarea label="備考" v-model="remarks" :error-messages="errors[0]" />
                    </ValidationProvider>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
            <v-card-actions class="justify-center">
              <v-btn class="col-5" color="blue" dark @click="register(validate)">登録</v-btn>
            </v-card-actions>
          </material-card>
        </ValidationObserver>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";
import { ValidationObserver, ValidationProvider } from "vee-validate";
import { JobTitlesModule } from "@modules/jobTitles";

@Component({
  components: {
    ValidationObserver,
    ValidationProvider
  }
})
export default class EmployeeAppend extends Vue {
  valid: boolean = false;
  isAdminCheck: string = "0";
  lastName: string = "";
  firstName: string = "";
  lastNameKana: string = "";
  firstNameKana: string = "";
  jobTitleId: number = -1;
  email: string = "";
  password: string = "";
  gender: string = "";
  profileImage: any = null;
  private date: { hire: string; birth: string } = {
    hire: new Date().toISOString().substr(0, 10),
    birth: new Date().toISOString().substr(0, 10)
  };
  private isShowDatePicker: { hire: boolean; birth: boolean } = {
    hire: false,
    birth: false
  };
  private remarks: string = "";

  private mounted() {
    window.axios
      .get(`/api/jobTitles`)
      .then(res => {
        JobTitlesModule.setJobTitles(res.data);
      })
      .catch(err => {
        console.log(err);
      });
    this.initInput();
  }

  private initInput() {
    this.lastName = "sample";
    this.firstName = "sample";
    this.lastNameKana = "sample";
    this.firstNameKana = "sample";
    this.jobTitleId = 2;
    this.email = "sample@gmail.com";
    this.password = "password";
    this.gender = "male";
    this.remarks = "sample";
  }

  get jobTitles() {
    return JobTitlesModule.jobTitles;
  }

  private register(validate: any) {
    validate().then((valid: boolean) => {
      if (valid === false) return;
      const params = new URLSearchParams();
      params.append("is_admin", this.isAdminCheck);
      params.append("job_title_id", this.jobTitleId + "");
      params.append("last_name", this.lastName);
      params.append("first_name", this.firstName);
      params.append("last_name_kana", this.lastNameKana);
      params.append("first_name_kana", this.firstNameKana);
      params.append("profile_image_path", this.profileImage.name);
      params.append("email", this.email);
      params.append("password", this.password);
      params.append("gender", this.gender);
      params.append("hired_at", this.date.hire);
      params.append("birth_at", this.date.birth);
      params.append("remarks", this.remarks);

      window.axios.post("api/employees", params).then(res => {
        console.log(res);
      });
    });
  }
}
</script>
