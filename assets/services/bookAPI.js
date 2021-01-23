import React from 'react';
import { BOOKS_API } from "../config";

async function findAll() {
    return fetch(BOOKS_API)
    .then(response => response.json())
    .catch(error => this.handleError(error))
}

export default findAll