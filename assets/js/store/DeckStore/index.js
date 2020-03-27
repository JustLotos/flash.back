import mutations from "./mutations";
import getters from "./getters";
import actions from "./actions";

export default {
    state: {
        decks: [
            {
                id: '1',
                name: 'Title deck 1',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                id: '2',
                name: 'Not title deck 2',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                id: '3',
                name: 'Test Deck',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                id: '4',
                name: 'its simple',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                id: '5',
                name: 'okay',
                description: 'And produce say the ten moments parties. Simple innate summer fat appear basket his desire joy. Outward clothes promise at gravity do excited.',
            },
            {
                id: '6',
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
