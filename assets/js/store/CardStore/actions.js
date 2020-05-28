import {
    CREATING_CARD, CREATING_CARD_ERROR, CREATING_CARD_SUCCESS,
    DELETING_CARD, DELETING_CARD_ERROR, DELETING_CARD_SUCCESS,
    FETCHING_CARDS, FETCHING_CARDS_ERROR, FETCHING_CARDS_SUCCESS,
    GETTING_CARD, GETTING_CARD_ERROR, GETTING_CARD_SUCCESS,
    UPDATING_CARD, UPDATING_CARD_ERROR, UPDATING_CARD_SUCCESS
} from "./constants";
import API from "../../api/card";

export default {
    async getOne(context, card) {
        context.commit(GETTING_CARD);
        try {
            let response = await API.getOne(card.id);
            context.commit(GETTING_CARD_SUCCESS, response.data);
            return Promise.resolve(response.data);
        } catch (errors) {
            context.commit(GETTING_CARD_ERROR, errors.response.data.errors);
            return Promise.reject(errors.response.data.errors);
        }
    },

    async getAll(context) {
        context.commit(FETCHING_CARDS);
        try {
            let response = await API.getAll();
            context.commit(FETCHING_CARDS_SUCCESS, response.data);
            return Promise.resolve(response.data);
        } catch (errors) {
            context.commit(FETCHING_CARDS_ERROR, errors.response.data.errors);
            return Promise.reject(errors.response.data.errors);
        }
    },

    async create(context, card) {
        context.commit(CREATING_CARD);
        try {
            let response = await API.create(card);
            context.commit(CREATING_CARD_SUCCESS, response.data);
            return Promise.resolve(response.data);
        } catch (errors) {
            context.commit(CREATING_CARD_ERROR, errors.response.data.errors);
            return Promise.reject(errors.response.data.errors);
        }
    },

    async update(context, card) {
        context.commit(UPDATING_CARD);
        try {
            let response = await API.update(card);
            context.commit(UPDATING_CARD_SUCCESS, response.data);
            return Promise.resolve(response.data);
        } catch (errors) {
            context.commit(UPDATING_CARD_ERROR, errors.response.data.errors);
            return Promise.reject(errors.response.data.errors);
        }
    },

    async delete(context, card) {
        context.commit(DELETING_CARD);
        try {
            let response = await API.delete(card.id);
            context.commit(DELETING_CARD_SUCCESS, card);
            return Promise.resolve(response.data);
        } catch (errors) {
            context.commit(DELETING_CARD_ERROR, errors.response.data.errors);
            return Promise.reject(errors.response.data.errors);
        }
    }
}