import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";
import {KidSignUp} from "./pages/KidSignUp";
import {SignUp} from "./pages/SignUp";

const Routing = () => (
	<>
	<BrowserRouter>
	<Switch>
	<Route exact path="/" component={SignUp}/>
<Route component={FourOhFour}/>
</Switch>
</BrowserRouter>
</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));