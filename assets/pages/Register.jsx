import React, { useState } from 'react';
import Avatar from '@material-ui/core/Avatar';
import Button from '@material-ui/core/Button';
import CssBaseline from '@material-ui/core/CssBaseline';
import TextField from '@material-ui/core/TextField';
import Link from '@material-ui/core/Link';
import Paper from '@material-ui/core/Paper';
import Box from '@material-ui/core/Box';
import Grid from '@material-ui/core/Grid';
import Typography from '@material-ui/core/Typography';
import { makeStyles } from '@material-ui/core/styles';
import AuthService from '../services/authAPI';

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
    backgroundImage: 'url(https://www.archimag.com/sites/archimag.com/files/styles/article/public/web_articles/image/bibliotheque.jpg?itok=AnndQaIa)',
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

const Register = ({ history }) => {
  const classes = useStyles();

  const [member, setMember] = useState({
    firstname: "",
    lastname: "",
    address: "",
    communeCode: "",
    mail: "",
    phone: "",
    password: "",
    passwordConfirm: ""
  })

  const [error, setError] = useState({
    firstname: "",
    lastname: "",
    address: "",
    communeCode: "",
    mail: "",
    phone: "",
    password: "",
    passwordConfirm: ""
  })

  const handleChange = ({ currentTarget }) => {
    const {value, name} = currentTarget;
    setMember({...member, [name]: value})
  }

	const handleSubmit = async (e) => {
		e.preventDefault();

		const apiError = {};
		if(member.password !== member.passwordConfirm){
			apiError.passwordConfirm = "Votre confirmation de mot de passe n'est pas conforme avec le mot de passe"
			setError(apiError)
			return;
		}
		
		try {
			await AuthService.register(member)
			setError({})
			history.replace('/login')
		} catch ({ response }) {
			const {violations} = response.data;
			if(violations) {    
				violations.forEach(({propertyPath, message}) => {
					apiError[propertyPath] = message;
				})
				setError(apiError);
			}
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
            Crée un compte
          </Typography>
          <form className={classes.form} noValidate onSubmit={handleSubmit}>
            <TextField
              value={member.firstname}
              onChange={handleChange}
              error={error.firstname}
              variant="outlined"
              margin="normal"
              required
              fullWidth
              size = "small"
              id="firstname"
              label="Prenom"
              name="firstname"
              autoComplete="prenom"
              autoFocus
            />
			{/* error */}
			{error.firstname &&
				<div className="card-panel red accent-1"> 
				{error.firstname} 
				</div>
			} 
            <TextField
              value={member.lastname}
              onChange={handleChange}
              error={error.lastname}
              variant="outlined"
              margin="normal"
              required
              fullWidth
              size="small"
              id="lastname"
              label="Nom"
              name="lastname"
              autoComplete="nom"
              autoFocus
            />
			{/* error */}
			{error.lastname &&
				<div className="card-panel red accent-1"> 
				{error.lastname} 
				</div>
			} 
            <TextField
              value={member.address}
              onChange={handleChange}
              error={error.address}
              variant="outlined"
              margin="normal"
              required
              fullWidth
              size="small"
              id="address"
              label="Adresse"
              name="address"
              autoComplete="adresse"
              autoFocus
            />
			{/* error */}
			{error.address &&
				<div className="card-panel red accent-1"> 
				{error.address} 
				</div>
			} 
            <TextField
              value={member.communeCode}
              onChange={handleChange}
              error={error.communeCode}
              variant="outlined"
              margin="normal"
              required
              fullWidth
              size="small"
              id="communeCode"
              label="Code postal"
              name="communeCode"
              autoComplete="Code postal"
              autoFocus
            />
			{/* error */}
			{error.communeCode &&
				<div className="card-panel red accent-1"> 
				{error.communeCode} 
				</div>
			} 
            <TextField
              value={member.mail}
              onChange={handleChange}
              error={error.mail}
              variant="outlined"
              margin="normal"
              required
              fullWidth
              size="small"
              id="mail"
              label="Email"
              name="mail"
              autoComplete="Email"
              autoFocus
            />
			{/* error */}
			{error.mail &&
				<div className="card-panel red accent-1"> 
				{error.mail} 
				</div>
			} 
            <TextField
              value={member.phone}
              onChange={handleChange}
              error={error.phone}
              variant="outlined"
              margin="normal"
              required
              fullWidth
              size="small"
              id="phone"
              label="Numéro de télephone"
              name="phone"
              autoComplete="Numéro de téléphone"
              autoFocus
            />
			{/* error */}
			{error.phone &&
				<div className="card-panel red accent-1"> 
				{error.phone} 
				</div>
			} 
            <TextField
              value={member.password}
              onChange={handleChange}
              error={error.password}
              variant="outlined"
              margin="normal"
              required
              fullWidth
              size="small"
              id="password"
              label="Mot de passe"
              name="password"
			  autoComplete="Mot de passe"
			  type="password"
              autoFocus
            />
			{/* error */}
			{error.password &&
				<div className="card-panel red accent-1"> 
				{error.password} 
				</div>
			} 
            <TextField
              value={member.passwordConfirm}
              onChange={handleChange}
              error={error.passwordConfirm}
              variant="outlined"
              margin="normal"
              required
              fullWidth
              size="small"
              id="password2"
              label="Confirmer votre mot de passe"
              name="passwordConfirm"
			  autoComplete="Confirmer votre mot de passe"
			  type="password"
              autoFocus
            />
			{/* error */}
			{error.passwordConfirm &&
				<div className="card-panel red accent-1"> 
				{error.passwordConfirm} 
				</div>
			} 
           
            <Button
              type="submit"
              fullWidth
              variant="contained"
              color="primary"
              className={classes.submit}
            >
              Crée un compte
            </Button>
            <Box mt={5}>
              <Copyright />
            </Box>
          </form>
        </div>
      </Grid>
    </Grid>
  );
}
export default Register;