import axios from 'axios';
import React from 'react';
import  { AUTHORS_API }  from '../config';

export default class AuthorServices 
{
    static findAll() {
        return axios
            .get(AUTHORS_API)
            .then(response => response.data['hydra:member'])
            .catch(error => this.handleError(error))
    }
}