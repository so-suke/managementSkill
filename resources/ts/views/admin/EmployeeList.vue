<template>
  <v-container fill-height fluid grid-list-xl>
    <v-row>
      <v-col cols="3" v-for="employee in employees" v-bind:key="employee.id">
        <router-link
          :to="{ name: 'Employee Profile', params: { id: employee.id }}"
        >
          <material-card class="v-card-profile shaped">
            <v-avatar slot="offset" class="mx-auto d-block elevation-6" size="150">
              <!-- <img src="/images/male_0.png" /> -->
              <!-- <img :src="'/images/' + employee.profile_image_path" /> -->
              <img :src="employee.profile_image_path" />
            </v-avatar>
            <v-card-text class="text-center">
              <p class="title">{{ employee.last_name }} {{ employee.first_name }}</p>
              <p class="subtitle-2 mb-0">{{ employee.job_title.name }}</p>
            </v-card-text>
          </material-card>
        </router-link>
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
        this.employees = res.data;
      })
      .catch(err => {
        console.log(err);
      });
  }
}
</script>
