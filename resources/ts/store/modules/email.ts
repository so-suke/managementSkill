import { Module, VuexModule, Action, Mutation, getModule } from 'vuex-module-decorators';
import store from '../index';

@Module({ dynamic: true, store, name: 'email', namespaced: true })
class Email extends VuexModule {
  public emails: any[] = [];

  @Mutation
  public setEmails(emails: any[]) {
    this.emails = emails;
  }
}

export const EmailModule = getModule(Email);
