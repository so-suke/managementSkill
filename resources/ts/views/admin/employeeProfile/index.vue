<template>
  <v-container fluid>
    <v-dialog v-model="createExperienceDialog" max-width="290">
      <v-card>
        <v-select
          label="経験スキル"
          v-model="experienceSkillId"
          :items="experienceSkills"
          item-text="name"
          item-value="id"
        ></v-select>
        <v-select
          label="経験期間"
          v-model="experiencePeriodId"
          :items="experiencePeriods"
          item-text="name"
          item-value="id"
        ></v-select>
        <v-card-actions>
          <v-btn color="green darken-1" text @click="createExperienceDialog = false">キャンセル</v-btn>
          <v-btn color="green darken-1" text @click="createExperience">作成</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="updateExperiencePeriodDialog" max-width="290">
      <v-card>
        <v-select
          label="経験期間"
          v-model="experiencePeriodId"
          :items="experiencePeriods"
          item-text="name"
          item-value="id"
        ></v-select>
        <v-card-actions>
          <v-spacer></v-spacer>

          <v-btn color="green darken-1" text @click="updateExperiencePeriodDialog = false">キャンセル</v-btn>

          <v-btn color="green darken-1" text @click="updateExperiencePeriod">更新</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-col cols="12">
      <material-card class="v-card-profile">
        <v-avatar slot="offset" class="mx-auto d-block elevation-6" size="200">
          <img src="https://cdn.vuetifyjs.com/images/cards/halcyon.png" />
        </v-avatar>
        <v-card-text>
          <v-text-field
            class="pr-sm-2"
            md="5"
            :value="`${employee.last_name} ${employee.first_name}`"
            label="名前"
            readonly
          ></v-text-field>
          <v-text-field
            md="5"
            :value="`${employee.last_name_kana} ${employee.first_name_kana}`"
            label="名前(カナ)"
            readonly
          ></v-text-field>
          <v-text-field md="5" :value="employee.job_title.name" label="役職" readonly></v-text-field>
          <v-text-field class="pr-sm-2" :value="employee.hired_at" label="入社日" readonly></v-text-field>
          <v-text-field md="5" :value="employee.birth_at" label="誕生日" readonly></v-text-field>
          <v-textarea :value="employee.remarks" label="備考" placeholder="未記載" readonly></v-textarea>
        </v-card-text>
        <v-col cols="12" class="text-right" v-if="isLoginEmployeeProfileEmployee() || isAdminer()">
          <v-btn
            :to="{ name: 'Employee Profile Update'}"
            class="justify-self-end"
            color="green"
            dark
          >プロフィール更新</v-btn>
        </v-col>
      </material-card>
    </v-col>

    <v-col cols="12">
      <material-card color="green" title="スキル一覧">
        <v-card-text>
          <material-card>
            <div class="d-flex align-center">
              <v-subheader class="title">言語</v-subheader>
              <v-btn
                text
                icon
                color="deep-orange"
                @click="showCreateExperienceDialog(SELECTED_SKILL_MODE.language)"
              >
                <v-icon>mdi-folder-plus</v-icon>
              </v-btn>
            </div>
            <v-list-item-group readonly>
              <v-list-item v-for="(experience, i) in employee.language_experiences" :key="i">
                <v-row align="center" justify="start">
                  <v-col cols="2">
                    <p class="mb-0">{{ experience.language.name }}</p>
                  </v-col>
                  <v-col class="d-flex">
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`languageExperience${i}`"
                      value="半年未満"
                      :checked="experience.experience_period_id === 1"
                    />半年未満
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`languageExperience${i}`"
                      value="半年から1年"
                      :checked="experience.experience_period_id === 2"
                    />半年から1年
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`languageExperience${i}`"
                      value="1年から2年"
                      :checked="experience.experience_period_id === 3"
                    />1年から2年
                    <input
                      type="radio"
                      :name="`languageExperience${i}`"
                      value="2年から3年"
                      :checked="experience.experience_period_id === 4"
                    />2年から3年
                    <input
                      type="radio"
                      :name="`languageExperience${i}`"
                      value="3年以上"
                      :checked="experience.experience_period_id === 5"
                    />3年以上
                  </v-col>
                  <v-col class="d-flex" cols="1">
                    <v-btn
                      text
                      icon
                      color="deep-orange"
                      @click="showUpdateExperiencePeriodDialog(experience.id, SELECTED_SKILL_MODE.language)"
                    >
                      <v-icon>mdi-calendar</v-icon>
                    </v-btn>
                    <v-btn
                      text
                      icon
                      color="deep-orange"
                      @click="showDeleteExperienceDialog(experience.id, SELECTED_SKILL_MODE.language)"
                    >
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </v-col>
                </v-row>
              </v-list-item>
            </v-list-item-group>
          </material-card>

          <material-card>
            <div class="d-flex align-center">
              <v-subheader class="title">フレームワーク</v-subheader>
              <v-btn
                text
                icon
                color="deep-orange"
                @click="showCreateExperienceDialog(SELECTED_SKILL_MODE.framework)"
              >
                <v-icon>mdi-folder-plus</v-icon>
              </v-btn>
            </div>
            <v-list-item-group readonly>
              <v-list-item v-for="(experience, i) in employee.framework_experiences" :key="i">
                <v-row align="center" justify="start">
                  <v-col cols="2">
                    <p class="mb-0">{{ experience.framework.name }}</p>
                  </v-col>
                  <v-col class="d-flex">
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`frameworkExperience${i}`"
                      value="半年未満"
                      :checked="experience.experience_period_id === 1"
                    />半年未満
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`frameworkExperience${i}`"
                      value="半年から1年"
                      :checked="experience.experience_period_id === 2"
                    />半年から1年
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`frameworkExperience${i}`"
                      value="1年から2年"
                      :checked="experience.experience_period_id === 3"
                    />1年から2年
                    <input
                      type="radio"
                      :name="`frameworkExperience${i}`"
                      value="2年から3年"
                      :checked="experience.experience_period_id === 4"
                    />2年から3年
                    <input
                      type="radio"
                      :name="`frameworkExperience${i}`"
                      value="3年以上"
                      :checked="experience.experience_period_id === 5"
                    />3年以上
                  </v-col>
                  <v-col class="d-flex" cols="1">
                    <v-btn
                      text
                      icon
                      color="deep-orange"
                      @click="showUpdateExperiencePeriodDialog(experience.id, SELECTED_SKILL_MODE.framework)"
                    >
                      <v-icon>mdi-calendar</v-icon>
                    </v-btn>
                    <v-btn
                      text
                      icon
                      color="deep-orange"
                      @click="showDeleteExperienceDialog(experience.id, SELECTED_SKILL_MODE.framework)"
                    >
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </v-col>
                </v-row>
              </v-list-item>
            </v-list-item-group>
          </material-card>

          <material-card>
            <div class="d-flex align-center">
              <v-subheader class="title">その他ツール</v-subheader>
              <v-btn
                text
                icon
                color="deep-orange"
                @click="showCreateExperienceDialog(SELECTED_SKILL_MODE.otherTool)"
              >
                <v-icon>mdi-folder-plus</v-icon>
              </v-btn>
            </div>
            <v-list-item-group readonly>
              <v-list-item v-for="(experience, i) in employee.other_tool_experiences" :key="i">
                <v-row align="center" justify="start">
                  <v-col cols="2">
                    <p class="mb-0">{{ experience.other_tool.name }}</p>
                  </v-col>
                  <v-col class="d-flex">
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`otherToolExperience${i}`"
                      value="半年未満"
                      :checked="experience.experience_period_id === 1"
                    />半年未満
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`otherToolExperience${i}`"
                      value="半年から1年"
                      :checked="experience.experience_period_id === 2"
                    />半年から1年
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`otherToolExperience${i}`"
                      value="1年から2年"
                      :checked="experience.experience_period_id === 3"
                    />1年から2年
                    <input
                      type="radio"
                      :name="`otherToolExperience${i}`"
                      value="2年から3年"
                      :checked="experience.experience_period_id === 4"
                    />2年から3年
                    <input
                      type="radio"
                      :name="`otherToolExperience${i}`"
                      value="3年以上"
                      :checked="experience.experience_period_id === 5"
                    />3年以上
                  </v-col>
                  <v-col class="d-flex" cols="1">
                    <v-btn
                      text
                      icon
                      color="deep-orange"
                      @click="showUpdateExperiencePeriodDialog(experience.id, SELECTED_SKILL_MODE.otherTool)"
                    >
                      <v-icon>mdi-calendar</v-icon>
                    </v-btn>
                    <v-btn
                      text
                      icon
                      color="deep-orange"
                      @click="showDeleteExperienceDialog(experience.id, SELECTED_SKILL_MODE.otherTool)"
                    >
                      <v-icon>mdi-delete</v-icon>
                    </v-btn>
                  </v-col>
                </v-row>
              </v-list-item>
            </v-list-item-group>
          </material-card>
        </v-card-text>
      </material-card>
    </v-col>
  </v-container>
