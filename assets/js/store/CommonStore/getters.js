export default {
    isLoading:          state => state.isLoading,

    isAuthenticated:    state => !!state.accessToken,
    accessToken:        state => state.accessToken,
    refreshToken:       state => state.refreshToken,

    errorsLogin:        state => state.errors.login,
    errorsRegister:     state => state.errors.register,
};