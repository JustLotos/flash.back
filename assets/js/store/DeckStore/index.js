import mutations from "./mutations";
import getters from "./getters";
import actions from "./actions";

export default {
    state: {
        decks: [
            {
                name: 'Title deck 1',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                name: 'Not title deck 2',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                name: 'Test Deck',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                name: 'its simple',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                name: 'okay',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                name: 'It is not possible to link the title text to a cell.',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
        ]
    },
    getters: getters,
    mutations: mutations,
    actions: actions,
    namespaced: true,
};
