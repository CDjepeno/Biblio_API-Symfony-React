import axios from 'axios';
import React from 'react';

export default class AuthService 
{
    static login(credentials) {
        return axios
            .post(LOGIN_API, credentials)
            .then(response => response.data.token)
            .then(token => {
                window.localStorage.setItem("authToken", token)
                setAxiosToken(token)
            })
    }

    /**
     * Positionne le token JWT sur Axios
     * @param {string} token 
     */
    static setAxiosToken(token) {
        axios.defaults.headers["Authorization"] = "Bearer " + token;
    }
} 