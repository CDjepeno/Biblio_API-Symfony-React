import React from 'react';
import ReactDOM from "react-dom";
import Main from './pages/Main';
import Login from './pages/Login';
import './styles/app.scss';
import { HashRouter, Switch, Route } from "react-router-dom";
import Register from './pages/Register';
import { AppBar, Toolbar, Typography } from '@material-ui/core';
import Index from './pages';

const App = () => {
    return(
    <>
        <HashRouter>
            <Switch>
                <Route path="/login" component={Login}/>
                <Route path="/register" component={Register}/>
                <Route path="/main" component={Main}/>
                <Route path="/" component={Index}/>
            </Switch>

        </HashRouter>
    </>  
    )
}

ReactDOM.render(<App/>, document.getElementById("root"));

