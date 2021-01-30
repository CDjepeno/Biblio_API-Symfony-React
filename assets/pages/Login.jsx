import React, { useContext, useState } from 'react';
import Avatar from '@material-ui/core/Avatar';
import Button from '@material-ui/core/Button';
import CssBaseline from '@material-ui/core/CssBaseline';
import TextField from '@material-ui/core/TextField';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import Checkbox from '@material-ui/core/Checkbox';
import Link from '@material-ui/core/Link';
import Paper from '@material-ui/core/Paper';
import Box from '@material-ui/core/Box';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import { makeStyles } from '@material-ui/core/styles';
import AuthService from '../services/authAPI';
import authContext from '../context/authContext';


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
  root: {
    height: '100vh',
  },
  image: {
    backgroundImage: 'url(https://bretteville50110.fr/wp-content/uploads/2019/02/images-bibliotheque.jpg)',
    backgroundRepeat: 'no-repeat',
    backgroundColor:
      theme.palette.type === 'light' ? theme.palette.grey[50] : theme.palette.grey[900],
    backgroundSize: 'cover',
    backgroundPosition: 'center',
  },
  paper: {
    margin: theme.spacing(8, 4),
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
  },
  avatar: {
    margin: theme.spacing(1),
    backgroundColor: theme.palette.secondary.main,
  },
  form: {
    width: '100%', // Fix IE 11 issue.
    marginTop: theme.spacing(1),
  },
  submit: {
    margin: theme.spacing(3, 0, 2),
  },
}));

const Login = ({ history }) => {
    const classes = useStyles();
    const [error, setError] = useState("")
    const [credentials, setCredentials] = useState({
    mail: "",
    password:""
    })

    const { setIsAuthenticated } = useContext(authContext)

    const handleChange = ({currentTarget}) => {
    const value = currentTarget.value;
    const name = currentTarget.name;
    setCredentials({...credentials, [name]: value})
    }

    const handleSubmit = async (e) => {
        e.preventDefault()
        try {
            await AuthService.login(credentials);
            setError("")
            setIsAuthenticated(true)
            history.replace("/main")
        } catch (error) {
            console.log(error);
            setError("Aucun compte ne possède cette adresse ou alors les informations ne correspondent pas")
        }
    } 


    return (
    <Grid container component="main" className={classes.root}>
        <CssBaseline />
        <Grid item xs={false} sm={4} md={7} className={classes.image} />
        <Grid item xs={12} sm={8} md={5} component={Paper} elevation={6} square>
        <div className={classes.paper}>
            <Avatar className={classes.avatar}>
            {/* <LockOutlinedIcon /> */}
            </Avatar>
            <Typography component="h1" variant="h5">
            Connexion
            </Typography>
            <form className={classes.form} method="POST"  onSubmit={handleSubmit}>
                <TextField
                    value={credentials.username}
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    label="Email Address"
                    name="mail"
                    autoComplete="email"
                    autoFocus
                    />
                <TextField
                    value={credentials.password}
                    onChange={handleChange}
                    variant="outlined"
                    margin="normal"
                    required
                    fullWidth
                    name="password"
                    label="Password"
                    type="password"
                    id="password"
                    autoComplete="current-password"
                />
                <FormControlLabel
                    control={<Checkbox value="remember" color="primary" />}
                    label="Se souvenir de moi"
                />
                { error && <p className="invalid-feedback">{error}</p> }
                <Button
                    type="submit"
                    fullWidth
                    variant="contained"
                    color="primary"
                    className={classes.submit}
                >
                    Connexion
                </Button>
                <Grid container>
                    <Grid item xs>
                    <Link href="#" variant="body2">
                        Mot de passe oublié?
                    </Link>
                    </Grid>
                    <Grid item>
                    <Link href="#" variant="body2">
                        {"Vous n'avez pas de compte ? Crée un compte"}
                    </Link>
                    </Grid>
                </Grid>
                <Box mt={5}>
                    <Copyright />
                </Box>
            </form>
        </div>
        </Grid>
    </Grid>
    );
}
export default Login;