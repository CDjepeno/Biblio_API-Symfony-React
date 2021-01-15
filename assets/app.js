import React from 'react';
import ReactDOM from "react-dom";
import Main from './pages/main';
import './styles/app.scss';

const App = () => {
    return(
    <>
        <Main/>
    </>  
    )





}
const rootElement = document.getElementById("root");

ReactDOM.render(<App/>, rootElement);

