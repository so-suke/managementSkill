<template>
  <v-card :style="styles" v-bind="$attrs" v-on="$listeners">
    <helper-offset v-if="hasOffset" :inline="inline" :full-width="fullWidth" :offset="offset">
      <v-card
        v-if="!$slots.offset"
        :color="color"
        :elevation="elevation"
        class="v-card--material__header d-flex align-center"
        dark
        min-height="80"
      >
        <slot v-if="!title && !text" name="header" />
        <div v-else class="px-3">
          <h4 class="title font-weight-light mb-2" v-text="title" />
          <p class="category font-weight-thin mb-0" v-text="text" />
        </div>
      </v-card>

      <slot v-else name="offset" />
    </helper-offset>

    <v-card-text>
      <slot />
    </v-card-text>

    <v-divider v-if="$slots.actions" class="mx-3" />

    <v-card-actions v-if="$slots.actions">
      <slot name="actions" />
    </v-card-actions>
  </v-card>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";

@Component({})
export default class MaterialCard extends Vue {
  public readonly name: string = "MaterialCard";
  inheritAttrs: boolean = false;

  @Prop({ default: 'secondary' }) private color!: string;
  @Prop({ default: 10 }) private elevation!: number | string;
  @Prop({ default: false }) private inline!: boolean;
  @Prop({ default: false }) private fullWidth!: boolean;
  @Prop({ default: 24 }) private offset!: number
  @Prop({ default: undefined }) private title: string | undefined;
  @Prop({ default: undefined }) private text: string | undefined;

  get hasOffset() {
    return this.$slots.header || this.$slots.offset || this.title || this.text;
  }
  get styles() {
    if (!this.hasOffset) return null;
    return {
      marginBottom: `${this.offset}px`,
      marginTop: `${this.offset * 2}px`
    };
  }
}
</script>

<style>
.v-offset {
  margin: 0 auto;
  max-width: calc(100% - 32px);
  position: relative;
  z-index: 1;
}
.v-offset--full-width {
  max-width: 100%;
}
</style>

