import { Module, VuexModule, Action, Mutation, getModule } from 'vuex-module-decorators';
import store from '../index';

@Module({ dynamic: true, store, name: 'drawerLinks', namespaced: true })
class DrawerLinks extends VuexModule {
  public drawerLinks: any = [];

  @Mutation
  public setDrawerLinks(drawerLinks: any) {
    this.drawerLinks = drawerLinks;
  }
}

export const DrawerLinksModule = getModule(DrawerLinks);
