import API from "../../api/deck";
import {
    FETCHING_DECKS,
    FETCHING_DECKS_ERROR,
    FETCHING_DECKS_SUCCESS
} from "./constants";

const actions = {
    async findAll(context) {
        context.commit(FETCHING_DECKS);
        try {
            let response = await API.findAll();
            context.commit(FETCHING_DECKS_SUCCESS, response.data);
            return response.data;
        } catch (error) {
            context.commit(FETCHING_DECKS_ERROR, error);
            return null;
        }
    }
};

export default actions;