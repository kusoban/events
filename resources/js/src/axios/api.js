import axios from 'axios';

const api = axios.create({
    baseURL: 'http://events.api/api',
})
api.interceptors.response.use(function (response) {
    return response.data;
})

export default api;