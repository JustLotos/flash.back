import axios from "./common";

export default {
    findAll() {
        return axios.get("/decks", {});
    },
};
