<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>
      <v-flex xs12 sm8 md4>
        <v-card class="elevation-12">
          <v-toolbar color="primary" dark flat>
            <v-toolbar-title>ログインフォーム</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form>
              <v-text-field
                v-model="email"
                label="メールアドレス"
                name="login"
                prepend-icon="person"
                type="text"
              ></v-text-field>

              <v-text-field
                id="password"
                v-model="password"
                label="パスワード"
                name="password"
                prepend-icon="lock"
                type="password"
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="login">ログイン</v-btn>
          </v-card-actions>
        </v-card>
        <div class="text-center mt-4">
          まだアカウントを持っていませんか?
          <router-link :to="{ name: 'Register' }">新規登録</router-link>
        </div>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";
import { AppModule } from "@modules/app";

@Component({})
export default class Login extends Vue {
  email: string = "";
  password: string = "";

  mounted() {
    // console.log(AuthenticationModule.isLogin);
  }

  private login() {
    window.axios
      .post("/api/login", {
        email: this.email,
        password: this.password
      })
      .then(res => {
        const token = res.data.access_token;
        window.axios.defaults.headers.common["Authorization"] =
          "Bearer " + token;
        window.axios.post("/api/me").then(res => {
          this.$store.commit("authenticationModule/setIsLogin", true);
          this.$store.commit("authenticationModule/setUser", res.data);
          this.$router.push({ name: "Admin Wrapper" });
          AppModule.setIsShowSnackbar(true);
        });
      })
      .catch(error => {
        console.log(error);
      });
  }
}
</script>
