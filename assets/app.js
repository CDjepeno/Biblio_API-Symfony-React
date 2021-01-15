import React from 'react';
import ReactDOM from "react-dom";
import './styles/app.scss';

const App = () => {
    return <h1>Bonjour</h1>
}
const rootElement = document.getElementById("root");

ReactDOM.render(<App/>, rootElement);

