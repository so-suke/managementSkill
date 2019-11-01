<template>
  <v-container fluid>
    <v-col cols="12">
      <material-card class="v-card-profile">
        <v-avatar slot="offset" class="mx-auto d-block elevation-6" size="200">
          <img src="https://cdn.vuetifyjs.com/images/cards/halcyon.png" />
        </v-avatar>
        <v-card-text>
          <v-text-field class="pr-sm-2" md="5" value="酒井 一樹" label="名前" readonly></v-text-field>
          <v-text-field md="5" value="サカイ カズキ" label="名前(カナ)" readonly></v-text-field>
          <v-text-field md="5" value="フロントエンドエンジニア" label="役職" readonly></v-text-field>
          <v-text-field class="pr-sm-2" value="2015/04/15" label="入社日" readonly></v-text-field>
          <v-text-field md="5" value="1992/03/16" label="誕生日" readonly></v-text-field>
          <v-textarea label="備考" placeholder="未記載" readonly></v-textarea>
        </v-card-text>
        <v-col cols="12" class="text-right">
          <v-btn
            :to="{ name: 'Your Profile Update'}"
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
export default class YourProfile extends Vue {}
</script>
