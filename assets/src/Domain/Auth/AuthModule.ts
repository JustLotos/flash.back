import {Action, getModule, Module, Mutation, MutationAction, VuexModule} from "vuex-module-decorators";
import Store from "../../Store";
import {AuthResponse, LoginRequest, RefreshResponse, RegisterRequest} from "./types";
import AuthService from "./AuthService";

@Module({dynamic: true, store: Store, name: 'AuthModule'})
class Auth extends VuexModule implements IAuthState {
    token = localStorage.getItem(TOKEN);
    refreshToken = localStorage.getItem(REFRESH_TOKEN);
    status = localStorage.getItem(STATUS);
    role = localStorage.getItem(ROLE);
    load = false;

    get isAuthenticated(): boolean {
        return !!(this.token || localStorage.getItem(TOKEN));
    }
    get isLoading(): boolean {
        return this.load;
    }
    get getRole(): string {
        switch (this.role) {
            case ROLES.ADMIN:
                return 'Администратор';
            case ROLES.USER:
                return 'Пользователь';
            default:
                return 'Анонимный пользователь';
        }

    }
    get getStatus(): string {
        switch (this.status) {
            case LIST_STATUS.ACTIVE:
                return 'Подтвержден';
            case LIST_STATUS.WAIT:
                return 'Не подвтержден';
            case LIST_STATUS.BLOCK:
                return 'Заблокирован';
            default:
                return 'Анонимный пользователь';
        }
    }
    get getToken(): string {
        return <string>this.token
    }

    @MutationAction
    public loading(value = true) {
        this.load = value;
    }
    @Mutation
    private TOKEN_REFRESH_SUCCESS (data: RefreshResponse) {
        this.token = data.token;
        this.refreshToken = data.refreshToken;
        localStorage.setItem(TOKEN, JSON.stringify(this.token));
        localStorage.setItem(REFRESH_TOKEN, JSON.stringify(this.refreshToken));
        this.load = false;
    }
    @Mutation
    private AUTHENTICATING_SUCCESS (data: AuthResponse) {
        this.token = data.token;
        this.refreshToken = data.refreshToken;
        this.status = data.status;
        this.role = data.role;
        localStorage.setItem(REFRESH_TOKEN, <string>this.refreshToken);
        localStorage.setItem(TOKEN, <string>this.token);
        localStorage.setItem(STATUS, <string>this.status);
        localStorage.setItem(ROLE, <string>this.role);
        this.load = false;
    }
    @Mutation
    private LOGOUT() {
        this.refreshToken = null;
        this.token = null;
        this.status = null;
        this.role = null;
        localStorage.removeItem(TOKEN);
        localStorage.removeItem(REFRESH_TOKEN);
        localStorage.removeItem(STATUS);
        localStorage.removeItem(ROLE);
        this.load = false;
    }

    @Action({ rawError: true })
    public async login(payload: LoginRequest): Promise<AuthResponse> {
        this.loading();
        const response  = await AuthService.login(payload);
        console.log(response);
        this.AUTHENTICATING_SUCCESS(response.data);
        return Promise.resolve(response.data);
    }

    @Action({ rawError: true })
    public async register(payload: RegisterRequest): Promise<AuthResponse> {
        this.loading();
        const response  = await AuthService.register(payload);
        console.log(response);
        this.AUTHENTICATING_SUCCESS(response.data);
        return Promise.resolve(response.data);
    }

    @Action({ rawError: true })
    public async resetPassword(payload: RegisterRequest): Promise<AuthResponse> {
        this.loading();
        this.LOGOUT();
        const response  = await AuthService.resetPassword(payload);
        return Promise.resolve(response.data);
    }

    @Action({ rawError: true })
    public async refresh(): Promise<RefreshResponse> {
        this.loading();
        if(this.refreshToken) {
            const response = await AuthService.refreshToken({refreshToken: this.refreshToken});
            this.TOKEN_REFRESH_SUCCESS(response.data);
            return Promise.resolve(response.data);
        }
    }

    @Action({ rawError: true })
    public logout() {
        this.LOGOUT();
        AuthService.logout();
    }

    @Mutation
    private INIT() {
        this.token = localStorage.getItem(TOKEN);
        this.refreshToken = localStorage.getItem(REFRESH_TOKEN);
        this.status = localStorage.getItem(STATUS);
        this.role = localStorage.getItem(ROLE);
    }
    @Action
    public init() {
        this.INIT();
    }

}

const TOKEN = 'TOKEN', ROLE = 'ROLE', REFRESH_TOKEN = 'REFRESH_TOKEN', STATUS = 'STATUS';
const ROLES = { ADMIN: 'ROLE_ADMIN', USER:'ROLE_USER'};
const LIST_STATUS = { ACTIVE: 'ACTIVE', WAIT:'WAIT', BLOCK: 'BLOCK'};

export interface IAuthState {
    token: string | null;
    refreshToken: string | null;
    status: string | null;
    role: string | null;
    load: boolean;
}

export const AuthModule = getModule(Auth);