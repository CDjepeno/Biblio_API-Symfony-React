import { AppBar, Button, Toolbar, Typography } from '@material-ui/core';
import React, { useContext } from 'react';
import { Link, NavLink, useHistory } from 'react-router-dom';
import authContext from '../context/authContext';
import AuthService from '../services/authAPI';

const Navbar = ({ history }) => {
    const { isAuthenticated, setIsAuthenticated} = useContext(authContext);

    const handleLogout = () => {
        AuthService.logout();
        setIsAuthenticated(false)
        history.push("/")
    }
    return (
    
    <AppBar position="relative">
        <Toolbar>
            <Typography variant="h6" color="inherit" noWrap>
                <NavLink to="/" className="MuiLink-underlineNone" color="white">
                    BiblioAPI
                </NavLink>
            </Typography>
            {(!isAuthenticated && (
                <Button  variant="contained" color="secondary" className="button_navbar"  onClick={handleLogout}>
                    deconexion
                </Button>
             )) }
        </Toolbar>
    </AppBar>
   
  
    );
}

export default Navbar;