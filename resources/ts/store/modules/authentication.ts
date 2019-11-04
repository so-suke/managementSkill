import { Module, VuexModule, Action, Mutation, getModule } from 'vuex-module-decorators';
import store from '../index';

@Module({ name: 'authentication', namespaced: true })
export default class AuthenticationModule extends VuexModule {
  public isLogin: boolean = false;
  public user: any = {};

  @Mutation
  public setIsLogin(isLogin: boolean) {
    this.isLogin = isLogin;
  }
  @Mutation
  public setUser(user: any) {
    this.user = user;
  }
}
