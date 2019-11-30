import { Module, VuexModule, Action, Mutation, getModule } from 'vuex-module-decorators';
import store from '../index';

@Module({ dynamic: true, store, name: 'skill', namespaced: true })
class Skill extends VuexModule {
  public experiencePeriods: any[] = [];
  public languages: any[] = [];
  public frameworks: any[] = [];
  public otherTools: any[] = [];

  @Mutation
  public setExperiencePeriods(experiencePeriods: any[]) {
    this.experiencePeriods = experiencePeriods;
  }
  @Mutation
  public setLanguages(languages: any[]) {
    this.languages = languages;
  }
  @Mutation
  public setFrameworks(frameworks: any[]) {
    this.frameworks = frameworks;
  }
  @Mutation
  public setOtherTools(otherTools: any[]) {
    this.otherTools = otherTools;
  }
}

export const SkillModule = getModule(Skill);
