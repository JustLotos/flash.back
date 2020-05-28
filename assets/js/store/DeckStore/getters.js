export default {
    isLoading:      state => state.isLoading,

    decks:          state => state.byId,
    decksId:        state => state.allIds,

    getCardsId: (state) => (id) => state.byId[id].cards,

    /* ERRORS */
    errorsDelete:    state => state.errors.delete,
    errorsCreate:    state => state.errors.create,
    errorsUpdate:    state => state.errors.update,
    errorsGetAll:    state => state.errors.getAll,
    errorsGetOne:    state => state.errors.getOne,
};