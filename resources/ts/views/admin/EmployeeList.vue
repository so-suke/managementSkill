<template>
  <v-container fill-height fluid grid-list-xl>
    <v-row>
      <v-col cols="3" v-for="n in 10" v-bind:key="n">
        <material-card class="v-card-profile shaped">
          <v-avatar slot="offset" class="mx-auto d-block elevation-6" size="150">
            <img src="https://cdn.vuetifyjs.com/images/cards/halcyon.png" />
          </v-avatar>
          <v-card-text class="text-center">
            <p class="title">酒井 一樹</p>
            <p class="subtitle-2 mb-0">フロントエンドエンジニア</p>
          </v-card-text>
        </material-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";

@Component({})
export default class EmployeeList extends Vue {
  private employees: any = [];

  private mounted() {
    this.fetchData();
  }

  private fetchData() {
    window.axios
      .get(`/api/employees`)
      .then(res => {
        console.log(res.data);
      })
      .catch(err => {
        console.log(err);
      });
  }
}
</script>
