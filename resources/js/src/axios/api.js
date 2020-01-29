import axios from 'axios';

const api = axios.create({
    baseURL: 'http://testix/api',
})
api.interceptors.response.use(function (response) {
    return response.data;
})

export default api;