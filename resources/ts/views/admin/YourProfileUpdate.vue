<template>
  <v-container fluid>
    <material-card color="green" title="プロフィール更新">
      <v-form>
        <v-container class="py-0">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field label="姓" />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field label="名" />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field label="姓(カナ)" />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field label="名(カナ)" />
            </v-col>

            <v-col cols="12" md="4">
              <v-text-field label="役職" />
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
                  <v-text-field v-model="date.hire" label="入社日" readonly v-on="on"></v-text-field>
                </template>
                <v-date-picker v-model="date.hire" @input="isShowDatePicker.hire = false"></v-date-picker>
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
                  <v-text-field v-model="date.birth" label="誕生日" readonly v-on="on"></v-text-field>
                </template>
                <v-date-picker v-model="date.birth" @input="isShowDatePicker.birth = false"></v-date-picker>
              </v-menu>
            </v-col>

            <v-col cols="12">
              <v-textarea v-model="remarks" label="備考" />
            </v-col>

            <v-col cols="12" class="text-right">
              <v-btn :to="{ name: 'Your Profile'}" @click="updateProfile" color="success">更新確定</v-btn>
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
  private date: { hire: string, birth: string } = {
    hire: new Date().toISOString().substr(0, 10),
    birth: new Date().toISOString().substr(0, 10)
  };
  private isShowDatePicker: { hire: boolean, birth: boolean } = {
    hire: false,
    birth: false
  };
  private remarks: string = "";

  private updateProfile() {
    console.log(this.date);
  }
}
</script>
