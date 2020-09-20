import { RouteConfig } from "vue-router";
import { UserModule } from "../../../User/UserModule";

export class Menu {
    private _routes;

    constructor() {
        this._routes = [];
    }

    public setRoutes(routes: Array<RouteConfig>) {
        this._routes = routes;
    }

    get getNavMenu(): Array<RouteConfig> {
        return this._routes.filter((item: RouteConfig)=>{
            if(UserModule.isAuthenticated) {
                return item.meta.menu && item.meta.auth;
            }
            return item.meta.menu && !item.meta.auth;
        });
    }
}