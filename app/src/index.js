import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {TaskForm} from "./pages/TaskForm";


import {KidSignUp} from "./pages/KidSignUp";
import {SignUp} from "./pages/SignUp";

import {Kid} from "./pages/Kid";


const Routing = () => (
	<>
	<BrowserRouter>
	<Switch>
	<Route exact path="/" component={Home}/>
	<Route exact path="/Ad"



		<Route exact path="/" component={Home}/>
<Route component={FourOhFour}/>
</Switch>
</BrowserRouter>
</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));