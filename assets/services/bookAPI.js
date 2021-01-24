import React from 'react';
import { BOOKS_API } from "../config";


export default class BookService {
    
    static findAll() {
        return fetch("https://localhost:8000/apiPlatform/books")
        .then(response => response.json())
        .catch(error => this.handleError(error))
    }

    static handleError(error) {
        console.error(error);
    }
}

