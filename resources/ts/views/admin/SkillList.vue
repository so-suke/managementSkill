<template>
  <v-container fluid>
    <v-dialog v-model="createSkillDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">スキル新規作成</v-card-title>
        <v-text-field label="スキル名" v-model="skillName"></v-text-field>
        <v-card-actions>
          <v-btn color="green darken-1" text @click="createSkillDialog = false">キャンセル</v-btn>
          <v-btn color="green darken-1" text @click="createSkill">作成</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="updateSkillDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">スキル名の更新</v-card-title>
        <v-card-text>
          <v-text-field label="スキル名" v-model="willUpdateSkillName"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-btn color="green darken-1" text @click="updateSkillDialog = false">キャンセル</v-btn>
          <v-btn color="green darken-1" text @click="updateSkill">更新</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="deleteSkillDialog" max-width="290">
      <v-card>
        <v-card-title class="headline">本当に削除してもいいですか。</v-card-title>

        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="green darken-1" text @click="deleteSkillDialog = false">キャンセル</v-btn>

          <v-btn color="green darken-1" text @click="deleteSkill">確定</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <material-card color="green" title="スキル一覧">
      <v-card class="mb-4" v-for="skills in skillGroup" v-bind:key="skills.name">
        <v-card-title>
          <span>{{ skills.name }}一覧</span>
          <v-btn
            text
            icon
            color="deep-orange"
            @click="showCreateSkillDialog(SELECTED_SKILL_MODE[skills.nameEn])"
          >
            <v-icon>mdi-folder-plus</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <v-chip
            class="ma-2"
            v-for="skill in skills.items"
            v-bind:key="skill.id"
            close
            @dblclick="showUpdateSkillDialog(skill.id, SELECTED_SKILL_MODE[skills.nameEn], skill.name)"
            @click:close="showDeleteSkillDialog(skill.id, SELECTED_SKILL_MODE[skills.nameEn])"
          >{{ skill.name }}</v-chip>
        </v-card-text>
      </v-card>
    </material-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";
import { SkillModule } from "@modules/skill";

@Component({})
export default class SkillList extends Vue {
  private skillName: string = "";
  private createSkillDialog: boolean = false;
  private updateSkillDialog: boolean = false;
  private deleteSkillDialog: boolean = false;
  private willUpdateSkillId: number = -1;
  private willUpdateSkillName: string = "";
  private willDeleteSkillId: number = -1;
  private SELECTED_SKILL_MODE: {
    [skillMode: string]: { sql: string; routing: string };
  } = {
    language: {
      sql: "language",
      routing: "languages"
    },
    framework: {
      sql: "framework",
      routing: "frameworks"
    },
    otherTool: {
      sql: "other_tool",
      routing: "otherTools"
    }
  };
  private selectedSkillMode: any = {};

  get skillGroup() {
    return [
      {
        name: "言語",
        nameEn: "language",
        items: SkillModule.languages
      },
      {
        name: "フレームワーク",
        nameEn: "framework",
        items: SkillModule.frameworks
      },
      {
        name: "その他ツール",
        nameEn: "otherTool",
        items: SkillModule.otherTools
      }
    ];
  }

  initSkills() {
    window.axios
      .get(`/api/getSkills`)
      .then(res => {
        SkillModule.setLanguages(res.data.languages);
        SkillModule.setFrameworks(res.data.frameworks);
        SkillModule.setOtherTools(res.data.otherTools);
      })
      .catch(err => {
        console.log(err);
      });
  }

  showCreateSkillDialog(selectedSkillMode: any) {
    this.selectedSkillMode = selectedSkillMode;
    this.createSkillDialog = true;
  }

  createSkill() {
    const params = new URLSearchParams();
    params.append("name", this.skillName);
    window.axios
      .post(`api/${this.selectedSkillMode.routing}`, params)
      .then(res => {
        this.createSkillDialog = false;
        this.initSkills();
      });
  }

  showDeleteSkillDialog(skillId: number, selectedSkillMode: string) {
    this.willDeleteSkillId = skillId;
    this.selectedSkillMode = selectedSkillMode;
    this.deleteSkillDialog = true;
  }

  deleteSkill() {
    window.axios
      .delete(`api/${this.selectedSkillMode.routing}/${this.willDeleteSkillId}`)
      .then(res => {
        this.initSkills();
        this.deleteSkillDialog = false;
      });
  }

  showUpdateSkillDialog(
    skillId: number,
    selectedSkillMode: string,
    skillName: string
  ) {
    this.willUpdateSkillId = skillId;
    this.selectedSkillMode = selectedSkillMode;
    this.willUpdateSkillName = skillName;
    this.updateSkillDialog = true;
  }

  updateSkill() {
    const params = new URLSearchParams();
    params.append("name", this.willUpdateSkillName);
    window.axios
      .put(
        `api/${this.selectedSkillMode.routing}/${this.willUpdateSkillId}`,
        params
      )
      .then(res => {
        this.updateSkillDialog = false;
        this.initSkills();
      });
  }
}
</script>
