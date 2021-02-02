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

    static addBook(book) {
        return axios
            .post(BOOKS_API, {
                ...book, 
                author:`/apiPlatform/authors/${book.author}`,
                genre:`/apiPlatform/genres/${book.genre}`,
                editor:`/apiPlatform/editors/${book.editor}`,
            })
            .then(response => response.data);
    }

    static handleError(error) {
        console.error(error);
    }
}

