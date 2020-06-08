import {AuthResponse, LoginRequest, RefreshResponse, RefreshTokenRequest, RegisterRequest} from "./types";
import Axios from "../../Plugins/Axios";
import {AxiosPromise} from "axios";

export default {
    async login(payloads: LoginRequest): AxiosPromise<AuthResponse> {
        return Axios.post("/auth/login", payloads);
    },
    async register(payloads: RegisterRequest): AxiosPromise<AuthResponse> {
        return Axios.post("/auth/register", payloads);
    },
    async refreshToken(payloads: RefreshTokenRequest): AxiosPromise<RefreshResponse> {
        return Axios.post('/auth/token/refresh', payloads);
    },
    logout() {

    }
};
