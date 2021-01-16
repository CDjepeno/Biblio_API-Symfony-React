import React from 'react';
import ReactDOM from "react-dom";
import Main from './pages/main';
import './styles/app.scss';
import { HashRouter, Switch, Route } from "react-router-dom";

const App = () => {
    return(
    <>
        <HashRouter>
            <Switch>
                <Route path="/login" component={Logi}/>
                <Route path="/" component={Main}/>
            </Switch>

        </HashRouter>
    </>  
    )





}
const rootElement = document.getElementById("root");

ReactDOM.render(<App/>, rootElement);

