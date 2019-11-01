import { Module, VuexModule, Action, Mutation, getModule } from 'vuex-module-decorators';
import store from '../index';

@Module({ dynamic: true, store, name: 'app', namespaced: true })
class App extends VuexModule {
  public drawer: boolean = true;
  public color: string = 'success';
  public image: string = 'https://demos.creative-tim.com/vue-material-dashboard/img/sidebar-2.32103624.jpg';
  public isShowSnackbar: boolean = false;

  @Mutation
  public setDrawer(drawer: boolean) {
    this.drawer = drawer;
  }
  @Mutation
  public setColor(color: string) {
    this.color = color;
  }
  @Mutation
  public setImage(image: string) {
    this.image = image;
  }
  @Mutation
  public setIsShowSnackbar(isShowSnackbar: boolean) {
    this.isShowSnackbar = isShowSnackbar;
  }
}

export const AppModule = getModule(App);
