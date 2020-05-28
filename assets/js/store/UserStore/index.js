import {USER} from "./constants";
import mutations from './mutations';
import actions from './actions';

export default {
    state: {
        user: localStorage.getItem(USER) || userDefault(),
    },
    getters: {
        user:  state => state.user,
    },
    mutations: mutations,
    actions: actions,
};

export function userDefault() {
    return {
        email: null,
        roles: [],
        active: false,
        nickname: null
    }
}