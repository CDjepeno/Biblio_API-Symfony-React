import axios from 'axios';
import React from 'react';
import { GENRE_API } from '../config';



export default class GenreServices
{
    static findAll() {
        return axios 
            .get(GENRE_API)
            .then(response => response.data['hydra:member'])
            .catch(error => this.handleError(error))
    }

    static handleError(error) {
        console.error(error);
    }
}