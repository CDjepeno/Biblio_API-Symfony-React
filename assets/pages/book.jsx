import React, { useEffect, useState } from 'react';
import BookService from '../services/bookAPI';


const Book = ({match}) => {
   
    const [book, setBook] = useState()

    useEffect(() => {
        BookService.findOne(match.params.id)
        .then(book => setBook(book))
    }, [match.params.id])

    return ( 
        <h1>Bienvenue</h1>
     );
}
 
export default Book;