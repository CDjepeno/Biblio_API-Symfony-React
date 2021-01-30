import React, { useContext } from 'react';
import { Redirect, Route } from 'react-router-dom';
import authContext from './context/authContext';

const PrivateRoute = ({path, component}) => {
    const {isAuthenticated} = useContext(authContext);
    return isAuthenticated ? (<Route path={path} component={component}/>) : (<Redirect to="/login" />)
}
 
export default PrivateRoute;