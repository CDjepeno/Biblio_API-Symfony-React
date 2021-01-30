import axios from 'axios';
import React from 'react';
import { BOOKS_API } from "../config";


export default class BookService 
{
    static findAll() {
        return axios 
            .get(BOOKS_API)
            .then(response => response.data['hydra:member'])
            .catch(error => this.handleError(error))
    }

    static handleError(error) {
        console.error(error);
    }
}

