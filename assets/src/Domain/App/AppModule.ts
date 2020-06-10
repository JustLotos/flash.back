import { VuexModule, Module, Mutation, Action, getModule } from 'vuex-module-decorators'
import {getLocale} from "../../Plugins/I18n/I18n";
import Store from "../../Store";
import {getSidebarStatus, getSize, setLanguage, setSidebarStatus, setSize} from "../../Plugins/Cookies";

export enum DeviceType { Mobile, Desktop}
export interface IAppState {
    device: DeviceType
    sidebar: {
        opened: boolean
        withoutAnimation: boolean
    }
    activeModal: boolean;
    language: string
    size: string
}

@Module({dynamic: true, store: Store, name: 'AppModule' , namespaced: true})
class App extends VuexModule implements IAppState {
    public sidebar = {
        opened: getSidebarStatus() !== 'closed',
        withoutAnimation: false
    }
    public activeModal = false;
    public device = DeviceType.Desktop
    public language = getLocale()
    public size = getSize() || 'medium'

    get isResetValidation() {return !this.activeModal}
    get getRedirectOnGuardedPath() {
        return {name: 'Login'};
    }
    get getRedirectOnUnguardedPath() {
        return {name: 'Dashboard'};
    }

    @Mutation
    public SET_ACTIVE_MODAL(value:boolean = true) {
        this.activeModal = value;
    }

    @Mutation
    private TOGGLE_SIDEBAR(withoutAnimation: boolean) {
        this.sidebar.opened = !this.sidebar.opened
        this.sidebar.withoutAnimation = withoutAnimation
        if (this.sidebar.opened) {
            setSidebarStatus('opened')
        } else {
            setSidebarStatus('closed')
        }
    }

    @Mutation
    private SET_SIDEBAR(sidebar: boolean, withoutAnimation: boolean) {
        this.sidebar.opened = sidebar;
        console.log(sidebar)
        this.sidebar.withoutAnimation = withoutAnimation
        sidebar ?
            setSidebarStatus('opened'):
            setSidebarStatus('closed')
    }

    @Mutation
    private TOGGLE_DEVICE(device: DeviceType) {
        this.device = device
    }

    @Mutation
    private SET_LANGUAGE(language: string) {
        this.language = language
        setLanguage(this.language)
    }

    @Mutation
    private SET_SIZE(size: string) {
        this.size = size
        setSize(this.size)
    }

    @Action
    public ToggleSideBar(withoutAnimation: boolean) {
        this.TOGGLE_SIDEBAR(withoutAnimation)
    }

    @Action
    public SetSideBar(sidebar: boolean, withoutAnimation: boolean){
        this.SET_SIDEBAR(sidebar, withoutAnimation);
    }

    @Action
    public ToggleDevice(device: DeviceType) {
        this.TOGGLE_DEVICE(device)
    }

    @Action
    public SetLanguage(language: string) {
        this.SET_LANGUAGE(language)
    }

    @Action
    public SetSize(size: string) {
        this.SET_SIZE(size)
    }
}

export const AppModule = getModule(App);