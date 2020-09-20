import { VuexModule, Module, Mutation, getModule } from 'vuex-module-decorators'
import {Store} from "./Store";
import {Application} from "./Entity/Application";
import {RouteConfig} from "vue-router";

@Module({dynamic: true, store: Store, name: 'AppModule' , namespaced: true})
class VuexApplication extends VuexModule {
    private app: Application = new Application();

    get getApp(): Application {
        return this.app;
    }
    get isResetValidation() {
        return false;
    }
    get getRedirectToUnAuth() {
        return {name: 'Login'};
    }
    get getRedirectToAuth() {
        return {name: 'Dashboard'};
    }

    @Mutation
    public INIT(routes: Array<RouteConfig>) {
        this.app.menu.setRoutes(routes);
    }

    // @Mutation
    // public SET_ACTIVE_MODAL() {
    //     this.activeModal = true;
    // }
    //
    // @Mutation
    // public UNSET_ACTIVE_MODAL() {
    //     this.activeModal = false;
    // }

    // @Mutation
    // private TOGGLE_SIDEBAR(withoutAnimation: boolean) {
    //     this.sidebar.opened = !this.sidebar.opened
    //     this.sidebar.withoutAnimation = withoutAnimation
    //     if (this.sidebar.opened) {
    //         setSidebarStatus('opened')
    //     } else {
    //         setSidebarStatus('closed')
    //     }
    // }
    //
    // @Mutation
    // private SET_SIDEBAR(sidebar: boolean, withoutAnimation: boolean) {
    //     this.sidebar.opened = sidebar;
    //     console.log(sidebar)
    //     this.sidebar.withoutAnimation = withoutAnimation
    //     sidebar ?
    //         setSidebarStatus('opened'):
    //         setSidebarStatus('closed')
    // }
    //
    // @Mutation
    // private TOGGLE_DEVICE(device: DeviceType) {
    //     this.device = device
    // }
    //
    // @Mutation
    // private SET_LANGUAGE(language: string) {
    //     this.language = language
    //     setLanguage(this.language)
    // }
    //
    // @Mutation
    // private SET_SIZE(size: string) {
    //     this.size = size
    //     setSize(this.size)
    // }
    //
    // @Action
    // public ToggleSideBar(withoutAnimation: boolean) {
    //     this.TOGGLE_SIDEBAR(withoutAnimation)
    // }
    //
    // @Action
    // public SetSideBar(sidebar: boolean, withoutAnimation: boolean){
    //     this.SET_SIDEBAR(sidebar, withoutAnimation);
    // }
    //
    // @Action
    // public ToggleDevice(device: DeviceType) {
    //     this.TOGGLE_DEVICE(device)
    // }
    //
    // @Action
    // public SetLanguage(language: string) {
    //     this.SET_LANGUAGE(language)
    // }
    //
    // @Action
    // public SetSize(size: string) {
    //     this.SET_SIZE(size)
    // }
}

export const AppModule = getModule(VuexApplication);