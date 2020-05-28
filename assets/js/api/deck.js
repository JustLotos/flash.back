import axios from "./common";

export default {
    getAll() { return axios.get("/decks"); },
    getOne(id) { return axios.get("/decks/" + id); },
    delete(id) { return axios.delete("/decks/" + id); },

    create(deck) {
        return axios.post("/decks", {
            name: deck.name,
            description: deck.description,
            limit_repeat: deck.limit_repeat,
            limit_learning: deck.limit_learning,
            difficulty_index: deck.difficulty_index,
            modifier_index: deck.modifier_index,
            base_index: deck.base_index
        });
    },

    update(deck) {
        return axios.put("/decks/" + deck.id, {
            name: deck.name,
            description: deck.description,
            limit_repeat: deck.limit_repeat,
            limit_learning: deck.limit_learning,
            difficulty_index: deck.difficulty_index,
            modifier_index: deck.modifier_index,
            base_index: deck.base_index
        });
    },


};