</template>

<script lang="ts">
import { Component, Prop, Emit, Vue, Watch } from "vue-property-decorator";
import { getEmployee } from "../../../utils/employee";
import { SkillModule } from "@modules/skill";

@Component({})
export default class YourProfile extends Vue {
  private employee: any = {
    job_title: {}
  };

  private SELECTED_SKILL_MODE: {
    [skillMode: string]: { sql: string; routing: string };
  } = {
    language: {
      sql: "language",
      routing: "language"
    },
    framework: {
      sql: "framework",
      routing: "framework"
    },
    otherTool: {
      sql: "other_tool",
      routing: "otherTool"
    }
  };
  private selectedSkillMode: any = {};

  experienceSkills: any[] = [];

  get experiencePeriods() {
    return SkillModule.experiencePeriods;
  }

  createExperienceDialog: boolean = false;
  experienceSkillId: string = "-1";
  updateExperiencePeriodDialog: boolean = false;
  deleteExperienceDialog: boolean = false;
  willUpdateExperienceId: number = -1;
  willDeleteExperienceId: number = -1;
  experiencePeriodId: string = "-1";

  mounted() {
    // console.log(this.$store.state.authenticationModule.user);
  }

  initEmployee(id: string) {
    window.axios.get(`/api/employees/${id}`).then(res => {
      this.employee = res.data;
    });
  }

