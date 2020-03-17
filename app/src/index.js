import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {KidSignUp} from "./pages/KidSignUp";
import {SignUp} from "./pages/SignUp";
import {Kid} from "./pages/KidDashboard";
import {AdultDashboard} from "./pages/AdultDashboard";
import {CreateTask} from "./pages/CreateTask";
import {Home} from "./pages/Home";
import axios from "axios";
axios.get("/apis/earl-grey/");

const Routing = () => (
	<>
	<BrowserRouter>
	<Switch>

	<Route exact path="/adult-dashboard" component={AdultDashboard}/>
	{/*<Route exact path="/kid-dashboard" component={Kid}/>*/}
	{/*<Route exact path="/kid-sign-up" component={KidSignUp}/>*/}
	<Route exact path="/adult-sign-up" component={SignUp}/>
	<Route exact path="/create-task" component={CreateTask}/>

		<Route exact path="/" component={Home}/>
	{/*<Route exact path="/task-form" component={TaskForm}/>*/}

<Route component={FourOhFour}/>
</Switch>
</BrowserRouter>
</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));
