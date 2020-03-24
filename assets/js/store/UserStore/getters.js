const getters = {
    isLoading(state) {
        return state.isLoading;
    },
    isAuthenticated(state) {
        return !!state.token;
    },
    hasRole(state) {
        return state.roles.indexOf(role) !== -1;
    },
    hasErrorLogin(state) {
        return state.errorsLogin !== null;
    },
    hasErrorRegister(state) {
        return state.errorsRegister !== null;
    },
    errorsLogin(state) {
        return state.errorsLogin;
    },
    errorsRegister(state) {
        return state.errorsRegister;
    },
    token(state){
        return state.token;
    }
};

export default getters;