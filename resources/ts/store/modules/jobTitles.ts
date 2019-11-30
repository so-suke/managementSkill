import { Module, VuexModule, Action, Mutation, getModule } from 'vuex-module-decorators';
import store from '../index';

@Module({ dynamic: true, store, name: 'skill', namespaced: true })
class JobTitles extends VuexModule {
  public jobTitles: any[] = [];

  @Mutation
  public setJobTitles(jobTitles: any[]) {
    this.jobTitles = jobTitles;
  }
}

export const JobTitlesModule = getModule(JobTitles);
