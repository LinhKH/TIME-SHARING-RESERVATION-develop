const auth = {
    namespaced: true,
    state() {
        return {
            isAuthenticated: false,
        };
    },
};
export default auth;
