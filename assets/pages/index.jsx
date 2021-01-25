import React, { useEffect, useState } from 'react';
import AppBar from '@material-ui/core/AppBar';
import Button from '@material-ui/core/Button';
import Card from '@material-ui/core/Card';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import CardMedia from '@material-ui/core/CardMedia';
import CssBaseline from '@material-ui/core/CssBaseline';
import Grid from '@material-ui/core/Grid';
import Toolbar from '@material-ui/core/Toolbar';
import Typography from '@material-ui/core/Typography';
import { makeStyles } from '@material-ui/core/styles';
import Container from '@material-ui/core/Container';
import BookService from '../services/bookAPI';
import Link from '@material-ui/core/Link';
import { NavLink } from 'react-router-dom';

function Copyright() {
  return (
    <Typography variant="body2" color="textSecondary" align="center">
      {'Copyright © '}
      <Link color="inherit" href="https://material-ui.com/">
        Biblio
      </Link>{' '}
      {new Date().getFullYear()}
      {'.'}
    </Typography>
  );
}

const useStyles = makeStyles((theme) => ({
    icon: {
      marginRight: theme.spacing(2),
    },
    heroContent: {
      backgroundColor: theme.palette.background.paper,
      padding: theme.spacing(8, 0, 6),
    },
    heroButtons: {
      marginTop: theme.spacing(4),
    },
    cardGrid: {
      paddingTop: theme.spacing(8),
      paddingBottom: theme.spacing(8),
    },
    card: {
      height: '100%',
      display: 'flex',
      flexDirection: 'column',
    },
    cardMedia: {
      paddingTop: '56.25%', // 16:9
    },
    cardContent: {
      flexGrow: 1,
    },
    footer: {
      backgroundColor: theme.palette.background.paper,
      padding: theme.spacing(6),
    },
  }));
  
const cards = [1, 2, 3, 4, 5, 6, 7, 8, 9];
const Index = (props) => {
  const [books, setBooks] = useState([]);

  useEffect(() => {
    BookService.findAll()
    .then(books => setBooks(books))
  }, [])
  console.log(books);

  const classes = useStyles();
  return ( 
      <React.Fragment>
      <CssBaseline />
      <AppBar position="relative">
        <Toolbar>
          <Typography variant="h6" color="inherit" noWrap>
            BiblioAPI
          </Typography>
          <Button  variant="contained" color="secondary" className="button_navbar">
                <NavLink to="/register" justifyContent="flex-end" className="Nav_link">
                    deconexion
                </NavLink>        
            </Button>
        </Toolbar>
      </AppBar>
      <main>
        {/* Hero unit */}
        <div className={classes.heroContent}>
          <Container maxWidth="sm">
            <Typography component="h1" variant="h2" align="center" color="textPrimary" gutterBottom>
              Biblio
            </Typography>
            <Typography variant="ha" align="center" color="textSecondary" paragraph>
              Connectez vous ou enregister vous pour acceder a nos livres !
            </Typography>
            <div className={classes.heroButtons}>
              <Grid container spacing={2} justify="center">
                <Grid item>
                  <Button  variant="contained" color="primary">
                    <NavLink to="/login" className="Nav_link">
                        Connexion
                    </NavLink>        
                  </Button>
                </Grid>
                <Grid item>
                <Button  variant="contained" color="secondary">
                    <NavLink to="/register" className="Nav_link" >
                        Enregistrement
                    </NavLink>        
                </Button>
                </Grid>
              </Grid>
            </div>
          </Container>
        </div>
        <Container className={classes.cardGrid} maxWidth="md">
        
        </Container>
      </main>
      {/* Footer */}
      <footer className={classes.footer}>
        <Typography variant="h6" align="center" gutterBottom>
          Biblio
        </Typography>
        <Typography variant="subtitle1" align="center" color="textSecondary" component="p">
          Lire c'est la vie !!!
        </Typography>
        <Copyright />
      </footer>
      {/* End footer */}
    </React.Fragment>
    );
}
 
export default Index;