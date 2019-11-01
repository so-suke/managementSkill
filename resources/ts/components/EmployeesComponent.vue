<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12">
        <v-row justify="center" class="grey lighten-5" style="height: 300px;">
          <v-card v-for="n in 3" :key="n" class="ma-3 pa-6" outlined tile>Column</v-card>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script lang="ts">
import { Component, Prop, Vue, Watch } from "vue-property-decorator";
import { optionModule } from "@modules/Option";
import { async } from "q";

@Component
export default class ExampleComponent extends Vue {
  employees: any[] = [];
  isCollapse: boolean = false;
  activeIndex: string = "1";
  private input: string = "";

  private toggleSidemenu() {
    this.isCollapse = !this.isCollapse;
  }

  private handleOpen(key: any, keyPath: any) {
    console.log(key, keyPath);
  }
  private handleClose(key: any, keyPath: any) {
    console.log(key, keyPath);
  }
  private handleSelect(key: any, keyPath: any) {
    console.log(key, keyPath);
  }
  private mounted(): void {
    // this.fetchData();
  }

  private fetchData() {
    window.axios
      .get(`/api/employees`)
      .then(res => {
        console.log(res.data);
        this.employees = res.data;
      })
      .catch(err => {
        console.log(err);
      });
  }

  get options() {
    return optionModule.options;
  }

  @Watch("currentPage")
  onCurrentPageChanged(value: any) {
    this.fetchData();
  }
}
</script>

<style lang="scss" scoped>
@import "~@/variables/_variables.scss";

.svg-inline--fa {
  width: 24px;
}

.el-menu-vertical-demo {
  .el-submenu:first-child {
    margin-top: 60px;
  }
}

.el-menu-vertical-demo:not(.el-menu--collapse) {
  width: 200px;
  min-height: 400px;
}
.el-menu-demo {
  width: 100%;
}
.myContainer {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.employees {
  width: 40%;
  margin: 0 auto;
  li {
    cursor: pointer;
    &:hover {
      background-color: $colorUserHoverBg;
    }
  }
}
.employee {
  margin-bottom: 8px;
  border: 1.5px solid;
  border-radius: 5px;
  padding: 8px;
  &--male {
    border-color: $colorBorderMale;
  }
  &--female {
    border-color: $colorBorderFemale;
  }
  span {
    display: inline-block;
    &.name_last {
      width: 120px;
    }
    &.name_last_kana {
      width: 200px;
    }
  }
}
</style>