  showUpdateExperiencePeriodDialog(
    experienceId: number,
    selectedSkillMode: any
  ) {
    this.willUpdateExperienceId = experienceId;
    this.selectedSkillMode = selectedSkillMode;
    this.updateExperiencePeriodDialog = true;
  }

  updateExperiencePeriod() {
    //経験期間の更新
    if (this.experiencePeriodId === "-1") {
      console.warn("経験期間を選択して下さい処理を書く");
      return;
    }
    const params = new URLSearchParams();
    params.append("experience_period_id", this.experiencePeriodId);
    window.axios
      .put(
        `api/${this.selectedSkillMode.routing}Experiences/${
          this.willUpdateExperienceId
        }`,
        params
      )
      .then(res => {
        this.updateExperiencePeriodDialog = false;
        this.initEmployee(this.$route.params.id);
      });
  }

  showDeleteExperienceDialog(experienceId: number, selectedSkillMode: string) {
    this.willDeleteExperienceId = experienceId;
    this.selectedSkillMode = selectedSkillMode;
    this.deleteExperienceDialog = true;
  }

  deleteExperience() {
    window.axios
      .delete(
        `api/${this.selectedSkillMode.routing}Experiences/${
          this.willDeleteExperienceId
        }`
      )
      .then(res => {
        this.initEmployee(this.$route.params.id);
        this.deleteExperienceDialog = false;
      });
  }

  showCreateExperienceDialog(skillMode: any) {
    // this.willUpdateExperienceId = experienceId;
    this.selectedSkillMode = skillMode;
    if (this.selectedSkillMode === this.SELECTED_SKILL_MODE.language) {
      const languageIds = this.employee.language_experiences.map(
        (experience: any) => {
          return experience.language_id;
        }
      );
      this.experienceSkills = SkillModule.languages.filter(item => {
        if (languageIds.includes(item.id) !== true) {
          return item;
        }
      });
    } else if (this.selectedSkillMode === this.SELECTED_SKILL_MODE.framework) {
      // this.experienceSkills = SkillModule.frameworks;
      const frameworkIds = this.employee.framework_experiences.map(
        (experience: any) => {
          return experience.framework_id;
        }
      );
      this.experienceSkills = SkillModule.frameworks.filter(item => {
        if (frameworkIds.includes(item.id) !== true) {
          return item;
        }
      });
    } else if (this.selectedSkillMode === this.SELECTED_SKILL_MODE.otherTool) {
      // this.experienceSkills = SkillModule.otherTools;
      const otherToolIds = this.employee.other_tool_experiences.map(
        (experience: any) => {
          return experience.other_tool_id;
        }
      );
      this.experienceSkills = SkillModule.otherTools.filter(item => {
        if (otherToolIds.includes(item.id) !== true) {
          return item;
        }
      });
    } else {
      this.experienceSkills = SkillModule.languages;
    }
    this.createExperienceDialog = true;
  }

  createExperience() {
    if (this.experienceSkillId === "-1" || this.experiencePeriodId === "-1") {
      console.warn("選択して下さい処理を書く");
      return;
    }
    const params = new URLSearchParams();
    params.append("employee_id", this.$route.params.id);
    params.append(`${this.selectedSkillMode.sql}_id`, this.experienceSkillId);
    params.append("experience_period_id", this.experiencePeriodId);
    window.axios
      .post(`api/${this.selectedSkillMode.routing}Experiences/`, params)
      .then(res => {
        console.log(res.data);
        this.createExperienceDialog = false;
        this.initEmployee(this.$route.params.id);
      });
  }

  // プロフィール社員がログイン社員かどうか
  isLoginEmployeeProfileEmployee(): boolean {
    return (
      parseInt(this.$route.params.id) ===
      parseInt(this.$store.state.authenticationModule.user.id)
    );
  }

  // ログイン社員が管理者かどうか
  isAdminer(): boolean {
    return this.$store.state.authenticationModule.user.is_admin === 1;
  }

  @Watch("$route.params.id", { immediate: true, deep: true })
  onUrlChange(id: string) {
    this.initEmployee(id);
  }
}
</script>
