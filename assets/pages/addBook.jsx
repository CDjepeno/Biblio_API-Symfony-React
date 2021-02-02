import { Button, Container, FormControl,  InputLabel,  makeStyles,  MenuItem, Select, TextField } from '@material-ui/core';
import React, { useEffect, useState } from 'react';
import AuthorServices from '../services/authorAPI';
import BookService from '../services/bookAPI';
import EditorServices from '../services/editorAPI';
import GenreServices from '../services/genreAPI';

const AddBook = ({ history }) => {

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
    const [genres, setGenres]   = useState([]);

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
    const fetchEditors = async() => {
        try {
            const editors = await EditorServices.findAll();
            setEditors(editors);
        } catch (error) {
            console.log(error.message)
        }
    }
    // Récupération des genres
    const fetchGenres = async() => {
        try {
            const genres = await GenreServices.findAll();
            setGenres(genres);
        } catch (error) {
            console.log(error.message)
        }
    }
    
    const handleChange = ({ target }) => {
        const {name, value} = target;
        setBook({...book, [name]: "type" === "number" ? parseInt(value) : value})
    }
    
    const handleSubmit = async (e) => {
        e.preventDefault();
        console.log(book);
        try {
            await BookService.addBook(book)
            history.replace("/main")
        } catch (error) {   
            console.log(error.message);    
        }
    }

    useEffect(() => {
        fetchEditors()
        fetchGenres()
        fetchAuthors()
    },[])


    const useStyles = makeStyles(theme => ({
        formControl: {
            minWidth: 920
        }
    }));

    const classes = useStyles();

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
                <FormControl className={classes.formControl}>
                    <InputLabel>Genre</InputLabel>
                    <Select name="genre" value={book.genre} onChange={handleChange}> 
                        {genres.map(genre => 
                            <MenuItem key={genre.id} value={genre.id} > 
                                {genre.title}  
                            </MenuItem>
                        )}
                    </Select>
                </FormControl>
                    <p>{book.genre}</p>
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
                <FormControl className={classes.formControl}>
                    <InputLabel>Editeur</InputLabel>
                    <Select name="editor" value={book.editor} onChange={handleChange}> 
                        {editors.map(editor => 
                            <MenuItem key={editor.id} value={editor.id} > 
                                {editor.firstname}  
                            </MenuItem>
                        )}
                    </Select>
                </FormControl>
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
                    type="number"
                />
                <FormControl className={classes.formControl}>
                    <InputLabel>Auteur</InputLabel>
                    <Select name="author" value={book.author.id} onChange={handleChange}> 
                        {authors.map(author => 
                            <MenuItem key={author.id} value={author.id} > 
                                {author.firstname} {author.lastname}  
                            </MenuItem>
                        )}
                    </Select>
                </FormControl>
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