import React, { useState } from 'react';
import ReactDOM from "react-dom";
import { HashRouter, Route, Switch, withRouter } from "react-router-dom";
import MenuAppBar from './componant/Navbar';
import authContext from './context/authContext';
import Index from './pages';
import Login from './pages/Login';
import Main from './pages/Main';
import Register from './pages/Register';
import PrivateRoute from './privateRoute';
import AuthService from './services/authAPI';
import './styles/app.scss';
// jwt-decode package pour token décodé

AuthService.setup();

const App = () => {
    const [ isAuthenticated, setIsAuthenticated ] = useState(AuthService.isAuthenticated());
    const MenuWithRouter = withRouter(MenuAppBar)
    const contextValue = {
        isAuthenticated, 
        setIsAuthenticated
    }

    return(
    <>
        <authContext.Provider value={contextValue}>
            <HashRouter>
            {isAuthenticated && 
                <MenuWithRouter />
            }
                <Switch>
                    <Route path="/login" component={Login}/>
                    <Route path="/register" component={Register}/>
                    <PrivateRoute path="/main" component={Main}/>
                    <Route path="/" component={Index}/>
                </Switch>
            </HashRouter>
        </authContext.Provider>
    </>  
    )
}

ReactDOM.render(<App/>, document.getElementById("root"));

