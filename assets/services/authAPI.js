import axios from 'axios';
import jwtDecode from 'jwt-decode';
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

    static setup() {
        const token = window.localStorage.getItem("authToken");
        if(token) {
            const jwtData = jwtDecode(token);   
            if(jwtData.exp * 1000 > new Date().getTime()) {
                this.setAxiosToken(token)
            }
        }
    }

    static isAuthenticated() {
        const token = window.localStorage.getItem("authToken");
        if(token) {
            const jwtData = jwtDecode(token);   
            if(jwtData.exp * 1000 > new Date().getTime()) {
                this.setAxiosToken(token)
                return true
            }
            return false;
        }
        return false;
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