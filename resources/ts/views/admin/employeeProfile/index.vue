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
          <img :src="this.$store.state.authenticationModule.user.profile_image_path" alt />
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
          <material-card
            v-for="(skill_mode, skill_mode_name) in SELECTED_SKILL_MODE"
            v-bind:key="skill_mode_name"
          >
            <div class="d-flex align-center">
              <v-subheader class="title">{{ skill_mode.jpName }}</v-subheader>
              <v-btn
                text
                icon
                color="deep-orange"
                @click="showCreateExperienceDialog(SELECTED_SKILL_MODE[skill_mode_name])"
              >
                <v-icon>mdi-folder-plus</v-icon>
              </v-btn>
            </div>
            <v-list-item-group readonly>
              <v-list-item
                v-for="(experience, i) in employee[skill_mode.sql + '_experiences']"
                :key="i"
              >
                <v-row align="center" justify="start">
                  <v-col cols="2">
                    <p class="mb-0">{{ experience[skill_mode.sql].name }}</p>
                  </v-col>
                  <v-col class="d-flex">
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`${skill_mode.routing}Experience${i}`"
                      value="半年未満"
                      :checked="experience.experience_period_id === 1"
                    />半年未満
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`${skill_mode.routing}Experience${i}`"
                      value="半年から1年"
                      :checked="experience.experience_period_id === 2"
                    />半年から1年
                    <input
                      class="noTouch"
                      type="radio"
                      :name="`${skill_mode.routing}Experience${i}`"
                      value="1年から2年"
                      :checked="experience.experience_period_id === 3"
                    />1年から2年
                    <input
                      type="radio"
                      :name="`${skill_mode.routing}Experience${i}`"
                      value="2年から3年"
                      :checked="experience.experience_period_id === 4"
                    />2年から3年
                    <input
                      type="radio"
                      :name="`${skill_mode.routing}Experience${i}`"
                      value="3年以上"
                      :checked="experience.experience_period_id === 5"
                    />3年以上
                  </v-col>
                  <v-col class="d-flex" cols="1">
                    <v-btn
                      text
                      icon
                      color="deep-orange"
                      @click="showUpdateExperiencePeriodDialog(experience.id, SELECTED_SKILL_MODE[skill_mode_name])"
                    >
                      <v-icon>mdi-calendar</v-icon>
                    </v-btn>
                    <v-btn
                      text
                      icon
                      color="deep-orange"
                      @click="showDeleteExperienceDialog(experience.id, SELECTED_SKILL_MODE[skill_mode_name])"
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
  // 社員情報の格納用変数。社員情報は、「ページ読み込み時」にDBより取得。
  private employee: any = {
    job_title: {}
  };

  //
  private SELECTED_SKILL_MODE: {
    [skillMode: string]: {
      jpName: string;
      sql: string;
      routing: string;
    };
  } = {
    language: {
      jpName: "言語",
      sql: "language",
      routing: "language"
    },
    framework: {
      jpName: "フレームワーク",
      sql: "framework",
      routing: "framework"
    },
    otherTool: {
      jpName: "その他ツール",
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

  // ページ読み込み時に「社員情報」をDBより取得
  initEmployee(id: string) {
    window.axios.get(`/api/employees/${id}`).then(res => {
      this.employee = res.data;
      console.log(this.employee);
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
        `api/${this.selectedSkillMode.routing}Experiences/${this.willUpdateExperienceId}`,
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
        `api/${this.selectedSkillMode.routing}Experiences/${this.willDeleteExperienceId}`
      )
      .then(res => {
        this.initEmployee(this.$route.params.id);
        this.deleteExperienceDialog = false;
      });
  }

  // スキル経験データの新規作成ダイアログを表示する。
  // スキルの種類により処理を分ける。
  showCreateExperienceDialog(skillMode: any) {
    this.selectedSkillMode = skillMode;

    const skillIds = this.employee[skillMode.sql + "_experiences"].map(
      (experience: any) => {
        return experience[skillMode.sql + "_id"];
      }
    );

    const skills = SkillModule.skillByKind(skillMode.routing);
    this.experienceSkills = skills.filter((skill: any) => {
      if (skillIds.includes(skill.id) !== true) {
        return skill;
      }
    });

    // ダイアログを表示するため、trueにする。
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
