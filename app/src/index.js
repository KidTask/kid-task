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
import {AdultViewTasks} from "./pages/AdultViewTasks";
import {Home} from "./pages/Home";
import axios from "axios";
import reducer from "./shared/reducers/reducers";
import {Provider} from "react-redux";
import { configureStore } from '@reduxjs/toolkit'


axios.get("/apis/earl-grey/");


const store = configureStore({reducer});

const Routing = () => (

	<>
		<Provider store={store}>

			<BrowserRouter>
				<Switch>
					<Route exact path="/create-task/:kidUsername" component={CreateTask} kidUsername=":kidUsername"/>
					<Route exact path="/adult-dashboard" component={AdultDashboard}/>
					<Route exact path="/kid-dashboard" component={Kid}/>
					<Route exact path="/kid-sign-up/" component={KidSignUp} />
					<Route exact path="/adult-sign-up" component={SignUp}/>
					<Route exact path="/assigned-tasks/:kidUsername" component={AdultViewTasks} kidUsername=":kidUsername"/>
					<Route exact path="/" component={Home}/>

					<Route component={FourOhFour}/>
				</Switch>
			</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));
