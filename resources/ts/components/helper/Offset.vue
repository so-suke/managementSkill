<template>
  <div :style="styles" :class="classes" class="v-offset">
    <slot />
  </div>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";

@Component({})
export default class HelperOffset extends Vue {
  public readonly name: string = "HelperOffset";
  inheritAttrs: boolean = false;

  @Prop({ default: false }) private fullWidth!: boolean;
  @Prop({ default: 0 }) private offset!: number;

  get classes() {
    return {
      "v-offset--full-width": this.fullWidth
    };
  }
  get styles() {
    return {
      top: `-${this.offset}px`,
      marginBottom: `-${this.offset}px`
    };
  }
}
</script>
