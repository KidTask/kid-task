import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {AdultDashboard} from "./pages/AdultDashboard";


const Routing = () => (
	<>
	<BrowserRouter>
	<Switch>
	<Route exact path="/" component={AdultDashboard}/>
<Route component={FourOhFour}/>
</Switch>
</BrowserRouter>
</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));