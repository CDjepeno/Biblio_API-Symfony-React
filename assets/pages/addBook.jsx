import { Button, Container, TextField } from '@material-ui/core';
import Typography from '@material-ui/core/Typography';
import React, { useEffect, useState } from 'react';
import AuthorServices from '../services/authorAPI';
import EditorServices from '../services/authorAPI';

const AddBook = () => {

    const [book, setBook]   = useState({
        isbn:"",
        title:"",
        genre:"",
        editor:"",
        author:"",
        year:"",
        langue:"",
        picture:""
    });
    const [error, setError] = useState({
        isbn:"",
        title:"",
        genre:"",
        editor:"",
        author:"",
        year:"",
        langue:"",
        picture:""
    });
    const [authors, setAuthors] = useState([]);
    const [editors, setEditors] = useState([]);
    const [genres, setGenres] = useState([]);

    // Récupération des auteurs
    const fetchAuthors = async() => {
        try {
            const authors = await AuthorServices.findAll();
            setAuthors(authors);
        } catch (error) {
            console.log(error.message)
        }
    }

    // Récupération des editeurs
    const fetchEditor = async() => {
        try {
            const authors = await EditorServices.findAll();
            setEditors(authors);
        } catch (error) {
            console.log(error.message)
        }
    }

    const handleChange = ({ currentTarget }) => {
        const {name, value} = currentTarget;
        setBook({...book, [name]: value})
    }
    
    const handleSubmit = (e) => {
        e.prenventDefault();
        try {
            console.log(book);
        } catch (error) {   
            console.log(error.message);    
        }
    }

    useEffect(() => {
        fetchAuthors()
    },[])

    console.log(authors);
    return ( 
        <Container  maxWidth="md">
            <h1 align="center">Ajout d'un livre</h1>
            <form onSubmit={handleSubmit}>
                <TextField   
                    value={book.isbn}
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    label="Isbn"
                    name="isbn"
                    autoComplete="isbn"
                    autoFocus
                    />
                <TextField   
                    value={book.title}
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    label="Titre du livre"
                    name="title"
                    autoComplete="titre"
                    autoFocus
                    />
                <TextField   
                    value={book.genre}
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    label="Genre"
                    name="genre"
                    autoComplete="genre"
                    autoFocus
                    />
                <TextField 
                    value={book.editor}  
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    label="Editeur"
                    name="editor"
                    autoComplete="editeur"
                    autoFocus
                    />
                <TextField   
                    value={book.author}
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    label="Auteur"
                    name="author"
                    autoComplete="author"
                    autoFocus
                    />
                <TextField   
                    value={book.year}
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    label="Année"
                    name="year"
                    autoComplete="année"
                    autoFocus
                    />
                <TextField
                    value={book.langue}   
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    label="Langue"
                    name="langue"
                    autoComplete="langue"
                    autoFocus
                    />
                <TextField
                    value={book.picture}
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    name="picture"
                    label="Photo"
                    autoComplete="photo"
                />
                {/* { error && <p className="invalid-feedback">{error}</p> } */}
                <Button
                    type="submit"
                    fullWidth
                    variant="contained"
                    color="primary"       
                >
                    Ajouter
                </Button>
            </form>
        </Container>
     );
}
 
export default AddBook;