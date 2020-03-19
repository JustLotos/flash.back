const getters = {
    isLoading(state) {
        return state.isLoading;
    },
    isAuthenticated(state) {
        return state.isAuthenticated;
    },
    hasRole(state) {
        return role => {
            return true;
            // return state.user.roles.indexOf(role) !== -1;
        }
    },
    hasError(state) {
        return state.errors !== null;
    },
    error(state) {
        return state.errors;
    },
};

export default getters;