const getters = {
    decks(state) {
        return state.decks
    },
    deck(state){
        return state.decks.find(d => d.id === this.id)
    },
    error(state) {
        return state.error;
    },
    hasError(state) {
        return state.error !== null;
    },
};

export default getters;