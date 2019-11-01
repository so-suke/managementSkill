<template>
  <v-content>
    <v-container fluid fill-height justify-center align-center>
      <transition name="fade" mode="out-in">
        <router-view></router-view>
      </transition>
    </v-container>
  </v-content>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";

@Component({})
export default class AuthWrapper extends Vue {}
</script>
