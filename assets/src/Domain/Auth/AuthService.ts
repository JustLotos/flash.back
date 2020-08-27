import {AuthResponse, LoginRequest, RefreshResponse, RefreshTokenRequest, RegisterRequest} from "./types";
import Axios from "../../Plugins/Axios";

export default {
    async login(payloads: LoginRequest): AxiosResponse<AuthResponse> {
        return Axios.post("/auth/login", payloads);
    },
    async register(payloads: RegisterRequest): AxiosResponse<AuthResponse> {
        return Axios.post("/auth/register", payloads);
    },
    async refreshToken(payloads: RefreshTokenRequest): AxiosResponse<RefreshResponse> {
        return Axios.post('/auth/token/refresh', payloads);
    },
    async resetPassword(payloads: RegisterRequest): AxiosResponse {
        return Axios.post('/auth/reset/password', payloads);
    },
    logout() {

    }
};
