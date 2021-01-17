import React from 'react';
import ReactDOM from "react-dom";
import Main from './pages/Main';
import Login from './pages/Login';
import './styles/app.scss';
import { HashRouter, Switch, Route } from "react-router-dom";
import Register from './pages/Register';
import { AppBar, Toolbar, Typography } from '@material-ui/core';

const App = () => {
    return(
    <>
        <HashRouter>
            <Switch>
                <Route path="/login" component={Login}/>
                <Route path="/register" component={Register}/>
                <Route path="/" component={Main}/>
            </Switch>

        </HashRouter>
    </>  
    )
}

ReactDOM.render(<App/>, document.getElementById("root"));

