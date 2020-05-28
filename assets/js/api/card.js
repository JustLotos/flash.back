import axios from "./common";
import date from "../plugins/date";

export default {
    getAll() { return axios.get("/cards"); },
    getOne(id) { return axios.get("/cards/" + id); },
    delete(id) { return axios.delete("/cards/" + id); },

    create(card) {
        return axios.post("/cards", {
            name: card.name,
            next_repeat_at: date('Y-m-d\\TH:i:sP', new Date()),
            deck: card.deck,
            front_records: card.frontRecords,
            back_records: card.backRecords,
        });
    },

    update(card, ) {
        return axios.put("/cards/" + card.id, {
            name: card.name,
            next_repeat_at: date('Y-m-d\\TH:i:sP', new Date()),
            deck: card.deck,
            front_records: card.frontRecords,
            back_records: card.backRecords,
            count_repeat: card.count_repeat
        });
    },
};
