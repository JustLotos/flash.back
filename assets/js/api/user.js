import axios from "./common";

export default {
    getUserProfile(token) {
        return axios.get("/user/profile", {
            headers: {
                'Authorization': 'Bearer ' + token
            }
        });
    },
}