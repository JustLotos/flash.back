import axios from 'axios';

export const API_URL = process.env.API_URL || 'http://flash.local/api/v1';

let axiosCustom = axios.create({
    headers: {
        'Content-Type': 'application/json',
    },
    baseURL: API_URL
});

export default axiosCustom;
