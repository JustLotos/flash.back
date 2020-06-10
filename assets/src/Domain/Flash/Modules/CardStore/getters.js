export default {
    isLoading:      state => state.isLoading,
    cards:          state => state.byId,
    cardsId:        state => state.allIds,

    getCardsById: (state) => (cards) => {
        let temp = {};
        cards.forEach((id) => {
            temp[id] = state.byId[id];
        });
        return temp;
    },

    /* ERRORS */
    errorsDelete:    state => state.errors.delete,
    errorsCreate:    state => state.errors.create,
    errorsUpdate:    state => state.errors.update,
    errorsGetAll:    state => state.errors.getAll,
    errorsGetOne:    state => state.errors.getOne,
}