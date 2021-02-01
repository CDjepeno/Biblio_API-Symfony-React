import React from 'react';

export default class EditorServices 
{
    static findAll() {
        return axios
            .get(AUTHORS_API)
            .then(response => response.data['hydra:member'])
            .catch(error => this.handleError(error))
    }
}