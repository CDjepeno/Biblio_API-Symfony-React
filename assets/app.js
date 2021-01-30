import React from 'react';
import ReactDOM from "react-dom";
import Main from './pages/Main';
import Login from './pages/Login';
import './styles/app.scss';
import { HashRouter, Switch, Route, withRouter } from "react-router-dom";
import Register from './pages/Register';
import Index from './pages';
import Navbar from './componant/Navbar';
// jwt-decode package pour token décodé
const App = () => {

    const NavbarWithRouter = withRouter(Navbar)
  
    return(
    <>
        <HashRouter>
            <NavbarWithRouter/>
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

