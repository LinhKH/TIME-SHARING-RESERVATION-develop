const tour = {
    namespaced: true,
    state() {
        return {
            tourDetailItem: {},
        };
    },
    getters: {
        getTourDetailItem(state) {
            return state.tourDetailItem;
        },
    },
    mutations: {
        setTourDetailItem(state, payload) {
            state.tourDetailItem = payload;
        },
    },
};
export default tour;
