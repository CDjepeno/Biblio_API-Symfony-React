import axios from 'axios';
import React from 'react';
import { LOGIN_API } from '../config';

export default class AuthService 
{
    static login(credentials) {
        return axios
            .post(LOGIN_API, credentials)
            .then(response => response.data.token)
            .then(token => {
                window.localStorage.setItem("authToken", token)
                this.setAxiosToken(token)
            })
    }

    static logout() {
        window.localStorage.removeItem("authToken");
        delete axios.defaults.headers["Authorization"];
    }

    /**
     * Positionne le token JWT sur Axios
     * @param {string} token 
     */
    static setAxiosToken(token) {
        axios.defaults.headers["Authorization"] = "Bearer " + token;
    }
} 